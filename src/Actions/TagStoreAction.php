<?php

namespace BLOG\Actions;

use Psr\Http\Message\ServerRequestInterface;
use BLOG\Responders\TagStoreResponder;
use BLOG\Domain\Services\TagStoreService;

class TagStoreAction
{
    protected $responder;
    protected $service;

    public function __construct(TagStoreResponder $responder, TagStoreService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->responder->send($this->service->handle($request));
    }
}