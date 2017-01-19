(function(){
  'use strict';

  app.controller('CtrlTipoEvento',function($scope, $http,  $localStorage){
    $scope.ReporteInicial =$localStorage.ReporteInicial || [];
    if ($scope.ReporteInicial == "") {
      window.location = url + 'ReporteAPH/ctrlIndex';
    }else{
      $scope.ListaTriaje=[];
      $scope.TipoEvento = $localStorage.ReporteInicial.IDESTipoEvento || [];
      $scope.TriageId = $localStorage.ReporteInicial.Triage || [];
      $scope.Cuidados = $localStorage.ReporteInicial.Cuidados  || [];
      $scope.ListaTipoEvento1 = [];
      $scope.ListaTipoEvento2 = [];
      $scope.ListaTipoEvento3 = [];
      $scope.ninguno = false;
      $scope.ListaCuidados = ['Ciudadano','Bomberos','Tránsito','Policía','Socorrista','Empleado','Enfermero(a)','Seguridad','Familiar','Médico'];
      function DisabledCuidados(){
        if ($scope.Cuidados == "Ninguno") {
            return true;
        }else{
            return false;
        }
      }
      $scope.QuitarBorderCheckTipoEvento = function(){
        $(".labelCheckTipo").removeClass("checkTipoEvento");
      }
      $scope.quitarBordeCuidados = function(){
        if ($scope.Cuidados  == "") {
          $(".checkCuidados").addClass("checkTipoEvento");
          $(".checkCuidadosN").addClass("checkTipoEvento");
        }else{
          $(".checkCuidados").removeClass("checkTipoEvento");
          $(".checkCuidadosN").removeClass("checkTipoEvento");
        }
      }
      $scope.quitarBordeTipoEvento = function(){
        if ($scope.TipoEvento == "") {
          $(".labelCheckTipo").addClass("checkTipoEvento");
        }else{
          $(".labelCheckTipo").removeClass("checkTipoEvento");
        }
      }
      $scope.GuadarTipoEvento = function(){
        if ($scope.TipoEvento == "" && $localStorage.ReporteInicial.Triage == "" && $scope.Cuidados == "") {
          $(".checkTriageID").addClass("checkTipoEvento");
          $(".labelCheckTipo").addClass("checkTipoEvento");
          $(".checkCuidados").addClass("checkTipoEvento");
          $(".checkCuidadosN").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario completar los campos obligatorios.',
            duracion: 5
          });
        }else if ($scope.TipoEvento == "") {
          $(".checkTriageID").removeClass("checkTipoEvento");
          $(".labelCheckTipo").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el tipo de evento.',
            duracion: 3
          });
        }else if ($localStorage.ReporteInicial.Triage == "") {
          $(".checkTriageID").addClass("checkTipoEvento");
          $(".labelCheckTipo").removeClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el triage.',
            duracion: 3
          });
        }else if ($scope.Cuidados == "") {
          $(".checkCuidados").addClass("checkTipoEvento");
          $(".checkCuidadosN").addClass("checkTipoEvento");
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar Cuidados Antes del Arribo.',
            duracion: 3
          });
        }
        else if ($("#txtIdPaciente").val() == "") {
          Notificate({
            tipo: 'error',
            titulo: 'Error!',
            descripcion: 'Es necesario especificar el paciente de la emergencia.',
            duracion: 3
          });
        }else{
          for (var i = 0; i < $scope.Cuidados.length; i++) {
            if ($scope.Cuidados[i] == "Ninguno") {
              $scope.Cuidados = ['Ninguno'];
              $localStorage.ReporteInicial.Cuidados = $scope.Cuidados;
            }
          }

          validarBarraProgreso('ctrlMotivoConsulta');

        }

      }
      $scope.GuardarTriage = function(idTriage){
        $(".checkTriageID").removeClass("checkTipoEvento");
        $localStorage.ReporteInicial.Triage = idTriage;
      };
      $scope.Checktriage= function(id){
        if ($scope.TriageId == id) {
          return true;
        }else{
          return false;
        }
      };



      $scope.ConsultaTriage = function(){
        $http.post(url + 'ReporteAPH/CtrlTipoEvento/ConsultarTriage')
        .success(function(lista){
          $scope.ListaTriaje = lista;
        })
        .error(function(error){
          console.log(error);
        });
      };
      $scope.ListarTipoEvento = function(){
        $http.post(url + 'ReporteAPH/CtrlTipoEvento/ListarTipoEvento')
        .success(function(Lista){
          $scope.ListadoTipoEvento = Lista;
        })
        .error(function(Error){
          console.log(Error);
        });
      };
      $scope.ListarTipoEvento();
      $scope.ConsultaTriage();
    }
  });
})();

$(document).ready(function(){

  // cargarMisgasPan("CtrlTipoEvento");
});
