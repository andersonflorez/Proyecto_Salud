<?php

/**
 * Modelo Para desarrolar las instrucciones del CRUD de Las maestras de Historia Clinica de Domiciliaria
 */
class Mdlmaestra implements iModel {

    private static $_INSTANCIA; // Instancia única de esta clase
    private $_CONEXION;         // Variable de conexión PDO

    # Atributos de la clase:
    // ...
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
    # TIPO DE DEVOLUCIÓN

    function registrartipoDevolucion($descripcion) {
        $sql = "CALL spRegistrarTipodevolucion(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $descripcion, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function ListadotipoDevolucionMdl() {
        $sql = "CALL spListarTipodevolucion()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function ActualizartipoDevolucion($id, $des, $est) {
        $sql = "CALL spModificarTipodevolucion(?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $id, PDO::PARAM_STR);
        $query->bindParam(2, $des, PDO::PARAM_STR);
        $query->bindParam(3, $est, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //TIPO  NOVEDAD
    function Registrartiponovedad($descripcion, $estado) {
        $sql = "CALL spRegistrarTiponovedad(?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $descripcion, PDO::PARAM_STR);
        $query->bindParam(2, $estado, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function Listadotiponovedad() {
        $sql = "CALL spListarTiponovedad()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function Actualizartiponovedad($idexamen, $descripcionexamen, $estado) {
        $sql = "CALL spModificarTiponovedad(?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idexamen, PDO::PARAM_STR);
        $query->bindParam(2, $descripcionexamen, PDO::PARAM_STR);
        $query->bindParam(3, $estado, PDO::PARAM_STR);
        if ($query->execute()){
            return true;
        }else{
            return false;
        }
    }

    # CATEGORIA RECURSO
    function RegistrarCategoriaRecurso($descripcionCategoriaRecurso) {
        $sql = "CALL spRegistrarCategoriaRecurso(?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $descripcionCategoriaRecurso, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function ListadoCategoriaRecurso() {
        $sql = "CALL spListarCategoriaRecurso()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function ActualizarCategoriaRecurso($id, $des, $est) {
        $sql = "CALL spModificarCategoriaRecurso(?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idCategoriaRecurso, PDO::PARAM_STR);
        $query->bindParam(2, $descripcionCategoriaRecurso, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    #TIPO ASIGNACION
    function RegistrarTipoAsignacion($descripcionTipoAsignacion) {
        $sql = "CALL spRegistrarTipoAsignacion(?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $descripcionTipoAsignacion, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function ListadoTipoAsignacion() {
        $sql = "CALL spListadoTipoAsignacion()";
        $query = $this->_CONEXION->prepare($sql);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function ActualizarTipoAsignacion ($id, $des, $est) {
        $sql = "CALL spActualizarTipoAsignacion(?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idTipoAsignacion, PDO::PARAM_STR);
        $query->bindParam(2, $descripcionTipoAsignacion, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }


}

?>
