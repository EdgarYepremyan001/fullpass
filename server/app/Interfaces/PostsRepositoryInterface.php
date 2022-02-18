<?php

namespace App\Interfaces;

interface PostsRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    public function create(array $postsDetails);
    public function update($id, array $newDetails);
}
