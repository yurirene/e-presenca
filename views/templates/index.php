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
                        video.pause();
                        audio.play();
                        alerta(data['message']['type'],data['message']['text']);
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
        var dataString = {"token":"<?=$_SESSION['token']?>", "id":id, "nome":nome};
        
        $.ajax({
            url: "<?= url("/API/Chamada")?>",
            type: "POST",
            data: JSON.stringify(dataString),
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function(data){
                alerta(data['message']['type'],data['message']['text']);
                video.play();
                
                
            }
        });
    });
    

    function alerta(tipo, msg){
        var alerta = "<div class='alert alert-dismissible fade alert-"+tipo+" show' role='alert'>"+
                "<p>"+msg+"</p>"+
                "<button type='button' class='close' data-dismiss='alert'>"+
                "<span aria-hidden='true'>&times;</span>"+
                "</button></div>";
        $("#alerta").html(alerta);

    }

</script>

<?=$this->end();?>