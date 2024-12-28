<?php

namespace App\Http\Controllers\UserTask;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserTask\UserTaskRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ChangeStatusController extends Controller
{
    protected UserTaskRepositoryInterface $userTaskRepository;

    public function __construct(UserTaskRepositoryInterface $userTaskRepository)
    {
        $this->userTaskRepository = $userTaskRepository;
    }

    public function __invoke(Request $request)
    {
        try {
            $userTaskID = intval($request->input('id'));
            $status = strval($request->input('status'));
            $userTaskChanged = $this->userTaskRepository->changeStatus($userTaskID, $status);

            return response()->json($userTaskChanged);

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
