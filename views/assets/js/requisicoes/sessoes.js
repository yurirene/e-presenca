
function pegaLista(){
    $.getJSON(url+"/"+token, function( data ) {

     if(data['error']){
         $("#lista").html("<li class='list-group-item'>Não Encontrado</li>");

     }else{
         var lista="";
         $.each(data, function(i, sessoes) {
             lista+="<li class='list-group-item'>"+sessoes.sessao+" <button class='btn btn-sm btn-danger' data-toggle='modal' data-target='#apagar-modal' data-id='"+sessoes.id+"'>Apagar</button></li>";
         });
         $("#lista").html(lista);
     }

 });

}


 $('#apagar-modal').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget) // Button that triggered the modal
     var id = button.data('id') 
     var modal = $(this)
     modal.find('#id-apagar').val(id);
 });

 $("#botao-apagar").click(function(event) {
     var id = $("#id-apagar").val();
     $('#apagar-modal').modal('toggle');
     $.ajax({
         url: url+"/"+token+"/"+id,
         type: "DELETE",
         contentType: "application/json; charset=utf-8",
         success: function(data){
             alerta(data['message']['type'],data['message']['text']);
             $('#apagar').modal('toggle');
             if(data['status']==200){
                 pegaLista();
             }

         }
     });

 });

 $("#botao-inserir").click(function(event) {

     event.preventDefault();

     var sessao = $("#sessao").val();
     var dataString = {"token":token, "sessao":sessao};
     $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(dataString),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        success: function(data){

               alerta(data['message']['type'],data['message']['text']);
               if(data['status']==200){
                   pegaLista();
               }
           }
     });

 });
