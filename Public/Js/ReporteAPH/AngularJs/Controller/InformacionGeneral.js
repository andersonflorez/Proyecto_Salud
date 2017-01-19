(function(){
  'use strict';

  app.controller('CtrlInformacionGeneral', function ($scope, $http,  $localStorage){
    $scope.ReporteInicial = $localStorage.ReporteInicial || [];
    if ($scope.ReporteInicial == "") {
      window.location = url + 'ReporteAPH/ctrlIndex';
    }else{
      whichWorkMode.then(function (esModoConsulta) {
        $scope.FlechaIzquierdaInformacionGeneral = function(){
          if (esModoConsulta) {
              window.location = url + 'ReporteAPH/ctrlIndex';
          }else{
            window.location = url + 'ReporteAPH/ctrlReporteInicialAPH';
          }
        }

      }, function (err) {
        alert('No se pudó obtener el modo de trabajo.');
      });
      $scope.tiempos = $localStorage.ReporteInicial.Tiempos;
      $scope.ReporteInicial = $localStorage.ReporteInicial.informacion  || [];
      $scope.PersonalQueAtiende = $localStorage.ReporteInicial.PersonalQueAtiende || [];
      $scope.apoyo1  =  $scope.PersonalQueAtiende[0];
      $scope.apoyo2 =  $scope.PersonalQueAtiende[1];
      $scope.apoyo3  =  $scope.PersonalQueAtiende[2];
    }
  });

})();

$(document).ready(function(){
  // cargarMisgasPan("ctrlInformacionGeneral");
});
