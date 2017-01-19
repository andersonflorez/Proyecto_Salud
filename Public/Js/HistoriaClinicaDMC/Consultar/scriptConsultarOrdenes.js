$(document).ready(function(){
    $.ajax({
        type: 'POST',
        dataType:'JSON',
        url: url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarDatos",
        data:{"idAtencion":idAtencion,"idPersona":idPersona}
    }).done(function(data){
      console.log(data);
        $(".info_head").prepend('<div class="n_flex_col100">'
          +' <div class="n_flex_col100">'
                +'<p class="paragraph"+>'
                +  '<span class="text_bold block" style="color: #00A8A7;">Fecha: </span>'
                +'  <label id="">'+data.Fecha.fechaAtencion+'</label>'
            +'    </p>'
            +'</div>'
            +'<br>'
            +'<div class="n_flex">'
              +'<div class="n_flex_col30">'
                +'<div class="n_flex">'
                  +'  <p class="paragraph">'
                      +'<span class="text_bold block" style="color: #00A8A7;">Nombre: </span>'
                      +'<label id="">'+data.Paciente.primerNombre+" "+data.Paciente.segundoNombre+'</label>'
                    +'</p>'
                +'</div>'
                +'<br>'
                +'<div class="n_flex">'
                    +'<p class="paragraph">'
                      +'<span class="text_bold block" style="color: #00A8A7;">Apellido: </span>'
                      +'<label id="">'+data.Paciente.primerApellido+" "+data.Paciente.segundoApellido+'</label>'
                    +'</p>'
              +'  </div>'
              +'</div>'
              +'<div class="n_flex_col35">'
              +'  <div class="n_flex">'
                    +'<p class="paragraph">'
                      +'<span class="text_bold block" style="color: #00A8A7;">Tipo documento: </span>'
                      +'<label id="">'+data.Paciente.descripcionTdocumento+'</label>'
                    +'</p>'
                +'</div>'
                +'<br>'
                +'<div class="n_flex">'
                    +'<p class="paragraph">'
                    +'  <span class="text_bold block" style="color: #00A8A7;">Documento: </span>'
                    +'  <label id="">'+data.Paciente.numeroDocumento+'</label>'
                    +'</p>'
                +'</div>'
              +'</div>'
              +'<div class="n_flex_col30">'
                +'<div class="n_flex">'
                    +'<p class="paragraph">'
                      +'<span class="text_bold block" style="color: #00A8A7;">Médico: </span>'
                      +'<label id="">'+data.Medico.primerNombre+" "+data.Medico.segundoNombre+" "+data.Medico.primerApellido+" "+data.Medico.segundoApellido+'</label>'
                    +'</p>'
                +'</div>'
                +'<br>'
                +'<div class="n_flex">'
                    +'<p class="paragraph">'
                    +'  <span class="text_bold block" style="color: #00A8A7;">Especialidad: </span>'
                    +'  <label id="">'+data.Medico.descripcionEspecialidad+'</label>'
                    +'</p>'
                +'</div>'
              +'</div>'
            +'</div>'
            +'<br><hr>'
        +'</div>');
    }).fail(function(data){console.log(data);});
    if(emailPaciente == ""){
        $(".btnEnviarOrdenes").hide();
    }
    //General
    $("#Item1").hide();
    $("#Item2").hide();
    $("#Item3").hide();
    $("#Item4").hide();
    $("#Item5").hide();
    $("#Item6").hide();
    $("#marcaOrdenesMedicas").addClass("marcaAgua");
    $("#marcaOrdenesMedicas").show();

    consultarTratamiento(idAtencion);
    consultarFormula(idAtencion);
    consultarExamenEspecializado(idAtencion);
    consultarInterconsulta(idAtencion);
    consultarIncapacidad(idAtencion);
    consultarOtro(idAtencion);


    //Item 1
    $("#item1").click(function(){
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item1").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();
    });
    //Item 2
    $("#item2").click(function(){
        $("#Item1").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item2").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();
    });

    //Item 3 Exámen Especializado
    $("#item3").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item3").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();
    });
    //Item 4
    $("#item4").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item4").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();
    });
    //Item 5
    $("#item5").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item6").hide();
        $("#Item5").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();
    });
    //Item 6
    $("#item6").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
        $("#marcaOrdenesMedicas").hide();

    });
});





