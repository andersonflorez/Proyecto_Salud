$(document).ready(function(){

    $("#cmbTipoExamenEspecializado").html("<option></option>");
    $.ajax({
        dataType:'json',
        url:url+"HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas/consultarTipoExamenEspecializado"
    }).done(function(data){
        $.each(data,function(i,d){
            $("#cmbTipoExamenEspecializado").append("<option value='"+d.idTipoExamenEspecializado+"'>"+d.descripcion+"</option>");
        });
        $("#cmbTipoExamenEspecializado").append("<option value='otro'>Otro</option>");
        $("#cmbTipoExamenEspecializado").select2({
            placeholder: 'Selecciones una opción'
        });
    }).fail(function(){
        alert("Error en examen especializado");
    });


    $("#item3").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").hide();
        $("#Item3").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
         $("#marcaOrdenesMedicas").hide();

        $("#cmbTipoExamenEspecializado").change(function(){
            if($("#cmbTipoExamenEspecializado").val() == "otro"){
                $("#cmbTipoExamenEspecializado > option").removeAttr("selected");
                $("#cmbTipoExamenEspecializado > option").eq(0).attr("selected","selected");
                $("#cmbTipoExamenEspecializado").select2({
                    placeholder: 'Seleccione una opción'
                });
                swal({   
                    title: "Exámen especializado",   
                    text: "Ingrese el nuevo examen especializado:",   
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
                        $("#cmbTipoExamenEspecializado option[estado='0']").remove();
                        $("#cmbTipoExamenEspecializado").append("<option estado='0' value="+inputValue+">"+inputValue+"</option>");
                        $("#cmbTipoExamenEspecializado > option").removeAttr("selected");
                        $("#cmbTipoExamenEspecializado > option").last().attr("selected","selected");
                        $("#cmbTipoExamenEspecializado").select2({
                            placeholder: 'Seleccione una opción'
                        });
                        swal.close(); 
                        Notificate({
                            tipo: 'success',
                            titulo: '¡Agregado',
                            descripcion: 'El administrador debe habilitar el examen especializado ingresado'
                        });
                    }

                });
            }
        });

    });
});


function finalizarExamenEspecializado(){
    localStorage.setItem("ordenMedicaExamenEspecializado","");
    if($("#item3").is(":visible")){
        var observacion = $("#txtObservacionExamenEspecializado").val();
        var descripcion = $("#txtDescripcionExamenEspecializado").val();
        var tipoExamenEspecializado = $("#cmbTipoExamenEspecializado").val();
        var estadoExamenFisico;
        if(isNaN($("#cmbTipoExamenEspecializado").val())){
            tipoExamenEspecializado = btoa(tipoExamenEspecializado);
            estadoExamenFisico = "n";
        }else{
            tipoExamenEspecializado = btoa(tipoExamenEspecializado);
            estadoExamenFisico = "v";
        }

        var registros={
            "observacion":observacion,
            "descripcion":descripcion,
            "tipoExamenEspecializado":tipoExamenEspecializado,
            "estadoTipoExamenEspecializado":estadoExamenFisico
        }
        localStorage.setItem("ordenMedicaExamenEspecializado",btoa(JSON.stringify(registros)));
    }
}