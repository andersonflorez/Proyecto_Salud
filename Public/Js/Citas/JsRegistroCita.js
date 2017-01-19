$(document).ready(function(){
  ListaTipoCup();
  cll(0);
  ListaTipoDocumento();
  $('#terminarCita').click(function(){
    ReporteEnviarRegistroCita();
    setTimeout('document.location.reload()',1500);
  });
  $('#txtFechaNacimiento1').datepicker({
    language: 'es',
    maxDate: new Date()
   });
     $("#txtFechaNacimiento1").blur(function (){
       $.ajax({
         type:'POST',
         dataType: 'JSON',
         url:url+'Citas/ctrlCitas/FechaServidorCitas'
       }).done(function(data){
         var valorFecha = $("#txtFechaNacimiento1").val();
         var fecha = new Date(valorFecha);
         var fechaActual = new Date(data);
         if (fecha.getYear() > fechaActual.getYear()) {
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
             duracion: 4
           });
           $("#txtFechaNacimiento1").val("").focus();
         }else if (fecha.getYear() == fechaActual.getYear() && fecha.getMonth() > fechaActual.getMonth()) {
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
             duracion: 4
           });
           $("#txtFechaNacimiento1").val("").focus();
         }else if(fecha.getYear() == fechaActual.getYear() && fecha.getMonth() == fechaActual.getMonth() && fecha.getDate() >  fechaActual.getDate()){
           Notificate({
             tipo: 'warning',
             titulo: 'Cuidado con la fecha',
             descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
             duracion: 4
           });
           $("#txtFechaNacimiento1").val("").focus();
         }
       });
     });
  /*
  |----------------------------|
  |Lista de tipo de documento  |
  |____________________________|
  */
  function ListaTipoDocumento(){
    DoPostAjax({
      url: "Citas/CtrlCitas/ListarTipoDocumento"
    }, function(err, data) {
      if (err) {
        Notificate({
          titulo: 'Ha ocurrido un error',
          descripcion: 'Error con la lista de los tipo de documento.',
          tipo: 'error',
          duracion: 4
        });
      } else {
        //  console.log(typeof data)
        let datos=JSON.parse(data);
        for (var item in datos) {
          $("#SltTipoDocumento1").append("<option value='"+datos[item].idTipoDocumento+"'>"+datos[item].descripcionTdocumento+"</option>");
        }
      }
    });
  }

  /*
  |----------------------------|
  |Lista de las zonas          |
  |____________________________|
  */
  $(".select#SltComuna").change(function(){
    var idTipoZ = document.getElementById('SltComuna').value;
    if (idTipoZ!=-1) {
      document.getElementById("SltBarrio").disabled = false;
      DoPostAjax({
        url: "Citas/CtrlCitas/ConsultaZona",
        data:{idTipo:idTipoZ}
      }, function(err, data) {
        if (err) {
          Notificate({
            titulo: 'Ha ocurrido un error',
            descripcion: 'Error con la lista de las zonas.',
            tipo: 'error',
            duracion: 4
          });
        } else {
          $("#SltBarrio").html("<option value='-1'>Seleccione un barrio.</option>");
          let valores=JSON.parse(data);
          if (valores!=null) {
            for (var item in valores) {
              $("#SltBarrio").append("<option value='"+valores[item].idZona+"'>"+valores[item].descripcionZona+"</option>");
            }
            $(".select").select2();
          }else{
            $(".select").select2();
            document.getElementById("SltBarrio").disabled = true;
          }
        }
      });
    }
  });
});
/*
|-----------------------------------|
|cargar informacion de los paciente |
|___________________________________|
*/
function cargarDatos(data){
  Notificate({
    tipo: 'success',
    titulo: 'Consulta exitosa.',
    descripcion: 'El paciente se encuentra registrado.'
  });
  var estadoPaciente = data[0].descripcionEstadoPaciente;
  var PNombre = data[0].primerNombre;
  var SNombre=data[0].segundoNombre;
  var PApellido=data[0].primerApellido;
  var SApellido =data[0].segundoApellido;
  var Ciudad=data[0].ciudadResidencia;
  var Barrio=data[0].barrioResidencia;
  var Direccion = data [0].direccion;
  var Correo = data[0].correoElectronico;
  var TelFijo = data[0].telefonoFijo;
  var InfoTelefono =  TelFijo.split("-");
  var TelMovil = data [0].telefonoMovil;
  var idPaciente =data [0].idPaciente;

  var ConfirmacionD=
    {
      "Estado":btoa(estadoPaciente),
      "Barrio":btoa(Barrio),
      "Ciudad":btoa(Ciudad),
      "Correo":btoa(Correo),
      "Direccion":btoa(Direccion),
      "PrimerApellido":btoa(PApellido),
      "PrimerNombre":btoa(PNombre),
      "SegundoApellido":btoa(SApellido),
      "SegundoNombre":btoa(SNombre),
      "Telefono":btoa(TelFijo),
      "Celular":btoa(TelMovil),
      "idPac":btoa(idPaciente)
  }
  localStorage.setItem("InformacionPaciente",JSON.stringify(ConfirmacionD));

  $(".NombrePaciente").html(PNombre+" "+PApellido);
  $("#SltEstadoPaciente").html("<option selected='selected' value='1'>"+estadoPaciente+"</option>");
  //para seleccionar por defecto un valor se agrega el selected y esta function
  $(".select").select2();
  $("#txtPrimerNombre").val(PNombre);
  $("#txtSegundoNombre").val(SNombre);
  $("#txtPrimerApellido").val(PApellido);
  $("#txtSegundoApellido").val(SApellido);
  $("#txtCiudadResidencia").val(Ciudad);
  $("#txtBarrioResidencia").val(Barrio);
  $("#txtDireccion").val(Direccion);
  $("#txtCorreo").val(Correo);
  $("#txtTelefono").val(InfoTelefono[0]);
  $("#txtExtTelefonoCita3").val(InfoTelefono[1]);
  $("#txtTelefonoCelular").val(TelMovil);
  $("#txtidPaciente").val(idPaciente);
}
/*
|-----------------------------------|
|Vistas del calendario              |
|___________________________________|
*/
function cll(dato){
  if (dato==0) {
  DoPostAjax({
    url: 'Citas/CtrlCitas/cl'
  }, function(err) {
  });
}

DoPostAjax({
  url: 'Citas/CtrlCitas/cl',
  data: {boton:dato}
}, function(err, data) {
  if (err) {

  } else {
    datos=JSON.parse(data);
    $("#cuerpo-dias").empty();
    $("#li2").empty();
    $("#faa").empty();
    $("#cuerpo-dias").html(datos[0]);
    $("#li2").html(datos[1]);
    $("#faa").html(datos[2]);
    $.ajax({
      type: 'POST',
      dataType:'JSON',
      url: url+ "Citas/ctrlCitas/ConsultarProgramacionDias"
    }).done(function(data){
      let mesA=parseInt(data.mesActual);
      let diaA=parseInt(data.diaActual);
      let mesC=data.mesCalen;
      //console.log(data);
      let diasDispo=data.DiasDisponibles;
      let datosDias=[];
      let datosMeses=[];
      for (var item in diasDispo) {
        datosDias[item]=diasDispo[item].DiasDisponibles;
        datosMeses[item]=diasDispo[item].MesDisponible;
      }
      for (var i = 0; i < datosDias.length; i++) {
        if (mesC==mesA) {
          if (parseInt(datosDias[i])>=diaA) {
            $(".Dato"+datosMeses[i]+datosDias[i]).css({'background':'#ddd'});
          }
        }else {
          $(".Dato"+datosMeses[i]+datosDias[i]).css({'background':'#ddd'});
        }
      }
    });
  }
});
}
/*
|------------------------------------------|
|Función para consultar mes y año          |
|__________________________________________|
*/
function Calendario(id){
  var days=$("#"+id).attr("datoCalendario");
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/ctrlCitas/ConsultaMesYear",
    data:{Dato:days}
  }).done(function(data){
    let year = data.year;
    let respuesta=data.respuesta;
    if (respuesta) {
      ConsultaHorario(days,year);
    }else{
      Notificate({
        titulo: 'Advertencia',
        descripcion: 'No seleccione días anteriores a la actual.',
        tipo: 'warning',
        duracion: 4
      });
    }
  }).fail(function(data){
    console.log('Error en el horario');
  });
}
/*
|-----------------------------------_-_-_-_------|
|Información del calendario y los tunrnos        |
|____________________________________-_-_-_------|
*/
function ConsultaHorario(days,year){
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultHorario",
    data:{Dato:days}
  }).done(function(data){
    if(data!=null){
      let horario=data.horario;
      //var horario = JSON.parse(data.horario);
      $("#DaySem").html(data.dias+" "+days+" del "+year);
      Horario(0);
      Horario(1,horario,data.dias,days);
      let datos=JSON.parse(localStorage.getItem("infoCita"));
      var infoCita=
        {"txtTelefonoUno":datos.txtTelefonoUno,
        "txtTelefonoDos":datos.txtTelefonoDos,
        "SltBarrio":datos.SltBarrio,
        "txtDireccionCita":datos.txtDireccionCita,
        "barrioNombre":datos.barrioNombre,
        "SltTipoCita":datos.SltTipoCita,
        "diaSemana":btoa(data.dias+" "+days+" del "+year),
        "horaCita":datos.horaCita,
        "diaCita":btoa(days)
      };
      localStorage.setItem("infoCita",JSON.stringify(infoCita));
      AbrirModal('modalTurnos');
    }else{
      Horario(0);
      Notificate({
        titulo: 'Información',
        descripcion: 'No hay turnos disponibles.',
        tipo: 'info',
        duracion: 4
      });
    }
  }).fail(function(data){
    console.log('Error en los turnos');
  });
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para mostrar y limpiar el contenido del horario  |
|____________________________________-_-_-_---------------|
*/
function Horario(val,hor,diaNombre,diaNumero){
  let valor=val;
  let horario=hor;
  let diaNombreSelect=diaNombre;
  let diaNumeroSelect=diaNumero;
  var check=$(".turnoSel").attr("turn");
  if (valor==0) {
    $("#divTbl").html('<div class="n_flex_col10" id="tbl_ejemplo"><table class="tbl_responsive" ><thead><tr><th>Turnos</th></tr></thead><tbody id="tbltbltbl"></tbody></table></div>');
  }else{
    let parteID=diaNombreSelect+""+diaNumeroSelect;
    var cont=0;
    for (var i = 0; i < horario.length; i++) {
      var s = horario[i];
      for (var j = 0; j < s.length; j++) {
        $("#tbltbltbl").append("<tr><td class='rdo_tabla'><div class='radio cont-rdo '><input id='"+parteID+""+cont+"' onclick='mostrarTurno()' data_turno="+cont+" class='rdo_tabla micheck' type='radio' name='diferente'><label for='"+parteID+""+cont+"'>"+s[j]+"</label></div></td></tr>");
        cont++;
        $("#"+check).attr('checked','checked');
      }
    }
  }
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para validar si checkeó algún check de los turnos|
|____________________________________-_-_-_---------------|
*/
function datoRadio(){
  var res=$(".micheck:checked").attr("data_turno");
  var Datos=[];
  $('#tbltbltbl tr').each(function(index, element){
    var Referencia = $(element).find("label").eq(0).html();
    Datos.push(Referencia);
  });
  var Valor=Datos[res];
  return Valor;
}
/*Agregación de algunos datos al formdata para
enviar al registro de la cita por medio del ajax
del registro de las cita*/
function agregarDatos(formdata){
  let info=JSON.parse(localStorage.getItem("infoCita"));
  let idPaciente=JSON.parse(localStorage.getItem("InformacionPaciente"));
  formdata['txtTelefonoUno']=info.txtTelefonoUno;
  formdata['txtTelefonoDos']=info.txtTelefonoDos;
  formdata['SltBarrio']=info.SltBarrio;
  formdata['txtDireccionCita']=info.txtDireccionCita;
  formdata['SltTipoCita']=info.SltTipoCita;
  formdata['nametxtEncrypt']=idPaciente.idPac;
  formdata['diaCita']=info.diaCita;
  formdata["hour"]=info.horaCita;
  return formdata;
}

/*
|-----------------------------------_-_-_-_---------------|
|Función para filtrar los médicos especialista disponibles|
|en el horario seleccionado por el usuario                |
|____________________________________-_-_-_---------------|
*/
$("#txtBusquedaMedicos").keyup(function(){
  let valorBusquedaMedico=$('#txtBusquedaMedicos').val();
  let tipoBusquedaMedico=$('#sltFiltroMedicos').val();
  if (tipoBusquedaMedico==1) {
    ConsultarMedicosEspecial(valorBusquedaMedico);
  }else{
    ConsultaNombresMedicos(valorBusquedaMedico);
  }
});
$("#sltFiltroMedicos").change(function(){
  let tipoBusquedaMedico=$('#sltFiltroMedicos').val();
  if (tipoBusquedaMedico==1) {
    $("#txtBusquedaMedicos").attr("placeholder","Ej: Psicólogo");
  } else {
    $("#txtBusquedaMedicos").attr("placeholder","Ej: Juan");
  }
});
function ConsultarMedicosEspecial(val){
  let datoEspecialidad=val;
  let datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultarMedicosEspecial",
    data:{especial:datoEspecialidad,day:dayCita,hora:hour}
  }).done(function(data){
    let id=$(".medicos").attr('id');
    informacionPersonalA(data,id);
  }).fail(function(data){
    console.log('entre al fail');
  });
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para filtrar médicos por su nombre, disponibles  |
|en el horario seleccionado por el usuario                |
|____________________________________-_-_-_---------------|
*/
function ConsultaNombresMedicos(value){
  let datoNombre=value;
  let datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultaNombresMedicos",
    data:{Nombres:datoNombre,day:dayCita,hora:hour}
  }).done(function(data){
    let id=$(".medicos").attr('id');
    informacionPersonalA(data,id);
  }).fail(function(data){
    console.log('entre al fail');
  });
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para consultar los médicos disponibles en el     |
|horarios seleccionado por el usuario                     |
|____________________________________-_-_-_---------------|
*/
function ConsultarEnferJefe(){
  var datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultaEnfermerosJefe",
    data:{Cita_Dia:dayCita,Cita_Hour:hour}
  }).done(function(data){
    if (data!=null) {
      let id=$(".enfermeros").attr('id');
      informacionPersonalA(data,id);
    }else {
      Notificate({
        titulo: 'Aviso.',
        descripcion: 'No hay enfermeros jefe disponibles.',
        tipo: 'warning',
        duracion: 4
      });
    }
  }).fail(function(data){
    console.log('entre al fail');
  });
}

