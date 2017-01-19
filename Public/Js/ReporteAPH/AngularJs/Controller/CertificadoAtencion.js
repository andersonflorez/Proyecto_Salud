(function () {
  'use strict';

  app.controller('ctrlCertificadoAtencion' , function ($scope , $http) {
    $scope.listaCertificadosAtencion = [];

    /**
    * Listar todos los certificados de atención
    */

    $scope.Listar = function() {

      $http.get(url + 'ReporteAPH/ctrlConfiguracion/ListarCertificadosAtencion')
      .success(function(res){
        $scope.listaCertificadosAtencion = res;
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    };


    /**
    * Registrar un certificado de atención
    */
    $scope.Registrar = function (formData) {

      $http.post(url + 'ReporteAPH/ctrlConfiguracion/RegistrarCertificadosAtencion',formData)
      .success(function(res){
        $scope.CA.txtRegCertificadoAtencion = '';
        var tipo = (res == 'Registro Exitoso') ? 'exito' : 'error';
        alerta(tipo,null,res);
        $scope.Listar();
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    };

    /**
    * Modificar un certificado de atención
    */
    $scope.Modificar = function (id) {
      var obj = $scope.listaCertificadosAtencion[id];
      $http.post(url + 'ReporteAPH/ctrlConfiguracion/ModificarCertificadosAtencion', {
        'txtId': obj.idCertificadoAtencion,
        'txtRegCertificadoAtencion' : obj.descripcionCertificadoAtencion
      })
      .success(function(res){
        var tipo = (res == 'Modificación Exitosa') ? 'exito' : 'error';
        alerta(tipo,null,res);
        $scope.Listar();
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    };

    /**
    * Eliminar un certificado de atención
    */
    $scope.Eliminar = function (id) {
      $http.post(url + 'ReporteAPH/ctrlConfiguracion/EliminarCertificadosAtencion', {
        'txtId': id
      })
      .success(function(res){
        var tipo = (res == 'Certificado eliminado') ? 'exito' : 'error';
        alerta(tipo,null,res);
        $scope.Listar();
      })
      .error(function (res , status) {
        alerta('error',null,res);
      });

    };

    // Carga de datos inicial
    $scope.Listar();

  });


})();
