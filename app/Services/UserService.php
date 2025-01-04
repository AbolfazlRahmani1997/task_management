<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    public function findUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data): User
    {
        $user = $this->userRepository->create($data);

        Log::info('User created', ['user_id' => $user->id]);

        return $user;
    }

    public function updateUser(int $user, array $data): User
    {
        $user = $this->userRepository->findById($user);
        $user = $this->userRepository->update($user, $data);

        Log::info('User updated', ['user_id' => $user->id]);

        return $user;
    }

    public function deleteUser(User $user): bool
    {
        $result = $this->userRepository->delete($user);

        if ($result) {
            Log::info('User deleted', ['user_id' => $user->id]);
        }

        return $result;
    }
}
