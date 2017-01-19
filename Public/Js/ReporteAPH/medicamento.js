var datos;
var reporte;
var cedulaPaciente;

$(document).ready(function() {
//registrarAutorizacionReporte();
    whichWorkMode.then(function(esModoConsulta) {

        if (esModoConsulta) {
            $("#contMedicam").css("display", "none");
            $("#contListMedicamento").removeAttr("style");
            $(".cerrar-medicamento").css('display', 'none');
            listarMedicamentosUsados();
            $(".icono-medicamento").children().remove();
            $(".icono-medicamento").append("<span class='fa fa-stethoscope'></span>");
            $(".icono-medicamento").removeAttr("style");
            $(".icono-medicamento").removeAttr("onClick");
        } else {
            var persistencia = localStorage.getItem("ReporteAPH-kit")
            if (persistencia != null) {
                listMedicamento();
            } else {
                ListarMedicamento();
                listMedicamento();
            }
        }

    }, function(err) {
        alert('No se pudó obtener el modo de trabajo.');
    });

})

function registrarAutorizacionReporte() {
  var consulta = JSON.parse(localStorage.getItem("ReporteAPH-Paciente"));
  var cedula = consulta["documento"];
  console.log(cedula);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "ReporteAPH/ctrlMedicamento/consultarAllAutorizacion",
        data: {"cedula":cedula},
        async: false
    }).done(function(e) {

    }).fail(function(el) {

    });
}

function medicamentoUsNat(id_, nombre) {
    var dosis = $("#dosis" + id_).val();
    var hora = $("#hora" + id_).val();
    var via = $("#viaad" + id_).val();
    var cantidad = $("#cantidad" + id_).val();
    var cantidadDisponible = $("#cantidadDisponible" + id_).val();
    var cantidadP = cantidadDisponible - cantidad;
    var kit = JSON.parse(localStorage.getItem("ReporteAPH-kit"));

    if (dosis == "" || dosis == null || hora == "" || hora == null || via == "" || via == null || cantidad == "" || cantidad == null) {
        Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: "Debe de llenar todos los campos",
            duracion: 4
        });
        $("#dosis" + id_).focus();
    } else {
        if (cantidadP >= 0) {
            for (var i = 0 in kit) {
                if (kit[i].idDetalleKit == id_) {
                    kit[i].cantidadAsignada = cantidadP;
                }
            };
            localStorage.setItem("ReporteAPH-kit", JSON.stringify(kit));
            agregarMedicamentoLocalStorage(id_, dosis, hora, via, cantidad, nombre);
            $("#lblCantidad" + id_).html(cantidadP);
            Notificate({
                tipo: 'success',
                titulo: 'Medicamento!',
                descripcion: "Se ha agregado el medicamento",
                duracion: 3
            });
        } else {
            Notificate({
                tipo: 'error',
                titulo: 'Error!',
                descripcion: "La cantidad utilizada debe ser menor que la cantidad disponible",
                duracion: 4
            });
        }
    }
    $("#hora" + id_).val("");
    $("#viaad" + id_).val("Vía Administración");
    $("#dosis" + id_).val("");
    $("#cantidad" + id_).val("");
}

function ListarMedicamento() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "ReporteAPH/ctrlMedicamento/ListarMedicamento",
        data: {
            "": ""
        },
        async: false
    }).done(function(e) {
        localStorage.setItem("ReporteAPH-kit", JSON.stringify(e));
    }).fail(function(el) {
        Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'No hay ninguna asignacion registrada',
            duracion: 3
        });
    });
};


