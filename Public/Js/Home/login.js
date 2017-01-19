$(document).ready(function () {
  localStorage.clear();
  jQuery.validator.setDefaults({
    debug: true,
    success: 'valid'
  });

  if (loginError === 1) {
    Notificate({
      tipo: 'error',
      titulo: 'Usuario inactivo',
      descripcion: 'El usuario con el cual intenta ingresar se encuentra en estado Inactivo',
      duracion: 4
    });
  } if(loginError === 2){
    Notificate({
      tipo: 'error',
      titulo: 'Verifique la contraseña',
      descripcion: 'La contraseña es incorrecta',
      duracion: 4
    });
  } if(loginError === 3){
    Notificate({
      tipo: 'error',
      titulo: 'Usuario inexistente',
      descripcion: 'El usuario con el cual intenta ingresar no existe',
      duracion: 4
    });
  }
});

$('#frmLogin').validate({
  onfocusout: function (element) {
    $(element).valid();
  },

  focusCleanup: function (element) {
    $(element).parent().removeClass('frm_contenedorMalo');
  },

  onkeyup: false,

  highlight: function (element, errorClass) {
    $(element).siblings('input').removeClass('errorClass');
    $(element).parent().addClass('frm_contenedorMalo');
  },

  success: function (element) {
    $(element).parent().removeClass('frm_contenedorMalo');
  }

});

function LimpiarCampos() {
  $("#txtEmail").val("");
  $("#txtCodigo").val("");
  $("#txtNuevaCon").val("");
  $("#txtConfirmarCon").val("");
}

$("#btnSolicitarCodigo").click(function () {
  swal({
    title: "Solicitar código de restablecimiento",
    text: "Ingrese su correo electrónico",
    type: "input",
    confirmButtonColor: "#2ecc71",
    inputPlaceholder: "Ejemplo@ejemplo.com",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  }, function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("Ingrese su correo electrónico");
      return false
    }
    $.ajax({
      type: 'POST',
      url: url + 'Home/ctrlLogin/restablecerClave',
      data: {
        'email': inputValue
      }
    }).done(function(data){
      if (data == "1") {
        swal({
          title:"¡Éxito!",
          text:"Se ha enviado un código a su correo",
          type:"success",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#1F95D0",
        });
      } else if (data == "2") {
        swal({
          title:"Error",
          text:"No se pudo enviar el correo",
          type:"error",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#1F95D0"
        });
      } else if (data == "3") {
        swal({
          title:"El correo no existe",
          text:"Ingrese un correo valido",
          type:"warning",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#1F95D0"
        });
      } else {
        alert("Error: " + data);
      }
    }).fail(function(fail){  console.log(fail);  });
  });
});

$("#btnRestablecerCodigo").click(function(){
  swal({
    title: "Restablecer contraseña",
    text: "Ingrese el código que fue enviado a su correo electrónico",
    type: "input",
    confirmButtonColor: "#2ecc71",
    inputPlaceholder: "Código",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true
  }, function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("Ingrese el código");
      return false
    }
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: url + 'Home/ctrlLogin/validarCodigo',
      dataType: "JSON",
      data: {
        'codigo': inputValue
      }
    }).done(function(data){
      if (data.estado == "1") {
        swal({
          title:"¡Error!",
          text:"El código ingresado no existe, se pasó de las 24 horas límites o ya se usó. Envie otro código a su correo si no restauró su contraseña",
          type:"error",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#1F95D0",
        });
      }
      else if (data.estado == "2") {
        swal({
          title:"¡Atención!",
          text:"Se pasó de las 24 horas límites para restablecer la contraseña. Envie otro código a su correo",
          type:"warning",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#1F95D0",
        });
      }
      else if (data.estado == "3") {
        swal({
          title:"¡Restaure su contraseña!",
          text:"Nueva contraseña:<br><input type='password' style='display:block' id='txtNuevaClave' placeholder='Nueva contraseña' autocomplete='off'/><br>Confirmar contraseña:<br><input type='password' style='display:block' id='txtConfirmarClave' placeholder='Confirmar contraseña' autocomplete='off'/>",
          html:true,
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          confirmButtonColor: "#1F95D0",
          cancelButtonText: "Cancelar",
          showCancelButton: true,
          closeOnConfirm: false
        }, function(){
          var nuevaClave = $("#txtNuevaClave").val();
          var confirmarClave = $("#txtConfirmarClave").val();
          if (nuevaClave === false) return false;
          if (confirmarClave === false) return false;
          if (nuevaClave === "") {
            swal.showInputError("Ingrese la nueva contraseña");
            $("#txtNuevaClave").focus();
            return false
          }
          if (confirmarClave === "") {
            swal.showInputError("Ingrese la confirmación de la contraseña");
            $("#txtConfirmarClave").focus();
            return false
          }
          if(nuevaClave !== confirmarClave){
            swal.showInputError("Las contraseñas no coinciden");
            return false
          }
          $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: url + 'Home/ctrlLogin/cambiarClave',
            data: {
              'idUsuario':data.idUsuario,
              'clave': nuevaClave
            }
          }).done(function(data){
            swal({
              title:"¡Exito!",
              text:"Se cambió la contraseña correctamente",
              type:"success",
              confirmButtonText: "Aceptar",
              confirmButtonColor: "#1F95D0",
            });
          }).fail(function(data){

          });
        });
      }
    }).fail(function(fail){
      //            console.log(fail);
    });
  });
});
