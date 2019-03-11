<?php

namespace BLOG\Actions;

use BLOG\Responders\PostsIndexResponder;
use BLOG\Domain\Services\PostsIndexService;

class PostsIndexAction
{
    protected $responder;
    protected $service;

    public function __construct(PostsIndexResponder $responder, PostsIndexService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke()
    {
        return $this->responder->send($this->service->handle());
    }
}