function agregarContenedorMedicamento(idDetalleKit, nombre, descripcion, cantidad) {
    var horaMinima = localStorage.getItem("ReporteAPH-HoraConfirmacion");
    if (horaMinima != null) {
      var res = horaMinima.substr(1, 5);
    }else{
      res = "00:00:00"
    }


    $("#contenedorMedicamento").append("<div class='n_flex n_flex_col100 sm_flex_col45 lg_flex_col30 block '><div style='max-height: 404px !important;' class='content-solid height-fijo whole_wrapper'><p class='block05 subTitulo'>" + nombre + "</p><div class='n_flex n_flex_col100 n_justify_around'><div class='n_flex n_flex_col100 sm_flex_col45 lg_flex_col45 block '><input id='dosis" + idDetalleKit + "' type='text' placeholder='Dosis'></div><div class='n_flex n_flex_col100 sm_flex_col45 lg_flex_col45 block '><input id='hora" + idDetalleKit + "' type='text' placeholder='Hora'></div><div class='n_flex n_flex_col100 sm_flex_col45 lg_flex_col45 block '><select id='viaad" + idDetalleKit + "'><option value='Vía Administración' disabled='' selected='selected'>Vía Administración</option><option value='Vía Oral'>Vía Oral</option><option value='Vía Intravenosa'>Vía Intravenosa</option><option value='Vía Sublingual'>Vía Sublingual</option><option value='Vía Tópica'>Vía Tópica</option><option value='Vía Transdérmica'>Vía Transdérmica</option><option value='Vía Oftálmica'>Vía Oftálmica</option><option value='Vía Ótica'>Vía Ótica</option><option value='Vía Intranasal'>Vía Intranasal</option><option value='Vía Inhalatoria'>Vía Inhalatoria</option><option value='Vía Rectal'>Vía Rectal</option><option value='Vía Vaginal'>Vía Vaginal</option><option value='Vía Parenteral'>Vía Parenteral</option></select></div><div class='n_flex n_flex_col100 sm_flex_col45 lg_flex_col45 block '><input id='cantidad" + idDetalleKit + "' type='number' min='0' onblur='validarNegativo("+idDetalleKit+")' placeholder='Cantidad'></div></div><div class='content-solid height-fijo whole_wrapper' style='display:flex;justify-content:center;aling-items:center;margin-bottom:5px;height: 53px;'><p class='block05 subTitulo'>Cantidad Disponible: </p><input type='text' id='cantidadDisponible" + idDetalleKit + "' value='" + cantidad + "' style='display:none' /> <label id='lblCantidad" + idDetalleKit + "'> " + cantidad + "</label></div><div id='contenedorBtnMedic" + idDetalleKit + "'><div class='checkbox' style=width: 35px;'><input id='AutorizacionMedicamento" + idDetalleKit + "' type='checkbox'><label id='id_lbl_" + idDetalleKit + "' class='autorizacion' style='height: 35px;width: 100%;' for='AutorizacionMedicamento" + idDetalleKit + "' class='lbl_autorizacion' onclick='abrirModalAutorizacion(" + idDetalleKit + ",\"" + nombre + "\")' tittle='Solicitar Autorización'><i class='fa fa-paper-plane'></i></label></div><button id='btnAgregarMedicamento" + idDetalleKit + "' type='button' onclick='medicamentoUsNat(" + idDetalleKit + ",\"" + nombre + "\");abrirModalAutorizacion(" + idDetalleKit + ",\"" + nombre + "\")' class='btn btn-registrar agregarMedicamento' style='width:100%' name='button' >Agregar</button></div></div></div></div>");
    $('#hora' + idDetalleKit).timepicker({
        timeFormat: 'H:i',
        step: 1,
        minTime: res
    });

    $(".autorizacion").css("display","none");
    $("#btnConsultarAutorizacion").css("display","none");
    $(".btn-segundoMedicamento").css("display","none");
};

function validarNegativo(id){
  if (!/^([0-9])*$/.test($("#cantidad"+id).val())){
  Notificate({
      tipo: 'error',
      titulo: 'Error ',
      descripcion: 'Solo números positivos, por defecto será el número 1',
      duracion: 4
  });
  $("#cantidad"+id).val("1");
  }
}

function listMedicamento() {

    $("#contenedorMedicamento").children().remove();
    var kit = JSON.parse(localStorage.getItem("ReporteAPH-kit"));


    for (var k = 0 in kit) {
        if (k != "chunk") {
            agregarContenedorMedicamento(kit[k].idDetalleKit, kit[k].nombre, kit[k].descripcion, kit[k].cantidadAsignada);
        }
    };
};


