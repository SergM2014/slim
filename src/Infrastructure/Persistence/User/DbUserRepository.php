<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\UserRepository;
use App\Infrastructure\Db\DB;
use App\Domain\User\User;

class DbUserRepository implements UserRepository
{
    public function store(array $data): void
    {    
        $email = $data["email"];
        $name = $data["name"];
        
        $password = password_hash($data["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

        try {
            $db = new Db();
            $conn = $db->connect();
        
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();

            $db = null;
        } catch (\PDOException $e) {
       
            echo $e->getMessage(); die();
        }
    }

    public function getVerifiedUser(array $data): bool|User
    {
        $email = $data['email'];
        $password = $data['password'];

        $query = 'SELECT * FROM users WHERE (email = :email)';
        $values = [':email' => $email];

        try
        {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($query);
            
            $result = $stmt->execute($values);
            }
            catch (\PDOException $e) {
                echo $e->getMessage(); die();
            }

            $res = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (is_array($res) AND password_verify($password, $res['password']))
            {

              return (new User($res['id'], $res['name'], $res['email'], $res['password']));
            }
            
            return false;
    }

    public function checkUniqueEmail(string $email): bool
    {
        $query = 'SELECT * FROM users WHERE (email = :email)';
        $values = [':email' => $email];

        try
        {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->prepare($query);
            
            $stmt->execute($values);
            }
            catch (\PDOException $e) {
                echo $e->getMessage(); die();
            }
            $email = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($email) return false;

            return true;
    }

    public function setResetToken($data): string
    {
        $email = $data['email'];

         $resetToken =  openssl_random_pseudo_bytes(16);
         $resetToken = bin2hex($resetToken);

        $sql = 'UPDATE users SET reset_token = :reset_token, reset_timestamp = UNIX_TIMESTAMP() WHERE email = :email';

        try {
            $db = new Db();
            $conn = $db->connect();
        
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':reset_token', $resetToken);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $db = null;

            return $resetToken;
            
        } catch (\PDOException $e) {
       
            echo $e->getMessage(); die();
        }
    }

    public function getCredentials(string $token): bool|array
    {
        $query = 'SELECT * FROM users WHERE (reset_token = :token)';
        $values = [':token' => $token];

        try
            {
                $db = new Db();
                $conn = $db->connect();
                $stmt = $conn->prepare($query);
                
                $stmt->execute($values);
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                echo $e->getMessage(); die();
            }    
        return $result;
    }

    public function changePassword(array $data): void
    {
        $password = password_hash($data["password"], PASSWORD_DEFAULT);

        $sql = 'UPDATE users SET  password = :password WHERE email = :email';

        try {
            $db = new Db();
            $conn = $db->connect();
        
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            
            $stmt->execute();

            $db = null;
            
        } catch (\PDOException $e) {
       
            echo $e->getMessage(); die();
        }
    }
       
    public function getUsers(): array
    {
        $query = 'SELECT * FROM users';
        
        try
            {
                $db = new Db();
                $conn = $db->connect();
                $stmt = $conn->prepare($query);
                
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                echo $e->getMessage(); die();
            }   
        return $result;
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM users WHERE id = :id';

        try {
            $db = new Db();
            $conn = $db->connect();
        
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $db = null;
            
        } catch (\PDOException $e) {
       
            echo $e->getMessage(); die();
        }

        return true;
    }  
}