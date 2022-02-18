<?php

namespace App\Interfaces;

interface UsersRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    public function create(array $usersDetails);
    public function updateById($id, array $usersDetails);
}
