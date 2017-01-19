$(document).ready(function(){
  ListaTipoZona();
  $('.select').select2({});
  $('input').keypress(function(e){
    if (e.keyCode==13) {
      $("#SgteCita").click();
    }
  });
  $("#AntCita").hide();
  $("#part2").hide();
  $("#part3").hide();
  $("#part4").hide();
  $("#part5").hide();
  $("#part6").hide();
  $("#part7").hide();
});
var medicos=[];
var enfermerosJefe=[];
var auxEnfermeria=[];

let contadorJefenfermeros=0;
let contadorAuxenfermeria=0;
let contadorMedicos=0;

var nombresmedicos=[];
var nombresenfermerosJefe=[];
var nombresauxEnfermeria=[];

let controlPaso=0;
//fin document ready-------------------------------
var contenido=$("#part1");
/*
|-----------------------------------_-_-_-_|
|Confirmación de datos y consulta de datos |
|____________________________________-_-_-_|
*/

ValidateForm('formDatosPaciente', function(formdata) {
  ConfirmacionDatos(formdata);
});

/*
|-----------------------------------|
|Información del paciente           |
|___________________________________|
*/
let repuestaCampos=false;
$(".infoP").change(function(){
  repuestaCampos=true;
});
ValidateForm('formInfoPaciente', function(formdata) {
  if (repuestaCampos==true) {
    ActualizarDatosPaciente();
    repuestaCampos=false;
  }
  citasExistentes(formdata);
});
function citasExistentes(formdata){
  let infoLocalStorage=JSON.parse(localStorage.getItem("InformacionPaciente"));
  var EstadoPaciente=infoLocalStorage.Estado;
  var idPaciente=infoLocalStorage.idPac;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/ctrlCitas/ConsultarCitasAsignadas",
    data:{idPac:idPaciente}
  }).done(function(data){
    let citasAsignadas=JSON.parse(data[0]).Citas_Asignadas;
    citasAsignadas=parseInt(citasAsignadas);
    if (citasAsignadas==0 || isNaN(citasAsignadas)) {

      if (atob(EstadoPaciente)=="Activo") {
        AsignarMoraPaciente($("#txtDocumento1").val());
        localStoragePaciente(formdata);
      }
      else if(atob(EstadoPaciente)=="Inactivo"){
        Notificate({
          titulo: 'Advertencia',
          descripcion: 'El paciente se encuentra en un estado inactivo',
          tipo: 'warning',
          duracion: 4
        });
      }
      else {
        Notificate({
          titulo: 'Ha ocurrido un error',
          descripcion: 'El estado del paciente no es permitido para registrar la cita.',
          tipo: 'error',
          duracion: 1
        });
        Notificate({
          titulo: 'Dias restantes',
          descripcion: 'El paciente cuenta con<b>'+data[1]+'</b> dias de multa.',
          tipo: 'warning',
          duracion: 2
        });
      }
    }else {
      Notificate({
        titulo: 'Advertencia',
        descripcion: 'El paciente ya tiene citas asignadas.',
        tipo: 'warning',
        duracion: 4
      });
    }
  });
}
/*

|-----------------------------------|
|Información de la cita             |
|___________________________________|
*/
ValidateForm('formCita', function(formdata) {
  var config=JSON.parse(localStorage.getItem("config"));
  var Paciente=JSON.parse(localStorage.getItem("InformacionPaciente"));
  let configDia=parseInt(atob(config.ConfigDia));
  let configMes=parseInt(atob(config.ConfigMes));
  var pacienteDia=parseInt(atob(Paciente.CitasXdiaPaciente));
  var pacienteMes=parseInt(atob(Paciente.CitasXmesPaciente));
  if (pacienteDia<=configDia) {
    if (pacienteMes<=configMes) {
      var tel1=formdata.txtTelefonoUno;
      var extTel1 = formdata.txtExtTelefonoCita1;
      var tel2=formdata.txtTelefonoDos;
      var extTel2=formdata.txtExtTelefonoCita2;
      var barrioCita=formdata.SltBarrio;
      var direcccionCita=formdata.txtDireccionCita;
      var tipoCita=formdata.cmbCodigoCUP;
      var barrioNombre = $("#SltBarrio option:selected").html();
      //----------------------------------------------
      if (extTel1!="") {
        tel1=tel1+"-"+extTel1;
      }
      if (extTel2!="") {
        tel2=tel2+"-"+extTel2;
      }
let datosCita=JSON.parse(localStorage.getItem("infoCita"));
    if (datosCita!=null) {
    var hora=datosCita.horaCita;
    var infoCita2=
    {"txtTelefonoUno":btoa(tel1),
    "txtTelefonoDos":btoa(tel2),
    "SltBarrio":btoa(barrioCita),
    "txtDireccionCita":btoa(direcccionCita),
    "barrioNombre":btoa(barrioNombre),
    "SltTipoCita":btoa(tipoCita),
    "diaSemana":"",
    "horaCita":hora,
    "diaCita":""
  };
  localStorage.setItem("infoCita",JSON.stringify(infoCita2));
}else {
      var infoCita=
      {"txtTelefonoUno":btoa(tel1),
      "txtTelefonoDos":btoa(tel2),
      "SltBarrio":btoa(barrioCita),
      "txtDireccionCita":btoa(direcccionCita),
      "barrioNombre":btoa(barrioNombre),
      "SltTipoCita":btoa(tipoCita),
      "diaSemana":"",
      "horaCita":"",
      "diaCita":""
    };
    localStorage.setItem("infoCita",JSON.stringify(infoCita));
  }

    SectionWizard();
  }else {
    Notificate({
      titulo: 'Ha ocurrido un error',
      descripcion: 'El paciente no puede asignar más citas en este mes.',
      tipo: 'error',
      duracion: 4
    });
  }
}else{
  Notificate({
    titulo: 'Ha ocurrido un error',
    descripcion: 'El paciente no puede asignar más citas en este día.',
    tipo: 'error',
    duracion: 4
  });
}
});
/*
|-----------------------------------|
|Registro de la cita                |
|___________________________________|
*/
ValidateForm('frmC', function(formdata) {
  var sect=$('.turnoSel').text();
  if (sect!="") {
    let datos=JSON.parse(localStorage.getItem("infoCita"));
    let daySem=$(".turnoSel").attr("daysemana");
    let diaCita=$(".turnoSel").attr("diacita");
    var infoCita=
    {"txtTelefonoUno":datos.txtTelefonoUno,
    "txtTelefonoDos":datos.txtTelefonoDos,
    "SltBarrio":datos.SltBarrio,
    "txtDireccionCita":datos.txtDireccionCita,
    "barrioNombre":datos.barrioNombre,
    "SltTipoCita":datos.SltTipoCita,
    "diaSemana":btoa(daySem),
    "horaCita":datos.horaCita,
    "diaCita":btoa(diaCita)
  };
  localStorage.setItem("infoCita",JSON.stringify(infoCita));
  ConsultarMedicos(1);
  //aca
  ConsultarEnferJefe();
  ConsultarAuxEnfermeria();

}else{
  $(".rdo_tabla label").addClass("errorSelected");
  Notificate({
    titulo: 'Advertencia',
    descripcion: 'Por favor, seleccione un turno.',
    tipo: 'warning',
    duracion: 4
  });
}
});
/*
|----------------------------|
|Consulta de médicos         |
|____________________________|
*/
ValidateForm('formPersonalMedico', function(formdata) {
  if (contadorMedicos>0) {
    SectionWizard();
  }else{
    $(".CktblMedicos").addClass("errorSelected");
    Notificate({
      titulo: 'Advertencia',
      descripcion: 'Por favor, seleccione al menos un médico.',
      tipo: 'warning',
      duracion: 4
    });
  }
});
/*
|----------------------------|
|Consulta de enfermeros jefe |
|____________________________|
*/
ValidateForm('frmPersonalJefeEnfermeros', function(formdata) {
  nombresenfermerosJefe=[];
  contadorJefenfermeros=0;
  enfermerosJefe=[];
  $('.tblEnfJefe:checked').each(
        function() {
            let val =$(this).val();
            enfermerosJefe.push(val);
            contadorJefenfermeros++;
            let nombresAux= $(this).attr("nombre");
            nombresenfermerosJefe.push(nombresAux);
      }
    );
  //console.log(nombresenfermerosJefe+" - "+contadorJefenfermeros+" - "+enfermerosJefe);
  SectionWizard();
});
/*
|----------------------------|
|Consulta de aux enfermeria  |
|____________________________|
*/
ValidateForm('frmAxuEnfermeria', function(formdata) {
  nombresauxEnfermeria=[];
  contadorAuxenfermeria=0;
  auxEnfermeria=[];
  $('.tblAuxEnferm:checked').each(
        function() {
            let val =$(this).val();
            auxEnfermeria.push(val);
            contadorAuxenfermeria++;
            let nombresAux=$(this).attr("nombre");
            nombresauxEnfermeria.push(nombresAux);
      }
    );
  //console.log(nombresauxEnfermeria+" - "+contadorAuxenfermeria+" - "+auxEnfermeria);
  var datos=JSON.parse(localStorage.getItem("InformacionPaciente"));
  let EstadoP=atob(datos.Estado);
  if (EstadoP=="Activo") {
    if (contadorAuxenfermeria>0 || contadorJefenfermeros>0) {
      $(".CktblEnfJefe").removeClass("errorSelected");
      $(".CktblAuxEnferm").removeClass("errorSelected");

      formdata=agregarDatos(formdata);
      DoPostAjax({
        url: 'Citas/ctrlCitas/RegistrarCita',
        data: formdata
      }, function(err, data) {
        if (err) {
          Notificate({
            titulo: 'Ha ocurrido un error',
            descripcion: 'Error inesperado al enviar la información, por favor intentelo nuevamente',
            tipo: 'error',
            duracion: 4
          });
        } else {
          if (data=="true") {
            regDetailCita_Programacion();
            informCita();
            $('#SgteCita').attr('submit-form','formFinal');
            Notificate({
              tipo: 'success',
              titulo: 'Registro exitoso.',
              descripcion: 'Se ha registrado la cita con éxito.',
              duracion: 4
            });
            //setTimeout('document.location.reload()',30000);
            //swal({title: "¡Éxito!",text:"Se ha registrado la cita exitosamente.",type: "success",confirmButtonClass: "btn-success",});
          }else{
            Notificate({
              titulo: 'Ha ocurrido un error',
              descripcion: 'No se ha podido registrar la cita, por favor verifica los campos.',
              tipo: 'error',
              duracion: 4
            });
          }
        }
      });
    }else{
      $(".CktblEnfJefe").addClass("errorSelected");
      $(".CktblAuxEnferm").addClass("errorSelected");
      Notificate({
        titulo: 'Advertencia',
        descripcion: 'Por favor, seleccione al menos un auxiliar o un enfermer@ jefe.',
        tipo: 'warning',
        duracion: 4
      });
    }
  }else{
    Notificate({
      titulo: 'Ha ocurrido un error',
      descripcion: 'El estado del paciente no es permitido para registrar la cita.',
      tipo: 'error',
      duracion: 4
    });
  }
});
/*
|----------------------------|
|Funcionamiento wizard       |
|____________________________|
*/
$("#SgteCita").click(function(){
  let target = $(this).attr('submit-form');
  if (target!="formFinal") {
    $('#'+target).submit();
  }else{
    setTimeout('document.location.reload()',1500);
  }
});

