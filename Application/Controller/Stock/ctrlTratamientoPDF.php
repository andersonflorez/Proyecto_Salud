<?php

require_once(APP.'Lib/Fpdf/fpdf.php');


class ctrlTratamientoPDF extends Controller
{

  private $FPDF;
  private $modelo = NULL;
    function __construct(){
      $this->FPDF = new FPDF('P','mm','Legal');
      $this->modelo = $this->loadModel('Stock', 'mdlTratamientoPDF');

    }

    public function Reporte($ID)
    {
      $id = base64_decode($ID);
      $title = 'Reporte Prestamos';
      $this->FPDF->SetTitle($title);
      //$idAtencion = base64_decode($ID);
      $this->FPDF->AddPage();
      $this->FPDF->SetMargins(20,20,20);
      $this->Header($id);
      $this->body($id);
      $this->Footer();
      $this->FPDF->Output('ReportePrestamo_PDF.pdf','I');
    }

function Header($id)
{
/*
$this->FPDF->Image('../Public/Img/Todos/logoPDF.png',90,8,33);

$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->SetTextColor(66,66,66);
$this->FPDF->Cell(142);

$consultarHc = $this->modelo->consultarHc($id);
$this->FPDF->SetFont('Arial','B',8);

$this->FPDF->Ln(13);

$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(80);
$this->FPDF->Cell(30,10,'REPORTE DE PRESTAMOS',0,0,'C');
$this->FPDF->Ln(5);*/


//Encabezado

    $this->FPDF->SetTitle('Despacho ');
    $this->FPDF->Image(URL. 'Public/Img/Todos/LogoPDF.png', 10, 7, 40, 0,'PNG');
    $this->FPDF->SetFont('Arial','B', 20);
    $this->FPDF->SetTextColor(40, 40, 40);
    $this->FPDF->Cell(-1.6, 8, '', 0);
    $this->FPDF->ln(6);
    $this->FPDF->Cell(0, 8, 'Reporte Prestamos' ,'B',1,'R');
    $this->FPDF->ln(15);
    //Fin Encabezado
}

function Footer()
{
    // Pie de página
    $this->FPDF->SetY(-1);
    $this->FPDF->SetFont('Arial','I',8);
    $this->FPDF->SetTextColor(128);
    $this->FPDF->Cell(0,10,utf8_decode('Página '.$this->FPDF->PageNo()),0,0,'C');
}

