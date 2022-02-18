<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersRepository implements UsersRepositoryInterface
{
    protected $model;

    public function __construct(User $user){
        $this->model = $user;
    }


    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function create(array $usersDetails)
    {
        return $this->model->create($usersDetails);
    }

    public function updateById($id, array $newDetails)
    {
        $update = $this->model->find($id)->update($newDetails);
        $roleId = $newDetails['role'];
        if($roleId){
          DB::table('role_user')->insert([
             'user_id' => $id,
             'role_id' => $roleId,
          ]);
        }
        if($roleId == 0){
            DB::table('role_user')->where('user_id',$id)->delete();
        }

        return $update;

    }

}
