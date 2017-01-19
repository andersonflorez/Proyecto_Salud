<?php

/**
* NOMBRE DE LA CLASE: CtrlPdf
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Se encarga de Generar un reporte de la información de un despacho.
*/
require APP . 'Lib/fpdf/fpdf.php';

class CtrlPdf extends Controller implements iController {

//Variables los modelos y para el fpdf.
  private $objListarDespacho;
  private $reportePDF;
  private $idDespacho;


  public function __construct() {

    $this->reportePDF = new FPDF();
    $this->objListarDespacho = $this->loadModel('Despachador','mdlListarDespacho');
  }
  public function Index(){
    // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
    // las dos siguientes lineas de código:

    header('Location: '.URL.'Error/Error');
  }

  //Funcion para reporte de despacho.
  public function reporteDespacho($idDespacho){
    $this->objListarDespacho->SetIdDespacho($idDespacho);

    //Extraccion de los datos del reporte.
    $consultaReporte = $this->objListarDespacho->datosReporte();
    $codigoDespacho = $this->AgregarCeros($consultaReporte->idDespacho);
    $codigoReporteInicial = $consultaReporte->idReporteInicial;
    $placaAmbulancia = $consultaReporte->placaAmbulancia;
    $fechaDespacho = date_create($consultaReporte->fechaHoraDespacho);
    $estadoDespacho = $consultaReporte->estadoDespacho;
    $ubicacionIncidente = $consultaReporte->ubicacionIncidente;
    $puntoReferencia = $consultaReporte->puntoReferencia;
    $fechaHoraAproximadaEmergencia = date_create($consultaReporte->fechaHoraAproximadaEmergencia);
    $fechaHoraEnvioReporteInicial = date_create($consultaReporte->fechaHoraEnvioReporteInicial);
    $informacionInicial = $consultaReporte->informacionInicial;
    $descNovedad = $consultaReporte->descripcionNovedad;
    $primerNombreP = $consultaReporte->primerNombre;
    $primerApellidoP = $consultaReporte->primerApellido;
    $especialidad = $consultaReporte->descripcionRol;
    $lesionadosReporte = $consultaReporte->numeroLesionados;
    $lesionadosNovedad = $consultaReporte->numeroLesionadosNovedad;
    $nombreDespachador = $consultaReporte->despachador;
    $cargoPersonaLider = $consultaReporte->CargoPersona;
    date_default_timezone_set('America/Bogota');
    $timestamp = date("Y-m-d");
    //Maqueta PDF
    //Encabezado
    $this->reportePDF->AddPage();
    $this->reportePDF->SetTitle('Despacho '.$codigoDespacho);
    $this->reportePDF->Image(URL. 'Public/Img/Todos/LogoPDF.png', 10, 7, 40, 0,'PNG');
    $this->reportePDF->SetFont('Arial','B', 20);
    $this->reportePDF->SetTextColor(40, 40, 40);
    $this->reportePDF->Cell(-1.6, 8, '', 0);
    $this->reportePDF->ln(6);
    $this->reportePDF->Cell(0, 8, 'Fecha Despacho '. $timestamp,'B',1,'R');
    $this->reportePDF->ln(15);
    //Fin Encabezado

    //Cuerpo

    //Reporte Inicial

  $this->reportePDF->SetDrawColor(170);
   $this->reportePDF->SetTextColor(0,168,167);
   $this->reportePDF->SetFont('Arial','B',12);
   $this->reportePDF->Cell(0,10,'INFORMACION INICIAL',1,0,'C');
    $this->reportePDF->ln(10);



   $MSJ = $informacionInicial;
$cont = 0; $alt = 18;
while ($cont <= strlen($MSJ)) {
  $cont +=100;
  $alt+=3;
}
$this->reportePDF->Cell(0,$alt,"",1,0,'L');
$this->reportePDF->Ln(1);
$this->reportePDF->SetTextColor(66,66,66);
$this->reportePDF->SetFont('Arial','B',12);
$this->reportePDF->Cell(43, 6, 'Descripcion Reporte:', 0,0);
$this->reportePDF->SetTextColor(66,66,66);
$this->reportePDF->SetFont('Arial','',12);
$this->reportePDF->Write(6,$MSJ);

$this->reportePDF->ln($alt+2);
$this->reportePDF->SetTextColor(66,66,66);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, utf8_decode('Ubicación del incidente:'), 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, utf8_decode($ubicacionIncidente), 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, 'Punto de referencia:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, $puntoReferencia, 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, 'Fecha aproximada de la emergencia:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, date_format($fechaHoraAproximadaEmergencia,'d/m/Y H:i:s'), 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, 'Fecha envio Reporte Inicial:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, date_format($fechaHoraEnvioReporteInicial,'d/m/Y H:i:s'), 1,1);
      $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, utf8_decode('Numero de lesionados:'), 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, utf8_decode($lesionadosReporte), 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, utf8_decode('Novedad del Reporte:'), 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, utf8_decode($descNovedad), 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(79, 10, utf8_decode('Numero de lesionados en la Novedad:'), 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, utf8_decode($lesionadosNovedad), 1,1);
    $this->reportePDF->ln(13);


    //Despacho
    $this->reportePDF->SetDrawColor(170);
     $this->reportePDF->SetTextColor(0,168,167);
     $this->reportePDF->SetFont('Arial','B',12);
     $this->reportePDF->Cell(0,10,'DESPACHO',1,0,'C');
    $this->reportePDF->ln(10);

    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->SetTextColor(66,66,66);
    $this->reportePDF->Cell(58, 10, 'Fecha de despacho:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, date_format($fechaDespacho, 'd/m/Y H:i:s'), 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(58, 10, 'Placa ambulancia:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, $placaAmbulancia, 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(58, 10, 'Estado de despacho:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, $estadoDespacho, 1,1);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(58, 10, 'Responsable del Despacho:', 1,0);
    $this->reportePDF->SetFont('Arial','',12);
    $this->reportePDF->Cell(0, 10, $nombreDespachador, 1,1);
    $this->reportePDF->ln(14);
    $this->reportePDF->SetDrawColor(170);
     $this->reportePDF->SetTextColor(0,168,167);
     $this->reportePDF->SetFont('Arial','B',12);
     $this->reportePDF->Cell(0,10,'LÍDER DE LA AMBULANCIA',1,0,'C');
    $this->reportePDF->ln(10);
    $this->reportePDF->SetTextColor(66,66,66);
    $this->reportePDF->Cell(58, 10, 'Nombre:', 1,0);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(0, 10, $primerNombreP, 1,1);
    $this->reportePDF->Cell(58, 10, 'Apellido:', 1,0);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(0, 10, $primerApellidoP, 1,1);
    $this->reportePDF->Cell(58, 10, 'Especialidad:', 1,0);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(0, 10, $especialidad, 1,1);
    $this->reportePDF->Cell(58, 10, 'Cargo:', 1,0);
    $this->reportePDF->SetFont('Arial','B',12);
    $this->reportePDF->Cell(0, 10, $cargoPersonaLider, 1,1);



    $modo="I";
    $nombreArchivo = 'ReporteDespacho_'.$codigoDespacho;
    $this->reportePDF->OutPut($modo,'ReporteDespacho_.pdf', 'D');



  }


  //Función para agregar ceros a la izquierda de cada código de reporte:
  private function AgregarCeros($string) {
  return strlen($string) < 4 ? $this->agregarCeros("0$string") : $string;
}


}

?>
