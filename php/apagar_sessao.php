<?php

require_once("conexao.php");
session_start();
if(!$_GET['id']){
    $_SESSION['alerta']['tipo']="warning";
    $_SESSION['alerta']['texto']="Sessão Inválida";

    header("Location: ../sessoes.php");
    exit();
}

$pdo = Conexao::getInstance();

$query_chamada = "SELECT COUNT(*) as c FROM chamada WHERE sessao = :sessao";
$stmt=$pdo->prepare($query_chamada);
$stmt->bindValue(":sessao", $_GET['id']);
$stmt->execute();

$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if($resultado['c']>0){
    $_SESSION['alerta']['tipo']="danger";
    $_SESSION['alerta']['texto']="Vixe! Exitem delegados registrados nessa sessão - Chame o 'técnico'";

    header("Location: ../sessoes.php");
    exit();
}

$query_delete="DELETE FROM sessoes WHERE id = :id";
$stmt=$pdo->prepare($query_delete);
$stmt->bindValue(":id", $_GET['id']);
$stmt->execute();

$_SESSION['alerta']['tipo']="success";
$_SESSION['alerta']['texto']="Operação Realizada com Sucesso!";

header("Location: ../sessoes.php");
exit();
