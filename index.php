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
$router->get("/Delegados", "AppController:delegados", "app.delegados");
$router->get("/Igrejas", "AppController:igrejas", "app.igrejas");

$router->post("/Logar", "AppController:logar", "app.logar");

$router->group("API");
$router->get("/{token}", "APIController:index");
$router->get("/Federacoes/{token}", "APIController:listarFederacoes");
$router->get("/Federacoes/{token}/{id}", "APIController:listarFederacoesById");
$router->get("/Delegados/{token}", "APIController:listarDelegados");
$router->get("/Delegados/{token}/{codigo}", "APIController:buscarDelegadosByCodigo");
$router->get("/Sessoes/{token}", "APIController:listarSessoes");
$router->get("/Sessoes/{token}/{id}", "APIController:listarSessoesById");
$router->get("/Chamada/{token}", "APIController:listarChamada");
$router->get("/Igrejas/{token}", "APIController:listarIgrejas");
$router->get("/Erro", "APIController:erro", "api.error");

$router->post("/Chamada", "APIController:registrarPresenca");
$router->post("/Sessoes", "APIController:novaSessao");
$router->post("/Igrejas", "APIController:novaIgreja");
$router->post("/Delegados", "APIController:novoDelegado");

$router->delete("/Sessoes/{token}/{id}", "APIController:apagarSessao");
$router->delete("/Igrejas/{token}/{id}", "APIController:apagarIgreja");
$router->delete("/Delegados/{token}/{id}", "APIController:apagarDelegado");

$router->put("/Igrejas", "APIController:atualizarIgreja");
$router->put("/Delegados", "APIController:atualizarDelegado");
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
