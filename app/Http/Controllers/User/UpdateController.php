<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\UseCases\Contracts\User\UpdateUserUseCaseInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
    protected UpdateUserUseCaseInterface $updateUserUseCase;

    public function __construct(UpdateUserUseCaseInterface $updateUserUseCase)
    {
        $this->updateUserUseCase = $updateUserUseCase;
    }


    public function __invoke(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'id' => 'required|integer',
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'nullable|string',
                'taskIDs' => 'nullable|array'
            ]);

            if ($validation->fails()) {
                return $validation->errors();
            }

            $id = intval($request->input('id'));
            $name = strval($request->input('name'));
            $email = strval($request->input('email'));
            $password = $request->input('password');

            if (isset($password)) {
                $password = Hash::make($request->input('password'));
            }

            $taskIDs = null;

            if (isset($request->taskIDs)) {
                $taskIDs = array_map([$this, 'parseInt'], (array)$request->taskIDs);;
            }

            $updateUserDTO = new UpdateUserDTO($id, $name, $email, $password, $taskIDs);
            $userUpdatedMessage = $this->updateUserUseCase->handle($updateUserDTO);

            return response()->json($userUpdatedMessage);

        } catch (Exception $e) {

            return [
                'status' => 500,
                'message' => 'ERROR: ' . $e->getMessage()
            ];
        }
    }

    public function parseInt(string $id): int
    {
        return intval($id);
    }
}
