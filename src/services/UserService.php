<?php

require DIR . "/src/database.php";
require DIR . "/src/user/model.php";


class UserService
{
    private PDO $conn;
    private UserModel $user;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getUsers(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->query($sql);
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            unset($row["password"]);
            $data[] = $row;
        }

        return $data;
    }

    public function createUser(array $data): int
    {
        if($this->isUsernameExist($data["username"]))
        {
            throw new Exception("Username already exists");
        }
        if($this->isEmailExist($data["email"]))
        {
            throw new Exception("Email already exists");
        }
        $user = new UserModel();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setEmail($data['email']);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function isEmailExist(string $email): bool
    {
        $user = $this->findUserByEmail($email);
        if(!$user)
        {
            return false;
        }
        return true;
    }

    public function checkPassword(string $username, string $password): bool
    {
        $user = $this->findUserByUsername($username);
        return password_verify($password, $user["password"]);
    }

    public function isUsernameExist(string $username): bool
    {
        $user = $this->findUserByUsername($username);
        if(!$user)
        {
            return false;
        }
        return true;
    }

    public function findUserByUsername(string $username): array | false
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    private function findUserByEmail(string $email): array | false
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    private function findUserById(string $id): array | false
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

}