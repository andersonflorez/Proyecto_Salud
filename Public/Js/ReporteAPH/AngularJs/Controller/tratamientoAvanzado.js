(function() {
  'use strict';
  app.controller('CtrlTratamientoA', function($scope, $http, $localStorage, $window) {
    $scope.tratamientoTipoA = [];
    $scope.tratamientoTipoB = [];
    $scope.tratamientoTipoC = [];
    $scope.tratamientoTipoD = [];
    $scope.tratamientoEspecialDesfibrilacion = [];
    $scope.tratamientoEspecial = [];

    $scope.tratamientoAvanzado = $localStorage.tratamientoAvanzado || {
      idTipoTratamiento: '',
      observacionTratamiento: '',
      desfibrilacion: ''
    };

    $scope.tratamientoAvanzadoDextrosa = $localStorage.tratamientoAvanzadoDextrosa || {
      idTipoTratamiento: '',
      descripcionDextrosa: ''
    }

    $scope.tratamientoAvanzadoDesfibrilacion = $localStorage.tratamientoAvanzadoDesfibrilacion || {
      julios1: '',
      hora1: '',
      julios2: '',
      hora2: '',
      julios3: '',
      hora3: ''
    }

    $scope.ListarTipoTratamiento = function() {
      $http.post(url + 'ReporteAPH/ctrlTratamientoA/ListarTratamientoAvanzado')
      .success(function(lista) {
        for (var i = 0; i < lista.length; i++) {
          if (lista[i].categoriaItemTratamiento == "A") {
            $scope.tratamientoTipoA.push(lista[i]);
          } else if (lista[i].categoriaItemTratamiento == "B") {
            if (lista[i].Descripcion == "Dextrosa 5%" || lista[i].Descripcion == "Dextrosa") {
              $scope.tratamientoEspecial.push(lista[i]);
            } else {
              $scope.tratamientoTipoB.push(lista[i]);
            }
          } else if (lista[i].categoriaItemTratamiento == "C") {
            if (lista[i].Descripcion == "Desfibrilacion") {
              $scope.tratamientoEspecialDesfibrilacion.push(lista[i]);
            } else {
              $scope.tratamientoTipoC.push(lista[i]);
            }

          }
        }
        ListarSolicitudesA();
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

    $scope.GuardarTratamiento = function() {
      $localStorage.tratamientoAvanzado = $scope.tratamientoAvanzado;
    }

    $scope.GuardarTratamientoDextrosa = function() {
      $localStorage.tratamientoAvanzadoDextrosa = $scope.tratamientoAvanzadoDextrosa;
    }

    $scope.GuardarDesfibrilacion = function() {
      if ($("#julios1").val() != "") {
        if (!/^([0-9])*$/.test($("#julios1").val())){
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Solo números positivos, por defecto será el número 1',
            duracion: 4
          });
          $scope.tratamientoAvanzadoDesfibrilacion.julios1 = 1;
        }
      }
      if ($("#julios2").val() != "") {
        if (!/^([0-9])*$/.test($("#julios2").val())){
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Solo números positivos, por defecto será el número 1',
            duracion: 4
          });
          $scope.tratamientoAvanzadoDesfibrilacion.julios2 = 1;
        }
      }
      if ($("#julios3").val() != "") {
        if (!/^([0-9])*$/.test($("#julios3").val())){
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Solo números positivos, por defecto será el número 1',
            duracion: 4
          });
          $scope.tratamientoAvanzadoDesfibrilacion.julios3 = 1;
        }
      }

      $localStorage.tratamientoAvanzadoDesfibrilacion = $scope.tratamientoAvanzadoDesfibrilacion;
    }



    $scope.abrirModalAutorizacion = function(id, nombre) {
      $("#cuadro_autorizacion").remove();
      $("body").append('<div class="" id="cuadro_autorizacion1"></div>');
      $http({
        method : "POST",
        url : url + 'ReporteAPH/ctrlTratamientoA/ValidarTipoAmbulancia',
        async:false
      }).success(function(lista) {
        if (lista != "") {
          if (lista[0].tipoAmbulancia == "TAM") {
            angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">REGISTRAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Registrar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><div class="frmCont autentificacion" style="width:100%"><label for="txtUsuarioAutentificacion">Usuario: </label><div class="frmInput"><input class="input_data bloquear usuarioCheck" ng-blur="BorrarBordeusuario()" ng-model="formulario.usuario" type="text" name="txtUsuarioAutentificacion" id="usuarioMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Clave: </label><div class="frmInput"><input class="input_data bloquear passwordCheck" ng-blur="BorrarBordepass()" ng-model="formulario.pass" type="password" name="txtClaveAutentificacion" id="claveMedico"></div></div><div class="frmCont autentificacion" style="width:100%"><label for="txtClaveAutentificacion">Descripcion: </label><div class="frmInput"><textarea rows="4" id="txtDescripcion" cols="10"></textarea></div></div></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="registrarAutorizacionMedicalizada(' + id + ')" >Registrar Autorizacion</button></div></div></div></div></div></div>');
          } else if (lista[0].tipoAmbulancia == "TAB") {
            angular.element(document.getElementById('cuadro_autorizacion1')).append('<div class="md_solicitarAyuda temporalAuto" id="abrirConfirmacion"><input type="text" id="lbl_tratamiento_' + id + '" style="display:none" value="' + nombre + '"></label><div class="head_md_confirmar"><h5 style="color: #fff">SOLICITAR AUTORIZACION</h5></div><span style="float: right;float: rigth;margin-right: 10px;margin-top: -35px;color:#fff;cursor:pointer;" onclick="tratamiento.cerrarSolicitudAutorizacion()">X</span><div class="contenido_md_confirmacion"><div class="contenido no-pad"><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente">Solicitar Autorizacion Para: <b>' + nombre + '</b></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><b>Descripcion </b><br><br><textarea id="txtArea' + id + '" name="name" rows="8" cols="40"></textarea></div></div></div><div class="fila"><div class="columna--10 div_botones"><div class="cont-antecedente"><button type="button" name="" class="btn btn-registrar" style="width: 100%;" onclick="tratamiento.solicitar_autorizacion(1,' + id + ',1020481343)" >Solicitar Autorizacion</button></div></div></div></div></div></div>');
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
    }

    $scope.abrirModalAutorizacion1 = function(id, nombre) {
      var registro = $localStorage.tratamientoAvanzado.idTipoTratamiento;
      var estado = 0;
        for (var i = 0; i < registro.length; i++) {
                if (registro[i] == id) {
                  estado++;
                }
        };
      if (estado > 0) {
        $("#cuadro_autorizacion").remove();
        $("body").append('<div class="" id="cuadro_autorizacion1"></div>');
        $http.post(url + 'ReporteAPH/ctrlTratamientoA/ValidarTipoAmbulancia')
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

    $scope.abrirModalAutorizacionDextrosa = function(id, nombre) {
      var registro = $localStorage.tratamientoAvanzadoDextrosa.idTipoTratamiento;
      var estado = 0;
        for (var i = 0; i < registro.length; i++) {
                if (registro[i] == id) {
                  estado++;
                }
        };
      if (estado > 0) {
        $("#cuadro_autorizacion").remove();
        $("body").append('<div class="" id="cuadro_autorizacion1"></div>');
        $http.post(url + 'ReporteAPH/ctrlTratamientoA/ValidarTipoAmbulancia')
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

    $scope.ValidarSeleccionCampo = function() {
      var redirecionamiento;
      if (angular.element(document.getElementById('tratamientoDextrosa')).is(":checked")) {
        var descripcion = angular.element(document.getElementById('descripcionDextrosa')).val();
        console.log(descripcion);
        if (descripcion == "" || descripcion == null) {
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Si selecciono un dextrosa se debe digitar un valor',
            duracion: 4
          });
          redirecionamiento = false;
          angular.element(document.getElementById('descripcionDextrosa')).attr("style", "border-color: #E91E63;margin-right: 7px;cursor: initial;");
        } else {
          redirecionamiento = true;
        }

      } else {
        redirecionamiento = true;
      }


      if (!angular.element(document.getElementById('descripcionDextrosa')).val() == "") {
        if (!angular.element(document.getElementById('tratamientoDextrosa')).is(":checked")) {

          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Si ingresaste un valor de dextrosa debes seleccionar dextrosa',
            duracion: 4
          });
          redirecionamiento = false;
          angular.element(document.getElementById('lblDextrosa')).attr("style", "border: solid 1px #E91E63 !important;");
        } else {
          if (redirecionamiento == false) {

          } else {
            redirecionamiento = true;
          }
        }
      } else {
        if (redirecionamiento == false) {

        } else {
          redirecionamiento = true;
        }
      }


      if (angular.element(document.getElementById('tratamientoDesfibrilacion')).is(":checked")) {
        var hora1 = angular.element(document.getElementById('time1')).val();
        var julios1 = angular.element(document.getElementById('julios1')).val();
        if (hora1 == "" || hora1 == null || julios1 == "" || julios1 == null) {

          redirecionamiento = false;
          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Si seleccionaste desfibrilacion se debe digitar una descripcion(Hora, Julios)',
            duracion: 4
          });
          angular.element(document.getElementById('time1')).attr("style", "border-color: #E91E63;width: 42.5%; margin-bottom: 5px; cursor: initial;");
          angular.element(document.getElementById('julios1')).attr("style", "border-color: #E91E63;width: 42%; margin-bottom: 5px; cursor: initial;");
        } else {
          if (redirecionamiento == false) {

          } else {
            redirecionamiento = true;
          }
        }
      } else {
        if (redirecionamiento == false) {

        } else {
          redirecionamiento = true;
        }
      }



      if (!angular.element(document.getElementById('time1')).val() == "" || !angular.element(document.getElementById('time1')) == null || !angular.element(document.getElementById('julios1')).val() == "" || !angular.element(document.getElementById('julios1')) == null) {
        if (!angular.element(document.getElementById('tratamientoDesfibrilacion')).is(":checked")) {

          Notificate({
            tipo: 'error',
            titulo: 'Error ',
            descripcion: 'Si ingresaste un valor de desfibrilacion debes seleccionar desfibrilacion',
            duracion: 4
          });
          redirecionamiento = false;
          angular.element(document.getElementById('lbldesfibrilacion1')).attr("style", "border: solid 1px #E91E63 !important;");
        } else {
          if (redirecionamiento == false) {

          } else {
            redirecionamiento = true;
          }
        }
      } else {
        if (redirecionamiento == false) {

        } else {
          redirecionamiento = true;
        }
      }


      if (redirecionamiento == true) {
        validarBarraProgreso('ctrlmedicamento');
      } else {

      }

    }


    $scope.validarChage = function() {
      if ($localStorage.tratamientoAvanzadoDextrosa.idTipoTratamiento != "") {
        if ($localStorage.tratamientoAvanzadoDextrosa.descripcionDextrosa != null) {
          angular.element(document.getElementById('descripcionDextrosa')).removeAttr("style");
        } else {
          angular.element(document.getElementById('descripcionDextrosa')).attr("style", "border: solid 1px #E91E63; !important;");
        }

      } else {}

    }


    $scope.limpiarSiNoChecked = function() {
      if (!angular.element(document.getElementById('tratamientoDextrosa')).is(":checked")) {
        angular.element(document.getElementById('descripcionDextrosa')).val("");
      } else {}

    }

    $scope.validarChageCheck = function() {
      angular.element(document.getElementById('lblDextrosa')).removeAttr("style");
    }

    $scope.validarChageCheck1 = function() {
      angular.element(document.getElementById('lbldesfibrilacion1')).removeAttr("style");
    }

    $scope.deseleccionar = function() {
      var hora = angular.element(document.getElementById('time1')).val();
      var julios = angular.element(document.getElementById('julios1')).val();
      if (hora != "") {
        angular.element(document.getElementById('time1')).attr("style", "border-color: #e5e5e5;width: 42.5%; margin-bottom: 5px; cursor: initial;");
      }

      if (julios != "") {
        angular.element(document.getElementById('julios1')).attr("style", "border-color: #e5e5e5;width: 42%; margin-bottom: 5px; cursor: initial;");
      }
    }



    $scope.GuardarTratamientoAvanzado = function() {
      var hora1 = $scope.tratamientoAvanzadoDesfibrilacion.hora1;
      var julios1 = $scope.tratamientoAvanzadoDesfibrilacion.julios1;
      var hora2 = $scope.tratamientoAvanzadoDesfibrilacion.hora2;
      var julios2 = $scope.tratamientoAvanzadoDesfibrilacion.julios2;
      var hora3 = $scope.tratamientoAvanzadoDesfibrilacion.hora3;
      var julios3 = $scope.tratamientoAvanzadoDesfibrilacion.julios3;

      if (hora1 != null && hora1 != "" && julios1 != null && julios1 != null && hora2 != null && hora2 != "" && julios2 != null && julios2 != null && julios2 != null && julios2 != null && hora3 != null && hora3 != "" && julios3 != null && julios3 != null) {
        $scope.tratamientoAvanzado.desfibrilacion = '';
        $localStorage.tratamientoAvanzado = $scope.tratamientoAvanzado;
        $scope.tratamientoAvanzado.desfibrilacion = [{
          julios: julios1,
          hora: hora1
        }, {
          julios: julios2,
          hora: hora2
        }, {
          julios: julios3,
          hora: hora3
        }];
      } else if (hora1 != null && hora1 != "" && julios1 != null && julios1 != null && hora2 != null && hora2 != "" && julios2 != null && julios2 != null && julios2 != null && julios2 != null) {
        $scope.tratamientoAvanzado.desfibrilacion = '';
        $localStorage.tratamientoAvanzado = $scope.tratamientoAvanzado;
        $scope.tratamientoAvanzado.desfibrilacion = [{
          julios: julios1,
          hora: hora1
        }, {
          julios: julios2,
          hora: hora2
        }];
      } else if (hora1 != null && hora1 != "" && julios1 != null && julios1 != null) {
        $scope.tratamientoAvanzado.desfibrilacion = '';
        $localStorage.tratamientoAvanzado = $scope.tratamientoAvanzado;
        $scope.tratamientoAvanzado.desfibrilacion = [{
          julios: julios1,
          hora: hora1
        }];
      } else {

      }

      $localStorage.tratamientoAvanzado = $scope.tratamientoAvanzado;
    }

  });
})();
