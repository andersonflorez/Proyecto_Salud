/**
* Este archivo se encarga meramente de definir el módulo 'ReporteAPH'
* de angularJs, y de definir funcionalidad común que será utilizada
* entre controladores.
*/

var app = angular.module('ReporteAPH' , [
  'ngStorage',
  'checklist-model'
]);


// Defino un prefijo para las keys de localStorage
app.config(['$localStorageProvider',
function ($localStorageProvider) {
  $localStorageProvider.setKeyPrefix('ReporteAPH-');
}]);

app.directive('convertToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(val) {
        return val ? parseInt(val, 10) : null;
      });
      ngModel.$formatters.push(function(val) {
        return val ? '' + val : null;
      });
    }
  };
});

app.service('RegistrarReporte', function ($q, $http) {
  return {
      EliminarTipoEvento : EliminarTipoEvento,
      GuardarTipoEventoReporteInicial : GuardarTipoEventoReporteInicial,
      GuardarExamenFisico : GuardarExamenFisico,
      RegistrarDetalleMotivoConsulta : RegistrarDetalleMotivoConsulta,
      RegistrarHistoriaClinicaAPH : RegistrarHistoriaClinicaAPH,
      RegistrarAntecedentesAPH: RegistrarAntecedentesAPH,
      RegistrarViaComunicacion : RegistrarViaComunicacion,
      RegistrarPiel : RegistrarPiel,
      RegistrarTratamiento : RegistrarTratamiento,
      RegistrarMedicamento : RegistrarMedicamento,
      RegistrarLocalizacionLesiones : RegistrarLocalizacionLesiones,
      RegistrarCuidadosAntesArribo : RegistrarCuidadosAntesArribo,
      RegistrarTestigos:RegistrarTestigos,
      RegistrarNovedadesReporteInicial  : RegistrarNovedadesReporteInicial,
      consultarAllAutorizacion : consultarAllAutorizacion,
      FinalizarReporteInicial : FinalizarReporteInicial
  }



    function EliminarTipoEvento(idReporteInicial){
      var refered = $q.defer();
       $http.post(url + 'ReporteAPH/ctrlTipoEvento/EliminarTipoEvento', {'idReporteInicial':idReporteInicial})
       .success(function(respuesta){
          if (respuesta == "true") {
            refered.resolve("true");
          }else{
            refered.reject("false");
          }
       })
       .error(function(){
          refered.reject("false");
       });
       return refered.promise;
    }
    function GuardarTipoEventoReporteInicial(IDESTipoEvento,idReporteI){

      var refered = $q.defer();
        for (var i = 0; i < IDESTipoEvento.length; i++) {
          $http.post(url + 'ReporteAPH/ctrlTipoEvento/RegistrarTipoEventoReporteInicial', {'idReporteInicial':idReporteI,'idTipoEvento':IDESTipoEvento[i]})
          .success(function(respuesta){
             if (respuesta == "true") {
               refered.resolve("true");

             }else{
              refered.reject("false");
             }
          })
          .error(function(){
             refered.reject("false");
          })
        }
        return refered.promise;
    }
    function GuardarExamenFisico(objExamenFisico){

     var defered = $q.defer();

     $http.post(url + 'ReporteAPH/ctrlExamenFisico/RegistrarExamenFisico', objExamenFisico)
     .success(function(respuesta){
           if (respuesta !=null) {
               defered.resolve(respuesta.ultimoregistro);
           }else{
             defered.reject('Error en el Registro');
           }
     })
     .error(function(err){
             defered.reject('Error en ajax, en el Registro');
     });

     return defered.promise;
     }

    function RegistrarDetalleMotivoConsulta(UltimoReporteAPH,urg){

      var refered = $q.defer();
      for (var i = 0; i < urg.length; i++) {
           $http.post(url + 'ReporteAPH/ctrlMotivoConsulta/RegistrarReporteaphMotivoconsulta', {'idReporteAph':UltimoReporteAPH,'idMotivoConsulta':urg[i]})
           .success(function(res){
                if (res == "true") {
                  refered.resolve("true");
                }else{
                  refered.reject("false");
                }
           })
           .error(function(){
             refered.reject("false");
           });
      }
      return refered.promise;
    }
    function RegistrarHistoriaClinicaAPH(ultimoregistro,objParametrosAPH){

      var refered = $q.defer();
      var objHistoria = {
        'ultimoRegistro':ultimoregistro,
        'objParametrosAPH':objParametrosAPH
      }
        $http.post(url + 'ReporteAPH/ctrlReporteAPH/RegistrarHistoriaClinicaAPH',objHistoria)
        .success(function(ultimoAPHU){
            if (ultimoAPHU != "null") {
              refered.resolve(ultimoAPHU.ultimoReporte);
            }else{
              refered.reject(null);
            }
        })
        .error(function(err){
            refered.reject(null);
        })


       return refered.promise;
    }
    function RegistrarAntecedentesAPH(objAntecedentes,ultimoRegistroAPH){

      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlAntecedentesPaciente/RegistrarAntecedenteAPH', {'ultimo':ultimoRegistroAPH,'obj':objAntecedentes})
      .success(function(res){
        if (res == "true") {
            refered.resolve(true);
        }else{
          refered.reject(false);
        }

      })
      .error(function(){
        refered.reject(false);
      });
      return refered.promise;
    }
    function RegistrarViaComunicacion(objVia,ultimoAPH){

      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlReporteAPH/RegistrarViaDeComunicacion', {'obj':objVia,'ultimoAPH':ultimoAPH})
      .success(function(respuesta){
        if (respuesta == "true") {
              refered.resolve(true);
        }else{
              refered.reject(false);
        }
      })
      .error(function(){
              refered.reject(false);
      });
      return refered.promise;
    }
    function RegistrarPiel(ultimoEX,descripcionPiel){
       refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlReporteAPH/RegistrarPiel', {'obj':descripcionPiel,'ultimoEX':ultimoEX})
      .success(function(respuesta){
        if (respuesta == "true") {
              refered.resolve(true);
        }else{
              refered.reject(false);
        }
      })
      .error(function(){
              refered.reject(false);
      });
      return refered.promise;
    }
    function RegistrarTratamiento(ReporteAph,objA,objB,tratamientoBasicoOxigeno,tratamientoAvanzadoDextrosa){

      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlTratamientoA/RegistrarTratamientoaph',{'TB':objB,'TA':objA,'tratamientoBasicoOxigeno':tratamientoBasicoOxigeno,'tratamientoAvanzadoDextrosa':tratamientoAvanzadoDextrosa,'reporte':ReporteAph})
      .success(function(res){

          if (res === "true") {
              refered.resolve(true);
          }else{
            refered.reject(false);
          }
      })
      .error(function(){
          refered.reject(false);
      })
      return refered.promise;
    }
    function RegistrarMedicamento(medicamento,idReporte){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlMedicamento/registrarMedicamento',{'medicamento':medicamento,'idReporte':idReporte} )
      .success(function(respuesta){
            if (respuesta === "true") {
                refered.resolve(true);
            }else{
              refered.reject(false);
            }
      })
      .error(function(){
        refered.reject(false);
      })
      return refered.promise;
    }
    function RegistrarLocalizacionLesiones(objcuerpo, idReporteAH){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlLocalizacionLesiones/RegistrarPuntoLesion',{'datosLocalizacionLesiones':objcuerpo,'idReporteAPH':idReporteAH} )
      .success(function(respuesta){
            if (respuesta === "true") {
                refered.resolve(true);
            }else{
              refered.reject(false);
            }
      })
      .error(function(){
        refered.reject(false);
      })
      return refered.promise;
    }
    function RegistrarCuidadosAntesArribo(objCuidados,idReporteAH){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlReporteAPH/RegistrarCuidadoAntesArriboAPH',{'cuidado':objCuidados,'idReporte':idReporteAH} )
      .success(function(respuesta){
            if (respuesta === "1") {
                refered.resolve(true);
            }else{
              refered.reject(false);
            }
      })
      .error(function(){
        refered.reject(false);
      })
      return refered.promise;
    }
    function RegistrarTestigos(testigos,idReporte){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlReporteAPH/RegistrarTestigos',{'testigos':testigos,'idReporte':idReporte})
      .success(function(data){
          if (data === "1") {
                refered.resolve(true);
          }else{
                refered.resolve(false)
          }
      })
      .error(function(){
        refered.reject(false)
      })
      return refered.promise;
    }
    function RegistrarNovedadesReporteInicial(idReporteInicial,novedades){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlReporteAPH/RegistrarNovedadesReporteInicial', {'idReporteInicial':idReporteInicial,'novedades':novedades})
      .success(function(data){
        if (data === "1") {
            refered.resolve(true);
        }else{
            refered.reject(false);
        }
      })
      .error(function(){
          refered.reject(false);
      })
      return refered.promise;
    }
    function consultarAllAutorizacion(idReporte,cedulaPaciente){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlMedicamento/consultarAllAutorizacion', {'idReporte':idReporte,'cedulaPaciente':cedulaPaciente})
      .success(function(data){
        if (data === "1") {
            refered.resolve(true);
        }else{
            refered.reject(false);
        }
      })
      .error(function(){
          refered.reject(false);
      })
      return refered.promise;
    }
    function FinalizarReporteInicial(idReporteInicial){
      var refered = $q.defer();
      $http.post(url + 'ReporteAPH/ctrlReporteAPH/FinalizarReporteInicial', {'idReporteInicial':idReporteInicial})
      .success(function(data){
        if (data === "1") {
            refered.resolve(true);
        }else{
            refered.reject(false);
        }
      })
      .error(function(){
          refered.reject(false);
      })
      return refered.promise;
    }


});
