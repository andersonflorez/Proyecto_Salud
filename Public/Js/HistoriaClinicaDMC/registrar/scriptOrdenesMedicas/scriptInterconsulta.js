$(document).ready(function () {

    var myDatepicker = $('#txtFechaLimiteInterconsulta').datepicker().data('datepicker');

    $("#txtFechaLimiteInterconsulta").datepicker({
        language: 'es',
        minDate: new Date(),
        position: "bottom left",
        onSelect: function (formattedDate) {
            myDatepicker.hide();
        }
    });



    $("#txtFechaLimiteInterconsulta").blur(function () {
        var valorFecha = $("#txtFechaLimiteInterconsulta").val();
        var fecha = new Date(valorFecha);
        var fechaActual = new Date();
        
        if ((fecha.getDate() < fechaActual.getDate()) || (fecha.getMonth() < fechaActual.getMonth()) 
            || (fecha.getYear() < fechaActual.getYear())) {         
            Notificate({
                tipo: 'warning',
                titulo: 'Cuidado con la fecha',
                descripcion: 'No debe seleccionar una fecha menor a la fecha actual.',
                duracion:4
            });
            $("#txtFechaLimiteInterconsulta").val("").focus();
        }
    });

    $("#cmbEspecialidad").html("<option></option>");
    $.ajax({
        dataType: 'json',
        url: url + "HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas/consultarEspecialidad"
    }).done(function (data) {
        $.each(data, function (i, d) {
            $("#cmbEspecialidad").append("<option value='" + d.descripcionEspecialidad + "'>" + d.descripcionEspecialidad + "</option>");
        });
        $("#cmbEspecialidad").append("<option value='otro'>Otro</option>");
        $("#cmbEspecialidad").select2({
            placeholder: 'Selecciones una opción'
        });
    }).fail(function () {
        alert("Error en examen fisico");
    });


    $("#item4").click(function () {
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item4").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();

        $("#cmbEspecialidad").change(function () {
            if ($("#cmbEspecialidad").val() == "otro") {
                $("#cmbEspecialidad > option").removeAttr("selected");
                $("#cmbEspecialidad > option").eq(0).attr("selected", "selected");
                swal({
                        title: "Especialidad",
                        text: "Ingrese la nueva especialidad:",
                        type: "input",
                        confirmButtonText: "Registrar",
                        confirmButtonColor: "#2ecc71",
                        cancelButtonText: "Cancelar",
                        showCancelButton: true,
                        closeOnConfirm: false
                    },
                    function (inputValue) {

                        if (inputValue === false) {
                            swal.close();
                        } else if (inputValue === "") {
                            swal.close();
                        } else {
                            $("#cmbEspecialidad option[estado='0']").remove();
                            $("#cmbEspecialidad").append("<option estado='0' value='" + inputValue + "'>" + inputValue + "</option>");
                            $("#cmbEspecialidad > option").removeAttr("selected");
                            $("#cmbEspecialidad > option").last().attr("selected", "selected");
                            $("#cmbEspecialidad").select2({
                                placeholder: 'Selecciones una opción'
                            });
                            swal.close();
                            Notificate({
                                tipo: 'success',
                                titulo: '¡Agregado',
                                descripcion: 'Se agrego la especialidad correctamente'
                            });
                        }

                    });
            }
        });

    });
});


function finalizarInterconsulta() {
    localStorage.setItem("ordenMedicaInterconsulta", "");
    if ($("#item4").is(":visible")) {
        var fecha = $("#txtFechaLimiteInterconsulta").val();
        var descripcion = $("#txtDescripcionInterconsulta").val();
        var tipoInterconsulta = btoa(unescape(encodeURIComponent($("#cmbEspecialidad").val())));

        var registrosInterconsulta = {
            "fecha": fecha,
            "descripcion": unescape(encodeURIComponent(descripcion)),
            "tipoInterconsulta": tipoInterconsulta

        }
        localStorage.setItem("ordenMedicaInterconsulta", btoa(JSON.stringify(registrosInterconsulta)));
    }
}
