<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index()
    {
        $users = $this->usersRepository->getAll();
        return response()->json(UserResource::collection($users));

    }
    public function show($id) : JsonResponse
    {

        return response()->json(new UserResource($this->usersRepository->getById($id)));

    }

    public function store(UserRequest $userRequest): JsonResponse
    {
        $data = [
            'name' => $userRequest['name'],
            'email' => $userRequest['email'],
            'password' => Hash::make($userRequest['password']),
        ];
        $storeUser = new UserResource($this->usersRepository->create($data));
        $store = response()->json($storeUser);
        if($storeUser){
            return response()->json(['msg' => 'Row successfully created']);
        }
        return response()->json(['msg' => 'Row failed']);
    }

    public function edit($id): JsonResponse
    {
        return response()->json(new UserResource($this->usersRepository->getById($id)));
    }

    public function update(UserRequest $userRequest,$id): JsonResponse
    {
        $updateUser = UserResource::collection($this->usersRepository->updateById($id,$userRequest->all()));
        $update = response()->json($updateUser);
        if($updateUser){
            return response()->json(['msg' => 'Row Successfully updated']);
        }
        return response()->json(['msg' => 'Row Failed']);
    }

    public function destroy($id): JsonResponse
    {
        $destroy = new UserResource($this->usersRepository->delete($id));
        if($destroy) {
            return response()->json(['msg' => 'Row successfully Deleted']);
        }
        return response()->json(['msg' => 'Row failed']);

    }
}
