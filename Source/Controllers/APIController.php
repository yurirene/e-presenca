<?php


namespace Source\Controllers;



header('Access-Control-Allow-Origin: *');
header("Content-type: application/json");

use Firebase\JWT\JWT;
use Source\Entity\Chamada;
use Source\Persistence\ChamadaDAO;
use Source\Persistence\DelegadosDAO;
use Source\Persistence\FederacoesDAO;
use Source\Persistence\SessoesDAO;
use stdClass;
use function alert;
use function danger;
use function jsonResponse;
use function success;

/**
 * Controller da APÌ do e-presenca
 *
 * @author Yuri
 */
class APIController extends Controller 
{
    private $key = "v38xkHThwpTN";
    private $id;
    
    public function __construct($router) {
        parent::__construct($router);
    }
    
    public function getInfo($token): stdClass
    {
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        
        return $decoded;
        
    }
    
    private function acesso($token):void {
        
        if(!$token || empty($token)){
            echo json_encode(array("error"=>"Acesso Negado"));            
            return;
        }
        $partes = explode(".", $token);
        $assinatura = JWT::urlsafeB64Encode(hash_hmac('sha256', $partes[0].".".$partes[1],$this->key, true));
        if($assinatura != $partes[2]){
            echo json_encode(array("error"=>"Acesso Negado"));            
            return;
        }
        
        $this->id = $this->getInfo($token)->federacao;
        
    }
    
    public function index($data) {
        $this->acesso($data['token']);
        
        echo("index:".$this->id);
        return;
    }
    
    public function listarDelegados($data):void
    {
        $this->acesso($data['token']);
        $lista = array();
        $resultado  = new DelegadosDAO();
        $delegados = $resultado->findBy(array(
            "federacao"=>$this->id
        ));
        
        if(!$delegados){
            $jsonResponse = json_encode(["error"=>"Codigo Inválido"]);
            echo $jsonResponse;
            return;
        }
        
        foreach($delegados as $delegado){
            $lista[] = [
                "id"=> $delegado->getId(),
                "nome"=> $delegado->getNome(),
                "codigo" => $delegado->getCodigo(),
                "igreja" => $delegado->getIgreja(),
                "federacao" => $this->buscarFederacao($delegado->getFederacao())
            ];
        }
        
        $jsonResponse = json_encode($lista);
        echo $jsonResponse;
        return;
        
    }
    
    public function buscarDelegadosByCodigo($data):void
    {
        $this->acesso($data['token']);
        $codigo = filter_var($data['codigo'], FILTER_DEFAULT);
        $resultado  = new DelegadosDAO();
        $delegado = $resultado->findOneBy(array(
            "codigo"=>$codigo,
            "federacao"=>$this->id
        ));
        
        if(!$delegado){
            $jsonResponse = json_encode(["error"=>"Codigo Inválido"]);
            echo $jsonResponse;
            return;
        }
        $jsonResponse = json_encode([
            "id"=> $delegado->getId(),
            "nome"=> $delegado->getNome(),
            "codigo" => $delegado->getCodigo(),
            "igreja" => $delegado->getIgreja(),
            "federacao" => $this->buscarFederacao($delegado->getFederacao())
        ]);
        echo $jsonResponse;
        return;
        
    }
    
    private function buscarFederacao($id):array
    {
        $id = intval($id);
        $resultado  = new FederacoesDAO();
        $federacao = $resultado->findById($id);
        
        if(!$federacao){
            return array();
        }
        return array(
            "id"=>$federacao->getId(),
            "sigla"=>$federacao->getSigla()
        );
    }
    
    public function registrarPresenca(): void
    {
        $data = (array) json_decode(file_get_contents('php://input'));
        $data = filter_var_array($data, FILTER_DEFAULT);
        $this->acesso($data['token']);
        
        if($data['id']==null || !isset($data['id'])){
            echo jsonResponse(204, danger("Escaneie o Código primeiro"));
            return;
        }
        
        $entityManager = new DelegadosDAO();
        $delegado = $entityManager->findById(intval($data['id']));
        
        if(!$delegado){
            echo jsonResponse(204, danger("Delegado não encontrado"));
            return;
        }
        
        $chamadaDao = new ChamadaDAO();
        $presente  = $chamadaDao->verificaSeEstaRegistradoNaSessao($delegado);
        $sessaoDao = new SessoesDAO();
        $sessao_atual = $sessaoDao->getSessaoAtual($delegado->getFederacao());
        
        if(!$presente){
            echo jsonResponse(200, alert("Delegado {$delegado->getNome()} já está registrado nessa Sessão"));
            return ;
        }
        
        $insercao = new Chamada();
        $insercao->setDelegado($delegado->getId());
        $insercao->setFederacao($delegado->getFederacao());
        $insercao->setSessao($sessao_atual);
        
        $chamadaDao->insert($insercao);
        
        echo jsonResponse(201, success("Delegado {$delegado->getNome()} registrado com Sucesso"));
        return ;
    }
    
    
}
