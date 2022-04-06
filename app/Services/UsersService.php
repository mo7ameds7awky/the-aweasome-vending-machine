<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    public function createUser($validatedData)
    {
        return User::create([
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'deposit' => $validatedData['deposit'],
            'userRoleId' => $validatedData['roleName'] === 'seller' ? UserRole::where('roleName', UserRole::ROLES['SELLER'])->first()->id : UserRole::where('roleName', UserRole::ROLES['BUYER'])->first()->id,
        ]);
    }

    public function updateUser(User $user, $validatedData): User
    {
        if (isset($validatedData['username'])){
            $user->username = $validatedData['username'];
        }

        if (isset($validatedData['password'])){
            $user->password = Hash::make($validatedData['password']);
        }

        if (isset($validatedData['deposit'])){
            $user->deposit = $validatedData['deposit'];
        }

        if (isset($validatedData['userRoleId'])){
            $user->userRoleId = $validatedData['userRoleId'];
        }

        $user->save();

        return $user;
    }

    public function userLogin($validatedData): ?User
    {
        $user = User::where('username', $validatedData['username'])->first();
        if (!$user || !Hash::check($validatedData['password'], $user->password)){
            return null;
        }
        Auth::login($user);
        return $user;
    }

    public function userLogout(): bool
    {
        if (Auth::check()){
            Auth::user()->tokens()->delete();
        }
        return true;
    }
}
