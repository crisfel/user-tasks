<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ShowByIDController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(int $id)
    {
        try {
            return $this->userRepository->getByID($id);

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }


    }
}
