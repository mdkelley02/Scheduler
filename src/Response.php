<?php
declare (strict_types = 1);
namespace App;

class Response
{
    public function __construct($header, $message, $data = null, $status = 200)
    {
        $this->header = $header;
        $this->message = $message;
        $this->data = $data;
        $this->status = $status;
    }

    public function send()
    {
        http_response_code($this->status);
        header($this->header);
        echo json_encode(["message" => $this->message, "data" => $this->data]);
    }
}
