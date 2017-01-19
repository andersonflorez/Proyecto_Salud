$(document).ready(function(){
    $("#item5").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item6").hide();
        $("#Item5").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
         $("#marcaOrdenesMedicas").hide();
        select2Codigo();
        select2Descripcion();

        $("#noProrroga").change(function(){
            $("#siProrroga").parent().children().eq(1).removeClass("radioError");
            $("#noProrroga").parent().children().eq(1).removeClass("radioError");
        });
        $("#siProrroga").change(function(){
            $("#siProrroga").parent().children().eq(1).removeClass("radioError");
            $("#noProrroga").parent().children().eq(1).removeClass("radioError");
        });

    });
});

function select2Codigo(){
    $('#cmbCodigoCIE10').select2({
        placeholder: 'Seleccione una opción',
        minimumInputLength: 2,
        ajax: {
            url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoCie10",
            dataType: 'json',
            delay: 250,
            type:'POST',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; },
        minimumInputLength: 2,
        templateResult: function (data) {
            if (data.loading) return data.text;
            if (data.loading) return data.text;
            var markup = data.codigoCIE10;
            return markup;
        },
        templateSelection: function (data) {
            return data.codigoCIE10 || data.text;
        }
    });
}

function select2Descripcion(){
    $('#cmbDescripcionCIE10').select2({
        placeholder: 'Seleccione una opción',
        minimumInputLength: 2,
        ajax: {
            url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionCie10",
            dataType: 'json',
            delay: 250,
            type:'POST',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; },
        minimumInputLength: 3,
        templateResult: function (data) {
            if (data.loading) return data.text;

            var markup = data.descripcionCIE10;
            return markup;
        },
        templateSelection: function (data) {
            return data.descripcionCIE10 || data.text;
        }
    });
}

//diagnostico
function seleccionarCodigoAutomaticamente(select){
    var valor = $(select).val();   

    $("#"+select.id+" > option").first().remove();
    $("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
    $("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

    $.ajax({
        url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarCodigoIdCie10",
        type:"POST",
        data:{
            id:valor
        }
    }).done(function(data){
        $("#cmbCodigoCIE10").html("<option selected='select' value='"+valor+"'>"+data+"</option>");
        select2Codigo();
    });
}
function seleccionarDescripcionAutomaticamente(select){
    var valor = $(select).val();
    $("#"+select.id+" > option").first().remove();
    $("#"+select.id+" > option[value='"+valor+"']").html($("#"+select.id).parent().children().eq(1).children().children().children().eq(0).html());
    $("#"+select.id+" > option[value='"+valor+"']").attr("selected","selected");

    $.ajax({
        url: url+"HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/consultarDescripcionIdCie10",
        type:"POST",
        data:{
            id:valor
        }
    }).done(function(data){
        $("#cmbDescripcionCIE10").html("<option selected='select' value='"+valor+"'>"+data+"</option>");
        select2Descripcion();
    });
}






function finalizarIncapacidad(){
    localStorage.setItem("ordenMedicaIncapacidad","");
    if($("#item5").is(":visible")){
        var numeroDias = $("#txtNumeroDias").val();
        var descripcion = $("#txtDescripcionIncapacidad").val();
        var diagnostico = "";
        if($("#cmbCodigoCIE10").val() != null){
            diagnostico = btoa($("#cmbCodigoCIE10").val());
        }else if($("#cmbDescripcionCIE10").val() != null){
            diagnostico = btoa($("#cmbDescripcionCIE10").val());
        }
        var prorroga = $('input:radio[name=rdoPrroga]:checked').val();
        var registroIncapacidad ={
            "numeroDias":numeroDias,
            "descripcion":descripcion,
            "diagnostico":diagnostico,
            "prorroga":prorroga
        }
        localStorage.setItem("ordenMedicaIncapacidad",btoa(JSON.stringify(registroIncapacidad)));
    }
}