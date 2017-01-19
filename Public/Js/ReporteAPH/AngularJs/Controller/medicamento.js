(function(){
  'use strict';
  app.controller('CtrlMedicamento',function($scope, $http,  $localStorage){
    $scope.medicamento = [];
    $scope.NewMedicamento = [];

    $scope.dosis = $localStorage.dosis || {
      '':''
    };
    $scope.hora = $localStorage.hora || {
      hora:''
    };
    $scope.viaAdministracion = $localStorage.viaAdministracion ||{
      viaAdministracion : ''
    };
    $scope.cantidad = $localStorage.cantidad || {
      cantidad : ''
    };


    /*$scope.ListarTipoTratamiento = function(){
      $http.post(url + 'ReporteAPH/ctrlMedicamento/ListarMedicamento')
      .success(function(lista){
        for (var i = 0; i < lista.length; i++) {
          $scope.medicamento.push(lista[i]);

        }
        console.log(lista);
      })
      .error(function(error){
        alert();
        console.log(error);
      });
    };*/

    $scope.medicamentoUsNat = function(id_){

      var dosis = angular.element(document.getElementById('dosis'+id_)).val();
      var hora = angular.element(document.getElementById('hora'+id_)).val();
      var viaAdministracion = angular.element(document.getElementById('viaad'+id_)).val();
      var cantidad = angular.element(document.getElementById('cantidad'+id_)).val();
/*angular.element(document.getElementById('mensaje')).append('<script>medicamentoUsNat('+id_+')</script>');
angular.element(document.getElementById('mensaje')).html("");*/
/*$scope.medicamento.id_ = $localStorage.medicamento.id_ || {
  dosis:dosis,
  hora:hora,
  viaAdministracion:viaAdministracion,
  cantidad:cantidad
}*/

$localStorage.medicamento.id_ = $scope.medicamento.di_;
    }


  });
})();
