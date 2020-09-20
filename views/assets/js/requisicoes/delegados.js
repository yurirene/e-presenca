
function pegaLista(){
    $.getJSON(url+"/"+token, function( data ) {
    var lista="<tr><th>Nome</th><th>Igreja</th><th>Codigo</th><th>Ação</th></tr>";
     if(data['error']){
         $("#tabela").html("<tr>Não Encontrado</tr>");

     }else{
         
         $.each(data, function(i, delegados) {
             lista+="<tr>"+
                     "<td>"+delegados.nome+"</td>"+
                     "<td>"+delegados.igreja.nome+"</td>"+
                     "<td>"+delegados.codigo+"</td>"+
                     "<td>"+
                        "<button class='btn btn-sm btn-warning mr-1' data-id='"+delegados.id+"' "+
                        "data-igreja='"+delegados.igreja.id+"' data-codigo='"+delegados.codigo+"' "+
                        " data-nome='"+delegados.nome+"' data-toggle='modal' "+
                        " data-target='#editar'>Editar</button>"+
                        "<button class='btn btn-sm btn-danger' data-toggle='modal' "+
                        " data-target='#apagar' data-id='"+delegados.id+"'>Apagar</button>"+
                    "</td>"+
                    "</tr>";
         });
         $("#tabela").html(lista);
     }

 });

}

 
 function listarIgrejas(){
     
    $.getJSON(url_igrejas+"/"+token, function( data ) {
        var lista="";
        if(data['error']){
            lista="<option disabled>Cadastre uma Igreja Primeiro</option>";
        }else{
            $.each(data, function(i, igrejas) {
                lista+="<option value='"+igrejas.id+"'>"+igrejas.nome+"</option>";
            });
        }
        preencherLista("inserir", lista);
        preencherLista("edit", lista);
    });
 }

function preencherLista(id, lista){
    $("#igrejas-"+id).html(lista);
}


 
 $('#editar').on('show.bs.modal', function (event) {
     
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id');
    var igreja = button.data('igreja');
    var codigo = button.data('codigo');
    var nome= button.data('nome') ;
    var modal = $(this);
    modal.find('#id-edit').val(id);
    modal.find('#codigo-edit').val(codigo);
    modal.find('#nome-edit').val(nome);
    
    modal.find('#igrejas-edit option').attr("selected",false)
    modal.find("#igrejas-edit option[value="+igreja+"]").attr("selected",true);
 });
 
 $('#inserir').on('show.bs.modal', function (event) {
     var modal = $(this);
    modal.find('#id').val("");
    modal.find('#codigo').val("");
    modal.find('#nome').val("");    
    modal.find('#igrejas-inserir option').attr("selected",false);
 });
 
  $('#apagar').on('show.bs.modal', function (event) {
     
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id');
    var modal = $(this);
    modal.find('#id-del').val(id);
 });


 $("#botao-apagar").click(function(event) {
     event.preventDefault();
     var id = $("#id-del").val();
     $.ajax({
         url: url+"/"+token+"/"+id,
         type: "DELETE",
         contentType: "application/json; charset=utf-8",
         success: function(data){
             alerta(data['message']['type'],data['message']['text']);
         }
     });
     $('#apagar').modal('toggle');
     pegaLista();
 });
 
    $("#botao-editar").click(function(event) {
        event.preventDefault();
        var id = $("#id-edit").val();
        var nome = $("#nome-edit").val();
        var codigo = $("#codigo-edit").val();
        var igreja = $("#igrejas-edit").val();
        var dataString = {"token":token, "nome":nome, "igreja":igreja, "codigo":codigo, "id":id};
        $.ajax({
           url: url,
           type: "PUT",
           data: JSON.stringify(dataString),
           dataType: "json",
           contentType: "application/json; charset=utf-8",
           success: function(data){
              alerta(data['message']['type'],data['message']['text']);

           }
        });
    $('#editar').modal('toggle');
    pegaLista();
 });


 $("#botao-inserir").click(function(event) {

     event.preventDefault();

     var nome = $("#nome").val();
     var igreja = $("#igrejas-inserir").val();
     var codigo = $("#codigo").val();
     var dataString = {"token":token, "nome":nome, "igreja":igreja, "codigo":codigo};
     $.ajax({
     url: url,
     type: "POST",
     data: JSON.stringify(dataString),
     dataType: "json",
     contentType: "application/json; charset=utf-8",
     success: function(data){
        alerta(data['message']['type'],data['message']['text']);
    }
     });
    $('#inserir').modal('toggle');
    $('form#inserir').trigger("reset");
    pegaLista();

 });