//Funcion ajax para consultar Orden de Tratamiento
function consultarTratamiento(idAtencion){
    var estado;
    $.ajax({
        type: 'POST',
        url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarTratamiento",
        data:{
            idAtencion:idAtencion
        },
        dataType: 'JSON'
    }).done(function(data){
        if(data == false){
            $("#item1").hide();
            return;
        }else{
            $("#item1").show();
        }
        $("#containerConsultarEquipos").html('');
        $("#txtTipoTratamiento").html(data.tipoTratamiento);
        $("#txtFechaLimiteTratamiento").html(data.fechaTratamiento);
        $("#txtDescripcionTratamiento").html(data.descripcionTratamiento);
        $("#txtDosisTratamiento").html(data.dosisTratamiento);
        $.ajax({
            type: 'POST',
            url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarDetalleTratamiento",
            data:{
                idTratamiento:btoa(data.idTratamiento)
            },
            dataType: 'JSON',
            async: false
        }).done(function(data){
            $.each(data,function(i,datos){
                $("#containerConsultarEquipos").append('<tr><td>'+datos.nombre+'</td><td>Con existencias</td></tr>');
            });
        });
        $.ajax({
            type: 'POST',
            url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarEquipoBiomedicoTratamiento",
            data:{
                idTratamiento:btoa(data.idTratamiento)
            },
            dataType: 'JSON',
            async: false
        }).done(function(data){
            $.each(data,function(i,datos){
                $("#containerConsultarEquipos").append('<tr><td>'+datos.equipoBiomedico+'</td><td>Sin existencias</td></tr>');

            });
        });

    }).fail(function(error){
        console.log(error);
    });
}
//Funcion consultar Formula Medica
function consultarFormula(idAtencion){
    $.ajax({
        url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarFormula",
        type:'POST',
        data:{ idAtencion:idAtencion},
        dataType: 'JSON'
    }).done(function(data){
        if(data == false){
            $("#item2").hide();
            return;
        }else{
            $("#item2").show();
        }
        $("#containerConsultarFormula").html('');
        $("#txtRecomendaciones").html(data.recomendaciones);
        $.ajax({
            url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarDetalleFormula",
            type:'POST',
            data:{ idFormula:btoa(data.idFormulaMedica )},
            dataType: 'JSON'
        }).done(function(data){

            $("#tablaConsultarFormulaMedica").html('<table class="tbl_scroll" id="tablaConsultarFormulaM"><thead><tr><th>Medicamento</th><th>Cantidad unidades</th><th>Dosificación</th><th>Descripción</th></tr></thead><tbody id="containerConsultarFormula"></tbody><tfoot><tr><td>Medicamento</td><td>Cantidad unidades</td><td>Dosificación</td> <td>Descripción</td></tr></tfoot> </table>');



            $.each(data,function(i,datos){
                $("#containerConsultarFormula").append("<tr><td>"+datos.nombreMedicamento+"</td><td>"+datos.cantidadMedicamento+"</td><td>"+datos.dosificacion+"</td><td>"+datos.descripcion+"</td></tr>");
            });
            // DataTable
            var table = $('#tablaConsultarFormulaM').DataTable({
                "iDisplayLength": 5,
                "ordering": false,
                "language": {
                    "info": "Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros para mostrar",
                    "sInfoFiltered": "(Filtrada en _MAX_ registros)",
                    "zeroRecords": "No se encontraron registros",
                    "search": "Buscar",
                    "paginate": {
                        "next": "<span class='fa fa-angle-double-right'></span>",
                        "previous": "<span class='fa fa-angle-double-left'></span>"
                    },
                    "lengthMenu": 'N° Registros <select class="form-control">' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">Todos</option>' +
                    '</select>',
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando..."
                }
            });


            $('#tablaConsultarFormulaM tfoot td').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder=" '+title+'" />' );
            });

            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });




        });

    }).fail(function(error){
        console.log(error);
    });
}
//Funcion ajax de examenes Especializados
function consultarExamenEspecializado(idAtencion){
    $.ajax({
        url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarExamenEspecializado",
        type:'POST',
        data:{ idAtencion:idAtencion},
        dataType: 'JSON'
    }).done(function(data){
        if(data == false){
            $("#item3").hide();
            return;
        }else{
            $("#item3").show();
        }

        $("#txtObservaciones").html(data.observaciones);
        $("#txtDescripcion").html(data.descripcion);
        $("#txtNombreTipo").html(data.nombreTipoExamen);
    }).fail(function(error){
        console.log(error);

    });
}
//Funcion ajax de interconsulta
function consultarInterconsulta(idAtencion){
    $.ajax({
        url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarInterconsulta",
        type:'POST',
        data:{ idAtencion:idAtencion},
        dataType: 'JSON'
    }).done(function(data){
        if(data == false){
            $("#item4").hide();
            return;
        }else{
            $("#item4").show();
        }
        $("#txtFechaLimiteInterconsulta").html(data.fechaLimite);
        $("#txtEspecialidad").html(data.especialidad);
        $("#txtDescripcionInterconsulta").html(data.descripcionInterconsulta);
    }).fail(function(error){
        console.log(error);

    });
}

