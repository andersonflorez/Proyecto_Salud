(function(){
  'use strict';

  app.controller('CtrlMotivoConsulta',function($scope, $http,  $localStorage){

    $scope.UrgenciaTraumatica = [];
    $scope.UrgenciaMedica = [];
    $scope.TipoAseguramiento = [];
    $scope.AfectadoAccidente = [];
    $localStorage.Urgencias = $localStorage.Urgencias || [];

    /*************************************************************/
    /********************Une los local storage********************/
    /*************************************************************/
    //para local storage  de tipo aseguramiento
    $scope.Accidente = $localStorage.Accidente || {
      TipoAseguramiento:'',
      AfectadoAccidente:''
    };


    $scope.Urgencias = $localStorage.Urgencias || [];

    //para local storage  de tipo aseguramiento
    $scope.Aseguramiento = $localStorage.Aseguramiento || {
      id:'',
      otroAseguramiento:''
    };

    //para local storage  de afectado
    $scope.Afectado = $localStorage.Afectado || {
      id:'',
      placa:'',
      codigoAseguradora:'',
      numeroPoliza:''
    };



    $scope.ListadoMotivo = function(){
      $http.post(url + 'ReporteAPH/ctrlMotivoConsulta/ListarMotivoConsulta')
      .success(function(lista){
        $scope.UrgenciaM = "urgencia medica";
        $scope.UrgenciaMTil = "urgencia médica";
        $scope.UrgenciaT = "urgencia traumatica";
        $scope.UrgenciaTTil = "urgencia traumática";
        for (var i = 0; i < lista.length; i++) {
          if (lista[i].TipoMotivoConsulta.toUpperCase() == $scope.UrgenciaM.toUpperCase() || lista[i].TipoMotivoConsulta.toUpperCase() == $scope.UrgenciaMTil.toUpperCase() ) {
            $scope.UrgenciaMedica.push(lista[i]);
          }else if (lista[i].TipoMotivoConsulta.toUpperCase() == $scope.UrgenciaT.toUpperCase() || lista[i].TipoMotivoConsulta.toUpperCase() == $scope.UrgenciaTTil.toUpperCase()) {
            $scope.UrgenciaTraumatica.push(lista[i]);
          }
        }
        //console.log($scope.UrgenciaTraumatica)
      })
      .error(function(error){
        console.log(error);
      });
    };
    $scope.GuardarUrgencias = function(){
      var consulta = $localStorage.Afectado;
      if ($scope.Aseguramiento.id == "" && $scope.Aseguramiento.otroAseguramiento == "") {
        $(".tipoAseguramientoCheck").addClass("checkTipoEvento");
        Notificate({
          tipo: 'error',
          titulo: 'Error!',
          descripcion: 'Es necesario especificar el tipo aseguramiento.',
          duracion: 5
        });
      }else if (consulta != null) {
        if (consulta.id == "") {
          if(consulta.placa != "" && consulta.codigoAseguradora != "" && consulta.numeroPoliza != ""){
           $(".validacion").addClass("checkTipoEvento");
           Notificate({
             tipo: 'error',
             titulo: 'Error!',
             descripcion: 'Es necesario seleccionar un afectado.',
             duracion: 5
           });
         }else{
           $(".tipoAseguramientoCheck").removeClass("checkTipoEvento");
           window.location = url + 'ReporteAPH/CtrlAntecedentesPaciente';
         }
       }else if (consulta.id != ""){
         if (consulta.placa == "" || consulta.codigoAseguradora == "" || consulta.numeroPoliza == "") {
           $(".txtPlaca").addClass("checkTipoEvento");
           $(".txtCodigoAseguradora").addClass("checkTipoEvento");
           $(".txtNumeroPoliza").addClass("checkTipoEvento");
           Notificate({
             tipo: 'error',
             titulo: 'Error!',
             descripcion: 'Es necesario especificar los datos de la aseguradora.',
             duracion: 5
           });
         }else{
           $(".tipoAseguramientoCheck").removeClass("checkTipoEvento");
           validarBarraProgreso('ctrlAntecedentesPaciente');

         }
       }else{
        $(".tipoAseguramientoCheck").removeClass("checkTipoEvento");
          validarBarraProgreso('ctrlAntecedentesPaciente');
      }
      }else {
        $(".tipoAseguramientoCheck").removeClass("checkTipoEvento");
          validarBarraProgreso('ctrlAntecedentesPaciente');
      }
      $localStorage.Urgencias = $scope.Urgencias;
      $localStorage.Accidente = {'TipoAseguramiento': $scope.Aseguramiento,'AfectadoAccidente': $scope.Afectado};
    };
    $scope.GuardarDescripcion = function(){
      if ($scope.Formulario.otro == "") {
        $localStorage.Urgencias = $scope.Urgencias;
      }else{
        $localStorage.Urgencias = $scope.Formulario.otro;
      }
    };

    //==========================================================================
    //muestra el listado de tipo aseguramiento
    /*$scope.ValidarSeleccionAseguramiento = funcion(){
    localStorage.removeItem("ReporteAPH-Aseguramiento");
  }*/
  $scope.ValidarSeleccionAseguramiento = function(){
    if ($scope.Aseguramiento.id == "" && $scope.Aseguramiento.otroAseguramiento == "") {
      $(".tipoAseguramientoCheck").addClass("checkTipoEvento");
    }else{
      $(".tipoAseguramientoCheck").removeClass("checkTipoEvento");
    }

    $scope.Aseguramiento.id = "";
    $localStorage.Aseguramiento = $scope.Aseguramiento;
    console.log($localStorage.Aseguramiento);
  };

  $scope.ValidarChange = function(){
    var consulta = $localStorage.Afectado;
    if (consulta) {
      if (consulta.id != "") {
        if (consulta.placa == "") {
              $(".txtPlaca").addClass("checkTipoEvento");
        }else{
            $(".txtPlaca").removeClass("checkTipoEvento");
        }

        if (consulta.codigoAseguradora == "") {
            $(".txtCodigoAseguradora").addClass("checkTipoEvento");
        }else{
            $(".txtCodigoAseguradora").removeClass("checkTipoEvento");
        }

        if (consulta.numeroPoliza == "") {
            $(".txtNumeroPoliza").addClass("checkTipoEvento");
        }else{
          $(".txtNumeroPoliza").removeClass("checkTipoEvento");
        }
    }else{
    }
    }
  };

  $scope.ListadoTipoAseguramiento = function(){
    $http.post(url + 'ReporteAPH/ctrlMotivoConsulta/ListarTipoAseguramiento')
    .success(function(respuesta){
      for (var i = 0; i < respuesta.length; i++) {
        $scope.TipoAseguramiento.push(respuesta[i]);
      }
    })
    .error(function(error){
      console.log(error);
    });
  };

  $scope.cancelarTransito = function(){
$scope.Afectado.placa = "";
$scope.Afectado.codigoAseguradora = "";
$scope.Afectado.numeroPoliza = "";
$scope.Afectado.id = "";
  };
  //guarda en el local storage
  $scope.GuardarTipoAseguramiento = function(){
    $scope.Aseguramiento.otroAseguramiento = "";
    $localStorage.Aseguramiento = $scope.Aseguramiento;
    if ($localStorage.Aseguramiento == "") {
      $(".tipoAseguramientoCheck").addClass("checkTipoEvento");
    }else{
      $(".tipoAseguramientoCheck").removeClass("checkTipoEvento");
    }
  };

  $scope.ChageValidacion = function(){
    $(".validacion").removeClass("checkTipoEvento");
  }

  //==========================================================================
  //muestra el listado de tipo aseguramiento
  $scope.ListarAfectado = function(){
    $http.post(url + 'ReporteAPH/ctrlMotivoConsulta/ListarAfectado')
    .success(function(respuesta){

      for (var i = 0; i < respuesta.length; i++) {
        $scope.AfectadoAccidente.push(respuesta[i]);
      }

    })
    .error(function(error){
      console.log(error);
    });
  };
  //guarda en el local storage
  $scope.GuardarAfectado = function(){
        $localStorage.Afectado = $scope.Afectado;
  };

  $scope.ValidarAccidenteTransito = function(){

  }

});
})();
