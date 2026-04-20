<?php
use Slim\Factory\AppFactory;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/test', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Test page");
    return $response;
});


$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id}', "AlunniController:show");
$app->post('/alunni', "AlunniController:create");
$app->put('/alunni/{id}', "AlunniController:update");
$app->delete('/alunni/{id}', "AlunniController:destroy");

$app->get('/certificazioni', "CertificazioniController:index");
$app->get('/certificazioni/{id}', "CertificazioniController:show");
$app->post('/certificazioni', "CertificazioniController:create");
$app->put('/certificazioni/{id}', "CertificazioniController:update");
$app->delete('/certificazioni/{id}', "CertificazioniController:destroy");

$app->get('/alunni/{alunno_id}/certificazioni', "CertificazioniRefController:index");
$app->get('/alunni/{alunno_id}/certificazioni/{id}', "CertificazioniRefController:show");
$app->post('/alunni/{alunno_id}/certificazioni', "CertificazioniRefController:create");
$app->put('/alunni/{alunno_id}/certificazioni/{id}', "CertificazioniRefController:update");
$app->delete('/alunni/{alunno_id}/certificazioni/{id}', "CertificazioniRefController:destroy");

$app->run();