function removerMedicamento(idStorage) {
    var medicamento = JSON.parse(localStorage.getItem("ReporteAPH-Medicamento"));
    var newMedicamento = [];
    var id;
    var cantidad;
    var cantidadDisponible;
    for (var i = 0 in medicamento) {
        if (medicamento[i].idLocalStorage == idStorage) {
            id = medicamento[i].id;
            cantidad = medicamento[i].cantidad;
            delete medicamento[i];
            newMedicamento = limpiarArray(medicamento);
        }
    }
    var kit = JSON.parse(localStorage.getItem("ReporteAPH-kit"));
    for (var i = 0 in kit) {
        if (kit[i].idDetalleKit == id) {
            cantidadDisponible = kit[i].cantidadAsignada;
            kit[i].cantidadAsignada = parseInt(cantidad) + parseInt(cantidadDisponible);
        }
    };

    localStorage.setItem("ReporteAPH-kit", JSON.stringify(kit));
    localStorage.setItem("ReporteAPH-Medicamento", JSON.stringify(newMedicamento));
    listarMedicamentosUsados();
};

function agregarMedicamentoLocalStorage(idDetalleKit, dosis, hora, via, cantidad, nombre) {
    var medicamento = localStorage.getItem("ReporteAPH-Medicamento");
    var idLocalStorage = 0;
    if (medicamento != null) {
        medicamento = JSON.parse(medicamento);
        for (var i = 0 in medicamento) {

            if (medicamento[i].idLocalStorage > idLocalStorage) {

                idLocalStorage = medicamento[i].idLocalStorage;
            }
        };
        var idLocal = idLocalStorage + 1;
        var medicamentoNuevo = {
            idLocalStorage: idLocal,
            id: idDetalleKit,
            dosis: dosis,
            hora: hora,
            viaAdministracion: via,
            cantidad: cantidad,
            nombre
        };
        medicamento.push(medicamentoNuevo);
        localStorage.setItem("ReporteAPH-Medicamento", JSON.stringify(medicamento));
    } else {
        localStorage.setItem("ReporteAPH-Medicamento", JSON.stringify([{
            idLocalStorage: 1,
            id: idDetalleKit,
            dosis: dosis,
            hora: hora,
            viaAdministracion: via,
            cantidad: cantidad,
            nombre: nombre
        }]));
    }
}


function listarMedicamentosUsados() {
    $("#contListMedicamento").css("display", "block");
    $("#contMedicam").css("display", "none");
    $("#contenedorMedicamentoUsados").children().remove();
    var medicamento = JSON.parse(localStorage.getItem("ReporteAPH-Medicamento"));
    if (medicamento != null) {
        for (var i = 0 in medicamento) {
            if (i != "chunk") {
                $("#contenedorMedicamentoUsados").append('<li class="list_item n_dont_grow"><div class="list_item_header n_flex n_nowrap"><label class="item_icon n_flex n_align_center icono-medicamento" onClick="removerMedicamento(' + medicamento[i].idLocalStorage + ')" style="background: rgba(229,74,101,0.9); cursor:pointer;color:#fff"><span class="fa fa-trash"></span></label><div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"><h5 class="text_bold suspensive">' + medicamento[i].nombre + '</h5></div></div><div class="list_item_content"><p class="suspensive"><span class="text_bold">Dosis:</span>' + medicamento[i].dosis + '</p></div><div class="list_item_content"><p class="suspensive"><span class="text_bold">Cantidad:</span>' + medicamento[i].cantidad + '</p></div><div class="list_item_content"><p class="suspensive"><span class="text_bold">Hora:</span>' + medicamento[i].hora + '</p></div><div class="list_item_content"><p class="suspensive"><span class="text_bold">Via de Administracion:</span>' + medicamento[i].viaAdministracion + '</p></div></li>');
            }
        };
    } else {
        Notificate({
            tipo: 'info',
            titulo: 'Información',
            descripcion: 'No hay ningun medicamento agregado'
        });
    }



}

