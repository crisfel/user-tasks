<?php

namespace App\Http\Controllers\UserTask;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserTask\UserTaskRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ShowByUserIDController extends Controller
{
    protected UserTaskRepositoryInterface $userTaskRepository;

    public function __construct(UserTaskRepositoryInterface $userTaskRepository)
    {
        $this->userTaskRepository = $userTaskRepository;
    }

    public function __invoke(int $userID)
    {
        try{
            return $this->userTaskRepository->getByUserID($userID);
        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }

    }
}
