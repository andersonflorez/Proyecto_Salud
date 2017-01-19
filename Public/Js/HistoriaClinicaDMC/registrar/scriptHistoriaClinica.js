$(document).ready(function(){
    swal({
        title: "Placa vehiculo",
        text: "Ingrese la placa del vehiculo:",
        type: "input",
        showCancelButton: false,
        closeOnConfirm: false,
        inputPlaceholder: "Placa"
    },
         function(placa){
        if (placa === "") {
            swal.showInputError("La placa es olbigatoria");
            return false
        }
        swal({
            title: "¡Agregado!",
            text: "La placa "+placa+" se ha insertado correctamente.",
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false
        },function(){
            swal.close();
            setTimeout(function(){
                var datosInformacionPersonal = JSON.parse(atob(localStorage.getItem("informacionPersonal")));

                var respuesta;
                respuesta = actualizarInformacionPersonal(datosInformacionPersonal,idPaciente);
                if(respuesta == "1"){
                    //localStorage.removeItem("informacionPersonal");
                    var datosAtencion = JSON.parse(atob(localStorage.getItem("atencion")));
                    var evolucion = atob(localStorage.getItem("evolucion"));
                    var tipoOrigenAtencion;
                    if(datosAtencion.estado == "n"){
                        tipoOrigenAtencion = registrarTipoOrigenAtencion(datosAtencion.tipoOrigenAtencion);
                    }else{
                        tipoOrigenAtencion = datosAtencion.tipoOrigenAtencion;
                    }
                    var idHistoriaClinica = registrarHistoriaClinica(datosAtencion.motivoConsulta,datosAtencion.enfermedadGeneral,placa, tipoOrigenAtencion,idCitaProgramacion,idPaciente,evolucion);
                    if(idHistoriaClinica != "0"){
                        registrarAntecedente(idHistoriaClinica,atob(localStorage.getItem("antecedentes")));
                        registrarExamenFisico(idHistoriaClinica,atob(localStorage.getItem("examenFisico")));
                        registrarDiagnostico(idHistoriaClinica,atob(localStorage.getItem("diagnostico")));
                        registrarProcedimiento(idHistoriaClinica,atob(localStorage.getItem("procedimientos")));
                        registrarSignosVitales(idHistoriaClinica,atob(localStorage.getItem("signosVitales")));
                        registrarMedicacion(idHistoriaClinica,atob(localStorage.getItem("medicacion")));

                        //ordenes medicas
                        //tratamiento
                        if(localStorage.getItem("ordenMedicaTratamiento") != ""){
                            var tratamiento = JSON.parse(atob(localStorage.getItem("ordenMedicaTratamiento")));
                            var tipoTratamiento =JSON.parse(tratamiento.tipoTratamiento);

                            var idTipoTratamiento;
                            if(tipoTratamiento.estado == "n"){
                                idTipoTratamiento = registrarTipoTratamiento(tipoTratamiento.tipoTratamiento);
                            }else{
                                idTipoTratamiento = tipoTratamiento.tipoTratamiento;
                            }

                            var idTratamiento = registrarTratamiento(idHistoriaClinica,JSON.stringify(tratamiento),idTipoTratamiento);
                            registrarDetalleTratamiento(idTratamiento,tratamiento.equiposBiomedicos);
                        }


                        //formula medica
                        if(localStorage.getItem("ordenMedicaFormulaMedica") !=""){
                            var formulaMedica = JSON.parse(atob(localStorage.getItem("ordenMedicaFormulaMedica")));

                            var idFormulaMedica = registrarFormulaMedica(idHistoriaClinica,formulaMedica.recomendacion);
                            registrarFormulaMedicaMedicamentos(idFormulaMedica,formulaMedica.medicamentos);
                        }

                        //examen especializado
                        if(localStorage.getItem("ordenMedicaExamenEspecializado") !=""){
                            var examenEspecializado = JSON.parse(atob(localStorage.getItem("ordenMedicaExamenEspecializado")));
                            var idTipoExamenEspecializado;
                            if(examenEspecializado.estadoTipoExamenEspecializado == "n"){
                                idTipoExamenEspecializado = registrarTipoExamenEspecializado(examenEspecializado.tipoExamenEspecializado);
                            }else{
                                idTipoExamenEspecializado = examenEspecializado.tipoExamenEspecializado;
                            }
                            registrarExamenEspecializado(idHistoriaClinica,examenEspecializado.observacion,idTipoExamenEspecializado,examenEspecializado.descripcion);
                        }

                        //Interconsulta
                        if(localStorage.getItem("ordenMedicaInterconsulta") !=""){
                            var interconsulta = localStorage.getItem("ordenMedicaInterconsulta");
                            registrarInterconsulta(idHistoriaClinica,interconsulta);
                        }


                        //Incapacidad
                        if(localStorage.getItem("ordenMedicaIncapacidad") !=""){
                            var incapacidad = localStorage.getItem("ordenMedicaIncapacidad");
                            registrarIncapacidad(idHistoriaClinica,incapacidad);
                        }

                        //Otro
                        if(localStorage.getItem("ordenMedicaOtro") !=""){
                            var otro = localStorage.getItem("ordenMedicaOtro");
                            registrarOtro(idHistoriaClinica,otro);
                        }

                        cambiarEstadoCita(idCita);
                        localStorage.removeItem("antecedentes");
                        localStorage.removeItem("atencion");
                        localStorage.removeItem("diagnostico");
                        localStorage.removeItem("evolucion");
                        localStorage.removeItem("examenFisico");
                        localStorage.removeItem("informacionPersonal");
                        localStorage.removeItem("medicacion");
                        localStorage.removeItem("ordenMedicaExamenEspecializado");
                        localStorage.removeItem("ordenMedicaFormulaMedica");
                        localStorage.removeItem("ordenMedicaIncapacidad");
                        localStorage.removeItem("ordenMedicaInterconsulta");
                        localStorage.removeItem("ordenMedicaOtro");
                        localStorage.removeItem("ordenMedicaTratamiento");
                        localStorage.removeItem("ordeneMedicaOtro");
                        localStorage.removeItem("procedimientos");
                        localStorage.removeItem("signosVitales");
                        localStorage.removeItem("Citapendiente");
                        window.location = url+"HistoriaClinicaDMC/ctrlConsultarAtencion/Index/"+idPaciente;
                    }
                }
            },500);
        });

    });

});

