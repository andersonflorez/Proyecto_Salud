'use strict';

(function () {

  var app = angular.module('ReporteAPH' , []);

  app.controller('ctrlTipoTratamiento' , function ($scope , $http) {

    $scope.listaTipoTratamiento = [];

    /**
    * Listar todos los tipos de tratamiento
    */
    $scope.Listar = function() {

      $http.get(url + 'ReporteAPH/ctrlConfiguracion/ListarTipoTratamiento')
      .success(function(res){
        $scope.listaTipoTratamiento = res;
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    }


    /**
    * Registrar un tipo de tratamiento
    */
    $scope.Registrar = function (formData) {

      $http.post(url + 'ReporteAPH/ctrlConfiguracion/RegistrarTipotraTamiento', formData)
      .success(function(res){
        $scope.TT.txtTratamiento = '';
        $scope.TT.txtCategoriaI = '';
        $scope.TT.txtCategoriaT = '';

        var tipo = (res == 'Registro Exitoso') ? 'exito' : 'error';
        alerta(tipo,null,res);
        $scope.Listar();
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    }

    /**
    * Modificar un tipo de tratamiento
    */
    $scope.Modificar = function (id) {
      var obj = $scope.listaTipoTratamiento[id];
      delete obj.$$hashKey;
      $http.post(url + 'ReporteAPH/ctrlConfiguracion/ModificarTipoTratamiento', obj)
      .success(function(res){
        var tipo = (res == 'Modificación Exitosa') ? 'exito' : 'error';
        alerta(tipo,null,res);
        $scope.Listar();
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    }

    /**
    * Eliminar un tipo de tratamiento
    */
    $scope.Eliminar = function (id) {
      $http.post(url + 'ReporteAPH/ctrlConfiguracion/EliminarTipoTratamiento', {'txtId': id})
      .success(function(res){
        var tipo = (res == 'Tratamiento eliminado') ? 'exito' : 'error';
        alerta(tipo,null,res);
        $scope.Listar();
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    }

    // Carga de datos inicial
    $scope.Listar();

  });


})();
