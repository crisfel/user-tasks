<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }



    public function __invoke(Request $request)
    {
        try {
            $id = intval($request->input('id'));
            $title = strval($request->input('title'));

            $taskUpdatedMessage = $this->taskRepository->update($id, $title);
            return response()->json($taskUpdatedMessage);

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
