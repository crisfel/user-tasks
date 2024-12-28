<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }


    public function __invoke(int $id)
    {
        try {
            $this->taskRepository->delete($id);
        } catch (Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
