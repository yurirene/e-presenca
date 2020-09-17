<?php

ob_start();
session_start();

require_once(__DIR__.'/vendor/autoload.php');

use CoffeeCode\Router\Router;

$router = new Router(site());
$router->namespace("Source\Controllers");

$router->group(null);

$router->get("/", "AppController:index", "app.index");
$router->get("/Login", "AppController:login", "app.login");
$router->get("/Logout", "AppController:logout", "app.logout");
$router->get("/Lista", "AppController:lista", "app.lista");
$router->get("/Sessoes", "AppController:sessoes", "app.sessoes");
$router->get("/Buscar-Delegado/{codigo}", "AppController:buscarDelegado", "app.buscardelegado");

$router->post("/Logar", "AppController:logar", "app.logar");

$router->group("API");
$router->get("/{token}", "APIController:index");
$router->get("/Federacoes/{token}", "APIController:listarFederacoes");
$router->get("/Federacoes/{token}/{id}", "APIController:listarFederacoesById");
$router->get("/Delegados/{token}", "APIController:listarDelegados");
$router->get("/Delegados/{token}/{codigo}", "APIController:buscarDelegadosByCodigo");
$router->get("/Sessoes/{token}", "APIController:listarSessoes");
$router->get("/Sessoes/{token}/{id}", "APIController:listarSessoesById");
$router->get("/Chamada/{token}", "APIController:chamada");


$router->post("/Chamada", "APIController:registrarPresenca");

/**
* ERRO
*/

$router->group("Ops");
$router->get("/{errcode}", "AppController:erro","app.erro");

/**
 * Executa a Rota
 */
$router->dispatch();

/*
 * Redireciona os Erros
 */


if ($router->error()) {

    $router->redirect("Ops/{$router->error()}");
}


ob_end_flush();
