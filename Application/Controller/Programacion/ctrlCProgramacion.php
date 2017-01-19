<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlCProgramacion extends Controller implements iController {
    private $scripts;
    private $styles;
    Private $mdlCProgramacion = null;
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
        $this->mdlCProgramacion = $this->loadModel('Programacion','mdlCProgramacion');
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
            "Programacion/CProgramacion.js",
            "Todos/modal.js"
        );
        $this->styles = array(
            "Programacion/Ccalendario.css"
        );

        require APP . 'View/_layout/header.php';
        require APP . 'View/Programacion/ViewCProgramacion.php';
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
                    $css = 'class="calendario-dias contenedor"';
                }else {
                    $css ='class="contenedor calendario-dias dias" ';
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
    public function traerProgramacion(){
        $id = $_POST['txtid'];
        $res = $this->mdlCProgramacion->consultarDias($id);
        echo json_encode($res);
    }

public function traerTurnos(){
  $id = $_POST['txtid'];
  $res = $this->mdlCProgramacion->consultarTurnos($id);
  echo json_encode($res);
}

public function programacionHP(){
  $id = $_POST['txtid'];
  $dia = '1';
  $fecha = Sesion::getValue("aa")."/".Sesion::getValue("mm")."/".$dia;
  $res = $this->mdlCProgramacion->historialProgramacion($fecha,$id);

  echo json_encode($res);
}
public function convertirFecha(){
  $fecha = $_POST['fecha'];
  $dia;
  $dia = date('d',strtotime($fecha));
  echo json_encode($dia);
  $dia = 0;
}


public function turnoshp(){
  $id = $_POST['id'];
  $fecha = Sesion::getValue("aa")."-".Sesion::getValue("mm")."-".date('d');
  $res = $this->mdlCProgramacion->traerTrunoshp($fecha,$id);
  echo json_encode($res);
}

public function validarSelecion(){
    Sesion::setValue("diaA",date('d'));
    $anoS = Sesion::getValue("aa");
    $mesS = Sesion::getValue("mm");
    $diaA = Sesion::getValue("diaA");
    $fecha = $anoS."-".$mesS."-".$diaA;
    echo json_encode($fecha);
}




public function Mvalidarcitas(){
$id = $_POST['txtid'];
 $res = $this->mdlCProgramacion->citasagendadas($id);
if ($res != null) {
echo json_encode( $res);
}else{
echo json_encode("0");
}
}

public function inhabilitar(){
$id = $_POST['idP'];
$res = $this->mdlCProgramacion->inhabilitar($id);
echo $res;
}

public function listarcitas(){

  $id = $_POST['idt'];
$consultorio = $this->mdlCProgramacion->citacion($id);

 echo json_encode($consultorio);
/*if ($consultorio != "") {
 echo json_encode($consultorio);
    echo "<script>alert('sd');</script>";
}else{

   return false;
       echo "<script>alert('Error');</script>";
  }*/
}


public function validarcitas(){
  $this->mdlUsiarios = $this->loadModel('Programacion','mdlUsiarios');
  $idp = $_POST["id"];
$citasion = $this->mdlUsuarios->citasagendadas($idp);
echo $citasion;
}

public function darValorCalendario(){
 $ano = $_POST['anod'];
 $mes = $_POST['mesd'];
 $formatoano = (string)$ano;
 $formatomes = (string)$mes+1;
//if($formatomes!=Sesion::getValue("mm") && $formatoano!=Sesion::getValue("aa")){
 Sesion::setValue("mm",$formatomes);
 Sesion::setValue("aa",$formatoano);
 /*else if($formatoano=='NaN'){
  Sesion::setValue("aa",$formatoano);
  Sesion::setValue("mm",$formatomes);
 }
 else{
   Sesion::setValue("mm",Sesion::getValue("mm"));
   Sesion::setValue("aa",Sesion::getValue("aa"));
 }*/
 var_dump($formatoano);
}





}
?>
