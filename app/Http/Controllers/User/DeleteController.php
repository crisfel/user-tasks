<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(int $id)
    {
        try {
            $userDeletedMessage = $this->userRepository->delete($id);

            return response()->json($userDeletedMessage);

        } catch(Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
