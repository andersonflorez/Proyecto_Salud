<?php

class MdlConsultarHistoria implements iModel{

    private static $_INSTANCIA;
    private $_CONEXION;

     private function __construct($_CON){
        $this->_CONEXION=$_CON;
    }

    public static function getInstance($_CONEXION){
        if(!self::$_INSTANCIA instanceof self){
            self::$_INSTANCIA = new self($_CONEXION);
        }

        return self::$_INSTANCIA;

    }

    function consultarIndex(){
        $sql="CALL spConsultarHistoriaClinic()";
        $conn=$this->_CONEXION;
        $query=$conn->prepare($sql);  
        if($query->execute()){
            return $query->fetchAll();
        }else{
            return null;
        }
    }


}



?>
