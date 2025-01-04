<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseWrapper;
use App\Http\Requests\Api\Task\StoreTaskRequest;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\UserServiceInterface;

class UserController
{


    public function __construct(private UserServiceInterface $userService, private ResponseWrapper $responseWrapper)
    {
    }

    public function index()
    {
        return $this->responseWrapper
            ->setData($this->userService->getAllUsers())
            ->setResource(UserResource::class)
            ->setStatus(200)
            ->generateCollectionResponse();

    }


    public function show($id)
    {
        return $this->responseWrapper->setData($this->userService->findUserById($id))
            ->setResource(TaskResource::class)
            ->setStatus(200)
            ->generateSingleResponse();
    }

    public function edit($id, UpdateUserRequest $request)
    {
        return $this->responseWrapper->setData($this->userService->updateUser($id,$request->validated()))
            ->setResource(UserResource::class)->generateSingleResponse();
    }
}
