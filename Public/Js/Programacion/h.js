$(document).ready(function(){
  proposito();
$.ajax({
type:'POST',
dataType:'json',
url: url+ "Programacion/ctrlHistorialprogramacion/consultaragenda",
async:false
}).done(function(data){
$.each(data,function(s,p){
$("#tabla").append("<tr><td>"+p.horaInicioTurno+"</td><td>"+p.horaFinalTurno+"</td><td>"+p.Fecha_inicial+"</td><td>"+p.Fecha_final+"</td></tr>");
});

});
$('#idiot tfoot th').each( function () {
       var title = $(this).text();
       $(this).html( );
   } );

   // DataTable
   var table = $('#idiot').DataTable({
     "iDisplayLength": 5,
     "ordering": false,
     "language": {
       "info": "Página _PAGE_ de _PAGES_",
       "infoEmpty": "No hay registros para mostrar",
       "sInfoFiltered": "(Filtrada en _MAX_ registros)",
       "zeroRecords": "No se encontraron registros",
       "search": "Buscar",
       "paginate": {
           "next": "<span class='fa fa-angle-double-right'></span>",
           "previous": "<span class='fa fa-angle-double-left'></span>"
       },
       "lengthMenu": 'N° Registros <select class="form-control">' +
       '<option value="5">5</option>' +
       '<option value="10">10</option>' +
       '<option value="20">20</option>' +
       '<option value="30">30</option>' +
       '<option value="40">40</option>' +
       '<option value="50">50</option>' +
       '<option value="-1">Todos</option>' +
       '</select>',
       "loadingRecords": "Cargando...",
       "processing": "Procesando..."
     }
   });


function proposito(){
  // modal="modal1";
  // AbrirModal(modal);
 $.ajax({
   type: 'POST',
   dataType: 'json',
   url: url + "Programacion/ctrlHistorialprogramacion/consul"
 }).done(function(data){
  console.log(data[0].estadoTablaProgramacion);
  if (data[0].estadoTablaProgramacion == null){
    $("#btnMostrar").hide();
  swal({   title: "No hay programación actual",   text: "Este preciso momento usted no tiene una programación registrada",   type: "warning" }, function(){   swal(""); });
  $("#btnMostrar").hide();
  }else{
$.each(data,function(s,p){
// $("#diagnostico").append("<tr><td>"+p.Horainicial+"</td><td>"+p.Horafinal+"</td><td>"+p.Fechainicial+"</td><td>"+p.Fechafinal+"</td><td>"+p.estadoTablaProgramacion+"</td></tr>");

$("#Hello").append("<table class='tbl_responsive' id='consulta'><thead><tr><th>Hora inicial</th><th>Hora final</th> <th>Fecha inicial</th><th>Fecha final</th><th>Estado Agenda </th> </tr></thead> <tbody id='diagnostico'><tr><td>"+p.Horainicial+"</td><td>"+p.Horafinal+"</td><td>"+p.Fechainicial+"</td><td>"+p.Fechafinal+"</td><td>"+p.estadoTablaProgramacion+"</td></tr></tbody></table>")

});
  }
    }).fail(function(fail){
       // console.log('fail',fail)
       alert("Esta malo");
     })

}
    
    


});


/*
consultar table
mascon  tbody



*/