/*
|-----------------------------------_-_-_-_---------------|
|Función para filtrar enfermeros jefes por su nombre,     |
|disponibles en el horario seleccionado por el usuario    |
|____________________________________-_-_-_---------------|
*/
$("#txtBusquedaEnfermerosJefe").keyup(function(){
  let valorBusquedaEnfermerosJefe=$("#txtBusquedaEnfermerosJefe").val();
  ConsultaNombresEnfermJefes(valorBusquedaEnfermerosJefe);
});
function ConsultaNombresEnfermJefes(value){
  let datoNombre=value;
  let datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultaNombresEnfJefe",
    data:{Nombres:datoNombre,day:dayCita,hora:hour}
  }).done(function(data){
    let id=$(".enfermeros").attr('id');
    informacionPersonalA(data,id);
  }).fail(function(data){
    console.log('entre al fail');
  });
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para consultar los auxiliares disponibles en el  |
|horarios seleccionado por el usuario                     |
|____________________________________-_-_-_---------------|
*/
function ConsultarAuxEnfermeria(){
  var datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultarAuxEnfermeria",
    data:{Cita_Dia:dayCita,Cita_Hour:hour}
  }).done(function(data){
    if (data!=null) {
      let id=$(".auxiliares").attr('id');
      informacionPersonalA(data,id);
    }else {
      Notificate({
        titulo: 'Aviso.',
        descripcion: 'No hay auxiliares en enfermería disponibles.',
        tipo: 'warning',
        duracion: 4
      });
    }
  }).fail(function(data){
    console.log('entre al fail');
  });
}
/*
|-----------------------------------_-_-_-_---------------|
|Función para filtrar auxiliares enfermeros por su nombre,|
|disponibles en el horario seleccionado por el usuario    |
|____________________________________-_-_-_---------------|
*/
function ConsultaNombresAuxEnf(value){
  let datoNombre=value;
  let datos=JSON.parse(localStorage.getItem("infoCita"));
  let dayCita=datos.diaCita;
  let hour=datos.horaCita;
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/CtrlCitas/ConsultaNombresAuxEnf",
    data:{Nombres:datoNombre,day:dayCita,hora:hour}
  }).done(function(data){
    let id=$(".auxiliares").attr('id');
    informacionPersonalA(data,id);
  }).fail(function(data){
    console.log('entre al fail');
  });
}
/*
|-----------------------------------_-_-_-_------------------|
|Función para mostrar la información del personal asistencial|
|en el horario seleccionado por el usuario                   |
|____________________________________-_-_-_------------------|
*/
function informacionPersonalA(data,id){
  let idTabla=id;
  $('#'+idTabla).html('');
  if (data!=null) {
    $.each(data,function(s,p){
      if (p.SNombre=='null' || p.SNombre==null) {
        p.SNombre='No tiene';
      }else if(p.SApellido=='null' || p.SApellido==null){
        p.SApellido='No tiene';
      }
      let Dato;
      if (idTabla=="tblMedicos") {
        Dato=p.Especial;
      }else if(idTabla=="tblEnfJefe"){
        Dato=p.descripcionRol;
      }else {
        Dato=p.descripcionRol;
      }
      let nombrecomp=p.PNmbre+" "+p.PApellido;
      $("#"+idTabla).append("<li class='list_item n_grow_up'>"
      +" <div class='list_item_header n_flex n_nowrap'>"
      +" <div class='item_icon n_flex n_align_center'>"
      +"<span class='fa fa-user-md'></span>"
      +   "</div>"
      +   "<div class='item_title n_grow_up horizontal_padding vertical_padding ovf_hidden'>"
      +       "<h5 class='text_bold suspensive'>"+p.PNmbre+" "+p.PApellido+"</h5>"
      +    " </div>"
      +   "</div>"
      +   "<div class='list_item_content'>"
      +     "<p class='suspensive'>"
      +       "<span class='text_bold'>Segundo nombre: </span>"
      +     ""+p.SNombre+""
      +     "</p>"
      +  " </div>"
      +   "<div class='list_item_content'>"
      +     "<p class='suspensive'>"
      +      "<span class='text_bold'>Segundo apellido: </span>"
      +     ""+p.SApellido+""
      +    " </p>"
      +   "</div>"
      +   "<div class='list_item_content'>"
      +     "<p class='suspensive'>"
      +      "<span class='text_bold'>Cargo: </span>"
      +      ""+Dato+""
      +    " </p>"
      +   "</div>"

      +" <div class='list_item_footer n_flex n_justify_end '>"
      +"  <div class='cont-checkbox'>"
      +"  <div class='checkbox'>"
      +"    <input id='"+idTabla+""+p.IdTProgramacion+"' value='"+p.IdTProgramacion+"'  class='"+idTabla+"' nombre='"+nombrecomp+"' onclick='validarCheck(this)' type='checkbox' name='ckTurnos'>"
      +"      <label for='"+idTabla+""+p.IdTProgramacion+"' class='Ck"+idTabla+"'><i class='fa fa-check'></i></label>"
      +"    </div>"
      +"  </div>"
      +"  </div>"

      +"  </div>"
      +"</li>"
      +"</ul>");
    });
  }
}
/*
|------------------------------------------|
|Función para consultar la cantidad de     |
|citas que tiene un paciente al mes        |
|__________________________________________|
*/
function ConsultarCitasDelMes(){
  /*
  |------------------------------------------|
  |ajax    para consultar el primer y último |
  |del mes en el que se encuentra            |
  |__________________________________________|
  */
  let infoPaciente=JSON.parse(localStorage.getItem("InformacionPaciente"));
  $.ajax({
    type: 'POST',
    dataType:'JSON',
    url: url+ "Citas/ctrlCitas/ConsultarCitasDelMes",
    data:{idPac:idPac}
  }).done(function(data){
    console.log(data);
  });
}

