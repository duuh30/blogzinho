<?php

namespace BLOG\Responders;

use Psr\Http\Message\ResponseInterface;

class TagIndexResponder
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function send($res)
    {
        return $this->response->withJson($res);
    }
}