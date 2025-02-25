<?php

namespace RudyVieira;

class Response
{
    public function sendJson($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }
}