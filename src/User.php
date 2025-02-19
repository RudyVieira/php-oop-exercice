<?php

namespace RudyVieira;

use PDO;

class User
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['email'], $data['password']]);
        return $this->db->lastInsertId();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['email'], $data['password'], $id]);
        return $stmt->rowCount();
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}