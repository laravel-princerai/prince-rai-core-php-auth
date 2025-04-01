<?php

namespace CoreAuth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;

class Auth {
    private $db;
    private $secret;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
        $config = require __DIR__ . '/../config/config.php';
        $this->secret = $config['jwt_secret'];
    }

    public function register($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $token = $this->generateToken($user['id'], $user['email']);
            return ['token' => $token, 'user' => $user];
        }
        return false;
    }

    private function generateToken($userId, $email) {
        $payload = [
            'iss' => "localhost",
            'iat' => time(),
            'exp' => time() + (60 * 60), // Token expires in 1 hour
            'sub' => $userId,
            'email' => $email
        ];
        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function verifyToken($token) {
        try {
            return JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
