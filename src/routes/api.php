<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\PhpRenderer;



$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/mock-data', function (Request $request, Response $response) {
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'id' => $i + 1,
                'name' => 'Name ' . ($i + 1),
                'email' => 'name' . ($i + 1) . '@example.com'
            ];
        }


        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $group->post('/mock-data', function (Request $request, Response $response) {
        $data = $request->getParsedBody();

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $group->put('/mock-data/{id}', function (Request $request, Response $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

        $response->getBody()->write(json_encode(['id' => $id, 'data' => $data]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $group->delete('/mock-data/{id}', function (Request $request, Response $response, $args) {
        $id = $args['id'];

        $response->getBody()->write(json_encode(['id' => $id, 'message' => 'Data deleted']));
        return $response->withHeader('Content-Type', 'application/json');
    });
});


$app->get('/', function (Request $request, Response $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../../templates');
    $viewData = [
        'name' => 'LSR',
        'email' => 'siriforever.ltd@gmail.com'
    ];
    return $renderer->render($response, 'index.php', $viewData);
});
