$(document).ready(function () {
    // Setup - add a text input to each footer cell


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
        window.location = url+"Stock/ctrlConsultarTratamiento";
    });

    $("#btnCerrar").click(function () {
        $("#panelAtencion").fadeOut(100, function () {
            $("#panelAtencion").removeClass("lg_flex_col40 xl_flex_col30");
            $(".panelAtencionSeleccionado").removeClass("panelAtencionSeleccionado");
            $("#panelDerecho").removeClass("lg_flex_col60 xl_flex_col70 n_flex_col10");
            $("#panelAtencion").fadeIn();
            $("#panelDerecho").fadeOut();
        });

    });


});

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


    consultarAntecedentes(idAtencion);
    consultarMedicacion(idAtencion);
    consultarAtencion(idAtencion);

    $("#idAtencion").html('Prestamo número : ' + atob(idAsignacion));



}

function generarReporte(id) {
    window.open(url + 'Stock/ctrlTratamientoPDF/Reporte/' + id +'');
};

//Funcion ajax para consultar los antecedentes que tiene un paciente,recolectados desde el registro de la atencion
function consultarAntecedentes(idAtencion) {
    $.ajax({
        url: url + "Stock/CtrlConsultarAtencionTratamiento/consultarAtencedentes",
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



//Funcion ajax para consultar la medicacion hecha en la atencion a un paciente
function consultarMedicacion(idAtencion) {
    $.ajax({
        url: url + "Stock/CtrlConsultarAtencionTratamiento/consultarMedicacion",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON',
        async: false
    }).done(function (data) {

      if (data == 0) {
            $("#containerAntecedentes").hide();
            //$("#recursosA").hide();
            //$("#informacion").show();
      }else{


        $("#containerTable").html('<table class="tbl_scroll" id="tablaPrestamos"><thead><tr><th>Implemento</th><th>Cantidad de unidades</th><th>Descripción Tratamiento</th><th>Fecha Asignación</th><th>estado asignación</th></tr></thead><tbody id="containerMedicacion"></tbody><tfoot><tr><td>Implemento</td><td>Cantidad de unidades</td><td>Descripción Tratamiento</td><td>Fecha Asignación</td><td>Estado Asignación</td>,</tr></tfoot></table>');

        $.each(data, function (i, datos) {
            $("#containerMedicacion").append("<tr><td>" + datos.nombre + "</td><td>" + datos.cantidadAsignada + "</td><td>" + datos.descripcionTratamiento + "</td><td>" + datos.fechaHoraAsignacion + "</td> <td>"+datos.estadoTablaAsignacionKit+"</td></tr>");
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

}
    }).fail(function (error) {
        alert("hay error: " + error);
    });
}
//Funcion de ajax para consultar Diagnosticos dados a un paciente en la realizacion de la atencion

//Funcion ajax para consultar los procedimientos que se le hicieron a un paciente en una atencion.Pasandole el parametro de la atencion que esta en el controlador.
function consultarProcedimiento(idAtencion) {
    $.ajax({
        url: url + "Stock/CtrlConsultarAtencionTratamiento/consultarProcedimiento",
        data: {
            idAtencion: idAtencion
        },
        type: 'POST',
        dataType: 'JSON'

    }).done(function (data) {
        $("#containerProcedimientos").html('');

        if (data == "") {
            $("#containerProcedimientos").append('<center><p id="mensaje" >No se registraron datos en  procedimientos</center></p>');
        } else {

            $.each(data, function (i, datos) {
                $("#containerProcedimientos").append('<div class="n_flex xl_flex_col50 n_flex_col100"><div class="panel-contenido scroll-panel n_flex_col100" style="padding:1.5em 1.5em 0 1.5em;" id="containerProcedimientos"><ul class="list_panel relative_element n_justify_start"><li class="list_item n_dont_grow n_flex_col100 " style="width:97.5%"><div class="list_item_content" style="border-bottom: none;"><span class="text_bold block" style="color: #00A8A7;">Descripción CUPS: </span>' + datos.nombreCUP + '<br><br><span class="text_bold block"style=" color: #00A8A7;">Código CUPS: </span>' + datos.codigoCup + '<br><br><p><span class="text_bold block" style="color: #00A8A7;">Procedimiento Realizado:</span>' + datos.descripcionProcedimiento + '</p><button type="button" class="fa fa-plus btn btn-modal btn-registrar notasEnfermeria" target="notasEnfermeria" onclick="ingresarNotasProcedimiento(' + "'" + btoa(datos.idProcedimiento) + "'" + ')"></button></div></li></ul></div></div>');

            });
        }

    }).fail(function (error) {
        console.log(error);

    });

}


//Funcion ajax para consultar la atencion del paciente
function consultarAtencion(idAtencion) {
    $.ajax({
        url: url + "Stock/CtrlConsultarAtencionTratamiento/consultarAtencion",
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
              console.log(datos);
                $("#containerAtencion").append('<br><br> <span class="text_bold block" style="color: #00A8A7; ">Enfermedad Actual : </span>' + datos.enfermedadActual,
                                                '<br><br> <span class="text_bold block" style="color: #00A8A7; ">Información del prestamo : </span>');

            });
        }



    }).fail(function (error) {
        console.log(error);
    });

}
function Reporte(id) {
    window.open(url + 'stock/ctrlTratamientoPDF/Reporte/'+ id +'/Historia clinica');
};
