<?php

/**
* NOMBRE DE LA CLASE: CtrlFpdf
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN: Este controlador genera el PDF de los reportes
* iniciales de emergencia.
*/
class ctrlFpdf extends Controller implements iController{

  private $objFpdf;
  private $objReporteInicial;
  private $idReporteInicial;
  private $objNovedadReporteInicial;
  private $styles;
  private $scripts;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL . "error/error");
      exit();

    } else {

      $this->objReporteInicial = $this->loadModel('ReporteInicial', 'mdlReporteInicial');
      $this->objNovedadReporteInicial = $this->loadModel('ReporteInicial', 'mdlNovedadReporte');

    }

  }

  /**
  * Método Index() obligatorio
  * Renderiza la página de error debido a que la función principal GenerarPdf()
  * debe ser llamada al momento de descargar un PDF.
  */
  public function Index() {
    header('Location: '.URL.'Error/Error');
  }


  public function GenerarPdf($idReporteInicial) {

    require APP . 'Lib/fpdf/fpdf.php';

    $this->objFpdf = new FPDF();
    $this->objFpdf->AddPage();

    $this->objReporteInicial->__SET('idReporteInicial', $idReporteInicial);
    $PaqueteReporte = $this->objReporteInicial->ConsultarReporteInicial();
    $TiposEvento = $this->objReporteInicial->ConsultarTipoEventoReporteInicial();
    $EntesExternos = $this->objReporteInicial->ConsultarEnteExternoReporteInicial();
    $Novedades = $this->objNovedadReporteInicial->ConsultarNovedadesReporteInicial();


    $idReporteInicial = $PaqueteReporte->idReporteInicial;
    $idReporteVista = $this->AgregarCeros($PaqueteReporte->idReporteInicial);
    $informacionInicial = empty($PaqueteReporte->informacionInicial) ? 'No especificado' : $PaqueteReporte->informacionInicial;
    $ubicacionIncidente = empty($PaqueteReporte->ubicacionIncidente) ? 'No especificado' : $PaqueteReporte->ubicacionIncidente;
    $puntoReferencia = empty($PaqueteReporte->puntoReferencia) ? 'No especificado' : $PaqueteReporte->puntoReferencia;
    $numeroLesionados = empty($PaqueteReporte->numeroLesionados) ? 'No especificado' : $PaqueteReporte->numeroLesionados;
    $fechaEmergencia = $this->ExtraerFormatoFecha($PaqueteReporte->fechaHoraAproximadaEmergencia).' '.$this->ExtraerFormatoHora($PaqueteReporte->fechaHoraAproximadaEmergencia);
    $fechaEnvioReporte = $this->ExtraerFormatoFecha($PaqueteReporte->fechaHoraEnvioReporteInicial).' '.$this->ExtraerFormatoHora($PaqueteReporte->fechaHoraEnvioReporteInicial);
    $estadoReporteInicial = $PaqueteReporte->estadoTablaReporteInicial;

    $this->objFpdf->SetTitle('Reporte Inicial'.' '.$idReporteVista);

    $this->objFpdf->Image(URL. 'Public/Img/Todos/LogoPDF.png', 160, 7, 40, 0,'PNG');
    $this->objFpdf->SetFont('Arial','B', 15);
    $this->objFpdf->SetTextColor(60, 60, 60);
    $this->objFpdf->Cell(-1.6, 8, '', 0);
    $this->objFpdf->Cell(15, 8, 'Reporte Inicial'.' '. $idReporteVista, 0);
    $this->objFpdf->ln(8);
    $this->objFpdf-> MultiCell(49, 0.3, '', 1, 'J', true);
    $this->objFpdf->ln(8);
    $this->objFpdf->ln(8);

    $this->objFpdf->SetFont('Arial','B',13);
    $this->objFpdf->SetTextColor(60, 60, 60);
    $this->objFpdf->Cell(100, 8, 'Ubicacion del incidente:', 1);
    $this->objFpdf->Cell(90, 8, 'Punto de referencia:', 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->SetFont('Arial','',12);
    $this->objFpdf->Cell(100, 8, $ubicacionIncidente, 1);
    $this->objFpdf->Cell(90, 8, $puntoReferencia, 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->ln(8);

    $this->objFpdf->SetFont('Arial','B',13);
    $this->objFpdf->SetTextColor(60, 60, 60);
    $this->objFpdf->Cell(100, 8, 'Fecha de envio del reporte:', 1);
    $this->objFpdf->Cell(90, 8, 'Fecha de la emergencia:', 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->SetFont('Arial','',12);
    $this->objFpdf->Cell(100, 8, $fechaEnvioReporte, 1);
    $this->objFpdf->Cell(90, 8, $fechaEmergencia, 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->ln(8);

    $this->objFpdf->SetFont('Arial','B',13);
    $this->objFpdf->SetTextColor(60, 60, 60);
    $this->objFpdf->Cell(100, 8, 'Numero de lesionados:', 1);
    $this->objFpdf->Cell(90, 8, 'Estado del reporte:', 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->SetFont('Arial','',12);
    $this->objFpdf->Cell(100, 8, $numeroLesionados, 1);
    $this->objFpdf->Cell(90, 8, $estadoReporteInicial, 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->ln(8);

    $this->objFpdf->SetFont('Arial','B',13);
    $this->objFpdf->Cell(190, 8, 'Informacion reporte inicial:', 1);
    $this->objFpdf->ln(8);
    $this->objFpdf->SetFont('Arial','',12);
    $this->objFpdf-> MultiCell(0, 6, $informacionInicial, 1, 'J');
    $this->objFpdf->ln(8);


    $modo="I";
    $nombreArchivo = 'ReporteInicial'.' '.$idReporteVista;
    $this->objFpdf->OutPut($nombreArchivo, $modo);
  }

  # Función para agregar ceros a la izquierda de cada código de reporte:
  private function AgregarCeros($string) {
    return strlen($string) < 4 ? $this->agregarCeros("0$string") : $string;
  }

  # Función para obtener solo la fecha de un DATETIME:
  private function ExtraerFormatoFecha($datetime) {
    return date("d/m/Y", strtotime($datetime));
  }

  # Función para obtener solo la hora de un DATETIME:
  private function ExtraerFormatoHora($datetime) {
    return date("H:i:s", strtotime($datetime));
  }

}

?>
