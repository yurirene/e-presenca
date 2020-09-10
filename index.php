<?php
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
        
        <nav class="navbar  navbar-expand navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">e-Presença</span>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Scanner</a>
                    </li>
                    <li class="nav-item ">
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
                    <h2 class="text-center">Aponte para o QR Code</h2>
                    <video class="img-fluid" autoplay="true" id="webCamera"></video>
                </div>
            </div>
            <audio id="audio">
                <source src="audio/scan.mp3" type="audio/mp3" />
            </audio>

            <div class="row">
                <div class="col-md-6 offset-md-3 col-sm-12">
                    <?php if(isset($_SESSION['alerta'])):
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
                    <form action="php/registrar-presenca.php" method="POST">
                        <div class="form-group">
                            <label>Código do Delegado</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Nome do Delegado</label>
                            <input type="text" name="nome" id="nome" class="form-control" />
                        </div>
                        <input type="text" name="id" id="id" hidden />
                        <button id="botao" type="submit" class="btn btn-success btn-block">Registrar Presença</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

        <script src="js/script.js"></script>
        <script>
            loadCamera();
        </script>
        <script src="js/qcode-decoder.min.js" ></script>
        
        
        <script>
        
            $("#botao").attr("disabled", true);
            
            
            var qr = new QCodeDecoder();
            
            var video =
                document.getElementById('webCamera');

            QCodeDecoder()
                .decodeFromVideo(video, function(er,res){
                if(res!=null || res!=false){

                    $("#codigo").val(res);
                    $("#codigo").blur();
                }
            });
            
            $("#codigo").blur(function(){
                
                var audio = document.getElementById('audio');
                var codigo = $("#codigo").val();
                
                if(!video.paused){
                    $.getJSON("php/buscarNome.php?cod="+codigo, function( data ) {

                        if(data == false){
                            $("#nome").val("Não Encontrado");
                            $("#id").val("");
                            $("#botao").attr("disabled", true);

                        }else{
                            video.pause();
                            audio.play();
                            $("#nome").val(data.nome);
                            $("#id").val(data.id);
                            $("#botao").attr("disabled", false);
                        }

                    });
                }
                
               
                
            });
            
            
        </script>
        
    </body>
</html>