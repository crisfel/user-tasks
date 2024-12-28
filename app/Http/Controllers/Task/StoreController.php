<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(Request $request): JsonResponse|array
    {
        try {
            $title = strval($request->input('title'));

            $description = $request->input('description');

            if (isset($description)) {
                $description = strval($request->input('description'));
            }

            $taskStoredMessage = $this->taskRepository->store($title, $description);
            return response()->json($taskStoredMessage);

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }

    }
}
