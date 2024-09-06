<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require '../vendor/autoload.php';


$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

AppFactory::setResponseFactory($psr17Factory);
$app = AppFactory::create();


require_once __DIR__ . '/routes/api.php';

$serverRequest = $creator->fromGlobals();


$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Run app
$app->run($serverRequest);
