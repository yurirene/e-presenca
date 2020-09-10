<?php

require_once("conexao.php");
session_start();

if(!$_POST['id']){
    $_SESSION['alerta']['tipo']="info";
    $_SESSION['alerta']['texto']="Faça o Scan do Código primeiro";

    header("Location: ../index.php");
    exit();
}

$pdo = Conexao::getInstance();

$query = "SELECT id FROM sessoes ORDER BY id DESC";
$stmt = $pdo->query($query);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$sessao = intval($resultado['id']);


$query = "SELECT COUNT(*) as c FROM chamada WHERE delegado = :delegado AND sessao = :sessao";
$stmt = $pdo->prepare($query);
$stmt->bindValue(":delegado", $_POST['id']);
$stmt->bindValue(":sessao", $sessao);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
if($resultado['c']>0){
    $_SESSION['alerta']['tipo']="warning";
    $_SESSION['alerta']['texto']="{$_POST['nome']} já está registrado nessa sessão";

    header("Location: ../index.php");
    exit();
}

try{
    
    $query = "INSERT INTO chamada (delegado, sessao) VALUES (:delegado, :sessao)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(":delegado", $_POST['id']);
    $stmt->bindValue(":sessao", $sessao);
    $stmt->execute();
    
    $_SESSION['alerta']['tipo']="success";
    $_SESSION['alerta']['texto']="Delegado {$_POST['nome']} Registrado com Sucesso!";
    
    header("Location: ../index.php");
    
}catch(Exception  $e){

    $_SESSION['alerta']['tipo']="danger";
    $_SESSION['alerta']['texto']="Erro: ".$e->getMessage();

    header("Location: ../index.php");
}


