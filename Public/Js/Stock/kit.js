$(document).ready(function(){
  $("#containerTableRecursos").hide();
  $("#containerFormActualizarKit").hide();
  ConsultarTiposDeKit();
  ListaridRecurso();
  ConsultarKit();
  agregar();
  $(".select").select2({
  });

//Boton Registrar
  $('#btnRegistrarKit').click(function(){
    var form = $("#formRegistroKit");
    var valor=form.valid();
    if (valor==true) {
      RegistrarKit();
      $('#formRegistroKit')[0].reset();
      Notificate({
        tipo: 'success',
        titulo: 'Éxito',
        descripcion: 'Registro de Recursos Exitoso.',
        duracion: 2
      });
    }else {
      Notificate({
        tipo: 'error',
        titulo: '¡Error!',
        descripcion: 'Verifica que toda La información esté correcta.',
        duracion: 2
      });
    }
  });
//Función Registrar Kit
  RegistrarKit = function(){
    $.ajax({
      type : 'POST',
      dataTypen: 'json',
      url : url + "Stock/ctrlKit/RegistrarKit",
      data : new FormData (document.getElementById("formRegistroKit")),
      contentType: false,
      processData: false
    }).done(function(){

    }).fail(function(){
      Notificate({
        tipo: 'error',
        titulo: '¡Error!',
        descripcion: 'Verifica que toda La información esté correcta.',
        duracion:2
      });
    })
  }


});//Cierre document.ready()

//Consulta Tipos de Kit
function ConsultarTiposDeKit(){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Stock/ctrlKit/ListarTipoKit",
    async: false
  }).done(function(data){
    $("#containerTable").html('<table id="examples" class="tbl_scroll"><thead><tr><th>Tipo Kit</th><th>Estado</th><th>Añadir</th><th>Ver</th></tr></thead><tfoot><tr><th>Tipo Kit</th><th>Estado</th><th>Añadir</th><th>Ver</th></tr></tfoot><tbody id="cont-table1"></tbody></table>');
    $("#cont-table1").empty();
    $.each(data,function(s,p){
      $("#cont-table1").append("<tr><td>"+p.descripcionTipoKit +"</td><td>"+p.estadoTabla +"</td><td><button type='button'class=' fa fa-plus btn btn-consultar' name='btnRegistros' OnClick='traerId("+p.idTipoKit+")'></button></td><td><button value='"+ p.idTipoKit+"' type='button'  id='btnVer"+p.idTipoKit+"' class=' fa fa-eye btn btn-consultar' name='btnRegistros' OnClick=' mostrar("+p.idTipoKit+")'></button></td></tr>");
    });
  });
  $('#examples tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  });
  var table = $('#examples').DataTable({
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
}

function mostrar(id){
  $("#containerTableRecursos").show();
  $("#containerTable").hide();
  ConsultarKit(id);
}

//Consulta Recursos de Kit
function ConsultarKit(id){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Stock/ctrlKit/ConsultarKit",
    async: false,
    data: {'idTipoKit':id}
  }).done(function(data){
    $("#containerTableRecursos").html('<table id="example" class="tbl_scroll"><thead><tr><th>Recurso Kit</th><th>Stock Minimo</th><th>Estado</th><th>&nbsp;&nbsp;&nbsp;&nbsp;Modificar&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr></thead><tfoot><tr><th>Recurso Kit</th><th>Stock Minimo</th><th>Estado</th><th style="display:none;">Modificar</th><th style="display:none;"><i class="fa fa-lock"></i>/<i class="fa fa-unlock"></i></th></tr></tfoot><tbody id="cont-table"></tbody></table><button id="btnvolver" title="Volver" class="flecha-izq fa fa-long-arrow-left"></button>');
    $('#btnvolver').click(function(){
      $("#containerTable").show();
      $("#containerTableRecursos").hide();
    });
    $("#cont-table").empty();
    $.each(data,function(s,p){
      if (p.estadoTablaEstandarKit == "Activo") {
        icono = "fa fa-lock";
        classbtn = "btn btn-eliminar";
      }else{
        icono = "fa fa-unlock";
        classbtn = "btn btn-habilitar";
      }
      var Recurso = p.stockminKit+'   '+p.unidadMedida;
      $("#cont-table").append("<tr><td>"+p.nombre +"</td><td>"+Recurso+"</td><td>"+p.estadoTablaEstandarKit +"</td><td><button type='button'class=' fa fa-pencil btn btn-consultar' name='btnRegistros' OnClick='Redireccionar("+p.idEstandarkit+")'></button></td><td> <button value='"+ p.idEstandarkit+"' type='button' class='"+classbtn+"' id='btnCambiarEstado"+p.idEstandarkit+"' OnClick=\"CambiarEstado("+p.idEstandarkit+",'"+p.estadoTablaEstandarKit+"')\"><span class='"+icono+"'></span></button></td></tr>");
    });
  });
  $('#example tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  });
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
}

$('#btnCancelar').click(function(){
    $("#containerFormActualizarKit").hide();
    $("#containerTableRecursos").show();
  });

//Cargar y Actualizar Datos
function Redireccionar(id){
  $("#containerTableRecursos").hide();
  $("#containerFormActualizarKit").show();
  $.ajax({
    url: url+"Stock/ctrlKit/traerId",
    type:'POST',
    data:{'id':id},
    dataType:'json'
  }).done(function(data){
    console.log(data);
    $("#txtidEstandarKitA").val(data.idEstandarkit);
    $("#slcidRecursoA > option[value='"+data.idRecurso+"']").attr("selected", "selected");
    $("#slcunidadMedidaA > option[value='"+data.unidadMedida+"']").attr("selected", "selected");
    $("#txtstockminKitA").val(data.stockminKit);
    $("#slctipokitA > option[value='"+data.idTipoKit+"']").attr("selected", "selected");
    $(".select").select2({
    });
  }).fail(function(error){
    console.log(error);
  });
};

//Función Actualizar Kit.
$('#btnActualizarKits').click(function(){
  var form = $("#formModificarKit");
  var valor=form.valid();
  if (valor==true) {
    ActualizarKit();
        $("#containerFormActualizarKit").hide();
    $("#containerTableRecursos").show();
  }else {
    Notificate({
      tipo: 'error',
      titulo: '¡Error!',
      descripcion: 'Verifica que toda La información esté correcta.'
    });
  }
});

ActualizarKit = function(){
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url + "Stock/ctrlKit/ActualizarKit",
    data : new FormData (document.getElementById("formModificarKit")),
    contentType: false,
    processData: false
  }).done(function () {

  }).fail(function () {
    Notificate({
      tipo: 'error',
      titulo: '¡Error!',
      descripcion: 'Verifica que toda La información esté correcta.'
    });
  })
}

