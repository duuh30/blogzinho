<?php

namespace BLOG\Actions;

use Psr\Http\Message\ServerRequestInterface;
use BLOG\Responders\PostsStoreResponder;
use BLOG\Domain\Services\PostsStoreService;

class PostsStoreAction
{
    protected $responder;
    protected $service;

    public function __construct(PostsStoreResponder $responder, PostsStoreService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->responder->send($this->service->handle($request));
    }
}