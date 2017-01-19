$(document).ready(function () {
    var frm = '#frmFiltroBusqueda';
    // Configuración Basica para el paginador
    var options = {
        parent: 'paginadorDinamico',
        url: 'HistoriaClinicaDMC/ctrlConsultarAtencion/consultarAtenciones/'+idPersona,
        configuration: {
            tableName: '..', // Es recomendable hacer esto desde el controlador
            limit: 6
        }
    };


    var generarPaginador = function(resultado) {
        resultado = resultado || 'No Se Encuentran Atenciones.';
        paginator.view.generateButtons(options)
            .then(function(data) {
            if (data.datos !== null) {
                consultarAtenciones(data); // Primera vez
                $(frm + ' #limiteTodos').val(data.cantidadRegistros);
            }else {
                noResultado(resultado);
            }
            $('#' + options.parent).on('click', 'li.btn_paginador', function() {
                Paginate(options, $(this), function(data) {
                    if (data.datos !== null) {
                        consultarAtenciones(data); // Segunda vez
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
    $(frm + ' .orderBy').change(function () {
        filter();
    });

    $('.reset_search').click(function (event) {
        let config = JSON.parse(JSON.stringify($('#frmFiltroBusqueda').serializeArray()));
        options.configuration.limit = Number(config[0].value);
        options.configuration.page = 1;
        options.configuration.nameColumnFilter = '';
        options.configuration.filter =  '';
        options.configuration.filterDateTimeStart = '';
        options.configuration.filterDateTimeEnd = '';
        options.configuration.orderBy = '';
        
        $('#txtinputBusqueda').val('');
        $('#fechaInicio').val('');
        $('#fechaFin').val('');
        
        generarPaginador('No se encontraron resultados que coincidan con el filtro solicitado.');
    });


    var filter = function () {
        let config = JSON.parse(JSON.stringify($('#frmFiltroBusqueda').serializeArray()));
        
        options.configuration.limit = Number(config[0].value);
        options.configuration.page = 1;
        options.configuration.nameColumnFilter = Number(config[1].value);
        options.configuration.filter = $('#txtinputBusqueda').val() || '';
        options.configuration.filterDateTimeStart = config[2].value;
        options.configuration.filterDateTimeEnd = config[3].value;
        options.configuration.orderBy = config[4].value;
        
        generarPaginador('No se encontraron resultados que coincidan con el filtro solicitado.');
    };

    var noResultado = function(resultado){
        $("#containerAtenciones").html("");
        alert(resultado);
    };


    //Acordeon
    $(".acordeonTitulo").click(function () {
        var el = this;
        if (!$(el).parent().children().eq(1).is(":visible")) {

            $(".acordeonDescripcion").fadeOut(200);

            setTimeout(function () {

                $(el).parent().children().eq(1).fadeIn();
            }, 201)
        }
    });


    $("#btnCerrar2").click(function(){
        window.location = url+"HistoriaClinicaDMC/ctrlConsultarHistoria";
    });

    $("#btnCerrar").click(function () {
        $("#panelAtencion").fadeOut(100, function () {
            $("#panelAtencion").removeClass("lg_flex_col40 xl_flex_col30");
            $(".panelAtencionSeleccionado").removeClass("panelAtencionSeleccionado");
            $("#panelDerecho").removeClass("lg_flex_col60 xl_flex_col70 n_flex_col10");
            $("#panelAtencion").fadeIn();
            $("#panelDerecho").fadeOut();
            $("#btnConsultarInformacionPersonal").show();
            $("#btnCerrar2").show();
            $("#tituloPaciente").removeClass("xl_flex_col100");
            $("#tituloPaciente").addClass("xl_flex_col90");
        });

    });
});
//Funcion para consultar atenciones
function consultarAtenciones(data){

    $("#containerAtenciones").html('');
    if(data !=null || data !=0){
        $.each(data.datos,function(e,s){

            $("#containerAtenciones").append('<ul class="list_panel relative_element n_justify_start block"><li class="list_item n_dont_grow"><div class="list_item_header n_flex n_nowrap"><div class="item_icon n_flex n_align_center"><span class=""></span>'+s.idHistoriaClinica+'</div><div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 class="text_bold suspensive">Atención</h5></div></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold"> Médico : </span>'+s.primerNombre+'</p></div><div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold">Télefono Paciente : </span>'+s.telefonoFijo1+'</p> </div> <div class="list_item_content suspensive_4"><p class="suspensive"><span class="text_bold">Dirección Paciente : </span>'+s.direccion+'</p></div><div class="list_item_footer n_flex n_justify_between horizontal_padding"><div class="footer_element"><span><i class="fa fa-calendar"></i>&nbsp&nbsp'+s.fechaAtencion+'</span></div><div class="footer_element n_flex"><div class="tooltip separate_right"><span class="button" onclick="generarReporte('+"'"+btoa(s.idHistoriaClinica)+"'"+')"><i class="fa fa-download"></i></span><span class="tooltiptext">Descargar</span></div><div class="footer_element n_flex"><div class="tooltip separate_right"><span class="button"onclick="mostrarAtencion('+"'"+btoa(s.idHistoriaClinica)+"'"+',this)"><i class="fa fa-eye "></i></span><span class="tooltiptext" style="width:80px">Ver</span></div></div></div></li></ul>');

        });
    }
}

function mostrarAtencion(idAtencion, el) {
    $(".acordeonDescripcion").fadeOut();
    $("#panelAtencion").fadeOut(100, function () {
        $("#panelAtencion").addClass("lg_flex_col40 xl_flex_col30");
        $(".panelAtencionSeleccionado").removeClass("panelAtencionSeleccionado");
        $("#panelDerecho").addClass("lg_flex_col60 xl_flex_col70 n_flex_col10");
        $(el).parent().parent().parent().parent().parent().addClass("panelAtencionSeleccionado");
        $("#panelAtencion").fadeIn();
        $("#panelDerecho").fadeIn();
    });
    $("#btnConsultarNotas").click(function () {
        consultarNotasDeEnfermeria(idAtencion);

    });
    $("#btnSignosV").click(function () {
        consultarSignosVitales(idAtencion);
    });

    consultarAntecedentes(idAtencion);
    consultarExamenFisico(idAtencion);
    consultarMedicacion(idAtencion);
    consultarDiagnosticos(idAtencion);
    consultarProcedimiento(idAtencion);
    consultarAtencion(idAtencion);

    $("#btnConsultarInformacionPersonal").hide();
    $("#btnCerrar2").hide();

    $("#tituloPaciente").removeClass("xl_flex_col85");
    $("#tituloPaciente").addClass("xl_flex_col100");

    $("#idAtencion").html('Atención Número : ' + atob(idAtencion));

    $("#btnOrdenesM").click(function () {
        window.location = url + "HistoriaClinicaDMC/ctrlConsultarOrdenes/Index/" + idAtencion + "/" + idPersona;
    });


}

function generarReporte(id) {
    window.open(url + 'HistoriaClinicaDMC/ctrlPDF/Reporte/'+ id +'/Historia clinica');
};

//Funcion ajax para consultar los antecedentes que tiene un paciente,recolectados desde el registro de la atencion
function consultarAntecedentes(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarAtencedentes",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'
    }).done(function (data) {
        $("#containerAntecedentes").html('');

        if(data==""){
            $("#containerAntecedentes").append('<center><p id="mensaje" >No se registraron datos en  Antecedentes</center></p>');
        }else{
            $.each(data, function (i, datos) {
                $("#containerAntecedentes").append('<div><center><h6 class="text_bold n_align_center block">' + datos.descripcion + '</h6></center><p class="block">' + datos.descripcionAntecedente + '</p><hr class="block"></div>');

            });
        }


    }).fail(function (error) {
        alert("hay error: " + error);
    });
}

function consultarExamenFisico(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarExamenesFisicos",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'
    }).done(function (data) {
        $("#containerExamenFisico").html('');
        if (data == "") {
            $("#containerExamenFisico").append('<center><p id="mensaje" >No se registraron datos en  Exámen Físico</center></p>');
        } else {
            $.each(data, function (i, datos) {
                $("#containerExamenFisico").append(' <div><center><h6 class="text_bold n_align_center block">' + datos.descripcionExamenFisico + '</h6></center><p class="block">' + datos.descripcionExamen + '</p><p class="block"><b>Estado: </b>' + datos.estadoTablaExamen + '</p><hr class="block"></div>');

            });
        }

    }).fail(function (error) {
        alert("hay error: " + error);
    });
}

//Funcion ajax para consultar la medicacion hecha en la atencion a un paciente
function consultarMedicacion(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarMedicacion",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON',
        async: false
    }).done(function (data) {
        $("#containerTable").html('<table class="tbl_scroll" id="tablaMedicacion"><thead><tr><th>Medicamento</th><th>Cantidad unidades</th><th>Vía administración</th><th>Dósis</th><th>Hora</th></tr></thead><tbody id="containerMedicacion"></tbody><tfoot><tr><td>Medicamento</td><td>Cantidad unidades</td><td>Vía administración</td><td>Dósis</td><td>Hora</td></tr></tfoot></table>');

        $.each(data, function (i, datos) {
            $("#containerMedicacion").append("<tr><td>" + datos.nombre + "</td><td>" + datos.cantidadUnidades + "</td><td>" + datos.viaAdministracion + "</td><td>" + datos.dosis + "</td><td>" + datos.hora + "</td></tr>");
        });
        // DataTable
        var table = $('#tablaMedicacion').DataTable({
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


        $('#tablaMedicacion tfoot td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder=" ' + title + '" />');
        });

        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });


    }).fail(function (error) {
        alert("hay error: " + error);
    });
}
//Funcion de ajax para consultar Diagnosticos dados a un paciente en la realizacion de la atencion
function consultarDiagnosticos(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarDiagnosticos",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON',
        async: false
    }).done(function (data) {
        $("#containerDiagnostico").html('');

        if (data == "") {
            $("#containerDiagnostico").append('<center><p id="mensaje" >No se registraron datos en  diagnósticos</center></p>');

        } else {
            $.each(data, function (i, datos) {
                $("#containerDiagnostico").append(' <ul class="list_panel relative_element n_flex n_justify_center"><li class="list_item n_dont_grow n_flex_col70" style="width:97.5%"><div class="list_item_content"><p style="display:none;"  id="mensaje">No se registraron datos en la atención</p><span class="block"><span class="text_bold" style="color: #00A8A7;">Descripción CIE10: </span>' + datos.descripcionCIE10 + '</span><br><br><span class="block"><span class="text_bold" style="color: #00A8A7;">Código CIE10: </span>' + datos.codigoCIE10 + '</span><br><br><p><span class="text_bold block" style="color: #00A8A7;">Diagnóstico Realizado:</span>' + datos.descripcionDiagnostico + '</p></div></li></ul>');

            });
        }


    }).fail(function (error) {
        alert("hay error: " + error);
    });

}
//Funcion ajax para consultar los procedimientos que se le hicieron a un paciente en una atencion.Pasandole el parametro de la atencion que esta en el controlador.
function consultarProcedimiento(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarProcedimiento",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'

    }).done(function (data) {
        $("#containerProcedimientos").html('');

        if (data == "") {
            $("#containerProcedimientos").append('<center><p id="mensaje" >No se registraron datos en  procedimientos</p></center>');
        } else {
            $.each(data, function (i, datos) {
                $("#containerProcedimientos").append('<div class="xl_flex_col50 n_flex_col100"><div class="panel-contenido n_flex_col100" style="padding:1.5em 1.5em 0 1.5em;" id="containerProcedimientos"><ul class="list_panel relative_element n_justify_start"><li class="list_item n_dont_grow n_flex_col100 " style="width:97.5%"><div class="list_item_content" style="border-bottom: none;"><span class="text_bold block" style="color: #00A8A7;">Descripción CUPS: </span>' + datos.nombreCUP + '<br><br><span class="text_bold block"style=" color: #00A8A7;">Código CUPS: </span>' + datos.codigoCup + '<br><br><p><span class="text_bold block" style="color: #00A8A7;">Procedimiento Realizado:</span>' + datos.descripcionProcedimiento + '</p><button type="button" class="fa fa-plus btn btn-modal btn-registrar notasEnfermeria" target="notasEnfermeria" onclick="ingresarNotasProcedimiento(' + "'" + btoa(datos.idProcedimiento) + "'" + ')"></button></div></li></ul></div></div>');

            });
        }

    }).fail(function (error) {
        

    });

}


