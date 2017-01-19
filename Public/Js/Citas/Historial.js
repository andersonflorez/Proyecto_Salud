$(document).ready(function(){

  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Citas/ctrlHistorialCitas/ListarCitasT",
    async: false
  }).done(function(data){
    if (data!=null) {
    $("#cont-table").html();
    $.each(data,function(a,b){
      $("#cont-table").append("<tr><td>"+b.numeroDocumento+"</td><td>"+b.NombrePaciente+
      "</td><td onmouseout='ocultarNombreCUP()' onmouseover='mostrarNombreCUP("+'"'+b.nombreCUP+'"'+")'><p>"+b.codigoCup+"</p>"+"</td><td>"+b.fechaCita+
      "</td><td>"+b.horaInicial+"</td><td>"+b.direccionCita+"</td><td>"
      +b.estadoTablaCita+"</td><td> <button  class='fa fa-eye btn-modal btn btn-consultar' onclick='ConsultarPersonalAsistencial("+b.idCita+")' type='button'></button></td></tr>");
    });
  }else {
  $(".infoC").html("No se encuentran citas registradas.");
  }
  });
  // Setup - add a text input to each footer cell
  $('#example tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  } );
  // DataTable
  var table = $('#example').DataTable({
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
  // Apply the search
  table.columns().every( function () {
    var that = this;
    $( 'input', this.footer() ).on( 'keyup change', function () {
      if ( that.search() !== this.value ) {
        that
        .search( this.value )
        .draw();
      }
    });
  });
});

function mostrarNombreCUP(texto){
  $("#textNombreCUP").html("<b>Nombre CUP:</b> "+texto);
}

function ocultarNombreCUP(){
  $("#textNombreCUP").text("");
}

 function ConsultarPersonalAsistencial(idCita){
  $.ajax({
    type:"POST",
    url: url + "Citas/CtrlHistorialCitas/ConsultaPersonalAsi",
    data:{idCita:idCita}
  }).done(function(data){
    var Informacion = JSON.parse(data);
    $("#AbrirPersonal").html("");
    $.each(Informacion,function(a,b){
    $("#AbrirPersonal").append("<center><span style='color:#1f95d0;font-weight:bold;font-size:24px;'>"
    +b.descripcionRol+" : </span><span style='font-size:20px;color: #666;'>"+b.NombrePersona+"</span></center>");
});
  AbrirModal('modalPAsistencial');
  }).fail(function(error){
    console.log(error);
  });
}
