<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UsersCollectionResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Services\UsersService;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private UsersService $service;

    /**
     * @param UsersService $service
     */
    public function __construct(UsersService $service)
    {
        $this->service = $service;
    }


    public function index(): JsonResponse
    {
        return response()->json(['data' => new UsersCollectionResource(User::with(['userRole'])->paginate(5))], 200);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if ($user = $this->service->createUser($request->validated())) {
                // Create authentication token using sanctum
                $token = $user->createToken('myapptoken')->plainTextToken;
                DB::commit();
                return response()->json(['data' => ['user' => new UsersResource($user), 'token' => $token]], 201);
            }
            DB::rollBack();
            return response()->json([], 500);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(['data' => new UsersResource($user)], 200);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();
        try {
            if ($user = $this->service->updateUser($user, $request->validated())) {
                DB::commit();
                return response()->json(['data' => new UsersResource($user)], 200);
            }
            DB::rollBack();
            return response()->json([], 500);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        DB::beginTransaction();
        try {
            if ($user->delete()) {
                DB::commit();
                return response()->json(['data' => new UsersResource($user)], 200);
            }
            DB::rollBack();
            return response()->json([], 500);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            if ($user = $this->service->userLogin($request->validated())) {
                // Create authentication token using sanctum
                $token = $user->createToken('myapptoken')->plainTextToken;
                DB::commit();
                return response()->json(['data' => ['user' => new UsersResource($user), 'token' => $token]], 200);
            }
            DB::rollBack();
            return response()->json(['message' => 'Invalid credentials.'], 422);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function logout(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->service->userLogout();
            DB::commit();
            return response()->json([], 200);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }
}
