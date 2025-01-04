<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

interface UserServiceInterface
{
    public function getAllUsers(): \Illuminate\Support\Collection;

    public function findUserById(int $id): ?User;

    public function createUser(array $data): User;

    public function updateUser(int $user, array $data): User;

    public function deleteUser(User $user): bool;
}
