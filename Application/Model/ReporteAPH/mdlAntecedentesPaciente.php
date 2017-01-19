<?php

/**
 * Modelo ModelNombreModelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class MdlAntecedentesPaciente implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_idReporteAPH;
  private $_idAntecedente;
  private $_especificacion;

  # Atributos de la clase:
  // ...

  # Constructor:
  private function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos :' + $e);
    }
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

  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

        public function RegistrarAntecedenteAPH(){
          try {
              $idReporte = $this->__GET("_idReporteAPH");
              $idAntecedente = $this->__GET("_idAntecedente");
              $especificacion = $this->__GET("_especificacion");
              $sql = "CALL spRegistrarAntecedenteaph(?,?,?)";
              $query = $this->_CONEXION->prepare($sql);
              $query->bindParam(1, $idAntecedente, PDO::PARAM_STR);
              $query->bindParam(2, $idReporte, PDO::PARAM_STR);
              $query->bindParam(3, $especificacion, PDO::PARAM_STR);
              if ($query->execute()) {
                      return true;
              }else{
                      return false;
              }
          } catch (Exception $e) {
                      return false;
          }

        }

}


?>
