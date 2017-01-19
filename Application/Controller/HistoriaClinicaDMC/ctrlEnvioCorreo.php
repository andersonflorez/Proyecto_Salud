<?php
require_once(APP.'Lib/Fpdf/fpdf.php');
require APP.'controller/historiaClinicaDMC/ctrlCuerpoPDF.php';
/**
* NOMBRE DE LA CLASE: ctrlTipoAntecedente
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de la tabla maestra tbl_tipoantecedente
* del módulo historia Clinica
*/
class ctrlEnvioCorreo extends Controller implements iController {

    private $FPDF;
    private $cuerpo;
    /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
    public function __construct() {
        $this->cuerpo = new ctrlCuerpoPDF();
        $this->FPDF = new FPDF('P','mm','Legal');
    }

    /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
    public function Index() {
        header('Location: ' . URL . 'Error/Error');
    }

    function enviarReporte(){
        $id = base64_decode($_POST["idAtencion"]);
        $this->FPDF->AddPage();
        $this->cuerpo->Header($this->FPDF);
        $this->cuerpo->formato($id,$this->FPDF);
        $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/HIstoria_clinica.pdf","F");

        $transport = Swift_SmtpTransport::newInstance()
            ->setHost('smtp.gmail.com')
            ->setPort('465')
            ->setEncryption("ssl")
            ->setUsername('central.automatizada.despacho@gmail.com')
            ->setPassword('administracioncad');

        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance()
            //asunto
            ->setSubject('Historia clinica atencion numero: '.base64_decode($_POST["idAtencion"]."."))
            //remitente
            ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
            //Destinatarios
            ->setTo(array($_POST["email"] => "Usuario"))
            ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte de atención</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la atencion N° <b>".$id."</b> que se realizó. Cualquier comentario hagalo llegar al administrador de la central.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
            ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/HIstoria_clinica.pdf","application/pdf"));
        $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // Send the message
        $mailer->send($message,$headers);
        unlink(APP."Controller/HistoriaClinicaDMC/HIstoria_clinica.pdf");
        echo "1";

    }

    public function enviarOrdenes(){
        $Orden = $_POST["Orden"];
        $id = base64_decode($_POST["idAtencion"]);
        if ($Orden == "formulaMedica") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->formulaMedica($id,$this->FPDF);
            $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/Formula_Medica.pdf","F");

            $transport = Swift_SmtpTransport::newInstance()
                ->setHost('smtp.gmail.com')
                ->setPort('465')
                ->setEncryption("ssl")
                ->setUsername('central.automatizada.despacho@gmail.com')
                ->setPassword('administracioncad');

            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
                //asunto
                ->setSubject('Formula medica.')
                //remitente
                ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
                //Destinatarios
                ->setTo(array($_POST["email"] => "Usuario"))
                ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte Formula Medica</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la formula medica enviada en la atencion N° <b>".$id."</b>, si desea otra orden medica comuniquese con la central. Cualquier comentario hagalo llegar al administrador.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
                ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/Formula_Medica.pdf","application/pdf"));
            $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Send the message
            $mailer->send($message,$headers);
            unlink(APP."Controller/HistoriaClinicaDMC/Formula_Medica.pdf");
            echo "1";


        }else if ($Orden == "tratamiento") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarTratamiento($id,$this->FPDF);
            $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/Tratamientos.pdf","F");


