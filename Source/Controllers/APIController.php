<?php


namespace Source\Controllers;



header('Access-Control-Allow-Origin: *');
header("Content-type: application/json");

use Firebase\JWT\JWT;
use Source\Entity\Sessoes;
use Source\Persistence\ChamadaDAO;
use Source\Persistence\DelegadosDAO;
use Source\Persistence\FederacoesDAO;
use Source\Persistence\IgrejasDAO;
use Source\Persistence\SessoesDAO;
use stdClass;
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
    
    private function acesso($token):bool {
        
        if(!$token || empty($token)){
            echo json_encode(array("error"=>"Acesso Negado"));            
            return false;
        }
        $partes = explode(".", $token);
        if(count($partes)<3){
            echo json_encode(array("error"=>"Acesso Negado (TI)"));            
            return false;
        }
        $assinatura = JWT::urlsafeB64Encode(hash_hmac('sha256', $partes[0].".".$partes[1],$this->key, true));
        if($assinatura != $partes[2]){
            echo json_encode(array("error"=>"Acesso Negado"));            
            return false;
        }
        
        $this->id = $this->getInfo($token)->federacao;
        return true;
    }
    
    public function index($data) {
        if(!$this->acesso($data['token'])){
            return;
            
        }
        
        echo("index:".$this->id);
        return;
    }
    
    public function listarDelegados($data):void
    {
        if(!$this->acesso($data['token'])){
            return;
        }
        $dao  = new DelegadosDAO();
        $lista = $dao->listarDelegados($this->id);
        echo json_encode($lista);
        return;
        
    }
    
    public function novoDelegado():void
    {
        $content = (array) json_decode(file_get_contents('php://input'));
        $data = filter_var_array($content, FILTER_DEFAULT);
        if(!$this->acesso($data['token'])){
            return;
            
        }
        $dao = new DelegadosDAO();
        if(!$dao->validarParaInsercao($data, $this->id)){
            echo jsonResponse(202, danger("Dados Insuficientes"));
            return ;
        }
        $dao->inserir($data, $this->id);
        echo jsonResponse(201, success("Delegado Inserido com Sucesso"));
        return ;
    }
    
    public function atualizarDelegado():void
    {
        $content = (array) json_decode(file_get_contents('php://input'));
        $data = filter_var_array($content, FILTER_DEFAULT);
        if(!$this->acesso($data['token'])){
            return;
        }
        $dao = new DelegadosDAO();
        $delegado = $dao->findOneBy(["id"=>intval($data['id']), "federacao"=>$this->id]);
        if(!$delegado){
            echo jsonResponse(202, danger("Dados insconsistentes"));
            return ;
        }
        if(!$dao->validarParaInsercao($data, $this->id)){
            echo jsonResponse(202, danger("Dados Insuficientes"));
            return ;
        }
        $delegado->setNome($data['nome']);
        $delegado->setCodigo($data['codigo']);
        $delegado->setIgreja($data['igreja']);$dao->update($delegado);
        echo jsonResponse(200, success("Delegado Atualizado com Sucesso"));
        return ;
    }
    
    public function apagarDelegado($data): void
    {
        if(!$this->acesso($data['token'])){
            return;
        }
        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $dao = new DelegadosDAO();
        if(!$dao->apagar($id, $this->id)){
            echo jsonResponse(202, danger("Dados incorretos"));
            return ;
        }
        echo jsonResponse(200, success("Delegado Apagado com Sucesso"));
        return ;
    }
    
    public function buscarDelegadosByCodigo($data):void
    {
        if(!$this->acesso($data['token'])){
            return;        
            
        }
        $codigo = filter_var($data['codigo'], FILTER_DEFAULT);
        $dao  = new DelegadosDAO();
        $delegado = $dao->buscarDelegadosByCodigo($codigo, $this->id);
        echo json_encode($delegado);
        return;
    }
    
    
    
    public function registrarPresenca(): void
    {
        $data = (array) json_decode(file_get_contents('php://input'));
        $data = filter_var_array($data, FILTER_DEFAULT);
        if(!$this->acesso($data['token'])){
            return;
        }
        $chamadaDao = new ChamadaDAO();
        if(!$chamadaDao->insert($data)){
            return;
        }
        
        echo jsonResponse(201, success("Delegado {$data['nome']} registrado com Sucesso"));
        return ;
    }
    
    public function listarChamada($data):void
    {
        if(!$this->acesso($data['token'])){
            return;
            
        }
        $chamadaDAO = new ChamadaDAO();
        $federacao = $this->id;
        $lista = $chamadaDAO->listaChamada($federacao);
        echo json_encode($lista);
        return;
        
    }
    
    public function novaSessao(): void
    {
        $data = (array) json_decode(file_get_contents('php://input'));
        if(!$this->acesso($data['token'])){
            return;
        }
        $dao = new SessoesDAO();
        if(!$dao->verificaSeEstaDuplicado($this->id, $data['sessao'])){
            echo jsonResponse(202, danger("Sessão já iniciada"));
            return;
        }
        
        $sessao = new Sessoes();
        
        $sessao->setFederacao($this->id);
        $sessao->setSessao($data['sessao']);
        
        $dao->insert($sessao);
        
        echo jsonResponse(200, success("Sessao Criada com Sucesso!"));
    }
    
    
    public function listarSessoes($data): void
    {
        
        if(!$this->acesso($data['token'])){
            return;
        }
        $dao = new SessoesDAO();
        $lista = $dao->listarSessoes($this->id);
        echo json_encode($lista);
        return;
    }
    
    public function apagarSessao($data):void
    {
        if(!$this->acesso($data['token'])){
            return;
        }
        $dao = new SessoesDAO();
        if(!$dao->delete($data)){
            return;
        }
        
        echo jsonResponse(200, success("Sessão apagada com Sucesso!"));
        return ;
        
    }
    
    
    public function novaIgreja():void
    {
        $data = (array) json_decode(file_get_contents('php://input'));
        if(!$this->acesso($data['token'])){
            return;
        }
        $dao = new IgrejasDAO();
               
        if(!$dao->inserir($data, $this->id)){
            return;
        }
        
        echo jsonResponse(200, success("Igreja Registrada com Sucesso!"));
        return ;
        
    }
    
    public function listarIgrejas($data):void
    {
        
        if(!$this->acesso($data['token'])){
            return;
        }
        
        $dao = new IgrejasDAO();
        
        echo json_encode($dao->listarIgrejas($this->id));
        
    }
    
    public function atualizarIgreja():void
    {
        $data = (array) json_decode(file_get_contents('php://input'));
        if(!$this->acesso($data['token'])){
            return;
            
        }
        
        $data = filter_var_array($data, FILTER_DEFAULT);
        
        $dao = new IgrejasDAO();
        
        if(!$dao->atualizar($data, $this->id)){
            return;
        }
                
        echo jsonResponse(200, success("Igreja Atualizada!"));
        return ;
        
    }
    
    public function apagarIgreja($data):void
    {
        if(!$this->acesso($data['token'])){
            return;
        
        }
        
        $dao = new IgrejasDAO();
        if(!$dao->apagar(intval($data['id']), $this->id)){
            return;
        }
        
        echo jsonResponse(200, success("Igreja Removida!"));
        return ;
        
    }
    
    
    
    
}
