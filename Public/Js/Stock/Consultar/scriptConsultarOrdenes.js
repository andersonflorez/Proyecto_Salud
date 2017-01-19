$(document).ready(function(){
    //General
    $("#Item1").hide();
    $("#Item2").hide();
    $("#Item3").hide();
    $("#Item4").hide();
    $("#Item5").hide();
    $("#Item6").hide();

    //Item 1
    $("#item1").click(function(){
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item1").fadeIn(800);
        consultarTratamiento(idAtencion);
    });
    //Item 2
    $("#item2").click(function(){
        $("#Item1").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item2").fadeIn(800);
        consultarFormula(idAtencion);
    });                                                           
    //Item 3
    $("#item3").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item3").fadeIn(800);
        consultarExamenEspecializado(idAtencion);
    });
    //Item 4
    $("#item4").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item4").fadeIn(800);
        consultarInterconsulta(idAtencion);
    });
    //Item 5
    $("#item5").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item6").hide();
        $("#Item5").fadeIn(800);
        consultarIncapacidad(idAtencion);
    });
    //Item 6
    $("#item6").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").fadeIn(800);
        consultarOtro(idAtencion);

    });





    //Funcion ajax para consultar Orden de Tratamiento
    function consultarTratamiento(idAtencion){
        $.ajax({
            type: 'POST',
            url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarTratamiento",
            data:{
                idAtencion:idAtencion
            },
            dataType: 'JSON'
        }).done(function(data){
            $("#containerConsultarEquipos").html('');
            $("#txtTipoTratamiento").html(data.tipoTratamiento);
            $("#txtFechaLimiteTratamiento").html(data.fechaTratamiento);
            $("#txtDescripcionTratamiento").html(data.descripcionTratamiento);
            $("#txtDosisTratamiento").html(data.dosisTratamiento);
            $.ajax({
                type: 'POST',
                url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarDetalleTratamiento",
                data:{
                    idTratamiento:data.idTratamiento
                },
                dataType: 'JSON',
                async: false
            }).done(function(data){
                $.each(data,function(i,datos){
                    $("#containerConsultarEquipos").append('<span>'+datos.nombre+'</span><br>');
                });
            });
            $.ajax({
                type: 'POST',
                url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarEquipoBiomedicoTratamiento",
                data:{
                    idTratamiento:data.idTratamiento
                },
                dataType: 'JSON',
                async: false
            }).done(function(data){
                $.each(data,function(i,datos){
                    $("#containerConsultarEquipos").append('<span>'+datos.equipoBiomedico+'</span><br>');

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

            $("#containerConsultarFormula").html('');
            $("#txtRecomendaciones").html(data.recomendaciones);
            $.ajax({
                url:url+"HistoriaClinicaDMC/ctrlConsultarOrdenes/consultarDetalleFormula",
                type:'POST',
                data:{ idFormula:data.idFormulaMedica },
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
           if(data!=""){
                $("#item3").removeAttr("style");               
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
            
            $("#txtNumeroDias").html(data.cantidadDias);
            $("#txtCodigoCie10").html(data.codigoCIE10);
            $("#txtDescripcionCie10s").html(data.descripcionCIE10);
            $("#txtDescripcionIncapacidad").html(data.descripcionMotivo);
            $("#txtProrroga").html(data.prorroga);

        }).fail(function(error){
            console.log(error);
        });
    }
});