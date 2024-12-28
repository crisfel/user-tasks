<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use Exception;

class TaskRepository implements TaskRepositoryInterface
{
    public function store(string $title, ?string $detail): array
    {
        try {
            $task = new Task();
            $task->title = $title;
            $task->detail = $detail;
            $task->save();

            return [
                'status' => 200,
                'task_id' => $task->id,
                'message' => 'task stored',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function update(int $id, string $title): array
    {
        try {
            $task = Task::find($id);
            $task->title = $title;
            $task->save();

            return [
                'status' => 200,
                'task_id' => $task->id,
                'message' => 'task updated',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function getByID(int $id): array
    {
        try {
            return Task::find($id);

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function getNotDeleted()
    {
        try {
            return Task::where('is_deleted', 0)->orderBy('created_at', 'desc')->get();

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function delete(int $id)
    {
        try {
            $task = Task::find($id);
            $task->is_deleted = 1;
            $task->save();

            return [
                'status' => 200,
                'task_id' => $task->id,
                'message' => 'task deleted',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }



}
