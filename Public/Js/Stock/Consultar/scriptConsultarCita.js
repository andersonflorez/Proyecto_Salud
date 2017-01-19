function consultaCitas(){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "HistoriaClinicaDMC/ctrlConsultarCita/ListarCitas",
        async: false
    }).done(function(data){
        if (data != null || data !=0){
            $.each(data,function(s,p){
                if (p.estadoTablaCita == "Proceso") {
                    $("#cont").append("<li class='list_item n_dont_grow'>"
                                      + "<div class='list_item_header n_flex n_nowrap'><div class='item_icon n_flex n_align_center'>"
                                      +"<span class='fa fa-calendar-minus-o'></span></div><div class='item_title n_grow_up horizontal_padding vertical_padding ovf_hidden'>"
                                      +   "<h5 class='text_bold suspensive'>"+p.primerNombre+" "+p.primerApellido +"</h5>"
                                      + "</div>"
                                      + "</div>"
                                      +"<div class='list_item_content suspensive_3'>"
                                      + "<p class='paragraph'>"
                                      +   "<span class='text_bold'>Telefono: </span>"
                                      + p.telefonoFijo1
                                      +"</p>"
                                      +"</div>"
                                      +"<div class='list_item_content suspensive_3'>"
                                      + "<p class='paragraph'>"
                                      + "<span class='text_bold'>Barrio: </span>"
                                      + p.descripcionZona
                                      + "</p>"
                                      +"</div>"
                                      +"<div class='list_item_content suspensive_3'>"
                                      + "<p class='paragraph'>"
                                      +   "<span class='text_bold'>Direccion: </span>"
                                      + p.direccionCita
                                      +"</p>"
                                      +"</div>"
                                      +"<div class='list_item_footer n_flex n_justify_between n_align_center horizontal_padding'>"
                                      +  "<div class='footer_element'>"
                                      +    "<span><i class='fa fa-clock-o'></i> "+p.horaInicial+" - "+p.horaFinal+"</span>"
                                      +  "</div>"
                                      +"<div class='footer_element n_flex'>"
                                      +   "<div class='tooltip separate_right'>"
                                      +     "<span class='button' style='color:#1F95D0;' onclick='mostrarCita("+p.idCita+",this)'><i class='fa fa-eye'></i></span>"
                                      +     "<span class='tooltiptext' style='width:80px;'>Detalles</span>"
                                      +   "</div>"
                                      +   "<div class='tooltip separate_right'>"
                                      +     "<span class='button' onclick='Cancelar("+p.idCita+")'><i class='fa fa-ban'></i></span>"
                                      +     "<span class='tooltiptext' style='width:80px;'>Cancelar</span>"
                                      +   "</div>"
                                      +   "<div class='tooltip separate_right'>"
                                      +     "<span class='button' style='color:rgba(229,152,42,0.89);' onclick='validaPendiente("+p.idPaciente+","+p.idCitaProgramacion+","+p.idCita+")'><i class='fa fa-hourglass-2'></i></span>"
                                      +     "<span class='tooltiptext'>Continuar</span>"
                                      +   "</div>"
                                      + "</div>"
                                      + "</div>"
                                      +"</div>");
                }
            });
            $.each(data,function(s,p){
                if (p.estadoTablaCita == "Iniciada") {
                    $("#cont").append("<li class='list_item n_dont_grow'>"
                                      + "<div class='list_item_header n_flex n_nowrap'><div class='item_icon n_flex n_align_center'>"
                                      +"<span class='fa fa-calendar-minus-o'></span></div><div class='item_title n_grow_up horizontal_padding vertical_padding ovf_hidden'>"
                                      +   "<h5 class='text_bold suspensive'>"+p.primerNombre+" "+p.primerApellido +"</h5>"
                                      + "</div>"
                                      + "</div>"
                                      +"<div class='list_item_content suspensive_3'>"
                                      + "<p class='paragraph'>"
                                      +   "<span class='text_bold'>Telefono: </span>"
                                      + p.telefonoFijo1
                                      +"</p>"
                                      +"</div>"
                                      +"<div class='list_item_content suspensive_3'>"
                                      + "<p class='paragraph'>"
                                      + "<span class='text_bold'>Barrio: </span>"
                                      + p.descripcionZona
                                      + "</p>"
                                      +"</div>"
                                      +"<div class='list_item_content suspensive_3'>"
                                      + "<p class='paragraph'>"
                                      +   "<span class='text_bold'>Direccion: </span>"
                                      + p.direccionCita
                                      +"</p>"
                                      +"</div>"
                                      +"<div class='list_item_footer n_flex n_justify_between n_align_center horizontal_padding'>"
                                      +  "<div class='footer_element'>"
                                      +    "<span><i class='fa fa-clock-o'></i> "+p.horaInicial+" - "+p.horaFinal+"</span>"
                                      +  "</div>"
                                      +"<div class='footer_element n_flex'>"
                                      +   "<div class='tooltip separate_right'>"
                                      +     "<span class='button' style='color:#1F95D0;' onclick='mostrarCita("+p.idCita+",this)'><i class='fa fa-eye'></i></span>"
                                      +     "<span class='tooltiptext' style='width:80px;'>Detalles</span>"
                                      +   "</div>"
                                      +   "<div class='tooltip separate_right'>"
                                      +     "<span class='button' onclick='Cancelar("+p.idCita+")'><i class='fa fa-ban'></i></span>"
                                      +     "<span class='tooltiptext' style='width:80px;'>Cancelar</span>"
                                      +   "</div>"
                                      +   "<div class='tooltip separate_right'>"
                                      +     "<span class='button' style='color:#2ecc71;' onclick='Comfirmar("+p.idPaciente+","+p.idCitaProgramacion+","+p.idCita+")'><i class='fa fa-check'></i></span>"
                                      +     "<span class='tooltiptext'>Confirmar</span>"
                                      +   "</div>"
                                      + "</div>"
                                      + "</div>"
                                      +"</div>");
                }
            });

        }else {
            alert("No tiene citas")
        }
    });
}
consultaCitas();
function Comfirmar(idPaciente,idCitaProgramacion,idCita){

    if (localStorage.getItem("Citapendiente") == null) {
        swal({
            title: "Confirmar",
            text: "¿Esta seguro que desea confirmar la cita?",
            type: "info",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: true,
        },function() {
            $.ajax({
                data:"POST",
                dataType: "JSON",
                url: url + "HistoriaClinicaDMC/ctrlConsultarCita/cambiarEstadoProceso/"+idCita+"",
                async: false
            }).done(function(data){
                localStorage.setItem("Citapendiente","1");
                var idPacienteE = btoa(idPaciente);
                var idCitaE = btoa(idCita);
                var idCitaProgramacionE = btoa(idCitaProgramacion);
                window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarInformacionPersonalAtencion/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
            });
        });
    }else{
        Notificate({
            tipo: 'warning',
            titulo: 'Notificación de advertencia',
            descripcion: 'Asegúrese de terminar la cita pendiente.'
        });
    }
};

