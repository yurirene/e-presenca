<?php

namespace Source\Persistence;

use PDO;
use Source\Entity\Delegados;
use Source\Entity\Igrejas;

class DelegadosDAO extends DAO {

    private $path = 'Source\Entity\Delegados';
    
    function __construct() {
        parent::__construct($this->path);
    }
    
    public function inserir(array $data, int $federacao): void
    {
        $delegado = new Delegados();
        $delegado->setCodigo($data['codigo']);
        $delegado->setFederacao($federacao);
        $delegado->setIgreja($data['igreja']);
        $delegado->setNome($data['nome']);
        
        $this->insert($delegado);
        
    }

    public function validarParaInsercao(array $data, int $federacao): bool
    {
        if(!isset($data['nome']) || !isset($data['codigo']) || !isset($data['igreja'])){
            return false;
        }
        if(intval($data['igreja'])<0){
            return false;
        }
        if(strlen($data['codigo'])>9){
            return false;
        }
        
        $igrejasDAO = new IgrejasDAO();
        $igreja = $igrejasDAO->findOneBy(["federacao"=>$federacao, "id"=>$data['igreja']]);
        if(!$igreja){
            return false;
        }
        
        return true;
        
    }
    
    function validarParaChamada($data):bool
    {
        if($data['id']==null || !isset($data['id'])){
            echo jsonResponse(202, danger("Escaneie o Código primeiro"));
            return false;
        }
        
        $delegado = $this->findById(intval($data['id']));
        
        if(!$delegado){
            echo jsonResponse(202, danger("Delegado não encontrado"));
            return false;
        }
        
        $chamadaDao = new ChamadaDAO();
        $presente  = $chamadaDao->verificaSeEstaRegistradoNaSessao($delegado);
        
        if(!$presente){
            echo jsonResponse(200, alert("Delegado {$delegado->getNome()} já está registrado nessa Sessão"));
            return false;
        }
        return true;
    }
    
    
    /**
     * 
     * @param Igrejas[] $igrejas
     * @return array
     */
    public function delegadosPorIgreja($sessao, array $igrejas): array
    {
        $retorno = array();
        foreach($igrejas as $i){
                
            $sql = "SELECT delegados.nome, (CASE WHEN (SELECT chamada.delegado_id FROM chamada WHERE delegados.id = chamada.delegado_id AND chamada.sessao_id = {$sessao})>0 THEN 1 ELSE 0 END) as presenca FROM `delegados` WHERE delegados.igreja_id = {$i->getId()} ORDER BY delegados.nome";
            $conn = $this->getConection();
            
            $result= $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $retorno[] = [
                "Igreja"=>$i->getNome(),
                "Delegados"=>$result
            ];
        }
        return $retorno;
    }
    /**
     * 
     * @param Delegados[] $lista
     * @return array
     */
    private function formataLista(array $lista):array
    {
        $retorno = array();
        foreach($lista as $l){
            
            $retorno[] = $l->getNome();
            
        }
        return $retorno;
    }
 
    
    public function existeDelegadosNaIgreja(int $id):bool
    {
        
        $delegados = $this->findBy([
            "igreja"=>$id
        ]);
        if(count($delegados)>0){
            return false;
        }
        return true;
        
    }
    
    public function apagar(int $id, int $federacao):bool
    {
        $delegado = $this->findOneBy(["id"=>$id, "federacao"=>$federacao]);
        if(!$delegado){
            return false;
        }
        $dao = new ChamadaDAO();
        $dao->deletarRegistroDoDelegado($delegado);
        $this->delete($delegado);
        return true;
        
    }
    
    public function listarDelegados(int $federacao):array
    {
        $daoIgreja = new IgrejasDAO();
        $delegados = $this->findBy(array(
            "federacao"=>$federacao
        ));
        
        if(!$delegados){
            $lista[] = "Sem Delegados Cadastrados";
            return $lista;
        }
        
        foreach($delegados as $delegado){
            $lista[] = [
                "id"=> $delegado->getId(),
                "nome"=> $delegado->getNome(),
                "codigo" => $delegado->getCodigo(),
                "igreja" => $daoIgreja->buscarNomeIgreja($delegado->getIgreja()),
                "federacao" => $delegado->getFederacao()
            ];
        }
        return $lista;
        
    }
    
    
    public function buscarDelegadosByCodigo($codigo, $federacao): array
    {
        $delegado = $this->findOneBy(array(
            "codigo"=>$codigo,
            "federacao"=>$federacao
        ));
        
        if(!$delegado){
            return array(["error"=>"Codigo Inválido"]);
        }
        
        return array([
            "id"=> $delegado->getId(),
            "nome"=> $delegado->getNome(),
            "codigo" => $delegado->getCodigo(),
            "igreja" => $delegado->getIgreja(),
            "federacao" => $delegado->getFederacao()
        ]);        
    }
}
