<?php

require_once("conexao.php");


$pdo = Conexao::getInstance();


$query_sessoes="SELECT id,sessao FROM sessoes ORDER BY id";
$stmt=$pdo->query($query_sessoes);

$stmt->execute();

$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
