<?php
require_once(APP.'Lib/fpdf/fpdf.php');
/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlCalendario extends Controller implements iController {
    private $scripts;
    private $styles;
    Private $mdlCalendario = null;
    Private $pdf;
    /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
    private $vistasMenu;


    function __construct(){
        Sesion::init();
        if (!Sesion::exist()){
            header("Location: ".URL);
            exit();
        }else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR'){
               // Es recomendable cargar los modelos en este apartado:
             $this->mdlCalendario = $this->loadModel('Programacion','mdlCalendario');
             $this->pdf = new FPDF('P','mm','Legal');
        }
        else{
          header("Location: " . URL . 'Error/Error');
          exit();
        }

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
          'Todos/sweetalert.js',
            "Programacion/calendario.js",
            "Todos/modal.js"
        );
        $this->styles = array(
            "Todos/sweetalert.css",
            "Programacion/calendario.css"
        );
        require APP . 'View/_layout/header.php';
        require APP . 'View/Programacion/ViewCalendario.php';
        require APP . 'View/_layout/footer.php';
    }


    public function CargarCalendario(){
  if(Sesion::exist()){
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
            $df=29;
        }else
        {
            $df=28;
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
                    $css ='class="contenedor calendario-dias dias" onclick="validarDia(this)"';
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
    public function traerCorreo(){
        $id = $_POST['txtid'];
        $res = $this->mdlCalendario->consultarCorreo($id);
        echo $res->correoElectronico;
      }

    public function validarSelecion(){
    $DI = $_POST['d'];
    $anoC = Sesion::getValue("aa");
    $mesC = Sesion::getValue("mm");
    $anoA = date('Y');
    $MesA = date('m');
    $dia = date('d');
      if($anoC<$anoA){
      echo  false;
      }else if($anoC==$anoA && $mesC<$MesA){
      echo false;
      }else if($anoC==$anoA && $mesC==$MesA && $DI<=$dia){
      echo   false;
      }else if($anoC==$anoA && $mesC==$MesA && $DI>$dia){
      echo  true;
      }else if($anoC==$anoA && $mesC>$MesA){
      echo  true;
      }else if($anoC>$anoA){
      echo true;
      }else{
        echo  false;
      }
    }
    public function datos(){
      Sesion::setValue("diaA",date('d'));
      $anoS = Sesion::getValue("aa");
      $mesS = Sesion::getValue("mm");
      $diaA = Sesion::getValue("diaA");
      $fecha = $anoS."-".$mesS."-".$diaA;
      echo $fecha;
    }
    public function guardarDiasT(){
        $diasT = $_POST['ALLdias'];
        Sesion::setValue("arrayDias",$diasT);
        echo json_encode(Sesion::getValue("arrayDias"));
    }
    //metodo para registrar Programacion
    public function registrarProgramacion(){
        //header('Location: '.APP."Controller/Programacion/ctrlRegistrarHistoriaClinica.php");
        $idUsuario = $_POST['txtidUsuario'];
        $turno1=$_POST['txturnos'];
        $dias=$_POST['txtDias'];
        $Ano =$_POST['anoS'];
        $meses =$_POST['meses'];
        $correo = $_POST['correo'];
        //require APP . 'Controller/Programacion/CtrlRegistrarHistoriaClinica.php';
        $cantidaddias = count($dias);
        unset($dias[0]);
        $maxd = max($dias);
        $maxA = max($Ano);
        $maxM = max($meses);
      //  $fechainicial;
        $diasExcel;
        for($i=1; $i<=$cantidaddias-1; $i++){
            $fechaFinal = $maxA."/".$maxM."/".$maxd;
            $formato = $Ano[$i]."/".$meses[$i]."/".$dias[$i];
            $diasExcel[$i] = $formato;
            $diasExcel[$cantidaddias] = $fechaFinal;
            $res = $this->mdlCalendario->insertarProgramacion($formato,$fechaFinal,$turno1);
            $num;
            foreach ($res as $key) {
                $num = $key;
            }
            $this->mdlCalendario->insertarTurnoProgramacion($turno1,$num,$idUsuario);
        }
        //$this->crearExcel();
        $this->crearExcel($diasExcel,$turno1);
        //header('location: /Programacion/ctrlCalendario');
        $transport = Swift_SmtpTransport::newInstance()
        ->setHost('smtp.gmail.com')
        ->setPort('465')
        ->setEncryption("ssl")
        ->setUsername('central.automatizada.despacho@gmail.com')
        ->setPassword('administracioncad');

        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance()
        //asunto
        ->setSubject('Su programación fue ingresada')
        //remitente
        ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administrador'))
        //Destinatarios
        ->setTo(array($correo => "Usuario"))
        ->setBody("Señor(a)<br><br>Usted esta programado para que trabaje los días que se encuentran en el archivo adjunto.<br><b></b><br><br> enviado este correo<br><br><i>Nota: No responder. Este correo es generado automáticamente</i>", 'text/html')
        ->attach(Swift_Attachment::fromPath(APP."Controller/Programacion/Programacion.pdf","application/pdf"));
         $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .
         'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //$headers->addTextHeader('hola mundo', 'the header value');
        // Send the message
        if ($mailer->send($message,$headers)) {
          echo "1";
          unlink(APP."Controller/Programacion/Programacion.pdf");
          //require APP . 'Controller/Programacion/ctrlConsultarUsuarios.php';
        }else {
          echo "2";
        }
    }

    function crearExcel($diasexcel,$formato){
      var_dump($formato);
      $cantidadTurnos = count($formato);
      $cantidadDias = count($diasexcel);
$contador=0;
$contador2=0;
$this->pdf->AddPage("primero",'Letter');
$this->Header($this->pdf);
$this->pdf->SetFont('Arial','B',12);
$this->pdf->SetTitle('Programación', true);
$this->pdf->SetTextColor(31,149,208);
$this->pdf->Text(10,55,'Turnos');
$this->pdf->SetTextColor(0,0,0);
$this->pdf->Text(10,60,'Estos son los turnos que le ha asignado el administrador.');
for ($i=0; $i<=$cantidadTurnos-1; $i++) {
    $contador = $contador+10;
    $posicion = $i+1;
    if($formato[$i]==1 && $contador==10){
      $this->pdf->SetXY($contador,65);
      //$objRichText->createText('00:00 a 06:00');
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 00:00 a 06:00',1,0,'C',false);
      //$objPHPExcel->getActiveSheet()->setCellValue('A3', '00:00 a 06:00');
    }else if($formato[$i]==2 && $contador==10){
      $this->pdf->SetXY($contador,65);
      //$objRichText->createText('06:00 a 12:00');
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 06:00 a 12:00',1,0,'C',false);
      //$objPHPExcel->getActiveSheet()->setCellValue('B3','06:00 a 12:00');
    }else if($formato[$i]==3 && $contador==10){
      $this->pdf->SetXY($contador,65);
      //$objRichText->createText('12:00 a 18:00');
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 12:00 a 18:00',1,0,'C',false);
      //$objPHPExcel->getActiveSheet()->setCellValue('C3','12:00 a 18:00');
    }else if($formato[$i]==4 && $contador==10){
      $this->pdf->SetXY($contador,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 18:00 a 00:00',1,0,'C',false);
    }else if($formato[$i]==1 && $contador==20){
      $this->pdf->SetXY(100,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 00:00 a 06:00',1,0,'C',false);
    }
     else if($formato[$i]==2 && $contador==20){
      $this->pdf->SetXY(60,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 06:00 a 12:00',1,0,'C',false);
    }else if($formato[$i]==3 && $contador==20){
      $this->pdf->SetXY(60,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 12:00 a 18:00',1,0,'C',false);
    }else if($formato[$i]==4 && $contador==20){
      $this->pdf->SetXY(60,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 18:00 a 00:00',1,0,'C',false);
    }
    else if($formato[$i]==1 && $contador==30){
      $this->pdf->SetXY(110,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 00:00 a 06:00',1,0,'C',false);
    }
    else if($formato[$i]==2 && $contador==30){
      $this->pdf->SetXY(110,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 06:00 a 12:00',1,0,'C',false);
    }else if($formato[$i]==3 && $contador==30){
      $this->pdf->SetXY(110,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 12:00 a 18:00',1,0,'C',false);
    }else if($formato[$i]==4 && $contador==30){
      $this->pdf->SetXY(110,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 18:00 a 00:00',1,0,'C',false);
    }
     else if($formato[$i]==1 && $contador==40){
      $this->pdf->SetXY(160,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 00:00 a 06:00',1,0,'C',false);
    }
    else if($formato[$i]==2 && $contador==40){
      $this->pdf->SetXY(160,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 06:00 a 12:00',1,0,'C',false);
    }else if($formato[$i]==3 && $contador==40){
      $this->pdf->SetXY(160,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 12:00 a 18:00',1,0,'C',false);
    }else if($formato[$i]==4 && $contador==40){
      $this->pdf->SetXY(160,65);
      $this->pdf->Cell(50,15,'Turno '.$posicion.':'.' 18:00 a 00:00',1,0,'C',false);
    }
  }
  $this->pdf->SetTextColor(31,149,208);
  $this->pdf->Text(10,95,utf8_decode('Días'));
  $this->pdf->SetTextColor(0,0,0);
  $this->pdf->Text(10,100,utf8_decode('Estos son los días que le ha asignado el administrador para trabajar.'));
  for ($i=1; $i<=$cantidadDias-1 ; $i++){
    $multiplo = $cantidadDias-1;
     $contador= $contador + 10;
     $contador2 = $contador2+2;
     $y = 85;
    if($i==1){
      $this->pdf->SetY(105);
      $this->pdf->SetX(10);
      $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
    }else if($i==2){
      $valort = 60;
      $this->pdf->SetY(105);
      $this->pdf->SetX($valort);
      $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
    }else if($i==3){
      $valor = $valor + 110;
      $acumulador = $acumulador+(0+50);
      $this->pdf->SetXY($valor,105);
      $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
    }
    else if($i==4){
      $valor = 10;
      $acumulador = $acumulador+(0+50);
      $this->pdf->SetXY(10,120);
      $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
 }
  else if($i==5){
  $valor = $valor + 10;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(60,120);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==6){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(110,120);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==7){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(10,135);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==8){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(60,135);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}

else if($i==9){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(110,135);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==10){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(10,150);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==11){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(60,150);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==12){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(110,150);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==13){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(10,165);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==14){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(60,165);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
else if($i==15){
  $valor = $valor + 60;
  $acumulador = $acumulador+(0+50);
  $this->pdf->SetXY(110,165);
  $this->pdf->Cell(50,15,'día '.$i.': '.$diasexcel[$i],1,0,'C',false);
}
}
$this->pdf->Text(2,195,utf8_decode('Nota: tenga en cuenta, que con base a esta programación seran asignadas las citas ha pacientes.'));
$this->pdf->Output(APP."Controller/Programacion/Programacion.pdf",'F');
$this->pdf->Output();
    }


    function Header($pdf)
{
    // Select Arial bold 15
    $pdf->Image(URL.'Public\Img\Todos\LogoPDF.png',5,5,-300);
    //Arial bold 15
    $pdf->SetFont('Arial','B',15);
    //Movernos a la derecha
    $pdf->SetY(15);
    $pdf->Cell(80);
    //Título
    $pdf->Cell(37,10,'Programación',0,0,'C');
    $pdf->Cell(100,10,'Fecha: '.date('Y-m-d'),0,0,'C');
    $pdf->Line(10,33,$pdf->GetPageWidth()-10,33);
    //Salto de línea
    $pdf->Ln(20);
}
}

?>
