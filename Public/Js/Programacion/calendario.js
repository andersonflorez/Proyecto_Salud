var operacion;
//var Respuesta= false;
var fechaActual = new Date();
var anoC;
var mesC;
var controlador3=0;
var contador = 1;
var correo;
dias = [];
diasT = [];
mesesT = [];
anoT = [];
$(document).ready(function(){
    $("#informa").append("<p class='nombre'>"+ localStorage.getItem("especialidad")+": "+localStorage.getItem("nombre")+" "+localStorage.getItem("apellido")+"</p>");
  cll(0);
  cll(0);
});
//cargar dias del calendario cuando cambie de mes
function cll(dato){
  DoPostAjax({
    url: 'Programacion/ctrlCalendario/CargarCalendario',
    data: {boton:dato}
  }, function(err, data) {
    if (err){
    } else {
      datos=JSON.parse(data);
      $("#cuerpo-dias").empty();
      $("#li2").empty();
      $("#faa").empty();
      $("#cuerpo-dias").html(datos[0]);
      $("#li2").html(datos[1]);
      $("#faa").html(datos[2]);
    }
    //ajax para consultar la fecha del calendario para validarla con la del sistema
    $.ajax({
      type:'POST',
      datatype:'json',
      url: url + 'Programacion/ctrlCalendario/datos'
    }).done(function(ano){
      fechaS = new Date(ano);
      mesC = fechaS.getMonth()+1;
      anoC = fechaS.getFullYear();
      cargarDias();
    }).fail(function(){
      console.log("error al obtener la fecha ");
    })
    //
  });
  $.ajax({
    type: 'POST',
    url: url + 'Programacion/ctrlCalendario/traerCorreo',
    data: {'txtid': localStorage.getItem("id")}
  }).done(function(DATA){
    correo = DATA;
  }).fail(function(){
    alert("no se pudo")
  });
}

function cargarDias(){
  for(var i = 1; i<=contador2; i++){
    if(anoT[i]==anoC && mesesT[i]==mesC){
      id= dias[i];
      if(contador<16){
        $('#'+id).addClass('dia');
        $('#'+id).addClass('max');
      }else {
        contador=16;
      }
    }
  }
}

//validar la seleccion de los dias
function validarDia(DIr){
aidi = $(DIr).attr('id');
$.ajax({
  type:'POST',
  datatype : 'json',
  url: url+'Programacion/ctrlCalendario/validarSelecion',
  data: {'d': aidi}
}).done(function(DATA){
 pd(DIr,DATA);
}).fail(function(){
  console.log('error');
})
}

//funcion para selecionar dias
function pd(his,data){
  var Respuesta = data;
  if(data==true){
    if(contador!=17){
      if(!$(his).hasClass('dia')){
        $(his).addClass('dia');
        $(his).addClass('max');
        Agregar($(his).attr('id'));
        contador=contador+1;
      }else {
        $(his).removeClass('max');
        $(his).removeClass('dia');
        remobverID($(his).attr('id'),mesC);
        contador=contador-1;
      }if(contador>2){
        document.getElementById("seguido").style.visibility = "visible";
      }if(contador<3){
        document.getElementById("seguido").style.visibility = "hidden";
      }
    }if(contador==17){
      $(his).removeClass('dia');
      Notificate({
        tipo: 'warning',
        titulo: 'Notificación de advertencia',
        descripcion: 'No puede seleccionar más de 15 días.'
      });

      if($('max').click()){
        $(his).removeClass('dia');
        contador=contador-1;
        remobverID($(his).attr('id'));
      }
    }
  }else {
    Notificate({
      tipo: 'info',
      titulo: 'Alerta',
      descripcion: 'Tiene que seleccionar los días, apartir de mañana.'
    });
  }
}