//Funcion ajax para consultar la atencion del paciente
function consultarAtencion(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarAtencion",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'
    }).done(function (data) {
        $("#containerAtencion").html('');
        if (data == "") {
            $("#containerAtencion").append('<center><p id="mensaje" >No se registraron datos en la atención</center></p>');
        } else {
            $.each(data, function (i, datos) {
                $("#containerAtencion").append('<span class="text_bold block" style="color: #00A8A7;">Origen Atención :</span>' + datos.descripcionorigenAtencion + '<br><br><span class="text_bold block"style=" color: #00A8A7;">Motivo Consulta : </span>' + datos.motivoAtencion + '<br><br> <span class="text_bold block" style="color: #00A8A7; ">Enfermedad Actual : </span>' + datos.enfermedadActual + '<br><br><span class="text_bold block" style="color: #00A8A7;">Evolución : </span>' + datos.evolucion);

            });
        }



    }).fail(function (error) {
        
    });

}

//Funcion ajax para consultar Notas de enfermeriaa
function consultarNotasDeEnfermeria(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarNotasEnfermeria",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'
    }).done(function (data) {

        $("#modalConsultarNotasEnfermeria").html('');
        $.each(data, function (i, datos) {

            $("#modalConsultarNotasEnfermeria").append('<div class="panel block" style="margin-top: 10px; padding: 2em;" ><span class="block"><h6 class="text_bold  block" style="display: inline;color: #00A8A7;">Descripción : </h6>' + datos.nombreCUP + '</span><span style="float: right;"><h6 class="text_bold  block" style="display: inline;color: #00A8A7">Código : </h6>' + datos.codigoCup + '</span> <br><br><span class="block"><h6 class="text_bold" style="color: #00A8A7; display: inline;">Procemiento Realizado : </h6>' + datos.descripcionProcedimiento + '</span><br><br><span class="block"><h6 class="text_bold  block" style="display: inline;color: #00A8A7;">Nombre y apellido realizador : </h6>' + datos.primerNombre + " " + datos.primerApellido + '</span><br><br><span class="block"><h6 class="text_bold  block" style="display: inline;color: #00A8A7;">Tipo Documento : </h6>' + datos.descripcionTdocumento + '</span><br><br><span class="block"><h6 class="text_bold  block" style="display: inline;color: #00A8A7;">Número Documento : </h6>' + datos.numeroDocumento + '</span><br><br><span class="block"><h6 class="text_bold" style="color: #00A8A7; display: inline;">Nota Enfermeria : </h6>' + datos.descripcion + '</span></div>');
            
        });

    }).fail(function (error) {
        console.log(error);
    });
}
//Funcion ajax para consultar signos vitales
function consultarSignosVitales(idAtencion) {
    $.ajax({
        url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/consultarSignosVitales",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'
    }).done(function (data) {

        for (var j = 0; j < 4; j++) {
            $("#txtSignoVital0-" + (j + 1)).val(data[0][j].hora);
        }
        var h = 0;
        for (var i = 1; i <= 8; i++) {
            for (var j = 1; j <= 4; j++) {
                $("#txtSignoVital" + i + "-" + j).val(data[1][h].resultado);
                h++;
            }
        }
    }).fail(function (error) {
        console.log(error);
    });

}

//Funcion ajax para registrar las notas de enfermeria

function ingresarNotasProcedimiento(idProcedimiento) {
    swal({
        title: "Descripción Notas Enfermeria",
        text: "<textarea id='txtDescripcionFormulaMedica'></textarea>",
        html: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    },
         function (confirmacion) {
        if (!confirmacion) {
            swal.close();
        } else {
            if ($("#txtDescripcionFormulaMedica").val() != "") {
                descripcion = $("#txtDescripcionFormulaMedica").val();
                $.ajax({
                    url: url + "HistoriaClinicaDMC/ctrlConsultarAtencion/registarNotaEnfermeria",
                    data: {
                        idProcedimiento: idProcedimiento,
                        descripcion: descripcion
                    },
                    type: 'POST'

                }).done(function (data) {
                    swal.close();
                    Notificate({
                        tipo: 'success',
                        titulo: 'Registro Exitoso',
                        descripcion: 'La nota de enfermeria se registro correctamente.'
                    });
                }).fail(function () {});
            } else {
                swal.showInputError("Es necesario compleatr la descripción!");
                return false;
            }
        }
    });
}
