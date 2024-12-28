<?php

namespace App\Repositories\UserTask;

use App\Models\User;
use App\Models\UserTask;
use App\Repositories\Contracts\UserTask\UserTaskRepositoryInterface;
use Exception;

class UserTaskRepository implements UserTaskRepositoryInterface
{
    public function store(int $userID, int $taskID)
    {
        try{
            $userTask = new UserTask();
            $userTask->user_id = $userID;
            $userTask->task_id = $taskID;
            $userTask->save();

            return [
                'status' => 200,
                'user_task_id' => $userTask->id,
                'message' => 'user task stored',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function delete(UserTask $userTask)
    {
        try{
            $userTask->delete();

            return [
                'status' => 200,
                'message' => 'user task deleted',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function getByUserID(int $id)
    {
        try{
            return UserTask::with('user', 'task')->where('user_id', $id)->get();

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function getByID(int $id)
    {
        try{
            return UserTask::find($id);
        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function changeStatus(int $id, string $status)
    {
        try{
            $userTask = $this->getByID($id);
            $userTask->status = $status;
            $userTask->save();

            return [
                'status' => 200,
                'user_task_status' => $userTask->status,
                'message' => 'user task status changed'
            ];
        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
