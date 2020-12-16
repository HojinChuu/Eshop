<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($data)
    {
        $sql = "INSERT INTO users (name, email, password) 
                    VALUES (:name, :email, :password)";
        $this->db->query($sql);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        return $this->db->execute() ? true : false;
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(":email", $email);
        $this->db->execute();

        $row = $this->db->single();
        $hashed_password = $row->password;

        return password_verify($password, $hashed_password) ? $row : false;
    }

    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        $this->db->execute();

        return $this->db->rowCount() > 0 ? true : false;
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->execute();

        return $this->db->single();
    }

    public function update($data)
    {
        $sql = "UPDATE users SET name = :name, password = :password WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $data["id"]);
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":password", $data["password"]);

        return $this->db->execute() ? true : false;
    }

    public function charge($id, $money)
    {
        $sql = "UPDATE users SET money = money + :money WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->bind(":money", $money);

        return $this->db->execute() ? true : false;
    }

    public function updateMoney($id, $money)
    {
        $sql = "UPDATE users SET money = :money WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->bind(":money", $money);

        return $this->db->execute() ? true : false;
    }

    public function refundMoney($user_id, $price)
    {
        $sql = "UPDATE users SET money = money + :price WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":price", $price);
        $this->db->bind(":id", $user_id);

        return $this->db->execute() ? true : false;
    }

    // ADMIN
    public function getUsers()
    {
        $sql = "SELECT * FROM users";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->resultSet();
    }

    // ADMIN
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }
}