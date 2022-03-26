<?php
declare (strict_types = 1);
namespace App\api\auth;

use App\api\users\UserDao;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private $user_dao;

    public function __construct()
    {
        $this->user_dao = new UserDao();
    }

    public function login(string $email, string $password)
    {
        $user = $this->user_dao->get_user_by_email($email);
        if (!$user["email"]) {
            throw new \Exception("User not found");
        }
        if ($user['password'] != $password) {
            throw new \Exception("Invalid password");
        }
        return $this->encode_jwt($user['email'], $user['user_id']);
    }

    public function register(string $full_name, string $email, string $password)
    {
        $user = $this->user_dao->get_user_by_email($email);
        if ($user != null) {
            throw new \Exception("User already exists");
            return;
        }
        $this->user_dao->create_user($full_name, $email, $password);
    }

    private function encode_jwt(string $email, $user_id)
    {
        $plus_60_minutes = time() + (60 * 60);
        $key = getenv('JWT_SECRET');
        $payload = [
            'iss' => getenv('JWT_ISSUER'),
            'aud' => getenv('JWT_AUDIENCE'),
            'iat' => time(),
            'nbf' => time() + $plus_60_minutes,
            'user_id' => $user_id,
            'email' => $email,
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

    public function decode_jwt(string $jwt)
    {
        $key = getenv('JWT_SECRET');
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return (array) $decoded;
    }
}