//Function ajax de otro
function consultarOtro(idAtencion){
    $.ajax({
        url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarOtro",
        type:'POST',
        data:{ idAtencion:idAtencion},
        dataType: 'JSON'

    }).done(function(data){
        if(data == false){
            $("#item6").hide();
            return;
        }else{
            $("#item6").show();
        }
        $("#txtOtro").html(data.descripcionOtro);

    }).fail(function(error){
        console.log(error);
    });
}
//Funcion para consultar la orden de incapacidad
function consultarIncapacidad(idAtencion){
    $.ajax({
        url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarIncapacidad",
        type:'POST',
        data:{idAtencion:idAtencion},
        dataType:'JSON',
        assign:false
    }).done(function(data){
        if(data == false){
            $("#item5").hide();
            return;
        }else{
            $("#item5").show();
        }
        $("#txtNumeroDias").html(data.cantidadDias);
        $("#txtCodigoCie10").html(data.codigoCIE10);
        $("#txtDescripcionCie10s").html(data.descripcionCIE10);
        $("#txtDescripcionIncapacidad").html(data.descripcionMotivo);
        $("#txtProrroga").html(data.prorroga);

    }).fail(function(error){
        console.log(error);
    });
}

function generarReporteFormulaM() {
    window.open(url + 'HistoriaClinicaDMC/ctrlDescargarPDF/ReporteOrdenes/'+ idAtencion +'/FormulaMedica');
};
function generarReporteTratamiento() {
    window.open(url + 'HistoriaClinicaDMC/ctrlDescargarPDF/ReporteOrdenes/'+ idAtencion +'/Tratamiento');
};
function generarReporteExamenE() {
    window.open(url + 'HistoriaClinicaDMC/ctrlDescargarPDF/ReporteOrdenes/'+ idAtencion +'/ExamenEspecializado');
};
function generarReporteIncapacidad() {
    window.open(url + 'HistoriaClinicaDMC/ctrlDescargarPDF/ReporteOrdenes/'+ idAtencion +'/Incapacidad');
};
function generarReporteInterconsulta() {
    window.open(url + 'HistoriaClinicaDMC/ctrlDescargarPDF/ReporteOrdenes/'+ idAtencion +'/Interconsulta');
};
function generarReporteOtro() {
    window.open(url + 'HistoriaClinicaDMC/ctrlDescargarPDF/ReporteOrdenes/'+ idAtencion +'/Otro');
};

