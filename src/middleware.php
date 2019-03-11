<?php
// Application middleware

//$app->add(new \Slim\Csrf\Guard);

use Tuupola\Middleware\CorsMiddleware;

$app->add(
    new CorsMiddleware(
        [
            "logger"         => $container["logger"],
            "origin"         => ["*"],
            "methods"        => [
                "GET",
                "POST",
                "PUT",
                "PATCH",
                "DELETE",
                "OPTIONS",
            ],
            "headers.allow"  => [
                "Authorization",
                "If-Match",
                "If-Unmodified-Since",
                "Content-Type",
                "Accept",
                "Origin",
            ],
            "headers.expose" => [
                "Authorization",
                "Etag",
            ],
            "credentials"    => false,
            "cache"          => 0,
        ]
    )
);

$app->add(
    new Tuupola\Middleware\JwtAuthentication(
        [
            "path"   => [
            "/posts",
            "/tags",
        ],
            "header" => "Authorization",
            "regexp" => "/(.*)/",
            "secret" => $_ENV['KEY_JWT'],
        ]
        )
    );
