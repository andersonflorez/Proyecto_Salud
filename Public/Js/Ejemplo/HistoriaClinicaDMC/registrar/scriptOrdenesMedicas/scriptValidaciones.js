$(document).ready(function(){

    /*========================================VALIDACION======================================*/
    /*===================TRATAMIENTO==================*/
    //fecha limite
    $("#txtFechaLimite").focus(function(){
        tratamientoFechaLimite();
        $("#txtFechaLimite-error").hide();

    });
    $("#txtFechaLimite").focusout(function(){
        tratamientoFechaLimite();
    });

    //descripcion
    $("#txtDescripcionTratamiento").focus(function(){
        tratamientoDescripcion();
        $("#txtDescripcionTratamiento-error").hide();

    });
    $("#txtDescripcionTratamiento").focusout(function(){
        tratamientoDescripcion();
    });

    /*===================FORMULA MEDICA==================*/

    //se hace en funciones abajo

    /*===================EXAMEN ESPECIALIZADO==================*/
    //observaciones
    $("#txtObservacionExamenEspecializado").focus(function(){
        tratamientoFechaLimite();
        $("#txtObservacionExamenEspecializado-error").hide();

    });
    $("#txtObservacionExamenEspecializado").focusout(function(){
        examenObservaciones();
    });

    //descripcion
    $("#txtDescripcionExamenEspecializado").focus(function(){
        examenDescripcion();
        $("#txtDescripcionExamenEspecializado-error").hide();

    });
    $("#txtDescripcionExamenEspecializado").focusout(function(){
        examenDescripcion();
    });

    /*===================INTERCONSULTA==================*/
    //fecha limite
    $("#txtFechaLimiteInterconsulta").focus(function(){
        interconsultaFechaLimite();
        $("#txtFechaLimiteInterconsulta-error").hide();

    });
    $("#txtFechaLimiteInterconsulta").focusout(function(){
        interconsultaFechaLimite();
    });

    //descripcion
    $("#txtDescripcionInterconsulta").focus(function(){
        interconsultaDescripcion();
        $("#txtDescripcionInterconsulta-error").hide();

    });
    $("#txtDescripcionInterconsulta").focusout(function(){
        interconsultaDescripcion();
    });

    /*===================INCAPACIDAD==================*/
    //numero dias
    $("#txtNumeroDias").focus(function(){
        incapacidadNumeroDias();
        $("#txtNumeroDias-error").hide();

    });
    $("#txtNumeroDias").focusout(function(){
        incapacidadNumeroDias();
    });

    //descripcion
    $("#txtDescripcionIncapacidad").focus(function(){
        incapacidadDescripcion();
        $("#txtDescripcionIncapacidad-error").hide();

    });
    $("#txtDescripcionIncapacidad").focusout(function(){
        incapacidadDescripcion();
    });

    /*===================OTRO==================*/
    //descripcion
    $("#txtDescripcionOtro").focus(function(){
        otroDescripcion();
        $("#txtDescripcionOtro-error").hide();

    });
    $("#txtDescripcionOtro").focusout(function(){
        otroDescripcion();
    });

});

