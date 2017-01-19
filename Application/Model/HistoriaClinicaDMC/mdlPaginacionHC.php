<?php

/**
 * Modelo Para desarrolar las instrucciones del CRUD de Las maestras de Historia Clinica de Domiciliaria
 */
class   mdlPaginacionHC implements iModel {

    private static $_INSTANCIA; // Instancia única de esta clase
    private $_CONEXION;         // Variable de conexión PDO

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

    public function Select($config, $returnData,$id,$columnaId){
        $isRowCount = ($returnData) ? 1 : 0;

        $sql = "CALL spPaginacionHC(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$config['tableName']);
        $query->bindParam(2,$config['fields']);
        $query->bindParam(3,$config['limit']);
        $query->bindParam(4,$config['page']);
        $query->bindParam(5,$config['nameColumnDateTime']);
        $query->bindParam(6,$config['filterDateTimeStart']);
        $query->bindParam(7,$config['filterDateTimeEnd']);
        $query->bindParam(8,$config['nameColumnFilter']);
        $query->bindParam(9,$config['filter']);
        $query->bindParam(10,$this->lengthFilter);
        $query->bindParam(11,$config['nameColumnOrderBy']);
        $query->bindParam(12,$config['orderBy']);
        $query->bindParam(13,$isRowCount);
        $query->bindParam(14,$columnaId);
        $query->bindParam(15,$id);

        $query->execute();

        if ($query->rowCount() > 0) {

            if ($returnData) {

                return $query->fetchAll();
            }else {
                return (int) $query->fetchColumn();
            }

        }else{
            return null;
        }
    }



    public function consultar($config,$id,$columnaId) {

        // Para validar el filtro de las fechas
        $valorRango1 = ( !empty($config['nameColumnDateTime']) ) ? 1 : 0;
        $valorRango2 = ( !empty($config['filterDateTimeStart']) ) ? 1 : 0;
        $valorRango3 = ( !empty($config['filterDateTimeEnd']) ) ? 1 : 0;
        $sumaRangoFehca = $valorRango1 + $valorRango2 + $valorRango3;

        // Para validar filtro especifico
        $valorEspecifico1 = ( !empty($config['nameColumnFilter']) ) ? 1 : 0;
        $valorEspecifico2 = ( !empty($config['filter']) ) ? 1 : 0;
        $sumaFiltroEspecifico = $valorEspecifico1 + $valorEspecifico2 ;

        // Para validar orderBy
        $valorOrderBy1 = ( !empty($config['nameColumnOrderBy']) ) ? 1 : 0;
        $valorOrderBy2 = ( !empty($config['orderBy']) ) ? 1 : 0;
        $sumaValorOrderBy = $valorOrderBy1 + $valorOrderBy2;



        if ($config['tableName'] == '' || $config['fields'] == '' || $config['limit'] == '' || $config['page'] == ''){
            return 'Los siguientes campos son necesarios: tableName, fields, limit, page.';
        }

        if ((int) $config['page'] <= 0 || (int) $config['limit'] <= 0) {
            return 'Propiedad page y limit deben ser mayores a 0.';
        }

        if (!empty($config['nameColumnDateTime']) || !empty($config['filterDateTimeStart']) || !empty($config['filterDateTimeEnd']) ) {
            if ($sumaRangoFehca != 3) {
                return "Se requiere los siguientes propiedades para el filtro de rango de fechas nameColumnDateTime, filterDateTimeStart, filterDateTimeEnd.";
            }
        }

        if ( !empty($config['nameColumnFilter']) || !empty($config['filter']) )  {
            if ($sumaFiltroEspecifico != 2) {
                return "Se requiere los siguientes propiedades para un filtro especifico nameColumnFilter, filter.";
            }else {
                $this->lengthFilter = count(explode(",", $config['filter']));
            }
        }

        if ( !empty($config['nameColumnOrderBy']) || !empty($config['orderBy']) )  {
            if ($sumaValorOrderBy != 2) {
                return "Se requiere los siguientes propiedades para ordenar los resultados nameColumnOrderBy, orderBy.";
            }
        }

        $datos = array(
            'cantidadRegistros' => self::Select($config, false,$id,$columnaId),
            'datos' => self::Select($config, true,$id,$columnaId)
        );
        return $datos;


    }
}
?>
