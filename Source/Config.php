<?php 

use Doctrine\DBAL\DriverManager;

define("SITE",[
    "name"=>"e-Presenca",
    "root"=>"https://localhost/ProjetosUMP/ChamadaVirtual",
    "locale"=>"pt_Br"
]);

define("ORM_CONFIG",[
    'dbname' => 'e-presenca',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
    'charset'=>'utf8'
]);

$conexao = DriverManager::getConnection(ORM_CONFIG);


/*
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "e-presenca",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);
*/
?>