function SectionWizard(){
  $("#SgteCita").attr("disabled",true);
  setTimeout(function deshabilitar() {
     $("#SgteCita").removeAttr("disabled",false);
  },1000);
  $(contenido).slideToggle(function(){
    //alert($('#SgteCita').attr('submit-form'));
    if (contenido.attr("id")=="part1")
    {
      $('#SgteCita').attr('submit-form','formInfoPaciente');
      $("#AntCita").show();
      contenido=$("#part2");
      $(contenido).slideToggle();
    }else
    if (contenido.attr("id")=="part2") {
      $('#SgteCita').attr('submit-form','formCita');
      contenido=$("#part3");
      $(contenido).slideToggle();
    }else if (contenido.attr("id")=="part3") {
      $('#SgteCita').attr('submit-form','frmC');
      contenido=$("#part4");
      $(contenido).slideToggle();
    }else if (contenido.attr("id")=="part4") {
      $('#SgteCita').attr('submit-form','formPersonalMedico');
      contenido=$("#part5");
      $(contenido).slideToggle();
    }else if (contenido.attr("id")=="part5") {
      $('#SgteCita').attr('submit-form','frmPersonalJefeEnfermeros');
      contenido=$("#part6");
      $(contenido).slideToggle();
    }else if (contenido.attr("id")=="part6") {
      $('#sgt').removeClass('fa-long-arrow-right');
      $('#sgt').addClass('fa-floppy-o');
      $('#SgteCita').attr('submit-form','frmAxuEnfermeria');
      contenido=$("#part7");
      $(contenido).slideToggle();
    }
  });
}
$("#AntCita").click(function(){
  $("#AntCita").attr("disabled",true);
  setTimeout(function deshabilitar() {
     $("#AntCita").removeAttr("disabled",false);
  },1000);
  $(contenido).slideToggle(function(){
    if (contenido.attr("id")=="part7") {
      $('#sgt').removeClass('fa-floppy-o');
      $('#sgt').addClass('fa-long-arrow-right');
      $('#SgteCita').attr('submit-form','frmPersonalJefeEnfermeros');
      contenido=$("#part6");
      $(contenido).slideToggle();
    }else
    if (contenido.attr("id")=="part6") {
      $('#SgteCita').attr('submit-form','formPersonalMedico');
      contenido=$("#part5");
      $(contenido).slideToggle();
    }else
    if (contenido.attr("id")=="part5") {
      $('#SgteCita').attr('submit-form','frmC');
      contenido=$("#part4");
      $(contenido).slideToggle();
    }else
    if (contenido.attr("id")=="part4") {
      $('#SgteCita').attr('submit-form','formCita');
      contenido=$("#part3");
      $(contenido).slideToggle();
    }
    else if (contenido.attr("id")=="part3") {
      $('#SgteCita').attr('submit-form','formInfoPaciente');
      contenido=$("#part2");
      $(contenido).slideToggle();
    }else if (contenido.attr("id")=="part2") {
      $('#SgteCita').attr('submit-form','formDatosPaciente');
      contenido=$("#part1");
      $("#AntCita").hide();
      $(contenido).slideToggle();
    }
  });
});
function ConfirmacionDatos(formdata){
  DoPostAjax({
    url: 'Citas/ctrlCitas/ConfirmacionDatos',
    data: formdata
  }, function(err, data) {
    if (err) {
      Notificate({
        titulo: 'Ha ocurrido un error',
        descripcion: 'Error con la confirmación de datos',
        tipo: 'error',
        duracion: 4
      });
    } else {
      if (data!='null') {
        let informacionPaciente = JSON.parse(data);
        cargarDatos(informacionPaciente);
        SectionWizard();
      }else{
        console.log(data);
        Notificate({
          titulo: 'Ha ocurrido un error',
          descripcion: 'El paciente no se encuentra registrado.',
          tipo: 'error',
          duracion: 4
        });
      }
    }
  });
}
/*
|----------------------------|
|Lista de tipo de zona       |
|____________________________|
*/
function ListaTipoZona(){
  DoPostAjax({
    url: "Citas/CtrlCitas/ListarTipoZona"
  }, function(err, data) {
    if (err) {
      Notificate({
        titulo: 'Ha ocurrido un error',
        descripcion: 'Error con la lista de los tipo de zona.',
        tipo: 'error',
        duracion: 4
      });
    } else {
      let respuesta=JSON.parse(data);
      $("#SltComuna").html("<option value='-1'>Seleccione una comuna.</option>");

      for (var val in respuesta) {
        $("#SltComuna").append("<option value='"+respuesta[val].idTipoZona+"'>"+respuesta[val].descripcionTipozona+"</option>");
      }
    }
  });
}
function AsignarMoraPaciente(documento){
  $.ajax({
    type:'POST',
    url : url+"Citas/CtrlCitas/AsignarMoraPaciente",
    data : {'documento':documento}
  }).done(function(data){
    if(data=="0"){
      Notificate({
        tipo: 'warning',
        titulo: 'Ha ocurrido un error.',
        descripcion: 'El Paciente tiene registrado una mora.'
      });
    }else{
      SectionWizard();
    }
  }).fail(function(){
    Notificate({
      tipo: 'success',
      titulo: '',
      descripcion: 'Puede registrar una cita'
    });
  });
}

