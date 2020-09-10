<?php

require_once("conexao.php");
session_start();
if(!$_POST['sessao']){
    $_SESSION['alerta']['tipo']="warning";
    $_SESSION['alerta']['texto']="Selecione uma Sessão";

    header("Location: ../sessoes.php");
    exit();
}

$pdo = Conexao::getInstance();


$query_sessoes="SELECT COUNT(*) as c FROM sessoes WHERE sessao = :sessao";
$stmt=$pdo->prepare($query_sessoes);
$stmt->bindValue(":sessao", $_POST['sessao']);
$stmt->execute();

$resultado= $stmt->fetch(PDO::FETCH_ASSOC);

if($resultado['c']>0){
    $_SESSION['alerta']['tipo']="danger";
    $_SESSION['alerta']['texto']="Sessão já iniciada, escolha outra";

    header("Location: ../sessoes.php");
    exit();
    
}

try{
    
    $query="INSERT INTO sessoes (sessao) VALUES (:sessao)";
    $stmt=$pdo->prepare($query);
    $stmt->bindValue(":sessao", $_POST['sessao']);
    $stmt->execute();
    
    $_SESSION['alerta']['tipo']="success";
    $_SESSION['alerta']['texto']="Sessão Iniciada!";

    header("Location: ../sessoes.php");
    
}catch (Exception $e){
    $_SESSION['alerta']['tipo']="danger";
    $_SESSION['alerta']['texto']="Erro! ".$e->getMessage();

    header("Location: ../sessoes.php");
}
exit();