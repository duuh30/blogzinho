<?php

namespace BLOG\Responders;

use Psr\Http\Message\ResponseInterface;

class PostsIndexResponder
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function send(array $res)
    {
        return $this->response->withJson($res);
    }
}