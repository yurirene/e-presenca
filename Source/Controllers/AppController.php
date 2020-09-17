<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Controllers;

use Firebase\JWT\JWT;
use Source\Persistence\UsuariosDAO;
use function flash;


/**
 * Description of AppController
 *
 * @author Yuri
 */
class AppController extends Controller 
{
    
    private $key = "v38xkHThwpTN";
    
    public function __construct($router) 
    {
        parent::__construct($router);
    }
    
    private function acesso():void 
    {
        
        if(!$_SESSION['token'] || empty($_SESSION['token'] )){
            flash("danger", "Faça o Login");
            $this->router->redirect("app.logout");
            return;
        }
        $token = $_SESSION['token'];
        $partes = explode(".", $token);
        $assinatura = JWT::urlsafeB64Encode(hash_hmac('sha256', $partes[0].".".$partes[1],$this->key, true));
        if($assinatura != $partes[2]){
            flash("danger", "Acesso negado");            
            $this->router->redirect("app.logout");
            return;
        }
        
        
        
    }
    
    public function logar($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        
        if(empty($data['usuario']) || empty($data['senha'])){
            flash("danger", "Preencha todos os dados");            
            $this->router->redirect("app.login");
            return;
        }
        
        $dao = new UsuariosDAO();
        $usuario = $dao->findOneBy(["usuario"=>$data['usuario']]);
        if(!$usuario){
            flash("danger", "Usuário ou Senha inválidos");            
            $this->router->redirect("app.login");
            return;
        }
        $senha = sha1($data['senha']);
        if($usuario->getSenha() != $senha){
            flash("danger", "Usuário ou Senha inválidos");            
            $this->router->redirect("app.login");
            return;
        }
        
        $payload = array(
            "federacao"=>$usuario->getFederacao()
        );
        
        $jwt = JWT::encode($payload, $this->key);
        
        $_SESSION['token'] = $jwt;
        
        echo $this->router->redirect("app.index");
        return;
        
    }
    
    public function logout(): void
    {
        unset($_SESSION['token']);
        $this->router->redirect("app.login");
        return;
    }
    
    public function index(): void
    {
        $this->acesso();
        
        echo $this->view->render("index");
        return;  
    }
    
    public function login(): void {
        
        if(isset($_SESSION['token'])){
            $this->router->redirect("app.index");
            return;
        }
        echo $this->view->render("login");
        return;  
        
        
    }
    
    public function lista(): void
    {
        
        echo $this->view->render("lista");
        return;   
    }
    
    public function erro($dados): void
    {
        $erro = filter_var_array($dados, FILTER_VALIDATE_INT);
        echo ('erro');
        //echo $this->view->render("site/erro", ["erro"=>$erro["errcode"], "title"=>"Ooops!"]);
        return;
        
    }
    
}
