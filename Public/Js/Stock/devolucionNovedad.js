$(document).ready(function(){
  ValidateForm();
  $(".select").select2({
  });
  $("#containerTable").hide();
  $("#formRegistroDevolucion").hide();
  //Mostrar Campos
  $('#slcasignacion').change(function(){
    let option=(this.value);
    if (option ==0){
      $("#medico").fadeOut(300);
      $("#paciente").fadeOut (300);
    }else if (option ==1){
      $("#medico").fadeIn (300);
      $("#paciente").fadeOut(300);
      $("#ambulancia").fadeOut(300);
    }else if(option ==2){
      $("#paciente").fadeIn(300);
      $("#medico").fadeOut(300);
      $("#ambulancia").fadeOut(300);
    }else if(option ==3){
      $("#ambulancia").fadeIn(300);
      $("#paciente").fadeOut(300);
      $("#medico").fadeOut(300);
    }
  });

  $('#btnconfirmarAsignacion').click(function(){
    ConfirmarAsignacion();
  });

  var myDatepicker = $('#txtfechaHoraAsignacion').datepicker().data('datepicker');
  $("#txtfechaHoraAsignacion").datepicker({
    language: 'es',
    onSelect:function(formattedDate){
      myDatepicker.hide();
    }
  });

  ValidateForm('formConsultaAsignacion', function(formdata) {
    let descripcion = 'Revisa la consola del navegador para ver los datos que has enviado';
    Notificate({
      titulo: 'Formulario enviado!',
      descripcion: descripcion,
      tipo: 'success',
      duracion: 2
    });
  });


  //Función confirmar Asignación
  function ConfirmarAsignacion(){
    var fecha = $("#txtfechaHoraAsignacion").val();
    var id = 0;
    var select = "l"
    if (fecha == 0 ) {
      Notificate({
        titulo: 'Ha ocurrido un error',
        descripcion: 'Por favor ingrese una fecha.',
        tipo: 'warning',
        duracion: 2
      });
    }
    else {
      if ($('#slcidAmbulancia').is(':visible')){
        id = $("#slcidAmbulancia").val();
        select = "ambulancia";
      }else if ($('#slcidPaciente').is(':visible')) {
        id = $("#slcidPaciente").val();
        select = "paciente";
      }else{
        id = $("#slcidPersona").val();
        select = "persona";
      }
    }
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:url+'Stock/ctrlDevolucionNovedad/ConfirmarAsignacion',
      data:{'idTipo':id,'select':select,'fecha':fecha}
    }).done(function(data){
      var obj = {
        data:data
      }
      $('.contenedor-btn-registrar').empty();
      $('.contenedor-btn-registrar').append('<span class="btn btn-registrar">Registrar</span>');

      if(fecha != 0 ){
        if (data == null) {
          Notificate({
            titulo: 'Ha ocurrido un error',
            descripcion: 'Verifique los datos e intente nuevamente',
            tipo: 'warning',
            duracion: 2
          });
        }else{
          $("#containerTable").show();
          $("#formRegistroDevolucion").show();
          $("#formConsultaAsignacion").hide();
          $.each(data,function(i, s){
            $("#containerTable").html('<table id="example" class="tbl_scroll"><thead><tr><th>ID Registro</th><th>Recurso</th><th>Cantidad Asignada</th><th>Residuo</th><th>Novedad</th></tr></thead><tfoot><tr><th>ID Registro</th><th>Recurso</th><th>Cantidad Asignada</th><th>Residuo</th><th>Novedad</th></tr></tfoot><tbody id="cont-table"></tbody></table>    <button id="btnvolver" title="Volver" class="flecha-izq fa fa-long-arrow-left"></button>');
            $('#btnvolver').click(function(){
              $("#containerTable").hide();
              $("#formRegistroDevolucion").hide();
              $("#formConsultaAsignacion").show();
            });
            $("#cont-table").empty();
            $.each(data,function(s,p){
              $("#cont-table").append("<tr><td id='idDetallekit' name='idDetallekit'>"+p.idDetallekit+"</td><td id='idrecurso' name='idrecurso'>"+p.nombre+"</td><td>"+p.cantidadAsignada +"</td><td id='cantidad' name='cantidad'><input type='number'data-rule-required='true' min='1' class='input_data' id='txtcantidad' name='cantidad' placeholder='Cantidad'/></td><td><button type='button'class=' fa fa-eye btn btn-consultar' name='btnRegistros' OnClick='Redireccionar("+p.idDetallekit+")'></button></td></tr>");
            });

            $('#example tfoot th').each( function () {
              var title = $(this).text();
              $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            });
            var table = $('#example').DataTable({
              "paging": false,
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
                '<option value="20">20</option>' +
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

          });
        }
      }
    }).fail(function(data){
    })
  }


  //Función Registrar Novedad.
  $('#btnRegistrarNovedad').click(function(){
    var form = $("#formRegistroNovedad");
    var valor=form.valid();
    if (valor==true) {
      RegistrarNovedad();
      $('#formRegistroNovedad')[0].reset();
    }else {
      Notificate({
        tipo: 'warning',
        titulo: '¡Advertencia!',
        descripcion: 'Verifica que toda La información esté correcta.',
        duracion: 2
      });
    }
  });

  RegistrarNovedad = function(){
    $.ajax({
      type : 'POST',
      dataTypen: 'json',
      url : url + "Stock/ctrlNovedad/RegistrarNovedad",
      data : new FormData (document.getElementById("formRegistroNovedad")),
      contentType: false,
      processData: false
    }).done(function(){
      Notificate({
        tipo: 'success',
        titulo: 'Éxito',
        descripcion: 'Registro de Novedad Exitoso.',
        duracion: 2
      });
    }).fail(function(){

    })
  }

});

