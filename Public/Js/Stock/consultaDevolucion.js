$(document).ready(function(){
  // $("#containerTableDevolucion").hide();
ConsultarAsignacion();
});//Cierre document.ready()

//Consulta Tipos de Kit
function ConsultarAsignacion(){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Stock/ctrlConsultaDevolucion/ListarAsignacion",
    async: false
  }).done(function(data){
    $("#containerTable").html('<table id="examples" class="tbl_scroll"><thead><tr><th>Fecha De Asignación</th><th>Tipo Asignación</th><th>Médico</th><th>Paciente</th><th>Ambulancia</th><th>Ver</th></tr></thead><tfoot><tr><th>Fecha De Asignación</th><th>Tipo Asignación</th><th>Médico</th><th>Paciente</th><th>Ambulancia</th><th>Ver</th></tr></tfoot><tbody id="cont-table1"></tbody></table>');
    $("#cont-table1").empty();
    $.each(data,function(s,p){
      $("#cont-table1").append("<tr><td>"+p.fechaHoraAsignacion +"</td><td>"+p.descripcionTipoasignacion+"</td><td>"+p.numeroDpersona+"</td><td>"+p.numeroDPaciente+"</td><td>"+p.placaAmbulancia+"</td><td><button value='"+ p.idAsignacion+"' type='button'  id='btnVer"+p.idAsignacion+"' class=' fa fa-eye btn btn-consultar' name='btnRegistros' OnClick='mostrar("+p.idAsignacion+")'></button></td></tr>");
    });
  });
  $('#examples tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  });
  var table = $('#examples').DataTable({
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
}

function mostrar(id){
  $("#containerTableDevolucion").show();
  $("#containerTable").hide();
  console.log(id);
  ConsultarDevolucion(id);
}

//Consulta de devoluciones
function ConsultarDevolucion(id){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Stock/ctrlConsultaDevolucion/ConsultarDevolucion",
    async: false,
    data: {'idAsignacion':id}
  }).done(function(data){
    $("#containerTableDevolucion").html('<table id="example" class="tbl_scroll"><thead><tr><th>Fecha y Hora de Devolución</th><th>Nombre de Recurso</th><th>Tipo de Devolución</th><th>Cantidad en Devolución</th><th>N. Documento Médico</th><th>Estado de Devolución</th></tr></thead><tbody id="cont-table"></tbody><tfoot><tr><th>Fecha De Devolución</th><th>Recurso</th><th>Tipo Devolución</th><th>Cantidad</th><th>N. Documento Médico</th><th>Estado</th></tr></tfoot></table><button id="btnvolver" title="Volver" class="flecha-izq fa fa-long-arrow-left"></button>');
    $('#btnvolver').click(function(){
      $("#containerTableDevolucion").hide();
      $("#containerTable").show();
    });
    $("#cont-table").empty();
    $.each(data,function(s,p){
      $("#cont-table").append("<tr><td>"+p.fechaHoraDevolucion +"</td><td>"+p.nombre+"</td><td>"+p.descripcionDevolucion+"</td><td>"+p.cantidad+"</td><td>"+p.numeroDocumento+"</td><td>"+p.estadoTablaDevolucion+"</td></tr>");
    });
  });
  $('#examples tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  });
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

}
