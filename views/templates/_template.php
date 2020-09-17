<!DOCTYPE html>
<html>
    <head>
        <title>e-Presença</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema de Presença para Congresso">
        <meta name="author" content="Yuri Ferreira">

        <link rel="stylesheet" href="<?=assets("css/bootstrap.min.css")?>" >
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
        <nav class="navbar  navbar-expand navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">e-Presença</span>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="<?=url("/")?>">Scanner</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?=url("/Lista")?>">Lista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=url("/Sessoes")?>">Sessões</a>
                    </li>
                </ul>
            
            </div>
        </nav>
        <div class="container">
            
            <?=$this->section("content");?>
            
        </div>

        <script src="<?=assets("js/jquery.min.js")?>"></script>
        <script src="<?=assets("js/popper.min.js")?>"></script>
        <script src="<?=assets("js/bootstrap.min.js")?>"></script>

        <?=$this->section("script")?>
        
    </body>
</html>