 function body($id)
{
  $consultarDetalleTratamiento = $this->modelo->consultarDetalleTratamiento();
  $consultarTratamiento = $this->modelo->consultarTratamiento($id);
  $consultarHc = $this->modelo->consultarHc($id);
  $this->FPDF->Ln(8);
  $this->FPDF->SetDrawColor(170);
   $this->FPDF->SetTextColor(0,168,167);
   $this->FPDF->SetFont('Arial','B',10);
  $this->FPDF->Cell(0,10,'1.  Informacion de la asignacion',1,0,'L');
  $this->FPDF->Ln(10);
  $this->FPDF->SetTextColor(66,66,66);
  //$this->FPDF->SetXY(20,20);

  $this->FPDF->SetTextColor(66,66,66);
  $this->FPDF->SetFont('Arial','B',10);
  $this->FPDF->Cell(40,10,'Fecha',1,0,'L');
  $this->FPDF->SetFont('Arial','',10);
  $this->FPDF->Cell(48,10,$consultarHc->fechaHoraAsignacion,1,0,'L');
  //$this->FPDF->SetFont('Arial','',10);
  $this->FPDF->SetFont('Arial','B',10);
  $this->FPDF->Cell(45,10,'Estado de la asignación',1,0,'L');
  $this->FPDF->SetFont('Arial','',10);
  $this->FPDF->Cell(43,10,$consultarHc->estadoTablaAsignacionKit,1,0,'L');



  //$this->FPDF->Cell(20,6,'2016/02/04',0,0,'L');

  $this->FPDF->SetFont('Arial','B',10);

  $this->FPDF->SetFont('Arial','',10);
  $this->FPDF->ln(2);
  $this->FPDF->SetFont('Arial','B',10);
  $this->FPDF->Cell(43,10,'');


  //$this->FPDF->Cell(20,6,'2016/25/02 02:45:00',0,0,'L');

$this->FPDF->Ln(8);
$this->FPDF->SetDrawColor(170);
 $this->FPDF->SetTextColor(0,168,167);
 $this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(0,10,'2.  Información del paciente',1,0,'L');
$this->FPDF->Ln(10);
$this->FPDF->SetTextColor(66,66,66);
$this->FPDF->Cell(40,10,"Nombre del Paciente:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(48,10,$consultarHc->primerNombre,1,0,'L');
$this->FPDF->SetFont('Arial','',10);
//$this->FPDF->Cell(55,10,"Johan Stiven Hernandez",0,0,'L');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(15,10,"Edad:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(20,10,$consultarHc->edadPaciente,1,0,'L');

//$this->FPDF->Cell(10,10,"18",0,0,'L');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(20,10,"Genero:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(33,10,$consultarHc->genero,1,0,'L');
$this->FPDF->SetFont('Arial','',10);
//$this->FPDF->Cell(20,10,"Masculino",0,0,'L');
$this->FPDF->Ln(10);
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(40,10,"Tipo de documento:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(48,10,$consultarHc->descripcionTdocumento,1,0,'L');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(45,10,"Número de documento:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(43,10,$consultarHc->numeroDocumento,1,0,'L');
//$this->FPDF->Cell(40,10,"1035439806",0,0,'L');
$this->FPDF->Ln(10);
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(40,10,"Dirección:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(48,10,$consultarHc->direccion,1,0,'L');
//$this->FPDF->Cell(45 ,10,"Crr 60A #49 A 27",0,0,'L');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(45,10,"Municipio:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(43,10,$consultarHc->ciudadResidencia,1,0,'L');
$this->FPDF->Ln(10);
//$this->FPDF->Cell(35,10,"Copacabana",0,0,'L');
//$this->FPDF->Cell(25,10,"Asuncion",0,0,'L');

//$this->FPDF->Cell(20 ,10,"4011557",0,0,'L');

$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(40,10,"Ocupacion:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(48,10,$consultarHc->ocupacion,1,0,'L');
//$this->FPDF->Cell(35,10,"Programador",0,0,'L');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(45,10,"Telefono:",1,0,'L');
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Cell(43,10,$consultarHc->telefonoFijo,1,0,'L');
$this->FPDF->ln(10);
$MSJ = $consultarHc->enfermedadActual;
$cont = 0; $alt = 19;
while ($cont <= strlen($MSJ)) {
  $cont +=100;
  $alt+=5;
}
$this->FPDF->Cell(0,$alt,"",1,0,'L');
$this->FPDF->Ln(6);
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Write(4,$MSJ);
$this->FPDF->setXY(20,115);
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(170,10,"Enfermedad Actual",0,0,'L');
$this->FPDF->ln($alt+1);

// tratamiento$alt
$salto= $alt;

$MSJ2 = $consultarTratamiento->descripcionTratamiento;
$cont = 0; $alt = 18;
while ($cont <= strlen($MSJ2)) {
  $cont +=100;
  $alt+=6;
}
$this->FPDF->Cell(0,$alt,"",1,0,'L');
$this->FPDF->Ln(7);
$this->FPDF->SetFont('Arial','',10);
$this->FPDF->Write(4,$MSJ2);
$this->FPDF->setXY(20,115+$salto);
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(0,11,"Tratamiento",0,0,'L');
$this->FPDF->ln($alt+1);
//tabla
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(50,10,'Implemento',1,0,'C');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(40,10,'Cantidad',1,0,'C');
$this->FPDF->SetFont('Arial','B',10);
$this->FPDF->Cell(86,10,'Descripción',1,0,'C');
$this->FPDF->ln(10);


foreach ($consultarHc as $key => $value) {
  $this->FPDF->SetFont('Arial','',10);
  $this->FPDF->Cell(50,10,$consultarHc->nombre,1,0,'C');
  $this->FPDF->SetFont('Arial','',10);
  $this->FPDF->Cell(40,10,$consultarHc->cantidadAsignada,1,0,'C');
  $this->FPDF->SetFont('Arial','',10);
  $this->FPDF->Cell(86,10,$consultarHc->descripcion,1,1,'C');
}




$this->FPDF->SetDrawColor(170);
 $this->FPDF->SetTextColor(0,168,167);
 $this->FPDF->SetFont('Arial','B',10);

}
/*
public function consultarMedicacion($idAtencion){
  $consultarMedicacion = this->modelo->consultarMedicacion($idAtencion);


}
  function consultarInformacionPersonal($idAtencion){
    $consultarInformacionPersonal = this->consultarInformacionPersonal($idAtencion);
  }


*/
}




?>
