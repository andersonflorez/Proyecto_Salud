$(document).ready(function(){

  $("#txtNumeroDocumento").blur(function () {
    ConsultaPersonaD();
  });
  $("#txtCorreo").blur(function () {
    ConsultaPersonaCorreo();
  });

  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Usuarios/ctrlConsultarPersona/ListarPersonas",
    async: false
  }).done(function(data){
    var icono = "fa fa-lock";
    $("#cont-table").empty();
    $.each(data,function(s,p){
      if (p.estadoTablaPersona == "Activo") {
        icono = "fa fa-lock";
        classbtn = "btn btn-eliminar";
      }else{
        icono = "fa fa-unlock";
        classbtn = "btn btn-habilitar";
      }
      $("#cont-table").append("<tr><td>"+p.idPersona +"</td><td>"+p.numeroDocumento +"</td><td>"+p.primerNombre +"</td><td>"+p.primerApellido +"</td><td>"+p.correoElectronico +"</td><td>"+p.telefono +"</td><td>"+p.estadoTablaPersona +"</td><td><button type='button'class=' fa fa-eye btn btn-consultar' name='btnRegistros' OnClick='Redireccionar("+p.idPersona+")'></button></td><td><button type='button'class=' fa fa-pencil btn btn-consultar' name='btnRegistros' OnClick='Redireccionar2("+p.idPersona+")'></button></td><td> <button value='"+ p.idPersona+"' type='button' class='"+classbtn+"' id='btnCambiarEstado"+p.idPersona+"' OnClick=\"CambiarEstado("+p.idPersona+",'"+p.estadoTablaPersona+"')\"><span class='"+icono+"'></span></button></td></tr>");
    });

  });

  $('#example tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" style="font-weight:lighter;" placeholder="Filtro" />' );
  });

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

  table.columns().every(function(){
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

function Redireccionar(id){

  AbrirModal('modalVerPersona');

  $.ajax({
    url: url+"Usuarios/ctrlConsultarPersona/traerId",
    type:'POST',
    data:{'id':id},
    dataType:'json'
  }).done(function(data){
    var img = document.getElementById("imagenPersona");
    img.src = "../"+data.urlFoto;
    var url = data.urlFoto;
    $("#txtPrimerNombreP").val(data.primerNombre);
    $("#txtSegundoNombreP").val(data.segundoNombre);
    $("#txtPrimerApellidoP").val(data.primerApellido);
    $("#txtSegundoApellidoP").val(data.segundoApellido);
    $("#slcTipoDocumentoP> option[value='"+data.idTipoDocumento+"']").attr("selected", "selected");
    $("#txtNumeroDocumentoP").val(data.numeroDocumento);
    $("#txtLugarExpedicionDocumentoP").val(data.lugarExpedicionDocumento);
    $("#txtFechaNacimientoP").val(data.fechaNacimiento);
    $("#txtLugarNacimientoP").val(data.lugarNacimiento);
    $("#slcSexoP").val(data.sexo);
    $("#txtDireccionP").val(data.direccion);
    $("#txtTelefonoP").val(data.telefono);
    $("#txtCorreoP").val(data.correoElectronico);
    $("#slcGrupoSanguineoP").val(data.grupoSanguineo);
    $("#txtCiudadP").val(data.ciudad);
    $("#txtDepartamentoP").val(data.departamento);
    $("#txtPaisP").val(data.pais);
    $("#slcDependenciaP").val(data.dependencia);

  }).fail(function(error){

  });

  $.ajax({
    url: url+"Usuarios/ctrlConsultarPersona/traerRol",
    type:'POST',
    data:{'id':id},
    dataType:'json'
  }).done(function(data){

    $("#slcRolP> option[value='"+data.idRol+"']").attr("selected", "selected");

  }).fail(function(error){

  });

};

function Redireccionar2(id){

  window.location.assign(url+"Usuarios/ctrlModificarPersona/Index/"+btoa(id));

};

//funcion para quese habiliten las especialidades cuando este seleccionado el rol médico
$("#slcRol").change(function () {
  if ($("#slcRol").val() != "3") {
    $("#slcEspecialidad").attr("disabled", "disabled");
  } else {
    $("#slcEspecialidad").removeAttr("disabled");
  }
});

$("#slcRol").change(function () {
  if ($("#slcRol").val() != "3") {
    $("#txtFirma").attr("disabled", "disabled");
  } else {
    $("#txtFirma").removeAttr("disabled");
  }
});


ValidateForm('FormModificarPersona', function() {

  $.ajax({
    type: 'POST',
    url: url + "Usuarios/ctrlModificarPersona/ActualizarPersona",
    contentType: false,
    processData: false,
    data: new FormData($("#FormModificarPersona")[0])
  }).done(function (data) {

    if (Number(data) === 1) {
      var descripcion = 'Se ha modificado exitosamente';
      Notificate({
        titulo: '¡Modificación exitosa!',
        descripcion: descripcion,
        tipo: 'success',
        duracion: 4
      });

    } else {
      Notificate({
        tipo: 'success',
        titulo: '¡Modificación exitosa!',
        descripcion: 'Se ha modificado exitosamente',
        duracion: 4
      });
    }

  }).fail(function (a) {
    Notificate({
      tipo: 'error',
      titulo: '¡Error!',
      descripcion: 'Verifica que toda la información esté correcta',
      duracion: 4
    });
  })

});

function CambiarEstado(idPersona, estadoTablaPersona) {
  $.ajax({
    url: url + "Usuarios/ctrlConsultarPersona/CambiarEstadoPersona",
    type: 'POST',
    data: {'idPersona':idPersona, 'estadoTablaPersona':estadoTablaPersona}
  }).done(function(data) {
    var Estado;
//    console.log(estadoTablaPersona);
    var btn = $('#btnCambiarEstado'+idPersona);
    var row = btn.parent().parent();
    var colEstado = row.find('td:nth-last-child(4)');
    if (data == "1") {
      if (estadoTablaPersona == 'Activo') {
        Estado = 'Inactivo';
        btn.removeClass('btn btn-eliminar');
        btn.addClass('btn btn-habilitar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-unlock');
        colEstado.text(Estado);
        Notificate({
          tipo: 'success',
          titulo: '¡Éxito!',
          descripcion: 'Se ha inhabilitado la persona correctamente',
          duracion: 2

        });
      } else {
        Estado = 'Activo';
        btn.removeClass('btn btn-habilitar');
        btn.addClass('btn btn-eliminar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-lock');
        colEstado.text(Estado);
        Notificate({
          tipo: 'success',
          titulo: '¡Éxito!',
          descripcion: 'Se ha habilitado la persona correctamente',
          duracion: 2

        });
      }
      btn.attr("onclick","CambiarEstado('"+idPersona+"','"+Estado+"')");
    } else {
//      console.log('Ha ocurrido un error al intentar realizar la operación');
    }
//    console.log(colEstado);
  }).fail(function(err) {
//    console.log(err);
  });
}

function ConsultaPersonaCorreo() {
  var correo = $("#txtCorreo").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlModificarPersona/ConsultarPersonaCorreo',
    data: {
      'txtCorreo': correo
    },
  }).done(function (data) {

    if (data == '1') {
      $('#btnModificarPersona').attr("disabled", false);
    } else {
      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ese correo ya está siendo usado',
        duracion: 4
      });

      $.each(data, function (indice, valor) {
        $('#btnModificarPersona').attr("disabled", true);

      });
    }
  }).fail(function (err) {

  })
}

