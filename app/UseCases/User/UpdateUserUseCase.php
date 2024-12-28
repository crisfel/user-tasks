<?php

namespace App\UseCases\User;

use App\DTOs\User\UpdateUserDTO;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Repositories\Contracts\UserTask\UserTaskRepositoryInterface;
use App\UseCases\Contracts\User\UpdateUserUseCaseInterface;
use Exception;

class UpdateUserUseCase implements UpdateUserUseCaseInterface
{
    protected UserRepositoryInterface $userRepository;
    protected UserTaskRepositoryInterface $userTaskRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                UserTaskRepositoryInterface $userTaskRepository)
    {
        $this->userRepository = $userRepository;
        $this->userTaskRepository = $userTaskRepository;
    }

    public function handle(UpdateUserDTO $DTO)
    {
        try {
                $userUpdatedMessage = $this->userRepository->update($DTO);

                $userID = $userUpdatedMessage['user_id'];

                if (isset($DTO->taskIDs) && isset($userID)) {
                    $userTasks = $this->userTaskRepository->getByUserID($userID);

                    foreach ($userTasks as $userTask) {
                        $this->userTaskRepository->delete($userTask);
                    }

                    foreach ($DTO->taskIDs as $taskID) {
                        $this->userTaskRepository->store($userID, $taskID);
                    }

                    return $userUpdatedMessage;
                }

                $userUpdatedMessage['message'] = 'user updated without tasks';

                return $userUpdatedMessage;

        } catch(Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }



    }
}
