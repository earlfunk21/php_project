<?php

declare(strict_types=1);

namespace App\Models;

use App\Lib\Database;
use \PDO;
use App\Lib\Response;
use App\Lib\Session;

class UserModel
{
    private string $username;
    private string $email;
    private string $password;
    private $conn;

    public function __construct(){
        $this->conn = Database::connect();
    }

    public function setUsername(string $username): void
    {
        if(preg_match('/[^a-z0-9_]+/i', $username))
        {
            throw new Exception("Username must be alphanumeric", 1);
        }

        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
        {
            throw new Exception("$email is not valid email address", 1);
            
        }
        $this->email = $email;
    } 

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
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

    public function createUser(array $data)
    {
        if($this->isUsernameExist($data["username"]))
        {
            Session::message("Username already exists", "error");
            Response::redirect("/create");
            die();
        }
        if($this->isEmailExist($data["email"]))
        {
            Session::message("Email already exists", "error");
            Response::redirect("/create");
            die();
        }
        
        $this->setUsername($data['username']);
        $this->setPassword($data['password']);
        $this->setEmail($data['email']);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $this->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->getPassword(), PDO::PARAM_STR);
        $stmt->execute();
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