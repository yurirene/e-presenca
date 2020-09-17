<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Persistence;

use Source\Entity\Delegados;

/**
 * Description of ChamadaDAO
 *
 * @author Yuri
 */
class ChamadaDAO extends DAO
{
    private $path = 'Source\Entity\Chamada';
    
    function __construct() {
        parent::__construct($this->path);
    }

    
     public function verificaSeEstaRegistradoNaSessao(Delegados $delegado): bool
    {
        
        $sessaoDao = new SessoesDAO();
        $sessao = $sessaoDao->getSessaoAtual($delegado->getFederacao());
        
        $presenca = $this->findBy([
            "delegado"=>$delegado->getId(),
            "sessao"=>$sessao,
            "federacao"=>$delegado->getFederacao()
        ]);
        
        if(count($presenca)>0){
            return false;
        }else{
            
            return true;
        }
        
    }
    
}
