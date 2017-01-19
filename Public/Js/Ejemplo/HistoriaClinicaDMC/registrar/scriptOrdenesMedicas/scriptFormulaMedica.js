var medicamentoDisabled = [];
var descripcionFormulaMedica = "";
$(document).ready(function(){
    registroMedicamento=[];
    $.ajax({
        dataType:'json',
        url: url+"HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas/consultarMedicamentos",
        async: false
    }).done(function(cmb){
        $.each(cmb, function(e,s){
            registroMedicamento.push({descripcion :s.descripcion,id: s.idMedicamento}); 
        });
    }).fail(function(){
        alert("error")
    });
    contadorMedicamento=0;
    agregarMedicamento();

    $("#item2").click(function(){
        $("#Item1").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item2").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
         $("#marcaOrdenesMedicas").hide();

        //$("#containerMedicamentos").html("");
        //contadorMedicamento=0;
        if(contadorMedicamento==0){
            agregarMedicamento();
        }

        $("#btnAgregarDescripcion").click(function(){
            swal({   
                title: "Descripción",   
                text: "<textarea id='txtDescripcionFormulaMedica'></textarea>",   
                html:true,  
                showCancelButton: true,   
                confirmButtonText: "Registrar",
                confirmButtonColor: "#2ecc71",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }, 
                 function(confirmacion){ 

                if (!confirmacion){
                    swal.close();
                }
                else{
                    if($("#txtDescripcionFormulaMedica").val() != ""){
                        descripcionFormulaMedica = $("#txtDescripcionFormulaMedica").val();
                        swal("¡Agregado!", $("#txtDescripcionFormulaMedica").val(), "success");
                    }else{
                        swal.close();
                    }
                }
            });
        });
    });

    $("#btnNuevoMedicamento").click(function(){
        agregarMedicamento();
    });
    $("#btnQuitarMedicamento").click(function(){
        quitarMedicamento();
    });
});

function agregarMedicamento(){
    $("#containerMedicamentos").append('<tr><td style="width:33%"><div class="frmCont"  style="margin-top:0px"><label></label><div class="frmInput frmInput_select2" style="height:100%"><select id="cmbMedicamento'+(contadorMedicamento+1)+'" name="cmbMedicamento" class="select cmbMedicamentos input_data" onchange="seleccion('+contadorMedicamento+')"></select></div></div></td><td><div class="frmCont"  style="margin-top:0px"><label></label><div class="frmInput"><input type="text" name="txtCantidadMedicamentos'+contadorMedicamento+'" class="txtCantidadMedicamentos input_data" autocomplete="off"></div></div></td><td><div class="frmCont"  style="margin-top:0px"><label></label><div class="frmInput"><input type="text" name="txtDosificacionMedicamento'+contadorMedicamento+'" class="txtDosificacionMedicamento input_data" autocomplete="off"></div></div></td><td><div class="frmCont"  style="margin-top:0px"><label></label><div class="frmInput"><input type="text" name="txtDescripcionMedicamentos'+contadorMedicamento+'"class="txtDescripcionMedicamentos" autocomplete="off"></div></div></td></tr>');
    $('#cmbMedicamento'+(contadorMedicamento+1)).html("<option></option>");
    for (var i = 0;i<registroMedicamento.length;i++) {
        $('#cmbMedicamento'+(contadorMedicamento+1)).append('<option value="'+registroMedicamento[i].id+'">'+registroMedicamento[i].descripcion+'</option');
    }
    contadorMedicamento++;

    $(".select").select2({
        placeholder: 'Selecciones una opción'
    });
    validacionFormulaMedica();
    focusInputsValidaciones();
    disabledMedicamento();

}

function quitarMedicamento(){
    if(contadorMedicamento>1){
        contadorMedicamento--;
        $("#containerMedicamentos").children().eq(contadorMedicamento).remove();
        disabledMedicamento();
    }

    else if(contadorMedicamento==1){
        $("#containerMedicamentos").children().eq(0).remove();
        agregarMedicamento();
        disabledMedicamento();
    }
}
function seleccion(cont){
    $(".txtCantidadMedicamentos").eq(cont).attr("data-rule-required","true");
    $(".txtCantidadMedicamentos").eq(cont).attr("data-rule-RE_Numbers","true");
    $(".txtDosificacionMedicamento").eq(cont).attr("data-rule-required","true")
    disabledMedicamento();
}
function disabledMedicamento(){
    $(".cmbMedicamentos option").removeAttr("disabled");
    medicamentoDisabled = [];
    $(".cmbMedicamentos").each(function(i,e){
        medicamentoDisabled.push($(e).val());
    });

    $(".cmbMedicamentos").each(function(i,e){
        $("#"+e.id+" option").each(function(ind,el){
            for(var i =0;i<medicamentoDisabled.length;i++){
                if($(el).val() == medicamentoDisabled[i]){
                    $(el).attr("disabled","disabled");
                }
            }
        });
    });

    $(".cmbMedicamentos").each(function(a,r){
        for(var i =0;i<medicamentoDisabled.length;i++){
            if(r.value == medicamentoDisabled[i]){
                $("#"+r.id+" > option[value='"+medicamentoDisabled[i]+"']").removeAttr("disabled");
            }
        }
    });
    $(".select").select2({
        placeholder: 'Seleccione una opción'
    });
}
function finalizarFormulaMedica(){

    localStorage.setItem("ordenMedicaFormulaMedica","");
    if($("#item2").is(":visible")){
        var registrosMedicamentos = [];
        var recomendacion = descripcionFormulaMedica;

        for(var i=0;i<$(".cmbMedicamentos").length;i++){
            var id = $(".cmbMedicamentos").eq(i).val();
            var cantidad = $(".txtCantidadMedicamentos").eq(i).val();
            var dosificacion = $(".txtDosificacionMedicamento").eq(i).val();
            var descripcion = $(".txtDescripcionMedicamentos").eq(i).val();
            registrosMedicamentos.push({"id":btoa(id),"cantidad":cantidad,"dosificacion":dosificacion,"descripcion":descripcion});
        }
        registrosMedicamentos = btoa(JSON.stringify(registrosMedicamentos));
        var registros={
            "medicamentos":registrosMedicamentos,
            "recomendacion":recomendacion
        }
        localStorage.setItem("ordenMedicaFormulaMedica",btoa(JSON.stringify(registros)));
    }

}