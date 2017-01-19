
$(document).ready(function(){
  ConsultarRecurso();
  ValidateForm();
  //Función Registrar recurso.
  $(".select").select2({
  });

  ValidateForm('formRegistroRecurso',function(formdata) {
  let descripcion = 'Revisa la consola del navegador para ver los datos que has enviado';
  Notificate({
    titulo: 'Formulario enviado!',
    descripcion: descripcion,
    tipo: 'success',
    duracion: 2
  });
});

  $('#btnRegistrarRecurso').click(function(){
    var form = $("#formRegistroRecurso");
    var valor=form.valid();
    if (valor==true) {
      RegistrarRecurso();
      $('#formRegistroRecurso')[0].reset();
    }else {
      Notificate({
        tipo: 'error',
        titulo: '¡Error!',
        descripcion: 'Verifica que toda La información esté correcta.',
        duracion: 2
      });
    }
  });

  RegistrarRecurso = function(){
    $.ajax({
      type : 'POST',
      dataTypen: 'json',
      url : url + "Stock/ctrlRecurso/RegistrarRecurso",
      data : new FormData (document.getElementById("formRegistroRecurso")),
      contentType: false,
      processData: false
    }).done(function(){
      ConsultarRecurso();
      Notificate({
        tipo: 'success',
        titulo: 'Éxito',
        descripcion: 'Registro de Recurso Exitoso.',
        duracion: 2
      });
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: '¡Error!',
        descripcion: 'Verifica que toda La información esté correcta.',
        duracion: 2
      });
    })
  }

  //Cargar Datos.
  function ConsultarRecurso(){
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "Stock/ctrlRecurso/ConsultarRecurso",
      async: false
    }).done(function(data){
      $("#containerTable").html('<table id="example" class="tbl_scroll"><thead><tr><th>ID Registro</th><th>Nombre</th><th>Categoría</th><th>Existencia</th><th>Descripción</th><th>Estado</th><th>Modificar</th><th><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th></tr></thead><tfoot><tr><th>ID Registro</th><th>Nombre</th><th>Categoría</th><th>Existencia</th><th>Descripción</th><th>Estado</th><th style="display:none;">Modificar</th><th style="display:none;"><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th></tr></tfoot><tbody id="cont-table"></tbody></table>');
      var icono = "fa fa-lock";
      $("#cont-table").empty();
      $.each(data,function(s,p){
        if (p.estadoTablaRecurso == "Activo") {
          icono = "fa fa-lock";
          classbtn = "btn btn-eliminar";
        }else{
          icono = "fa fa-unlock";
          classbtn = "btn btn-habilitar";
        }
        var descripcion = p.descripcion.substring(0, 30);
        $("#cont-table").append("<tr><td>"+p.idrecurso +"</td><td>"+p.nombre +"</td><td>"+p.descripcionCategoriarecurso +"</td><td>"+p.cantidadRecurso +"</td><td>"+descripcion +"</td><td>"+p.estadoTablaRecurso +"</td><td><button type='button'class=' fa fa-pencil btn btn-consultar' name='btnRegistros' OnClick='Redireccionar("+p.idrecurso+")'></button></td><td> <button value='"+ p.idrecurso+"' type='button' class='"+classbtn+"' id='btnCambiarEstado"+p.idrecurso+"' OnClick=\"CambiarEstado("+p.idrecurso+",'"+p.estadoTablaRecurso+"')\"><span class='"+icono+"'></span></button></td></tr>");
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

//Abrir Y Cargar Datos De Actualización En Modal.
function Redireccionar(id){
  AbrirModal('ModalActualizarRecurso');
  $.ajax({
    url: url+"Stock/ctrlRecurso/traerId",
    type:'POST',
    data:{'id':id},
    dataType:'json'
  }).done(function(data){
    $("#txtidrecursoA").val(data.idrecurso);
    $("#txtnombreA").val(data.nombre);
    $("#slcidCategoriaRecursoA > option[value='"+data.idCategoriaRecurso+"']").attr("selected", "selected");
    $("#txtcantidadRecursoA").val(data.cantidadRecurso);
    $("#txtdescripcionA").val(data.descripcion);
    $(".select").select2({
    });
  }).fail(function(error){
  });
};

//Función Actualizar recurso.
$('#btnActualizarRecurso').click(function(){
  var form = $("#formModificarRecurso");
  var valor=form.valid();
  if (valor==true) {
    ActualizarRecurso();
  }else {
    Notificate({
      tipo: 'error',
      titulo: '¡Error!',
      descripcion: 'Verifica que toda La información esté correcta.',
      duracion: 2
    });
  }
});

ActualizarRecurso = function(){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Stock/ctrlRecurso/ActualizarRecurso",
    data: $("#formModificarRecurso").serialize()
  }).done(function () {
  //  location.reload(true);
  }).fail(function () {
    Notificate({
      tipo: 'error',
      titulo: '¡Error!',
      descripcion: 'Verifica que toda La información esté correcta.',
      duracion: 2
    });
  })
}

//Cambiar Estado De recurso.
function CambiarEstado(idrecurso, estadoTablaRecurso) {
  $.ajax({
    url: url + "Stock/ctrlRecurso/CambiarEstadoRecurso",
    type: 'POST',
    data: {'idrecurso':idrecurso, 'estadoTablaRecurso':estadoTablaRecurso}
  }).done(function(data) {
    var Estado;
    var btn = $('#btnCambiarEstado'+idrecurso);
    var row = btn.parent().parent();
    var colEstado = row.find('td:nth-last-child(3)');
    if (data == "1") {
      if (estadoTablaRecurso == 'Activo') {
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
      btn.attr("onclick","CambiarEstado('"+idrecurso+"','"+Estado+"')");
    } else {
    }
  }).fail(function(err) {
  });
}