/*
|-----------------------------------_-_-_-_---------------|
|Función para consultar los médicos disponibles en el     |
|horarios seleccionado por el usuario                     |
|____________________________________-_-_-_---------------|
*/
function ConsultarMedicos(option){
  var datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita= datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultarMedicos",
    data:{Cita_Dia:dayCita,Cita_Hour:hour}
  }).done(function(data){
    if (data!=null) {
      if (option==1) {
        let id=$(".medicos").attr('id');
        informacionPersonalA(data,id);
        SectionWizard();
      }
    }else{
      Notificate({
        titulo: 'Aviso.',
        descripcion: 'No hay médicos disponibles.',
        tipo: 'warning',
        duracion: 4
      });
    }
  }).fail(function(data){
    console.log('entre al fail');
  });
}
//mostrar turno en el calendario
function mostrarTurno() {
  $(".rdo_tabla label").removeClass("errorSelected");
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/dateActual"
  }).done(function(data){
    let hora=parseInt(data.horaA)+4;
    let diaActual=parseInt(data.day);
    $(".turnoSel").html("");
    $(".calendario-dias").removeClass("contSelect");
    var check=$(".micheck:checked").attr("id");
    var valorcheck=datoRadio();
    var horaSeleccionada=parseInt(valorcheck);
    datos=JSON.parse(localStorage.getItem("infoCita"));
    var infoCita=
    {"txtTelefonoUno":datos.txtTelefonoUno,
    "txtTelefonoDos":datos.txtTelefonoDos,
    "SltBarrio":datos.SltBarrio,
    "txtDireccionCita":datos.txtDireccionCita,
    "barrioNombre":datos.barrioNombre,
    "SltTipoCita":datos.SltTipoCita,
    "diaSemana":datos.diaSemana,
    "horaCita":btoa(valorcheck),
    "diaCita":datos.diaCita
  };
  localStorage.setItem("infoCita",JSON.stringify(infoCita));
  let diaSemana=atob(datos.diaSemana);
  let diaCita=atob(datos.diaCita);
  var dato=atob(datos.diaCita);
  var diaSeleccionado=parseInt(diaCita);
  if (diaActual==diaSeleccionado) {
    if (hora<horaSeleccionada) {
      $("#CAL"+dato).addClass("contSelect");
      $(".controlT").html("");
      $(".SelT"+dato).html("<span class='turnoSel ' daySemana='"+diaSemana+"' diaCita='"+diaCita+"' turn='"+check+"'>"+valorcheck+"</span>");
      ConsultarMedicos(0);
    }else{
      Notificate({
        titulo: 'Información',
        descripcion: 'Para asignar una cita el mismo día, debe ser con 4 horas de anticipación.',
        tipo: 'info',
        duracion: 5
      });
    }
  }else{
    $("#CAL"+dato).addClass("contSelect");
    $(".controlT").html("");
    $(".SelT"+dato).html("<span class='turnoSel horizontal_padding' daySemana='"+diaSemana+"' diaCita='"+diaCita+"' turn='"+check+"'>"+valorcheck+"</span>");
    ConsultarMedicos(0);
  }
});
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para el registro del detalle cita_programación   |
|____________________________________-_-_-_---------------|
*/
/*Consulta del id de la programación que pertenece al turnos
que se se eligió*/
function regDetailCita_Programacion(){
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/registroDetail",
    data:{Medicos:medicos,EnfermeroJefe:enfermerosJefe,AuxEnfermeria:auxEnfermeria}
  }).done(function(dataDetail){
    medicos="";
    enfermerosJefe="";
    auxEnfermeria="";
  });
}

