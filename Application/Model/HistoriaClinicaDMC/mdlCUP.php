<?php

class MdlCUP implements iModel{
    private static $_INSTANCIA; // Instancia única de esta clase
    private $_CONEXION;         // Variable de conexión PDO

    # Atributos de la clase:
    private $DescripcionCup;
    private $EstadoCup = 'Activo';
    private $idCup;
    private $CodigoCup;
    private $idConfiguracion = 1;
    private $idTipoCup = 3;

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
    public function RegistrarCup() {
        $r = false;
        $idConfiguracion = 1;
        $idTipoCup = 2;
        try {
            $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarCup(?,?,?,?,?)");
            $ejecutador->bindParam(1, $this->DescripcionCup);
            $ejecutador->bindParam(2, $this->idConfiguracion);
            $ejecutador->bindParam(3, $this->idTipoCup);
            $ejecutador->bindParam(4, $this->CodigoCup);
            $ejecutador->bindParam(5, $this->EstadoCup);
            $r = $ejecutador->execute();
        } catch (Exception $e) {
            die("Ha ocurrido un error: " . $e);
        }
        return $r;
    }

    public function ModificarCup() {
        $r = false;
        try {
            $ejecutador = $this->_CONEXION->prepare("CALL spModificarCup(?,?,?,?,?)");
            $ejecutador->bindParam(1, $this->idCup);
            $ejecutador->bindParam(2, $this->DescripcionCup);
            $ejecutador->bindParam(3, $this->idConfiguracion);
            $ejecutador->bindParam(4, $this->idTipoCup);
            $ejecutador->bindParam(5, $this->CodigoCup);
            $ejecutador->execute();
            $r = $ejecutador->rowCount() > 0;
        } catch (Exception $e) {
            die("Ha ocurrido un error: " . $e);
        }
        return $r;
    }

    public function CambiarEstadoCup() {
        $r = false;
        try {
            $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoCup(?,?)");
            $ejecutador->bindParam(1, $this->idCup);
            $ejecutador->bindParam(2, $this->EstadoCup);
            $r = $ejecutador->execute();
            $this->EstadoCup = 'Activo';
        } catch (Exception $e) {
            die("Ha ocurrido un error: " . $e);
        }
        return $r;
    }

    public function SetDescripcionCup($value) {
        $this->DescripcionCup = $value;
    }

    public function SetEstadoCup($value) {
        $this->EstadoCup = $value;
    }

    public function SetIdCup($value) {
        $this->idCup = $value;
    }

    public function SetCodigoCup($value){
        $this->CodigoCup = $value;
    }


}





?>