(function(){
  'use strict';
  app.controller('ctrlAntecedentesPaciente' , function ($scope, $http,  $localStorage) {
    if ($localStorage.ExamenFisicoAPH) {
      if ($localStorage.ExamenFisicoAPH.hasOwnProperty('horaExamenFisico')) {
        $scope.horaExamenFisico = $localStorage.ExamenFisicoAPH.horaExamenFisico || "";
      }
    }
    $("#horaUltimaIngesta").timepicker({
      timeFormat:'H:i',step:1
    });
    var myDatepicker = $('#fechaUltimaIngesta').datepicker().data('datepicker');
    $("#fechaUltimaIngesta").datepicker({
      language: 'es',
      maxDate: new Date(),
      position:"bottom left",
      onSelect:function(formattedDate){
        myDatepicker.hide();
      }
    });
    $scope.sonFechasVacias = true;
    $scope.disabledOcular=true;
    $scope.disabledVerbal=true;
    $scope.disabledMotor=true;
    $localStorage.ExamenFisicoAPH = $localStorage.ExamenFisicoAPH  ||  {'TablaGlasgow':'','Respiracion':'','Pulso':'','PresionArterial':'','Conciencia':'','Pupilas':'','Piel':'','EstadoHemodinamico':'','EspecificacionExamen':'','Antecedentes':''};
    $scope.CalculoGlasgows  = 0;
    $scope.Ocular = 0;
    $scope.Verbal = 0;
    $scope.Motor = 0;
    $scope.form={
      especificacion:''
    };
    $scope.listaD = $localStorage.ExamenFisicoAPH.Antecedentes ||  ConsultaInicial();
    $scope.listaDerecha= $scope.listaD.Derecha || [];
    $scope.listaIzquierda= $scope.listaD.Izquierda || [];
    $scope.Ante = {'Derecha':$scope.listaDerecha,'Izquierda':$scope.listaIzquierda};
    $scope.listaD=[];
    $scope.listaI=[];
    $scope.Respiracion =$localStorage.ExamenFisicoAPH.Respiracion || {
      'valor':'',
      'estado':'',
      'spo':'',
      'horaUltimaIngesta':'',
      'fechaUltimaIngesta':''
    };
    $scope.Pulso =$localStorage.ExamenFisicoAPH.Pulso || {
      'valor':'',
      'estado':''
    };
    $scope.PresionArterial=$localStorage.ExamenFisicoAPH.PresionArterial || {
      'sistolica':'',
      'diastolica':'',
      'glucometria':''
    };
    $scope.Conciencia = $localStorage.ExamenFisicoAPH.Conciencia || {
      'estado':'',
      'glasgow':''
    };

    $scope.pupilas =  $localStorage.ExamenFisicoAPH.Pupilas || {
      derecha : '',
      izquierda: '',
      izquierdaDilatacion:'',
      derechaDilatacion:''
    };

    $scope.TablaGlasgow = $localStorage.ExamenFisicoAPH.TablaGlasgow || {
      ocular:'',
      verbal:'',
      motor:'',
      descripcionOcular:'',
      descripcionVerbal:'',
      descripcionMotor:''
    };
    if ($scope.TablaGlasgow.ocular=="No Evaluable") {
      $scope.disabledOcular=false;
    }else{
      $scope.disabledOcular=true;
    }
    if ($scope.TablaGlasgow.verbal=="No Evaluable") {
      $scope.disabledVerbal=false;
    } else{
      $scope.disabledVerbal=true;
    }
    if ($scope.TablaGlasgow.motor=="No Evaluable") {
      $scope.disabledMotor=false;
    }else{
      $scope.disabledMotor=true;
    }

    $scope.Piel = $localStorage.ExamenFisicoAPH.Piel || [];
    $scope.EstadoHemodinamico = $localStorage.ExamenFisicoAPH.EstadoHemodinamico || "";
    $scope.EspecificacionExamen=$localStorage.ExamenFisicoAPH.EspecificacionExamen || "";
    function ConsultaInicial() {
      $http.post(url + 'ReporteAPH/ctrlTipoAntecedente/ListarTipoAntecedente')
      .success(function(listado){
        var chunk = listado.chunk(2);
        $scope.listaD = chunk[0];
        $scope.listaI = chunk[1];
        for (var i = 0; i < $scope.listaI.length; i++) {
          var obj = {

            'idTipoAntecedente':$scope.listaI[i].idTipoAntecedente,
            'descripcion' : $scope.listaI[i].descripcion,
            'especificacion':$scope.listaI[i].especificacion,
            'nomenclatura':$scope.listaI[i].nomenclatura,
            'si':false
          };
          $scope.listaIzquierda.push(obj);
        }

        for (var i = 0; i < $scope.listaD.length; i++) {
          var obj = {

            'idTipoAntecedente':$scope.listaD[i].idTipoAntecedente,
            'descripcion' : $scope.listaD[i].descripcion,
            'especificacion':$scope.form.especificacion,
            'nomenclatura':$scope.listaD[i].nomenclatura,
            'si':false
          };
          $scope.listaDerecha.push(obj);
        }

      })
      .error(function(error){

      });
      $scope.AntecedentesCompletos = {'Derecha':$scope.listaDerecha,'Izquierda':$scope.listaIzquierda,'UltimaHoraIngesta':$scope.form.ultimahora};
      return   $scope.AntecedentesCompletos ;

    }
    $scope.VaciarInputTrue = function(lado,id){
      if (lado=="derecha") {
        for (var i = 0; i < $scope.listaDerecha.length; i++) {
          if($scope.listaDerecha[i].idTipoAntecedente == id){
            $scope.listaDerecha[i].especificacion = "";
          }
        }
      }else{
        for (var i = 0; i < $scope.listaIzquierda.length; i++) {
          if($scope.listaIzquierda[i].idTipoAntecedente == id){
            $scope.listaIzquierda[i].especificacion = "";
          }
        }
      }
    };


    $scope.CalcularGlasgow = function(valor,categoria){
      if ($scope.TablaGlasgow.ocular=="No Evaluable") {
        $scope.disabledOcular=false;
      }else{
        $scope.disabledOcular=true;
        $scope.TablaGlasgow.descripcionOcular = "";
      }
      if ($scope.TablaGlasgow.verbal=="No Evaluable") {
        $scope.disabledVerbal=false;
      }else{
        $scope.disabledVerbal=true;
        $scope.TablaGlasgow.descripcionVerbal = "";
      }
      if ($scope.TablaGlasgow.motor=="No Evaluable") {
        $scope.disabledMotor=false;
      }else{
        $scope.disabledMotor=true;
        $scope.TablaGlasgow.descripcionMotor = "";
      }
      if (categoria == "ocular") {
        $scope.Ocular = valor;
      }else if (categoria == "verbal") {
        $scope.Verbal = valor;
      }else if (categoria == "motor") {
        $scope.Motor = valor;
      }else{
        $scope.Ocular = 0;
        $scope.Verbal = 0;
        $scope.Motor = 0;
      }
      $scope.Conciencia.glasgow = $scope.Ocular + $scope.Verbal + $scope.Motor;
    };
    $scope.validarFechasUltimaIngesta = function(){
      $scope.Respiracion.fechaUltimaIngesta = $("#fechaUltimaIngesta").val();
      if ($scope.Respiracion.horaUltimaIngesta != "" && $scope.Respiracion.fechaUltimaIngesta == "") {
        $scope.sonFechasVacias =false;
        $("#fechaUltimaIngesta").addClass("checkTipoEvento");
        $("#horaUltimaIngesta").removeClass("checkTipoEvento");
      }else if ($scope.Respiracion.horaUltimaIngesta == "" && $scope.Respiracion.fechaUltimaIngesta != "") {
        $("#fechaUltimaIngesta").removeClass("checkTipoEvento");
        $("#horaUltimaIngesta").addClass("checkTipoEvento");
        $scope.sonFechasVacias =false;
      }else if ($scope.Respiracion.horaUltimaIngesta != "" && $scope.Respiracion.fechaUltimaIngesta != "") {
        $("#horaUltimaIngesta").removeClass("checkTipoEvento");
        $("#fechaUltimaIngesta").removeClass("checkTipoEvento");
        $scope.sonFechasVacias =true;
      }
    }
    $scope.GuardarAntecedentes = function(opcion){
      if (opcion === "derecha") {


        if ($scope.Piel == "" && $scope.EstadoHemodinamico == "" && ($scope.Respiracion.horaUltimaIngesta == "" || $scope.Respiracion.fechaUltimaIngesta == "") && $scope.sonFechasVacias == false) {
          $(".EstadoHemodinamicoAntecedentes").addClass("checkTipoEvento");
          $("#fechaUltimaIngesta").addClass("checkTipoEvento");
          $("#fechaUltimaIngesta").addClass("checkTipoEvento");
          $(".checkPielAntecedentes").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario completar los campos obligatorios.',
            duracion: 5
          });
        }else if ($scope.Piel  == "") {
          $(".EstadoHemodinamicoAntecedentes").removeClass("checkTipoEvento");
          $(".checkPielAntecedentes").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la piel del paciente.',
            duracion: 3
          });
        }else if ($scope.EstadoHemodinamico == "") {
          $(".checkPielAntecedentes").removeClass("checkTipoEvento");
          $(".EstadoHemodinamicoAntecedentes").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el estado hemodinámico del paciente.',
            duracion: 3
          });
        }else if (($scope.Respiracion.horaUltimaIngesta == "" || $scope.Respiracion.fechaUltimaIngesta == "") && $scope.sonFechasVacias == false) {
          $("#horaUltimaIngesta").addClass("horaUltimaIngesta");
          $("#fechaUltimaIngesta").addClass("horaUltimaIngesta");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar la fecha y la hora de la última ingesta del paciente.',
            duracion: 3
          });
        }
        else{
          $(".checkPielAntecedentes").removeClass("checkTipoEvento");
          $(".EstadoHemodinamicoAntecedentes").removeClass("checkTipoEvento");
          $localStorage.ExamenFisicoAPH = {'TablaGlasgow':$scope.TablaGlasgow,'Respiracion':$scope.Respiracion,'Pulso':$scope.Pulso,'PresionArterial':$scope.PresionArterial,'Conciencia':$scope.Conciencia,'Pupilas':$scope.pupilas,'Piel':$scope.Piel,'EstadoHemodinamico':$scope.EstadoHemodinamico,'EspecificacionExamen':$scope.EspecificacionExamen,'Antecedentes':$scope.Ante};
           validarBarraProgreso('ctrlLocalizacionLesiones');
        }
      }else{
        $localStorage.ExamenFisicoAPH = {'TablaGlasgow':$scope.TablaGlasgow,'Respiracion':$scope.Respiracion,'Pulso':$scope.Pulso,'PresionArterial':$scope.PresionArterial,'Conciencia':$scope.Conciencia,'Pupilas':$scope.pupilas,'Piel':$scope.Piel,'EstadoHemodinamico':$scope.EstadoHemodinamico,'EspecificacionExamen':$scope.EspecificacionExamen,'Antecedentes':$scope.Ante};
        window.location = url + 'ReporteAPH/ctrlMotivoConsulta';
      }
    };
    $scope.BorrarClaseEstado = function(){
      $(".EstadoHemodinamicoAntecedentes").removeClass("checkTipoEvento");
    };
    $scope.BorrarPiel = function(){
      if ($scope.Piel == "") {
        $(".checkPielAntecedentes").addClass("checkTipoEvento");
      }else{
        $(".checkPielAntecedentes").removeClass("checkTipoEvento");
      }

    };

  });
})();
