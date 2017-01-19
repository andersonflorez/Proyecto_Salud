  $(document).ready(function() {

  $.validator.messages.required = mostrarNMensaje('Este campo es de carácter obligatorio');

  // Necesario para select2
  $('.select').select2({});

  /**
  * Permite ingresar o digitar en el input (agregando la clase) solo letras con y sin
  * acentuación.
  * Ejemplos de uso: para nombres, apellidos y demás
  */
  $('input.only_letters').keypress(function(e) {
    if ((e.charCode < 97 || e.charCode > 122) && (e.charCode < 65 || e.charCode > 90) && (e.charCode < 225 || e.charCode > 255) && (e.charCode != 32)) {
      return false;
    }
  });

  /**
  * Cantidad máxima de caracteres para un input que, también se le puede agregar tanto
  * un maxLength como un minlength, esta función no permite digitar más caracteres
  * de los que se establecen (depende de la necesidad)
  */
  $('input.quantity_maximun_input').keypress(function(del) {
    if (del.charCode != 127) {
      /*cantidad máxima de caracteres que quieres que se digiten*/
      if ($(this).val().length > 10) {
        del.preventDefault();
      }
    }
  });
  /**
  * longitud  máxima de un textarea agregando solamente la clase al text area
  * y para mostrar la cantidad de caracteres que faltan por digitar o lleva
  * digitado, simplemente se mete el textarea en un div que se le agregara un id
  */
  $('textarea.quantity_maximun_area').maxLength(10, {
    showNumber: '#contador',
    revert: true
  });

  /**
  * Solo permite digitar números en el input agregando la clase only_numbers
  */
  $('input.only_numbers').keypress(function(tecla) {
    if (tecla.charCode < 48 || tecla.charCode > 57) {
      return false;
    }
  });
});

