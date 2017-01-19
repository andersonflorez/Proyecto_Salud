(function(){
  'use strict';

  app.controller('ctrlResultadosDeAtencion', function($scope, $http,  $localStorage, RegistrarReporte){
    $scope.ReporteI =$localStorage.ReporteInicial || [];
    $scope.ExamenFisicoAPH = $localStorage.ExamenFisicoAPH || [];
    $scope.Aseguramiento = $localStorage.Aseguramiento || [];
    $scope.horaConfirmacion = $localStorage.HoraConfirmacion || "";
    $scope.Paciente =$localStorage.Paciente || [];
    if ($scope.ReporteI == ""  ||  $scope.ExamenFisicoAPH == "" || $scope.Aseguramiento == "" || $scope.horaConfirmacion == "" || $scope.Paciente == []) {
      window.location = url + 'ReporteAPH/ctrlIndex?error=error';
    }else{

      $("#horaArriboIPS").timepicker({
        timeFormat:'H:i',step:1
      });

      $scope.horaMala = false;
      $scope.testigoUno = false;
      $scope.testigoDos = false;
      $scope.bloquearNoLlegada = false;
      $scope.opcion = false;

      $scope.IdTipoAseguramiento = $scope.Aseguramiento.id;
      $scope.ProximoID = "";
      $scope.Disabled = false;
      $scope.Lesiones = $localStorage.Lesiones || [];
      $scope.ultimoRegistroAPH="";
      $scope.listadoCertificadoAtencion = [];
      $scope.Cuidados = $scope.ReporteI.Cuidados;
      $scope.novedades = $localStorage.Novedades || [];
      $scope.ResultadoFinal = $localStorage.ResultadoFinal || {
        resultado:'',
        institucion:'',
        complicacion:'',
        entregaPaciente:'',
        testigoUno:{nombre:'',cedula:''},
        testigoDos:{nombre:'',cedula:''},
        presionArterial:'',
        pulso:'',
        respiracion:'',
        personalPresente:'',
        TAPHPresente:false,
        TPAPHPresente:false,
        otroPersonalPresente:false,
        controlMedico:['Aplicativo Web'],
        protocolo:0,
        idCertificado:'',
        nombreotroPersonal:'',
        arribo:''
      };
      var hoy = new Date();
      var dd = hoy.getDate();
      var mm = hoy.getMonth()+1;
      var yyyy = hoy.getFullYear();
      var hoyEstandar = dd+"/"+mm+"/"+yyyy+' ';
      $scope.fechaEscenaSplit = $localStorage.HoraConfirmacion.split(':');
      $scope.horaConfirmacionValidar = $scope.fechaEscenaSplit[0] +':'+$scope.fechaEscenaSplit[1];
      if ($scope.ResultadoFinal.arribo!="") {
        if (hoyEstandar+$scope.horaConfirmacionValidar > hoyEstandar+$scope.ResultadoFinal.arribo) {
          $(".checkhora").addClass("checkTipoEvento");
          $scope.horaMala = true;
        }
      }

      $scope.formulario={
        'usuario':'',
        'pass':''
      }
      $scope.TestigosEnviar = [];
      $scope.Testigoslocal = $localStorage.ResultadoFinal;
      $scope.testigosUno = $scope.ResultadoFinal.testigoUno || {};
      $scope.testigosDos = $scope.ResultadoFinal.testigoDos || {};

      $localStorage.ResultadoFinal = $localStorage.ResultadoFinal || $scope.ResultadoFinal ;
      $scope.validarCampollenoNombreOtroPersonal = function(){
        $(".checkNombreOtroPersonal").removeClass("checkTipoEvento");
        if ($scope.ResultadoFinal.otroPersonalPresente == false) {
          $localStorage.ResultadoFinal.nombreotroPersonal = "";
        }
      }
      $scope.borrarBordehora = function(){
        if ($scope.ResultadoFinal.arribo == "") {
          $("#horaArriboIPS").addClass("checkTipoEvento");
        }else if (hoyEstandar+$scope.horaConfirmacionValidar > hoyEstandar+$scope.ResultadoFinal.arribo) {
          $("#horaArriboIPS").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'La hora del Arribo a la IPS debe ser inferior a la hora en que se confirmó la emergencia.',
            duracion: 5
          });
          $scope.horaMala = true;
        }
        else{
          $("#horaArriboIPS").removeClass("checkTipoEvento");
          $scope.horaMala = false;
        }
      }
      $scope.quitarBordeOtroPersonal = function(){
        if ($scope.ResultadoFinal.nombreotroPersonal == "") {
          $(".checkNombreOtroPersonal").addClass("checkTipoEvento");
        }else{
          $(".checkNombreOtroPersonal").removeClass("checkTipoEvento");
        }
      }
      $scope.GuardarResultadosFinales = function(){
        $localStorage.ResultadoFinal = $scope.ResultadoFinal;
      }
      $scope.ListarCertificadoAtencion = function(){

        $http.post(url + 'ReporteAPH/ctrlResultadosAtencion/ListarCertificadoAtencion')
        .success(function(lista){
          $scope.listadoCertificadoAtencion = lista;
        })
        .error(function(error){
          console.log(error);
        })
      }

      var IDESTipoEvento= $localStorage.ReporteInicial.IDESTipoEvento;
      var urg = $localStorage.Urgencias;
      var TratamientoAvanzado = $localStorage.tratamientoAvanzado;
      var TratamientoBasico = $localStorage.tratamientoBasico;
      var tratamientoBasicoOxigeno = $localStorage.tratamientoBasicoOxigeno;
      var tratamientoAvanzadoDextrosa = $localStorage.tratamientoAvanzadoDextrosa;
      if ($scope.ResultadoFinal.resultado === "Paciente niega atención" || $scope.ResultadoFinal.resultado === "Dado Alta en Sitio" || $scope.ResultadoFinal.resultado === "Paciente niega transporte") {
        $scope.bloquearNoLlegada = true;
        $scope.ResultadoFinal.institucion = "";
        $scope.ResultadoFinal.arribo = "";
        $scope.formulario.usuario = "";
        $scope.formulario.pass = "";
        $scope.ResultadoFinal.arribo = "";
        $("#horaArriboIPS").removeClass("checkTipoEvento");
        $(".checkInstitucion").removeClass("checkTipoEvento");
        $(".usuarioCheck").removeClass("checkTipoEvento");
        $(".passwordCheck").removeClass("checkTipoEvento");
      }else{
        $scope.bloquearNoLlegada = false;
      }
      $scope.GuardarReporte = function(){
        if ($("#testigoUno").val() != "" && $("#cedTestigoUno").val() == "") {
          $("#cedTestigoUno").addClass("checkTipoEvento");
          $scope.testigoUno = true;
        }else if ($("#testigoUno").val() == "" && $("#cedTestigoUno").val() != "") {
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $("#testigoUno").addClass("checkTipoEvento");
          $scope.testigoUno = true;
        }else if ($("#testigoUno").val() != "" && $("#cedTestigoUno").val() != "") {
          $("#testigoUno").removeClass("checkTipoEvento");
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $scope.testigoUno = false;
        }else if ($("#testigoUno").val() == "" && $("#cedTestigoUno").val() == "") {
          $("#testigoUno").removeClass("checkTipoEvento");
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $scope.testigoUno = false;
        }else{
          $("#testigoUno").removeClass("checkTipoEvento");
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $scope.testigoUno = false;
        }
        if ($("#nombreTestigoDos").val() != "" && $("#cedulaTestigoDos").val() == "") {
          $("#cedulaTestigoDos").addClass("checkTipoEvento");
          $scope.testigoDos = true;
        }else if ($("#nombreTestigoDos").val() == "" && $("#cedulaTestigoDos").val() != "") {
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $("#nombreTestigoDos").addClass("checkTipoEvento");
          $scope.testigoDos = true;
        }else if ($("#nombreTestigoDos").val() != "" && $("#cedulaTestigoDos").val() != "") {
          $("#nombreTestigoDos").removeClass("checkTipoEvento");
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $scope.testigoDos = false;
        }else if ($("#nombreTestigoDos").val() == "" && $("#cedulaTestigoDos").val() == "") {
          $("#nombreTestigoDos").removeClass("checkTipoEvento");
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $scope.testigoDos = false;
        }else{
          $("#nombreTestigoDos").removeClass("checkTipoEvento");
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $scope.testigoDos = false;
        }
        if ($localStorage.Aseguramiento.id == "") {
          $scope.RegistrarTipoAseguramiento();
        }
        var MedicoRecibe = JSON.parse(localStorage.getItem("ReporteAPH-MedicoRecibe"));
        if ($scope.ResultadoFinal.controlMedico == "" && $scope.ResultadoFinal.resultado == "" && $scope.ResultadoFinal.entregaPaciente == "" && $scope.ResultadoFinal.presionArterial == "" && $scope.ResultadoFinal.pulso == "" && $scope.ResultadoFinal.respiracion == "" && $scope.formulario.usuario == "" && $scope.formulario.pass == "" && $scope.ResultadoFinal.idCertificado == "" && $scope.ResultadoFinal.institucion == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario completar los campos obligatorios.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").addClass("checkTipoEvento");
          $(".checkResultados").addClass("checkTipoEvento");
          $(".checkEntrega").addClass("checkTipoEvento");
          $(".presionArterialCheck").addClass("checkTipoEvento");
          $(".pulsoCheck").addClass("checkTipoEvento");
          $(".respiracionCheck").addClass("checkTipoEvento");
          $(".usuarioCheck").addClass("checkTipoEvento");
          $(".passwordCheck").addClass("checkTipoEvento");
          $(".checkInstitucion").addClass("checkTipoEvento");
          $("#horaArriboIPS").addClass("checkTipoEvento");

        }else if($scope.ResultadoFinal.controlMedico == ""){
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la vía de comunicación.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").addClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.ResultadoFinal.otroPersonalPresente == true && $scope.ResultadoFinal.nombreotroPersonal == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el Nombre del Otro Personal Presente.',
            duracion: 5
          });
          $(".checkNombreOtroPersonal").addClass("checkTipoEvento");
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }
        else if ($scope.ResultadoFinal.resultado == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el resultado de atención.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").addClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.bloquearNoLlegada == false && $scope.ResultadoFinal.institucion == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la institución receptora.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").addClass("checkTipoEvento");
        }else if ($scope.bloquearNoLlegada == false && $scope.ResultadoFinal.arribo == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la hora del Arribo a la IPS.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
          $("#horaArriboIPS").addClass("checkTipoEvento");
        }
        else if ($scope.ResultadoFinal.entregaPaciente == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la situación de entrega de paciente.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").addClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.ResultadoFinal.presionArterial == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la presión arterial del paciente.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").addClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.ResultadoFinal.pulso == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el pulso del paciente.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").addClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.ResultadoFinal.respiracion == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la respiración del paciente.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").addClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.bloquearNoLlegada == false && $("#usuarioMedico").val() == "" ) {

          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el usuario que recibirá el paciente.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").addClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.bloquearNoLlegada == false && $("#claveMedico").val() == "") {

          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la clave del usuario que recibirá el paciente.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").addClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if($scope.bloquearNoLlegada == false && MedicoRecibe == ""){
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario verificar que el médico que recibirá al paciente exista.',
            duracion: 5
          });
          $(".usuarioCheck").addClass("checkTipoEvento");
          $(".passwordCheck").addClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");

        }else if ($scope.ResultadoFinal.idCertificado == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el certificado de la atención.',
            duracion: 5
          });
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
          $(".checkResultados").removeClass("checkTipoEvento");
          $(".checkEntrega").removeClass("checkTipoEvento");
          $(".presionArterialCheck").removeClass("checkTipoEvento");
          $(".pulsoCheck").removeClass("checkTipoEvento");
          $(".respiracionCheck").removeClass("checkTipoEvento");
          $(".usuarioCheck").removeClass("checkTipoEvento");
          $(".passwordCheck").removeClass("checkTipoEvento");
          $(".CheckCertificadoAtencion").addClass("checkTipoEvento");
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }else if ($scope.testigoUno == true) {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el testigo número uno.',
            duracion: 5
          });
        }else if ($scope.testigoDos == true) {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el testigo número dos.',
            duracion: 5
          });
        }else if ($scope.bloquearNoLlegada == false && $scope.horaMala == true ) {
           Notificate({
             tipo: 'error',
             titulo: 'Error!',
             descripcion: 'La hora del Arribo a la IPS debe ser superior a la hora en que se confirmó la emergencia.',
             duracion: 5
           });
         }
        else{

          $scope.ValidarDespachoUnico();
        }
      }
      $scope.BorrarClaseCheckViaCcion = function(){

        if ($scope.ResultadoFinal.controlMedico == "") {
          $(".CheckRojoControlMedico").addClass("checkTipoEvento");
        }else{
          $(".CheckRojoControlMedico").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarCheckResultados = function(){
        if ($scope.ResultadoFinal.resultado == "") {
          $(".checkResultados").addClass("checkTipoEvento");
        }else{
          if ($scope.ResultadoFinal.resultado === "Paciente niega atención" || $scope.ResultadoFinal.resultado === "Dado Alta en Sitio" || $scope.ResultadoFinal.resultado === "Paciente niega transporte") {
            $scope.bloquearNoLlegada = true;
            $scope.ResultadoFinal.institucion = "";
            $scope.ResultadoFinal.arribo = "";
            $scope.formulario.usuario = "";
            $scope.formulario.pass = "";
           $localStorage.MedicoRecibe = "";
           $localStorage.Datos = "";
           $(".usuarioCheck").val("");
           $(".passwordCheck").val("");
           $("#idPersona").val("");
           $("#nombreMedico").val("XXXXXXXXXXXXXX");
           $("#ApellidoMedico").val("XXXXXXXXXXXXXX");
           $("#numeroMedico").val("XXXXXXXXXXXXXX");
           $("#frmaMedico").empty();
           $("#imagenMedico").attr("src","../Public/Img/ReporteAPH/usuarioVacio.jpeg");
            $(".checkInstitucion").removeClass("checkTipoEvento");
            $(".usuarioCheck").removeClass("checkTipoEvento");
            $(".passwordCheck").removeClass("checkTipoEvento");
            $("#horaArriboIPS").removeClass("checkTipoEvento");
          }else{
            $scope.bloquearNoLlegada = false;
          }
          $(".checkResultados").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarCheckEntregaPaciente = function(){
        if ($scope.ResultadoFinal.entregaPaciente == "") {
          $(".checkEntrega").addClass("checkTipoEvento");
        }else{
          $(".checkEntrega").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarBordeDiagnosticoPre = function(){
        if ($scope.ResultadoFinal.presionArterial == "") {
          $(".presionArterialCheck").addClass("checkTipoEvento");
        }else{
          $(".presionArterialCheck").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarBordeDiagnosticoPul = function(){
        if ($scope.ResultadoFinal.pulso == "") {
          $(".pulsoCheck").addClass("checkTipoEvento");
        }else{
          $(".pulsoCheck").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarBordeDiagnosticoRes = function(){
        if ($scope.ResultadoFinal.respiracion == "") {
          $(".respiracionCheck").addClass("checkTipoEvento");
        }else{
          $(".respiracionCheck").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarBordepass = function(){

        if ($("#claveMedico").val() == "") {
          $(".passwordCheck").addClass("checkTipoEvento");
        }else{
          $(".passwordCheck").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarBordeusuario = function(){

        if ($("#usuarioMedico").val() == "") {
          $(".usuarioCheck").addClass("checkTipoEvento");
        }else{
          $(".usuarioCheck").removeClass("checkTipoEvento");
        }
      }
      $scope.BorrarCertificadoAtencion=function(){
        if ($scope.ResultadoFinal.idCertificado == "") {
          $(".CheckCertificadoAtencion").addClass("checkTipoEvento");
        }else{
          $(".CheckCertificadoAtencion").removeClass("checkTipoEvento");
        }
      }
      $scope.borrarBordeInstitucion=function(){
        if ($scope.ResultadoFinal.institucion == "") {
          $(".checkInstitucion").addClass("checkTipoEvento");
        }else{
          $(".checkInstitucion").removeClass("checkTipoEvento");
        }
      }
      $scope.validarExistenciaTestigoUno = function(){
        if ($("#testigoUno").val() != "" && $("#cedTestigoUno").val() == "") {
          $("#cedTestigoUno").addClass("checkTipoEvento");
          $scope.testigoUno = true;
        }else if ($("#testigoUno").val() == "" && $("#cedTestigoUno").val() != "") {
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $("#testigoUno").addClass("checkTipoEvento");
          $scope.testigoUno = true;
        }else if ($("#testigoUno").val() != "" && $("#cedTestigoUno").val() != "") {
          $("#testigoUno").removeClass("checkTipoEvento");
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $scope.testigoUno = false;
        }else if ($("#testigoUno").val() == "" && $("#cedTestigoUno").val() == "") {
          $("#testigoUno").removeClass("checkTipoEvento");
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $scope.testigoUno = false;
        }else{
          $("#testigoUno").removeClass("checkTipoEvento");
          $("#cedTestigoUno").removeClass("checkTipoEvento");
          $scope.testigoUno = false;
        }
      }
      $scope.validarExistenciaTestigoDos = function(){
        if ($("#nombreTestigoDos").val() != "" && $("#cedulaTestigoDos").val() == "") {
          $("#cedulaTestigoDos").addClass("checkTipoEvento");
          $scope.testigoDos = true;
        }else if ($("#nombreTestigoDos").val() == "" && $("#cedulaTestigoDos").val() != "") {
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $("#nombreTestigoDos").addClass("checkTipoEvento");
          $scope.testigoDos = true;
        }else if ($("#nombreTestigoDos").val() != "" && $("#cedulaTestigoDos").val() != "") {
          $("#nombreTestigoDos").removeClass("checkTipoEvento");
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $scope.testigoDos = false;
        }else if ($("#nombreTestigoDos").val() == "" && $("#cedulaTestigoDos").val() == "") {
          $("#nombreTestigoDos").removeClass("checkTipoEvento");
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $scope.testigoDos = false;
        }else{
          $("#nombreTestigoDos").removeClass("checkTipoEvento");
          $("#cedulaTestigoDos").removeClass("checkTipoEvento");
          $scope.testigoDos = false;
        }
      }

      $scope.ConfigurarHora = function(){
        $("#FechaFinish").html("");
        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();
        var hora = hoy.getHours();
        var minutos = hoy.getMinutes();
        var segundos = hoy.getSeconds();

        if(dd<10) {
          dd='0'+dd
        }

        if(mm<10) {
          mm='0'+mm
        }

        hoy = mm+'/'+dd+'/'+yyyy+'  '+hora+':'+minutos+':'+segundos+'.';
        $("#FechaFinish").html(hoy);
      }
      $scope.RegistrarTipoAseguramiento = function(){
        $http.post(url + "ReporteAPH/CtrlTipoAseguramiento/registrarTipoAseguramientoHC",{'descripcion':$localStorage.Accidente.TipoAseguramiento.otroAseguramiento})
        .success(function(data){
          $localStorage.Aseguramiento.id = data.ultimoTipoAseguramiento;
          $localStorage.Aseguramiento.otroAseguramiento = "";
          $scope.IdTipoAseguramiento = data.ultimoTipoAseguramiento;
        })
        .error(function(err){
          console.log(err);
        })
      }
      $scope.ValidarDespachoUnico = function(){
        $http.post(url + "ReporteAPH/CtrlReporteAPH/ValidarDespachoUnico", {'idDespacho':$localStorage.ReporteInicial.idDespacho })
        .success(function(data){
          if (data == "0") {
            swal({
                 title: "¿Está seguro de almacenar el reporte APH?",
                  text: "Presione OK para confirmar que desea guardar el reporte APH.",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
                  },function(){
                    $scope.GuardarHistoriaClinica()
                    swal("El Reporte APH está siendo  almacenado.");
                  });

          }else{
          sweetAlert({
            title :"Error al guardar el reporte." ,
            text :"Lo sentimos, el reporte APH que se intentó guardar ya ha sido almacenado con anterioridad." ,
            type : "error",
          },function(){
            localStorage.clear();
            $http.post(url +"ReporteAPH/ctrlReporteAPH/Reset", {'request':'ajax'}).success(function(data) {
              location.href = url + 'ReporteAPH/ctrlIndex';
            });
          })



          }
        })
        .error(function(){

        })
      }
      $scope.GuardarHistoriaClinica  = function(){
        if ($scope.testigosUno.nombre != "" && $scope.testigosUno.cedula != "") {
          $scope.TestigosEnviar.push($scope.testigosUno);
        }
        if ($scope.testigosDos.nombre != "" && $scope.testigosDos.cedula != "") {
          $scope.TestigosEnviar.push($scope.testigosDos);
        }
        $scope.ConfigurarHora();
        $scope.Disabled = true;

        $scope.idReporteInicial = $localStorage.ReporteInicial.idReporteInicial;
        $scope.MotivoC = $localStorage.Urgencias;
        var otroMotivoConsulta = $scope.MotivoC.otro;
        $scope.ExamenFisicoAPH =   $localStorage.ExamenFisicoAPH;
        $scope.GlasgowRegistrar = $scope.ExamenFisicoAPH.TablaGlasgow;
        $scope.RespiracionRegistrar = $scope.ExamenFisicoAPH.Respiracion;
        $scope.PulsoRegistrar = $scope.ExamenFisicoAPH.Pulso;
        $scope.PresionArterialRegistrar = $scope.ExamenFisicoAPH.PresionArterial;
        $scope.ConcienciaRegistrar = $scope.ExamenFisicoAPH.Conciencia;
        $scope.PupilasRegistrar = $scope.ExamenFisicoAPH.Pupilas;
        $scope.EstadoHemodinamicoRegistrar = $scope.ExamenFisicoAPH.EstadoHemodinamico;
        $scope.EspecificacionExamenRegistrar = $scope.ExamenFisicoAPH.EspecificacionExamen;
        var objExamenFisico = {
          'glasgow':$scope.GlasgowRegistrar,
          'respiracion':$scope.RespiracionRegistrar,
          'pulso':$scope.PulsoRegistrar,
          'presionArterial':$scope.PresionArterialRegistrar,
          'conciencia':$scope.ConcienciaRegistrar,
          'pupilas':$scope.PupilasRegistrar,
          'estadoHemodinamico':$scope.EstadoHemodinamicoRegistrar,
          'especificacionExamen':$scope.EspecificacionExamenRegistrar
        };
        $scope.tratamientoAvanzado =   $localStorage.tratamientoAvanzado || [];
        $scope.tratamientoBasico =   $localStorage.tratamientoBasico || [];
        $scope.DescripcionTratamientoA = $scope.tratamientoAvanzado.observacionTratamiento || "";
        $scope.DescripcionTratamientoB = $scope.tratamientoBasico.observacionTratamiento || "";
        var idMedicoReceptor = JSON.parse(localStorage.getItem("ReporteAPH-MedicoRecibe"));
        var objParametrosAPH = {
          'idDespacho':$localStorage.ReporteInicial.idDespacho,
          'idAsignacionPersonal':$localStorage.ReporteInicial.idAsignacionPersonal,
          'idPersonalRecibeReg':idMedicoReceptor,
          'triage' :$localStorage.ReporteInicial.Triage,
          'idTipoAseguramientoReg' : $scope.IdTipoAseguramiento,
          'idCertiAtencion' : $localStorage.ResultadoFinal.idCertificado,
          'horaEscena' : $scope.horaConfirmacion,
          'horaIPS' : $localStorage.ResultadoFinal.arribo,
          'horaUltimaIngesta':$localStorage.ExamenFisicoAPH.Respiracion.fechaUltimaIngesta + ' ' + $localStorage.ExamenFisicoAPH.Respiracion.horaUltimaIngesta,
          'idAfectado' : $localStorage.Accidente.AfectadoAccidente.id,
          'placa':$localStorage.Accidente.AfectadoAccidente.placa,
          'poliza' : $localStorage.Accidente.AfectadoAccidente.numeroPoliza,
          'codAseguradora':$localStorage.Accidente.AfectadoAccidente.codigoAseguradora,
          'tratamientoB' : $scope.DescripcionTratamientoB,
          'tratamientoA' : $scope.DescripcionTratamientoA,
          'evaluacionRes' : $localStorage.ResultadoFinal.resultado,
          'instReceptora' : $localStorage.ResultadoFinal.institucion,
          'situacionEntrega':$localStorage.ResultadoFinal.entregaPaciente,
          'presionArt':$localStorage.ResultadoFinal.presionArterial,
          'pulsoReg' : $localStorage.ResultadoFinal.pulso,
          'respiracionReg' : $localStorage.ResultadoFinal.respiracion,
          'estado' :"Finalizado",
          'complicacionesReg' : $localStorage.ResultadoFinal.complicacion,
          'idPaciente' : $scope.Paciente.idPaciente,
          'TAPHPresente':$localStorage.ResultadoFinal.TAPHPresente,
          'TPAPHPresente':$localStorage.ResultadoFinal.TPAPHPresente,
          'otroPersonal':$localStorage.ResultadoFinal.otroPersonalPresente,
          'nombreotroPersonal':$localStorage.ResultadoFinal.nombreotroPersonal,
          'protocolo':$localStorage.ResultadoFinal.protocolo,
          'idAcompanante': $localStorage.Paciente.idAcompanante
        };
        $scope.AntecedentesE = $localStorage.ExamenFisicoAPH
        var AntecedentesD = $localStorage.ExamenFisicoAPH.Antecedentes.Derecha;
        var AntecedentesI = $localStorage.ExamenFisicoAPH.Antecedentes.Izquierda;
        $scope.AntecedentesTrue = [];

        for (var i = 0; i < AntecedentesD.length; i++) {
          if (AntecedentesD[i].si === true) {
            $scope.AntecedentesTrue.push(AntecedentesD[i]);
          }
        }
        for (var i = 0; i < AntecedentesI.length; i++) {
          if (AntecedentesI[i].si === true) {
            $scope.AntecedentesTrue.push(AntecedentesI[i]);
          }
        }

        $scope.ViaRFinal = $localStorage.ResultadoFinal.controlMedico;
        $scope.Piel = $localStorage.ExamenFisicoAPH.Piel;
        RegistrarReporte.EliminarTipoEvento($scope.idReporteInicial)
        .then(function(){
          RegistrarReporte.GuardarTipoEventoReporteInicial(IDESTipoEvento,$scope.idReporteInicial)
        })
        .then(function(){
          return RegistrarReporte.GuardarExamenFisico(objExamenFisico)
        })
        .then(function (ultimoregistroEF) {
          $scope.UltimoExamenF = ultimoregistroEF;
          return RegistrarReporte.RegistrarHistoriaClinicaAPH(ultimoregistroEF,objParametrosAPH);
        })
        .then(function(ultimoAPH){
          $scope.ultimoRegistroAPH = ultimoAPH;
          RegistrarReporte.RegistrarDetalleMotivoConsulta($scope.ultimoRegistroAPH,urg);
        })
        .then(function(){
          RegistrarReporte.RegistrarAntecedentesAPH($scope.AntecedentesTrue,$scope.ultimoRegistroAPH);
        })
        .then(function(){
          RegistrarReporte.RegistrarViaComunicacion($scope.ViaRFinal,$scope.ultimoRegistroAPH);
        })
        .then(function(){
          RegistrarReporte.RegistrarPiel($scope.UltimoExamenF,$scope.Piel);
        })
        .then(function(){
          RegistrarReporte.RegistrarTratamiento($scope.ultimoRegistroAPH,TratamientoAvanzado,TratamientoBasico,tratamientoBasicoOxigeno,tratamientoAvanzadoDextrosa)
        })
        .then(function(){
          return RegistrarReporte.RegistrarMedicamento($scope.Medicamento,$scope.ultimoRegistroAPH);
        })
        .then(function(){
          return RegistrarReporte.RegistrarLocalizacionLesiones($scope.Lesiones,$scope.ultimoRegistroAPH);
        })
        .then(function(){
          return RegistrarReporte.RegistrarCuidadosAntesArribo($scope.Cuidados,$scope.ultimoRegistroAPH);
        })
        .then(function(){
          return RegistrarReporte.RegistrarTestigos($scope.TestigosEnviar,$scope.ultimoRegistroAPH);
        })
        .then(function(){
          return RegistrarReporte.RegistrarNovedadesReporteInicial($localStorage.ReporteInicial.idReporteInicial,$scope.novedades);
        })
        .then(function(){
          return RegistrarReporte.consultarAllAutorizacion($scope.ultimoRegistroAPH,$localStorage.Paciente.documento)
        })
        .then(function(){
          return RegistrarReporte.FinalizarReporteInicial($localStorage.ReporteInicial.idReporteInicial)
        })
        .then(function(msm){
          if (msm == true) {
            swal({
              title: "Reporte APH almacenado con exito!",
              text: "El reporte APH de la emergencia ha sigo guardado satisfactoriamente",
              type :"success"
            },function(){
              localStorage.clear();
              $http.post(url +"ReporteAPH/ctrlReporteAPH/Reset", {'request':'ajax'}).success(function(data) {
                location.href = url + 'ReporteAPH/ctrlIndex';
              });
            })

          }else{
          sweetAlert("Error al guardar el reporte.", "Lo sentimos, ha ocurrido un error al momento de almacenar el reporte, intenta más tarde.", "error");
          }
        })
        .catch(function(msm){
          sweetAlert("Error al guardar el reporte.", "Lo sentimos, ha ocurrido un error al momento de almacenar el reporte, intenta más tarde.", "error");
        })
      }


    }

  })

})();