function cerrarMedicamentoUsados() {

    $("#contMedicam").css("display", "block");
    $("#contListMedicamento").css("display", "none");

    listMedicamento();
    listarSolicitudesMedicamento();
}

function limpiarArray(medic) {
    var newMedicamento = new Array();
    for (var i = 0, j = medic.length; i < j; i++) {

        if (medic[i]) {
            newMedicamento.push(medic[i]);
        };

    };

    return newMedicamento;
}


function abrirModalAutorizacion(id, nombre) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "ReporteAPH/ctrlMedicamento/ValidarTipoAmbulancia",
        data: {
            "": ""
        },
        async: false
    }).done(function(lista) {
      if (lista != "") {
        if (lista[0].tipoAmbulancia == "TAM") {
            $('#cuadro_autorizacion').append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">REGISTRAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Registrar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="frmCont autentificacion" style="width:100%"><label for="txtUsuarioAutentificacion">Usuario: </label><div class="frmInput"><input class="input_data bloquear usuarioCheck" ng-blur="BorrarBordeusuario()" ng-model="formulario.usuario" type="text" name="txtUsuarioAutentificacion" id="usuarioMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Clave: </label><div class="frmInput"><input class="input_data bloquear passwordCheck" ng-blur="BorrarBordepass()" ng-model="formulario.pass" type="password" name="txtClaveAutentificacion" id="claveMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Descripcion: </label><div class="frmInput"><textarea rows="4" id="txtDescripcion" cols="10"></textarea></div></div></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="registrarAutorizacionMedicalizada(' + id + ')" >Registrar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
        } else if (lista[0].tipoAmbulancia == "TAB") {
            $('#cuadro_autorizacion').append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">SOLICITAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Solicitar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><b>Descripcion </b><br><br><textarea id="txtArea' + id + '" name="name" rows="8" cols="40"></textarea></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="solicitar_autorizacion(' + id + ')" >Solicitar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
        }
      }else{
        Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'No te encuentras asignado a ninguna ambulancia',
            duracion: 4
        });
      }
    }).fail(function(){
      Notificate({
          tipo: 'error',
          titulo: 'Error ',
          descripcion: 'No te encuentras asignado a ninguna ambulancia',
          duracion: 4
      });
    });
}

function crearNotificacion() {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url + 'ReporteAPH/ctrlTratamientoB/ListarRespuestaNotificacion'
    }).done(function(data) {
        if (data[0]['estadoEvaluacion'] == 'Aprobada') {
            Notificate({
                tipo: 'success',
                titulo: 'Respuesta de Solicitud:',
                descripcion: '<b>Estado:</b> ' + data[0].estadoEvaluacion + '<br><b>Descripcion:</b> ' + data[0].observacionRespuestaAutorizacion + '',
                duracion: 10
            });
        } else if (data[0]['estadoEvaluacion'] == 'Rechazada') {
            Notificate({
                tipo: 'Error',
                titulo: 'Respuesta de Solicitud:',
                descripcion: '<b>Estado:</b> ' + data[0].estadoEvaluacion + '<br><b>Descripcion:</b> ' + data[0].observacionRespuestaAutorizacion + '',
                duracion: 10
            });
        }
        listarSolicitudesMedicamento();
    }).fail(function() {
        Notificate({
            tipo: 'Error',
            titulo: 'Error de consulta:',
            descripcion: 'No se puedo realizar la consulta de las solicitudes de autorización',
            duracion: 10
        });
    })
};

