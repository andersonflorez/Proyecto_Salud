$(document).ready(function() {

  $.ajax({
    type: 'POST',
      dataType: 'JSON',
      url : url + "Despachador/ctrlListarDespacho/listarDespacho",
      async:false
    }).done(function (datos) {

  $.each(datos, function (l, despachos) {
      $('#tablaDespacho').append("<tr><td>"+despachos.idDespacho+"</td><td>"+despachos.idReporteInicial+"</td><td>"+despachos.placaAmbulancia+"</td><td>"+despachos.fechaHoraDespacho+"</td><td>"+despachos.estadoDespacho+"</td><td><button class='btn botonInforme' onClick=\"pdf('"+url+"Despachador/ctrlPdf/reporteDespacho/"+despachos.idDespacho+"')\"><i class='fa fa-file-pdf-o'></i></button></td></tr>")
       })
    }).fail( function() {
});

  $('#listarDespacho tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
  } );

  // DataTable
  var table = $('#listarDespacho').DataTable({
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

function pdf(url){
  var a = document.createElement("a");
  a.target = "_blank";
  a.href = url;
  a.click();
}
