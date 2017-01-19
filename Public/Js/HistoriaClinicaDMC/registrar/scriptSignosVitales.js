$(document).ready(function () {
  $("#btnAbreviaturas").click(function(){
        swal({   
            title: "Convenciones",   
            text:"<div style='text-align: left;margin-left: 80px;'><b>FC: </b> Frecuencia Cardiaca<br><b>T.A.S: </b> Tensión arteria sistolica<br><b>T.A.D: </b> Tensión arteria diastolica<br><b>FR: </b> Frecuencia respiratoria<br><b>Temperatura °C: </b> Temperatura corporal en °C<br><b>E.C.Glasgow: </b> Escala de coma de glasgow<br><b>Sp02: </b> Saturacion Porcentual de oxigeno<br><b>Glucometria: </b> Glucosa en la sangre<br></div>",   
            html:true,  
            confirmButtonText: "Aceptar",
            closeOnConfirm: true
        });
    });
    /*validar hora progresiva*/
    var fechaSig1, s1, hoursS1, minutesS1, minutesS1String;
    var fechaSig2, s2, hoursS2, minutesS2, minutesS2String;
    var fechaSig3, s3, hoursS3, minutesS3, minutesS3String;
    var fechaSig4, s4, hoursS4, minutesS4, minutesS4String;
  
    var splitHoraCita,hourCita,minuteCita;
   
console.log(horaCita);

    $("#txtSignoVital0-1").focusout(function () {

        if ($("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1 && $("#txtSignoVital0-4").val().length > 1) {
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS2 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS1 > minutesS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }else if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        } 
        /*grupo 3*/
        else if($("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS2 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS1 > minutesS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS1 && minutesS3 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS1 && minutesS1 > minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }else if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS2 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS1 > minutesS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }else if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        }
        /*grupo 2*/
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
         minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS2 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS1 > minutesS2) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }else if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia',
                    descripcion: 'La hora: ' + hoursS1 + ':' + minutesS1String + ' no puede ser mayor que la hora: ' + hoursS2 + ':' + minutesS2String + '.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS1 && minutesS3 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS1 && minutesS1 > minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia',
                    descripcion: 'La hora: ' + hoursS2 + ':' + minutesS2String + ' no puede ser menor que la hora: ' + hoursS1 + ':' + minutesS1String + '.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }else if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-4").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];

            if (hoursS1 > hoursS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia',
                    descripcion: 'La hora: ' + hoursS1 + ':' + minutesS1String + ' no puede ser mayor que la hora: ' + hoursS2 + ':' + minutesS2String + '.'
                });
                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS1 && minutesS4 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS1 && minutesS1 > minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia',
                    descripcion: 'La hora: ' + hoursS2 + ':' + minutesS2String + ' no puede ser menor que la hora: ' + hoursS1 + ':' + minutesS1String + '.'
                });

                $("#txtSignoVital0-1").focus();
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-4").attr("disabled", "disabled");


            }else if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig1 = $("#txtSignoVital0-1").val();
        s1 = fechaSig1.split(":");
        hoursS1 = Number(s1[0]);
        minutesS1 =Number(s1[1]);
            if(hoursS1<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS1==hourCita && minuteCita>minutesS1){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-1").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
            $("#txtSignoVital0-3").attr("disabled",false);
            $("#txtSignoVital0-2").attr("disabled",false);
            $("#txtSignoVital0-4").attr("disabled",false);
          }
            
        }
  
        
        if($("#txtSignoVital0-1").val().length < 1){
            
            $("#txtSignoVital0-4").attr("disabled",false);
            $("#txtSignoVital0-2").attr("disabled",false);
            $("#txtSignoVital0-3").attr("disabled",false);
            
        }
            
        


    });

    $("#txtSignoVital0-2").focusout(function () {
        /*grupo de 4*/
        if ($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 ) {
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
        
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS4 && minutesS2 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS2 && minutesS2 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2 > hoursS3){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2 == hoursS3 && minutesS2 == minutesS3){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3 == hoursS2 && minutesS2 > minutesS3){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS1 > hoursS2){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS1 == hoursS2 && minutesS1 == minutesS2){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS1 == hoursS2 && minutesS1 > minutesS2){
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la mayor.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else{
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }

        }
        /*grupo de 3*/
        else if ($("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1  && $("#txtSignoVital0-4").val().length > 1) {
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS4 && minutesS2 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS1 == hoursS2 && minutesS2 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2 > hoursS3){
                  Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3 == hoursS2 && minutesS2 == minutesS3){
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3 == hoursS2 && minutesS2 > minutesS3){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
            

        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS3 && minutesS2 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS3 && minutesS2 > minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS1 > hoursS2){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2 == hoursS1 && minutesS2 == minutesS1){
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2 == hoursS1 && minutesS1 > minutesS2){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2<hourCita){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
            }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }

       }
       else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-4").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
           
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS4 && minutesS2 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS4 && minutesS2 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS1 > hoursS2){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
                
            }else if(hoursS2 == hoursS1 && minutesS2 == minutesS1){
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2 == hoursS1 && minutesS1 > minutesS2){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
           
        }
        /*grupo de 2*/
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS4 && minutesS2 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS4 && minutesS2 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-3").val().length > 1 && $("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS3 && minutesS2 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS3 && minutesS2 > minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS1 > hoursS2) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS2 == minutesS1) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS1 && minutesS1 > minutesS2) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-2").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-3").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
            
        }
        else if($("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig2 = $("#txtSignoVital0-2").val();
        s2 = fechaSig2.split(":");
        hoursS2 = Number(s2[0]);
        minutesS2 =Number(s2[1]);
            if(hoursS2<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS2==hourCita && minuteCita>minutesS2){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-2").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
            $("#txtSignoVital0-3").attr("disabled",false);
            $("#txtSignoVital0-4").attr("disabled",false);
            $("#txtSignoVital0-1").attr("disabled",false);
          }
            
        }
        
        
        if($("#txtSignoVital0-2").val().length < 1){
            $("#txtSignoVital0-4").attr("disabled",false);
            $("#txtSignoVital0-3").attr("disabled",false);
            $("#txtSignoVital0-1").attr("disabled",false);
        }
           
       


    });

    $("#txtSignoVital0-3").focusout(function () {
            /*grupo de 4*/
        if ($("#txtSignoVital0-3").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-4").val().length > 1) {
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS3 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS3 && minutesS4 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS4 && minutesS3 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS3 < hoursS2){
                  Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
                
            }else if(hoursS3 == hoursS2 && minutesS3 == minutesS2){
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3 == hoursS2 && minutesS3 < minutesS2){
                  Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }

        }
            /*grupo de 3*/
        else if($("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1  && $("#txtSignoVital0-4").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS3 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS3 && minutesS4 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS4 && minutesS3 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS2 > hoursS3){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3 == hoursS2 && minutesS3 == minutesS2){
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3 == hoursS2 && minutesS2 > minutesS3){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS3 && minutesS2 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS2 && minutesS2 > minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1 && $("#txtSignoVital0-4").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS3 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS3 && minutesS4 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS4 && minutesS3 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS1 > hoursS3){
                  Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
                
            }else if(hoursS3 == hoursS1 && minutesS3 == minutesS1){
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS3 == hoursS1 && minutesS1 > minutesS3){
                  Notificate({
                    tipo: 'warning',
                    titulo: '11Notificación de advertencia',
                    descripcion: 'La hora: ' + hoursS3 + ':' + minutesS3String + ' no puede ser mayor que la hora: ' + hoursS4 + ':' + minutesS4String + '.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");
            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             }else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        /*grupo de 2*/
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS3 > hoursS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS4 == hoursS3 && minutesS4 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS4 && minutesS3 > minutesS4) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             }else if(hoursS3==hourCita && minuteCita>minutesS3){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS2 > hoursS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS2 == hoursS3 && minutesS2 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS2 && minutesS2 > minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
            minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS1 > hoursS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS1 == hoursS3 && minutesS1 == minutesS3) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            } else if (hoursS3 == hoursS1 && minutesS1 > minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-3").focus();
                $("#txtSignoVital0-4").attr("disabled", "disabled");
                $("#txtSignoVital0-2").attr("disabled", "disabled");
                $("#txtSignoVital0-1").attr("disabled", "disabled");

            }else if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             } else {
                $("#txtSignoVital0-4").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-3").val().length > 1){
            
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig3 = $("#txtSignoVital0-3").val();
        s3 = fechaSig3.split(":");
        hoursS3 = Number(s3[0]);
            minutesS3 =Number(s3[1]);
            if(hoursS3<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             }else if(hoursS3==hourCita && minuteCita>minutesS3){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-3").focus();
                      $("#txtSignoVital0-4").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-1").attr("disabled",true);
             }else{
            $("#txtSignoVital0-4").attr("disabled",false);
            $("#txtSignoVital0-2").attr("disabled",false);
            $("#txtSignoVital0-1").attr("disabled",false);
             }
            
        }
        
        
        
        if($("#txtSignoVital0-3").val().length < 1){
            $("#txtSignoVital0-4").attr("disabled",false);
            $("#txtSignoVital0-2").attr("disabled",false);
            $("#txtSignoVital0-1").attr("disabled",false);
        }
        
    });

    $("#txtSignoVital0-4").focusout(function () {

        if ($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1) {
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS3 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS3 == hoursS4 && minutesS3 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS3 && minutesS4 < minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        /*grupo 3*/
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-1").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS2 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS2 == hoursS4 && minutesS2 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS2 && minutesS4 < minutesS2) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
            
        }
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-2").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
            
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS3 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS3 == hoursS4 && minutesS3 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS3 && minutesS4 < minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-1").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
            
           fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS3 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS3 == hoursS4 && minutesS3 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS3 && minutesS4 < minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
        }
        /* grupo 2*/
       else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-2").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
           
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS2 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS2 == hoursS4 && minutesS2 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS2 && minutesS4 < minutesS2) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
       }
       else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-1").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
           
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS1 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS1 == hoursS4 && minutesS1 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS1 && minutesS4 < minutesS1) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
       }
       else if($("#txtSignoVital0-4").val().length > 1 && $("#txtSignoVital0-3").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
           
            fechaSig1 = $("#txtSignoVital0-1").val();
            s1 = fechaSig1.split(":");
            hoursS1 = Number(s1[0]);
            minutesS1 = Number(s1[1]);
            minutesS1String = s1[1];

            fechaSig2 = $("#txtSignoVital0-2").val();
            s2 = fechaSig2.split(":");
            hoursS2 = Number(s2[0]);
            minutesS2 = Number(s2[1]);
            minutesS2String = s2[1];

            fechaSig3 = $("#txtSignoVital0-3").val();
            s3 = fechaSig3.split(":");
            hoursS3 = Number(s3[0]);
            minutesS3 = Number(s3[1]);
            minutesS3String = s3[1];

            fechaSig4 = $("#txtSignoVital0-4").val();
            s4 = fechaSig4.split(":");
            hoursS4 = Number(s4[0]);
            minutesS4 = Number(s4[1]);
            minutesS4String = s4[1];


            if (hoursS4 < hoursS3 ) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });
                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);

            } else if (hoursS3 == hoursS4 && minutesS3 == minutesS4) {
                Notificate({
                    tipo: 'warning',
                    titulo: 'Notificación de advertencia ',
                    descripcion: 'las horas no pueden ser la misma.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            } else if (hoursS4 == hoursS3 && minutesS4 < minutesS3) {
                 Notificate({
                    tipo: 'warning',
                    titulo: 'Cuidado',
                    descripcion: 'La hora tiene que ser progresiva.'
                });

                $("#txtSignoVital0-4").focus();
                $("#txtSignoVital0-3").attr("disabled", true);
                $("#txtSignoVital0-2").attr("disabled", true);
                $("#txtSignoVital0-1").attr("disabled", true);
            }else if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             } else {
                $("#txtSignoVital0-3").attr("disabled", false);
                $("#txtSignoVital0-2").attr("disabled", false);
                $("#txtSignoVital0-1").attr("disabled", false);
            }
       }
       else if($("#txtSignoVital0-4").val().length > 1){
        splitHoraCita = horaCita.split(":");
        hourCita=  Number (splitHoraCita[0]);
        minuteCita = Number(splitHoraCita[1]);
        
        fechaSig4 = $("#txtSignoVital0-4").val();
        s4 = fechaSig4.split(":");
        hoursS4 = Number(s4[0]);
        minutesS4 = Number(s4[1]);
            if(hoursS4<hourCita){
                   Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else if(hoursS4==hourCita && minuteCita>minutesS4){
                 Notificate({
                       tipo: 'warning',
                       titulo: 'Notificación de advertencia',
                       descripcion: 'La hora no puede ser menor que la hora de la cita'    
                   });
                 
                      $("#txtSignoVital0-4").focus();
                      $("#txtSignoVital0-1").attr("disabled",true);
                      $("#txtSignoVital0-2").attr("disabled",true);
                      $("#txtSignoVital0-3").attr("disabled",true);
             }else{
            $("#txtSignoVital0-3").attr("disabled",false);
            $("#txtSignoVital0-2").attr("disabled",false);
            $("#txtSignoVital0-1").attr("disabled",false);
          }
            
        }
        
        
        
        if($("#txtSignoVital0-4").val().length < 1){ 
            $("#txtSignoVital0-3").attr("disabled",false);
            $("#txtSignoVital0-2").attr("disabled",false);
            $("#txtSignoVital0-1").attr("disabled",false);
            
        }


    });


   /* fin validar hora progresiva*/
    
    ValidateForm('frmSignosVitales', function (formData) {
        var registros = [];

        for (var i = 1; i <= 8; i++) {
            for (var j = 1; j <= 4; j++) {
                registros.push({
                    hora: $("#txtSignoVital0-" + j).val(),
                    idValoracion: btoa(i),
                    resultado: $("#txtSignoVital" + i + "-" + j).val()
                });
            }
        }
        localStorage.setItem("signosVitales", btoa(JSON.stringify(registros)));
        window.location = url + "HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico/index/" + idPaciente + "/" + idCita + "/" + idCitaProgramacion;
    });
    
     $("#txtSignoVital0-1").timepicker({
        timeFormat: 'H:i',
        minTime: horaCita,
        maxTime: '23:00',
        step: 60    
    });



    $("#txtSignoVital0-2").timepicker({
        timeFormat: 'H:i',
        minTime: horaCita,
        maxTime: '23:00',
        step: 60
    });

    $("#txtSignoVital0-3").timepicker({
        timeFormat: 'H:i',
        minTime: horaCita,
        maxTime: '23:00',
        step: 60
    });
    $("#txtSignoVital0-4").timepicker({
        timeFormat: 'H:i',
        minTime: horaCita,
        maxTime: '23:00',
        step: 60
    });


    if (localStorage.getItem("signosVitales") != null) {
        var registrosSignosVitales = JSON.parse(atob(localStorage.getItem("signosVitales")));
        for (var j = 0; j < 4; j++) {
            $("#txtSignoVital0-" + (j + 1)).val(registrosSignosVitales[j].hora);
        }
        var h = 0;
        for (var i = 1; i <= 8; i++) {
            for (var j = 1; j <= 4; j++) {
                $("#txtSignoVital" + i + "-" + j).val(registrosSignosVitales[h].resultado);
                h++;
            }
        }
    }

    if (localStorage.getItem("signosVitales") == null) {
        var cont = 1;
        var cont1 = 0;

        for (var i = 0; i < 9; i++) {

            for (var e = 0; e < 5; e++) {
                $("#txtSignoVital" + cont + "-" + e + "").attr("disabled", true);

            }
            cont++;
        }



    } else {
        if ($("#txtSignoVital0-1").val().length > 1) {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-1").attr("disabled", false);
            }

        } else {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-1").attr("disabled", true);
                $("#txtSignoVital" + i + "-1").val("");
            }
        }

        if ($("#txtSignoVital0-2").val().length > 1) {
            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-2").attr("disabled", false);
            }

        } else {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-2").attr("disabled", true);
                $("#txtSignoVital" + i + "-2").val("");
            }

        }

        if ($("#txtSignoVital0-3").val().length > 1) {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-3").attr("disabled", false);
            }

        } else {
            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-3").attr("disabled", true);
                $("#txtSignoVital" + i + "-3").val("");
            }
        }

        if ($("#txtSignoVital0-4").val().length > 1) {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-4").attr("disabled", false);
            }
        } else {
            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-4").attr("disabled", true);
                $("#txtSignoVital" + i + "-4").val("");
            }

        }
    }

    $("#txtSignoVital0-4").focusout(function () {

        if ($("#txtSignoVital0-4").val().length > 1) {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-4").attr("disabled", false);
            }
        } else {
            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-4").attr("disabled", true);
                $("#txtSignoVital" + i + "-4").val("");
            }

        }
    });

    $("#txtSignoVital0-3").focusout(function () {

        if ($("#txtSignoVital0-3").val().length > 1) {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-3").attr("disabled", false);
            }

        } else {
            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-3").attr("disabled", true);
                $("#txtSignoVital" + i + "-3").val("");
            }
        }
    });

    $("#txtSignoVital0-2").focusout(function () {
        if ($("#txtSignoVital0-2").val().length > 1) {
            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-2").attr("disabled", false);
            }

        } else {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-2").attr("disabled", true);
                $("#txtSignoVital" + i + "-2").val("");
            }

        }
    });

    $("#txtSignoVital0-1").focusout(function () {
        if ($("#txtSignoVital0-1").val().length > 1) {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-1").attr("disabled", false);
            }

        } else {

            for (var i = 1; i < 9; i++) {
                $("#txtSignoVital" + i + "-1").attr("disabled", true);
                $("#txtSignoVital" + i + "-1").val("");
            }
        }
    });



});
