<?php

namespace BLOG\Responders;

use Psr\Http\Message\ResponseInterface;
use BLOG\Domain\Messages\ValidationMessage;

class PostsStoreResponder
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function send($response)
    {
        if ($response instanceof ValidationMessage) {
            return $this->response->withJson($response->toArray(), 422);
        }
        return $this->response->withJson($response, 201);
    }
}