function registrarAutorizacionMedicalizada(idT) {
    var registro = localStorage.getItem("ReporteAPH-Paciente");
    cedula = "";
    if (registro != null) {
        var cedulaPaci = JSON.parse(registro);
        cedula = cedulaPaci['documento'];
    } else {
        cedula == "NN";
    }
    var usuario = $("#usuarioMedico").val();
    var pass = $("#claveMedico").val();
    var descripcion = $("#txtDescripcion").val();
    var datos = "usuario=" + usuario + "&pass=" + pass + "&descripcion=" + descripcion + "&id=" + idT + "&cedula=" + cedula;
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url + 'ReporteAPH/ctrlMedicamento/registrarAutorizacionMedicalizada',
        data: datos
    }).done(function(data) {
        listarSolicitudesMedicamento();
    }).fail(function() {
        Notificate({
            tipo: 'Error',
            titulo: 'Error de autenticacione:',
            descripcion: 'Recuerde que debe ser un médico quien se autentique para registrar la autorización',
            duracion: 10
        });
    });
    $("#abrirConfirmacion").remove('');
}


function cerrarSolicitudAutorizacion() {
    $("#abrirConfirmacion").remove('');
}
function solicitar_autorizacion(idMedicamento) {
    var nombre_temporal = $('#lbl_medicamento_' + idMedicamento).val();
    var registro = localStorage.getItem("ReporteAPH-Paciente");
    var cedulaPaci = "";
    if (registro != null) {
        cedulaPaci = JSON.parse(registro);
        cedulaPaci = cedulaPaci['documento'];
    } else {
        cedulaPaci = "NN";
    }
    $('#id_div_' + idMedicamento).remove();
    $('#id_lbl_' + idMedicamento).attr('disabled', 'disabled');
    $('#id_lbl_' + idMedicamento).removeAttr('style');
    $('#id_lbl_' + idMedicamento).attr('style', 'background:#18b9e3;border: solid 1px #18b9e3');
    $('#id_check_' + idMedicamento).attr('disabled', 'disabled');

    var id_Medicamento = idMedicamento;
    var descripcion_autorizacion = $("#txtArea" + idMedicamento).val();

    var variable = "idMedicamento=" + id_Medicamento + "&descripcion=" + descripcion_autorizacion + "&cedula=" + cedulaPaci;
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: url + "ReporteAPH/ctrlMedicamento/RegistrarAutorizacion",
        data: variable
    }).done(function(array) {
        listarSolicitudesMedicamento();
        ConsultarMedicos();
        Notificate({
            tipo: 'success',
            titulo: 'Solicitud!',
            descripcion: "Se ha enviado una solicitud",
            duracion: 4
        });
    }).fail(function() {
        Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: "Error al registrar",
            duracion: 4
        });
    });

    $("#abrirConfirmacion").remove('');
}

