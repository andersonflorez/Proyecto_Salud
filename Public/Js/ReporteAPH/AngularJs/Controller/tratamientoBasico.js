(function() {
  'use strict';
  app.controller('CtrlTratamientoB', function($scope, $http, $localStorage, $window) {
    $scope.tratamientoTipoA = [];
    $scope.tratamientoTipoB = [];
    $scope.tratamientoTipoC = [];
    $scope.tratamientoTipoD = [];
    $scope.tratamientoTipoO = [];
    $scope.tratamientoEspecial = [];

    $scope.tratamientoBasico = $localStorage.tratamientoBasico || {
      idTipoTratamiento: '',
      observacionTratamiento: '',
    };

    $scope.tratamientoBasicoOxigeno = $localStorage.tratamientoBasicoOxigeno || {
      idTipoTratamiento: '',
      descripcionOxigeno: ''
    }

    $scope.esta = function () {
      alert();
    };
    $scope.ListarTipoTratamiento = function() {
      $http({
        method: 'POST',
        url: url + 'ReporteAPH/ctrlTratamientoB/ListarTratamientoBasico',
        async: false
      })
      .success(function(lista) {

        for (var i = 0; i < lista.length; i++) {
          if (lista[i].categoriaItemTratamiento == "A") {
            $scope.tratamientoTipoA.push(lista[i]);
          } else if (lista[i].categoriaItemTratamiento == "B") {
            if (lista[i].Descripcion == "Oxigeno") {
              $scope.tratamientoEspecial.push(lista[i]);
            } else {
              $scope.tratamientoTipoB.push(lista[i]);
            }
          } else if (lista[i].categoriaItemTratamiento == "C") {
            $scope.tratamientoTipoC.push(lista[i]);
          } else if (lista[i].categoriaItemTratamiento == "D") {
            $scope.tratamientoTipoD.push(lista[i]);
          } else if (lista[i].categoriaItemTratamiento == "Otro") {
            $scope.tratamientoTipoO.push(lista[i]);
          }
        }
        ListarSolicitudesB();
      })
      .error(function(error) {
        Notificate({
          tipo: 'error',
          titulo: 'Error ',
          descripcion: 'Ocurrio algun problema al consultar los tipos de tratamientos',
          duracion: 4
        });
      });
    };

    $scope.ValidarSeleccionCampo = function() {
      var redireccion = false;
      if (angular.element(document.getElementById('tratamientoEOxigeno')).is(":checked")) {
        var descripcion = angular.element(document.getElementById('descripcionOxigeno')).val();
        if (descripcion == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Si selecciono un oxigeno se debe digitar un valor',
            duracion: 4
          });
          redireccion = false;
          var descripcion = angular.element(document.getElementById('descripcionOxigeno')).attr("style", "border-color: #E91E63;");
        } else {
          redireccion = true;
        }

      } else {
        redireccion = true;
      }

      if (!angular.element(document.getElementById('descripcionOxigeno')).val() == "" || !angular.element(document.getElementById('descripcionOxigeno')) == null) {
        if (!angular.element(document.getElementById('tratamientoEOxigeno')).is(":checked")) {

          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Si ingresaste un valor de oxigeno debes seleccionar oxigeno',
            duracion: 4
          });
          redireccion = false;
          angular.element(document.getElementById('lblTratamientoEOxigeno')).attr("style", "border: solid 1px #E91E63; !important;");
        } else {
          if (redireccion == false) {

          } else {
            redireccion = true;
          }
        }
      } else {
        if (redireccion == false) {

        } else {
          redireccion = true;
        }
      }

      if (redireccion == true) {
        validarBarraProgreso('ctrlTratamientoA');
      } else {

      }
    }

    $scope.limpiarSiNoChecked = function() {
      if (!angular.element(document.getElementById('tratamientoEOxigeno')).is(":checked")) {
        angular.element(document.getElementById('descripcionOxigeno')).val("");
      } else {}

    }

    $scope.validarNegativo = function(){

      if (!/^([0-9])*$/.test($("#descripcionOxigeno").val())){
        Notificate({
          tipo: 'error',
          titulo: 'Error ',
          descripcion: 'Solo números positivos, por defecto será el número 1',
          duracion: 4
        });
        $scope.tratamientoBasicoOxigeno.descripcionOxigeno = 1;
      }

    }


    $scope.validarChage = function() {
      if ($localStorage.tratamientoBasicoOxigeno != null) {
        if ($localStorage.tratamientoBasicoOxigeno.idTipoTratamiento != "") {
          if ($localStorage.tratamientoBasicoOxigeno.descripcionOxigeno != null) {
            angular.element(document.getElementById('descripcionOxigeno')).removeAttr("style");
          } else {
            angular.element(document.getElementById('descripcionOxigeno')).attr("style", "border: solid 1px #E91E63; !important;");
          }

        } else {

        }
      }else{

      }
    }

    $scope.validarChageCheck = function() {
      angular.element(document.getElementById('lblTratamientoEOxigeno')).removeAttr("style");
    }

    $scope.GuardarTratamiento = function() {
      $localStorage.tratamientoBasico = $scope.tratamientoBasico;
    };

    $scope.GuardarTratamientoOxigeno = function() {
      $localStorage.tratamientoBasicoOxigeno = $scope.tratamientoBasicoOxigeno;
    };

    $scope.abrirModalAutorizacion = function(id, nombre) {
      $("#cuadro_autorizacion").remove();
      $("body").append('<div class="" id="cuadro_autorizacion1"></div>');
      $http.post(url + 'ReporteAPH/ctrlTratamientoB/ValidarTipoAmbulancia')
      .success(function(lista) {
        if (lista != "") {
          if (lista[0].tipoAmbulancia == "TAM") {
            angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">REGISTRAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Registrar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="frmCont autentificacion" style="width:100%"><label for="txtUsuarioAutentificacion">Usuario: </label><div class="frmInput"><input class="input_data bloquear usuarioCheck" ng-blur="BorrarBordeusuario()" ng-model="formulario.usuario" type="text" name="txtUsuarioAutentificacion" id="usuarioMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Clave: </label><div class="frmInput"><input class="input_data bloquear passwordCheck" ng-blur="BorrarBordepass()" ng-model="formulario.pass" type="password" name="txtClaveAutentificacion" id="claveMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Descripcion: </label><div class="frmInput"><textarea rows="4" id="txtDescripcion" cols="10"></textarea></div></div></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="registrarAutorizacionMedicalizada(' + id + ')" >Registrar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
          } else if (lista[0].tipoAmbulancia == "TAB") {
            angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">SOLICITAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Solicitar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><b>Descripcion </b><br><br><textarea id="txtArea' + id + '" name="name" rows="8" cols="40"></textarea></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="tratamiento.solicitar_autorizacion(1,' + id + ',1020481343)" >Solicitar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
          }
        }else{
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'No te encuentras asignado a ninguna ambulancia',
            duracion: 4
          });
        }
      }).error(function(){
        Notificate({
          tipo: 'error',
          titulo: 'Error ',
          descripcion: 'No te encuentras asignado a ninguna ambulancia',
          duracion: 4
        });
      });
    };

    $scope.abrirModalAutorizacion1 = function(id, nombre) {
      var registro = $localStorage.tratamientoBasico.idTipoTratamiento;
      var estado = 0;
        for (var i = 0; i < registro.length; i++) {
                if (registro[i] == id) {
                  estado++;
                }
        };
      if (estado > 0) {
        $("#cuadro_autorizacion").remove();
        $("body").append('<div class="" id="cuadro_autorizacion1"></div>');
        $http.post(url + 'ReporteAPH/ctrlTratamientoB/ValidarTipoAmbulancia')
        .success(function(lista) {
          if (lista != "") {
            if (lista[0].tipoAmbulancia == "TAM") {
              angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">REGISTRAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Registrar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="frmCont autentificacion" style="width:100%"><label for="txtUsuarioAutentificacion">Usuario: </label><div class="frmInput"><input class="input_data bloquear usuarioCheck" ng-blur="BorrarBordeusuario()" ng-model="formulario.usuario" type="text" name="txtUsuarioAutentificacion" id="usuarioMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Clave: </label><div class="frmInput"><input class="input_data bloquear passwordCheck" ng-blur="BorrarBordepass()" ng-model="formulario.pass" type="password" name="txtClaveAutentificacion" id="claveMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Descripcion: </label><div class="frmInput"><textarea rows="4" id="txtDescripcion" cols="10"></textarea></div></div></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="registrarAutorizacionMedicalizada(' + id + ')" >Registrar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
            } else if (lista[0].tipoAmbulancia == "TAB") {
              angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">SOLICITAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Solicitar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><b>Descripcion </b><br><br><textarea id="txtArea' + id + '" name="name" rows="8" cols="40"></textarea></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="tratamiento.solicitar_autorizacion(1,' + id + ',1020481343)" >Solicitar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
            }
          }else{
            Notificate({
              tipo: 'error',
              titulo: 'Error ',
              descripcion: 'No te encuentras asignado a ninguna ambulancia',
              duracion: 4
            });
          }
        }).error(function(){
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'No te encuentras asignado a ninguna ambulancia',
            duracion: 4
          });
        });
      }else{

      }
    };

    $scope.abrirModalAutorizacionOxigeno = function(id, nombre) {
      var registro = $localStorage.tratamientoBasicoOxigeno.idTipoTratamiento;
      var estado = 0;
        for (var i = 0; i < registro.length; i++) {
                if (registro[i] == id) {
                  estado++;
                }
        };
      if (estado > 0) {
        $("#cuadro_autorizacion").remove();
        $("body").append('<div class="" id="cuadro_autorizacion1"></div>');
        $http.post(url + 'ReporteAPH/ctrlTratamientoB/ValidarTipoAmbulancia')
        .success(function(lista) {
          if (lista != "") {
            if (lista[0].tipoAmbulancia == "TAM") {
              angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">REGISTRAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Registrar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="frmCont autentificacion" style="width:100%"><label for="txtUsuarioAutentificacion">Usuario: </label><div class="frmInput"><input class="input_data bloquear usuarioCheck" ng-blur="BorrarBordeusuario()" ng-model="formulario.usuario" type="text" name="txtUsuarioAutentificacion" id="usuarioMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Clave: </label><div class="frmInput"><input class="input_data bloquear passwordCheck" ng-blur="BorrarBordepass()" ng-model="formulario.pass" type="password" name="txtClaveAutentificacion" id="claveMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Descripcion: </label><div class="frmInput"><textarea rows="4" id="txtDescripcion" cols="10"></textarea></div></div></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="registrarAutorizacionMedicalizada(' + id + ')" >Registrar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
            } else if (lista[0].tipoAmbulancia == "TAB") {
              angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">SOLICITAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Solicitar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><b>Descripcion </b><br><br><textarea id="txtArea' + id + '" name="name" rows="8" cols="40"></textarea></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="tratamiento.solicitar_autorizacion(1,' + id + ',1020481343)" >Solicitar Autorizacion</button></div><div class="cont-antecedente"><button type="button" name="" class="btn btn-cancelar" style="width: 100%;" onclick="tratamiento.cerrarSolicitudAutorizacion()" >No Solicitar Autorizacion</button></div></div></div></div></div></div>');
            }
          }else{
            Notificate({
              tipo: 'error',
              titulo: 'Error ',
              descripcion: 'No te encuentras asignado a ninguna ambulancia',
              duracion: 4
            });
          }
        }).error(function(){
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'No te encuentras asignado a ninguna ambulancia',
            duracion: 4
          });
        });
      }else{

      }
    };
  });


})();
