<?php

namespace BLOG\Actions;

use Psr\Http\Message\ServerRequestInterface;
use BLOG\Responders\LoginResponder;
use BLOG\Domain\Services\LoginService;

class LoginAction
{
    protected $responder;
    protected $service;

    public function __construct(LoginResponder $responder, LoginService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->responder->send($this->service->handle($request));
    }
}