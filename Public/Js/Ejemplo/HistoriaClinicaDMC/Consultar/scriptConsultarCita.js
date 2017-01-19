$(document).ready(function(){
    var frm = '#frmFiltroCita';
    // Configuración Basica para el paginador
    var options = {
        parent: 'paginadorDinamico',
        url: 'HistoriaClinicaDMC/ctrlConsultarCita/ListarCitas',
        configuration: {
            tableName: '..', // Es recomendable hacer esto desde el controlador
            limit: 6
        }
    };


    var generarPaginador = function(resultado) {
        resultado = resultado || 'No Se Encuentran Citas.';
        paginator.view.generateButtons(options)
            .then(function(data) {
            if (data.datos !== null) {
                consultaCitas(data); // Primera vez
                $(frm + ' #limiteTodos').val(data.cantidadRegistros);
            }else {
                noResultado(resultado);
            }
            $('#' + options.parent).on('click', 'li.btn_paginador', function() {
                Paginate(options, $(this), function(data) {
                    if (data.datos !== null) {
                        consultaCitas(data); // Segunda vez
                        $(frm + ' #limiteTodos').val(data.cantidadRegistros);
                    }else {
                        noResultado(resultado);
                    }
                });
            });
        });
    };

    generarPaginador();

    // Click en el icono de buscar:
    $('#btnBuscar').click(function () {
        filter();
    });

    // Evento enter en el campo de busqueda:
    $('#txtinputBusqueda').keyup(function(e){
        if(e.keyCode == 13) {
            filter();
        }
    });

    // Input filtrar por:
    $(frm + ' .filterBy').change(function () {
        filter();
    });

    // Input filtrar por:
    $(frm + ' .limit').change(function () {
        filter();
    });

    // Input buscar por:
    $(frm + ' .nameColumnFilter').change(function () {
        // if ($('#txtinputBusqueda').val()) {
        filter();
        // }
    });

    // Input ordenar por:
    $(frm + ' .nameColumnOrderBy').change(function () {
        filter();
    });

    // Input ordenar por:
    $(frm + ' .orderBy').change(function () {
        filter();
    });

    // Validar fechas filtro:
    ValidateForm('frmFiltroCita', function(date) {
        options.configuration.filterDateTimeStart = date.initialDate;
        options.configuration.filterDateTimeEnd = date.finalDate;
        filter();
    });

    $('.reset_search').click(function (event) {
        options.configuration.filterDateTimeStart = '';
        options.configuration.filterDateTimeEnd = '';
        $('#txtinputBusqueda').val('');
        filter();
        event.stopPropagation();
    });


    var filter = function () {
        let config = JSON.parse(JSON.stringify($('#frmFiltroCita').serializeArray()));
        options.configuration.limit = Number(config[0].value);
        options.configuration.page = 1;
        options.configuration.nameColumnFilter = Number(config[1].value);
        options.configuration.filter = $('#txtinputBusqueda').val() || '';

        // console.log("options", options);

        generarPaginador('No se encontraron resultados que coincidan con el filtro solicitado.');

    };
    
    var noResultado = function(resultado){
        $("#cont").html("");
        alert(resultado);
    };
});

function consultaCitas(data){
$("#cont").html("");
    if (data != null || data !=0){
        $.each(data.datos,function(s,p){
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
                                  +    "<span><i class='fa fa-clock-o'></i> "+p.horaInicial+"</span>"
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
        $.each(data.datos,function(s,p){
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
                                  +    "<span><i class='fa fa-clock-o'></i> "+p.horaInicial+"</span>"
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
}

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
                localStorage.setItem("Citapendiente",btoa(idCita));
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
    var id = atob(localStorage.getItem("Citapendiente"));
    if (id == idCita) {
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
    }else{
      Notificate({
          tipo: 'warning',
          titulo: 'Notificación de advertencia',
          descripcion: 'No puede cancelar la cita'
      });
    }

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
        $("#panelCita").show();
        $("#panelDerecho").hide();
    });

});

function mostrarCita(idCita,el){
    $("#panelCita").fadeOut(100,function(){
        if (!$("#panelCita").hasClass("lg_flex_col65 xl_flex_col75")) {
          $("#panelCita").addClass("lg_flex_col65 xl_flex_col75");
        }
        if (!$("#panelDerecho").hasClass("lg_flex_col35 xl_flex_col25 n_flex_col100")) {
          $("#panelDerecho").addClass("lg_flex_col35 xl_flex_col25 n_flex_col100");
          $("#panelDerecho").fadeIn(100);
        }
        $(".panelAtencionSeleccionado").removeClass("panelAtencionSeleccionado");
        $(el).parent().parent().parent().parent().addClass("panelAtencionSeleccionado");
        $("#panelCita").show();
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