function informCita(){
  var datosCita=JSON.parse(localStorage.getItem("infoCita"));
  var datosPaciente=JSON.parse(localStorage.getItem("InformacionPaciente"));
  let diaCita=atob(datosCita.diaSemana);
  let telefono=atob(datosCita.txtTelefonoUno);
  let barrioCita=atob(datosCita.barrioNombre);
  let directCita=atob(datosCita.txtDireccionCita);
  let hora=atob(datosCita.horaCita);
  let descripcionServicio=$( "#cmbDescripcionCUP option:selected" ).text();

  //----------------------------------------
  let pNombreP=atob(datosPaciente.PrimerNombre);
  let sNombreP=atob(datosPaciente.PrimerApellido);
  var nombreCompleto=pNombreP+" "+sNombreP;
  if (nombresenfermerosJefe=="") {
    nombresenfermerosJefe="Ninguno";
  }else if(nombresauxEnfermeria==""){
    nombresauxEnfermeria="Ninguno";
  }
  //console.log("medicos="+nombresmedicos+"enfer="+nombresenfermerosJefe+"aux="+nombresauxEnfermeria);
  $("#reporte_cita").html();
  $(".encabezado_informe").append('<span class="">'+diaCita+'</span>');
  $(".bodyInform").append('<span class="reporteCita"><h5 class="sub_reporte">Servicio:</h5>'+descripcionServicio+'</span>');
  $(".informepart1").append('<span class="reporteCita"><h5 class="sub_reporte">Paciente:</h5>'+nombreCompleto+'</span>');
  $(".informepart1").append('<span class="reporteCita"><h5 class="sub_reporte">Barrio:</h5>'+barrioCita+'</span>');
  $(".informepart1").append('<span class="reporteCita"><h5 class="sub_reporte">Teléfono:</h5>'+telefono+'</span>');
  $(".informepart1").append('<span class="reporteCita"><h5 class="sub_reporte">Jefes en enfermería:</h5>'+nombresenfermerosJefe.toString()+'</span>');
  $(".informepart2").append('<span class="reporteCita"><h5 class="sub_reporte">Hora:</h5>'+hora+'</span>');
  $(".informepart2").append('<span class="reporteCita"><h5 class="sub_reporte">Dirección:</h5>'+directCita+'</span>');
  $(".informepart2").append('<span class="reporteCita"><h5 class="sub_reporte">Médicos:</h5>'+nombresmedicos.toString()+'</span>');
  $(".informepart2").append('<span class="reporteCita"><h5 class="sub_reporte">Auxiliares en Enfermería:</h5>'+nombresauxEnfermeria.toString()+'</span>');

  AbrirModal('modalInformeCitas');
}



