<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;

class ShowAllController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function __invoke()
    {
        try {
            return $this->taskRepository->getNotDeleted();

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
