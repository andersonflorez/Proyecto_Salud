$(document).ready(function(){
  mostrarCampoAseguramiento();
});

$('#OtroAseguramiento').click(function(){
  var aseguramiento = JSON.parse(localStorage.getItem("ReporteAPH-Aseguramiento"));
  var descripcion = aseguramiento.otroAseguramiento;
  localStorage.setItem("ReporteAPH-Aseguramiento",JSON.stringify({id:"",otroAseguramiento:descripcion}));
  $("#contenedor_descripcion_aseguramiento").css("display","block");
  $("#contenedor_descripcion_aseguramiento").val("");
});

function mostrarCampoAseguramiento(){
  var aseguramiento = JSON.parse(localStorage.getItem("ReporteAPH-Aseguramiento"));
  if (aseguramiento) {
    if (aseguramiento.otroAseguramiento != null || aseguramiento.otroAseguramiento != "") {
      $("#contenedor_descripcion_aseguramiento").css("display","block");
    }else{
      $("#contenedor_descripcion_aseguramiento").css("display","none");
    }
  }
}

$('.checkValid').click(function(){
  alert();
});
