
function pegaLista(){
    $.getJSON(url+"/"+token, function( data ) {
    var lista="<tr><th>Nome</th><th>Ação</th></tr>";
     if(data['error']){
         $("#tabela").html("<tr>Não Encontrado</tr>");

     }else{
         
         $.each(data, function(i, igreja) {
             lista+="<tr>"+
                     "<td>"+igreja.nome+"</td>"+
                     "<td>"+
                        "<button class='btn btn-sm btn-warning mr-1' data-id='"+igreja.id+"' "+
                        "data-igreja='"+igreja.id+"' data-nome='"+igreja.nome+"' "+
                        "data-toggle='modal' data-target='#editar'>Editar</button>"+
                        "<button class='btn btn-sm btn-danger' data-toggle='modal' "+
                        " data-target='#apagar' data-id='"+igreja.id+"'>Apagar</button>"+
                    "</td>"+
                    "</tr>";
         });
         $("#tabela").html(lista);
     }

 });

}

 
 $('#editar').on('show.bs.modal', function (event) {
     
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id');
    var nome= button.data('nome') ;
    var modal = $(this);
    modal.find('#id-edit').val(id);
    modal.find('#nome-edit').val(nome);
 });
 
 $('#inserir').on('show.bs.modal', function (event) {
     var modal = $(this);
    modal.find('#id').val("");
    modal.find('#nome').val("");
 });
 
  $('#apagar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
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
        var dataString = {"token":token, "nome":nome, "id":id};
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
     var dataString = {"token":token, "nome":nome};
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
    pegaLista();

 });