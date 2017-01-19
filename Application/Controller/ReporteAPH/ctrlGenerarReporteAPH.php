<?php

require_once(APP.'Lib/Fpdf/fpdf.php');
require APP.'Controller/ReporteAPH/ctrlEstructuraPDF.php';

class ctrlGenerarReporteAPH extends Controller
{

  private $pdf;
  private $objEstructura = null;
  private $objModelo = null;

  function __construct(){
    $this->objEstructura = new ctrlEstructuraPDF();
    $this->pdf = new FPDF();

  }


  public function ReporteAPH($idReporteAPH){

    $this->pdf->AddPage();
    $this->objEstructura->Header($this->pdf,$idReporteAPH);
    $this->objEstructura->body($this->pdf,$idReporteAPH);
    //$this->objEstructura->Footer($this->pdf);
    $title = 'ReporteAPH';
    $this->pdf->SetTitle($title);
    $this->pdf->SetMargins(20,20,20);

    $this->pdf->Output('I','ReporteAPH_PDF.pdf','D');
  }



}


?>
