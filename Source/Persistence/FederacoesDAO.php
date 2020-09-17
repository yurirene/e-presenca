<?php

namespace Source\Persistence;

class FederacoesDAO extends DAO
{
    
    private $path  = "Source\Entity\Federacoes";
    
    public function __construct() {
        parent::__construct($this->path);
    }
    
}
