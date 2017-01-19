<?php

/**
 * Modelo nombre_modelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class MdlUsuarios implements iModel {

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

    // ...

    # Métodos Setter & Getter:


    /*
  select p.primerNombre ,  p.primerApellido ,e.descripcionEspecialidad , e.idEspecialidad,es.idPersonaespecialidad
from tbl_persona p
inner join tbl_personaespecialidad es
on p.idPersona = es.idPersona
INNER JOIN tbl_especialidad e
on es.idEspecialidad = e.idEspecialidad
CALL spCONPERSONA()
  */

  // ...
public function consultarPersona() {
$sql ='CALL spConsultarpersonaconespecialidad()';
$query = $this->_CONEXION->prepare($sql);
 if ($query->execute()) {
            return $query->fetchALL();
        } else {
            return null;
        }
    }
 public function consultarPersonatodo($id) {
$sql ='CALL  spConsultarPersonatodo(?) ';
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1,$id);
 if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }
    }


    public function consultarturno($idtu){

        $sql = "call  spConsultarprogramacionconturno(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$idtu);
        if ($query->execute()){
            return $query->fetchAll();
        } else {return null;}
    }


    public function citasagendadas($idp) {

        $sql = "call spConsultacitasU(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$idp);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    public function consultarcitas($idt) {
        $sql ="call spConsultacitasU(?)" ;
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$idt);
        if ($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }
    }

   public function programacionesVencidas($fecha){
     $sql = "CALL spTraerprogramacionesvencidas(?)";
     $query = $this->_CONEXION->prepare($sql);
     $query->bindParam(1,$fecha);
     if($query->execute()){
        return $query->fetchAll();
     }
   }
    public function actualizarProgramaciones($ids){
         $estado = 'Terminado';
         $count = count($ids);
         var_dump($ids);
         $query = $this->_CONEXION->prepare("CALL spCambiarEstadoTurnoprogramacion(?,?)");
         $query->bindParam(1,$ids);
         $query->bindParam(2,$estado);
         $query->execute();
      //
      // for ($i=0; $i <=$count-1; $i++){
      //  $query = $this->_CONEXION->prepare("CALL spCambiarEstadoTurnoprogramacion(?,?)");
      //   $id = $ids[$i];
      //   $in = $id;
      //   $query->bindParam(1,$in);
      //   $query->bindParam(2,$estado);
      //   $query->execute();
      // }
    }


}

?>
