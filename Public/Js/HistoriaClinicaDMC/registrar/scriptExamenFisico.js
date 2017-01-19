$(document).ready(function(){

    $(".chbExamenFisico").change(function(){
        if($(".chbExamenFisico").eq($(".chbExamenFisico").index(this)).is(":checked")){
            $(".rdoExamenFisicoN").eq($(".chbExamenFisico").index(this)).removeAttr("disabled");
            $(".rdoExamenFisicoA").eq($(".chbExamenFisico").index(this)).removeAttr("disabled");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).removeAttr("readonly");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("placeholder","Ingrese la descripción");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("required","required");
        }else{
            $(".rdoExamenFisicoN").eq($(".chbExamenFisico").index(this)).attr("disabled","true");
            $(".rdoExamenFisicoA").eq($(".chbExamenFisico").index(this)).attr("disabled","true");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("readonly","true");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).attr("placeholder","Debe seleccionar el checkbox");
            $(".txtExamenFisico").eq($(".chbExamenFisico").index(this)).removeAttr("required");
        }
    });


    $("#btnSiguiente").click(function(){
        var registrar =[];
        for(var i = 0;i<$(".chbExamenFisico").length;i++){
            if($(".chbExamenFisico").eq(i).is(":checked")){	
                var id = $(".txtIdExamenFisico").eq(i).val();
                var descripcion = $(".txtExamenFisico").eq(i).val();
                var estado;
                if($(".rdoExamenFisicoN").eq(i).is(":checked")){
                    estado = "Normal";
                }
                else if($(".rdoExamenFisicoA").eq(i).is(":checked")){
                    estado = "Anormal";
                }
                registrar.push({id: id, descripcion: descripcion, estado: estado});
            }
        }
        localStorage.setItem("examenFisico",JSON.stringify(registrar));
        window.location = url+"HistoriaClinicaDMC/ctrlRegistrarDiagnostico/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;

    });
});