/*=================================Validacion tratamiento================================*/
function tratamientoTipo(){
    if($("#cmbTipoTratamiento").val() == ""){
        $("#cmbTipoTratamiento").parent().addClass('frm_contenedorMalo');
        $("#cmbTipoTratamiento-error").remove();
        $("#cmbTipoTratamiento").parent().prepend('<div id="cmbTipoTratamiento-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#cmbTipoTratamiento").parent().removeClass('frm_contenedorMalo');
        $("#cmbTipoTratamiento-error").remove();
    }
}
function tratamientoFechaLimite(){
    if($("#txtFechaLimite").val() == ""){
        $("#txtFechaLimite").parent().addClass('frm_contenedorMalo');
        $("#txtFechaLimite-error").remove();
        $("#txtFechaLimite").parent().append('<div id="txtFechaLimite-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtFechaLimite").parent().removeClass('frm_contenedorMalo');
        $("#txtFechaLimite-error").remove();
    }
}
function tratamientoDescripcion(){
    if($("#txtDescripcionTratamiento").val() == ""){
        $("#txtDescripcionTratamiento").parent().addClass('frm_contenedorMalo');
        $("#txtDescripcionTratamiento-error").remove();
        $("#txtDescripcionTratamiento").parent().append('<div id="txtDescripcionTratamiento-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtDescripcionTratamiento").parent().removeClass('frm_contenedorMalo');
        $("#txtDescripcionTratamiento-error").remove();
    }
}
function tratamientoEquiposBiomedicos(index){
    if($(".cmbEquipoBiomedico").eq(index).val() == ""){
        $(".cmbEquipoBiomedico").eq(index).parent().addClass('frm_contenedorMalo');
        $("#cmbEquipoBiomedico"+index+"-error").remove();
        $(".cmbEquipoBiomedico").eq(index).parent().prepend('<div id="cmbEquipoBiomedico'+index+'-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $(".cmbEquipoBiomedico").eq(index).parent().removeClass('frm_contenedorMalo');
        $("#cmbEquipoBiomedico"+index+"-error").remove();
    }
}


/*=================================Validacion formula medica================================*/

function validacionFormulaMedica(){
    //cantidad
    $(".txtCantidadMedicamentos").focus(function(){
        var index = $(".txtCantidadMedicamentos").index(this);
        if($(".cmbMedicamentos").eq(index).val() != null){
            formulaCantidad(index);
            $("#txtCantidadMedicamentos"+index+"-error").hide();   
        }
    });
    $(".txtCantidadMedicamentos").focusout(function(){
        var index = $(".txtCantidadMedicamentos").index(this);
        if($(".cmbMedicamentos").eq(index).val() != null){
            formulaCantidad(index);
        }
    });

    //dosificacion
    $(".txtDosificacionMedicamento").focus(function(){
        var index = $(".txtDosificacionMedicamento").index(this);
        if($(".cmbMedicamentos").eq(index).val() != null){
            formulaDosificacion(index);
            $("#txtDosificacionMedicamento"+index+"-error").hide();
        }

    });
    $(".txtDosificacionMedicamento").focusout(function(){
        var index = $(".txtDosificacionMedicamento").index(this);
        if($(".cmbMedicamentos").eq(index).val() != null){
            formulaDosificacion(index);
        }
    });
}



function formulaCantidad(index){
    if($(".txtCantidadMedicamentos").eq(index).val() == ""){
        $(".txtCantidadMedicamentos").eq(index).parent().addClass('frm_contenedorMalo');
        $("#txtCantidadMedicamentos"+index+"-error").remove();
        $(".txtCantidadMedicamentos").eq(index).parent().append('<div id="txtCantidadMedicamentos'+index+'-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else if(isNaN($(".txtCantidadMedicamentos").eq(index).val())){
        $(".txtCantidadMedicamentos").eq(index).parent().addClass('frm_contenedorMalo');
        $("#txtCantidadMedicamentos"+index+"-error").remove();
        $(".txtCantidadMedicamentos").eq(index).parent().append('<div id="txtCantidadMedicamentos'+index+'-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Solo se aceptan números."></span></div>');
    }
    else{
        $(".txtCantidadMedicamentos").eq(index).parent().removeClass('frm_contenedorMalo');
        $("#txtCantidadMedicamentos"+index+"-error").remove();
    }
}
function formulaDosificacion(index){
    if($(".txtDosificacionMedicamento").eq(index).val() == ""){
        $(".txtDosificacionMedicamento").eq(index).parent().addClass('frm_contenedorMalo');
        $("#txtDosificacionMedicamento"+index+"-error").remove();
        $(".txtDosificacionMedicamento").eq(index).parent().append('<div id="txtDosificacionMedicamento'+index+'-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $(".txtDosificacionMedicamento").eq(index).parent().removeClass('frm_contenedorMalo');
        $("#txtDosificacionMedicamento"+index+"-error").remove();
    }
}


/*=================================Validacion examen especializado================================*/
function examenTipo(){
    if($("#cmbTipoExamenEspecializado").val() == ""){
        $("#cmbTipoExamenEspecializado").parent().addClass('frm_contenedorMalo');
        $("#cmbTipoExamenEspecializado-error").remove();
        $("#cmbTipoExamenEspecializado").parent().prepend('<div id="cmbTipoExamenEspecializado-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#cmbTipoExamenEspecializado").parent().removeClass('frm_contenedorMalo');
        $("#cmbTipoExamenEspecializado-error").remove();
    }
}
function examenObservaciones(){
    if($("#txtObservacionExamenEspecializado").val() == ""){
        $("#txtObservacionExamenEspecializado").parent().addClass('frm_contenedorMalo');
        $("#txtObservacionExamenEspecializado-error").remove();
        $("#txtObservacionExamenEspecializado").parent().append('<div id="txtObservacionExamenEspecializado-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtObservacionExamenEspecializado").parent().removeClass('frm_contenedorMalo');
        $("#txtObservacionExamenEspecializado-error").remove();
    }
}
function examenDescripcion(){
    if($("#txtDescripcionExamenEspecializado").val() == ""){
        $("#txtDescripcionExamenEspecializado").parent().addClass('frm_contenedorMalo');
        $("#txtDescripcionExamenEspecializado-error").remove();
        $("#txtDescripcionExamenEspecializado").parent().append('<div id="txtDescripcionExamenEspecializado-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtDescripcionExamenEspecializado").parent().removeClass('frm_contenedorMalo');
        $("#txtDescripcionExamenEspecializado-error").remove();
    }
}


/*=================================Validacion interconsula================================*/
function interconsultaEspecialidad(){
    if($("#cmbEspecialidad").val() == ""){
        $("#cmbEspecialidad").parent().addClass('frm_contenedorMalo');
        $("#cmbEspecialidad-error").remove();
        $("#cmbEspecialidad").parent().prepend('<div id="cmbEspecialidad-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#cmbEspecialidad").parent().removeClass('frm_contenedorMalo');
        $("#cmbEspecialidad-error").remove();
    }
}
function interconsultaFechaLimite(){
    if($("#txtFechaLimiteInterconsulta").val() == ""){
        $("#txtFechaLimiteInterconsulta").parent().addClass('frm_contenedorMalo');
        $("#txtFechaLimiteInterconsulta-error").remove();
        $("#txtFechaLimiteInterconsulta").parent().append('<div id="txtFechaLimiteInterconsulta-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtFechaLimiteInterconsulta").parent().removeClass('frm_contenedorMalo');
        $("#txtFechaLimiteInterconsulta-error").remove();
    }
}
function interconsultaDescripcion(){
    if($("#txtDescripcionInterconsulta").val() == ""){
        $("#txtDescripcionInterconsulta").parent().addClass('frm_contenedorMalo');
        $("#txtDescripcionInterconsulta-error").remove();
        $("#txtDescripcionInterconsulta").parent().append('<div id="txtDescripcionInterconsulta-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtDescripcionInterconsulta").parent().removeClass('frm_contenedorMalo');
        $("#txtDescripcionInterconsulta-error").remove();
    }
}

/*=================================Validacion incapacidad================================*/
function incapacidadCodigoCIE10(){
    if($("#cmbCodigoCIE10").val() == ""){
        $("#cmbCodigoCIE10").parent().addClass('frm_contenedorMalo');
        $("#cmbCodigoCIE10-error").remove();
        $("#cmbCodigoCIE10").parent().prepend('<div id="cmbCodigoCIE10-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#cmbCodigoCIE10").parent().removeClass('frm_contenedorMalo');
        $("#cmbCodigoCIE10-error").remove();
    }
}
function incapacidadDescripcionCIE10(){
    if($("#cmbDescripcionCIE10").val() == ""){
        $("#cmbDescripcionCIE10").parent().addClass('frm_contenedorMalo');
        $("#cmbDescripcionCIE10-error").remove();
        $("#cmbDescripcionCIE10").parent().prepend('<div id="cmbDescripcionCIE10-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#cmbDescripcionCIE10").parent().removeClass('frm_contenedorMalo');
        $("#cmbDescripcionCIE10-error").remove();
    }
}
function incapacidadNumeroDias(){
    if($("#txtNumeroDias").val() == ""){
        $("#txtNumeroDias").parent().addClass('frm_contenedorMalo');
        $("#txtNumeroDias-error").remove();
        $("#txtNumeroDias").parent().append('<div id="txtNumeroDias-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else if($("#txtNumeroDias").val() < 1){
        $("#txtNumeroDias").parent().addClass('frm_contenedorMalo');
        $("#txtNumeroDias-error").remove();
        $("#txtNumeroDias").parent().append('<div id="txtNumeroDias-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Por favor, escribe un valor mayor o igual a 1."></span></div>');
    }
    else if($("#txtNumeroDias").val() > 100){
        $("#txtNumeroDias").parent().addClass('frm_contenedorMalo');
        $("#txtNumeroDias-error").remove();
        $("#txtNumeroDias").parent().append('<div id="txtNumeroDias-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Por favor, escribe un valor menor o igual a 100."></span></div>');
    }
    else{
        $("#txtNumeroDias").parent().removeClass('frm_contenedorMalo');
        $("#txtNumeroDias-error").remove();
    }
}
function incapacidadDescripcion(){
    if($("#txtDescripcionIncapacidad").val() == ""){
        $("#txtDescripcionIncapacidad").parent().addClass('frm_contenedorMalo');
        $("#txtDescripcionIncapacidad-error").remove();
        $("#txtDescripcionIncapacidad").parent().append('<div id="txtDescripcionIncapacidad-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtDescripcionIncapacidad").parent().removeClass('frm_contenedorMalo');
        $("#txtDescripcionIncapacidad-error").remove();
    }
}




/*=================================Validacion interconsula================================*/
function otroDescripcion(){
    if($("#txtDescripcionOtro").val() == ""){
        $("#txtDescripcionOtro").parent().addClass('frm_contenedorMalo');
        $("#txtDescripcionOtro-error").remove();
        $("#txtDescripcionOtro").parent().append('<div id="txtDescripcionOtro-error" class="frm_mensajeVal wrapper" style="display: block;"><span class="fa fa-times-circle frmError" msm="Este campo es obligatorio."></span></div>');
    }
    else{
        $("#txtDescripcionOtro").parent().removeClass('frm_contenedorMalo');
        $("#txtDescripcionOtro-error").remove();
    }
}














