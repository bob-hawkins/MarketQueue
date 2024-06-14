<?php

use Ramsey\Uuid\Uuid;

class User {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function doesUserExist($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(":email", $email);
        // $result = $this->userModel->execute();
        $result = $this->db->single();
        return $this->db->rowCount() == 0 ? false : true;
    }

    public function notifications($id) {
    
        $this->db->query("SELECT * FROM notifications WHERE user_id = :id");
        $this->db->bind(":id", $id);
            // $result = $this->userModel->execute();
        $result = $this->db->fetchAll();
        return $result;
    }

    public function setResetToken($token, $email) {
        $this->db->query("UPDATE users SET token = :token WHERE email = :email");
        $this->db->bind(":email", $email);
        $this->db->bind(":token", $token);

        $this->db->execute();
    }

    public function setPassword($password, $email) {
        $this->db->query("UPDATE users SET password = :password WHERE email = :email");
        $this->db->bind(":email", $email);
        $this->db->bind(":password", $password);

        $this->db->execute();
    }

    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(":email", $email);
            // $result = $this->userModel->execute();
        $result = $this->db->single();
        return $result;
    }

    public function findUserByToken($token) {
        $this->db->query("SELECT * FROM users WHERE token = :token");
        $this->db->bind(":token", $token);
            // $result = $this->userModel->execute();
        $result = $this->db->single();
        return $result;
    }

    public function createUser($data) {
        $id = Uuid::uuid4()->toString();
        $password = password_hash($data["password"], PASSWORD_ARGON2I);
        $this->db->query("INSERT INTO users (id, username, email, password) VALUES (:id, :name, :email, :password)");
        $this->db->bind(":id", $id);
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":password", $password);

        $this->db->execute();

    }
}