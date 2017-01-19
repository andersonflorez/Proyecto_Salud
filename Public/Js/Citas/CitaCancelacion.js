$(document).ready(function(){
  $("#btnConsultaCP ").click(function(){
    ConsultarCitaPersonal();
  });
});

/*Funcion Listar Citas*/
function ConsultarCitaPersonal() {
  var datos = JSON.parse(localStorage.getItem("InformacionPaciente"));
  $.ajax({
    // async:false,
    type:'POST',
    dataType:'JSON',
    url: url+"Citas/CtrlCitas/ConsultarCitasP",
    data:{txtidPaciente:datos.idPac}
  }).done(function(data){
    //console.log(data);
    if (data!="") {
    AbrirModal('modalCitas');
    $("#cont-table").html('');
    var NombreCompleto=atob(datos.PrimerNombre)+" "+atob(datos.PrimerApellido);
    $("#NombreP").html("Citas asignadas a"+NombreCompleto);
    $.each(data, function(a,b){
      $("#cont-table").
      append("<tr><td onmouseout='ocultarNombreCUP()' onmouseover='mostrarNombreCUP("+'"'+b.nombreCUP+'"'+")'><p>"+b.codigoCup+"</p>"+"</td><td>"+b.fechaCita+"</td><td>"+b.horaInicial+
      "</td><td>"+b.estadoTablaCita+"</td><td> <button value='"+b.idCUP+
      "' type='button' class='btn btn-eliminar fa fa-times' id='btnCambiarEstado' OnClick=\"CancelarCita("+b.idCita+",'"+b.estadoTablaCita+"','"+b.horaInicial+"','"+b.fechaCita+"','"+b.nombreCUP+"','"+NombreCompleto+"')\"></button></td></tr>")
    });
  }else{
    $("#cont-table").parent().html("<div style='font-size: 24px;color: #888;text-align: center;display: table-caption;line-height: 30px;font-weight: bold;' >No se encuentran citas registradas</div>");
    Notificate({
      tipo: 'info',
      titulo: 'Información',
      descripcion: 'El paciente no tiene citas asignadas.'
    });
  }
  }).fail(function(){
    alert("estoy en el fail")
  })
}

function mostrarNombreCUP(texto){
  $("#textNombreCUP").html("<b>Nombre CUP:</b> "+texto);
}

function ocultarNombreCUP(){
  $("#textNombreCUP").text("");
}

function CancelarCita(idCita, EstadoCita, HoraInicial, FechaCita,nombreCUP,NombreCompleto ){
  var datosp = JSON.parse(localStorage.getItem("InformacionPaciente"));
  $.ajax({
    type:'POST',
    url : url+ "Citas/CtrlCitas/CambiarEstadoC",
    data: {'txtidCita': idCita, 'EstadoCita':EstadoCita, 'HoraInicial':HoraInicial, 'FechaCita':FechaCita,"idPaciente":datosp.idPac}
  }).done(function(data){
    ConsultarCitaPersonal();
    if(data=="0"){
      $("#SltEstadoPaciente").html("<option selected='selected' value='3'>Mora</option>");
      $(".select").select2();
      if (datosp.Correo!="") {
        enviarReporte(idCita,FechaCita,HoraInicial,nombreCUP,0,NombreCompleto);
      }else {
        swal({
          title: "Cita cancelada correctamente y se le ha generado mora.",
          text: "<b>Nombre del paciente</b> : "+NombreCompleto+"<br><b>Fecha de la cita</b> : "+FechaCita+" <br><b>Hora de la cita </b> : "+HoraInicial+"<br><b>Nombre del servicio </b> : "+nombreCUP+"",
          html:true,
          type: "warning",
          confirmButtonText: "Salir",
          confirmButtonColor: "#515554",
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        });
      }
    }else {
      if (datosp.Correo!="") {
        enviarReporte(idCita,FechaCita,HoraInicial,nombreCUP,1,NombreCompleto);
      }else {
        swal({
          title: "Cita cancelada correctamente.",
          text: "<b>Nombre del paciente</b> : "+NombreCompleto+"<br><b>Fecha de la cita</b> : "+FechaCita+" <br><b>Hora de la cita </b> : "+HoraInicial+"<br><b>Nombre del servicio </b> : "+nombreCUP+"",
          html:true,
          type: "success",
          confirmButtonText: "Salir",
          confirmButtonColor: "#515554",
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        });
      }
    }

  }).fail(function(){
    console.log("Dentre Al Error");
  });
}

function enviarReporte(idCita,FechaCita, HoraInicial,nombreCUP,conDato,NombreCompleto){
  var datos = JSON.parse(localStorage.getItem("InformacionPaciente"));
  var correoElectronico=atob(datos.Correo);
  if (conDato==0) {
  swal({
    title: "Cita cancelada correctamente y se le ha generado una multa.",
    text: "<b>Nombre del paciente</b> : "+NombreCompleto+"<br><b>Fecha de la cita</b> : "+FechaCita+" <br><b>Hora de la cita </b> : "+HoraInicial+"<br><b>Nombre del servicio </b> : "+nombreCUP+"</br><b>Correo Electronico </b>:"+correoElectronico+"<br> ",
    html:true,
    type: "warning",
    confirmButtonText: "Enviar correo",
    confirmButtonColor: "#2ecc71",
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  }, function(){
    $.ajax({
      type:"POST",
      url: url + "Citas/ctrlCitas/enviarReporte",
      data:{idP:datos.idPac, idCita: idCita, correoElectronico:correoElectronico, FechaCita:FechaCita, NombreCompleto:NombreCompleto, HoraInicial:HoraInicial, nombreCUP:nombreCUP}
    }).done(function(data){
      swal("Correo enviado con éxito");
      ConsultarCitaPersonal();
    }).fail(function(error){
      console.log(error);
    });

  });
}else {
  swal({
    title: "Cita cancelada correctamente.",
    text: "<b>Nombre del paciente</b> : "+NombreCompleto+"<br><b>Fecha de la cita</b> : "+FechaCita+" <br><b>Hora de la cita </b> : "+HoraInicial+"<br><b>Nombre del servicio </b> : "+nombreCUP+"</br><b>Correo Electronico </b>:"+correoElectronico+"<br> ",
    html:true,
    type: "success",
    confirmButtonText: "Enviar correo",
    confirmButtonColor: "#2ecc71",
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  }, function(){
    $.ajax({
      type:"POST",
      url: url + "Citas/ctrlCitas/enviarReporte",
      data:{idP:datos.idPac, idCita: idCita, correoElectronico:correoElectronico, FechaCita:FechaCita, NombreCompleto:NombreCompleto, HoraInicial:HoraInicial, nombreCUP:nombreCUP}
    }).done(function(data){
      swal("Correo enviado con éxito");
      ConsultarCitaPersonal();
    }).fail(function(error){
      console.log(error);
    });
  });
}
}