function listarSolicitudesMedicamento() {
    var consultaPaciente = JSON.parse(localStorage.getItem("ReporteAPH-Paciente"));
    if (consultaPaciente != null) {
        cedulaPaciente = consultaPaciente['documento'];
    } else {
        cedulaPaciente = "NN";
    };

    var modoConsulta = JSON.parse(localStorage.getItem("ReporteAPH-idReporteAPH"));
    if (modoConsulta != null) {
        reporte = modoConsulta;
    } else {
        reporte = 0;
    }
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "ReporteAPH/ctrlMedicamento/ListadoAutorizacion",
        data: {
            "idReporte": reporte,
            "cedulaPaciente": cedulaPaciente
        }
    }).done(function(e) {
      $('#SolicitudMedicamento').children().remove();
      $.each(e, function(l, s) {
        var descripcion_respuesta = (s.observacionRespuestaAutorizacion == null) ? 'Aún no hay respuesta.' : s.observacionRespuestaAutorizacion;
        $('#SolicitudMedicamento').append("<tr><td>" + s.nombre + "</td><td>" + s.descripcionAutorizacion + "</td><td>" + descripcion_respuesta + "</td><td>" + s.estadoEvaluacion + "</td></tr>");
      });
      e.reverse();
        $.each(e, function(l, s) {
            if (s.estadoEvaluacion == 'Por Evaluar') {

                var id = s.idMedicamento;
                var fecha = s.fechaEnvio;
                var cedula = s.cedulaPaciente;
                $('#id_lbl_' + id).attr('style', 'width: 100%;height: 35px !important;font-size: 22px;');
                $('#id_lbl_' + id).empty();
                $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-question-circle'></i><div>");
                $('#id_lbl_' + id).removeAttr('onclick');
                $('#id_lbl_' + id).attr('onclick', 'cancelarAutorizacion_vista("' + id + '","' + fecha + '", "' + cedula + '","' + s.nombre + '")');
            } else if (s.estadoEvaluacion == 'Aprobada') {
                var id = s.idMedicamento;
                $('#id_lbl_' + id).empty();
                $('#id_lbl_' + id).removeAttr('onclick');
                $('#id_div_' + id).remove();
                $('#id_lbl_' + id).attr('onclick', 'abrirModalAutorizacion(' + id + ',"' + s.nombre + '")');
                $('#id_lbl_' + id).attr('style', 'background:#2ecc71 !important;border: solid 1px #2ecc71 !important;color: #fff !important;height: 35px;font-size: 22px;width:100%');
                $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-check-circle'></i></i><div>");
            } else if (s.estadoEvaluacion == 'Cancelado') {

                var id = s.idMedicamento;
                $('#id_lbl_' + id).empty();
                $('#id_lbl_' + id).removeAttr('onclick');
                $('#id_lbl_' + id).attr('onclick', 'abrirModalAutorizacion(' + id + ',"' + s.nombre + '")');
                $('#id_div_' + id).remove();
                $('#id_lbl_' + id).attr('style', 'background:#515554 !important;border: solid 1px #515554 !important;color: #fff !important;height: 35px;font-size: 22px;width:100%');
                $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-ban'></i></i><div>");
            } else if (s.estadoEvaluacion == 'Rechazada') {

                var id = s.idMedicamento;
                $('#id_lbl_' + id).empty();
                $('#id_lbl_' + id).removeAttr('onclick');
                $('#id_lbl_' + id).attr('onclick', 'abrirModalAutorizacion(' + id + ',"' + s.nombre + '")');
                $('#id_div_' + id).remove();
                $('#id_lbl_' + id).attr('style', 'background:rgba(229,74,101,0.9) !important;border: solid 1px rgba(229,74,101,0.9) !important;color: #fff !important;height: 35px;font-size: 22px;width:100%');
                $('#id_lbl_' + id).append("<div id='id_div_" + id + "'><i class='fa fa-times-circle'></i></i><div>");
            }

        });
    }).fail(function() {});
}

function cancelarAutorizacion_vista(idMedicamento, FechaEnvio, cedulaR, nombre) {

    $(".temporalAuto").remove();
    $("#cuadro_autorizacion").append('<div class="md_solicitarAyuda" id="abrirConfirmacion"><input type="text" id="txt_cedula_001" value="' + cedulaR + '" style="display:none"/><input type="text" id="txt_fecha_001" value="' + FechaEnvio + '" style="display:none"/><input type="text" id="lbl_medicamento_' + idMedicamento + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">CANCELAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Cancelar Autorizacion Para:  <b style="margin-left:5px"> ' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="cancelar_autorizacion(' + idMedicamento + ')" >Cancelar Solicitud</button></div></div></div></div></div></div>');
}

function cancelar_autorizacion(idMedicamento) {

    $('#id_lbl_' + idMedicamento).attr('disabled', 'disabled');

    var cedula = $("#txt_cedula_001").val();
    var FechaEnvio = $("#txt_fecha_001").val();

    var FormData1 = "cedula=" + cedula + "&FechaEnvio=" + FechaEnvio;


    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "ReporteAPH/ctrlMedicamento/ActualizarEstadoAutorizacion",
        data: FormData1
    }).done(function(d) {
        listarSolicitudesMedicamento();
        Notificate({
            tipo: 'info',
            titulo: 'Solicitud',
            descripcion: 'Se ha cancelado la solicitud de autorizacion',
            duracion: 4
        });
    }).fail(function(f) {

        Notificate({
            tipo: 'error',
            titulo: 'Error',
            descripcion: 'Error al cancelar la solicitud',
            duracion: 4
        });
    })

    $("#abrirConfirmacion").remove('');
}


$(document).ready(function() {
    listarSolicitudesMedicamento();
});
