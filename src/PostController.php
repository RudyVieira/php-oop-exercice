<?php

namespace RudyVieira;

class PostController extends ApiController
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function show($id)
    {
        $post = $this->post->getPostById($id);
        if ($post) {
            $this->respondWithJson($post);
        } else {
            $this->respondWithJson(['error' => 'Post not found'], 404);
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $this->respondWithJson(['error' => 'Invalid JSON'], 400);
            return;
        }
        $postId = $this->post->createPost($data);
        if ($postId) {
            $this->respondWithJson(['id' => $postId], 201);
        } else {
            $this->respondWithJson(['error' => 'Failed to create post'], 500);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $this->respondWithJson(['error' => 'Invalid JSON'], 400);
            return;
        }
        if ($this->post->updatePost($id, $data)) {
            $this->respondWithJson(['message' => 'Post updated']);
        } else {
            $this->respondWithJson(['error' => 'Failed to update post'], 500);
        }
    }

    public function destroy($id)
    {
        if ($this->post->deletePost($id)) {
            $this->respondWithJson(['message' => 'Post deleted']);
        } else {
            $this->respondWithJson(['error' => 'Failed to delete post'], 500);
        }
    }
}