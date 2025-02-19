<?php

namespace RudyVieira;

use PDO;

class Comment
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getCommentById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createComment($data)
    {
        $stmt = $this->db->prepare("INSERT INTO comments (content, user_id, post_id) VALUES (?, ?, ?)");
        $stmt->execute([$data['content'], $data['user_id'], $data['post_id']]);
        return $this->db->lastInsertId();
    }

    public function deleteComment($id)
    {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}