function Cancelar(idCita){
    swal({
        title: "Cancelar",
        type: "input",

        confirmButtonText: "Registrar",
        confirmButtonColor: "#2ecc71",
        cancelButtonText: "Cancelar",
        showCancelButton: true,
        closeOnConfirm: false,
        inputPlaceholder: "motivo de la cancelación" 
    },
         function(inputValue){
        if (inputValue === false)
            return false;
        if (inputValue === "") {
            swal.showInputError("Debes escribir el motivo de la cancelación!");
            return false
        }
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data:{"des":inputValue, "idCita" : idCita},
            url: url + "HistoriaClinicaDMC/ctrlConsultarCita/cancelarCita",
            async: false
        }).done(function(data){
            if (data == 0) {
                localStorage.removeItem("Citapendiente");
                swal("Cita cancelada correctamente!", "Motivo: " + inputValue, "success");
                $("#cont").children().remove();
                consultaCitas();
            }else {
                return false;
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data:{"des":inputValue, "idCita" : idCita, "idMulta":idMulta},
                url: url + "HistoriaClinicaDMC/ctrlConsultarCita/cancelarCita",
                async: false
            }).done(function(data){
                if (data == 0) {
                    swal("Cita cancelada correctamente!", "Motivo: " + inputValue, "success");
                    $("#cont").children().remove();
                    consultaCitas();
                }else {
                    return false;
                }
            }).fail(function(ex){
                console.log(ex);
            });
        });
    });
}

