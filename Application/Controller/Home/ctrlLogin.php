<?php
/**
* Class Home:
* Renderiza la página inicial de la aplicación:
*/
class ctrlLogin extends Controller implements iController {

  private $objLogin;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

    Sesion::init();

    if (Sesion::exist()) {
      header("Location: " . URL . "Home/ctrlPrincipal");
    } else {
      $this->objLogin = $this->loadModel('Home', 'mdlLogin');
    }

  }

  public function CerrarSesion() {

    if (Sesion::exist()) {
      Sesion::destroy();
    }

    header("Location: " . URL);

  }

  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la siguiente URL:
  * http://PROYECTO_SALUD_DEV/Home/home
  */
  public function Index() {

    if (isset($_POST['loginError'])) {
      $loginError = $_POST['loginError'];
      unset($_POST['loginError']);

    }
    require APP . 'View/Home/viewLogin.php';
  }

  public function validarUsuario() {
    if (isset($_POST['txtUsuario']) && $_POST['txtClave']) {
      $usuario = $_POST['txtUsuario'];
        $this->objLogin->__SET("_Usuario", $usuario);
        $resPswd = $this->objLogin->ConsultarClaveUsuario();
        if($resPswd) {

            $realPassword = $resPswd->clave;
            $clave = Encrypter::decrypt(Encrypter::encrypt($_POST['txtClave']));
            $decrypted = Encrypter::decrypt($realPassword);
            var_dump(Encrypter::encrypt($_POST['txtClave']));

            if($decrypted === $clave) {

                $this->objLogin->__SET("_Clave", $realPassword);
                $credentials = $this->objLogin->Login();

                if($credentials) {

                    $descripcionRol = str_replace(' ', '_', strtoupper($credentials[0]->descripcionRol));
                    Sesion::setValue('ID_ROL', $credentials[0]->idRol);
                    Sesion::setValue('TIPO_USUARIO', $descripcionRol);
                    Sesion::setValue('ID_USUARIO', $credentials[0]->idUsuario);
                    Sesion::setValue('USUARIO', $credentials[0]->usuario);
                    Sesion::setValue('ID_PERSONA', $credentials[0]->idPersona);
                    Sesion::setValue('NOMBRES', $credentials[0]->nombres);
                    Sesion::setValue('APELLIDOS', $credentials[0]->apellidos);
                    Sesion::setValue('NUMERO_DOCUMENTO', $credentials[0]->numeroDocumento);
                    Sesion::setValue('FOTO', $credentials[0]->urlFoto);

                     $this->objLogin->__SET('_idPersona', $credentials[0]->idPersona);
                     $especialidad = $this->objLogin->ConsultarIdEspecialidad();

                    $Menu = $this->GenerarMenu();
                    Sesion::setValue('VISTAS_MENU', $Menu);
                    header("Location: " . URL . "Home/ctrlPrincipal");

                } else {
                    // Usuario inactivo

                    $_POST['loginError'] = 1;
                    $this->Index();
                }

            } else {
                // Contraseña incorrecta

                 $_POST['loginError'] = 2;
                 $this->Index();
            }

        } else {
             // El nombre de usuario no existe

             $_POST['loginError'] = 3;
             $this->Index();
        }

    } else {
      header('Location:'.URL.'Home/ctrlLogin');
    }

  }

  // public function ValidarAcceso(Param){
  //   header("Location: " . URL . "Home/Inicio");
  //   foreach ($acceso as Sesion::getValue('VISTAS_MENU')) {
  //   $acceso->urlVista==Param;
  //   return true;
  //   }
  //   return false;
  // }

  private function GenerarMenu() {

    $consultaMenu = array();
    $this->objLogin->__SET('_idRol', Sesion::getValue('ID_ROL'));
    $Modulos = $this->objLogin->ConsultarModulos();

    foreach($Modulos as $Modulo) {

      $idModulo = $Modulo->idModulo;
      $this->objLogin->__SET('_idModulo', $idModulo);
      $Vistas = $this->objLogin->ConsultarVistas();

      $arrayModulo = array(

        'idModulo' => $Modulo->idModulo,
        'iconoModulo' => $Modulo->iconoModulo,
        'Modulo' => $Modulo->descripcionModulo,
        'Vistas' => array()

      );

      foreach($Vistas as $Vista) {
        array_push($arrayModulo['Vistas'], $Vista);
      }

      array_push($consultaMenu, $arrayModulo);

    }

    // Ordenar el array de modulos en base la longitud del nombre del modulo:
    uksort($consultaMenu, function($last, $cur) use($consultaMenu) {
      $return = null;
      $lastlen = strlen($consultaMenu[$last]['Modulo']);
      $curlen = strlen($consultaMenu[$cur]['Modulo']);
      if ($lastlen < $curlen) {
        $return = -1;
      } else if ($lastlen === $curlen) {
        $return  = 0;
      } else {
        $return  = 1;
      }
      return $return;
    });

    return json_encode($consultaMenu);
  }

  public function restablecerClave() {

    $email = $_POST['email'];
    $key = "";
    $Listar = $this->objLogin->RestablecerClave($email);

    if ($Listar != null) {

      $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";

      for($i = 0; $i < 3; $i++) {
        $key .= $pattern{rand(0, 35)};
      }
      $key = md5($key);
      $this->objLogin->RegistrarCodigo($email,$key,$Listar->idUsuario);

      $transport = Swift_SmtpTransport::newInstance()
      ->setHost('smtp.gmail.com')
      ->setPort('465')
      ->setEncryption("ssl")
      ->setUsername('central.automatizada.despacho@gmail.com')
      ->setPassword('administracioncad');

      $mailer = Swift_Mailer::newInstance($transport);
      $message = Swift_Message::newInstance()
      //Asunto
      ->setSubject('Restaurar contraseña')
      //Remitente
      ->setFrom(array('central.automatizada.despacho@gmail.com' => 'Administrador'))
      //Destinatarios
      ->setTo(array($Listar->correoElectronico => "Usuario"))
      ->setBody(
"<div style='height:auto;box-shadow:0px 0px 2px 0px rgba(0,0,0,0.4);padding:10px;'>
   <div >
      <span style='width: 100%;display: flex;border-bottom:solid 1px rgba(0,0,0,0.5);padding:10px;font-family:Arial, Helvetica, sans-serif;font-size:27px;
         color:#666;
         text-align:center;
         line-height: 142%;'>
      <b>Restaurar contraseña</b>
      </span>
      <div style='display:flex;flex-direction:column;'>
         <div style='flex-direction:row;display:flex;width:100%;'>
            <p style='font-weight:bold;width:100%;font-family:Arial, Helvetica, sans-serif;font-size:14px;
               color:#777;
               text-align:left;
               line-height: 142%;'>Señor(a) usuario, este es el código para restaurar la contraseña: <br><br>$key<br><br>Este código sólo está habilitado para funcionar por 24 horas después de enviado este correo.
            </p>
         </div>
         </b>
      </div>
      <div style='width:100%;display:flex'>
         <p style='width:100%;font-family:Arial, Helvetica, sans-serif;font-size:11px;
            color:#666;
            text-align:lef;
            line-height: 142%;'>Nota: Este mensaje ha sido generado automaticamente. Por favor no lo responda.
         </p>
         <div>
            <img style='width: 130px;' src='https://imageshack.com/i/plpeIP96p'>
         </div>
      </div>
   </div>
</div>", 'text/html');
      $headers = 'From: central.automatizada.despacho@gmail.com' . " " . "\r\n" .'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      // Enviar el mensaje
      if ($mailer->send($message,$header)) {
        echo "1";
      } else {
        echo "2";
      }
    } else {
      echo "3";
    }

  }

  function validarCodigo(){
    $query = $this->objLogin->validarCodigoRestablecer($_POST["codigo"]);
    if($query == ""){
      echo json_encode(array("estado"=>"1","idUsuario"=>base64_encode("0")));
    }else{
      date_default_timezone_set("America/Bogota");
      $fechaActual = getDate();

      $fecha1 = strtotime($fechaActual["year"]."-".$fechaActual["mon"]."-".$fechaActual["mday"]." ".$fechaActual["hours"].":".$fechaActual["minutes"].":".$fechaActual["seconds"]);
      $fecha2 = strtotime("+24 hour",strtotime($query->fecha));

      $diferencia = $fecha1 - $fecha2;
      if($diferencia > 0){
        echo json_encode(array("estado"=>"2","idUsuario"=>base64_encode("0")));
      }else{
        echo json_encode(array("estado"=>"3","idUsuario"=>base64_encode($query->idUsuario)));
      }
      $this->objLogin->cambiarEstadoCodigoRestablecer($query->idRestablecer);
    }
  }

  function cambiarClave(){
    $this->objLogin->cambiarClaveUsuario(base64_decode($_POST["idUsuario"]),Encrypter::encrypt($_POST["clave"]));
    echo "1";
  }
}

?>