//Abre Modal Novedad
function Redireccionar(id){
  AbrirModal('ModalRegistroNovedad');
  $.ajax({
    url: url+"Stock/ctrlDevolucionNovedad/traerId",
    type:'POST',
    data:{'id':id},
    dataType:'json'
  }).done(function(data){
    $("#txtidDetallekit").val(data.idDetallekit);
  }).fail(function(error){
  });
};

$('.contenedor-btn-registrar').click(function(){
  var cantidad = [];
  var cantidadAsignada = [];
  var idTipoDevolucion = [];
  var idDetallekit = [];
  var idPersona = [];
  var datos = [];

  for(var i=0;i<$("#example tbody tr").length;i++){
    var td = $("#example tbody tr").eq(i).find("td");
    var residuo = td.eq(3).find("input").eq(0).val();
    var cantidadAsignada1 =  td.eq(2).text();
    datos.push({cantidad: td.eq(3).find("input").eq(0).val(), cantidadAsignada: td.eq(2).text(), idRecurso: td.eq(1).text(), idDetallekit: td.eq(0).text(), idPersona: $("#slcidPersonaD").val(),  idTipoDevolucion: $("#slcidTipoDevolucionD").val() });
  }

  if (residuo == null){
    residuo = 0;
  }else {
    residuo = residuo;
  }

  if (residuo <= cantidadAsignada1) {
    RegistrarDevolucion(datos);
  }else {
    Notificate({
      tipo: 'warning',
      titulo: '¡Advertencia!',
      descripcion: 'El Residuo debe ser igual o Menor a la Cantidad Asignada.',
      duracion: 2
    });
  }

})


function RegistrarDevolucion(datos){
  $.ajax({
    type : 'POST',
    dataType: 'json',
    url : url + "Stock/ctrlDevolucionNovedad/RegistrarDevolucion",
    data : {'datos':JSON.stringify(datos)}
  }).done(function(data){
    Notificate({
      tipo: 'success',
      titulo: 'Éxito',
      descripcion: 'Registro de Novedad Exitoso.',
      duracion: 2
    });
    $("#containerTable").hide();
    $("#formRegistroDevolucion").hide();
    $("#formConsultaAsignacion").show();
  }).fail(function(data){
    Notificate({
      tipo: 'error',
      titulo: '¡Error!',
      descripcion: 'Verifica que toda La información esté correcta.',
      duracion:2
    });

  });
}
