<?php

require (APP.'/Lib/fpdf/fpdf.php');


class PDF extends FPDF
{

  var $col=0;
  var $y=0;




  function Header()
  {

    $this->Image('../Public/Img/ReporteAPH/medellin.png',90,8,33);

    $this->SetFont('Arial','B',10);
    $this->SetTextColor(66,66,66);
    $this->Cell(142);

    $this->SetFont('Arial','B',8);
    $this->Cell(30,10,'Cod. Reporte',10,0,'L');
    $this->Cell(10,10,'#101',0,0,'L');
    $this->Ln(5);
    $this->Cell(142);
    $this->Cell(30,10,'Cod. Paciente',0,0,'L');
    $this->Cell(10,10,'#02',0,0,'L');
    $this->Ln(8);

    $this->SetFont('Arial','B',10);
    $this->Cell(0,10,'REPORTE DE ATENCION PREHOSPITALARIA',0,1,'C');
    $this->Ln(10);

  }

  function Footer()
  {
    // Pie de página
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'C');
  }




  public function body()
  {


    $this->SetDrawColor(170);
    $this->SetTextColor(0,168,167);
    $this->Cell(0,6,'1.  InformacionGeneral',1,0,'C');
    $this->Ln(8);
    $this->SetTextColor(66,66,66);
    //$this->SetXY(20,20);

    $this->SetTextColor(66,66,66);
    $this->SetFont('Arial','B',10);
    $this->Cell(16,6,'Fecha:',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'2016/02/04',0,0,'L');
    $this->SetX(120);
    $this->SetFont('Arial','B',10);
    $this->Cell(35,6,'Hora de Despacho',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'2016/25/02 02:45:00',0,0,'L');
    $this->Ln(5);
    $this->SetX(120);
    $this->SetFont('Arial','B',10);
    $this->Cell(35,6,'Arribo a la Escena',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'2016/25/02 02:45:00',0,0,'L');
    $this->Ln(5);
    $this->SetX(120);
    $this->SetFont('Arial','B',10);
    $this->Cell(35,6,'Arribo a IPS',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'2016/25/02 02:45:00',0,0,'L');
    $this->Ln(5);
    $this->SetX(120);
    $this->SetFont('Arial','B',10);
    $this->Cell(35,6,'Fin de la Atencion',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'2016/25/02 02:45:00',0,0,'L');
    $this->Ln(6);
    $this->SetFont('Arial','B',10);
    $this->Cell(42,6,'Ubicacion del incidente:',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'Crr70 call 103D-02',0,0,'L');
    $this->Ln(6);
    $this->SetFont('Arial','B',10);
    $this->Cell(35,6,'Punto de referencia:',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20,6,'SENA',0,0,'L');
    $this->Ln(6);
    $this->SetFont('Arial','B',10);
    $this->Cell(35,5,'Informacion Inicial:',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Write(5,'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis amet eaque enim, quaerat, minima magnam facere alias adipisci et atque, sint nisi rerum voluptatibus repudiandae. Quibusdam veniam quas, quaerat beatae.
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ducimus voluptas totam harum sequi, accusantium modi deleniti, quae amet rerum aut necessitatibus aliquid. Velit molestias libero doloribus repudiandae saepe, inventore.');
    $this->Ln(6);
    $this->SetFont('Arial','B',10);
    $this->Cell(49,6,'Clasificacion de la atencion:',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(25,6,'Emergencia',0,0,'L');

    $this->SetX(120);
    $this->SetFont('Arial','B',10);
    $this->Cell(49,6,'Personal que atiende:',0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Ln(6);
    $this->SetX(120);
    $this->Cell(50,6,'Santiago Giraldo Escudero',0,0,'L');
    $this->Ln(6);
    $this->SetX(120);
    $this->Cell(50,6,'Jose Angel Bermudez Puello',0,0,'L');
    $this->Ln(6);
    $this->SetX(120);
    $this->Cell(50,6,'Gabriel Jaime Marin Isaza',0,0,'L');
    $this->Ln(8);
    $this->SetDrawColor(170);
    $this->SetTextColor(0,168,167);
    $this->SetFont('Arial','B',10);
    $this->Cell(0,6,'2.  Tipo de Evento',1,0,'C');
    $this->SetTextColor(66,66,66);
    $this->Ln(8);
    $this->Cell(75,6,'Eventos:',0,0,'C');
    $this->SetX(120);
    $this->Cell(0,6,'Clasificacion triage:',0,0,'C');
    $this->SetFont('Arial','',10);
    $this->Ln(6);
    $this->SetX(120);
    $this->Cell(0,6,'Amarillo',0,0,'C');
    $this->Ln(1);
    $ejemplo = array("Acc de Transito" ,"Atrapamiento", "Caida", "Ambiental", "Golpe-impacto", "Enfermedad", "Explocion" );
    $con = 1;
    foreach ($ejemplo as $value) {

      $this->Cell(46,6,$value,0,0,'L');

      if ($con%2==0) {
        $this->Ln(6);
      }
      $con ++;
    }
    $this->Ln(8);
    $this->SetDrawColor(170);
    $this->SetTextColor(0,168,167);
    $this->SetFont('Arial','B',10);
    $this->Cell(0,6,'3.  Identificacion del paciente',1,0,'C');
    $this->Ln(6);
    $this->SetTextColor(66,66,66);
    $this->Cell(40,10,"Nombre del Paciente:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(55,10,"Juan Jose Rodriguez Perez",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(20,10,"Eda:",0,0,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(10,10,"22",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(20,10,"Genero:",0,0,'C');
    $this->SetFont('Arial','',10);
    $this->Cell(20,10,"Masculino",0,0,'L');
    $this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->Cell(36,10,"Tipo de documento:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(45,10,utf8_decode("Documento de Extranjería"),0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(43,10,"Numero de documento:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(40,10,"1035439815",0,0,'L');
    $this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->Cell(20,10,"Direccion:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(45 ,10,"Crr 50 #45 cll 120",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(20,10,"Municipio:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(35,10,"Medellin",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(16,10,"Barrio:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(25,10,"Pedregal",0,0,'L');
    $this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->Cell(20,10,"Telefono:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20 ,10,"254585",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(25,10,"Estado Civil:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(35,10,"1035439815",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(42,10,"Fecha de nacimiento:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(30,10,"28/01/1998",0,0,'L');
    $this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->Cell(20,10,"Ocupacion:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(35,10,"Programador",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(26,10,utf8_decode("Acompañante:"),0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(50,10,utf8_decode("Pedro Juan Perez"),0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(18,10,"Telefono:",0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(20 ,10,"254585",0,0,'L');
    $this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->Cell(25,10,utf8_decode("Identificación:"),0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(35,10,"1035818564",0,0,'L');
    $this->SetFont('Arial','B',10);
    $this->Cell(22,10,utf8_decode("Parentesco:"),0,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(26,10,utf8_decode("Hermano"),0,0,'L');
    $this->Ln(16);
    $this->SetDrawColor(170);
    $this->SetTextColor(0,168,167);
    $this->SetFont('Arial','B',10);
    $this->Cell(0,6,'4.  Cuidados antes del arribo',1,0,'C');
    $this->Ln(6);
    $cuidados = array('Médico','policia','bombero','otro');
    $con = 1;
    $this->SetTextColor(66);
    $this->SetFont('Arial','',10);
    foreach ($cuidados as $key => $value) {
      $this->Cell(42,10,''.utf8_decode($value),0,0,'L');
      if(fmod($con, 4) == 0){
        $this->Ln(10);

      }
      $con++;
    }
    $this->AddPage();
    $this->SetDrawColor(170);
    $this->SetTextColor(0,168,167);
    $this->SetFont('Arial','B',10);

    $this->Cell(130,6,'5.  Motivo de consulta',1,0,'C');
    $this->Cell(50,6,'6.  Tipo aseguradora',1,1,'C');
    $this->Ln(4);
    $this->SetTextColor(66);
    $this->Cell(65,6,utf8_decode("5.1.  Urgencia médica"),1,0,'C');
    $this->Cell(65,6,utf8_decode("5.1.  Urgencia traumatica"),1,0,'C');
    $this->Cell(50,6,utf8_decode("EPS"),1,1,'C');
      $this->SetTextColor(0,168,167);
      $this->SetX(150);
    $this->Cell(50,6,utf8_decode("7.En caso de Acc. de tránsito"),1,1,'C');
    $this->Ln(2);
    $this->SetX(150);
    $this->SetTextColor(66);
    $this->SetFont('Arial','B',10);
    $this->Cell(20,8,utf8_decode("Afectado:"),1,0,'L');
    $this->SetFont('Arial','',10);
    $this->Cell(30,8,utf8_decode("Peatón"),1,1,'L');
    $this->SetX(150);
    $this->SetFont('Arial','B',10);
    $this->Cell(30,8,utf8_decode("Placa:"),1,0,'L');
    $this->SetFont('Arial','',10);
      $this->Cell(20,8,utf8_decode("GJK3L"),1,1,'L');
      $this->SetFont('Arial','B',10);
      $this->SetX(150);
      $this->Cell(50,8,utf8_decode("Código aseguradora"),1,1,'L');
      $this->SetX(150);
      $this->SetFont('Arial','',10);
      $this->Cell(50,8,utf8_decode("G45D6"),1,1,'L');
      $this->SetX(150);
      $this->SetFont('Arial','B',10);
      $this->Cell(50,8,utf8_decode("Nùmero de poliza"),1,1,'L');
      $this->SetFont('Arial','',10);
      $this->SetX(150);
      $this->Cell(50,8,utf8_decode("120100120"),1,1,'L');
    $this->Ln(6);

    $Utraumatica = array('Pie y anexos','cardio repiratorio','metabolica','reaccion alerjica','Pie y anexos','cardio repiratorio','metabolica');
    $Umedica = array('Cardio vascular','Pie y anexos','Abdominal','cervical');

    $salto = 0;
    $der = 0;
    $con = 1;
    $total = 0;
    $comenzar = 0;
      foreach ($Umedica as  $value) {
        $this->SetXY(20+$der,69+$salto);

        if ($con%2==0) {
          $salto = $salto + 10;
          $der = 0;
          $total =  $salto;
        }else {
          $der = 32.5;
        }

        $con++;
        $this->Cell(32.5,10,$value,1,1,'C');
      }
      $total = $total-69;
      $der = 0;
      $con = 1;
      foreach ($Utraumatica as  $value) {
        $this->SetXY(85+$der,-$total+$salto);

        if ($con%2==0) {
          $salto = $salto + 10;
          $der = 0;
        }else {
          $der = 32.5;
        }
        $con++;
        $this->Cell(32.5,10,$value,1,1,'C');
      }

      $this->SetDrawColor(170);
      $this->SetTextColor(0,168,167);
      $this->SetFont('Arial','B',10);
     $this->Cell(0,6,'4.  Cuidados antes del arribo',1,0,'C');

  //  $this->Cell(85,6,utf8_decode($es),1,1,'C');




  }




}


$pdf = new PDF();
$title = 'ReporteAPH';
$pdf->SetTitle($title);


$pdf->AddPage();
$pdf->SetMargins(20,20,20);
$pdf->body();




$pdf->Output('ReporteAPH_PDF.pdf','I',True);
?>
