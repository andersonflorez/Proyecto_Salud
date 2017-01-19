$(document).ready(function(){
  $("#txtDocumento").focusout(function(){
    if(!(/^[a-zA-Z]{1}\d{7}[a-zA-Z0-9]{1}$/i).test($("#txtDocumento").val())){
      $("#errorN").html("El nombre no tiene la sintaxis correcta");
      $("#txtDocumento").removeClass("mensajeValido");
      $("#txtDocumento").addClass("mensajeError");
    }else{
      $("#errorN").html("");
      $("#txtDocumento").removeClass(".mensajeError");
      $("#txtDocumento").addClass(".mensajeValido");
    }
  });
  $("#txtFechanacimiento").focusout(function(){
    if(!(/^([0-9]{2}\/[0-9]{2}\/[0-9]{4})$/).test($("#txtFechanacimiento").val())){
      $("#errorC").html("La fecha no tiene la sintaxis correcta");
      $("#txtFechanacimiento").removeClass("mensajeValido");
      $("#txtFechanacimiento").addClass("mensajeError");
    }else{
      $("#errorC").html("");
      $("#txtFechanacimiento").removeClass(".mensajeError");
      $("#txtFechanacimiento").addClass(".mensajeValido");
    }
  });
  $("#txtApellido").focusout(function(){
    if(!(/^[a-z]+$/i).test($("#txtApellido").val())){
      $("#errorN").html("El nombre no tiene la sintaxis correcta");
    }else{
      $("#errorN").html("");
    }
  });


    return false;

});


