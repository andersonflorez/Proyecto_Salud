
/*Métodos estandar para las validaciones de los campos, cada uno de ellos tiene un
nombre con el que se identifica y, cada método tiene su respectiva función. La
función de cada método la vas a encontrar en el archivo js llamado Standard_Validations
ubicado en el public/Js/Todos, desde allí podrán utilizar estos métodos que, además
tendrá el modo de uso de estos métodos; ustedes mismo pueden crear validaciones extras
pero si alguna de sus validaciones tendrá estas mismas características deberán usar
los respectivos métodos (alguna duda llamar al negro)*/

/*Expresiones regulares y métodos de la librería JqueryValidate*/

jQuery.validator.addMethod('RE_number_letters',function(value,element) {
  return this.optional(element) ||  /^[a-zA-Z0-9]+$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="Caracteres no validos"></span>');

/*Caracteres látinos*/
jQuery.validator.addMethod('RE_LatinCharacters',function(value, element) {
  return this.optional(element) ||  /^[a-zAZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="Caracteres inválidos"></span>');

/*Email*/
jQuery.validator.addMethod('RE_Email',function(value, element) {
  return this.optional(element) ||  /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="El email debe tener el siguiente formato: alguien@ejemplo.com ó alguien@ejemplo.algo.co"></span>');


/*Números enteros*/
jQuery.validator.addMethod('RE_Numbers',function(value, element) {
  return this.optional(element) ||  /^[0-9]+$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="Solo se aceptan números"></span>');

/*Número enteros y decimales (incluye punto '.' y coma ',')*/
jQuery.validator.addMethod('RE_NumbersIntDecimal',function(value, element) {
  return this.optional(element) || /[-+]?([0-9]*\.[0-9]+|[0-9]+)/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="Solo se aceptan números enteros o decimales."></span>');

/*Para contenre al menos número y letras en el usuario o contraseña*/
jQuery.validator.addMethod('RE_Passwords',function(value, element) {
  return this.optional(element) ||  /^([a-z]+[0-9]+)|([0-9]+[a-z]+)/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="La contraseña debe contener números y letras"></span>');

/*Dominio de una url (.com,.es, etc)*/
jQuery.validator.addMethod('RE_URL',function(value, element) {
  return this.optional(element) || /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,6})?([\.\-\w\/_]+)$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="URL no válida, ingrese una correcta"></span>');

/*Usuario cantidad máxima y cantidad mínima de caracteres*/
jQuery.validator.addMethod('RE_Username',function(value, element) {
  return this.optional(element) ||  /^[a-z0-9_-]{6,20}$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="El usuario debe ser [a-z] y/o [0-9], de 6 a 20 caracteres."></span>');

/*Contraseña cantidad máxima y cantidad mínima de caracteres*/
jQuery.validator.addMethod('RE_Passwords2',function(value, element) {
  return this.optional(element) ||  /^[a-z0-9_-]{6,20}$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="La contraseña debe ser [a-z] y/o [0-9], de 6 a 20 caracteres."></span>');


/*Fechas con formato DD/MM/YYYY*/
jQuery.validator.addMethod('RE_Date',function(value, element) {
  return this.optional(element) || /^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="Ingrese una fecha válida (DD/MM/AAAA)<"></span>');

/*Formato correcto para las imagenes */
jQuery.validator.addMethod('RE_Image',function(value, element) {
  return this.optional(element) || /([^\s]+(?=\.(jpg|jpeg|png))\.\2)/gm.test(value);
  //return this.optional(element) ||    /<img.+?src=\"(.*?)\".+?>/ig.test(value);
},'<span class="fa fa-times-circle frmError" msm="Solo se permiten imagenes en formato .jpg, .jpeg y .png"></span>');

/*Formato correcto para los documentos */
jQuery.validator.addMethod('RE_Doc',function(value, element) {
  return this.optional(element) || /([^\s]+(?=\.(doc|pdf|docx))\.\2)/gm.test(value);
  //return this.optional(element) ||    /<img.+?src=\"(.*?)\".+?>/ig.test(value);
},'<span class="fa fa-times-circle frmError" msm="Solo se permiten documentos en formato .doc, .docx y .pdf"></span>');


/*Dominio de una url (.com,.es, etc) */
jQuery.validator.addMethod('RE_WWW',function(value, element) {
  return this.optional(element) ||    /[^w{3}\.]([a-zA-Z0-9]([a-zA-Z0-9\-]{0,65}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/igm.test(value);
},'<span class="fa fa-times-circle frmError" msm="El formato de la URL es incorrecto."></span>');

/*Formato de 24horas, además agregando el am/pm */
jQuery.validator.addMethod('RE_hours',function(value, element) {
  return this.optional(element) || /^([0-1]?[0-9]|[2][0-3]):([0-5][0-9])(:[0-5][0-9])?$/i.test(value);
},'<span class="fa fa-times-circle frmError" msm="El formato de la hora no es válido."></span>');

/*Escoger un item válido del select*/
jQuery.validator.addMethod('RE_Select', function(value, element, arg) {
  return arg != value;
}, '<span class="fa fa-times-circle frmError" msm="Por favor seleccione un item."></span>');

/*Al evento de maxLength se le agrega una función que permite calcular
la cantidad de caracteres máximos NO TOCAR*/
$.fn.maxLength = function(limit, options) {
  var defaults = {
    showNumber: '',
    revert: true
  };
  var options = $.extend(defaults, options);
  element = this;

  function event(e) {
    element.on(e, function() {
      chars = $(this).val().length;
      if (defaults.showNumber != '') {
        defaults.revert == true ? $(defaults.showNumber).text(limit - chars) : $(defaults.showNumber).text(chars);
      }

      if (chars >= limit) {
        $(this).val($(this).val().substr(0, limit - 1));
      }
    });
  }
  event('keypress');
  event('keydown');
  event('keyup');
  event('focus');
};
function mostrarNMensaje(text) {
  return '<span class="fa fa-times-circle frmError" msm="' + text + '"></span>';
}
