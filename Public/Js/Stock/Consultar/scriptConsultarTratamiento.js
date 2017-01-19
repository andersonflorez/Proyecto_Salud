
$(document).ready(function(){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + "Stock/CtrlConsultarTratamiento/ListarTratamiento",
        async: false
    }).done(function(data){
      console.log(data);
        var num = 1
        var id = btoa(num);
        $.each(data,function(s,p){
          console.log(p);
            $("#cont-tables").append("<tr><td>"+p.primerNombre +" "+p.primerApellido+" "+p.segundoApellido +"</td><td>"+p.numeroDocumento+"</td><td>"+p.ciudadResidencia+" - "+p.barrioResidencia+"</td><td>"+p.nombre+"</td><td>"+p.descripcionTratamiento+"</td><td><button type='button' class='fa fa-eye btn btn-consultar' name='bntConsultar' onclick='ver("+p.idPaciente+")'></button></td></tr>");
        });
    }).fail(function(){});

    // Setup - add a text input to each footer cell
    $('#tabla tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder=" '+title+'" />' );
    });

    // DataTable
    var table = $('#tabla').DataTable({
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


function ver(id){
    id=btoa(id);
    window.location.assign(url+"Stock/CtrlConsultarAtencionTratamiento/Index/"+id+"");
};
