<?php

namespace App\Repositories\Contracts\UserTask;

use App\Models\UserTask;

interface UserTaskRepositoryInterface
{
    public function store(int $userID, int $taskID);
    public function delete(UserTask $userTask);
    public function getByUserID(int $id);
    public function getByID(int $id);
    public function changeStatus(int $id, string $status);
}
