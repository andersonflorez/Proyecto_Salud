var equiposBiomedicos = [];
$(document).ready(function(){
    
    var myDatepicker = $('#txtFechaLimite').datepicker().data('datepicker');
    
    $("#txtFechaLimite").datepicker({    
        language: 'es',
        minDate: new Date(),
        position:"right top",
         onSelect:function(formattedDate){
            myDatepicker.hide();
         }
       });
    
        $("#txtFechaLimite").blur(function () {
        var valorFecha = $("#txtFechaLimite").val();
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
            $("#txtFechaLimite").val("").focus();
        }
    });
    
    

    registroEquipo=[];
    $.ajax({
        dataType:'json',
        url: url+"HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas/consultarEquipo",
        async: false
    }).done(function(cmb){
        $.each(cmb, function(e,s){
            registroEquipo.push({descripcion :s.nombre,id: s.idRecurso}); 
        });
    }).fail(function(){
        alert("error")
    });
    $("#containerEquipo").html("");
    contadorEquipo=0;
    agregarEquipo();
    $("#cmbTipoTratamiento").html("<option></option>");
    $.ajax({
        dataType:'json',
        url:url+"HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas/consultarTratamiento"
    }).done(function(data){
        $.each(data,function(i,d){
            $("#cmbTipoTratamiento").append("<option value='"+d.idTipoTratamiento+"'>"+d.Descripcion+"</option>");
        });
        $("#cmbTipoTratamiento").append("<option value='otro'>Otro</option>");
        $("#cmbTipoTratamiento").select2({
            placeholder: 'Seleccione una opción'
        });
    }).fail(function(){
        alert("Error en tratamiento");
    });

    $("#item1").click(function(){
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item1").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
         $("#marcaOrdenesMedicas").hide();

        $("#cmbTipoTratamiento").change(function(){


            if($("#cmbTipoTratamiento").val() == "otro"){
                $("#cmbTipoTratamiento > option").removeAttr("selected");
                $("#cmbTipoTratamiento > option").eq(0).attr("selected","selected");
                $("#cmbTipoTratamiento").select2({
                    placeholder: 'Seleccione una opción'
                });
                swal({   
                    title: "Tratamiento",   
                    text: "Ingrese el nuevo tratamiento:",   
                    type: "input",  
                    confirmButtonText: "Registrar",
                    confirmButtonColor: "#2ecc71",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,   
                    closeOnConfirm: false
                }, 
                     function(inputValue){ 

                    if (inputValue === false){
                        swal.close();
                    }
                    else if (inputValue === "") {  
                        swal.close();  
                    } 
                    else{
                        $("#cmbTipoTratamiento option[estado='0']").remove();
                        $("#cmbTipoTratamiento").append("<option estado='0' value='"+inputValue+"'>"+inputValue+"</option>");
                        $("#cmbTipoTratamiento > option").removeAttr("selected");
                        $("#cmbTipoTratamiento > option").last().attr("selected","selected");
                        $("#cmbTipoTratamiento").select2({
                            placeholder: 'Seleccione una opción'
                        });
                        swal.close(); 
                        Notificate({
                            tipo: 'success',
                            titulo: '¡Agregado',
                            descripcion: 'El administrador debe habilitar el tipo tratamiento ingresado'
                        });
                    }

                });
            }
        });


    });

    $("#btnNuevoEquipo").click(function(){
        agregarEquipo();
    });
});

function agregarEquipo(){
    $("#containerEquipo").append('<div class="frmCont n_flex"  style="margin-top:0px"><label></label><button onclick="quitarEquipoBiomedico(this)" type="button" class="btn btn-eliminar btnquitarEquipoBiomedico n_flex_col10" id="btnquitarEquipoBiomedico" style="margin-right: 8px;"><i class="fa fa-times"></i></button><div class="frmInput frmInput_select2 n_flex_col80" style="height:100%"><select id="cmbEquipoBiomedico'+(contadorEquipo+1)+'" name="cmbEquipoBiomedico'+(contadorEquipo+1)+'" class="select cmbEquipoBiomedico input_data" data-rule-RE_Select="0" onchange="seleccionOtro(this)"></select></div></div>');
    $('#cmbEquipoBiomedico'+(contadorEquipo+1)).html("<option></option>");
    for (var i = 0;i<registroEquipo.length;i++) {
        $('#cmbEquipoBiomedico'+(contadorEquipo+1)).append('<option value="'+registroEquipo[i].id+'">'+registroEquipo[i].descripcion+'</option');
    }
    $('#cmbEquipoBiomedico'+(contadorEquipo+1)).append('<option value="otro">Otro</option');
    contadorEquipo++;

    $(".select").select2({
        placeholder: 'Seleccione una opción'
    });
    disabledEquipoBiomedico();
}

