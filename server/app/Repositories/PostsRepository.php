<?php

namespace App\Repositories;

use App\Interfaces\PostsRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class PostsRepository implements PostsRepositoryInterface
{
    protected $model;

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function getAll()
    {
        return $this->model->where('user_id', Auth::id())->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function create(array $postsDetails)
    {
        return $this->model->create($postsDetails);
    }

    public function update($id, array $newDetails)
    {
        return $this->model->find($id)->update($newDetails);
    }

}
