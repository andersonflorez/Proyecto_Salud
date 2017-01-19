$(document).ready(function() {

  listarComboRoles();

  function close_accordion_section() {
    $('.accordion .accordion-section-title').removeClass('active');
    $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
  }

  $('.accordion-section-title').click(function(e) {
    // Grab current anchor value
    var currentAttrValue = $(this).attr('href');

    if ($(e.target).is('.active')) {
      close_accordion_section();
    } else {
      close_accordion_section();

      // Add active class to section title
      $(this).addClass('active');
      // Open up the hidden content panel
      $('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
    }

    e.preventDefault();
  });

  $("#slcRol").change(function() {
    var rol = $("#select2-slcRol-container").html();
    $.ajax({
      type:'POST',
      dataType: 'JSON',
      url:url+'Usuarios/ctrlPermisos/consultaAsignacionPermiso',
      data:{"rol":rol}
    }).done(function(e){


      /*Check:false para todos los checks*/
      var datos = array;
      var cont =0;

      for (var i in datos) {
        var vistas = datos[i].Vistas;
        var modulo = datos[i].Modulo;
        $("input[name='"+modulo+"']").prop("checked",false);
        for (var j = 0; j < vistas.length; j++) {
            var value= $("input[name='"+vistas[j].descripcionVista+"']").prop("checked",false);
        }
      }
      /*Check:true para los check asignados*/
      for (var i = 0; i < e.length; i++) {
        $("input[name='"+e[i].descripcionVista+"']").prop("checked",true);
      }

      /*Check:true para los check's(Todos) de cada módulo*/
      for (var i in datos) {
        var vistas = datos[i].Vistas;
        var modulo = datos[i].Modulo;
        var numVistas= vistas.length;
        var contVistas = 0;
        for (var j = 0; j < vistas.length; j++) {
          if ($("input[name='"+vistas[j].descripcionVista+"']").is(":checked")) {
            contVistas++;
          }
        }
        if (numVistas == contVistas) {
          $("input[name='"+modulo+"']").prop("checked",true);
        }
      }
    }).fail(function(data){
//      console.log(data);
    });
  });
});


$("#slcRol").select2({
  placeholder:"Seleccione un rol"
});


function listarComboRoles(){
  $.ajax({
    type:'POST',
    dataType: 'JSON',
    url:url+'Usuarios/ctrlPermisos/ListarComboRoles',
    data:{"":""}
  }).done(function(e){

    $.each(e,function(i,v){

      $('#slcRol').append('<option value="'+v.idRol+'">'+v.descripcionRol+'</option>');
    })
  }).fail(function(){
  })
}


ValidateForm('FormPermisos', function(formdata) {
  var datos = array;
  var valores= [];
  for (var i in datos) {
    var vistas = datos[i].Vistas;
    for (var j = 0; j < vistas.length; j++) {
      if ($("input[name='"+vistas[j].descripcionVista+"']").is(":checked")) {
        var campo = $("#slcRol").val();
        var value= $("input[name='"+vistas[j].descripcionVista+"']").val();
         id =  value.split("-");
        valores.push({"rol":campo,"modulo":id[0],"idVista":id[1]});
      }
    }
  }
//  console.log(valores);
  $.ajax({
    type:'POST',
    dataType: 'JSON',
    url:url+'Usuarios/ctrlPermisos/AsignarPermisos',
    data:{"dato":JSON.stringify(valores)}
  }).done(function(){
    var descripcion = 'Se han asignado los permisos exitosamente';
    Notificate({
      titulo: '¡Éxito!',
      descripcion: descripcion,
      tipo: 'success',
      duracion: 4
    });
  }).fail(function(data){
//    console.log(data);
    Notificate({
      titulo: '¡Error!',
      descripcion: "Error al registrar el/los permiso(s)",
      tipo: 'error',
      duracion: 4
    });
  });
});


function check(id){

  var modulo;

    for (var indice in array) {
      if (array.hasOwnProperty(indice) && Number(array[indice].idModulo) === Number(id)) {
        modulo = array[indice];
      }
    }

    var vistas = modulo.Vistas;
    if ($("input[name='"+modulo.Modulo+"']").is(":checked")) {
      for (var i = 0; i < vistas.length; i++) {
        $("input[name='"+vistas[i].descripcionVista+"']").prop("checked",true);
      }
    }else{
      for (var i = 0; i < vistas.length; i++) {
        $("input[name='"+vistas[i].descripcionVista+"']").prop("checked",false);
      }
    }
}
