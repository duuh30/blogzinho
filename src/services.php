<?php

use Valitron\Validator;
use BLOG\Actions\PostsIndexAction;
use BLOG\Actions\PostsStoreAction;
use BLOG\Actions\UserStoreAction;
use BLOG\Actions\TagStoreAction;
use BLOG\Actions\TagIndexAction;
use BLOG\Actions\LoginAction;


use BLOG\Responders\PostsIndexResponder;
use BLOG\Responders\PostsStoreResponder;
use BLOG\Responders\UserStoreResponder;
use BLOG\Responders\TagStoreResponder;
use BLOG\Responders\TagIndexResponder;
use BLOG\Responders\LoginResponder;

use BLOG\Domain\Services\PostsIndexService;
use BLOG\Domain\Services\PostsStoreService;
use BLOG\Domain\Services\UserStoreService;
use BLOG\Domain\Services\TagStoreService;
use BLOG\Domain\Services\TagIndexService;
use BLOG\Domain\Services\LoginService;

$container[PostsIndexAction::class] = function ($container) {
    return new PostsIndexAction(
        new PostsIndexResponder($container->response),
        new PostsIndexService($container->entityManager)
    );
};

$container[PostsStoreAction::class] = function ($container) {
    return new PostsStoreAction(
        new PostsStoreResponder($container->response),
        new PostsStoreService($container->entityManager, new Validator())
    );
};

$container[UserStoreAction::class] = function ($container) {
    return new UserStoreAction(
        new UserStoreResponder($container->response),
        new UserStoreService($container->entityManager, new Validator())
    );
};

$container[TagStoreAction::class] = function ($container) {
    return new TagStoreAction(
        new TagStoreResponder($container->response),
        new TagStoreService($container->entityManager, new Validator())
    );
};

$container[TagIndexAction::class] = function ($container) {
    return new TagIndexAction(
        new TagIndexResponder($container->response),
        new TagIndexService($container->entityManager, new Validator())
    );
};

$container[LoginAction::class] = function ($container) {
    return new LoginAction(
        new LoginResponder($container->response),
        new LoginService($container->entityManager, new Validator())
    );
};
