<?php

namespace RudyVieira;

class UserController extends ApiController
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->getUserById($id);
        if ($user) {
            $this->respondWithJson($user);
        } else {
            $this->respondWithJson(['error' => 'User not found'], 404);
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $this->respondWithJson(['error' => 'Invalid JSON'], 400);
            return;
        }
        $userId = $this->user->createUser($data);
        if ($userId) {
            $this->respondWithJson(['id' => $userId], 201);
        } else {
            $this->respondWithJson(['error' => 'Failed to create user'], 500);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $this->respondWithJson(['error' => 'Invalid JSON'], 400);
            return;
        }
        if ($this->user->updateUser($id, $data)) {
            $this->respondWithJson(['message' => 'User updated']);
        } else {
            $this->respondWithJson(['error' => 'Failed to update user'], 500);
        }
    }

    public function destroy($id)
    {
        if ($this->user->deleteUser($id)) {
            $this->respondWithJson(['message' => 'User deleted']);
        } else {
            $this->respondWithJson(['error' => 'Failed to delete user'], 500);
        }
    }
}