<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Source\Controllers;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
/**
 * Description of Controller
 *
 * @author Yuri
 */
abstract class Controller {
    
     /** @var Engine */
    protected $view;
    
    /** @var Router */
    protected $router;
    
    public function __construct($router)
    {
        
        $this->router = $router;
        $this->view = new Engine(dirname(__DIR__,2)."/views/templates", "php");
        $this->view->addData(["router"=>$this->router]);
    }
}