/*
|-----------------------------------------------|
|Función para actualizar los datos del paciente |
|_______________________________________________|
*/

function ActualizarDatosPaciente(){
  var local=JSON.parse(localStorage.getItem("InformacionPaciente"));
  let idtipoD= $("#SltTipoDocumento1").val();
  let datos =$("#formInfoPaciente").serialize();
  let idpaciente=local.idPac;
  $.ajax({
    type: 'POST',
    url: url + "Citas/ctrlCitas/ModificarDatosPaciente",
    data:"tipodocumento="+idtipoD+""+"&"+"txtidpaciente="+idpaciente+""+"&"+$("#formInfoPaciente").serialize()
  }).done(function () {
    Notificate({
      tipo: 'success',
      titulo: 'Modificación exitosa.',
      descripcion: 'Se han modificado los datos con éxito.',
      duracion: 4
    });
  });
}


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
|-----------------------------------------------|
|Función agregar extensión a los teléfonos
|_______________________________________________|
*/
let bandera=false;
$("#Ext1").click(function(dato){
  var info=dato.target.parentNode;
  var selectedInput=$(info).children("div.aggInput");
  var input=$(info).children("div.aggInput").children("input").attr("id");
  var spansel=$(info).children("span.aggExt");
  //agrega el input tamaño
  $(selectedInput).toggle(200);
  $(selectedInput).css({'display': 'flex'});
  if (bandera==false) {
  $(spansel).removeClass("fa-plus");
  $(spansel).addClass("fa-times");
  $(".fa-times").css({"color":"rgba(229,74,101,0.9)"});
  bandera=true;
}else{
  $("#"+input).val("");
  $(spansel).removeClass("fa-times");
  $(spansel).addClass("fa-plus");
  $(".fa-plus").css({"color":"#2ecc71"});
  bandera=false;
}
});
/*
|-----------------------------------------------|
|Función agregar extensión a los teléfonos
|_______________________________________________|
*/
let bandera1=false;
$("#Ext2").click(function(dato){
  var info=dato.target.parentNode;
  var selectedInput=$(info).children("div.aggInput");
  var input=$(info).children("div.aggInput").children("input").attr("id");
  var spansel=$(info).children("span.aggExt");
  //agrega el input tamaño
  $(selectedInput).toggle(200);
  $(selectedInput).css({'display': 'flex'});
  if (bandera1==false) {
  $(spansel).removeClass("fa-plus");
  $(spansel).addClass("fa-times");
  $(".fa-times").css({"color":"rgba(229,74,101,0.9)"});
  bandera1=true;
}else{
  $("#"+input).val("");
  $(spansel).removeClass("fa-times");
  $(spansel).addClass("fa-plus");
  $(".fa-plus").css({"color":"#2ecc71"});
  bandera1=false;
}
});
/*
|-----------------------------------------------|
|Función agregar extensión a los teléfonos
|_______________________________________________|
*/

