$(document).ready(function(){
  if (localStorage.getItem('ReporteAPH-Datos') != null) {
     var datos = localStorage.getItem('ReporteAPH-Datos')
     var medi = JSON.parse(datos);
     $('#usuarioMedico').val(medi.usuario);
     $('#claveMedico').val(medi.clave);
     $('#nombreMedico').val(medi.nombreMedico).attr("readonly", true);
     $('#ApellidoMedico').val(medi.apellidoMedico).attr("readonly", true);
     $('#numeroMedico').val(medi.numeroMedico).attr("readonly", true);
     img = document.getElementById("imagenMedico");
     firma = document.getElementById("frmaMedico");
     if (medi.urlFoto) img.src = "../"+medi.urlFoto;
     else img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";
     if (medi.urlFirma) {
       firma.src = "../"+medi.urlFirma;
       mostrarFirma(true);
     }else{
       ocultarFirma(true);
     }
  }else{
  imagenInicial();
  ocultarFirma();
  }
  ListarTipoDocumento();
  $('#btnAutenticar').click(function(){
    ValidarMedicoRecibe();
  });
});


function ocultarFirma(isMedico){
  if (isMedico) {
    $("#registM").css({"display": "none"});
  }else {
    $("#registP").css({"display": "none"});
  }
}

function limiparUser(){
  $('#usuarioMedico').val("");
  $('#claveMedico').val("");
}

$('#btnLimpiarM').click(function(){
  limiparUser();
})

function mostrarFirma(isMedico){
  if (isMedico) {
    $("#registM").css({"display": "block"});
  }else {
    $("#registP").css({"display": "block"});
  }
}


function limparCampos(){
  $('#nombreMedicoR').val("");
  $('#apellidoMedico').val("");
  $('#opTipoDocumento').val("");
  $('#NumeroDocumentoMedico').val("");
  $('#correoMedico').val("");
  $('#limpiarFoto').val("");
  $('#cargarFoto').val("");
}

String.prototype.replaceAll = function(search, replacement) {
  var target = this;
  return target.split(search).join(replacement);
};

function imagenInicial(){
  var img, firma, nombre, apellido, doc, recibe;
  whichWorkMode.then(function (esModoConsulta) {
    if (esModoConsulta) {
      recibe = JSON.parse( localStorage.getItem('ReporteAPH-MedicoRecibe') ) ||  '';
      $("#FechaFinish").html(localStorage.getItem('ReporteAPH-fechaHF').replaceAll('-','/'));
      atiende = JSON.parse( localStorage.getItem('ReporteAPH-ParamedicoAtencion') ) ||  '';

      $("#FechaFinish").html(localStorage.getItem('ReporteAPH-fechaHF').replaceAll('-','/').replaceAll('"',''));

      // Paramedico que atiende
      if (atiende) {
        img = document.getElementById("imagenParamedico");
        if (atiende.urlFoto) img.src = "../"+atiende.urlFoto;
        else img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";

        firma = document.getElementById("frmaParamedico");
        console.log(atiende.urlFirma);
        if (atiende.urlFirma) {
          firma.src = "../"+atiende.urlFirma;
          mostrarFirma(false);
        }else{
          ocultarFirma(false);
        }

        nombre =  $('#nombreParamedico').val(atiende.nombre);
        apellido = $('#ApellidoParamedico').val(atiende.apellido);
        doc = $('#numeroParamedico').val(atiende.documento);
      }else {
        img = document.getElementById("imagenParamedico");
        img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";
        nombre =  $('#nombreParamedico').val("No disponible");
        apellido = $('#ApellidoParamedico').val("No disponible");
        doc = $('#numeroParamedico').val("No disponible");
        ocultarFirma(false);
      }


      // Médico que recibe

      if (recibe) {
        img = document.getElementById("imagenMedico");
        if (recibe.urlFoto) img.src = "../"+recibe.urlFoto;
        else img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";

        firma = document.getElementById("frmaMedico");
        if (recibe.urlFirma) {
          firma.src = "../"+recibe.urlFirma;
          mostrarFirma(true);
        }else{
          ocultarFirma(true);
        }

        nombre =  $('#nombreMedico').val(recibe.nombre);
        apellido = $('#ApellidoMedico').val(recibe.apellido);
        doc = $('#numeroMedico').val(recibe.documento);
      }else {
        img = document.getElementById("imagenMedico");
        img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";
        nombre =  $('#nombreMedico').val("No disponible");
        apellido = $('#ApellidoMedico').val("No disponible");
        doc = $('#numeroMedico').val("No disponible");
        ocultarFirma(true);
      }


    }else {
      img = document.getElementById("imagenMedico");
      img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";
      nombre =  $('#nombreMedico').val("XXXXXXXXXXXXXX");
      apellido = $('#ApellidoMedico').val("XXXXXXXXXXXXXX");
      doc = $('#numeroMedico').val("XXXXXXXXXXXXX");
      ocultarFirma(true);
    }
  }, function (err) {
    alert('No se pudó obtener el modo de trabajo.');
  });
}


ListarTipoDocumento = function(){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "ReporteAPH/ctrlResultadosAtencion/ListarTipoDocumento"
  }).done(function(a){
    $.each(a, function(b,c){
      $('#opTipoDocumento').append("<option value='"+c.idTipoDocumento+"'>"+c.descripcionTdocumento+"</option>");
    });
  }).fail(function(){

  });
};