function EnviarReporteTratamiento(){
    swal({
        title: "Confirmacion",
        text: "Confirme el envío del tratamiento al siguiente correo <b>"+emailPaciente+"</b>",
        html:true,
        type: "info",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#2ecc71",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        $.ajax({
            type:"POST",
            url: url + "HistoriaClinicaDMC/ctrlEnvioCorreo/enviarOrdenes",
            data:{ idAtencion: idAtencion, email:emailPaciente, Orden:"tratamiento"  }
        }).done(function(data){
            swal("Correo enviado con éxito");
        }).fail(function(error){
            console.log(error);
        });

    });
}

function EnviarReporteFormulaMedica(){
    swal({
        title: "Confirmacion",
        text: "Confirme el envío de la formula medica al siguiente correo <b>"+emailPaciente+"</b>",
        html:true,
        type: "info",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#2ecc71",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        $.ajax({
            type:"POST",
            url: url + "HistoriaClinicaDMC/ctrlEnvioCorreo/enviarOrdenes",
            data:{ idAtencion: idAtencion, email:emailPaciente, Orden:"formulaMedica"  }
        }).done(function(data){
            swal("Correo enviado con éxito");
        }).fail(function(error){
            console.log(error);
        });

    });
}

function EnviarReporteExamenEspecializado(){
    swal({
        title: "Confirmacion",
        text: "Confirme el envío del examen especializado al siguiente correo <b>"+emailPaciente+"</b>",
        html:true,
        type: "info",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#2ecc71",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        $.ajax({
            type:"POST",
            url: url + "HistoriaClinicaDMC/ctrlEnvioCorreo/enviarOrdenes",
            data:{ idAtencion: idAtencion, email:emailPaciente, Orden:"examenEspecializado"  }
        }).done(function(data){
            swal("Correo enviado con éxito");
        }).fail(function(error){
            console.log(error);
        });

    });
}

function EnviarReporteInterconsulta(){
    swal({
        title: "Confirmacion",
        text: "Confirme el envío de la interconsulta al siguiente correo <b>"+emailPaciente+"</b>",
        html:true,
        type: "info",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#2ecc71",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        $.ajax({
            type:"POST",
            url: url + "HistoriaClinicaDMC/ctrlEnvioCorreo/enviarOrdenes",
            data:{ idAtencion: idAtencion, email:emailPaciente, Orden:"interconsulta"  }
        }).done(function(data){
            swal("Correo enviado con éxito");
        }).fail(function(error){
            console.log(error);
        });

    });
}

function EnviarReporteIncapacidad(){
    swal({
        title: "Confirmacion",
        text: "Confirme el envío de la incapacidad al siguiente correo <b>"+emailPaciente+"</b>",
        html:true,
        type: "info",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#2ecc71",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        $.ajax({
            type:"POST",
            url: url + "HistoriaClinicaDMC/ctrlEnvioCorreo/enviarOrdenes",
            data:{ idAtencion: idAtencion, email:emailPaciente, Orden:"incapacidad"  }
        }).done(function(data){
            swal("Correo enviado con éxito");
        }).fail(function(error){
            console.log(error);
        });

    });
}

function EnviarReporteOtro(){
    swal({
        title: "Confirmacion",
        text: "Confirme el envío del otro al siguiente correo <b>"+emailPaciente+"</b>",
        html:true,
        type: "info",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#2ecc71",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        $.ajax({
            type:"POST",
            url: url + "HistoriaClinicaDMC/ctrlEnvioCorreo/enviarOrdenes",
            data:{ idAtencion: idAtencion, email:emailPaciente, Orden:"otro"  }
        }).done(function(data){
            swal("Correo enviado con éxito");
        }).fail(function(error){
            console.log(error);
        });

    });
}
