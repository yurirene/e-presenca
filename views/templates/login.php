<!doctype html>
<html lang="pt-br">
    <head>
        
        <title>e-Presença</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema de Presença para Congresso">
        <meta name="author" content="Yuri Ferreira">

        <link rel="stylesheet" href="<?=assets("css/bootstrap.min.css")?>" >
        
    </head>

    <body class="text-center">
        <style>
            html,
            body {
                height: 100%;
            }

            body {
                display: -ms-flexbox;
                display: -webkit-box;
                display: flex;
                -ms-flex-align: center;
                -ms-flex-pack: center;
                -webkit-box-align: center;
                align-items: center;
                -webkit-box-pack: center;
                justify-content: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
        </style>
        <form class="form-signin" action="<?=$router->route("app.logar")?>" method="POST">
            <?=flash()?>
            <img class="mb-4" src="" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
            <label for="usuario" class="sr-only">Usuário</label>
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" required autofocus>
            <label for="senha" class="sr-only">Password</label>
            <input type="password" id="senha" name="senha" class="form-control  mt-2 mb-3" placeholder="Password" required>
            
            <button class="btn btn-lg btn-primary btn-block" type="submit">Acessar</button>
            <p class="mt-5 mb-3 text-muted">UMP Net &copy; 2020</p>
        </form>
        <script src="<?=assets("js/jquery.min.js")?>"></script>
        <script src="<?=assets("js/popper.min.js")?>"></script>
        <script src="<?=assets("js/bootstrap.min.js")?>"></script>

        
    </body>
</html>
