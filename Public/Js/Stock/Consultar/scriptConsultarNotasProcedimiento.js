$(document).ready(function(){
    

    // Setup - add a text input to each footer cell
   $('#tablaNotas tfoot th').each( function () {
       var title = $(this).text();
       $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
   } );

   // DataTable
   var table = $('#tablaNotas').DataTable({
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



function Agregar(){
  swal({
    title: "Nota procedimiento",
    text: "Descripción de la nota:",
    text: "<textarea height="+50+"></textarea>",
      html:true,
    showCancelButton: true,
     closeOnConfirm: false,
     inputPlaceholder: "Nota" },
     function(inputValue){
       if (HTMLTextAreaElement === false)
       return false;
       if (HTMLTextAreaElement === "") {
         swal.showInputError("You need to write something!");
         return false
       }
       swal("Nice!", "You wrote: " + inputValue, "success");
   });
};

function alert(){
    alert('hola');
}