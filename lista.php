<?php

require_once("php/lista_chamada.php");

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
                    <li class="nav-item active">
                        <a class="nav-link" href="lista.php">Lista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sessoes.php">Sessões</a>
                    </li>
                </ul>

            </div>
        </nav>

        <div class="container">
            <div class="row">

                <div class="col-md-6 offset-md-3 col-sm-12">
                    <h2 class="text-center">Lista de Presença</h2>
                    
                    <table width='100%'>
                        
                        
                        <?php
                        foreach($lista['chamada'] as $l):
                        ?>
                        <tr>
                            <th colspan="2" class="text-center text-white negro" ><?=$l['Sessao']?></th>
                        </tr>
                        <?php
                            foreach($l['Dados'] as $i):
                        ?>
                        <tr>
                            <th colspan="2" class="cinza"><?=$i['Igreja']?></th>
                        </tr>
                        <?php 
                                    foreach($i['Delegados'] as $d):
                                        $status = "<span class='badge badge-success'>Presente</span>";
                                        if($d['presenca']==0){
                                            $status = "<span class='badge badge-danger'>Ausente</span>";
                                        }
                        ?>
                        
                        <tr>
                            <td><?=$d['nome']?></td>
                            <td><?=$status?></td>
                        </tr>
                        <?php 
                                endforeach;
                            endforeach;
                        endforeach;
                        ?>
                        
                    </table>
                    
                </div>
            </div>


            
        </div>

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

        
    </body>
</html>