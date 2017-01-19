<?php
require_once(APP.'Lib/Fpdf/fpdf.php');
require APP.'controller/historiaClinicaDMC/ctrlCuerpoPDF.php';
class ctrlDescargarPDF extends Controller
{

    private $FPDF;
    private $cuerpo = null;
    private $modelo = NULL;
    function __construct(){
        $this->cuerpo = new ctrlCuerpoPDF();
        $this->FPDF = new FPDF('P','mm','Legal');
    }

    public function Reporte($ID,$histo){
        $id = base64_decode($ID);
        $this->FPDF->AddPage();
        $this->cuerpo->Header($this->FPDF);
        $this->cuerpo->formato($id,$this->FPDF);
        $this->FPDF->Output("HIstoria_clinica.pdf","I");
    }

    public function ReporteOrdenes($ID,$Orden){
        $id = base64_decode($ID);
        if ($Orden == "FormulaMedica") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->formulaMedica($id,$this->FPDF);
            $this->FPDF->Output("Formula_Medica_".$id.".pdf","I");

        }else if ($Orden == "Tratamiento") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarTratamiento($id,$this->FPDF);
            $this->FPDF->Output("Tratamientos-".$id.".pdf","I");

        }else if ($Orden == "ExamenEspecializado") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarExamenEspecializado($id,$this->FPDF);
            $this->FPDF->Output("ExamenEspecializado_".$id.".pdf","I");

        }else if ($Orden == "Incapacidad") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarIncapacidad($id,$this->FPDF);
            $this->FPDF->Output("Incapacidad_".$id.".pdf","I");

        }else if ($Orden == "Interconsulta") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarInterconsulta($id,$this->FPDF);
            $this->FPDF->Output("Interconsulta_".$id.".pdf","I");

        }else if ($Orden == "Otro") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarOtro($id,$this->FPDF);
            $this->FPDF->Output("Otro_".$id.".pdf","I");
        }

    }
}

?>
