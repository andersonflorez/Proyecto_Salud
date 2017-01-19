$(document).ready(function(){

    if(localStorage.getItem("antecedentes") != null){
        var registrosAntecedentes = JSON.parse(atob(localStorage.getItem("antecedentes")));
        for(var j=0;j<registrosAntecedentes.length;j++){
            for(var i=0;i<$(".chbAntecedentes").length;i++){
                if($(".txtIdAntecedente").eq(i).val() == atob(registrosAntecedentes[j].id)){
                    $(".chbAntecedentes").eq(i).attr("checked","checked");
                    $(".txtAntecendentes").eq(i).val(registrosAntecedentes[j].descripcion);
                    $(".txtAntecendentes").eq(i).removeAttr("disabled");
                    $(".txtAntecendentes").eq(i).attr("data-rule-required","true");
                    $(".frmInputAntecedentes").eq(i).addClass("frmInput");
                }
            }
        }
    }
    if(localStorage.getItem("examenFisico") != null){
        var registrosExamenes = JSON.parse(atob(localStorage.getItem("examenFisico")));
        for(var j=0;j<registrosExamenes.length;j++){
            for(var i=0;i<$(".chbExamenFisico").length;i++){
                if($(".txtIdExamenFisico").eq(i).val() == atob(registrosExamenes[j].id)){
                    $(".chbExamenFisico").eq(i).attr("checked","checked");
                    $(".txtExamenFisico").eq(i).val(registrosExamenes[j].descripcion);
                    $(".txtExamenFisico").eq(i).removeAttr("disabled");
                    $(".txtExamenFisico").eq(i).attr("data-rule-required","true");
                    $(".frmInputExamenFisico").eq(i).addClass("frmInput");

                    if(registrosExamenes[j].estado == "Normal"){
                        $(".rdoExamenFisicoN").eq(i).attr("checked","checked");
                    }else{
                        $(".rdoExamenFisicoA").eq(i).attr("checked","checked");
                    }

                    $(".rdoExamenFisicoN").eq(i).removeAttr("disabled");
                    $(".rdoExamenFisicoA").eq(i).removeAttr("disabled");
                }
            }
        }
    }

    $('.chbAntecedentes').change(function(){
        if ($('.chbAntecedentes').eq($(".chbAntecedentes").index(this)).is(":checked")){
            $(".txtAntecendentes").eq($(".chbAntecedentes").index(this)).removeAttr("disabled");
            $(".txtAntecendentes").eq($(".chbAntecedentes").index(this)).attr("placeholder","Ingrese la descripción");
            $(".txtAntecendentes").eq($(".chbAntecedentes").index(this)).attr("data-rule-required","true");
            $(".frmInputAntecedentes").eq($(".chbAntecedentes").index(this)).addClass("frmInput");
        }else{
            $(".txtAntecendentes").eq($(".chbAntecedentes").index(this)).attr("disabled","disabled");
            $(".txtAntecendentes").eq($(".chbAntecedentes").index(this)).attr("placeholder","Debe seleccionar el checkbox");
            $(".txtAntecendentes").eq($(".chbAntecedentes").index(this)).removeAttr("data-rule-required");
            $(".frmInputAntecedentes").eq($(".chbAntecedentes").index(this)).removeClass("frmInput");
            $(".frmInputAntecedentes").eq($(".chbAntecedentes").index(this)).removeClass("frm_contenedorMalo");
            $(".frmInputAntecedentes").eq($(".chbAntecedentes").index(this)).children().eq(1).remove();

        }
    });

    $(".chbExamenFisico").change(function(){
        if($(".chbExamenFisico").eq($(".chbExamenFisico").index(this)).is(":checked")){
            $(".rdoExamenFisicoN").eq($(".chbExamenFisico").index(this)).removeAttr("disabled");
            $(".rdoExamenFisicoA").eq($(".chbExamenFisico").index(this)).removeAttr("disabled");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).removeAttr("disabled");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("placeholder","Ingrese la descripción");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("data-rule-required","true");
            $(".frmInputExamenes").eq($(".chbExamenFisico").index(this)).addClass("frmInput");
        }else{
            $(".rdoExamenFisicoN").eq($(".chbExamenFisico").index(this)).attr("disabled","disabled");
            $(".rdoExamenFisicoA").eq($(".chbExamenFisico").index(this)).attr("disabled","disabled");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("disabled","disabled");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("placeholder","Debe seleccionar el checkbox");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).removeAttr("data-rule-required");
            $(".frmInputExamenes").eq($(".chbExamenFisico").index(this)).removeClass("frmInput");
            $(".frmInputExamenes").eq($(".chbExamenFisico").index(this)).removeClass("frm_contenedorMalo");
            $(".frmInputExamenes").eq($(".chbExamenFisico").index(this)).children().eq(1).remove();

            //.radios = contenedor global de los radios
            $(".radios").eq($(".chbExamenFisico").index(this)).children().eq(0).children().children().eq(1).removeClass("radioError");
            $(".radios").eq($(".chbExamenFisico").index(this)).children().eq(1).children().children().eq(1).removeClass("radioError");

            //se quita la clase que controla cuantos tienen error
            $(".radios").eq($(".chbExamenFisico").index(this)).removeClass("radioI");
        }
    });
    ValidateForm('frmAntecedentesExamenes', function(formData){
        for(var i = 0;i<$(".chbExamenFisico").length;i++){
            if($(".chbExamenFisico").eq(i).is(":checked")){

                //.radios = contenedor global de los radios
                if(!$(".radios").eq(i).children().eq(0).children().children().eq(0).is(":checked") && !$(".radios").eq(i).children().eq(1).children().children().eq(0).is(":checked")){
                    //se aplica una clase para controlar cuantos no se han seleccionado
                    $(".radios").eq(i).addClass("radioI");

                    //se aplica clase de error accediendo a cada radio desde el contenedor padre
                    $(".radios").eq(i).children().eq(0).children().children().eq(1).addClass("radioError");
                    $(".radios").eq(i).children().eq(1).children().children().eq(1).addClass("radioError");
                }
            }
        }

        if($(".radioI").length > 0){
            Notificate({
                tipo: 'error',
                titulo: 'No se puede continuar',
                descripcion: 'Seleccione el estado de cada examen fisico.'
            });
            return false;
        }

        var registrosAntecedente=[];
        for(var i=0;i<$(".chbAntecedentes").length;i++){
            if ($('.chbAntecedentes').eq(i).is(":checked")){
                var id = btoa($(".txtIdAntecedente").eq(i).val());
                var descripcion = $(".txtAntecendentes").eq(i).val();
                registrosAntecedente.push({id:id,descripcion:descripcion});
            }
        }
        localStorage.setItem("antecedentes",btoa(JSON.stringify(registrosAntecedente)));

        var registrosExamenFisico =[];
        for(var i = 0;i<$(".chbExamenFisico").length;i++){
            if($(".chbExamenFisico").eq(i).is(":checked")){

                var id = btoa($(".txtIdExamenFisico").eq(i).val());
                var descripcion = $(".txtExamenFisico").eq(i).val();
                var estado;
                if($(".rdoExamenFisicoN").eq(i).is(":checked")){
                    estado = "Normal";
                }
                else if($(".rdoExamenFisicoA").eq(i).is(":checked")){
                    estado = "Anormal";
                }
                registrosExamenFisico.push({id: id, descripcion: descripcion, estado: estado});
            }
        }
        localStorage.setItem("examenFisico",btoa(JSON.stringify(registrosExamenFisico)));

        window.location = url+"HistoriaClinicaDMC/ctrlRegistrarSignosVitales/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;
    });

    //se le quita la clase de error al radio cuando se seleccione alguno
    $(".rdoExamenFisicoN").change(function(){
        //.radios = contenedor global de los radios
        $(".radios").eq($(".rdoExamenFisicoN").index(this)).children().eq(0).children().children().eq(1).removeClass("radioError");
        $(".radios").eq($(".rdoExamenFisicoN").index(this)).children().eq(1).children().children().eq(1).removeClass("radioError");

        $(".radios").eq($(".rdoExamenFisicoN").index(this)).removeClass("radioI");
    });
    $(".rdoExamenFisicoA").change(function(){
        $(".radios").eq($(".rdoExamenFisicoA").index(this)).children().eq(0).children().children().eq(1).removeClass("radioError");
        $(".radios").eq($(".rdoExamenFisicoA").index(this)).children().eq(1).children().children().eq(1).removeClass("radioError");
        $(".radios").eq($(".rdoExamenFisicoA").index(this)).removeClass("radioI");
    });

    //FILTRO DE BUSQUEDA antecedentes

    //Click en el basurero
    $('#btnBorrarAntecedentes').click(function (event) {
        $(".descripcionTipoAntecedente").parent().parent().show();
        $("#txtinputBusquedaAntecedentes").val("")
    });

    // Click en el icono de buscar:
    $('#btnBuscarAntecedentes').click(function () {
        $(".descripcionTipoAntecedente").parent().parent().hide();
        jQuery.expr[':'].contains = function(a, i, m) {
            return jQuery(a).text().toUpperCase()
                .indexOf(m[3].toUpperCase()) >= 0;
        };
        $(".descripcionTipoAntecedente:contains("+$("#txtinputBusquedaAntecedentes").val()+")").parent().parent().show();
    });

    // Evento enter en el campo de busqueda:
    $('#txtinputBusquedaAntecedentes').keypress(function(e){
        if(e.keyCode == 13) {
            $(".descripcionTipoAntecedente").parent().parent().hide();
            jQuery.expr[':'].contains = function(a, i, m) {
                return jQuery(a).text().toUpperCase()
                    .indexOf(m[3].toUpperCase()) >= 0;
            };
            $(".descripcionTipoAntecedente:contains("+$("#txtinputBusquedaAntecedentes").val()+")").parent().parent().show();
            return false;
        }
    });


    //FILTRO DE BUSQUEDA examenes

    //Click en el basurero
    $('#btnBorrarExamenes').click(function () {
        $(".descripcionTipoExamen").parent().parent().show();
        $("#txtinputBusquedaExamenes").val("");
    });

    // Click en el icono de buscar:
    $('#btnBuscarExamenes').click(function () {
        $(".descripcionTipoExamen").parent().parent().hide();
        jQuery.expr[':'].contains = function(a, i, m) {
            return jQuery(a).text().toUpperCase()
                .indexOf(m[3].toUpperCase()) >= 0;
        };
        $(".descripcionTipoExamen:contains("+$("#txtinputBusquedaExamenes").val()+")").parent().parent().show();
    });

    // Evento enter en el campo de busqueda:
    $('#txtinputBusquedaExamenes').keypress(function(e){
        if(e.keyCode == 13) {
            $(".descripcionTipoExamen").parent().parent().hide();
            jQuery.expr[':'].contains = function(a, i, m) {
                return jQuery(a).text().toUpperCase()
                    .indexOf(m[3].toUpperCase()) >= 0;
            };
            $(".descripcionTipoExamen:contains("+$("#txtinputBusquedaExamenes").val()+")").parent().parent().show();
            return false;
        }
    })
});
