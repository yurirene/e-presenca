<?php

namespace Source\Persistence;

class UsuariosDAO extends DAO 
{
    
    private $path  = "Source\Entity\Usuarios";
    
    public function __construct() {
        parent::__construct($this->path);
    }
    
}
