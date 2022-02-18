<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\FileManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Nullable;

class PostController extends Controller
{
    /**
     * @var FileManagerService
     */
    private $fileManagerService;

    public function __construct(FileManagerService $fileManagerService){
        $this->fileManagerService = $fileManagerService;
    }


    public function index()
    {
        $skip = \request()->get('skip', 0);
        $take = \request()->get('take', 5);
        $posts = Post::skip($skip)->take($take)->get();
        return PostResource::collection($posts);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $postRequest)
    {
        $post = [
            'title' => $postRequest['title'],
            'src' => '',
            'description' => $postRequest['description'],
            'user_id' => $postRequest['user_id'],
            'approved' => $postRequest['approved'],
        ];
        $storePost = Post::create($post);

        $fileName = $this->fileManagerService->putFile("posts/$storePost->id", $postRequest->file('file'));
        Post::update($storePost->id, ['src' => $fileName]);
        $store = response()->json($storePost);
        if ($storePost) {
            return response()->json(['msg' => 'Row successfully created']);
        }
        return response()->json(['msg' => 'Row failed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(PostResource::collection(Post::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $postRequest, $id)
    {
        $post = Post::where('id', $id)->first();
        $this->fileManagerService->delete($post->src);
//        dd('11111');
        $fileName = $this->fileManagerService->putFile("posts/$post->id", $postRequest->file('file'));
        Post::update($post->id, ['src' => $fileName]);
        $store = response()->json($post);
        if ($post) {
            return response()->json(['msg' => 'Row successfully created']);
        }
        return response()->json(['msg' => 'Row failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Post::find($id)->delete();

        if ($destroy) {
            return response()->json(['msg' => 'Row successfully deleted']);
        }
        return response()->json(['msg' => 'Row failed']);
    }
}
