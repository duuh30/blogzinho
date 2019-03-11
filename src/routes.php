<?php

use BLOG\Actions\PostsIndexAction;
use BLOG\Actions\PostsStoreAction;
use BLOG\Actions\UserStoreAction;
use BLOG\Actions\TagStoreAction;
use BLOG\Actions\TagIndexAction;
use BLOG\Actions\LoginAction;
// Routes
$app->get('/posts', PostsIndexAction::class);
$app->post('/posts', PostsStoreAction::class);
$app->post('/users', UserStoreAction::class);
$app->post('/tags',TagStoreAction::class);
$app->get('/tags',TagIndexAction::class);
$app->post('/login',LoginAction::class);
