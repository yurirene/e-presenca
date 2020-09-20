<?php $this->layout('_template'); ?>

<div class="row mt-5">

    <div class="col-md-6 offset-md-3 col-sm-12">
        <div id="alerta">
            
        </div>
        <h2 class="text-center">Nova Sessão</h2>

        <form>
            <div class="form-group">
                <label>Selecione a Sessão</label>
                <select class="form-control" name="sessao" id="sessao">
                    <option value="Verificação de Poderes">Verificação de Poderes</option>
                    <option value="1ª Sessão Regular">1ª Sessão Regular</option>
                    <option value="2ª Sessão Regular">2ª Sessão Regular</option>
                    <option value="3ª Sessão Regular">3ª Sessão Regular</option>
                    <option value="4ª Sessão Regular">4ª Sessão Regular</option>
                    <option value="5ª Sessão Regular">5ª Sessão Regular</option>
                    <option value="6ª Sessão Regular">6ª Sessão Regular</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block" id="botao-inserir">Iniciar</button> 
        </form> 
    </div>
</div>
<div class="row mt-5">

    <div class="col-md-6 offset-md-3 col-sm-12">
        <h2 class="text-center">Lista de Sessões Iniciadas</h2>

        <ul class="list-group" id="lista">

        </ul>

    </div>
</div>



<div class="modal fade" id="apagar-modal" tabindex="-1" role="dialog" aria-labelledby="apagar-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apagar Sessão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Tem Certeza?</h4>
                <input type="text" id="id-apagar" hidden />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-success" id="botao-apagar">Sim</button>
            </div>
        </div>
    </div>
</div>

<?=$this->start("script");?>
<script src="<?= assets("js/requisicoes/sessoes.js")?>"></script>
    <script>
    var token = "<?=$_SESSION['token']?>";   
    var url = "<?= url("/API/Sessoes")?>";   
    pegaLista();
       
    </script>
            
<?=$this->end();?>