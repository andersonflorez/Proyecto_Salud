var operacion;
var Respuesta;
var fechaActual = new Date();
var anoC;
var mesC;
var controlador3=0;
var contador = 1;
dias = [];
diasT = [];
mesesT = [];
anoT = [];
$(document).ready(function(){
  cll(0);
});
//cargar dias del calendario cuando cambie de mes
function cll(dato){
  DoPostAjax({
    url: 'Programacion/ctrlMCalendario/cl',
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
      url: url + 'Programacion/ctrlMCalendario/validarSelecion'
    }).done(function(ano){
      fechaS = new Date(ano);
      mesC = fechaS.getMonth()+1;
      anoC = fechaS.getFullYear();
      cargarDias();
      AbrirModal("modal2");
    }).fail(function(){
      console.log("error al obtener la fecha ");
    })
    //
  });
}

function cargarDias(){
  for(var i = 0; i<=contador2; i++){
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
function validarDia(DI){
  anoA = fechaActual.getFullYear();
  MesA= fechaActual.getMonth()+1;
  dia = fechaActual.getDate();
  diaC = DI;
  if(anoC<anoA){
    Respuesta = false;
  }else if(anoC==anoA && mesC<MesA){
    Respuesta = false;
  }else if(anoC==anoA && mesC==MesA && DI<=dia){
    Respuesta = false;
  }else if(anoC==anoA && mesC==MesA && DI>dia){
    Respuesta = true;
  }else if(anoC==anoA && mesC>MesA){
    Respuesta = true;
  }
}

//funcion para selecionar dias
function pd(his){
  console.log(contador);
  validarDia($(his).attr('id'));
  if(Respuesta==true){
    if(contador!=17){
      if (!$(his).hasClass('dia')){
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
        descripcion: 'No puede selecionar más de 15 días.'
      });

      if($('max').click()){
        $(his).removeClass('dia');
        contador=contador-1;
        remobverID($(his).attr('id'));
        AbrirModal("modal1");
      }
    }
  }else {
    Notificate({
      tipo: 'info',
      titulo: 'Notificación de error',
      descripcion: 'No puede selecionar los días que anteceden a el de mañana.'
    });
  }
  console.log();
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
}
function mostrarInformacionCaracter(evObject) {
  var msg = '';
  var elCaracter = String.fromCharCode(evObject.which);
  if (evObject.which!=0 && evObject.which!=13) {
    msg = 'Tecla pulsada: ' + elCaracter;
    var codigo = evObject.which;
    console.log(msg);
    console.log(codigo+":codigo");
    if(evObject.which == 97){
      console.log ("a");
      Autocompletado();
    }
  }

  else { msg = 'Pulsada tecla especial';
  console.log(msg);
}
eventoControlado=true;
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
    console.log(nuevoArray);
    if(max < nuevoArray[i]){
      max = nuevoArray[i];
    }
    /*if(min > nuevoArray[i+1]){
    min = nuevoArray[i];
  }*/
}
for(var i=1,len=contador2+1;i<len;i++){
  if(min > nuevoArray[i]){
    min = nuevoArray[i];
  }
}
console.log(max+":max");
console.log(min+":min");
diferencia = max-min;
id = 0;
if(diferencia+1>15){
  Notificate({
    tipo: 'warning',
    titulo: 'Notificación de advertencia',
    descripcion: 'No puedes selecionar más de 15 días.'
  });
}else if(diferencia+1<16){
  for(var i=1; i<=diferencia; i++){
    id = min+i;
    dias[1]=min;
    dias[i+1] = id;
    contador = i+2 ;
    console.log(id);
    $('#'+id).addClass('dia');
  }
}
console.log(max);
console.log(min);
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
      descripcion: 'tienes que seleccionar almenos un truno.'
    });
  }else{
    //ajax para registrar
    $.ajax({
      type: 'POST',
      datatype: 'json',
      url : url + "Programacion/ctrlMCalendario/registrarProgramacion",
      data: {"txturnos": persona,"txtDias":diasF,"anoS":anoT,"meses":mesesT}
    }).done(function(){
      Notificate({
        tipo: 'success',
        titulo: 'Notificación de advertencia',
        descripcion: 'Registro exitoso.'
      });
    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: 'Notificación de error',
        descripcion: 'Error al ingresar la agenda.'
      });
    })
  }
});

//Fin del envio de la programacion
