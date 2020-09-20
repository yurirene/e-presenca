<?php $this->layout('_template'); ?>

<div class="row mt-5">

    <div class="col-12">
        <div id="alerta">
            
        </div>
        <h2 class="text-center">Lista de Delegados</h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#inserir">Novo Delegado</button>
        <table class="table table-striped mt-5" width='100%' id="tabela">
            
            
        </table>

    </div>
</div>


<?=$this->insert("modais/_delegados");?>


<?=$this->start("script");?>
<script src="<?= assets("js/requisicoes/delegados.js")?>"></script>
    <script>
    var token = "<?=$_SESSION['token']?>";   
    var url = "<?= url("/API/Delegados")?>";   
    var url_igrejas = "<?= url("/API/Igrejas")?>";   
    pegaLista();
    listarIgrejas();
    </script>
            
<?=$this->end();?>