//variable contador para mandar posicion al array
//variable array para almacenar los dias
var contador2=0;
//funcion para agregar los dias al array
function Agregar(dia) {
  contador2++;
  dias[contador2] = dia;
  mesesT[contador2]= mesC;
  anoT[contador2] = anoC;
  $('.contenedor').addClass('validacion');
}
//funcion para respar los dias al array
//cuando se desselecione un dia
function remobverID (res,mes){
  contador2=contador2-1;
  for (var i = 0; i <= 15; i++) {
    if (dias[i]== res && mesesT[i]==mes){
      delete dias[i];
      delete mesesT[i];
      delete anoT[i];
      delete dias[16];
    }
  }
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
var eventoControlado = false;
window.onload = function() {
  document.onkeypress = mostrarInformacionCaracter;
  if(window.addEventListener)
      document.addEventListener('DOMMouseScroll', moveObject, false);
  document.onmousewheel = moveObject;
}
function mostrarInformacionCaracter(evObject) {
  var msg = '';
  var elCaracter = String.fromCharCode(evObject.which);
  if (evObject.which!=0 && evObject.which!=13) {
    msg = 'Tecla pulsada: ' + elCaracter;
    var codigo = evObject.which;
    if(evObject.which == 97 || evObject.which== 65){
      Autocompletado();
    }else if(evObject.which == 101 || evObject.which==69){
     limpiar();
    }
  }
  else{ msg = 'Pulsada tecla especial';
  console.log(msg);
}
eventoControlado=true;
}
function moveObject(event)
{
    var delta = 0;
    if (!event) event = window.event;
    // normalize the delta
    if (event.wheelDelta == 120) {
    cll(2);
  }else if (event.wheelDelta != 120){
   cll(1);
  }
    //moving the position of the object
}
function Autocompletado()
{
  max = 0;
  min = 40;
  diferencia = 0;
  nuevoArray = [];
  nuevoArray[0]=1;
  for(var i=0,len=contador2+1;i<len;i++){
    nuevoArray[i] = parseInt(dias[i]);
    if(max < nuevoArray[i]){
      max = nuevoArray[i];
    }
}
for(var i=1,len=contador2+1;i<len;i++){
  if(min > nuevoArray[i]){
    min = nuevoArray[i];
  }
}
diferencia = max-min;
id = 0;
if(diferencia+1>15){
  Notificate({
    tipo: 'warning',
    titulo: 'Notificación de advertencia',
    descripcion: 'No puede seleccionar más de 15 días.'
  });
}else if(diferencia+1<16){
  for(var i=1; i<=diferencia; i++){
    id = min+i;
    dias[1]=min;
    dias[i+1] = id;
    contador = i+2;
    anoT[1] = anoC;
    anoT[i+1] =anoC;
    mesesT[1] = mesC;
    mesesT[i+1] = mesC;
    contador2 = diferencia+1;
    $('#'+id).addClass('dia');
    $('#'+id).addClass('max');
  }
}
}
function limpiar(){
for(var i=0; i<=contador2+1; i++){
$('#'+dias[i+1]).removeClass('dia');
$('#'+dias[i+1]).removeClass('max');
delete dias[0];
delete dias[i+1];
delete diasT[i+1];
delete mesesT[i+1];
delete anoT[i+1];
}
document.getElementById("seguido").style.visibility = "hidden";
contador = 1;
contador2 = 0;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//funcion para organizar el array mandado en la primera posiscion la fecha menor de todas las fechas
// y el la ultima, la fecha mas alta.
function seguido(){
  max = 0;
  min = 40;
  diferencia = 0;
  nuevoArray = [];
  nuevoArray[0]=1;
  //ciclo para calcular la fecha mayor de todos los dias que hay seleccionados
  //tipo ordenamiento burbuja
  for(var i=0,len=contador2+1;i<len;i++){
    nuevoArray[i] = parseInt(dias[i]);
    if(max < nuevoArray[i]){
      max = nuevoArray[i];
    }
  }
  //ciclo para calcular la fecha menor de todos los dias que hay seleccionados
  //tipo ordenamiento burbuja
  for(var i=1,len=contador2+1;i<len;i++){
    if(min > nuevoArray[i]){
      min = nuevoArray[i];
    }
  }
  diferencia = max-min;
  id = 0;
  //ciclo para mandar la fecha inicial a la primera posision y la final en la ultima
  for(var i=1; i<=diferencia; i++){
    id = min+i;
    dias[1]=min;
    dias[i+1] = id;
    contador = i+2;
  }
}


//mandar datos al controlador cuando den click en registrar
$('.guardar').click(function(){
  var persona = [];
  var datosPersonas;
  //ciclo para recorrer los turnos seleccionados y almacenarlos en un array
  for(var i =0 ;i<=$(".seleccion").length ;i++){
    if($(".seleccion").eq(i).is(":checked")){
      persona.push($(".seleccion").eq(i).val());
    }
  }
  datosPersonas = JSON.stringify(persona);
  parseTuno = parseInt(datosPersonas);
  var diasF = dias;

  //enviar por ajax los checked seleccionados
  var long = datosPersonas.length;
  //condicion para preguntar si hay algun checkbox seleccionado
  if(long == 2){
    Notificate({
      tipo: 'warning',
      titulo: 'Notificación de advertencia',
      descripcion: 'Tiene que seleccionar almenos un turno.'
    });
  }else{
    CerrarModal($(this).parents().find('.modal-ventana'));
    //ajax para registrar
    id = localStorage.getItem("id");
    //window.location = url + "../../../Application/Controller/Programacion/ctrlRegistrarHistoriaClinica";
    swal({
     title: "¿Desea registrar esta programación?",
     confirmButtonText: "Registrar",
     confirmButtonColor: "#2ecc71",
     showCancelButton: true,
     closeOnConfirm: false,
     showLoaderOnConfirm: true,
   },
     function(){
       setTimeout(function(){
         $.ajax({
           type: 'POST',
           datatype: 'json',
           url : url + "Programacion/ctrlCalendario/registrarProgramacion",
           data: {"txturnos": persona,"txtDias":diasF,"anoS":anoT,"meses":mesesT,"txtidUsuario":id,"correo":correo}
         }).done(function(){
          localStorage.setItem("res",1);
          window.location = url + "Programacion/ctrlConsultarUsuarios";
         }).fail(function(){
           localStorage.setItem("res",0);
           window.location = url + "Programacion/ctrlConsultarUsuarios";
        })
     },500);
  });
}
});
 
  $('#ayuda').click(function (event) {
       info();
    });

   $('#ayuda').click(function (event) {
       info();
    });




function info(){
   swal({  title:"Teclas rápidas",  html:true, text: "<b>Tecla A</b> Cuando escoja una cantidad de días presiona esta tecla para seleccionarlas automáticamente. <br> <b>Tecla E</b> Para quitar los días seleccionados bastan con oprimir este botón y lo ejecutara automáticamente.",  type: "info" }, function(){   swal(""); });

}


function info(){
   swal({  title:"Teclas rápidas",  html:true, text: "<b>Tecla A</b> Cuando escoja una cantidad de días presiona esta tecla para seleccionarlas automáticamente. <br> <b>Tecla E</b> Para quitar los días seleccionados bastan con oprimir este botón y lo ejecutara automáticamente.",  type: "info" }, function(){   swal(""); });

}



//Fin del envio de la programacion
