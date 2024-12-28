<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class ShowAllController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        try {
            return $this->userRepository->getNotDeleted();

        } catch(Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
