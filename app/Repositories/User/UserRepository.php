<?php

namespace App\Repositories\User;

use App\DTOs\User\StoreUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function store(StoreUserDTO $DTO): array
    {
        try {
            $user = new User();
            $user->name = $DTO->name;
            $user->email = $DTO->email;
            $user->password = $DTO->password;
            $user->save();

            return [
                'status' => 200,
                'user_id' => $user->id,
                'message' => 'user stored',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function update(UpdateUserDTO $DTO): array
    {
        try {
            $user = User::find($DTO->id);
            $user->name = $DTO->name;
            $user->email = $DTO->email;

            if (isset($DTO->password)) {
                $user->password = $DTO->password;
            }

            $user->save();

            return [
                'status' => 200,
                'user_id' => $user->id,
                'message' => 'user updated',
            ];

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function getByID(int $id)
    {
        try {
            return User::find($id);

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }

    }

    public function getByEmail(string $email)
    {
        try {
            return User::where('email', $email)->first();

        } catch(Exception $e) {
            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function delete(int $id)
    {
        try {
            $user = $this->getByID($id);
            $user->is_deleted = 1;
            $user->save();

            return [
                'status' => 200,
                'user_id' => $user->id,
                'message' => 'user deleted',
            ];

        } catch(Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function getNotDeleted()
    {
        try {
            return User::where('is_deleted', 0)->orderBy('created_at', 'desc')->get();

        } catch(Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }
}
