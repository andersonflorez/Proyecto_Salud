
$(document).ready(function(){
  listarComboTipoAsignacion();
  listarComboAmbulancia();
  listarComboPaciente();
  listarComboPersona();
  ValidateForm('formAsignacion');
});



$('#btnRegistrarAsignacion').click(function(){
  let option=$("#txtTipoAsignacion").val();
  if (option == 1 ) {
    var idRecursos = [];
    var cantRecursos = [];
    console.log($("#RegistrarEstandar").children().eq(4).children().eq(0).html());
    for(var i=1;i<$("#RegistrarEstandar").children().length;i++){
      idRecursos.push($("#RegistrarEstandar").children().eq(i).children().eq(0).html());
      cantRecursos.push($("#RegistrarEstandar").children().eq(i).children().eq(2).html());
    }
    $.ajax({
      type : 'POST',
      dataType: 'json',
      url : url + "Stock/ctrlRegistroAsignacion/RegistrarAsignacion",
      data : new FormData (document.getElementById("formAsignacion")),
      contentType: false,
      processData: false
    }).done(function(){
     $.ajax({
      type:'POST',
      dataType:'JSON',
      url:url+"Stock/ctrlregistroAsignacion/listarComboidAsignacion",
      data:{"":""},
      async: false
    }).done(function(r){
     var idAsignacion = r[0].idAsignacion;
     $.ajax({
      type : 'POST',
      dataType: 'json',
      url : url + "Stock/ctrlregistroAsignacion/RegistrarRecursosAsignacion",
      data : {
        'idAsignacion':idAsignacion,
        'cantidadAsignada':cantRecursos,
        'idrecurso':idRecursos}
    }).done(function(){
     
    }).fail(function(){
      Notificate({
          tipo: 'success',
          titulo: 'Registro Exitoso',
          descripcion: 'La asignación se registró exitosamente.'
        });
    });
    console.log('registre');
  }).fail(function(){
    console.log('no registre');
  });
}).fail(function(){
  console.log('no registre');
});
}else{
  RegistrarAsignacion();
}
});



function RegistrarAsignacion(){
  $.ajax({
    type : 'POST',
    dataType: 'json',
    url : url + "Stock/ctrlRegistroAsignacion/RegistrarAsignacion",
    data : new FormData (document.getElementById("formAsignacion")),
    contentType: false,
    processData: false
  }).done(function(data){
         if(data  === 1){
        Notificate({
          tipo: 'success',
          titulo: 'Registro Exitoso',
          descripcion: 'La asignación se registró exitosamente.'
        });
      }else if(data === 2){
        Notificate({
          tipo: 'error',
          titulo: 'Error',
          descripcion: 'No se pudo registrar.'
        });
      }
  }).fail(function(){
       Notificate({
        tipo: 'error',
        titulo: 'Error',
        descripcion: 'Ocurrió un error inesperado.'
      });
  });
  RegistrarRecursosAsignacion();
}

function RegistrarRecursosAsignacion(){
 $.ajax({
  type:'POST',
  dataType:'JSON',
  url:url+"Stock/ctrlregistroAsignacion/listarComboidAsignacion",
  data:{"":""},
  async: false
}).done(function(r){
 var idAsignacion = r[0].idAsignacion;
 $.ajax({
  type : 'POST',
  dataType: 'json',
  url : url + "Stock/ctrlregistroAsignacion/RegistrarRecursosAsignacion",
  data : "idAsignacion="+idAsignacion+""+"&"+$("#formRecursosAsignacion").serialize()
}).done(function(data){
  if(data  === 1){
        Notificate({
          tipo: 'success',
          titulo: 'Registro Exitoso',
          descripcion: 'La asignación se registró exitosamente.'
        });
      }else if(data === 2){
        Notificate({
          tipo: 'error',
          titulo: 'Error',
          descripcion: 'No se pudo registrar.'
        });
      }
});
}).fail(function(r) {
  console.log('fail');
});
}




function listarComboTipoAsignacion(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+'Stock/ctrlRegistroAsignacion/listarComboTipoAsignacion',
    data:{"":""}
  }).done(function(u){
    $.each(u,function( d, l){
      $('#txtTipoAsignacion').append('<option value="'+l.idTipoAsignacion+'">'+l.descripcionTipoasignacion+'</option>')
    })
  }).fail(function(u) {
    console.log('fail');
  });
}

function listarComboAmbulancia(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+'Stock/ctrlRegistroAsignacion/listarComboAmbulancias',
    data:{"":""}
  }).done(function(e){
    $.each(e,function( a, b){
      $('#txtCodigoAmbulancia').append('<option value="'+b.idAmbulancia+'">'+b.tipoAmbulancia+'</option>')
    })
  }).fail(function(e) {
    console.log('fail');
  });
}