let bandera2=false;
$("#Ext3").click(function(dato){
  var info=dato.target.parentNode;
  var selectedInput=$(info).children("div.aggInput");
  var input=$(info).children("div.aggInput").children("input").attr("id");
  var spansel=$(info).children("span.aggExt");
  //agrega el input tamaño
  $(selectedInput).toggle(200);
  $(selectedInput).css({'display': 'flex'});
  if (bandera2==false) {
  $(spansel).removeClass("fa-plus");
  $(spansel).addClass("fa-times");
  $(".fa-times").css({"color":"rgba(229,74,101,0.9)"});
  bandera2=true;
}else{
  $("#"+input).val("");
  $(spansel).removeClass("fa-times");
  $(spansel).addClass("fa-plus");
  $(".fa-plus").css({"color":"#2ecc71"});
  bandera2=false;
}
});
/*
|-----------------------------------------------|
|Función agregar extensión a los teléfonos
|_______________________________________________|
*/
let bandera3=false;
$("#Ext4").click(function(dato){
  var info=dato.target.parentNode;
  var selectedInput=$(info).children("div.aggInput");
  var input=$(info).children("div.aggInput").children("input").attr("id");
  var spansel=$(info).children("span.aggExt");
  //agrega el input tamaño
  $(selectedInput).toggle(200);
  $(selectedInput).css({'display': 'flex'});
  if (bandera3==false) {
  $(spansel).removeClass("fa-plus");
  $(spansel).addClass("fa-times");
  $(".fa-times").css({"color":"rgba(229,74,101,0.9)"});
  bandera3=true;
}else{
  $("#"+input).val("");
  $(spansel).removeClass("fa-times");
  $(spansel).addClass("fa-plus");
  $(".fa-plus").css({"color":"#2ecc71"});
  bandera3=false;
}
});

