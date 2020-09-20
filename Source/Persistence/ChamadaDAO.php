<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Persistence;

use Source\Entity\Chamada;
use Source\Entity\Delegados;
use Source\Entity\Sessoes;

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
    
    public function listaChamada(int $federacao):array
    {
        $sessaoDAO = new SessoesDAO();
        $delegadoDAO = new DelegadosDAO();
        $lista_sessoes = $sessaoDAO->findBy(
                [
                    "federacao"=>$federacao
                ],[
                    "id"=>"ASC"
                ]);
        
        $igrejaDAO = new IgrejasDAO();
        $lista_igrejas = $igrejaDAO->findBy(["federacao"=>$federacao]);
        
        foreach($lista_sessoes as $s){
            $lista_delegados_por_igreja = $delegadoDAO->delegadosPorIgreja($s->getId(),$lista_igrejas);
            $retorno[] = $this->formataLista($s, $lista_delegados_por_igreja);
            
        }
        
        
        
        return $retorno;
        
        
    }
    /**
     * 
     * @param Sessoes[] $sessoes
     * @param array $lista
     * @return array
     */
    private function formataLista($s, array $lista):array
    {
        return [
                "Sessao"=>$s->getSessao(),
                "Chamada"=>$lista
            ];
        
        
    }
    
    public function insert($data): bool
    {
        
        $delegadoDAO = new DelegadosDAO();
        if(!$delegadoDAO->validarParaChamada($data)){
            return false;
        }
        
        $delegado = $delegadoDAO->findById(intval($data['id']));
        $sessaoDao = new SessoesDAO();
        $sessao_atual = $sessaoDao->getSessaoAtual($delegado->getFederacao());
        
        
        $insercao = new Chamada();
        $insercao->setDelegado($delegado->getId());
        $insercao->setFederacao($delegado->getFederacao());
        $insercao->setSessao($sessao_atual);
        
        parent::insert($insercao);
        return true;
    }
    
    public function deletarRegistroDoDelegado(Delegados $delegado): void
    {
        $lista = $this->findBy(["delegado"=>$delegado->getId()]);
        foreach($lista as $l){
            $this->delete($l);
        }
        
    }
    
}
