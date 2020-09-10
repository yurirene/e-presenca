<?php

require_once("conexao.php");


$pdo = Conexao::getInstance();


$sessoes = sessoes($pdo);
$igrejas = igrejas($pdo);

$lista = array();
$lista['sessoes'] =  $sessoes;





foreach($sessoes as $s){
    $dados = array();
    foreach($igrejas as $i){

        $dados[] = delegadosPorIgreja($pdo, $s['id'], $i['igreja']);


    }
    $lista['chamada'][] = [
        'Sessao' => $s['sessao'],
        'Dados' => $dados
    ];
    
}


function sessoes($pdo): array
{
    $query_sessoes="SELECT id, sessao FROM sessoes ORDER BY id";
    $stmt=$pdo->query($query_sessoes);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

function igrejas($pdo):array
{

    $query_igrejas="SELECT igreja FROM delegados GROUP BY igreja ORDER BY igreja";
    $stmt=$pdo->query($query_igrejas);

    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

function delegadosPorIgreja($pdo, $sessao, $igreja): array
{
    
    $query="SELECT delegados.nome, (CASE WHEN (SELECT chamada.delegado FROM chamada WHERE delegados.id = chamada.delegado AND chamada.sessao = :sessao)>0 THEN 1 ELSE 0 END) as presenca FROM `delegados` WHERE delegados.igreja = :igreja ORDER BY delegados.nome";
    $stmt=$pdo->prepare($query);
    $stmt->bindValue(':sessao', $sessao);
    $stmt->bindValue(':igreja', $igreja);
    $stmt->execute();
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return [
        'Igreja' =>$igreja,
        'Delegados' => $array
    ];
}