//RegistrarMedicoRecibe
ValidateForm('frmMedicoRecibe', function(formdata){
  $.ajax({
    type : 'POST',
    dataTypen: 'json',
    url : url + "ReporteAPH/ctrlResultadosAtencion/RegistrarMedicoRecibe",
    data : new FormData ($("#frmMedicoRecibe")[0]),
    contentType: false,
    processData: false
  }).done(function(data){
    if (data != 3) {
      $(".usuarioCheck").removeClass("checkTipoEvento");
      $(".passwordCheck").removeClass("checkTipoEvento");
      limparCampos();
      Notificate({
        tipo: 'success',
        titulo: 'Registro Exitoso',
        descripcion: 'Se ha Registrado Exitosamente.'
      });
      $('#btnRegistrar').hide();
      CerrarModal($("#modalMedico"));

    }else if (data ==3){
      Notificate({
          tipo: 'error',
          titulo: 'Error',
          descripcion: 'Ha ocurrido un error al intentar registrarse.',
          duracion: 3
      });

    }
  }).fail(function(){
    Notificate({
      tipo: 'error',
      titulo: 'Error',
      descripcion: 'No se pudo registrar.'
    });
  });
});

function ValidarMedicoRecibe(){
  var usuario = $("#usuarioMedico").val();
  var clave = $("#claveMedico").val();
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url + "ReporteAPH/ctrlResultadosAtencion/ValidarMedicoRecibe",
    data : {'txtUsuarioAutentificacion':usuario, 'txtClaveAutentificacion':clave},
  }).done(function(data){
    if (data=='1') {
      Notificate({
          tipo: 'error',
          titulo: 'Error',
          descripcion: 'No se encuentra en el sistema.',
          duracion: 3
      });
    }else{
      $(".usuarioCheck").removeClass("checkTipoEvento");
      $(".passwordCheck").removeClass("checkTipoEvento");

      $.each(data, function(indice,valor){

        var nombreMedico = valor.primerNombre;
        $('#nombreMedico').val(nombreMedico).attr("readonly", true);
        var apellidoMedico = valor.primerApellido;
        $('#ApellidoMedico').val(apellidoMedico).attr("readonly", true);
        var numeroMedico = valor.numeroDocumento;
        $('#numeroMedico').val(numeroMedico).attr("readonly", true);
        var Persona = valor.idPersona;
        localStorage.setItem("ReporteAPH-MedicoRecibe", JSON.stringify(Persona));
        var firma = document.getElementById("frmaMedico");
        var img = document.getElementById("imagenMedico");
        if (valor.urlFoto === null) {
          img.src = "../Public/Img/ReporteAPH/usuarioVacio.jpeg";
        }else{
          img.src = "../"+valor.urlFoto;
        }
        if (valor.urlFirma === null) {
          $('#regist').hide();
          ocultarFirma(true);
        }else{
          firma.src = "../"+valor.urlFirma;
          mostrarFirma(true);
        }

        var medico = {
        usuario,
        clave,
        nombreMedico,
        apellidoMedico,
        numeroMedico,
        firma,
        img
        }
        localStorage.setItem('ReporteAPH-Datos', JSON.stringify(medico));

      });
    }
  }).fail(function(){
    Notificate({
      tipo: 'error',
      titulo: 'Error',
      descripcion: 'Ha ocurrido un error.'
    });
  });
}

$('#NumeroDocumentoMedico').blur(function(){
  ConsultarPersona();
  consultarNPersona();
})



function consultarNPersona(){
    var numeroDocu =$('#NumeroDocumentoMedico').val();
    $.ajax({
      type: 'POST',
      dataType:'json',
      url: url + "ReporteAPH/ctrlResultadosAtencion/consultarNPersona",
      data : {'txtNumeroNumeroDocumento':numeroDocu},
    }).done(function(data){
      if (data == 1){
        $('#NumeroDocumentoMedico').val("");
        Notificate({
          tipo: 'info',
          titulo: 'Advertencia',
          descripcion: 'Ya existe una persona con este número de documento. No es posible registrarse.'
        });
        CerrarModal($("#modalMedico"));
      }
      // else{
      //   console.log(data);
      // }
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'No es posible conectarse al servidor.'
      });
    })
}

function ConsultarPersona(){
  var numeroDoc =$('#NumeroDocumentoMedico').val();
  $.ajax({
    type: 'POST',
    dataType:'json',
    url: url + "ReporteAPH/ctrlResultadosAtencion/ConsultarPersona",
    data : {'txtNumeroNumeroDocumento':numeroDoc},
  }).done(function(data){
    if (data != null) {
      $(".usuarioCheck").removeClass("checkTipoEvento");
      $(".passwordCheck").removeClass("checkTipoEvento");
        $('#NumeroDocumentoMedico').val("");
      CerrarModal($("#modalMedico"));
      $.each(data,function(indice, valor) {
        var usuario = valor.correoElectronico;
        $('#usuarioMedico').val(usuario);
        var clave = valor.numeroDocumento;
        $('#claveMedico').val(clave);
      })
      }
    }).fail(function(){
    console.log("Error");
  })
}
