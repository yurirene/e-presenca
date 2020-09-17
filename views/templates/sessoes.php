<?php $this->layout('eleitor/_template'); ?>

<div class="row mt-5">

    <div class="col-md-6 offset-md-3 col-sm-12">
        <h2 class="text-center">Nova Sessão</h2>

        <?=flash()?>

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