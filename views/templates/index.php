<?php $this->layout('_template'); ?>

<div class="row">

    <div class="col-md-6 offset-md-3 col-sm-12">
        <h2 class="text-center">Aponte para o QR Code</h2>
        <video class="img-fluid" autoplay="true" id="webCamera"></video>
    </div>
</div>
<audio id="audio">
    <source src="<?=assets("audio/scan.mp3")?>" type="audio/mp3" />
</audio>


<div class="row">
    
    <div class="col-md-6 offset-md-3 col-sm-12">
        
        <div class="row">
            <div id="alerta">
                <div class="alert alert-dismissible fade" role="alert" id="alerta-class">
                    <p id="alerta-texto"></p>
                    <button type="button" class="close" id="botao-close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="form-group">
                <label>Código do Delegado</label>
                <input type="text" name="codigo" id="codigo" class="form-control" />
            </div>
            <div class="form-group">
                <label>Nome do Delegado</label>
                <input type="text" name="nome" id="nome" class="form-control" />
            </div>
        <form id="presenca">
            
            <input type="text" name="id" id="id" hidden />
            <button id="botao" type="submit" class="btn btn-success btn-block">Registrar Presença</button>
        </form>
    </div>
</div>


<?=$this->start("script");?>

<script src="<?=assets("js/script.js")?>"></script>
<script>
    loadCamera();
</script>
<script src="<?=assets("js/qcode-decoder.min.js")?>"></script>


<script>



    $("#botao").attr("disabled", true);


    var qr = new QCodeDecoder();

    var video = document.getElementById('webCamera');

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
            
            
            var audio = document.getElementById('audio');
            var codigo = $("#codigo").val();

            if(!video.paused){
                $.getJSON("<?= url("/API/Delegados/".$_SESSION['token'])?>/"+codigo, function( data ) {

                    if(data['error']){
                        $("#nome").val("Não Encontrado");
                        $("#id").val("");
                        $("#botao").attr("disabled", true);

                    }else{
                        desativar();
                        video.pause();
                        audio.play();
                        $("#nome").val(data.nome);
                        $("#id").val(data.id);
                        $("#botao").attr("disabled", false);
                    }

                });
            }
        }



    });
    
    $("#botao").click( function(event){
        event.preventDefault();
        // REGISTRAR PRESENCA
        var id = $("#id").val();
        var nome = $("#nome").val();
        var dataString = {"token":"<?=$_SESSION['token']?>", "id":id};
        $.ajax({
            url: "<?= url("/API/Chamada")?>",
            type: "POST",
            data: JSON.stringify(dataString),
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function(data){
                $("#alerta-class").addClass("alert-"+data['message']['type'])
                $("#alerta-texto").text(data['message']['text']);
                $("#alerta-class").addClass("show");
                video.play();
                
                
            }
        });
    });
    
   $("#botao-close").click( function(event){
        event.preventDefault();
        desativar();
    });
    
    function desativar(){
        $("#alerta-class").removeClass("show");
    }


</script>

<?=$this->end();?>