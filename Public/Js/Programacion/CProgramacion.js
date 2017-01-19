var mesC;
var anoC;
$(document).ready(function(){

  $("#informa").append("<p class='nombre' style='font-size 10%'>"+localStorage.getItem("especialidad")+": "+localStorage.getItem("nombre")+" "+localStorage.getItem("apellido")+"</p>");
  var idp = localStorage.getItem("id");
  ValidarCitas(idp);
  cll(0);
  //cll(0);
  var myDatepicker = $('#buscar').datepicker().data('datepicker');

   $("#buscar").datepicker({
       language: 'in',
       onSelect:function(formattedDate){
           valor = $('#buscar').val();
         if(valor==$('#buscar').val()){
           buscarCalendario();
            cll(1);
         }else{

         }
        }
      });
});
var valor;
dias = [];
turnosI = [];
turnosf = [];
contador = 0;
contador2 = 0;
//cargar dias del calendario cuando cambie de mes
function cll(dato){
  DoPostAjax({
    url: 'Programacion/ctrlCProgramacion/cl',
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
  var idp = localStorage.getItem("id");
DoPostAjax({
    url: 'Programacion/ctrlCProgramacion/turnoshp',
    data: {'id':idp}
  },function(err,data){
    if(err){
    }else{
      datos=JSON.parse(data);
      console.log(data);
      $("#body").html("");
    $.each(datos,function(s,p){
      $("#body").append("<tr><th>"+p.horaInicioTurno+"-"+p.horaFinalTurno+"</th></tr>");
      turnosI.push(p.horaInicioTurno);
      turnosf.push(p.horaFinalTurno);
    })
    limpiarArray();
    dias.length = 0;
    dias=[];
    }
  })
  //ajax para traer los dias
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + 'Programacion/ctrlCProgramacion/programacionHP',
    data: {'txtid':idp}
  }).done(function(DATA){
    $.each(DATA,function(s,p){
     $.ajax({
       type: 'POST',
       dataType: 'json',
       url: url+"Programacion/ctrlCProgramacion/convertirFecha",
       data: {'fecha':p.Fecha_inicial}
     }).done(function(data){
       console.log(data);
       dias.push(data);
       cargarDias();
       limpiarArray();

     }).fail(function(){
      alert('malo');
    });
    });
  }).fail(function(){
    alert('p');
  })
  $.ajax({
    type:'POST',
    datatype:'json',
    url: url + 'Programacion/ctrlCalendario/validarSelecion'
  }).done(function(ano){
    fechaS = new Date(ano);
    mesC = fechaS.getMonth()+1;
    anoC = fechaS.getFullYear();
    var logn = turnosI.length;
    console.log(turnosI);
    for(var i = 0; i<=logn-1; i++){
      if(contador<1){
        contador++;
       // $("#body").append("<tr><th>"+turnosI[i]+"-"+turnosf[i]+"</th></tr>");
      }
    }
  }).fail(function(){
    console.log("error al obtener la fecha ");
  })
})
}
  window.onload = function() {
    if(window.addEventListener)
        document.addEventListener('DOMMouseScroll', moveObject, false);
    document.onmousewheel = moveObject;
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
  // hay que hacer un switch para carcgar los dias en el calendario
  // debido a problematicas
function cargarDias(){
var long = dias.length;
console.log(dias);
  for(var i=0; i<=long; i++){
    dia = parseInt(dias[i]);
    console.log(dia);
    $('#'+dia).addClass('dia');
    AbrirModal("modal1");
    document.getElementById("seguido").style.visibility = "visible";
  }
}

function limpiarArray(){
  for (var i = 0; i<=15; i++) {
    delete dias[i];
  }
  dias.length = 0;
}

function buscarCalendario(){
  valor = $('#buscar').val();
  fecha = new Date(valor);
  ano = fecha.getFullYear();
  mes = fecha.getMonth()+1;
  $.ajax({
    type: 'POST',
    url: url+ "Programacion/ctrlCProgramacion/darValorCalendario",
    data: {'anod':ano, 'mesd':mes}
  }).done(function(){
  })
}

function ValidarCitas(idp){
 $.ajax({
   type: 'POST',
   dataType: 'json',
   url: url + "Programacion/ctrlCProgramacion/Mvalidarcitas",
   data:{'txtid':idp}
 }).done(function(data){
  if (data == "0" ){
    $("#ListaImprimir").html('');
    $("#ListaImprimir").append("<button class='btn btn-eliminar' onclick='inhabilitarPersona("+'"'+idp+'"'+")'>Inhabilitar</button>");
  }else{
    $.each(data,function(l,o){
     $("#ListaImprimir").html('');
    $("#ListaImprimir").append("<button class='btn btn-consultar' onclick='Abrirmodalpro("+o.idPersona+")'>Citas </button>");
  });
  }
    }).fail(function(fail){
       console.log('fail',fail)
     })
    }
   function Abrirmodalpro(idPersona){
modal = "modal2";
AbrirModal(modal);
$.ajax({
type: 'POST',
dataType: 'JSON',
url: url+"Programacion/ctrlCProgramacion/listarcitas",
data:{idt:idPersona}
}).done(function(data){
console.log(data);
let html = "";
if (data != 0) {
 $.each(data,function(m,t){
   html += "<tr><td>"+t.paciente+"</td> <td>"+t.primerApellido+"</td><td>"+t.numeroDocumento+"</td><td>"+t.horaInicial+"</td> <td>"+t.horaFinal+"</td><td>"+t.fecha+"</td><td>"+t.direccionCita+"</td><td>"+t.nombreCUP+"</td></tr>";
$("#mostrar").html(html);
});
}else{
Notificate({
tipo: 'warning',
titulo: 'error',
descripcion: 'No hay datos'
});}
}).fail(function(data){
alert(idPersona);
console.log(data);
});
}
    function inhabilitarPersona(idPersona){
      id = localStorage.getItem("id");
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url+"Programacion/ctrlCProgramacion/inhabilitar",
        data:{'idP':idPersona}
      }).done(function(data){
        console.log(data);
       localStorage.setItem("mon",1);
      window.location = url + "Programacion/ctrlConsultarUsuarios";
      }).fail(function(data){
        localStorage.setItem("mon",0);
      window.location = url + "Programacion/ctrlConsultarUsuarios";
      });
    }
