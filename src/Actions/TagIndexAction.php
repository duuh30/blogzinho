<?php

namespace BLOG\Actions;

use BLOG\Responders\TagIndexResponder;
use BLOG\Domain\Services\TagIndexService;

class TagIndexAction
{
    protected $responder;
    protected $service;

    public function __construct(TagIndexResponder $responder, TagIndexService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke()
    {
        return $this->responder->send($this->service->handle());
    }
}