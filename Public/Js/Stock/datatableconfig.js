var idTabla = "";
var config = {
    "functionUpdate": "",
    "functionDisable": ""
}
var opcion = {
    "info": "Mostrando desde el _START_ hasta el _END_. Página _PAGE_ de _PAGES_",
    "infoEmpty": "No hay registro para mostrar",
    "sInfoFiltered": "(filtrada en _MAX_ registros)",
    "zeroRecords": "No se encontraron registros",
    "search": "Buscar:",
    "paginate": {
        "next": "Siguiente",
        "previous": "Atras"
    },
    "lengthMenu": 'Mostrar <select class="form-control">' +
    '<option value="5">5</option>' +
    '<option value="10">10</option>' +
    '<option value="20">20</option>' +
    '<option value="30">30</option>' +
    '<option value="40">40</option>' +
    '<option value="50">50</option>' +
    '<option value="-1">All</option>' +
    '</select>',
    "loadingRecords": "Cargando...",
    "processing": "Procesando..."
};


function modificar(cadena) {
    var registros = cadena.split("-");
    config.functionUpdate(registros);
    $('#Vayase').addClass('animated fadeOutLeft');
    $('#Registro').show(2000);
    $('#Registro').add('animated fadeInLeft');
    $('#tblCups').hide(3000);
}
function cambiarEstado(cadena,estado) {
    config.functionDisable(cadena,estado);
}
