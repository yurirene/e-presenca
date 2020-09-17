<?php

namespace Source\Persistence;

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
}
