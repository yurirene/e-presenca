
<div class="modal fade" id="inserir" tabindex="-1" role="dialog" aria-labelledby="inserirLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inserirLabel">Novo Delegado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-inserir">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" />
                    </div>
                    <div class="form-group">
                        <label for="codigo">Código:</label>
                        <input type="text" class="form-control" id="codigo" maxlength="9" />
                        <small>Até 9 caracteres</small>
                    </div>
                    <div class="form-group">
                        <label for="igrejas-inserir">Igreja:</label>
                        <select class="form-control" id="igrejas-inserir">
                            
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="botao-inserir">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="editarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome-edit">Nome:</label>
                        <input type="text" class="form-control" id="nome-edit" />
                    </div>
                    <div class="form-group">
                        <label for="codigo-edit">Código:</label>
                        <input type="text" class="form-control" id="codigo-edit" maxlength="9" />
                        <small>Até 9 caracteres</small>
                    </div>
                    <div class="form-group">
                        <label for="igrejas-edit">Igreja:</label>
                        <select class="form-control" id="igrejas-edit">
                            
                        </select>
                    </div>
                    
                    <input type="text" id="id-edit" hidden/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" id="botao-editar">Editar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="apagar" tabindex="-1" role="dialog" aria-labelledby="apagarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apagarLabel">Apagar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>

                <div class="modal-body">
                    <h4>Tem Certeza?</h4>
                    <input type="text" id="id-del" hidden/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="botao-apagar">Apagar</button>
                </div>
            </form>

        </div>
    </div>
</div>