function actualizarInformacionPersonal(datos,idPaciente){
    var respuesta;
    $.ajax({
        type: "POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarInformacionPersonal/"+idPaciente,
        data: datos,
        async: false
    }).done(function(data){
        respuesta = data;

    }).fail(function(e){
        respuesta = "2";
    });
    return respuesta;
}

function registrarHistoriaClinica(motivoAtencion,enfermedadActual,placaVehiculo,idTipoOrigenAtencion,idCitaProgramacion,idPaciente,evolucion){
    var idHistoriaClinica;
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarHistoriaClinica",
        data:{
            'motivoAtencion':motivoAtencion,
            'enfermedadActual':enfermedadActual,
            'placaVehiculo':placaVehiculo,
            'idTipoOrigenAtencion':idTipoOrigenAtencion,
            'idCitaProgramacion':idCitaProgramacion,
            'idPaciente':idPaciente,
            'evolucion':evolucion
        },
        async:false
    }).done(function(data){
        idHistoriaClinica = data;
    }).fail(function(){
        idHistoriaClinica = "0";
    });
    return idHistoriaClinica;
}

function registrarTipoOrigenAtencion(descripcion){
    var idTipoOrigenAtencion;
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarTipoOrigenAtencion",
        data:{'txtDescripcion':descripcion},
        async:false
    }).done(function(data){
        idTipoOrigenAtencion = data;
    }).fail(function(){
        idTipoOrigenAtencion = "0";
    });
    return idTipoOrigenAtencion;
}

function registrarAntecedente(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarAntecedente",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarExamenFisico(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarExamenFisico",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarDiagnostico(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarDiagnostico",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarProcedimiento(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarProcedimiento",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarSignosVitales(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarSignosVitales",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarMedicacion(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarMedicacion",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarTipoTratamiento(descripcion){
    var idTipoTratamiento;
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarTipoTratamiento",
        data:{'txtDescripcion':descripcion},
        async:false
    }).done(function(data){
        idTipoTratamiento = data;
    }).fail(function(){
        idTipoTratamiento = "0";
    });
    return idTipoTratamiento;
}

function registrarTratamiento(idHistoriaClinica,datos,idTipoTratamiento){
    var idTipoTratamiento;
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarTratamiento",
        data:{'idHistoriaClinica':idHistoriaClinica,'datos':datos,'idTipoTratamiento':idTipoTratamiento},
        async:false
    }).done(function(data){
        idTipoTratamiento = data;
    }).fail(function(){
        idTipoTratamiento = "0";
    });
    return idTipoTratamiento;
}


function registrarDetalleTratamiento(idTratamiento,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarDetalleTratamiento",
        data:{'idTratamiento':idTratamiento,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarFormulaMedica(idHistoriaClinica,recomendacion){
    var idFormulaMedica;
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarFormulaMedica",
        data:{'idHistoriaClinica':idHistoriaClinica,'recomendacion':recomendacion},
        async:false
    }).done(function(data){
        idFormulaMedica = data;
    }).fail(function(){
        idFormulaMedica = "0";
    });
    return idFormulaMedica;
}

function registrarFormulaMedicaMedicamentos(idFormulaMedica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarFormulaMedicaMedicamentos",
        data:{'idFormulaMedica':idFormulaMedica,'datos':datos},
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}


function registrarTipoExamenEspecializado(descripcion){
    var idTipoExamenEspecializado;
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarTipoExamenEspecializado",
        data:{'txtDescripcion':descripcion},
        async:false
    }).done(function(data){
        idTipoExamenEspecializado = data;
    }).fail(function(){
        idTipoExamenEspecializado = "0";
    });
    return idTipoExamenEspecializado;
}

function registrarExamenEspecializado(idHistoriaClinica,observacion,idTipoExamenEspecializado,descripcion){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarExamenEspecializado",
        data:{
            'idHistoriaClinica':idHistoriaClinica,
            'observacion':observacion,
            'idTipoExamenEspecializado':idTipoExamenEspecializado,
            'descripcion':descripcion
        },
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarInterconsulta(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarInterconsulta",
        data:{
            'idHistoriaClinica':idHistoriaClinica,
            'datos':datos
        },
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarIncapacidad(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarIncapacidad",
        data:{
            'idHistoriaClinica':idHistoriaClinica,
            'datos':datos
        },
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function registrarOtro(idHistoriaClinica,datos){
    $.ajax({
        type:"POST",
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/registrarOtro",
        data:{
            'idHistoriaClinica':idHistoriaClinica,
            'datos':datos
        },
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}

function cambiarEstadoCita(idCita){
    $.ajax({
        url: url+"historiaClinicaDMC/ctrlRegistrarHistoriaClinica/cambiarEstadoCita",
        data:{
            'idCita':idCita
        },
        type:"POST",
        async:false
    }).done(function(data){
    }).fail(function(){
        alert("error")
    });
}
