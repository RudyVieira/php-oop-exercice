<?php

namespace RudyVieira;

use PDO;

class Post
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getPostById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPost($data)
    {
        $stmt = $this->db->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$data['title'], $data['content'], $data['user_id']]);
        return $this->db->lastInsertId();
    }

    public function updatePost($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE posts SET title = ?, content = ?, user_id = ? WHERE id = ?");
        $stmt->execute([$data['title'], $data['content'], $data['user_id'], $id]);
        return $stmt->rowCount();
    }

    public function deletePost($id)
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}