(function () {
  'use strict';
  /*jshint multistr: true */
  /* jshint eqnull:true */

  app.controller('ctrlLayoutReporteAPH' , function ($scope, $http,  $localStorage) {
    var idReporteInicial = 0;
    var idDespacho = 0;

    if ($localStorage.ReporteInicial) {
      idReporteInicial = Number($localStorage.ReporteInicial.idReporteInicial);
      idDespacho = Number($localStorage.ReporteInicial.idDespacho);
    }

    $scope.HoraConfirmacion = $localStorage.Confirmacion || false;


    if ($scope.HoraConfirmacion !== false) {
      $("#FlechaDerechaIndex").show();
    }
    // Contiene todas las novedades, este arreglo se enlaza con el localStorage (cualquier cambio afecta al arreglo de localStorage)
    $scope.Novedades = $localStorage.Novedades || [];
    $scope.ParametrosReporteInicialDespacho = [];

    // Necesario para registrar una novedad
    $scope.RegistroNovedad = {
      "txtNovedadLibre" : "",
      "txtNumeroLesionados" : "",
    };

    // Ocultar el botón de editar del formulario de Registro Novedad al inicial la app
    $scope.verBtnEditarNovedad = false;

    // Ocultar el mostrar el boton de registrar del formulario de Registro Novedad al inicial la app
    $scope.verBtnRegistrarNovedad = true;

    // Necesario para editar una novedad
    var idNovedadLocalS;

    // Controla que acción se desea realizar si registrar o insertar novedad
    var esClickBtnEditar = true;

    // Hora de confirmación de la emergencia
    $scope.horaConfirmacion = $localStorage.HoraConfirmacion || "";

    // Activar y desactivar modo consulta
    // $scope.esModoConsulta = esModoConsulta;



    /**
    * Confirmar emergencia de ReporteAPH
    */

    function getAllTime() {
      var today,h,m,s,allTime;

      function checkTime(i) {
        return (i < 10) ? "0" + i : i;
      }

      today = new Date(),
      h = checkTime(today.getHours()),
      m = checkTime(today.getMinutes()),
      s = checkTime(today.getSeconds());
      allTime = h + ":" + m + ":" + s;

      return allTime;
    }

    if ($scope.horaConfirmacion !== "") {
      horaLlegada("Hora de llegada " + $scope.horaConfirmacion );
    }else {

      if (idDespacho > 0) {
        $scope.ConfirmarLlegada = function () {

          // Alerta para confirmar emergencia
          swal({
            title: "¿Estas seguro de confirmar la emergencia?",
            text: "Estas a punto de confirmar a la central que has llegado al sitio de la emergencia satisfactoriamente.",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            confirmButtonColor : "#00A8A7"
          },
          function() {

            $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/ConfirmarLlegada',{
              "idDespacho"  : idDespacho
            })
            .success(function(res){
              if (res === 'Llegada confirmada') {
                swal(res, "Se ha confirmado la emergencia exitosamente.", "success");
                var hora = getAllTime();
                $scope.horaConfirmacion = hora;
                $localStorage.HoraConfirmacion = $scope.horaConfirmacion;
                $localStorage.Confirmacion = "true";
                horaLlegada("Hora de llegada " + hora);
                setTimeout(function(){
                  window.location = url + "ReporteAPH/CtrlInformacionGeneral";
                }, 500);

              } else {
                swal(res, "Ocurrio un problema al cancelar la emergencia.", "error");
              }

            })
            .error(function (res , status) {
              Notificate({
                titulo: 'Error al confirmar: ' + status,
                descripcion: 'No se pudó confirmar la emergencia.',
                tipo: 'error',
                duracion: 5
              });
            });

          });


        };
      }

    }


    /**
    * Cancelar emergencia de ReporteAPH
    */
    $scope.CancelarEmergencia = function () {

      if (idReporteInicial > 0) {
        // Alerta para cancelar emergencia
        swal({
          title: "¿Estas seguro de cancelar la emergencia?",
          text: "Por favor digita el motivo de la cancelación:",
          type: "input",
          showCancelButton: true,
          closeOnConfirm: false,
          animation: "slide-from-top",
          inputPlaceholder: "Motivo de la cancelación",
          confirmButtonColor : "#00A8A7"
        },
        function(inputValue) {
          if (inputValue === false) return false;
          if (inputValue === "") {
            swal.showInputError("Es necesario el motivo de la cancelación");
            return false;
          }

          $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/CancelarEmergencia',{
            "idReporteInicial"  : idReporteInicial,
            "idDespacho"      : idDespacho,
            "motivoCancelacion" : inputValue
          })
          .success(function(res){
            if (res === 'Emergencia cancelada') {
              swal({
                title: res,
                text: "Por favor reportate ante un superior",
                type: "success",
                showLoaderOnConfirm: true,
              }, function() {

                $localStorage.HoraConfirmacion = "";

                setTimeout(function(){
                  $localStorage.$reset();
                  window.location = url + "ReporteAPH/CtrlIndex";
                }, 300);

              });


            } else {
              swal(res, "Ocurrio un problema al cancelar la emergencia", "error");
            }

          })
          .error(function (res , status) {
            Notificate({
              titulo: 'Error al cancelar: ' + status,
              descripcion: 'No se pudó cancelar la emergencia.',
              tipo: 'error',
              duracion: 5
            });
          });

        });
      }else {
        Notificate({
          titulo: 'Error al cancelar:',
          descripcion: 'No existe un reporte inicial.',
          tipo: 'error',
          duracion: 5
        });
      }


    };



    /**
    * Pedir una nueva ambulancia
    */
    $scope.PedirNuevaAmbulancia = function (formData) {

      if(formData.txtNumeroBasico == null) formData.txtNumeroBasico = 0;
      if(formData.txtNumeroMedicalizada == null) formData.txtNumeroMedicalizada = 0;

      $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/PedirNuevaAmbulancia',{
        "idReporteInicial"  : idReporteInicial,
        "txtNumeroBasico" : formData.txtNumeroBasico,
        "txtNumeroMedicalizada" : formData.txtNumeroMedicalizada,
        "txtMotivoAyuda" : formData.txtMotivoAyuda
      })
      .success(function(res){
        if (res === 'Ayuda solicitada') {
          swal(res, "La ayuda ha sido solicitada, pero es recomendable que lo confirmes via radio.", "success");

          formData.txtNumeroBasico = "";
          $scope.form_PedirNuevaAmbulancia.txtNumeroBasico.$dirty = false;
          $scope.form_PedirNuevaAmbulancia.txtNumeroBasico.$pristine = true;

          formData.txtNumeroMedicalizada = "";
          $scope.form_PedirNuevaAmbulancia.txtNumeroMedicalizada.$dirty = false;
          $scope.form_PedirNuevaAmbulancia.txtNumeroMedicalizada.$pristine = true;

          formData.txtMotivoAyuda = "";

        } else {
          swal(res, "Ocurrio un problema al solicitar la ambulancia", "error");
        }

      })
      .error(function (res , status) {
        Notificate({
          titulo: 'Error en ayuda: ' + status,
          descripcion: 'No se puede solicitar la ambulancia.',
          tipo: 'error',
          duracion: 5
        });
      });

    };


    /**
    * Pedir ayuda de un ente externo
    */
    $scope.PedirAyudaExterna = function (tipoAyuda) {

      // Alerta de confirmación
      swal({
        title: "¿Estas seguro de que quieres pedir este tipo de ayuda?",
        text: "Por favor digita un motivo:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Motivo de la petición",
        confirmButtonColor : "#00A8A7"
      },
      function(inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
          swal.showInputError("Es necesario el motivo de la petición");
          return false;
        }

        $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/PedirAyudaExterna',{
          "idReporteInicial"  : idReporteInicial,
          "tipoAyuda" : tipoAyuda,
          "txtMotivoAyudaExterna" : inputValue
        })
        .success(function(res){
          if (res === 'Ayuda solicitada') {
            swal(res, "La ayuda ha sido solicitada, pero es recomendable que lo confirmes via radio.", "success");
          } else {
            swal(res, "Ocurrio un problema al solicitar la ayuda", "error");
          }

        })
        .error(function (res , status) {
          Notificate({
            titulo: 'Error en solicitud: ' + status,
            descripcion: 'No se pudó solicitar el ente externo.',
            tipo: 'error',
            duracion: 5
          });
        });

      });



    };


    /**
    * Controla que acción se quiere ejecutar si agregar o editar una novedad
    */
    $scope.ClickBtnEditar = function (res) {
      esClickBtnEditar = res;
    };


    /**
    * Agregar novedad a locacalStorage
    */
    $scope.AgregarNovedadLocalStorage = function (formData) {
      if (!esClickBtnEditar) {
        var id = $scope.Novedades.length;
        var novedad = {
          "idNovedad" : id,
          "txtNovedadLibre" : formData.txtNovedadLibre,
          "txtNumeroLesionados" : formData.txtNumeroLesionados
        };

        $scope.Novedades.push(novedad);
        $localStorage.Novedades = $scope.Novedades;

        Notificate({
          tipo: 'success',
          titulo: 'Exito:',
          descripcion: 'Novedad agregada correctamente.',
          duracion:4
        });
        $scope.LimpiarFormRN(formData);
      }
    };



    /**
    * Editar novedad de locacalStorage
    */
    $scope.EditarNovedadLocalStorage = function (formData) {

      if (esClickBtnEditar && formData.txtNovedadLibre) {
        var item = $scope.Novedades[idNovedadLocalS];
        item.txtNovedadLibre = formData.txtNovedadLibre;
        item.txtNumeroLesionados = formData.txtNumeroLesionados;

        $localStorage.Novedades = $scope.Novedades;

        Notificate({
          tipo: 'success',
          titulo: 'Exito:',
          descripcion: 'Novedad modificada correctamente.',
          duracion:4
        });

        $scope.LimpiarFormRN(formData);

        $scope.verBtnEditarNovedad = false;
        $scope.verBtnRegistrarNovedad = true;

      }

    };


    /**
    * Limpiar campos del formulario de registro de novedades
    */
    $scope.LimpiarFormRN = function (formData) {
      formData.txtNovedadLibre = "";
      formData.txtNumeroLesionados = "";
    };


    /**
    * Consultar novedad de locacalStorage
    */
    $scope.ConsultarNovedadLocalStorage = function (idNovedad) {
      idNovedadLocalS = idNovedad;

      var item = $scope.Novedades[idNovedad];
      $scope.RegistroNovedad.txtNovedadLibre = item.txtNovedadLibre;
      $scope.RegistroNovedad.txtNumeroLesionados = item.txtNumeroLesionados;

      $scope.verListaNovedades = false;
      $scope.verRegistroNovedad = true;

      $scope.verBtnEditarNovedad = true;
      $scope.verBtnRegistrarNovedad = false;

    };


    /**
    * Elimina una noveda del arreglo de local Storage
    */
    $scope.EliminarNovedad = function (idNovedad) {
      $scope.Novedades.splice(idNovedad , 1);

      for (var i = 0; i < $scope.Novedades.length; i++) {
        $scope.Novedades[i].idNovedad = i;
      }

      Notificate({
        tipo: 'success',
        titulo: 'Exito:',
        descripcion: 'Novedad eliminada correctamente.',
        duracion:4
      });

      $localStorage.Novedades = $scope.Novedades;
    };


    /**
    * Agregar novedad a la base de datos
    */
    $scope.RegistrarNovedad = function (formData) {
      var numeroLesionados;
      if(formData.txtNumeroLesionados != null){
        numeroLesionados = formData.txtNumeroLesionados;
      }else {
        numeroLesionados = -1;
      }

      $http.post(url + 'ReporteAPH/ctrlLayoutReporteAPH/RegistrarNovedad',{
        "idReporteInicial"  : idReporteInicial,
        "descripcion" : formData.txtNovedadLibre,
        "numeroLesionados" : numeroLesionados
      })
      .success(function(res){
        if (res === 'Novedad agregada') {
          swal(res, "La novedad fue agregada correctamente al reporte inicial.", "success");

          formData.txtNovedadLibre = "";
          formData.txtNumeroLesionados = "";

        } else {
          swal(res, "Ocurrio un problema al agregar la novedad", "error");
        }

      })
      .error(function (res , status) {
        alerta('error',null,res);
        Notificate({
          titulo: 'Ocurrio un error: ' + status,
          descripcion: 'No se pudó resgistrar la novedad.',
          tipo: 'error',
          duracion: 5
        });
      });

    };



  });


})();
