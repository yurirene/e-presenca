<?php

require_once("php/lista_sessao.php");
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>e-Presença</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema de Presença para Congresso">
        <meta name="author" content="Yuri Ferreira">

        <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    </head>
    <body>
        <style>
            .negro{
                background-color: #333333;
            }
            .cinza{
                background-color: #eaeaea;
            }
        </style>

        <nav class="navbar navbar-expand navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">e-Presença</span>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Scanner</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="lista.php">Lista</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="sessoes.php">Sessões</a>
                    </li>
                </ul>

            </div>
        </nav>

        <div class="container">

            <div class="row mt-5">

                <div class="col-md-6 offset-md-3 col-sm-12">
                    <h2 class="text-center">Nova Sessão</h2>
                    
                    <?php 
                    if(isset($_SESSION['alerta'])):
                    ?>

                    <div class="alert alert-<?=$_SESSION['alerta']['tipo']?> alert-dismissible fade show" role="alert">
                        <?=$_SESSION['alerta']['texto']?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <?php 
                        unset($_SESSION['alerta']);
                    endif;?>
                    
                    <form action="php/nova_sessao.php" method="POST">
                        <div class="form-group">
                            <label>Selecione a Sessão</label>
                            <select class="form-control" name="sessao">
                                <option value="Verificação de Poderes">Verificação de Poderes</option>
                                <option value="1ª Sessão Regular">1ª Sessão Regular</option>
                                <option value="2ª Sessão Regular">2ª Sessão Regular</option>
                                <option value="3ª Sessão Regular">3ª Sessão Regular</option>
                                <option value="4ª Sessão Regular">4ª Sessão Regular</option>
                                <option value="5ª Sessão Regular">5ª Sessão Regular</option>
                                <option value="6ª Sessão Regular">6ª Sessão Regular</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Iniciar</button> 
                    </form> 
                </div>
            </div>
            <div class="row mt-5">

                <div class="col-md-6 offset-md-3 col-sm-12">
                    <h2 class="text-center">Lista de Sessões Iniciadas</h2>

                    <ul class="list-group">


                        <?php
                        foreach($lista as $l):
                        ?>
                        <li class="list-group-item"><?=$l['sessao']?> <a href="php/apagar_sessao.php?id=<?=$l['id']?>" class="btn btn-sm btn-danger" >Apagar</a></li>
                        
                        <?php 
                        endforeach;
                        ?>

                    </ul>

                </div>
            </div>



        </div>

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>


    </body>
</html>