/*
|-----------------------------------------------|
|Función remover extensión a los teléfonos
|_______________________________________________|
*/
//validaciones
$('input.only_numbers').keypress(function(tecla) {
  if (tecla.charCode < 48 || tecla.charCode > 57) {
    return false;
  }
});
$('input.quantity_maximun_input').keypress(function(del) {
  if (del.charCode != 127) {
    /*cantidad máxima de caracteres que quieres que se digiten*/
    if ($(this).val().length >= 5) {
      del.preventDefault();
    }
  }
});



function select2Codigo(){
  $('#cmbCodigoCUP').select2({
    placeholder: 'Seleccione una opción',
    ajax: {
      url: url+"Citas/CtrlCitas/consultarCodigoCUP",
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
      url: url+"Citas/CtrlCitas/consultarDescripcionCUP",
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
    url: url+"Citas/CtrlCitas/consultarCodigoIdCUP",
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
    url: url+"Citas/CtrlCitas/consultarDescripcionIdCUP",
    type:"POST",
    data:{
      id:valor
    }
  }).done(function(data){
    $("#cmbDescripcionCUP").html("<option selected='select' value='"+valor+"'>"+data+"</option>");
    select2Descripcion();
  });
}

$("#telResident").click(function(){
let datosPaciente=JSON.parse(localStorage.getItem("InformacionPaciente"));
let info=atob(datosPaciente.Telefono).split("-");
$("#txtTelefonoUno").val(info[0]);
$("#txtExtTelefonoCita1").val(info[1]);
});
$("#direcResident").click(function(){
let datosPaciente=JSON.parse(localStorage.getItem("InformacionPaciente"));
$("#txtDireccionCita").val(atob(datosPaciente.Direccion));
});

$("#cmbCodigoCUP").change(function(){
  $.ajax({
    type: 'POST',
    url: url + "Citas/ctrlCitas/ConfigCup",
    data: {idCup:this.value}
  }).done(function(data) {
    data=JSON.parse(data);
    var ConfigDias=data[0].cantidadCitasDia;
    var ConfigMes=data[0].cantidadCitasMes;
    var config={
      "ConfigDia":btoa(ConfigDias),
      "ConfigMes":btoa(ConfigMes)
    };
    localStorage.setItem("config",JSON.stringify(config));
  });

});



function ReporteEnviarRegistroCita(){
  var datos = JSON.parse(localStorage.getItem("InformacionPaciente"));
  var datosCitas = JSON.parse(localStorage.getItem("infoCita"));
  var nombreCompleto =atob(datos.PrimerNombre)+" "+atob(datos.PrimerApellido);
  var correoE = datos.Correo;
  var barrioCita = datosCitas.barrioNombre;
  var telefono = datosCitas.txtTelefonoUno;
  var hora = datosCitas.horaCita;
  var directCita = datosCitas.txtDireccionCita;
  let diaCita=datosCitas.diaCita;
  let descripcionServicio=$("#cmbDescripcionCUP option:selected").text();
  $("#terminarCita").html("Cargando...");
  $.ajax({
    type:"POST",
    url: url + "Citas/ctrlCitas/ReporteRegistroCita",
    data:{diaCita:diaCita,nombreCompleto:nombreCompleto, barrioCita:barrioCita, telefono:telefono, nombresenfermerosJefe:nombresenfermerosJefe, hora:hora, directCita:directCita, nombresmedicos:nombresmedicos, nombresauxEnfermeria:nombresauxEnfermeria, correoE:correoE,descripcionServicio:descripcionServicio}
  }).done(function(data){
    Notificate({
      titulo: 'Aviso.',
      descripcion: 'Correo Enviado Con Exito.',
      tipo: 'success',
      duracion: 4
    });
    // setTimeout('document.location.reload()',1000);
  }).fail(function(error){
    console.log(error);
  });
}
