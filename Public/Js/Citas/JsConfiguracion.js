$(document).ready(function(){
  $('.select').select2({});
ListarConfi();
ListaTipoCup();
});
$('#btnActualizarCC').click(function(){
  ActualizarDatosConfi();
});

/*
|-----------------------------------------------|
|Función listar tipo cup |
|_______________________________________________|
*/
function ListaTipoCup(){
  select2Codigo();
  select2Descripcion();
}
/*
|-----------------------------------_-_-_-_|
|cancelación de datos  |
|____________________________________-_-_-_|
*/
ValidateForm('frmModalCup', function(formdata) {
});
function ActualizarDatosConfi(){
  $.ajax({
    type: 'POST',
    url: url + "Citas/ctrlConfiguracionCup/ModificarConfiCup",
    data:$("#frmModalCup").serialize()
  }).done(function () {
    if (true) {

    }
    Notificate({
      tipo: 'success',
      titulo: '',
      descripcion: 'Datos Modificados'
    });
  }).fail(function () {
  })
}
function select2Codigo(){
  $('#cmbCodigoCUP').select2({
    placeholder: 'Seleccione una opción',
    ajax: {
      url: url+"Citas/ctrlConfiguracionCup/consultarCodigoCUP",
      dataType: 'json',
      delay: 250,
      type:'POST',
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults: function (data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;

        return {
          results: data.items,
          pagination: {
            more: (params.page * 30) < data.total
          }
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) { return markup; },
    minimumInputLength: 2,
    templateResult: function (data) {
      if (data.loading) return data.text;
      if (data.loading) return data.text;
      var markup = data.codigoCup;
      return markup;
    },
    templateSelection: function (data) {
      return data.codigoCup || data.text;
    }
  });
}

function select2Descripcion(){
  $('#cmbDescripcionCUP').select2({
    placeholder: 'Seleccione una opción',
    ajax: {
      url: url+"Citas/ctrlConfiguracionCup/consultarDescripcionCUP",
      dataType: 'json',
      delay: 250,
      type:'POST',
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults: function (data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;

        return {
          results: data.items
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) { return markup; },
    minimumInputLength: 3,
    templateResult: function (data) {
      if (data.loading) return data.text;

      var markup = data.nombreCup;
      return markup;
    },
    templateSelection: function (data) {
      return data.nombreCup || data.text;
    }
  });
}

function seleccionarCodigoAutomaticamente(select){
  var valor = $(select).val();

  $("#"+select.id+" > option").first().remove();
  $("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
  $("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

  $.ajax({
    url: url+"Citas/ctrlConfiguracionCup/consultarCodigoIdCUP",
    type:"POST",
    data:{
      id:valor
    }
  }).done(function(data){
    $("#cmbCodigoCUP").html("<option selected='select' value='"+valor+"'>"+data+"</option>");
    select2Codigo();
  });
}
function seleccionarDescripcionAutomaticamente(select){
  var valor = $(select).val();
  $("#"+select.id+" > option").first().remove();
  $("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
  $("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

  $.ajax({
    url: url+"Citas/ctrlConfiguracionCup/consultarDescripcionIdCUP",
    type:"POST",
    data:{
      id:valor
    }
  }).done(function(data){
    $("#cmbDescripcionCUP").html("<option selected='select' value='"+valor+"'>"+data+"</option>");
    select2Descripcion();
  });
}
/*
|-----------------------------------------------|
|Función listar tipo configuracion |
|_______________________________________________|
*/

function ListarConfi(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url: url+"Citas/ctrlConfiguracionCup/ListarConfiguracion",
    data:{"":""}
  }).done(function(e){
    $.each(e,function(i,v){
      $('#SltTipoConfi').append('<option value="'+v.idConfiguracion+'">'+v.descripcionConfiguracion+'</option>');
    });
  }).fail(function(){
    console.log('mal');
  })
}