function ConsultaPersonaD() {
  var numero = $("#txtNumeroDocumento").val();
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    url: url + 'Usuarios/ctrlModificarPersona/ConsultarPersonaD',
    data: {
      'txtNumeroDocumento': numero
    },
  }).done(function (data) {

    if (data == '1') {

      $('#btnModificarPersona').attr("disabled", false);
    } else {
      Notificate({
        tipo: 'info',
        titulo: 'Noticia',
        descripcion: 'Ese número de documento ya está siendo usado',
        duracion: 4

      });

      $.each(data, function (indice, valor) {
        $('#btnModificarPersona').attr("disabled", true);

      });
    }
  }).fail(function (err) {

  })
}

$("#txtFechaNacimiento").datepicker({
        language: 'es',
        maxDate: new Date()
       });

       $("#txtFechaNacimiento").blur(function (){
     $.ajax({
       type:'POST',
       dataType: 'JSON',
       url:url+'Usuarios/ctrlModificarPersona/FechaServidor'
     }).done(function(data){
       var valorFecha = $("#txtFechaNacimiento").val();
       var fecha = new Date(valorFecha);
       var fechaActual = new Date(data);
       var lfechaActual=fechaActual.getYear()-18;
       if (fecha.getYear() > lfechaActual) {
         Notificate({
           tipo: 'warning',
           titulo: 'Cuidado con la fecha',
           descripcion: 'No puede registrar una persona menor de edad.',
           duracion: 4
         });
         $("#txtFechaNacimiento").val("").focus();
       }else if (fecha.getYear() == lfechaActual && fecha.getMonth() > fechaActual.getMonth()) {
         Notificate({
           tipo: 'warning',
           titulo: 'Cuidado con la fecha',
           descripcion: 'No puede registrar una persona menor de edad.',
           duracion: 4
         });
         $("#txtFechaNacimiento").val("").focus();
       }else if(fecha.getYear() == lfechaActual && fecha.getMonth() == fechaActual.getMonth() && fecha.getDate() >  fechaActual.getDate()){
         Notificate({
           tipo: 'warning',
           titulo: 'Cuidado con la fecha',
           descripcion: 'No puede registrar una persona menor de edad.',
           duracion: 4
         });
         $("#txtFechaNacimiento").val("").focus();
       }
     });
   });