function quitarEquipoBiomedico(el){
    var posicionIndex = $(".btnquitarEquipoBiomedico").index(el);

	$("#containerEquipo").children().eq(posicionIndex).remove();
	disabledEquipoBiomedico();
	contadorEquipo--;

}

function seleccionOtro(select){

    if($(select).val() == "otro"){
        $("#"+select.id+" > option").removeAttr("selected");
        $("#"+select.id+" > option").eq(0).attr("selected","selected");
        $(".select").select2({
            placeholder: 'Seleccione una opción'
        });
        swal({   
            title: "Equipo biomédico",   
            text: "Ingrese el nuevo Equipo biomédico:",   
            type: "input",  
            confirmButtonText: "Registrar",
            confirmButtonColor: "#2ecc71",
            cancelButtonText: "Cancelar",
            showCancelButton: true,   
            closeOnConfirm: false
        }, 
             function(inputValue){ 

            if (inputValue === false){
                swal.close();
            }
            else if (inputValue === "") {  
                swal.close();  
            } 
            else{
                $("#"+select.id+" option[estado='0']").remove();
                $("#"+select.id+"").append("<option estado='0' value="+inputValue+">"+inputValue+"</option>");
                $("#"+select.id+" > option").removeAttr("selected");
                $("#"+select.id).attr("estado","n");
                $("#"+select.id+" > option").last().attr("selected","selected");
                $(".select").select2({
                    placeholder: 'Seleccione una opción'
                });
                swal.close();
                Notificate({
                    tipo: 'success',
                    titulo: '¡Agregado',
                    descripcion: 'El equipo se ha agregado correctamente'
                });
            }

        });
    }else{
        if(isNaN($("#"+select.id).val())){
            $("#"+select.id).attr("estado","n");
        }else{
            $("#"+select.id).attr("estado","v");
        }
    }
    disabledEquipoBiomedico();
}

function finalizarTratamiento(){
    //Local storage de tratamiento
    localStorage.setItem("ordenMedicaTratamiento","");
    if($("#item1").is(":visible")){
        var registrosEquiposBiomedicos = [];
        var tipoTratamiento;
        var fechaLimite = $("#txtFechaLimite").val();
        var descripcion = $("#txtDescripcionTratamiento").val();
        var dosis = $("#txtDosisTratamiento").val();

        if(isNaN($("#cmbTipoTratamiento").val())){
            tipoTratamiento = {
                "tipoTratamiento":btoa(unescape(encodeURIComponent($("#cmbTipoTratamiento").val()))),
                "estado":"n"
            }
            tipoTratamiento = JSON.stringify(tipoTratamiento);
        }else{
            tipoTratamiento = {
                "tipoTratamiento":btoa($("#cmbTipoTratamiento").val()),
                "estado":"v"
            }
            tipoTratamiento = JSON.stringify(tipoTratamiento);
        }


        for(var i=0;i<$(".cmbEquipoBiomedico").length;i++){
            var id = $(".cmbEquipoBiomedico").eq(i).val();
            registrosEquiposBiomedicos.push({id:btoa(unescape(encodeURIComponent(id))),estado:$(".cmbEquipoBiomedico ").eq(i).attr("estado")});
        }
        registrosEquiposBiomedicos = btoa(JSON.stringify(registrosEquiposBiomedicos));
        var registros={
            "tipoTratamiento":tipoTratamiento,
            "fechaLimite":fechaLimite,
            "descripcion":descripcion,
            "dosis":dosis,
            "equiposBiomedicos":registrosEquiposBiomedicos
        }
        localStorage.setItem("ordenMedicaTratamiento",btoa(JSON.stringify(registros)));
    }
}

function disabledEquipoBiomedico(){
    $(".cmbEquipoBiomedico option").removeAttr("disabled");
    equiposBiomedicos = [];
    $(".cmbEquipoBiomedico").each(function(i,e){
        equiposBiomedicos.push($(e).val());
    });

    $(".cmbEquipoBiomedico").each(function(i,e){
        $("#"+e.id+" option").each(function(ind,el){
            for(var i =0;i<equiposBiomedicos.length;i++){
                if($(el).val() == equiposBiomedicos[i]){
                    if($(el).val() != ""){
                        $(el).attr("disabled","disabled");
                    }
                }
            }

        });
    });

    $(".cmbEquipoBiomedico").each(function(a,r){
        for(var i =0;i<equiposBiomedicos.length;i++){
            if(r.value == equiposBiomedicos[i]){
                $("#"+r.id+" > option[value='"+equiposBiomedicos[i]+"']").removeAttr("disabled");
            }
        }
    });
}


 function timeFormat(parametro){
            $('body').append("<style>."+parametro+" > .datepicker--nav{display:none !important;}."+parametro+" > .datepicker--content{display:none !important;}."+parametro+" > .datepicker--nav-title{display:none !important;}</style>");
        }