function localStoragePaciente(formdata){
  var EstadoP=formdata.SltEstadoPaciente;
  var estadoDescrip=$('#SltEstadoPaciente').text();
  var BarrioP=formdata.txtBarrioResidencia;
  var CiudadP=formdata.txtCiudadResidencia;
  var CorreoP=formdata.txtCorreo;
  var DireccionP=formdata.txtDireccion;
  var Ext=formdata.txtExtTelefonoCita3;
  var pApellidoP=formdata.txtPrimerApellido;
  var pNombreP=formdata.txtPrimerNombre;
  var sApellidoP=formdata.txtSegundoApellido;
  var sNombreP=formdata.txtSegundoNombre;
  var TelP1=formdata.txtTelefono;
  var CelP=formdata.txtTelefonoCelular;
  var idP=formdata.txtidPaciente;
  $(".NombrePaciente").html(pNombreP+" "+pApellidoP);
  if (Ext!="") {
    TelP1=TelP1+"-"+Ext;
  }else {
    TelP1=TelP1;
  }

  var datos=JSON.parse(localStorage.getItem("InformacionPaciente"));
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/ctrlCitas/ConsultarCitasDelDia",
    data:{idPac:datos.idPac}
  }).done(function(dataDias){
    var citasXdiaPaciente=dataDias.Cantidad_Citas_Dia;
    var citasXmesPaciente;
    $.ajax({
      type: 'POST',
      dataType:'JSON',
      url: url+ "Citas/ctrlCitas/ConsultarCitasDelMes",
      data:{idPac:datos.idPac}
    }).done(function(dataMes){
      citasXmesPaciente=dataMes.Cantidad_Citas_Mes;
      var infoPaciente=
      {
        "Estado":btoa(estadoDescrip),
        "Barrio":btoa(BarrioP),
        "Ciudad":btoa(CiudadP),
        "Correo":btoa(CorreoP),
        "Direccion":btoa(DireccionP),
        "PrimerApellido":btoa(pApellidoP),
        "PrimerNombre":btoa(pNombreP),
        "SegundoApellido":btoa(sApellidoP),
        "SegundoNombre":btoa(sNombreP),
        "Telefono":btoa(TelP1),
        "Celular":btoa(CelP),
        "idPac":datos.idPac,
        "CitasXdiaPaciente":btoa(citasXdiaPaciente),
        "CitasXmesPaciente":btoa(citasXmesPaciente)
      }
      localStorage.setItem("InformacionPaciente",JSON.stringify(infoPaciente));
    });
  });
}



