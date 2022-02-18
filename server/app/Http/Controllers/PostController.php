<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\PostsRepositoryInterface;
use App\Models\Post;
use App\Models\User;
use App\Notifications\StatusUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\FileManagerService;

class PostController extends Controller
{


    private PostsRepositoryInterface $postsRepository;
    /**
     * @var FileManagerService
     */
    private $fileManagerService;


    public function __construct(PostsRepositoryInterface $postsRepository, FileManagerService $fileManagerService)
    {
        $this->postsRepository = $postsRepository;
        $this->fileManagerService = $fileManagerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $skip = \request()->get('skip', 0);
        $take = \request()->get('take', 5);
        $posts = $this->postsRepository->getAll()->where('approved',true)->skip($skip)->take($take);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $postRequest): JsonResponse
    {
        $post = [
            'title' => $postRequest['title'],
            'src' => '',
            'description' => $postRequest['description'],
            'user_id' => Auth::id(),
        ];

        $storePost = $this->postsRepository->create($post);
//        Storage::disk('public')->putFile("posts/$post->id", $postRequest->file('file'));
        $fileName = $this->fileManagerService->putFile("posts/$storePost->id", $postRequest->file('file'));
        $this->postsRepository->update($storePost->id, ['src' => $fileName]);
        $store = response()->json($storePost);
        if($storePost){
            $administrators = User::whereHas('roles',function($q){
                $q->where('name','admin');
            });
            foreach($administrators as $administrator){
                $administrator->notify(new StatusUpdate($storePost));
            }
            return response()->json(['msg' => 'Coming soon Admin is approve your post']);
        }
        return response()->json(['msg' => 'Row failed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        return response()->json(new PostResource($this->postsRepository->getById($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        return response()->json(PostResource::collection($this->postsRepository->getById($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,PostRequest $postRequest): JsonResponse
    {

        $post = Post::find($id);
        $this->fileManagerService->delete($post->src);

        $this->postsRepository->update($id,$postRequest->all());
        $post = $this->postsRepository->getById($id);
        $updatePost = new PostResource($post);
        $administrators = User::whereHas('roles',function($q){
            $q->where('name','admin');
        })->get();
        Log::info('$administrators', [$administrators]);
        foreach($administrators as $administrator){
            $administrator->notify(new StatusUpdate($post));
        }
        $update = response()->json($updatePost);
        if ($updatePost) {return response()->json(['msg' => 'Row Successfully updated']);
        }

        return response()->json(['msg' => 'Row Failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $destroy = new PostResource($this->postsRepository->delete($id));
        if($destroy) {
            return response()->json(['msg' => 'Row successfully Deleted']);
        }
        return response()->json(['msg' => 'Row failed']);
    }



}




