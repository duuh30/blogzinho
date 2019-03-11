<?php

namespace BLOG\Actions;

use Psr\Http\Message\ServerRequestInterface;
use BLOG\Responders\UserStoreResponder;
use BLOG\Domain\Services\UserStoreService;

class UserStoreAction
{
    protected $responder;
    protected $service;

    public function __construct(UserStoreResponder $responder, UserStoreService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->responder->send($this->service->handle($request));
    }
}