function validarCheck(este){
  let datoR=$(este).attr("class");
  var marcado = $(este).prop("checked");
  var val=$(este).val();

  if (datoR=="tblMedicos") {
    $(".CktblMedicos").removeClass("errorSelected");
    nombresmedicos=[];
    contadorMedicos=0;
    medicos=[];
    $('.tblMedicos:checked').each(
          function() {
            let val =$(this).val();
            medicos.push(val);
            contadorMedicos++;
            let nombresM=$(this).attr("nombre");
            nombresmedicos.push(nombresM);
        }
      );
      //console.log("Nombres:"+nombresmedicos+"conador:"+contadorMedicos+"turnos:"+medicos);
      if (contadorMedicos>0) {
        sugerenciaEnfermerosJefe();
        ConsultarEnferJefe();
        sugerenciaAuxiliarEnfermeria();
      }
  }else if(datoR=="tblEnfJefe" || datoR=="tblAuxEnferm"){
    $(".CktblEnfJefe").removeClass("errorSelected");
    $(".CktblAuxEnferm").removeClass("errorSelected");
  }

if (datoR=="tblMedicos") {

$(".CktblMedicos").removeClass("errorSelected");

}else if(datoR=="tblEnfJefe"){
$(".CktblAuxEnferm").removeClass("errorSelected");
$(".CktblEnfJefe").removeClass("errorSelected");
if (marcado==false) {
  $("#programEnferm"+val).removeClass("contSel");
  $(".changeColorEnf"+val).css({'color':'#555555'});
}else {
  $("#programEnferm"+val).addClass("contSel");
  $(".changeColorEnf"+val).css({'color':'#FFFFFF'});
}

}else{
$(".CktblAuxEnferm").removeClass("errorSelected");
$(".CktblEnfJefe").removeClass("errorSelected");
if (marcado==false) {
  $("#programAux"+val).removeClass("contSel");
  $(".changeColorAux"+val).css({'color':'#555555'});
}else {
  $("#programAux"+val).addClass("contSel");
  $(".changeColorAux"+val).css({'color':'#FFFFFF'});
}

}
}



