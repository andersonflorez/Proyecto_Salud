$(document).ready(function(){  
    $("#btnTerminarHistoriaClinica").click(function(){
        if($("#item1").is(":visible")){
            tratamientoTipo();
            tratamientoFechaLimite();
            tratamientoDescripcion();

            $(".cmbEquipoBiomedico").each(function(i,e){
                tratamientoEquiposBiomedicos(i);
            });
            if($("#cmbTipoTratamiento").val() == ""){
                $("#item1").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Tratamiento'
                });
                return;
            }
            if($("#txtFechaLimite").val() == ""){
                $("#item1").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden medica Tratamiento'
                });
                return;
            }
            if($("#txtDescripcionTratamiento").val() == ""){
                $("#item1").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Tratamiento'
                });
                return;
            }
            var cont=0;
            $(".cmbEquipoBiomedico").each(function(i,e){
                if($(e).val()==""){
                    cont++;
                }
            });
            if(cont>0){
                $("#item1").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Tratamiento'
                });
                return;
            }
            $("#item1").removeClass("itemMenuError");
        }
        if($("#item2").is(":visible")){
            $(".txtCantidadMedicamentos").each(function(i,e){
                if($(".cmbMedicamentos").eq(i).val() != null){
                    formulaCantidad(i);
                }

            });

            $(".txtDosificacionMedicamento").each(function(i,e){
                if($(".cmbMedicamentos").eq(i).val() != null){
                    formulaDosificacion(i);
                }
            });
            var cont =0;
            $(".txtCantidadMedicamentos").each(function(i,e){
                if($(e).val() == "" || isNaN($(e).val())){
                    cont++;
                }
            });
            if(cont>0){
                $("#item2").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Fórmula Médica'
                });
                return;
            }
            cont =0;
            $(".txtDosificacionMedicamento").each(function(i,e){
                if($(e).val() == ""){
                    cont++;
                }
            });
            if(cont>0){
                $("#item2").addClass("itemMenuError");
                return;
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Fórmula Médica'
                });
            }
            $("#item2").removeClass("itemMenuError");
        }

        if($("#item3").is(":visible")){
            examenTipo();
            examenObservaciones();
            examenDescripcion();
            if($("#cmbTipoExamenEspecializado").val() == ""){
                $("#item3").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Exámen Especializado'
                });
                return;
            }
            if($("#txtObservacionExamenEspecializado").val() == ""){
                $("#item3").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Exámen Especializado'
                });
                return;
            }
            if($("#txtDescripcionExamenEspecializado").val() == ""){
                $("#item3").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Exámen Especializado'
                });
                return;
            }
            $("#item3").removeClass("itemMenuError");

        }
        if($("#item4").is(":visible")){
            interconsultaEspecialidad();
            interconsultaDescripcion();
            interconsultaFechaLimite();
            if($("#cmbEspecialidad").val() == ""){
                $("#item4").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Interconsulta'
                });
                return;
            }
            if($("#txtDescripcionInterconsulta").val() == ""){
                $("#item4").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Interconsulta'
                });
                return;
            }
            if($("#txtFechaLimiteInterconsulta").val() == ""){
                $("#item4").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Interconsulta'
                });
                return;
            }
            $("#item4").removeClass("itemMenuError");
        }
        if($("#item5").is(":visible")){
            incapacidadNumeroDias();
            incapacidadCodigoCIE10();
            incapacidadDescripcionCIE10();
            incapacidadDescripcion();

            if(!$("#siProrroga").is(":checked") && !$("#noProrroga").is(":checked")){
                //se aplica clase de error accediendo a cada radio desde el contenedor padre
                $("#siProrroga").parent().children().eq(1).addClass("radioError");
                $("#noProrroga").parent().children().eq(1).addClass("radioError");

                $("#item5").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Incapacidad'
                });
                return;
            }
            if($("#txtNumeroDias").val() == ""){
                $("#item5").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Incapacidad'
                });
                return;
            }
            if($("#cmbCodigoCIE10").val() == ""){
                $("#item5").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Incapacidad'
                });
                return;
            }
            if($("#cmbDescripcionCIE10").val() == ""){
                $("#item5").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden medica Incapacidad'
                });
                return;
            }
            if($("#txtDescripcionIncapacidad").val() == ""){
                $("#item5").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Incapacidad'
                });
                return;
            }
            $("#item5").removeClass("itemMenuError");
        }
        if($("#item6").is(":visible")){
            otroDescripcion();
            if($("#txtDescripcionOtro").val() == ""){
                $("#item6").addClass("itemMenuError");
                Notificate({
                    tipo: 'error',
                    titulo: '¡Error',
                    descripcion: 'Debe terminar la órden médica Otra'
                });
                return;
            }
            $("#item6").removeClass("itemMenuError");
        }

        finalizarTratamiento();
        finalizarFormulaMedica();
        finalizarExamenEspecializado();
        finalizarInterconsulta();
        finalizarIncapacidad();
        finalizarOtro();

        window.location = url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;

    });

    $("#Item1").hide();
    $("#Item2").hide();
    $("#Item3").hide();
    $("#Item4").hide();
    $("#Item5").hide();
    $("#Item6").hide();

    $("#item7").click(function(){

        var cualquiera = '<div class="filas">'
        +'<div style="margin-left:22%">'
        +'<label for="chbOrdenItem1">Tratamiento</label>'
        +'<div class="checkbox Center" style="margin-left:8px">'
        +'<input id="chbOrdenItem1" type="checkbox">'
        +'<label for="chbOrdenItem1"><i class="fa fa-check"></i></label>'
        +'</div></div>'
        +'<div style="margin-left:19%">'
        +'<label for="chbOrdenItem2">Fórmula médica</label>'
        +'<div class="checkbox Center" style="margin-left:9px">'
        +'<input id="chbOrdenItem2" type="checkbox">'
        +'<label for="chbOrdenItem2"><i class="fa fa-check"></i></label>'
        +'</div></div>'
        +'</div><br>'
        +'<div class="filas">'
        +'<div style="margin-left:22%">'
        +'<label for="chbOrdenItem4">Interconsulta</label>'
        +'<div class="checkbox Center" style="margin-left:8px">'
        +'<input id="chbOrdenItem4" type="checkbox">'
        +'<label for="chbOrdenItem4"><i class="fa fa-check"></i></label>'
        +'</div></div>'
        +'<div style="margin-left:13%">'
        +'<label for="chbOrdenItem3">Exámen especializado</label>'
        +'<div class="checkbox Center" style="margin-left:31px">'
        +'<input id="chbOrdenItem3" type="checkbox">'
        +'<label for="chbOrdenItem3"><i class="fa fa-check"></i></label>'
        +'</div></div>'
        +'</div><br>'
        +'<div class="filas">'
        +'<div style="margin-left:22%">'
        +'<label for="chbOrdenItem5">Incapacidad</label>'
        +'<div class="checkbox Center" style="margin-left:8px">'
        +'<input id="chbOrdenItem5" type="checkbox">'
        +'<label for="chbOrdenItem5"><i class="fa fa-check"></i></label>'
        +'</div></div>'
        +'<div style="margin-left:19%">'
        +'<label for="chbOrdenItem6">Otro</label>'
        +'<div class="checkbox Center" style="margin-left:8px">'
        +'<input id="chbOrdenItem6" type="checkbox">'
        +'<label for="chbOrdenItem6"><i class="fa fa-check"></i></label>'
        +'</div></div>'
        +'</div>';

        swal({   
            title: "Órdenes médicas",   
            text:cualquiera,   
            html:true,  
            showCancelButton: true,   
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        }, 
             function(confirmacion){ 

            if (!confirmacion){
                swal.close();
            }
            else{
                if($("#chbOrdenItem1").is(":checked")){
                    $("#item1").show();
                }else{
                    $("#item1").hide();
                }

                if($("#chbOrdenItem2").is(":checked")){
                    $("#item2").show();
                }else{
                    $("#item2").hide();
                }

                if($("#chbOrdenItem3").is(":checked")){
                    $("#item3").show();
                }else{
                    $("#item3").hide();
                }

                if($("#chbOrdenItem4").is(":checked")){
                    $("#item4").show();
                }else{
                    $("#item4").hide();
                }

                if($("#chbOrdenItem5").is(":checked")){
                    $("#item5").show();
                }else{
                    $("#item5").hide();
                }

                if($("#chbOrdenItem6").is(":checked")){
                    $("#item6").show();
                }else{
                    $("#item6").hide();
                }
                $("#Item1").hide();
                $("#Item2").hide();
                $("#Item3").hide();
                $("#Item4").hide();
                $("#Item5").hide();
                $("#Item6").hide();
                swal.close();
                $("#marcaOrdenesMedicas").addClass("marcaAgua");
                    $("#marcaOrdenesMedicas").show();
            }
        });
    });
});