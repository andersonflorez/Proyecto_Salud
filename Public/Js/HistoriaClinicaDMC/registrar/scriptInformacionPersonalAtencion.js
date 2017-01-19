$(document).ready(function(){
    if(localStorage.getItem("informacionPersonal") != null){
        var registrosPersona = JSON.parse(atob(localStorage.getItem("informacionPersonal")));

        $("#cmbEstadoCivil").val(registrosPersona.cmbEstadoCivil);
        $("#txtCiudadResidencia").val(registrosPersona.txtCiudadResidencia);
        $("#txtBarrioResidencia").val(registrosPersona.txtBarrioResidencia);
        $("#txtDireccion").val(registrosPersona.txtDireccion);
        $("#txtCorreoElectronico").val(registrosPersona.txtCorreoElectronico);
        $("#txtTelefonoFijo").val(registrosPersona.txtTelefonoFijo);
        $("#txtTelefonoCelular").val(registrosPersona.txtTelefonoCelular);
        $("#txtEmpresa").val(registrosPersona.txtEmpresa);
        $("#txtOcupacion").val(registrosPersona.txtOcupacion);
    }
    if(localStorage.getItem("atencion") != null){

        var registrosAtencion = JSON.parse(atob(localStorage.getItem("atencion")));
        var tipoOrigenAtencion = atob(registrosAtencion.tipoOrigenAtencion);
        var estado = registrosAtencion.estado;
        if(estado == "v"){
            $("#cmbOrigenAtencion").val(tipoOrigenAtencion);
        }else{
            $("#cmbOrigenAtencion").append("<option estado='0' value='"+tipoOrigenAtencion+"'>"+tipoOrigenAtencion+"</option>");
            $("#cmbOrigenAtencion > option").removeAttr("selected");
            $("#cmbOrigenAtencion > option").last().attr("selected","selected");
            $("#cmbOrigenAtencion").select2({
                placeholder: 'Seleccione una opción'
            });
        }
        $("#cmbOrigenAtencion").val();
        $("#txtMotivoConsulta").val(registrosAtencion.motivoConsulta);
        $("#txtEnfermedadActual").val(registrosAtencion.enfermedadGeneral);
    }
    if(localStorage.getItem("evolucion") != null){
        $("#txtEvolucion").val(atob(localStorage.getItem("evolucion")));
    }


    ValidateForm('frmInformacionPersonalAtencion', function(formData){
        var registrosInformacionPersonal = {
            txtCiudadResidencia: formData.txtCiudadResidencia,
            txtBarrioResidencia: formData.txtBarrioResidencia,
            txtDireccion: formData.txtDireccion,
            txtCorreoElectronico: formData.txtCorreoElectronico,
            txtTelefonoFijo: formData.txtTelefonoFijo,
            txtTelefonoCelular: formData.txtTelefonoCelular,
            txtEmpresa: formData.txtEmpresa,
            txtOcupacion: formData.txtOcupacion,
            cmbEstadoCivil: formData.cmbEstadoCivil
        };
        localStorage.setItem("informacionPersonal",btoa(JSON.stringify(registrosInformacionPersonal)));

        var estado;
        var tipoOrigenAtencion;
        if(isNaN(formData.cmbOrigenAtencion)){
            estado = "n";
            tipoOrigenAtencion = btoa(unescape(encodeURIComponent(formData.cmbOrigenAtencion)));
        }else{
            estado = "v";
            tipoOrigenAtencion = btoa(formData.cmbOrigenAtencion);
        }
        var registrosAtencion = {
            motivoConsulta: formData.txtMotivoConsulta,
            enfermedadGeneral: formData.txtEnfermedadActual,
            tipoOrigenAtencion: tipoOrigenAtencion,
            estado: estado
        };

        localStorage.setItem("atencion",btoa(JSON.stringify(registrosAtencion)));
        localStorage.setItem("evolucion",btoa(formData.txtEvolucion));
        window.location = url+"HistoriaClinicaDMC/ctrlRegistrarAntecedentesExamenes/index/"+idPaciente+"/"+idCita+"/"+idCitaProgramacion;
    });

    $(".select").select2({
        placeholder: 'Seleccione una opción'
    });

    $("#cmbOrigenAtencion").change(function(){
        if($("#cmbOrigenAtencion").val() == "otro"){
            $("#cmbOrigenAtencion > option").removeAttr("selected");
            $("#cmbOrigenAtencion > option").eq(0).attr("selected","selected");
            $("#cmbOrigenAtencion").select2({
                placeholder: 'Seleccione una opción'
            });
            swal({   
                title: "Origen atención",   
                text: "Ingrese el tipo de origen:",   
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
                    swal.close();  
                    $("#cmbOrigenAtencion option[estado='0']").remove();
                    $("#cmbOrigenAtencion").append("<option estado='0' value='"+inputValue+"'>"+inputValue+"</option>");
                    $("#cmbOrigenAtencion > option").removeAttr("selected");
                    $("#cmbOrigenAtencion > option").last().attr("selected","selected");
                    $("#cmbOrigenAtencion").select2({
                        placeholder: 'Seleccione una opción'
                    });
                    Notificate({
                        tipo: 'success',
                        titulo: '¡Agregado',
                        descripcion: 'El administrador debe habilitar el origen de atención ingresado'
                    });

                }

            });
        }
    });
});