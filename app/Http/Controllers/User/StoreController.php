<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\StoreUserDTO;
use App\Http\Controllers\Controller;
use App\UseCases\Contracts\User\StoreUserUseCaseInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    protected StoreUserUseCaseInterface $storeUserUseCase;

    public function __construct(StoreUserUseCaseInterface $storeUserUseCase)
    {
        $this->storeUserUseCase = $storeUserUseCase;
    }

    public function __invoke(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
               'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
                'taskIDs' => 'nullable|array'
            ]);

            if ($validation->fails()) {
                return $validation->errors();
            }

            $name = strval($request->input('name'));
            $email = strval($request->input('email'));
            $password = Hash::make($request->input('password'));
            $taskIDs = null;

            if (isset($request->taskIDs)) {
                $taskIDs = array_map([$this, 'parseInt'], (array) $request->taskIDs);;
            }

            $storeUserDTO = new StoreUserDTO($name, $email, $password, $taskIDs);
            $userStoredMessage = $this->storeUserUseCase->handle($storeUserDTO);

            return response()->json($userStoredMessage);

        } catch(Exception $e) {

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
