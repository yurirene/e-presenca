<?php $this->layout('_template'); ?>

<div class="row">

    <div class="col-md-6 offset-md-3 col-sm-12">
        <h2 class="text-center">Lista de Presença</h2>

        <table width='100%' id="tabela">
            
        </table>

    </div>
</div>

<?=$this->start("script")?>

<script>

$.getJSON("<?= url("/API/Chamada/".$_SESSION['token'])?>", function( data ) {

    if(data == null){
        $("#tabela").html("<tr>Sem Registro</tr>")
    }else{
        
        var tabela = "";
        
        $.each( data, function(i, sessoes) {
            tabela+= "<tr><th colspan='2' class='text-center text-white negro' >"+sessoes.Sessao+"</th></tr>"
            $.each( sessoes.Chamada, function(j, chamada) {
                tabela+="<tr><th colspan='2' class='cinza'>"+chamada.Igreja+"</th></tr>";
                
                $.each( chamada.Delegados, function(k, delegado) {
                    var status = "<span class='badge badge-success'>Presente</span>";
                    if(delegado.presenca==0){
                        status = "<span class='badge badge-danger'>Ausente</span>";
                    }
                    tabela+= "<tr><td>"+delegado.nome+"</td><td>"+status+"</td></tr>";
                });
                
            });
        });
        
        $("#tabela").html(tabela)
    }

});

</script>

<?=$this->end()?>