function listarComboPaciente(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+'Stock/ctrlRegistroAsignacion/listarComboPaciente',
    data:{"":""}
  }).done(function(i){

    $.each(i,function( x, z){
      $('#txtNombrePaciente').append('<option value="'+z.idPaciente+'">'+z.primerNombre+' '+z.segundoNombre+' '+z.primerApellido+' '+z.segundoApellido+'</option>')
    })

  }).fail(function(i) {

    console.log('fail');
  });
}

function listarComboPersona(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+'Stock/ctrlRegistroAsignacion/listarComboPersona',
    data:{"":""}
  }).done(function(o){
    $.each(o,function( j, k){
 // console.log (k);
 $('#txtNombrePersona').append('<option value="'+k.idPersona+'">'+k.primerNombre+' '+k.segundoNombre+' '+k.primerApellido+' '+k.segundoApellido+'</option>')
})
    $(".select2").select2({
    });
  }).fail(function(o) {
//console.log('fail');
});
}


$('#btnActualizarAsignacion').click(function(){
  ActualizarAsignacion();
});
ActualizarAsignacion = function(){
  $.ajax({
    type: 'POST',
 //dataType: 'json',
 url: url + "Stock/ctrlRegistroAsignacion/ActualizarAsignacion",
 data: $("#formAsignacionModificar").serialize()
}).done(function (){
  alert('exito','Modificación Exitosa','El Kit se modificó correctamente.')
  window.location = url+"Stock/ctrlRegistroAsignacion/"
}).fail(function () {
  alert('error','Error al modificar','El Kit no se pudo modificar.');
});
}

$.ajax({
  type: 'POST',
  dataType: 'json',
  url: url + "Stock/ctrlRegistroAsignacion/ConsultarAsignacion",
  async: false
}).done(function(data){
  //console.log(data);
  $("#cont-table").html();
  //console.log(data);
  $.each(data,function(s,p){
    $("#cont-table").append("<tr><td>"+p.descripcionTipoasignacion +"</td><td>"+p.fechaHoraAsignacion +"</td><td>"+p.placaAmbulancia +"</td><td>"+p.numeroDpersona+"</td><td>"+p.numeroDPaciente+"</td><td>"+p.estadoTablaAsignacionKit+"</td><td><button type='button'class=' fa fa-eye btn btn-consultar'  name='btnRegistro' onclick='Redireccionar("+p.idAsignacion+")'></button></td></tr>");
    });

});


$("#btnConsultar").click(function(){
   });
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

  function Redireccionar(id){
     console.log(id);
     $("#panel1").hide();
     $("#panel2").fadeIn(1000);
         detalleKitTbl1(id);
  };

    function detalleKitTbl1(id){
      $.ajax({
  type: 'POST',
  dataType: 'json',
  url: url + "Stock/ctrlConsultarAsignacion/consultarTblDetalleKit",
  data:{
    idAsignacion:id
  }
}).done(function(data){
  $("#cont-tabless").html("");
  console.log(data);
  //console.log(data);
  $.each(data,function(i,h){
  $("#cont-tabless").append("<tr><td>"+h.nombre +"</td><td>"+h.cantidadAsignada+"</td><td>"+h.cantidadFinal+"</td></tr>");  
    });

}).fail(function(data){
  alert("mal");
});

    }
  $("#btnDevolver").click(function(){
       $("#panel1").fadeIn(1000);
     $("#panel2").hide();
  });



  var i= 0;

  $('#txtTipoAsignacion').change(function(){

    let option=(this.value);
    if (option != 2) {
      $("#txtNombrePaciente").val(0);
    };
    if (option ==0){
      $('#txtNombrePaciente').change(function(){
        $('#txtNombrePaciente').prop('selectedIndex',0);
      });
      $("#ca").fadeOut(1000);
      $("#Ambulancia").fadeOut (1000);
      $("#Paciente").fadeOut(1000);

    }else
    if ( option == 1 ){
      listaCompletaRecursoEstandar();
      $("#Ambulancia").fadeIn (1000);
      $("#ca").fadeIn(1000);
      $("#Paciente").fadeOut(1000);

//$("#txtNombrePaciente option:selected").val(-1);


}
else if(option ==2){
  LLamarTablaPrestamo();
  $("#Ambulancia").fadeOut(1000);
  $("#ca").fadeOut(1000);
  $("#Paciente").fadeIn(2000);

}else if(option ==3){
 LLamarTablaPrestamo();
 $("#Ambulancia").fadeIn(1000);
 $("#ca").fadeIn(1000);
 $("#Paciente").fadeOut(1000);


}

$("#txtCodigoAmbulancia").on("change",function(){
  if (this.value >= 1) {
    $("#ca").fadeOut(1000);
  }else{
    $("#ca").fadeIn(1000);
  }
});

$("#txtNombrePersona").on("change",function(){
  if (this.value >= 1) {
    $("#Ambulancia").fadeOut(1000);
  }else{
    $("#Ambulancia").fadeIn(1000);
  }
});

});
