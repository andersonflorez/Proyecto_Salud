$(document).ready(function(){
  
  idU =0;
  Nombre = 0;
  apellido =0;
  localStorage.removeItem("nombre");
  localStorage.removeItem("apellido");
  
/*if(localStorage.getItem("id")==0 || localStorage.getItem("nombre")){
  window.location = url + "Programacion/ctrlConsultarUsuarios";
}else {

}*/
 $.ajax({
  url: url + "Programacion/ctrlConsultarUsuarios/consultarPersona",
   type: 'POST',
   dataType: 'json',
   async: false
 }).done(function(data){
    $.each(data,function(s,p){
        var cl = p.pro==0?"btn-registrar":"btn-consultar";
        $("#personal").append("<tr><td class='letras'>"+p.primerNombre+"</td><td class='letras'>"+p.primerApellido+"</td><td class='letras'>"+p.descripcionRol+"</td><td><center><button type='button'   class='btn btn-consultar fa fa-eye' aria-hidden='true' onclick='cargarDatos("+p.idPersona+")'></button></center></td><td> <button type='button' class='btn "+cl+" btn-modal fa fa-calendar' id='teo' onclick='programacion("+p.idPersona+");insertarprogramacion("+'"'+p.idPersona+'"'+","+'"'+p.primerNombre+'"'+","+'"'+p.primerApellido+'"'+","+'"'+p.descripcionRol+'"'+")' ></button></td></tr>");
    });

 
   // Setup - add a text input to each footer cell
   $('#personal tfoot th').each( function () {
     var title = $(this).text();
     $(this).html('<input type="text" placeholder="'+title+'" />'  );
   });
   // DataTable
   var table = $('#personal').DataTable({
     "iDisplayLength": 5,
     "ordering": false,
     "language": {
       "info": "Página _PAGE_ de _PAGES_",
       "infoEmpty": "No hay registros para mostrar",
       "sInfoFiltered": "(Filtrada en _MAX_ registros)",
       "zeroRecords": "No se encontraron registros",
       "search": "Buscar",
       "paginate": {
         "next": "<span class='fa fa-angle-double-right'></span>",
         "previous": "<span class='fa fa-angle-double-left'></span>"
       },
       "lengthMenu": 'N° Registros <select class="form-control">' +
       '<option value="5">5</option>' +
       '<option value="10">10</option>' +
       '<option value="20">20</option>' +
       '<option value="30">30</option>' +
       '<option value="40">40</option>' +
       '<option value="50">50</option>' +
       '<option value="-1">Todos</option>' +
       '</select>',
       "loadingRecords": "Cargando...",
       "processing": "Procesando..."
     }
   });

 }).fail(function(){
  console.log("Error");
 })

if(localStorage.getItem("res")==1){
  Notificate({
    tipo: 'success',
    titulo: 'Notificación de advertencia',
    descripcion: 'Registro exitoso'
  });
  localStorage.setItem("res",0);
}
else if(localStorage.getItem("mon")==1){
  Notificate({
    tipo: 'success',
    titulo: 'Notificación de advertencia',
    descripcion: 'Programación inhabilitada'
  });
  localStorage.setItem("mon",0);
}

 });
function cargarDatos(id){
  window.location = url+"Programacion/ctrlConsultarUsuarios/consultarPersonatodo/"+btoa(id);
}
function Abrirmodalpro(){
  modal = "modal1";
  AbrirModal(modal);
}

function programacion(id){
$.ajax({
type: 'POST',
dataType: 'json',
url: url + "Programacion/ctrlConsultarUsuarios/consultarturno",
data:{'id':id}
}).done(function(data){
if (data == "0"){
   swal({
            title: "Ingresar Programación",
            text: "Registra una nueva programación con turnos",
            showCancelButton: true,
            confirmButtonText: "Ingresar",
            confirmButtonColor: "#2ecc71",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (confirmacion) {
            if (!confirmacion) {
                swal.close();
            } else {
              mandarID();
            }
        });
}else{
swal({
title: "Consultar Programación",
text: "Adiciona una consulta de citas sí exite",
showCancelButton: true,
confirmButtonText: "Consultar",
cancelButtonText: "Cancelar",
closeOnConfirm: false,
closeOnCancel: false
        },
        function (confirmacion) {
            if (!confirmacion) {
                swal.close();
            } else {
              consultarProgramacion();
            }
        });
}
}).fail(function(fail){console.log('fail',fail)})


}


function insertarprogramacion(id,n,a,m){
  idU = id;
  Nombre = n;
  apellido = a;
  especialidad = m;
  localStorage.setItem("especialidad",especialidad);
  localStorage.setItem("nombre", Nombre);
  localStorage.setItem("apellido",apellido);
}

function mandarID(){
localStorage.setItem("id", idU);
  $.ajax({
  type: 'POST',
  datatype: 'json',
  url: url + 'Programacion/ctrlCalendario/traerid',
  data: {"txtID":idU}
}).done(function(){
window.location = url+"Programacion/ctrlCalendario";
}).fail(function(){
alert("m");
})
}



function consultarProgramacion(){


  localStorage.setItem("id", idU);
window.location = url+"Programacion/ctrlCProgramacion";

if(localStorage.getItem("pro")==1){
  Notificate({
    tipo: 'success',
    titulo: 'Notificación de advertencia',
    descripcion: 'Accion exitosa.'
  });
  localStorage.setItem("pro",0);
}

}
