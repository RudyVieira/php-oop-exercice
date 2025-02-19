<?php

namespace RudyVieira;

class CommentController extends ApiController
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function show($id)
    {
        $comment = $this->comment->getCommentById($id);
        if ($comment) {
            $this->respondWithJson($comment);
        } else {
            $this->respondWithJson(['error' => 'Comment not found'], 404);
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $this->respondWithJson(['error' => 'Invalid JSON'], 400);
            return;
        }
        $commentId = $this->comment->createComment($data);
        if ($commentId) {
            $this->respondWithJson(['id' => $commentId], 201);
        } else {
            $this->respondWithJson(['error' => 'Failed to create comment'], 500);
        }
    }

    public function destroy($id)
    {
        if ($this->comment->deleteComment($id)) {
            $this->respondWithJson(['message' => 'Comment deleted']);
        } else {
            $this->respondWithJson(['error' => 'Failed to delete comment'], 500);
        }
    }
}