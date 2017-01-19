<?php
class MdlExamenFisico implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_fechaHoraExamen;
  private $_estadoRespiracion;
  private $_respiracion_min;
  private $_SpO2;
  private $_estado_pulso;
  private $_pulso_min;
  private $_sistole;
  private $_diastole;
  private $_glucometria;
  private $_conciencia;
  private $_glasgow;
  private $_estadoPupilaDerecha;
  private $_estadoPupilaIzquierda;
  private $_gradoDilatacionPupilaD;
  private $_gradoDilatacionPupilaI;
  private $_estadoHemodinamico;
  private $_especificacionOcular;
  private $_especificacionVerbal;
  private $_especificacion_Motor;
  private $_especificacion_ExamenFisico;


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
  function __SET($atributo, $valor){
      $this->$atributo = $valor;
  }
  function RegistrarExamenFisico(){
    try {
          $hora = $this->__GET("_fechaHoraExamen");
          $estadoRespiracion = $this->__GET("_estadoRespiracion");
          $respiracion_min = $this->__GET("_respiracion_min");
          $SpO2 = $this->__GET("_SpO2");
          $estadoPulso = $this->__GET("_estado_pulso");
          $pulso_min = $this->__GET("_pulso_min");
          $sistole = $this->__GET("_sistole");
          $diastole = $this->__GET("_diastole");
          $glucometria = $this->__GET("_glucometria");
          $conciencia = $this->__GET("_conciencia");
          $glasgow = $this->__GET("_glasgow");
          $estadoPupilaDerecha = $this->__GET("_estadoPupilaDerecha");
          $estadoPupilaIzquierda = $this->__GET("_estadoPupilaIzquierda");
          $gradoPupilaD = $this->__GET("_gradoDilatacionPupilaD");
          $gradoPupilaI = $this->__GET("_gradoDilatacionPupilaI");
          $especificacionVerbal = $this->__GET("_especificacionVerbal");
          $estadoHemodinamico = $this->__GET("_estadoHemodinamico");
          $especificacionOcular = $this->__GET("_especificacionOcular");
          $especificacionMotor = $this->__GET("_especificacion_Motor");
          $especificacionExamenFisico = $this->__GET("_especificacion_ExamenFisico");
          $sql = "CALL `spRegistrarExamenfisicoaph`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $query = $this->_CONEXION->prepare($sql);
          $query->bindParam(1, $hora, PDO::PARAM_STR);
          $query->bindParam(2, $estadoRespiracion, PDO::PARAM_STR);
          $query->bindParam(3, $respiracion_min, PDO::PARAM_STR);
          $query->bindParam(4, $SpO2, PDO::PARAM_STR);
          $query->bindParam(5, $estadoPulso, PDO::PARAM_STR);
          $query->bindParam(6, $pulso_min, PDO::PARAM_STR);
          $query->bindParam(7, $sistole, PDO::PARAM_STR);
          $query->bindParam(8, $diastole, PDO::PARAM_STR);
          $query->bindParam(9, $glucometria, PDO::PARAM_STR);
          $query->bindParam(10, $conciencia, PDO::PARAM_STR);
          $query->bindParam(11, $glasgow, PDO::PARAM_STR);
          $query->bindParam(12, $estadoPupilaDerecha, PDO::PARAM_STR);
          $query->bindParam(13, $estadoPupilaIzquierda, PDO::PARAM_STR);
          $query->bindParam(14, $gradoPupilaD, PDO::PARAM_STR);
          $query->bindParam(15, $gradoPupilaI, PDO::PARAM_STR);
          $query->bindParam(16, $estadoHemodinamico, PDO::PARAM_STR);
          $query->bindParam(17, $especificacionVerbal, PDO::PARAM_STR);
          $query->bindParam(18, $especificacionOcular, PDO::PARAM_STR);
          $query->bindParam(19, $especificacionMotor, PDO::PARAM_STR);
          $query->bindParam(20, $especificacionExamenFisico, PDO::PARAM_STR);
          if ($query->execute()) {
                return $query->fetch();
          }else{
                return null;
          }


    } catch (Exception $e) {
              return null;
    }

  }

}


?>
