<?php
require_once(APP.'Lib/Fpdf/fpdf.php');

class ctrlCuerpoPDF extends Controller
{

    private $modelo = NULL;
    function __construct(){
        $this->modelo = $this->loadModel('HistoriaClinicaDMC', 'mdlPDF');
    }


    //Cabecera de página
    function Header($PDF)
    {
        //Logo
        $PDF->Image(URL.'Public\Img\Todos\LogoPDF.png',5,5,-300);
        //Arial bold 15
        $PDF->SetFont('Arial','B',15);
        //Movernos a la derecha
        $PDF->SetY(15);
        $PDF->Cell(80);
        //Título
        $PDF->Cell(37,10,'Historia clinica',0,0,'C');
        //Salto de línea
        $PDF->Ln(20);
    }

    function Header1($ID,$tipo,$PDF)
    {
        //Logo
        $PDF->Image(URL.'Public\Img\Todos\LogoPDF.png',5,5,-300);
        //Arial bold 15
        $PDF->SetFont('Arial','B',20);
        //Movernos a la derecha
        $PDF->SetY(15);
        $PDF->Cell(80);
        //Título
        if ($tipo == "FormulaMedica") {
            $PDF->Cell(37,10,"Formula Medica",0,0,'C');

        }else if ($tipo == "Tratamiento") {
            $PDF->Cell(37,10,"Tratamiento",0,0,'C');

        }else if ($tipo == "ExamenEspecializado") {
            $PDF->Cell(37,10,"Examen Especializado",0,0,'C');

        }else if ($tipo == "Incapacidad") {
            $PDF->Cell(37,10,"Incapacidad",0,0,'C');
        }elseif ($tipo == "Otro") {
            $PDF->Cell(37,10,"Otro",0,0,'C');
        }else if($tipo == "Interconsulta"){
            $PDF->Cell(37,10,"Interconsulta",0,0,'C');
        }
        $consultaIdHc = $this->modelo->consultarHc($ID);
        $persona = $this->modelo->ConsultarPersona($ID);
        $consultarPaciente = $this->modelo->consultarPaciente($consultaIdHc->idPaciente);

        $PDF->Ln(20);
        $PDF->SetFont('Arial','B',10);
        $PDF->Line(10,33,$PDF->GetPageWidth()-10,33);
        $PDF->Write(5,"Fecha: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultaIdHc->fechaAtencion);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln(10);
        $PDF->Write(5,"Nombre: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->primerNombre." ".$consultarPaciente->segundoNombre);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"Apellido: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->primerApellido." ".$consultarPaciente->segundoApellido);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"Tipo documento: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->descripcionTdocumento);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"N° Documento: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->numeroDocumento);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"Telefono: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->telefonoFijo);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"Ciudad: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->ciudadResidencia);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"Barrio: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->barrioResidencia);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->Write(5,"Dirección: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->direccion);
        $PDF->SetFont('Arial','B',10);
        $PDF->Ln();
        $PDF->SetFont('Arial','B',10);
        $PDF->Write(5,"Tipo de afiliación: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$consultarPaciente->descripcionAfiliacion);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetXY(90,45);
        $PDF->Write(5,"Realizo: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$persona->primerNombre." ".$persona->segundoNombre." ".$persona->primerApellido." ".$persona->segundoApellido);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetXY(90,50);
        $PDF->Write(5,"Especialidad: ");
        $PDF->SetFont('Arial','',10);
        $PDF->Write(5,$persona->descripcionEspecialidad);
        $PDF->SetFont('Arial','B',10);
        $PDF->Line(10,93,$PDF->GetPageWidth()-10,93);
        $PDF->Ln(45);
    }
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }

    function formato($id,$PDF){
        /*Primer Bloque*/
        $consulta = $this->modelo->consultarHc($id);
        $num = $consulta->idHistoriaClinica;


        $PDF->SetFont('Arial','B',8);
        $PDF->SetY(30);
        $PDF->SetX(10);
        $PDF->Cell(60,8,'Atención N',1,1,'C');
        $PDF->SetY(38);
        $PDF->SetX(10);
        $PDF->Cell(60,8,''.$num.'',1,1,'C');
        $PDF->SetY(30);
        $PDF->SetX(70);
        $PDF->Cell(135,16,'',1,1,'C');
        $PDF->SetFont('Arial','B',8);
        $PDF->SetY(28);
        $PDF->SetX(86);
        $PDF->Cell(10,10,'Historia Clinica de Atencion',0,1,'C');
        $PDF->SetY(31);
        $PDF->SetX(112);
        $PDF->Cell(4,4,'X',1,1,'C');
        $PDF->SetY(40);
        $PDF->SetX(150);
        $PDF->Cell(4,4,'',1,1,'C');
        $PDF->SetY(40);
        $PDF->SetX(160);
        $PDF->Cell(4,4,'',1,1,'C');
        $PDF->SetY(40);
        $PDF->SetX(170);
        $PDF->Cell(4,4,'',1,1,'C');
        $PDF->SetY(40);
        $PDF->SetX(180);
        $PDF->Cell(4,4,'',1,1,'C');
        $PDF->SetY(40);
        $PDF->SetX(190);
        $PDF->Cell(4,4,'',1,1,'C');
        $PDF->SetY(40);
        $PDF->SetX(200);
        $PDF->Cell(4,4,'',1,1,'C');
        $PDF->SetY(38);
        $PDF->SetX(70);
        $PDF->Cell(10,10,'No.',0,1,'C');
        /*Fin 1er-Bloque*/

        /*Segundo Bloque*/

        $placa = $consulta->placaVehiculo;
        $PDF->SetXY(10,46);
        $PDF->Cell(30,10,"",1,1,'C');
        $PDF->SetXY(13,47);
        $PDF->Write(3,"Placa vehiculo");
        $PDF->SetXY(18,52);
        $PDF->SetFont('Arial','',8);
        $PDF->Write(3,$placa);
        $PDF->SetFont('Arial','B',8);

        $PDF->SetY(46);
        $PDF->SetX(40);
        $PDF->Cell(30,10,'',1,1,'C');


        $PDF->SetXY(70,46);
        $PDF->Cell(70,10,'',1,1,'C');
        $PDF->SetXY(92,47);
        $PDF->Write(3,"Medico a cargo");
        $PDF->SetFont("Arial",'',8);
        $PDF->SetXY(83,52);
        $PDF->Write(3,$consulta->primerNombre." ".$consulta->segundoNombre." ".$consulta->primerApellido);

        $PDF->SetFont("Arial",'B',8);
        $PDF->SetXY(140.1,46);
        $PDF->Cell(20,10,'',1,1,'C');
        $PDF->SetXY(143,48);
        $PDF->Write(3,"Telefono");
        $PDF->SetFont("Arial",'',8);
        $PDF->SetXY(143.5,52);
        $PDF->Write(3,$consulta->telefono);
        $PDF->SetFont("Arial",'B',8);

        $PDF->SetY(45.5);
        $PDF->SetX(166);
        $PDF->Cell(5,5,'Ocupacion',0,1,'C');
        $PDF->SetY(46);
        $PDF->SetX(160);
        $PDF->SetFont("Arial",'',8);
        $PDF->Cell(45,10,$consulta->ocupacion,1,1,'C');
        $PDF->SetFont("Arial",'B',8);
        /**/

        /*Tercer Bloque*/
        $PDF->SetY(56);
        $PDF->SetX(10);
        $PDF->Cell(80,10,'',1,1,'C');
        $PDF->SetXY(37,57);
        $PDF->Write(3,"Lugar de atencion");
        $PDF->SetFont("Arial",'',8);
        $PDF->SetXY(45,61);
        $PDF->Write(3,"Casa");

        $PDF->SetFont("Arial",'B',8);
        $PDF->SetY(56);
        $PDF->SetX(90);
        $PDF->Cell(50,10,$consulta->idtipoAfiliacion,1,1,'C');

        $direccion = $consulta->direccion;
        $PDF->SetXY(140,56);
        $PDF->Cell(65,10,"",1,1,'C');
        $PDF->SetXY(145,58);
        $PDF->Write(3,"Dirección de la atencion");
        $PDF->SetXY(145,62);
        $PDF->SetFont("Arial",'',8);
        $PDF->Write(3,$direccion);
        $PDF->SetFont("Arial",'B',8);

        /**/

        /*Cuarto Bloque*/
        $edadPaciente = $consulta->edadPaciente;
        $genero = $consulta->genero;
        $telefonoFijo = $consulta->telefonoFijo;

        $PDF->SetXY(10,66);
        $PDF->Cell(40,10,"",1,1,'C');
        $PDF->SetXY(12,67);
        $PDF->Write(3,"Telefono de Atención");
        $PDF->SetXY(20,71);
        $PDF->SetFont("Arial",'',8);
        $PDF->Write(3,$telefonoFijo);
        $PDF->SetFont("Arial",'B',8);


        $PDF->SetXY(50,66);
        $PDF->Cell(30,10,'',1,1,'C');
        $PDF->SetXY(60.5,67);
        $PDF->Write(3,"Edad");
        $PDF->SetXY(62,71);
        $PDF->SetFont("Arial",'',8);
        $PDF->Write(3,$edadPaciente);
        $PDF->SetFont("Arial",'B',8);

        $PDF->SetXY(80,66);
        $PDF->Cell(30,10,"",1,1,'C');
        $PDF->SetXY(88,67);
        $PDF->Write(3,"Genero");
        $PDF->SetXY(86,71 );
        $PDF->SetFont("Arial",'',8);
        $PDF->Write(3,$genero);
        $PDF->SetFont("Arial",'B',8);

        $PDF->SetY(66);
        $PDF->SetX(80);
        $PDF->Cell(125 ,10,'Clasificacionde la llamada',1,1,'C');
        /**/
        $pos=76;$alt =12;
        /*QUINTO BLOQUE*/
        $PDF->SetFont('Arial','',8);
        $MotivoConsulta = $consulta->motivoAtencion;
        $cont = 0;
        while($cont <= strlen($MotivoConsulta)){
            $cont = $cont + 100;
            $alt = $alt+2;
        }

        $PDF->SetFont('Arial','',8);
        $PDF->SetXY(10,$pos);
        $PDF->Cell(195,$alt,"",1,1,'L');
        $PDF->SetXY(10,78);
        $PDF->Write(3,str_replace("<br />","\r",$MotivoConsulta));


        /**/
        /**/
        $enfermedadActual = $consulta->enfermedadActual;
        $alt1 = 12;$cont1=0;
        $pos= $alt +$pos;

        while($cont1 <= strlen($enfermedadActual)){
            $cont1 = $cont1 + 100;
            $alt1 = $alt1+2;
        }

        $PDF->SetXY(10,$pos);
        $PDF->MultiCell(195,$alt1,'',1,'J');
        $PDF->SetXY(10,$pos +2);
        $PDF->Write(3,str_replace("<br />","\r",$enfermedadActual));
        /**/
        /**/
        $PDF->SetFont('Arial','B',8);
        $pos = $alt1 + $pos;
        $descripcionorigenAtencion = $consulta->descripcionorigenAtencion;
        $PDF->SetXY(10,$pos);
        $PDF->Cell(30,7,'3.Origen de atencion',1,1,'C');

        $PDF->SetXY(40,$pos);
        $PDF->Cell(165,7,$descripcionorigenAtencion,1,1,'L');
        $PDF->SetXY(43,$pos +2);

        /**/
        /**/
        $pos = $pos + 7;



        $PDF->SetXY(10,$PDF->GetY()+6);
        $PDF->SetFont('Arial','B',8);
        $PDF->Cell(195,8,'5. Signos Vitales',1,1,'C');

        $pos = 8 + $pos;
        $posA = $this->tabla($id,$pos,$PDF);
        /*FIN DE TABLA*/


        /**/
        /*ULTIMO Y = 308--325*/
        $PDF->addPage();
        /**/

        $PDF->SetXY(10,10);
        $PDF->Cell(195,5,'6. Examen Fisico',1,1,'C');

        $posA = 10;
        $posA = $this->tabla1($id,$posA,$PDF);

        $PDF->SetXY(10,$posA);
        $PDF->Cell(155,5,'7. Diagnostico',1,1,'C');

        $PDF->SetXY(165,$posA);
        $PDF->Cell(40,5,'7. Codigo',1,1,'C');
        $posA += 5;

        $PDF->SetFont('Arial','',8);
        $datos = $this->modelo->diagnosticos($id);

        $posI = $posA +1; $posO = 10;
        $alt = 5;$cont=0;

        foreach ($datos as $key) {
            $cont++;
            if ($cont > 3) {
                $alt += 10;
                $posO = 10;
                $posI += 7;
            }
            $PDF->SetXY($posO,$posI);
            $PDF->Write(3,$cont.'.'.$key->descripcionCIE10 );

            $posO +=55;
        }

        $PDF->SetXY(10,$posA);
        $PDF->Cell(195,$alt,'',1,0,'C');

        $pos = $posA + $alt;
        $posZ= $pos + 2;
        $alt= 0;
        $sum =0;
        foreach ($datos as $key) {
            $sum ++;
            $PDF->SetXY(10,$posZ);
            $PDF->Write(3,$sum.".".str_replace("<br />","\r",$key->descripcionDiagnostico));

            $posZ += 15;
            $alt += 15;
        }

        $PDF->SetXY(10,$posA);
        $PDF->Cell(195,$alt,'',1,0,'C');


        $PDF->SetFont('Arial','B',8);
        $posA = $posA + $alt;
        $PDF->SetXY(10,$posA);
        $PDF->Cell(195,5,'8. Prodedimiento',1,1,'C');

        $posA += 5;

        $PDF->SetFont('Arial','',8);
        $datos1 = $this->modelo->procedimientos($id);

        $posI = $posA +1; $posO = 10;
        $alt = 5;$cont=0;

        foreach ($datos1 as $key) {
            $cont++;
            if ($cont > 3) {
                $alt += 10;
                $posO = 10;
                $posI += 10;
            }
            $PDF->SetXY($posO,$posI);
            $PDF->Write(3,$cont.'.'.$key->nombreCUP);

            $posO +=55;
        }

        $PDF->SetXY(10,$posA);
        $PDF->Cell(195,$alt,'',1,0,'C');

        $pos = $posA + $alt;
        $posZ= $pos + 2;
        $alt= 0;
        $sum =0;
        foreach ($datos1 as $key) {
            $sum ++;
            $PDF->SetXY(10,$posZ);
            $PDF->Write(3,$sum.".".str_replace("<br />","\r",$key->descripcionProcedimiento));

            $posZ += 15;
            $alt += 15;
        }

        $PDF->SetXY(10,$posA);
        $PDF->Cell(195,$alt,'',1,0,'C');




        /**/
        $posA+= $alt;
        $PDF->SetXY(10,$posA);
        $PDF->Cell(45,20,'',1,1);
        $PDF->SetXY(55,$posA);
        $PDF->Cell(45,20,'',1,1);
        $PDF->SetXY(100,$posA);
        $PDF->Cell(105,20,'',1,1);

        /**/

    }

    function tabla($id,$pos,$PDF){
        $h1= 0;$h2=0;$h3=0;$h4=0;$alt=7;
        $datos = $this->modelo->consultarHoraSignosVitales($id);
        $Res = $this->modelo->consultarResultadoSignosVitales($id);
        foreach ($datos as $key) {
            $h1 = $datos[0]->hora;
            $h2 = $datos[1]->hora;
            $h3 = $datos[2]->hora;
            $h4 = $datos[3]->hora;
        }

        $posF = $pos;

        $PDF->SetFont('Arial','B',8);
        $PDF->SetXY(10,$posF);
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'Inicio',1, 0 , 'L' );
        $PDF->Cell(13,7,'Min',1, 0 , 'L' );
        $PDF->Cell(13,7,'Min',1, 0 , 'L' );
        $PDF->Cell(13,7,'Final',1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'Inicio',1, 0 , 'L' );
        $PDF->Cell(13,7,'Min',1, 0 , 'L' );
        $PDF->Cell(13,7,'Min',1, 0 , 'L' );
        $PDF->Cell(13,7,'Final',1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'Inicio',1, 0 , 'L' );
        $PDF->Cell(13,7,'Min',1, 0 , 'L' );
        $PDF->Cell(13,7,'Min',1, 0 , 'L' );
        $PDF->Cell(13,7,'Final',1, 0 , 'L' );

        $posF = $posF + 7;
        $PDF->SetXY(10,$posF);
        $PDF->Cell(13,7,'Tiempo',1, 0 , 'L' );
        $PDF->Cell(13,7,$h1,1, 0 , 'L' );
        $PDF->Cell(13,7,$h2,1, 0 , 'L' );
        $PDF->Cell(13,7,$h3,1, 0 , 'L' );
        $PDF->Cell(13,7,$h4,1, 0 , 'L' );
        $PDF->Cell(13,7,'Tiempo',1, 0 , 'L' );
        $PDF->Cell(13,7,$h1,1, 0 , 'L' );
        $PDF->Cell(13,7,$h2,1, 0 , 'L' );
        $PDF->Cell(13,7,$h3,1, 0 , 'L' );
        $PDF->Cell(13,7,$h4,1, 0 , 'L' );
        $PDF->Cell(13,7,'Tiempo',1, 0 , 'L' );
        $PDF->Cell(13,7,$h1,1, 0 , 'L' );
        $PDF->Cell(13,7,$h2,1, 0 , 'L' );
        $PDF->Cell(13,7,$h3,1, 0 , 'L' );
        $PDF->Cell(13,7,$h4,1, 0 , 'L' );

        $posF = $posF + 7;
        $PDF->SetXY(10,$posF);
        $PDF->Cell(13,7,'F.C',1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[0]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[1]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[2]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[3]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,'F.R',1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[12]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[13]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[14]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[15]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,'SaO2',1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[24]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[25]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[26]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[27]->resultado,1, 0 , 'L' );

        $posF = $posF + 7;
        $PDF->SetXY(10,$posF);
        $PDF->Cell(13,7,'T.A.S',1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[4]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[5]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[6]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[7]->resultado,1, 0 , 'L' );
        $PDF->SetFont('Arial','B',5);
        $PDF->Cell(13,7,'Temperatura',1, 0 , 'L' );
        $PDF->SetFont('Arial','B',8);
        $PDF->Cell(13,7,$Res[16]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[17]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[18]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[19]->resultado,1, 0 , 'L' );
        $PDF->SetFont('Arial','B','5');
        $PDF->Cell(13,7,'Glucometria',1, 0 , 'L' );
        $PDF->SetFont('Arial','B','8');
        $PDF->Cell(13,7,$Res[28]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[29]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[30]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[31]->resultado,1, 0 , 'L' );

        $posF = $posF + 7;
        $PDF->SetXY(10,$posF);
        $PDF->SetFont('Arial','B','8');
        $PDF->Cell(13,7,'T.A.D',1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[8]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[9]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[10]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[11]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,'Glasgow',1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[20]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[21]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[22]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,$Res[23]->resultado,1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $PDF->Cell(13,7,'',1, 0 , 'L' );
        $posF = $posF + 7;
        return $posF;
    }

    function tablaAntecedentes($id,$pos,$PDF){
        $alt = 5;$cont=0;
        $posF = $pos ;
        $PDF->SetFont('Arial','B',8);
        $PDF->SetXY(10,$posF);
        $PDF->Cell(40,5,'Sistema',1, 0 , 'L' );
        $PDF->Cell(155,5,'',1, 0 , 'L' );

        $consultaAnte = $this->modelo->cunsultarAtencedentes($id);

        $sum=0;

        $posF += 5;
        foreach ($consultaAnte as $key) {
          $alt1= 5;
            $texto = sub_str($key->descripcionAntecedente,100);
            for ($i=0; $i < count($texto); $i++) {
                $sum +=90; $alt1 +=3;
            }

            $PDF->SetXY(10,$posF);
            $PDF->Cell(40,$alt1,$key->descripcion,1, 0 , 'L' );

            $PDF->Cell(155,$alt1,"",1, 0 , 'L' );
            $pos = $PDF->GetY()+2;
            foreach ($texto as $key) {
                $PDF->SetXY(50,$pos);
                $PDF->Write(3,$key);
                $pos+=3;
            }
            $posF += $alt1;
        }
        return $posF;
    }

    function tabla1($id,$pos,$PDF){
        $alt = 5;$cont=0;
        $posF = $pos + $alt;
        $PDF->SetFont('Arial','B',8);
        $PDF->SetXY(10,$posF);
        $PDF->Cell(30,5,'Sistema',1, 0 , 'L' );
        $PDF->Cell(10,5,'N',1, 0 , 'C' );
        $PDF->Cell(10,5,'A',1, 0 , 'C' );
        $PDF->Cell(145,5,'',1, 0 , 'L' );

        $datos = $this->modelo->ListarExamenFisico($id);

        $sum=0;

        $posF += 5;
        foreach ($datos as $key) {
          $alt1= 5;
            $texto = sub_str($key->descripcionExamen,100);
            for ($i=0; $i < count($texto); $i++) {
                $sum +=90; $alt1 +=3;
            }

            $PDF->SetXY(10,$posF);
            $PDF->Cell(30,$alt1,$key->descripcionExamenFisico,1, 0 , 'L' );
            if ($key->estadoTablaExamen == "Normal") {
                $PDF->Cell(10,$alt1,'X',1, 0 ,'C' );
                $PDF->Cell(10,$alt1,'',1, 0 , 'C' );
            }else if ($key->estadoTablaExamen == "Anormal") {
                $PDF->Cell(10,$alt1,'',1, 0 , 'C' );
                $PDF->Cell(10,$alt1,'X',1, 0 , 'C' );
            }else{
                $PDF->Cell(10,$alt1,'',1, 0 , 'C' );
                $PDF->Cell(10,$alt1,'',1, 0 , 'C' );
            }

            $PDF->Cell(145,$alt1,"",1, 0 , 'L' );
            $pos = $PDF->GetY()+1;
            foreach ($texto as $key) {
                $PDF->SetXY(60,$pos);
                $PDF->Write(3,$key);
                $pos+=3;
            }
            $posF += $alt1;
        }
        return $posF;
    }

    function formulaMedica($id,$PDF)
    {
        $formulaMedica = $this->modelo->consultarFormulaMedica($id);
        $idFormula = $formulaMedica->idFormulaMedica;
        $consultarDetalleFormula = $this->modelo->consultarDetalleFormula($idFormula);
        if ($formulaMedica != NULL) {
            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,149,208);
            $PDF->Cell(65,10,'Medicamento',0, 0 , 'L' );
            $PDF->Cell(65,10,'Cantidad de Medicamento',0, 0 , 'L' );
            $PDF->Cell(65,10,'Dosificacion',0, 0 , 'L' );
            $pos = $PDF->GetY() + 7;

            $PDF->SetFont('Arial','',10);
            foreach ($consultarDetalleFormula as $key) {
                $PDF->SetXY(10,$pos);
                $PDF->SetTextColor(0,0,0);
                $PDF->Cell(65,7,$key->nombreMedicamento,0, 0 , 'L' );
                $PDF->Cell(65,7,$key->cantidadMedicamento,0, 0 , 'L' );
                $PDF->Cell(65,7,$key->dosificacion,0, 0 , 'L' );
                $pos +=7;
            }
            $pos +=5 ;$alt = 5;
            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,149,208);
            $PDF->SetXY(10,$pos);
            $PDF->Cell(195,$alt,"Recomendaciones:",0, 0 , 'L' );

            $pos+=5;$cont=0;
            $PDF->SetFont('Arial','',10);

            $PDF->SetTextColor(0,0,0);
            $PDF->SetXY(10,$pos+1);
            $PDF->Write(3,str_replace("<br />","\r",$formulaMedica->recomendaciones));
            $pos+=10;
           // while($cont <= strlen($formulaMedica->recomendaciones)){
           //     $cont += 100;
            //    $pos += 2;
            //    /*var_dump($cont." : ".strlen($formulaMedica->recomendaciones));
            //var_dump($pos);*/
            //}
            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,149,208);
            $PDF->SetXY(10,$pos);
            $PDF->Cell(92,$alt,"Descripcion:",0, 0 , 'L' );
            $pos +=$alt;
            $PDF->SetFont('Arial','',10);
            $PDF->SetTextColor(0,0,0);
            $PDF->SetXY(10,$pos+1);
            $PDF->Write(3,str_replace("<br />","\r", $consultarDetalleFormula[0]->descripcion));
        }
    }

    function consultarTratamiento($id,$PDF){
        $consultarTratamiento = $this->modelo->consultarTratamiento($id);
        if (count($consultarTratamiento) != 0) {
            $idTratamiento = $consultarTratamiento->idTratamiento;
            $consultarDetalleTratamiento = $this->modelo->consultarDetalleTratamiento($idTratamiento);
            $consultarEquipoBiomedicoTratamiento = $this->modelo->consultarEquipoBiomedicoTratamiento($idTratamiento);

            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,141,208);
            $PDF->Cell(0,10,'Fecha Limite:',0, 0 , 'L' );
            $PDF->Ln(7);
            $PDF->SetFont('Arial','',10);
            $PDF->SetTextColor(0,0,0);
            $PDF->Cell(0,7,$consultarTratamiento->fechaTratamiento,0, 0 , 'L' );
            $PDF->Ln();
            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,141,208);
            $PDF->Cell(65,10,'Tratamiento:',0, 0 , 'L' );
            $PDF->Ln(7);
            $PDF->SetFont('Arial','',10);
            $PDF->SetTextColor(0,0,0);
            $PDF->Cell(65,7,$consultarTratamiento->tipoTratamiento,0, 0 , 'L' );
            $PDF->Ln();
            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,141,208);
            $PDF->Cell(65,10,'Dosis tratamiento:',0, 0 , 'L' );
            $PDF->Ln(7);
            $PDF->SetFont('Arial','',10);
            $PDF->SetTextColor(0,0,0);
            $PDF->Cell(65,7,$consultarTratamiento->dosisTratamiento,0, 0 , 'L' );

            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,141,208);
            $PDF->SetXY($PDF->GetX()+10,96);
            $PDF->Cell(60,7,"Equipo Biomedico",1, 0 , 'C' );
            $PDF->SetX($PDF->GetX());
            $PDF->Cell(60,7,"Equipo Biomedico",1, 0 , 'C' );

            $PDF->SetFont('Arial','',10);
            $PDF->SetTextColor(0,0,0);
            if ($consultarDetalleTratamiento != Null) {
              for ($i=0; $i < count($consultarDetalleTratamiento) ; $i++) {
                $PDF->SetXY($PDF->GetX()-120,$PDF->GetY()+7);
                $PDF->Cell(60,7,$consultarDetalleTratamiento->nombre,1, 0 , 'C' );
                $PDF->SetX($PDF->GetX());
                $PDF->Cell(60,7,"Con Existencia",1, 0 , 'C' );
              }
            }

            if ($consultarEquipoBiomedicoTratamiento != Null) {
              for ($i=0; $i < count($consultarEquipoBiomedicoTratamiento); $i++) {
                $PDF->SetXY($PDF->GetX()-120,$PDF->GetY()+7);
                $PDF->Cell(60,7,$consultarEquipoBiomedicoTratamiento->equipoBiomedico,1, 0 , 'C' );
                $PDF->SetX($PDF->GetX());
                $PDF->Cell(60,7,"Sin Existencia",1, 0 , 'C' );
              }
            }
            $PDF->Ln(26);
            $PDF->SetFont('Arial','B',10);
            $PDF->SetTextColor(31,141,208);
            $PDF->Cell(65,10,'Descripcion: ',0, 0 , 'L' );
            $PDF->Ln();
            $PDF->SetFont('Arial','',10);
            $PDF->SetTextColor(0,0,0);
            $PDF->Write(3,$consultarTratamiento->descripcionTratamiento,0, 0 , 'L' );
        }
    }



    function consultarExamenEspecializado($id,$PDF){
        $consultarExamenEspecializado = $this->modelo->consultarExamenEspecializado($id);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetTextColor(31,141,208);
        $PDF->Write(3,"Tipo exámen especializado: ");
        $PDF->SetFont('Arial','',10);
        $PDF->SetTextColor(0,0,0);
        $PDF->Ln(5);
        $PDF->Write(3,$consultarExamenEspecializado->nombreTipoExamen);

        $pos = $PDF->GetY() + 7;
        $PDF->SetY($pos);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(65,7,"Observaciones:",0, 0 , 'L' );
        $PDF->SetFont('Arial','',10);
        $PDF->SetY($pos+=7);
        $PDF->SetTextColor(0,0,0);
        $PDF->Write(3,str_replace("<br />","\r",$consultarExamenEspecializado->observaciones));


        $cont =0 ;
        while($cont <= strlen($consultarExamenEspecializado->observaciones)){
            $cont += 100;
            $pos += 2;
        }

        $PDF->SetY($pos+=10);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(65,7,"Descripción:",0, 0 , 'L' );
        $PDF->SetY($pos+=7);
        $PDF->SetFont('Arial','',10);
        $PDF->SetTextColor(0,0,0);
        $PDF->Write(3,str_replace("<br />","\r",$consultarExamenEspecializado->descripcion));

    }
    function consultarInterconsulta($id,$PDF){
        $consultarInterconsulta = $this->modelo->consultarInterconsulta($id);

        $PDF->SetFont('Arial','B',10);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(65,10,'Fecha Límite',0, 0 , 'L' );
        $PDF->Ln(7);
        $PDF->SetFont('Arial','',10);
        $PDF->SetTextColor(0,0,0);
        $PDF->Cell(65,7,$consultarInterconsulta->fechaLimite,0, 0 , 'L' );
        $PDF->Ln();
        $PDF->SetFont('Arial','B',10);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(65,10,'Especialidad',0, 0 , 'L' );
        $PDF->SetFont('Arial','',10);
        $PDF->Ln(7);
        $PDF->SetTextColor(0,0,0);
        $PDF->Cell(65,7,$consultarInterconsulta->especialidad,0, 0 , 'L' );
        $PDF->SetFont('Arial','B',10);

        $pos = $PDF->GetY() + 7;
        $PDF->SetY($pos);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(65,10,'Descripción:',0, 0 , 'L' );
        $PDF->SetTextColor(0,0,0);

        $pos = $PDF->GetY() + 8;
        $PDF->SetY($pos);
        $PDF->SetFont('Arial','',10);
        $PDF->Write(3,str_replace("<br />","\r",$consultarInterconsulta->descripcionInterconsulta));
    }
    function consultarIncapacidad($id,$PDF){
        $consultarIncapacidad = $this->modelo->consultarIncapacidad($id);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(45,10,'Número de días ',0, 0 , 'L' );
        $PDF->Ln(7);
        $PDF->SetTextColor(0,0,0);
        $PDF->SetFont('Arial','',10);
        $PDF->Cell(45,7,$consultarIncapacidad->cantidadDias,0, 0 , 'L' );
        $PDF->Ln();
        $PDF->SetTextColor(31,141,208);
        $PDF->SetFont('Arial','B',10);
        $PDF->Cell(105,10,'Prorroga',0, 0 , 'L' );
        $PDF->Ln(7);
        $PDF->SetTextColor(0,0,0);
        $PDF->SetFont('Arial','',10);
        $PDF->Cell(105,7,$consultarIncapacidad->prorroga,0, 0 , 'L' );
        $PDF->Ln();
        $PDF->SetTextColor(31,141,208);
        $PDF->SetFont('Arial','B',10);
        $PDF->Cell(45,10,'Codigo CIE-10',0, 0 , 'L' );
        $PDF->Ln(7);
        $PDF->SetFont('Arial','',10);
        $PDF->SetTextColor(0,0,0);
        $PDF->Cell(45,7,$consultarIncapacidad->codigoCIE10,0, 0 , 'L' );
        $pos = $PDF->GetY();

        $PDF->SetTextColor(0,0,0);
        $PDF->SetY($pos);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetY($pos+=7);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(105,10,'Descripcion',0, 0 , 'L' );
        $PDF->SetTextColor(0,0,0);
        $PDF->SetY($pos+=7);
        $PDF->SetFont('Arial','',10);
        $PDF->Cell(105,7,$consultarIncapacidad->descripcionCIE10,0, 0 , 'L' );

        $PDF->SetFont('Arial','B',10);
        $PDF->SetY($pos+=20);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(105,10,'Observación/Motivo',0, 0 , 'L' );
        $PDF->SetTextColor(0,0,0);
        $PDF->SetY($pos+=7);
        $PDF->SetFont('Arial','',10);
        $PDF->Cell(105,7,$consultarIncapacidad->descripcionMotivo,0, 0 , 'L' );
    }

    function consultarOtro($id,$PDF){
        $consultarOtro = $this->modelo->consultarOtro($id);
        $PDF->SetFont('Arial','B',10);
        $PDF->SetTextColor(31,141,208);
        $PDF->Cell(0,10,'Orden medica: ',0, 0 , 'L' );
        $PDF->Ln(7);

        $PDF->SetTextColor(0,0,0);
        $PDF->SetFont('Arial','',10);
        $PDF->Write(3,str_replace("<br />","\r",$consultarOtro->descripcionOtro));
    }
}

 function sub_str($texto,$limite)
{
  $text= [];
  $ini = 0;
  $cant = strlen($texto);
  while ($ini <= $cant) {
     array_push($text, substr($texto,$ini,$limite));
     $ini +=$limite;
  }
  return $text;
}
?>
