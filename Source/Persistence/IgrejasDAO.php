<?php


namespace Source\Persistence;

use Source\Entity\Igrejas;
use function alert;
use function danger;
use function jsonResponse;
class IgrejasDAO extends DAO 
{
    
    private $path  = "Source\Entity\Igrejas";
    
    public function __construct() {
        parent::__construct($this->path);
    }
    
    
    public function validaDados(string $nome, int $id=null, int $federacao=null):bool
    {
        
        if($id!=null){
            
            $igreja= $this->findOneBy([
                "federacao"=>$federacao,
                "id"=>$id
            ]);
            if($igreja == null){
                return false;
            }     
        }
        
        if(isset($nome) && !empty($nome)){
            return true;                
        } 
        
        return false;
        
    }


    /**
     * 
     * @param Igrejas[] $lista
     * @return array
     */
    public function formatarLista(array $lista): array {
        $retorno = array();
        
        foreach($lista as $l){
            
            $retorno[] = [
                "id"=>$l->getId(),
                "nome"=>$l->getNome()
            ];
        }
        
        
        return $retorno;
    }
    
    public function inserir($data, int $federacao): bool
    {
        if(!$this->validaDados($data['nome'], null, $federacao)){
            echo jsonResponse(202, alert("Preencha os dados corretamente!"));
            return false;
        }
        
        
        $igreja = new Igrejas();
        $igreja->setFederacao($federacao);
        $igreja->setNome($data['nome']);
        
        $this->insert($igreja);
        return true;
        
        
    }
    
    public function listarIgrejas(int $id):array
    {
        
        return $lista = $this->formatarLista($this->findBy(
                    [
                        "federacao" =>$id
                    ], 
                    [
                        "nome"=>"ASC"
                    ] 
                ));
        
    }
    
    public function atualizar($data, int $id):bool
    {
        
        if(!$this->validaDados($data['nome'], intval($data['id']), $id)){
            echo jsonResponse(202, danger("Erro nos dados informados!"));
            return false;
        }
        
        $igreja = $this->findOneBy([
            "id"=>intval($data['id']),
            "federacao"=>$id
        ]);
        
        $igreja->setNome($data['nome']);
        
        $this->update($igreja);
        return true;
        
    }
    
    
    public function apagar(int $id, int $federacao):bool {
        
        $delegadosDAO = new DelegadosDAO();
        
        $igreja = $this->findOneBy([
            "id"=>$id,
            "federacao"=>$federacao
        ]);
        
        if(!$delegadosDAO->existeDelegadosNaIgreja($igreja->getId())){
            echo jsonResponse(202, danger("Você não pode fazer isso, existem delegados registrados na igreja"));
            return false;
        }
        
        
        if($igreja==null){
            echo jsonResponse(202, danger("Erro nos dados informados!"));
            return false;
        }
        
        $this->delete($igreja);
        return true;
    }
    
    public function buscarNomeIgreja($id):array
    {
        $igreja = $this->findById($id);
        
        if(!$igreja){
            return array("Igreja não encontrada");
        }
        return array(
            "id"=>$igreja->getId(),
            "nome"=>$igreja->getNome()
        );
        
    }
    
}