<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlMCalendario extends Controller implements iController {
    private $scripts;
    private $styles;
    Private $mdlCalendario = null;
    /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
    private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlCalendario = $this->loadModel('Programacion','mdlCalendario');
    }
    /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  */


    public function validarF($dia,$mes){
        $fes = false;
        $fecha = $dia."-".$mes;
        switch ($fecha) {
            case '1-1':
            case '1-5':
            case '8-12':
            case '25-12':
                $fes = true;
                break;
        }
        return $fes;
    }


    public function Index(){
           $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->scripts = array(
            "Programacion/Mcalendario.js",
            "Todos/Alerta.js",
            "Todos/modal.js",
            "Todos/notify.js"
            //"Todos/_header.js",
        );
        $this->styles = array(
            "Programacion/calendario.css",
            "Programacion/calendario.css.map",
            "Todos/otro.css"
        );

        require APP . 'View/_layout/header.php';
        require APP . 'View/Programacion/MViewCalendario.php';
        require APP . 'View/_layout/footer.php';
    }


    public function cl(){

        if (Sesion::exist()) {
            if(Sesion::getValue("bandera") == null){
                Sesion::setValue("mm",date('m'));
                Sesion::setValue("aa", date('Y'));
                Sesion::setValue("bandera",1);
            }
        }

        if($_POST["boton"] == 2){

            Sesion::setValue("mm",Sesion::getValue("mm")+1);

            if(Sesion::getValue("mm") == 13){
                Sesion::setValue("aa", Sesion::getValue("aa")+1);
                Sesion::setValue("mm",1);
            }else{
                Sesion::setValue("aa", Sesion::getValue("aa"));
            }

        }else if($_POST["boton"] == 1){

            Sesion::setValue("mm", Sesion::getValue("mm")-1);

            if(Sesion::getValue("mm") == 0){
                Sesion::setValue("aa", Sesion::getValue("aa")-1);
                Sesion::setValue("mm",12);
            }else{
                Sesion::setValue("aa", Sesion::getValue("aa"));
            }

        }else{
            Sesion::setValue("mm", date('m'));
            Sesion::setValue("aa", date('Y'));
        }

        $bisiesto = Sesion::getValue("aa");

        if(($bisiesto%4 ==0) && ($bisiesto%100 != 0 || $bisiesto%400 == 0)){
            $df=28;
        }else
        {
            $df=29;
        }
        switch (Sesion::getValue("mm")) {
            case '1': $can_dias = 31;
                $nombre = 'Enero';
                break ;
            case '2': $can_dias = $df;
                $nombre = 'Febrero';
                break;
            case '3': $can_dias = 31;
                $nombre = 'Marzo';
                break;
            case '4': $can_dias = 30;
                $nombre = 'Abril';
                break;
            case '5': $can_dias = 31;
                $nombre = 'Mayo';
                break;
            case '6': $can_dias = 30;
                $nombre = 'Junio';
                break;
            case '7': $can_dias = 31;
                $nombre = 'Julio';
                break;
            case '8': $can_dias = 31;
                $nombre = 'Agosto';
                break;
            case '9': $can_dias = 30;
                $nombre = 'Septiembre';
                break;
            case '10': $can_dias = 31;
                $nombre = 'Octubre';
                break;
            case '11': $can_dias = 30;
                $nombre = 'Noviembre';
                break;
            case '12': $can_dias = 31;
                $nombre = 'Diciembre';
                break;
        }
        $timeta = mktime(0,0,0,Sesion::getValue("mm"),1,Sesion::getValue("aa"));
        $saltar = date("w", $timeta);
        $can_dias += $saltar;
        $filas = ceil($can_dias/7);
        $can_celdas = $filas * 7;
        $diferencia = $can_celdas - $can_dias;
        /*if(isset($_POST['derecha'])){
      $p=$p+1;
    }*/
        $i = 1;
        $id = 0;
        $calendar = "";
        for ($i; $i <= $can_dias ; $i++) {
            if ($i <=$saltar) {
                $calendar .= '<div class="calendario-dias contenedor"></div>';
            }else{
                $nueva = $i - $saltar;
                $res = $this->validarF($nueva,Sesion::getValue("mm"));
                if ($res == true) {
                    $css = 'class="calendario-dias festivo contenedor"';
                }else {
                    $css ='class="contenedor calendario-dias dias" onclick="pd(this)"';
                }
                $calendar .= "<div $css id='$nueva'>$nueva</div>";
            }
        }
        for ($i=1; $i <= $diferencia ; $i++) {
            $calendar .= '<div class="calendario-dias contenedor">'.$i.'</div>';
        }
        $Vble2 = array();
        array_push($Vble2,$calendar);
        array_push($Vble2,$nombre);
        array_push($Vble2,Sesion::getValue("aa"));
        echo json_encode($Vble2);
    }



    //*************************************************************************


    public function validarSelecion(){
        Sesion::setValue("diaA",date('d'));
        $anoS = Sesion::getValue("aa");
        $mesS = Sesion::getValue("mm");
        $diaA = Sesion::getValue("diaA");
        $fecha = $anoS."-".$mesS."-".$diaA;
        echo json_encode($fecha);
    }


    public function guardarDiasT(){
        $diasT = $_POST['ALLdias'];
        Sesion::setValue("arrayDias",$diasT);
        echo json_encode(Sesion::getValue("arrayDias"));
    }

    //metodo para registrar Programacion
    public function registrarProgramacion(){
        $turno1=$_POST['txturnos'];
        $dias=$_POST['txtDias'];
        $Ano =$_POst['anoS'];
        $meses =$_POST['meses'];
        $cantidaddias = count($dias);
        $cantidadturnos = count($turno1);
        unset($dias[0]);
        $maxd = max($dias);
        $maxA = max($Ano);
        $maxM = max($meses);
        for($i=1; $i<=$cantidaddias-1; $i++){
            $fechaFinal = $maxA."/".$maxM."/".$maxd;
            $formato = $Ano."/".$mes."/".$dias[$i];
            //    var_dump($formato.":fechainicial");
            //  var_dump($fechaFinal.":fechaFinal");
            $res = $this->mdlCalendario->insertarProgramacion($formato,$fechaFinal,$turno1);
            $num;
            foreach ($res as $key) {
                $num = $key;
            }
            $this->mdlCalendario->insertarTurnoProgramacion($turno1,$num,1);
        }
    }


}

?>
