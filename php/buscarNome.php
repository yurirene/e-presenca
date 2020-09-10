<?php

require_once("conexao.php");


$pdo = Conexao::getInstance();

$query="SELECT nome, id FROM delegados WHERE codigo = '{$_GET['cod']}'";
$stmt=$pdo->query($query);

$stmt->execute();

$resultado = $stmt->fetch();

echo json_encode($resultado);