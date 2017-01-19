$(document).ready(function () {
  var con1 = 0;
  var con2 = 0;

  $('.btn-menu-movil').click(function () {
    if (con1 == 0) {
      $('.menu-maestras').css({
        left: '0%',
        transition: '1s all'
      });
      if (con2 == 0) {
        $('.girar').css({
          transform: 'rotate(360deg)',
          transition: '1s all'
        });
        con2 = 1;
      } else {


        $('.girar').css({
          transform: 'rotate(0)',
          transition: '1s all'
        });
        con2 = 0;
      }
    }


  });


  $('.cerrar-menu-configuracion').click(function () {
    $('.menu-maestras').css({
      left: '-50%',
      transition: '1s all'
    });
  });

});



//FUNCION ANÓNIMA DE CONFIGURACION, PARA LLAMR CUALQUIER FUNCION DENTRO DE ESTA: LLAMAR ASI. Configuracion.Function
var Configuracion = {
  //Se inicializa la function anonima, deben llamar en el footer, ejemplo:  $(document).ready(function(){
  //  Configuracion.init();
  // }); Para poder que les funcione el init
  init: function () {
    //Cuando se inicialice el documento init se desea que de inmediato cargue la tabla dinamica.
    Configuracion.ListadoCIE10();
    Configuracion.ListadoAseguramiento();
    Configuracion.ListadoTriage();
    Configuracion.ListadoTipoAntecedente();
    //Cuando se presione el boton registrarCIE10 Se llama la funcion registrar
    $('#btnRegistrarCIE10').click(function () {
      Configuracion.RegistrarCIE10();
    });
    //Cuando se presione el boton ActualizarCIE10 Se llama la funcion Actualizar
    $('#btnActualizarCIE10').click(function () {
      Configuracion.ActualizarCIE10();
    });
    $('#btnCancelarCIE10').click(function(){
        Configuracion.Restablecer();
    });
    $('#btnRegistrarAse').click(function(){
        Configuracion.RegistrarAseguramiento();
    });
    $('#btnActualizarAse').click(function(){
        Configuracion.ActualizarAseguramiento();
    });
    $('#btnRegistrarTriage').click(function(){
      Configuracion.RegistrarTriage();
    });
    $('#btnActualizarTriage').click(function(){
      Configuracion.ActualizarTriage();
    });
    $('#btnCancelarTriage').click(function(){
        Configuracion.RestablecerTriage();
    });
    $('#btnCancelarAse').click(function(){
      Configuracion.RestablecerAseguramiento();
    });
    $('#btnRegistrarTipoAntecente').click(function(){
      Configuracion.RegistrarTipoAntecedente();
    });
    $('#btnActualizarTipoAntecente').click(function(){
      Configuracion.ActualizarAseguramiento();
    });
    $('#btnCancelarTipoAntecedente').click(function(){
      Configuracion.RestablecerTipoAntecedente();
    });

  },
  //Funcion para registrar CIE10
  RegistrarCIE10: function () {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/RegistrarCie10",
      data: new FormData(document.getElementById("FormCIE10")),
      contentType: false,
      processData: false
    }).done(function () {
      Configuracion.ListadoCIE10();
      Configuracion.Restablecer();
    }).fail(function () {
      alert("ha ocurrido un error");
    });
  },
  //Funcion Para listar los datos de CIE10
  ListadoCIE10: function () {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/ListadoCIE10",
      data: {"": ""}
    }).done(function (e) {
      $('#tbodyCIE10 tr').remove();
      $.each(e, function (l, s) {
        $('#TablaCIE10').append("<tr><th>" + s.idCIE10 + "</th><th>" + s.codigoCIE10 + "</td><th>" + s.descripcionCIE10 + "</th><th><button type='button'  class='btn btn-modificar' onclick=\"Configuracion.PasarDatos('" + s.idCIE10 + "', '" + s.codigoCIE10 + "', '" + s.descripcionCIE10 + "')\">Editar</button></th><th><button type='button' class='btn btn-eliminar' onclick=\"Configuracion.EliminarCIE10('"+s.idCIE10+"')\">Eliminar</button></th></tr>");
      });
    }).fail(function () {

    });
  },
  //Funcion para pasar los datos de la tabla a los input
  PasarDatos: function (id, cod, des) {
    $('#btnRegistrarCIE10').hide();
    $('#btnActualizarCIE10').show();
    $('#btnCancelarCIE10').show();
    $('#idcie10').val(id);
    $('#codigocie10').val(cod);
    $('#descripcioncie10').val(des);
  },
  Restablecer: function () {
    $('#btnRegistrarCIE10').show();
    $('#btnActualizarCIE10').hide();
    $('#idcie10').val("");
    $('#codigocie10').val("");
    $('#descripcioncie10').val("");
    $('#btnCancelarCIE10').hide();
  },
  //Funcion Para actualizar datos de CIE10
  ActualizarCIE10: function () {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/AcualizarCIE10",
      data: new FormData(document.getElementById("FormCIE10")),
      contentType: false,
      processData: false
    }).done(function () {
      Configuracion.ListadoCIE10();
      Configuracion.Restablecer();
    }).fail(function () {
      alert("ha ocurrido un error");
    });
  },
  //Funcion Para Eliminar CIE10
  EliminarCIE10:function(id){
    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/EliminarCIE10",
      data: "idCIE10="+id
    }).done(function () {
      Configuracion.ListadoCIE10();
      Configuracion.Restablecer();
    }).fail(function () {
      alert("ha ocurrido un error");
    });
  },
  RegistrarAseguramiento:function(){
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/RegistrarAseguramiento",
      data: new FormData(document.getElementById("FormAseguramiento")),
      contentType: false,
      processData: false
    }).done(function () {
      Configuracion.ListadoAseguramiento();
      Configuracion.RestablecerAseguramiento();
    }).fail(function () {
      alert("ha ocurrido un error");
    });
  },
    ListadoAseguramiento: function () {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/ListadoAseguramiento",
      data: {"": ""}
    }).done(function (p) {
      $('#tbodyTipoAseguramiento tr').remove();
      $.each(p, function (n, r) {
        $('#TablaAseguramiento').append("<tr><th>" + r.idTipoAseguramiento + "</th><th>" + r.DescripcionTipoAseguramiento + "</th><th><button type='button'  class='btn btn-modificar' onclick=\"Configuracion.PasarDatosAseguramiento('" + r.idTipoAseguramiento + "', '" + r.DescripcionTipoAseguramiento + "')\">Editar</button></th><th><button type='button' class='btn btn-eliminar' onclick=\"Configuracion.EliminarAseguramiento('"+r.idTipoAseguramiento+"')\">Eliminar</button></th></tr>");
      });
    }).fail(function () {

    });
  },
  PasarDatosAseguramiento: function (id, des) {
    $('#btnRegistrarAse').hide();
    $('#btnActualizarAse').show();
    $('#btnCancelarAse').show();
    $('#idase').val(id);
    $('#descripcionaseguramiento').val(des);
  },
  RestablecerAseguramiento: function () {
    $('#btnRegistrarAse').show();
    $('#btnActualizarAse').hide();
    $('#idase').val("");
    $('#descripcionaseguramiento').val("");
    $('#btnCancelarAse').hide();
  },
  ActualizarAseguramiento: function () {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/AcualizarAseguramiento",
      data: new FormData(document.getElementById("FormAseguramiento")),
      contentType: false,
      processData: false
    }).done(function () {
      Configuracion.ListadoAseguramiento();
      Configuracion.RestablecerAseguramiento();
    }).fail(function () {
      alert("ha ocurrido un error");
    });
  },
   EliminarAseguramiento:function(id){
    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/EliminarAseguramiento",
      data: "idAse="+id
    }).done(function () {
      Configuracion.ListadoAseguramiento()();
      Configuracion.RestablecerAseguramiento();
    }).fail(function () {
      alert("ha ocurrido un error");
    });
  },

  RegistrarTriage : function(){
    $.ajax({
      type:'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/RegistrarTriage",
      data: new FormData(document.getElementById("frmTriage")),
      contentType: false,
      processData: false
    }).done(function(){
      Configuracion.ListadoTriage();
      Configuracion.RestablecerTriage();
    }).fail(function(){
      alert("Error");
    });
  },

  ListadoTriage : function (){
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/ListadoTriage",
      data: {"": ""}
    }).done(function (k){
     $('#tbodyTriage tr').remove();
     $.each(k, function (a,j){
      $('#TablaTriage').append("<tr><th>" + j.idTriage + "</th><th>" +j.descripcionTriaje + "</th><th><button type='button' class='btn btn-modificar' onclick=\"Configuracion.PasarDatosTriage('"+ j.idTriage +"', '"+ j.descripcionTriaje +"')\">Editar</button></th><th><button type='button' class='btn btn-eliminar' onclick=\"Configuracion.EliminarTriage('"+j.idTriage+"')\">Eliminar</button></th></tr>");
    });
    }).fail(function (){

    });
   },





    PasarDatosTriage: function(id, des){
     $('#btnRegistrarTriage').hide();
     $('#btnActualizarTriage').show();
     $('#btnCancelarTriage').show();
     $('#idTriage').val(id);
     $('#DescripcionTriage').val(des);
   },

   RestablecerTriage: function (){
     $('#btnRegistrarTriage').show();
     $('#btnActualizarTriage').hide();
     $('#btnCancelarTriage').hide();
     $('#idTriage').val("");
     $('#DescripcionTriage').val("");
   },

   ActualizarTriage: function(){
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/ActualizarTriage",
      data: new FormData(document.getElementById("frmTriage")),
      contentType: false,
      processData: false
    }).done(function (){
      Configuracion.ListadoTriage();
      Configuracion.RestablecerTriage();
    }).fail(function (){
      alert("Error");
    });
   },

    EliminarTriage: function(id){
    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlConfiguracion/EliminarTriage",
      data: "idTria="+id
    }).done(function () {
      Configuracion.ListadoTriage()();
      Configuracion.RestablecerTriage();
    }).fail(function () {
      alert("Error");
    });
   },

   /**
    * ----------------------------------------------------- *
    *           CRUD: Tipo Antecedente                 *
    * ----------------------------------------------------- *
    */
    /*Listar un tipo de antecedente*/
    ListadoTipoAntecedente: function () {
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "ReporteAPH/ctrlConfiguracion/ListadoTipoAntecedente",
        data: {"": ""}
      }).done(function (b) {
        $('#tbodyTipoAntecedente tr').remove();

        $.each(b, function (c, k) {
          $('#tablaTipoAntecedente').append("<tr><th>" + k.idTipoAntecedente + "</th><th>" + k.descripcion + "</th><th><button type='button'  class='btn btn-modificar' onclick=\"Configuracion.PasarDatosTipoAntecedente('" + k.idTipoAntecedente + "', '" + k.descripcion + "')\">Editar</button></th><th><button type='button' class='btn btn-eliminar' onclick=\"Configuracion.EliminarTipoAntecedente('"+k.idTipoAntecedente+"')\">Eliminar</button></th></tr>");
        });
      }).fail(function () {

      });
    },


   /*Registrar un tipo de antencedente*/
   RegistrarTipoAntecedente:function(){
     $.ajax({
       type: 'POST',
       dataType: 'json',
       url: url + "ReporteAPH/ctrlConfiguracion/RegistrarTipoAntecedente",
       data: new FormData(document.getElementById("FormTipoAntecedente")),
       contentType: false,
       processData: false
     }).done(function () {
       Configuracion.ListadoTipoAntecedente();
       Configuracion.RestablecerTipoAntecedente();

     }).fail(function (d) {
       alert("ha ocurrido un error");
console.log(d);
     });
   },

   /*Operaciones varias*/
   PasarDatosTipoAntecedente: function (id, des) {
     $('#btnRegistrarTipoAntecedente').hide();
     $('#btnActualizarTipoAntecedente').show();
     $('#btnCancelarTipoAntecedente').show();
     $('#txtidTipoAntecedente').val(id);
     $('#txtDescripcionTipoAntecedente').val(des);
   },
   /*Operaciones varias*/
   RestablecerTipoAntecedente: function () {
     $('#btnRegistrarTipoAntecedente').show();
     $('#btnActualizarTipoAntecedente').hide();
     $('#txtidTipoAntecedente').val("");
     $('#txtDescripcionTipoAntecedente').val("");
     $('#btnCancelarTipoAntecedente').hide();
   },

   /*Eliminar tipo antecedente*/

   EliminarTipoAntecedente:function(id){
     $.ajax({
       type: 'GET',
       dataType: 'json',
       url: url + "ReporteAPH/ctrlConfiguracion/EliminarTipoAntecedente",
       data: "idTipoAntecedente="+id
     }).done(function () {
       Configuracion.ListadoTipoAntecedente();
       Configuracion.RestablecerTipoAntecedente();
     }).fail(function () {
       alert("ha ocurrido un error");
     });
   },

   /*Actualizar tipo antecedente*/
   ActualizarAseguramiento: function () {
     $.ajax({
       type: 'POST',
       dataType: 'json',
       url: url + "ReporteAPH/ctrlConfiguracion/AcualizarTipoantecedente",
       data: new FormData(document.getElementById("FormTipoAntecedente")),
       contentType: false,
       processData: false
     }).done(function () {
       Configuracion.ListadoAseguramiento();
       Configuracion.RestablecerAseguramiento();
     }).fail(function () {
       alert("ha ocurrido un error");
     });
   },


};
