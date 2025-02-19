<?php

namespace RudyVieira;

class Request
{
    public function getMethod() { return $_SERVER['REQUEST_METHOD']; }
    public function getUri() { return $_SERVER['REQUEST_URI']; }
    public function getBody() { return json_decode(file_get_contents('php://input'), true); }
}