            $transport = Swift_SmtpTransport::newInstance()
                ->setHost('smtp.gmail.com')
                ->setPort('465')
                ->setEncryption("ssl")
                ->setUsername('central.automatizada.despacho@gmail.com')
                ->setPassword('administracioncad');

            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
                //asunto
                ->setSubject('Tratamiento.')
                //remitente
                ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
                //Destinatarios
                ->setTo(array($_POST["email"] => "Usuario"))
                ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte Tratamiento</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la informacion del tratamiento enviado en la atencion N° <b>".$id."</b>, si desea otra orden medica comuniquese con la central. Cualquier comentario hagalo llegar al administrador.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
                ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/Tratamientos.pdf","application/pdf"));
            $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Send the message
            $mailer->send($message,$headers);
            unlink(APP."Controller/HistoriaClinicaDMC/Tratamientos.pdf");
            echo "1";

        }else if ($Orden == "examenEspecializado") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarExamenEspecializado($id,$this->FPDF);
            $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/ExamenEspecializado.pdf","F");


            $transport = Swift_SmtpTransport::newInstance()
                ->setHost('smtp.gmail.com')
                ->setPort('465')
                ->setEncryption("ssl")
                ->setUsername('central.automatizada.despacho@gmail.com')
                ->setPassword('administracioncad');

            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
                //asunto
                ->setSubject('Examen especializado.')
                //remitente
                ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
                //Destinatarios
                ->setTo(array($_POST["email"] => "Usuario"))
                ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte Examen especializado</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la informacion el examen especializado enviado en la atencion N° <b>".$id."</b>, si desea otra orden medica comuniquese con la central. Cualquier comentario hagalo llegar al administrador.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
                ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/ExamenEspecializado.pdf","application/pdf"));
            $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Send the message
            $mailer->send($message,$headers);
            unlink(APP."Controller/HistoriaClinicaDMC/ExamenEspecializado.pdf");
            echo "1";

        }else if ($Orden == "incapacidad") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarIncapacidad($id,$this->FPDF);
            $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/Incapacidad.pdf","F");


            $transport = Swift_SmtpTransport::newInstance()
                ->setHost('smtp.gmail.com')
                ->setPort('465')
                ->setEncryption("ssl")
                ->setUsername('central.automatizada.despacho@gmail.com')
                ->setPassword('administracioncad');

            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
                //asunto
                ->setSubject('Incapacidad.')
                //remitente
                ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
                //Destinatarios
                ->setTo(array($_POST["email"] => "Usuario"))
                ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte Incapacidad</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la informacion de la incapacidad enviada en la atencion N° <b>".$id."</b>, si desea otra orden medica comuniquese con la central. Cualquier comentario hagalo llegar al administrador.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
                ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/Incapacidad.pdf","application/pdf"));
            $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Send the message
            $mailer->send($message,$headers);
            unlink(APP."Controller/HistoriaClinicaDMC/Incapacidad.pdf");
            echo "1";

        }else if ($Orden == "interconsulta") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarInterconsulta($id,$this->FPDF);
            $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/Interconsulta.pdf","F");


            $transport = Swift_SmtpTransport::newInstance()
                ->setHost('smtp.gmail.com')
                ->setPort('465')
                ->setEncryption("ssl")
                ->setUsername('central.automatizada.despacho@gmail.com')
                ->setPassword('administracioncad');

            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
                //asunto
                ->setSubject('Interconsulta.')
                //remitente
                ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
                //Destinatarios
                ->setTo(array($_POST["email"] => "Usuario"))
                ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte Interconsulta</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la informacion de la interconsula enviada en la atencion N° <b>".$id."</b>, si desea otra orden medica comuniquese con la central. Cualquier comentario hagalo llegar al administrador.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
                ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/Interconsulta.pdf","application/pdf"));
            $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Send the message
            $mailer->send($message,$headers);
            unlink(APP."Controller/HistoriaClinicaDMC/Interconsulta.pdf");
            echo "1";

        }else if ($Orden == "otro") {
            $this->FPDF->AddPage();
            $this->cuerpo->Header1($id,$Orden,$this->FPDF);
            $this->cuerpo->consultarOtro($id,$this->FPDF);
            $this->FPDF->Output(APP."Controller/HistoriaClinicaDMC/Otro.pdf","F");


            $transport = Swift_SmtpTransport::newInstance()
                ->setHost('smtp.gmail.com')
                ->setPort('465')
                ->setEncryption("ssl")
                ->setUsername('central.automatizada.despacho@gmail.com')
                ->setPassword('administracioncad');

            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance()
                //asunto
                ->setSubject('Informacion adicional.')
                //remitente
                ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administración CAD'))
                //Destinatarios
                ->setTo(array($_POST["email"] => "Usuario"))
                ->setBody("<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
  <div >

  <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
  color:#666;
  text-align:center;
  line-height: 142%;'>
  <b>Reporte Orden medica adicional</b>
  </span>
  <div  style='display:flex;flex-direction:column;'>
  <div style='flex-direction:row;display:flex;width:100%;'>
  <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
  color:#777;
  text-align:left;
  line-height: 142%;'>Señor(a) usuario, este correo se envio por su solicitud, en este se adjunta la informacion acidonal enviada en la atencion N° <b>".$id."</b>, si desea otra orden medica comuniquese con la central. Cualquier comentario hagalo llegar al administrador.
  </p>
  </div>

  </b>
  </div>

  <div style='width:100%;display:flex'>
  <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
  color:#666;
  text-align:lef;
  line-height: 142%;'>'Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda. ':
  </p>
  <div>
  <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
  </div>
  </div>
  </div>
  </div>", 'text/html')
                ->attach(Swift_Attachment::fromPath(APP."Controller/HistoriaClinicaDMC/Otro.pdf","application/pdf"));
            $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Send the message
            $mailer->send($message,$headers);
            unlink(APP."Controller/HistoriaClinicaDMC/Otro.pdf");
            echo "1";
        }

    }
}

?>