function sugerenciaEnfermerosJefe() {
  var datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
$.ajax({
  type: 'POST',
  dataType:'JSON',
  url: url+ "Citas/CtrlCitas/sugerenciaEnfermerosJefe",
  data:{'MED':medicos,Cita_Dia:dayCita,Cita_Hour:hour}
}).done(function(data){
  if (data!=null) {
  $("#sugerenciaEnf").html("");
  $.each(data,function(s,p){
  $("#sugerenciaEnf").append("<li class='list_item sgrEnfermeria'style='width: 100% !important'>"
    +" <div class='list_item_header n_flex n_nowrap'>"
    +" <div class='item_icon n_flex n_align_center'>"
    +"<span class='fa fa-user-md'></span>"
    +   "</div>"
    +   "<div class='item_title n_grow_up horizontal_padding ovf_hidden contSuge' onclick='SeleccionSugPerEnf("+p.IdTProgramacion+",1)' ondblclick='DesSeleccionSugPerEnf("+p.IdTProgramacion+",1)' id='programEnferm"+p.IdTProgramacion+"'style=' padding-top: 7px;'>"
    +       "<span class='text_bold suspensive changeColorEnf"+p.IdTProgramacion+"' style='color:#555555' >"+p.PNmbre+" "+p.PApellido+"</span>"
    +    " </div>"
    +   "</div>"
    +"</li>"
  );
  });
}else {
  $("#personalEnfer").hide();
$("#sugerenciaEnf").html("<div>No existen sugerencias con este médico.</div>");
}

}).fail(function(data){

});
}

