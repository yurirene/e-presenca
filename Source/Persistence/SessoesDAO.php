<?php

namespace Source\Persistence;

use Source\Entity\Sessoes;

class SessoesDAO extends DAO
{
    
    private $path  = "Source\Entity\Sessoes";
    
    public function __construct() {
        parent::__construct($this->path);
    }
    /**
     * 
     * @param int $federacao
     * @return int
     */
    public function getSessaoAtual(int $federacao): int
    {
        $sessao = $this->findOneBy([
            "federacao"=>$federacao
                ],
                [
                    "id" => "DESC"
                ]);
        
        return $sessao->getId();
    }
    
    public function listarSessoes(int $federacao):array
    {
        return $this->formatarLista($this->findBy(["federacao"=>$federacao]));
    }
    /**
     * 
     * @param Sessoes[] $sessoes
     * @return array
     */
    private function formatarLista(array $sessoes): array
    {
        $retorno = array();
        foreach($sessoes as $s){
            $retorno[] = [
                'id'=>$s->getId(),
                'sessao'=>$s->getSessao()
            ];
        }
        
        return $retorno;
        
    }
    
    public function delete($data): bool
    {
        $sessao = $this->findById(intval(intval($data['id'])));
        $chamadaDAO = new ChamadaDAO();
        $sessao_preenchida = $chamadaDAO->findBy(["sessao"=>$sessao->getId()]);
        if(count($sessao_preenchida)>0){
             echo jsonResponse(202, danger("Vixe! A Sessão não pode ser Apagada, porque está sendo usada. Chame o técnico"));
            return false;
        }
        
        parent::delete($sessao);
        return true;      
        
    }
    
    public function verificaSeEstaDuplicado(int $federacao, string $data): bool
    {
        $sessao = $this->findOneBy(["sessao"=>$data, "federacao"=>$federacao]);
        
        if($sessao != null){
            
            return false;
        }
        
        
        return true;
        
    }
}
