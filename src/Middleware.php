<?php

namespace CoreAuth;

class Middleware {
    private $auth;

    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function checkAuth() {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }

        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
        if (!$this->auth->verifyToken($token)) {
            http_response_code(401);
            echo json_encode(["error" => "Invalid token"]);
            exit;
        }
    }
}