//Cambiar Estado De Kit.
function CambiarEstado(idEstandarkit, estadoTablaEstandarKit) {
  $.ajax({
    url: url + "Stock/ctrlKit/CambiarEstadoEstandarKit",
    type: 'POST',
    data: {'idEstandarkit':idEstandarkit, 'estadoTablaEstandarKit':estadoTablaEstandarKit}
  }).done(function(data) {
    var Estado;
    var btn = $('#btnCambiarEstado'+idEstandarkit);
    var row = btn.parent().parent();
    var colEstado = row.find('td:nth-last-child(3)');
    if (data == "1") {
      if (estadoTablaEstandarKit == 'Activo') {
        Estado = 'Inactivo';
        btn.removeClass('btn btn-eliminar');
        btn.addClass('btn btn-habilitar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-unlock');
        colEstado.text(Estado);
      } else {
        Estado = 'Activo';
        btn.removeClass('btn btn-habilitar');
        btn.addClass('btn btn-eliminar');
        btn.children('span').removeClass();
        btn.children('span').addClass('fa fa-lock');
        colEstado.text(Estado);
      }
      btn.attr("onclick","CambiarEstado('"+idEstandarkit+"','"+Estado+"')");
    } else {
    }
  }).fail(function(err) {
  });
}

//Cargar ID de Tipo Kit
function traerId(id){
  AbrirModal('ModalRegistroKit');
  $.ajax({
    url: url+"Stock/ctrlKit/traerIdKit",
    type:'POST',
    data:{'id':id},
    dataType:'json'
  }).done(function(data){
    $("#slctipokit").val(data.idTipoKit);

  });
};