$("#personalEnfer").click(function() {
AddContent();
});
$("#personalAux").click(function() {
AddContent();
});

function sugerenciaAuxiliarEnfermeria() {
  var datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
$.ajax({
  type: 'POST',
  dataType:'JSON',
  url: url+ "Citas/CtrlCitas/sugerenciasAuxiliarEnfermeria",
  data:{'MED':medicos,Cita_Dia:dayCita,Cita_Hour:hour}
}).done(function(data){
if (data!=null) {
  $("#sugerenciaAux").html("");
  $.each(data,function(s,p){
  $("#sugerenciaAux").append("<li class='list_item sgrEnfermeria'style='width: 100% !important'>"
    +" <div class='list_item_header n_flex n_nowrap'>"
    +" <div class='item_icon n_flex n_align_center'>"
    +"<span class='fa fa-user-md'></span>"
    +   "</div>"
    +   "<div class='item_title n_grow_up horizontal_padding ovf_hidden contSuge' onclick='SeleccionSugPerEnf("+p.IdTProgramacion+",2)' ondblclick='DesSeleccionSugPerEnf("+p.IdTProgramacion+",2)' id='programAux"+p.IdTProgramacion+"' style=' padding-top: 7px;'>"
    +       "<span class='text_bold suspensive changeColorAux"+p.IdTProgramacion+" ' style='color:#555555;'>"+p.PNmbre+" "+p.PApellido+"</span>"
    +    " </div>"
    +   "</div>"
    +"</li>"
  );
  });
}else {
  $("#personalAux").hide();
$("#sugerenciaAux").html("<div>No existen sugerencias con este médico.</div>");
}
}).fail(function(data){

});
}


function AddContent() {
  $(".sugerenciaEnfermeria").addClass("despMostrarMas");
}
function SeleccionSugPerEnf(info,val) {
  if (val==1) {
    $("#programEnferm"+info).addClass("contSel");
    $("#tblEnfJefe"+info).prop("checked", true);
    $(".changeColorEnf"+info).css({'color':'#FFFFFF'});
  }else {
    $("#programAux"+info).addClass("contSel");
    $("#tblAuxEnferm"+info).prop("checked", true);
    $(".changeColorAux"+info).css({'color':'#FFFFFF'});
  }
}
function DesSeleccionSugPerEnf(idProgram,val) {
  if (val==1) {
    $("#programEnferm"+idProgram).removeClass("contSel");
    $("#tblEnfJefe"+idProgram).prop("checked", false);
    $(".changeColorEnf"+idProgram).css({'color':'#555555'});
  }else {
    $("#programAux"+idProgram).removeClass("contSel");
    $("#tblAuxEnferm"+idProgram).prop("checked", false);
    $(".changeColorAux"+idProgram).css({'color':'#555555 '});
  }
}
