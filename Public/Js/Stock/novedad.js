$(document).ready(function(){
  ConsultarNovedad();
  //Función Registrar novedad.
  $(".select").select2({
  });

  //Consulta Novedad
  function ConsultarNovedad(){
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "Stock/ctrlNovedad/ConsultarNovedad",
      async: false
    }).done(function(data){
      $("#containerTable").html('<table id="example" class="tbl_scroll"><thead><tr><th>Fecha Novedad</th><th>Recurso</th><th>Descripción</th><th>Persona</th><th>Estado</th><th><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th></tr></thead><tfoot><tr><th>Fecha Novedad</th><th>Recurso</th><th>Descripción</th><th>Persona</th><th>Estado</th><th style="display:none;"><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th></tr></tfoot><tbody id="cont-table"></tbody></table>');
      var icono = "fa fa-lock";
      $("#cont-table").empty();
      $.each(data,function(s,p){
        if (p.estadoTablaNovedad == "Activo") {
          icono = "fa fa-lock";
          classbtn = "btn btn-eliminar";
        }else{
          icono = "fa fa-unlock";
          classbtn = "btn btn-habilitar";
        }
        var descripcion = p.descripcionNovedad.substring(0, 30);
        $("#cont-table").append("<tr><td>"+p.fechaHoraNovedad +"</td><td>"+p.nombre+"</td><td>"+descripcion +"...</td><td>"+p.numeroDocumento +"</td><td>"+p.estadoTablaNovedad +"</td><td> <button value='"+ p.idNovedadRecurso+"' type='button' class='"+classbtn+"' id='btnCambiarEstado"+p.idNovedadRecurso+"' OnClick=\"CambiarEstado("+p.idNovedadRecurso+",'"+p.estadoTablaNovedad+"')\"><span class='"+icono+"'></span></button></td></tr>");
      });
    });
    $('#example tfoot th').each( function () {
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
});

//Cambiar Estado De novedad.
function CambiarEstado(idNovedadRecurso, estadoTablaNovedad) {
  $.ajax({
    url: url + "Stock/ctrlNovedad/CambiarEstadoNovedad",
    type: 'POST',
    data: {'idNovedadRecurso':idNovedadRecurso, 'estadoTablaNovedad':estadoTablaNovedad}
  }).done(function(data) {
    var Estado;
    var btn = $('#btnCambiarEstado'+idNovedadRecurso);
    var row = btn.parent().parent();
    var colEstado = row.find('td:nth-last-child(2)');
    if (data == "1") {
      if (estadoTablaNovedad == 'Activo') {
        Estado = 'Inactivo';
        btn.removeClass('btn btn-eliminar');
        btn.addClass('btn btn-habilitar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-unlock');
        colEstado.text(Estado);
      } else {
        Estado = 'Activo';
        btn.removeClass('btn btn-habilitar');
        btn.addClass('btn btn-eliminar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-lock');
        colEstado.text(Estado);
      }
      btn.attr("onclick","CambiarEstado('"+idNovedadRecurso+"','"+Estado+"')");
    } else {

    }

  }).fail(function(err) {

  });
}
