<?php

namespace App\UseCases\User;

use App\DTOs\User\StoreUserDTO;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Repositories\Contracts\UserTask\UserTaskRepositoryInterface;
use App\UseCases\Contracts\User\StoreUserUseCaseInterface;
use Exception;

class StoreUserUseCase implements StoreUserUseCaseInterface
{
    protected UserRepositoryInterface $userRepository;
    protected UserTaskRepositoryInterface $userTaskRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                UserTaskRepositoryInterface $userTaskRepository)
    {
        $this->userRepository = $userRepository;
        $this->userTaskRepository = $userTaskRepository;
    }

    public function handle(StoreUserDTO $DTO)
    {
        try {
            $userFound = $this->userRepository->getByEmail($DTO->email);

            if (is_null($userFound)) {
                $userStoredMessage = $this->userRepository->store($DTO);
                $userID = $userStoredMessage['user_id'];

                if (isset($DTO->taskIDs) && isset($userID)) {
                    foreach ($DTO->taskIDs as $taskID) {
                        $this->userTaskRepository->store($userID, $taskID);
                    }

                    return $userStoredMessage;
                }

                $userStoredMessage['message'] = 'user stored without tasks';

                return $userStoredMessage;
            }

            return [
                'status' => 409,
                'message' => 'duplicated email'
            ];

        } catch(Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
