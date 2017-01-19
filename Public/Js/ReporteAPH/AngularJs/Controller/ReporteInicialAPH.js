(function(){
  'use strict';
  app.controller('ctrlReporteInicialAPH' , function ($scope, $http,  $localStorage) {
    $localStorage.ReporteInicial=$localStorage.ReporteInicial || {'ubicacion':'','idReporteInicial':'','IDESTipoEvento':'','PersonalQueAtiende':'','informacion':'','Triage':'','idDespacho':'','idAmbulancia':''};
    $scope.HoraConfirmacion = $localStorage.HoraConfirmacion || "";
    if ($scope.HoraConfirmacion != "") {
      $(".FlechaDerechaMapa").show();
    }
    $scope.ListaReporteI=[];
    $scope.ListaDespacho =[];
    $scope.Nombres=[];
    $scope.IdsTipoEvento = [];
    $scope.PersonalQueAtiende  = $localStorage.ReporteInicial.PersonalQueAtiende || [];
      $scope.idReporteInicial = $localStorage.ReporteInicial.idReporteInicial || [];
      if ($scope.idReporteInicial == "") {
        location.href= url +"ReporteAPH/ctrlIndex";
      }else{

          $scope.idreporteI = $localStorage.ReporteInicial.idReporteInicial;
      }

      $scope.FuncionConsultarReporteI = function(){

        $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/ConsultarReporteInicial',{idReporteInicial:$scope.idreporteI})
        .success(function(reportein){
          if (reportein == "null") {
            Notificate({
              tipo: 'error',
              titulo: 'Error!',
              descripcion: 'No hay registros para visualizar.',
              duracion: 5
            });
          }else{
            $scope.ListaReporteI = {
              horallamada: reportein[0].fechaHoraAproximadaEmergencia == null ? 'No aplica': reportein[0].fechaHoraAproximadaEmergencia,
              horaenvio : reportein[0].fechaHoraEnvioReporteInicial == null ? 'No aplica' : reportein[0].fechaHoraEnvioReporteInicial,
              responsableReporteInicial : reportein[0].ReceptorInicial == null ? 'No aplica' : reportein[0].ReceptorInicial,
              numeroheridos : reportein[0].numeroLesionados == null ? 'No aplica': reportein[0].numeroLesionados,
              puntoreferencia:  reportein[0].puntoReferencia == null ? 'No aplica' : reportein[0].puntoReferencia,
              direccion: reportein[0].ubicacionIncidente == null ? 'No aplica' : reportein[0].ubicacionIncidente,
              usuarioExterno: reportein[0].UsuarioExterno == null ? 'No aplica' : reportein[0].UsuarioExterno,
              telefono:reportein[0].telefonousuarioExterno == null ? 'No aplica' : reportein[0].telefonousuarioExterno,
              tipoevento:reportein[0].descripcionTipoEvento == null ? 'No aplica' : reportein[0].descripcionTipoEvento,
              descripcion : reportein[0].informacionInicial == null ? 'No aplica' : reportein[0].informacionInicial+'.'
            };
            $scope.FuncionConsultarDespacho();
            $scope.ReporteInicial = {'direccion':$scope.ListaReporteI.direccion,'puntoreferencia':$scope.ListaReporteI.puntoreferencia,'descripcionEmergencia':$scope.ListaReporteI.descripcion,'responsableReporteInicial':$scope.ListaReporteI.responsableReporteInicial,'numeroheridos':$scope.ListaReporteI.numeroheridos};
            $localStorage.ReporteInicial.informacion =$scope.ReporteInicial;
            var TipoEvento = $scope.ListaReporteI.tipoevento;
            var ides = reportein[0].idTipoEvento.split(',');
            for (var i = 0; i < ides.length; i++) {
              $scope.IdsTipoEvento[i] = ides[i];
            }
            $localStorage.ReporteInicial.IDESTipoEvento =$scope.IdsTipoEvento;

          }
        })
        .error(function(err){
         alerta('error',null,err);
       });
     };
      $scope.FuncionConsultarDespacho = function(){
        $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/ConsultarDespacho',{idDespacho:$localStorage.ReporteInicial.idDespacho})
        .success(function(despacho){
          if (despacho == "null") {
            Notificate({
              tipo: 'error',
              titulo: 'Error!',
              descripcion: 'No hay registros para visualizar.',
              duracion: 5
            });
          }else{

              var value = despacho[0].Nombres;
              var nombres = value.split(',');
              for (var i = 0; i < nombres.length; i++) {
                $scope.Nombres.push(nombres[i]);
              }
                $scope.ListaDespacho = {
                  responsable: despacho[0].nombreDespachador == null ? 'No aplica' : despacho[0].nombreDespachador,
                  codAmbulancia : despacho[0].idAmbulancia == null ? 'No aplica' : despacho[0].idAmbulancia,
                  fechaDespacho: despacho[0].fechaHoraDespacho == null ? 'No aplica' : despacho[0].fechaHoraDespacho
                }
                $scope.idDespacho = despacho[0].idDespacho;
                $scope.idAmbulancia = despacho[0].idAmbulancia;
                };
                $localStorage.ReporteInicial.idAsignacionPersonal = despacho[0].idAsignacionPersonal;
                $scope.PersonalQueAtiende = $scope.Nombres;
                $localStorage.ReporteInicial.PersonalQueAtiende =$scope.PersonalQueAtiende;
                $localStorage.ReporteInicial.idDespacho =$scope.idDespacho;
                $localStorage.ReporteInicial.idAmbulancia =$scope.idAmbulancia;
        })
        .error(function(err){
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'No hay registros para visualizar.',
            duracion: 5
          });
       });
     };
   });
 })();