// Al dar click a un botón paginador:
$('.btn_paginador').click(function() {

    // Capturar el botón clickeado:
    let btn = $(this);

    // Si el botón clickeado no es el que está activo:
    if (!btn.hasClass('active')) {

        // Identificar el botón activo:
        let parent = btn.parent();
        let active = parent.find('li.btn_paginador.active');

        // Si el botón clickeado es un pasador:
        if (btn.hasClass('slider')) {
            let target;

            // Si el botón clickeado es 'siguiente':
            if (btn.hasClass('siguiente')) {
                // Capturar el botón siguiente en 'target':
                target = active.next();
            } else {
                // Capturar el botón anterior en 'target':
                target = active.prev();
            }

            // Si 'target' no es un pasador entonces paginar:
            if (!target.hasClass('slider')) {
                // Aqui iría el código para actualizar la vista
                active.removeClass('active');
                target.addClass('active');
            }
        } else {
            // Aqui iría el código para actualizar la vista

            // Paginar
            active.removeClass('active');
            btn.addClass('active');
        }
    }
});
$("#btnCerrar").click(function(){
    $("#panelCita").fadeOut(100,function(){
        $("#panelCita").removeClass("lg_flex_col65 xl_flex_col75");
        $(".panelAtencionSeleccionado").removeClass("panelAtencionSeleccionado");
        $("#panelDerecho").removeClass("lg_flex_col35 xl_flex_col25 n_flex_col100");
        $("#panelCita").show(100);
        $("#panelDerecho").hide();
    });

});

function mostrarCita(idCita,el){
    $("#panelCita").fadeOut(100,function(){
        $("#panelCita").addClass("lg_flex_col65 xl_flex_col75");
        $(".panelAtencionSeleccionado").removeClass("panelAtencionSeleccionado");
        $("#panelDerecho").addClass("lg_flex_col35 xl_flex_col25 n_flex_col100");
        $(el).parent().parent().parent().parent().addClass("panelAtencionSeleccionado");
        $("#panelCita").show(100);
        $("#panelDerecho").fadeIn(100);
    });
    $.ajax({
        data: 'POST',
        dataType: 'JSON',
        url: url + "HistoriaClinicaDMC/ctrlConsultarCita/consultarCitaPersona/"+idCita+"",
        async: false
    }).done(function(data){
        $.each(data,function(s,p){
            $("#lblNombre").html(p.primerNombre+" "+p.segundoNombre);
            $("#lblApellido").html(p.primerApellido+" "+p.segundoApellido);
            $("#lblDocumento").html(p.numeroDocumento);
            $("#lblHi").html(p.horaInicial);
            $("#lblHf").html(p.horaFinal);
            $("#lblCup").html(p.nombreCUP);
            $("#lblBarrio").html(p.barrioResidencia);
            $("#lblZona").html(p.descripcionZona);
            $("#lblDir").html(p.direccionCita);
        });
    }).fail(function(){});
}

function validaPendiente(idPaciente,idCitaProgramacion,idCita){
    var idPacienteE = btoa(idPaciente);
    var idCitaE = btoa(idCita);
    var idCitaProgramacionE = btoa(idCitaProgramacion);
    if (localStorage.getItem("informacionPersonal") != null && localStorage.getItem("atencion") && localStorage.getItem("evolucion")) {
        if (localStorage.getItem("antecedentes") != null && localStorage.getItem("examenFisico") != null ) {
            if (localStorage.getItem("signosVitales") != null ) {
                if (localStorage.getItem("procedimientos") != null && localStorage.getItem("diagnostico") != null ) {
                    if (localStorage.getItem("medicacion") != null ) {
                        window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
                    }else{
                        window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarMedicacion/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
                    }
                }else{
                    window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
                }
            }else{
                window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarSignosVitales/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
            }
        }else{
            window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarAntecedentesExamenes/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
        }
    }else{
        window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarInformacionPersonalAtencion/index/"+idPacienteE+"/"+idCitaE+"/"+idCitaProgramacionE+"");
    }
}
