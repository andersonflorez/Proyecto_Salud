<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class mdlConfiguracionCup implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...
  private $_idCup;
  private $_filtros;
  private $_DatosConfig;
  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }

  /*
  * Función getInstance():
  * Devuelve la única instancia de esta clase.
  * Recibe la conexión PDO como parámetro.
  */
  public static function getInstance($_CONEXION) {
    if (!self::$_INSTANCIA instanceof self) {
      self::$_INSTANCIA = new self($_CONEXION);
    }
    return self::$_INSTANCIA;
  }

  # Métodos y funciones de la clase:
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  function consultarDescripcionProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = " CALL spConsultaDesProcedi(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetchAll();

  }

  function consultarDescripcionIdProcedimiento() {
    $id=$this->__GET("_idCup");
    $sql = " CALL spConsultaDesIdProce(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$id);
    $query->execute();
    return $query->fetch();

  }

  function consultarCodigoIdProcedimiento() {
    $id=$this->__GET("_idCup");
    $sql = "CALL spConsultarCodIdProce(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$id);
    $query->execute();
    return $query->fetch();

  }

  function contarDescripcionProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = "CALL spContarDescripProce(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetch();
  }

  function consultarCodigoProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = "CALL spConsultarCodProcedi(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetchAll();
  }


  function contarCodigoProcedimiento() {
    $filtro=$this->__GET("_filtros");
    $sql = "CALL spContarCodProcedimi(?)";
    $query =$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$filtro);
    $query->execute();
    return $query->fetch();
  }



  function ListarConfiguracion(){
      $sql = "CALL spListarConfiguracionCup()";
      $query = $this->_CONEXION->prepare($sql);
      if ($query->execute()) {
         return $query->fetchAll();
      }else {
        return false;
      }
  }

  function ModificarConfi(){
    $datosC=$this->__GET("_DatosConfig");
    $sql = "CALL spModificarCupConfiguracion(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($datosC) ; $i++) {
        $query->bindParam($i+1, $datosC[$i]);
        //var_dump($datosC[$i]);
    }
    if ($query->execute()) {
         return true;
    }else {
      return false;
    }
  }


}


?>
