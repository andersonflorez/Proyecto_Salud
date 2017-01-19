<?php
require_once(APP.'Lib/Fpdf/fpdf.php');

class ctrlEstructuraPDF extends Controller
{

  private $objModelo = null;
  function __construct(){
    $this->objModelo = $this->loadModel('ReporteAPH', 'mdlGenerarReporteAPH');
  }


  //Cabecera de página
  function Header($pdf,$idReporteAPH){

    $consulta = $this->objModelo->consultarReporteAPH($idReporteAPH);
    $codPaciente = $consulta->idPAciente;
    $codReporte = $consulta->idReporteAPH;
    if ($codPaciente < 10) {
      $codPaciente = "00".$codPaciente;
    }else if($codPaciente > 9 && $codPaciente < 100){
      $codPaciente = "0".$codPaciente;
    }else {
      $codPaciente = $codPaciente;
    }
    if ($codReporte < 10) {
      $codReporte = "00".$codReporte;
    }else if($codReporte > 9 && $codReporte < 100){
      $codReporte = "0".$codReporte;
    }else {
      $codReporte = $codReporte;
    }

    $pdf->Image('../Public/Img/ReporteAPH/medellin.png',90,8,33);
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(66,66,66);
    $pdf->Cell(142);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,10,'Cod. Reporte',10,0,'L');
    $pdf->Cell(10,10,'#'.$codReporte,0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(142);
    $pdf->Cell(30,10,'Cod. Paciente',0,0,'L');
    $pdf->Cell(10,10,'#'.$codPaciente,0,0,'L');
    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,10,'REPORTE DE ATENCION PREHOSPITALARIA',0,1,'C');
    $pdf->Ln(10);

  }

    function Footer($pdf){
    // Pie de página
    $pdf->SetY(-15);
    $pdf->SetFont('Arial','I',8);
    $pdf->SetTextColor(128);
    $pdf->Cell(0,10,'Página '.$pdf->PageNo(),1,0,'C');
  }

  public function body($pdf,$idReporteAPH){
    $consulta = $this->objModelo->consultarReporteAPH($idReporteAPH);
    $antecedentes = $this->objModelo->ConsultarAntecedentesAPH($idReporteAPH);
    $motivosConsulta = $this->objModelo->ConsultarMotivoConsultaAPH($idReporteAPH);

    foreach ($consulta as $key => $value) {

      if ($value == null || $value == "") {
        $consulta->$key = "* * * * * * ";
      }
    }





   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(0,168,167);
   $pdf->Cell(0,6,'1.  Información General',1,0,'C');
   $pdf->Ln(8);
   $pdf->SetTextColor(66,66,66);
   //$pdf->SetXY(20,20);

   $pdf->SetTextColor(66,66,66);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(16,6,'Fecha:',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,'2016/02/04',0,0,'L');
   $pdf->SetX(120);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,6,'Hora de Despacho',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->fechaHoraDespacho,0,0,'L');
   $pdf->Ln(5);
   $pdf->SetX(120);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,6,'Arribo a la Escena',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->fechaHoraArriboEscena,0,0,'L');
   $pdf->Ln(5);
   $pdf->SetX(120);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,6,'Arribo a IPS',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->fechaHoraArriboIPS,0,0,'L');
   $pdf->Ln(5);
   $pdf->SetX(120);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,6,'Fin de la Atención',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->fechaHoraFinalizacion,0,0,'L');
   $pdf->Ln(6);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(42,6,'Ubicación del incidente:',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->ubicacionIncidente,0,0,'L');
   $pdf->Ln(6);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,6,'Punto de referencia:',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->puntoReferencia,0,0,'L');
   $pdf->Ln(6);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,5,'Información Inicial:',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Write(5,$consulta->informacionInicial);
   $pdf->Ln(6);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(49,6,'Clasificación de la atención:',0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(25,6,'Emergencia',0,0,'L');
   $personal = explode("-",$consulta->nombrePersonal);
   $pdf->SetX(120);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(49,6,'Personal que atiende:',0,0,'L');
   $pdf->SetFont('Arial','',10);
   foreach ($personal as $value) {
     $pdf->Ln(6);
     $pdf->SetX(120);
     $pdf->Cell(50,6,$value,0,0,'L');
   }
   $pdf->Ln(12);
   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(0,168,167);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(0,6,'2.  Tipo de Evento',1,0,'C');
   $pdf->SetTextColor(66,66,66);
   $pdf->Ln(8);
   $pdf->Cell(75,6,'Eventos:',0,0,'C');
   $pdf->SetX(120);
   $pdf->Cell(0,6,'Clasificacion triage:',0,0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->Ln(6);
   $pdf->SetX(120);
   $pdf->Cell(0,6,$consulta->descripcionTriage,0,0,'C');
   $pdf->Ln(1);
   $tiposEventos = Explode(",",$consulta->tipoEvento);
   $con = 1;
   foreach ($tiposEventos as $value) {

     $pdf->Cell(46,6,$value,0,0,'L');

     if ($con%2==0) {
       $pdf->Ln(6);
     }
     $con ++;
   }
   $pdf->Ln(12);
   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(0,168,167);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(0,6,'3.  Identificacion del paciente',1,0,'C');
   $pdf->Ln(6);
   $pdf->SetTextColor(66,66,66);
   $pdf->Cell(40,10,"Nombre del Paciente:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(55,10,$consulta->nomrePaciente,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,10,"Edad:",0,0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(10,10,$consulta->edadPaciente,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,10,"Genero:",0,0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,10,$consulta->genero,0,0,'L');
   $pdf->Ln(10);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(36,10,"Tipo de documento:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(45,10,$consulta->descripcionTDocumento,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(43,10,"Numero de documento:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(40,10,$consulta->numeroDocumento,0,0,'L');
   $pdf->Ln(10);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,10,"Direccion:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(45 ,10,$consulta->direccion,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,10,"Municipio:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(35,10,$consulta->ciudadResidencia,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(16,10,"Barrio:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(25,10,$consulta->barrioResidencia,0,0,'L');
   $pdf->Ln(10);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,10,"Telefono:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30 ,10,$consulta->telefonoFijo,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(25,10,"Estado Civil:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(35,10,$consulta->estadoCivil,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(42,10,"Fecha de nacimiento:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,10,$consulta->fechaNacimiento,0,0,'L');
   $pdf->Ln(10);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(25,10,"Ocupacion:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(35,10,$consulta->ocupacion,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(26,10,"Acompañante:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(50,10,"Pedro Juan Perez",0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(18,10,"Telefono:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20 ,10,"254585",0,0,'L');
   $pdf->Ln(10);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(25,10,"Identificación:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(35,10,$consulta->identificacionA,0,0,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(22,10,utf8_decode("Parentesco:"),0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(26,10,utf8_decode("Hermano"),0,0,'L');
   $pdf->Ln(16);
   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(0,168,167);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(0,6,'4.  Cuidados antes del arribo',1,0,'C');
   $pdf->Ln(6);
   $cuidados = Explode(",",$consulta->cuidadoAntesArribo);
   $con = 1;
   $pdf->SetTextColor(66);
   $pdf->SetFont('Arial','',10);
   foreach ($cuidados as $key => $value) {
     $pdf->Cell(42,10,''.($value),0,0,'L');
     if(fmod($con, 4) == 0){
       $pdf->Ln(10);

     }
     $con++;
   }
   $pdf->AddPage();
   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(0,168,167);
   $pdf->SetFont('Arial','B',10);

   $pdf->Cell(140,6,'5.  Motivo de consulta',1,0,'C');
   $pdf->Cell(50,6,'6.  Tipo aseguradora',1,1,'C');
   $pdf->Ln(4);
   $pdf->SetTextColor(66);
   $pdf->Cell(70,6,"5.1.  Urgencia médica",0,0,'C');
   $pdf->Cell(70,6,"5.1.  Urgencia traumatica",0,0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(50,6,$consulta->DescripcionTipoAseguramiento,0,1,'C');
   $pdf->SetFont('Arial','B',10);
   $pdf->SetTextColor(0,168,167);
   $pdf->SetX(150);
   $pdf->Cell(50,6,"7.En caso de Acc. de tránsito",1,1,'C');
   $pdf->Ln(2);
   $pdf->SetX(150);
   $pdf->SetTextColor(66);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,8,"Afectado:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,8,$consulta->descripcionAfectadoAccidenteTransito,0,1,'L');
   $pdf->SetX(150);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(20,8,"Placa:",0,0,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,8,$consulta->placaVehiculo,0,1,'L');
   $pdf->SetFont('Arial','B',10);
   $pdf->SetX(150);
   $pdf->Cell(50,8,"Código aseguradora",0,1,'L');
   $pdf->SetX(150);
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(50,8,$consulta->codigoAseguradora,0,1,'L');
   $pdf->SetX(150);
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(50,8,"Nùmero de poliza",0,1,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->SetX(150);
   $pdf->Cell(50,8,$consulta->numeroPoliza,0,1,'L');
   $pdf->Ln(6);
   $Utraumatica = array();
   $Umedica = array();
   foreach ($motivosConsulta as $key => $value) {
     if ($value->TipoMotivoConsulta == 'Urgencia Traumatica') {
       array_push($Utraumatica, $value->descripcionMotivoConsulta);
     }else {
       array_push($Umedica, $value->descripcionMotivoConsulta);
     }

   }

   $salto = 0;
   $der = 0;
   $con = 1;
   $total = 0;
   $comenzar = 0;
   foreach ($Umedica as  $value) {
     $pdf->SetXY(10+$der,26+$salto);

     if ($con%2==0) {
       $salto = $salto + 10;
       $der = 0;
       $total =  $salto;
     }else {
       $der = 35;
     }

     $con++;
     $pdf->Cell(35,10,$value,0,1,'C');
   }
   $total = $total-26;
   $der = 0;
   $con = 1;
   foreach ($Utraumatica as  $value) {
     $pdf->SetXY(80+$der,-$total+$salto);

     if ($con%2==0) {
       $salto = $salto + 10;
       $der = 0;
     }else {
       $der = 35;
     }
     $con++;
     $pdf->Cell(35,10,$value,0,1,'C');
   }
   $pdf->SetXY(10,26);
   $pdf->Cell(70,56,"",1,1,'C');
   $pdf->SetXY(80,26);
   $pdf->Cell(70,56,"",1,1,'C');
   $pdf->SetXY(150,32.2);
   $pdf->Cell(50,49.8,"",1,1,'C');
   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(0,168,167);
   $pdf->SetFont('Arial','B',10);
   $pdf->SetY(85);
   $pdf->Cell(0,6,"9.  Examen Físico",1,0,'C');
   $pdf->SetX(170);
   $pdf->SetTextColor(66);
   $pdf->Cell(10,6,"Hora:",0,0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(20,6,$consulta->horaExamenFisico,0,1,'C');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(34,7,"Respiración",0,0,'C');
   $pdf->Cell(34,7,"Pulso",0,0,'C');
   $pdf->Cell(34,7,"Presión Arterial",0,0,'C');
   $pdf->Cell(34,7,"Conciencia",0,0,'C');
   $pdf->Cell(54,7,"Pupilas",0,0,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(34,7,$consulta->respiracion_min."/min",0,1,'R');
   $pdf->Cell(34,7,$consulta->estadoRespiracion,0,1,'L');
   $pdf->Cell(34,10,$consulta->SpO2,0,1,'L');
   $pdf->SetFont('Arial','B',7);
   $pdf->SetXY(33,117);
   $pdf->Cell(10,5,"SpO2",0,1,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->SetXY(44,98);
   $pdf->Cell(34,7,$consulta->pulsaciones_min."/min",0,1,'R');
   $pdf->SetXY(44,105);
   $pdf->Cell(34,10,$consulta->estadoPulso,1,1,'L');
   $pdf->SetXY(78,98);
   $pdf->Cell(34,14,utf8_decode(""),1,1,'L');
   $pdf->Line(78,112,112,98);
   $pdf->SetXY(82,98);
   $pdf->Cell(5,5,$consulta->sistolica,0,1,'C');
   $pdf->SetXY(105,105);
   $pdf->Cell(5,5,$consulta->diastolica,0,1,'L');
   $pdf->SetXY(78,112);
   $pdf->Cell(34,10,$consulta->glucometria,0,1,'L');
   $pdf->SetFont('Arial','B',7);
   $pdf->SetXY(103,117);
   $pdf->Cell(10,5,"mg/dl",0,1,'L');
   $pdf->SetFont('Arial','',10);
   $pdf->SetXY(112,98);
   $pdf->Cell(34,10,$consulta->conciencia,0,1,'L');
   $pdf->SetXY(112,108);
   $pdf->Cell(34,10,$consulta->glasgow,0,1,'L');
   $pdf->SetFont('Arial','B',7);
   $pdf->SetXY(135,114);
   $pdf->Cell(11,5,"Glagow",0,1,'L');
   $pdf->SetFont('Arial','B',8);
   $pdf->SetXY(146,98);
   $pdf->Cell(27,7,"Derecha",0,1,'C');
   $pdf->SetXY(173,98);
   $pdf->Cell(27,7,"Izquierda",0,1,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->SetXY(146,105);
   $pdf->Cell(27,7,$consulta->estadoPupilaD,0,1,'L');
   $pdf->SetXY(173,105);
   $pdf->Cell(27,7,$consulta->estadoPupilaI,0,1,'L');
   $pdf->SetXY(146,112);
   $pdf->Cell(27,10,$consulta->gradoDilatacionPD,0,1,'C');
   $pdf->SetXY(173,112);
   $pdf->Cell(27,10,$consulta->gradoDilatacionPI,0,1,'C');
   $pdf->SetFont('Arial','B',7);
   $pdf->SetXY(166,116);
   $pdf->Cell(8,5,utf8_decode("mm"),0,1,'C');
   $pdf->SetXY(192,116);
   $pdf->Cell(8,5,utf8_decode("mm"),0,1,'C');
   $pdf->SetFont('Arial','',10);
   $pdf->SetDrawColor(170);
   $pdf->SetTextColor(66);
   $pdf->SetFont('Arial','B',10);
   $pdf->SetY(125);
   $pdf->Cell(80,6,"Piel",1,1,'C');
   $piel = Explode(",",$consulta->piel);
   $con = 1;
   $pdf->SetFont('Arial','',10);
   $pdf->SetTextColor(66);
   foreach ($piel as $key => $value) {
     $pdf->Cell(40,7,$value,1,0,'C');
     if(fmod($con, 2) == 0){
       $pdf->Ln(7);

     }
      $con++;
   }
   $pdf->SetTextColor(0,168,167);
   $pdf->SetFont('Arial','B',10);
   $pdf->SetXY(90,125);
   $pdf->Cell(30,6,"Estado",1,1,'C');
   $pdf->SetXY(90,131);
   $pdf->Cell(30,6,"hemodinámico ",1,1,'C');
   $pdf->SetXY(120,125);
   $pdf->Cell(80,6,"8.  Antecedentes",1,1,'C');

   $pdf->SetTextColor(66);
   $pdf->SetFont('Arial','',10);
    $pdf->Ln(5);
     $con = 1;
     $salto = 0;
     $lef = 0;
     if ($antecedentes != null) {
       foreach ($antecedentes as $value) {
         $pdf->SetXY(120+$lef,131+$salto);
         $pdf->Cell(40,7,$value->descripcion,1,0,'C');
        if(fmod($con, 2) == 0){
          $pdf->Ln(7);
          $salto = $salto + 7;
          $lef = 0;
        }else {
          $lef = 40;
        }

         $con++;
       }
     }else {
        $pdf->SetXY(120+$lef,131+$salto);
        $pdf->Cell(80,7,"Sin registros",1,0,'C');
     }





   //  $pdf->Cell(85,6,utf8_decode($es),1,1,'C');




 }
}


?>
