<?php

namespace Source\Persistence;

use Source\Entity\Delegados;

class DelegadosDAO extends DAO {

    private $path = 'Source\Entity\Delegados';
    
    function __construct() {
        parent::__construct($this->path);
    }

    
}
