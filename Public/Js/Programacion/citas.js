$(document).ready(function(){
     $.ajax({
       type: 'POST',
       dataType: 'json',
       url: url + "Programacion/ctrlCitas/consultarcitas",
       async: false
   }).done(function(data){
     $.each(data,function(s,p){
       $("#cont-table").append("<tr><td>"+p.medico+"</td><td>"+p.primerNombre +"</td><td>"+p.primerApellido +"</td><td>"+p.numeroDocumento +"</td><td>"+p.horaInicial +"</td><td>"+p.horaFinal +"</td><td>"+p.fecha+"</td><td>"+p.direccionCita+"</td><td>"+p.nombreCUP +"</td></tr>");
     })
   })

   // Setup - add a text input to each footer cell
   $('#example tfoot th').each( function () {
       var title = $(this).text();
       $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
   } );

   // DataTable
   var table = $('#example').DataTable({
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

   // Apply the search
   table.columns().every( function () {
       var that = this;

       $( 'input', this.footer() ).on( 'keyup change', function () {
           if ( that.search() !== this.value ) {
               that
                   .search( this.value )
                   .draw();
           }
       });
   });
});
function Comfirmar(id){
  swal({
    title: "Comfirmar",
    text: "¿Esta seguro que desea comfirmar la cita?",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: true,
  },function() {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "HistoriaClinicaDMC/ctrlRegistrarConsultarCita/ListarCitas",
      async: false
    }).done(function(){

    });
    window.location.assign(url+"HistoriaClinicaDMC/ctrlRegistrarInformacionPersonal/consultar/"+id+"");
  });
};

function Cancelar(id){
  swal({
    title: "An input!",
    text: "Write something interesting:",
    type: "input",
    showCancelButton: true,
     closeOnConfirm: false,
     inputPlaceholder: "Write something" },
     function(inputValue){
       if (inputValue === false)
       return false;
       if (inputValue === "") {
         swal.showInputError("You need to write something!");
         return false
       }
       swal("Nice!", "You wrote: " + inputValue, "success");
   });
};




.done(funtion(a){

var html = '';
$each(a,function(b,c){

  html += ''

});
$('#variable').append(html);


})