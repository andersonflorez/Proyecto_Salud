/*jshint multistr: true */
/* jshint eqnull:true */

var canLesiones   = 0;  // Lleva la cuanta de cuantas lesiones se han colocado
var lesiones      = []; // Array que almacena las lesionse (puntos del cuerpo)
var infoLesion    = []; // Array que almacena las lesiones que se seleccionan
var listadoCIE10    = []; // Array que almacena el listado de todos los CIE10
var seleccion     = false; // Controla si hay una selección activa
var fuera = $('html'); // Para poder cerrar el menú cuando se da afuera
var puntoAnteriorLocalizado = ''; // Almacena el id del ultimo punto localizado
var idReporteAPH = localStorage.getItem('ReporteAPH-idReporteAPH') || ''; // Almacena el id del reporteAPH que se esta consultando
var options = { // Configuración paginador CIE10
  parent: 'paginadorCI10',
  url: 'ReporteAPH/ctrlLocalizacionLesiones/ListadoCIE10',
  configuration: {
    tableName: '?',
    limit: 5
  }
};


$(document).ready(function () {



  whichWorkMode.then(function (esModoConsulta) {
    // Consulta via Ajax para cargar las lesiones
    generarPaginador();

    // Filtrar cie10
    $('#filterCie10').change(function () {
      options.configuration.filter = $('#filterCie10').val();
      options.configuration.page = 1;
      paginator.view.generateButtons(options)
      .then(function(data) {
        if (data.datos !== null) {
          ListarCIE10(data.datos); // Filtro
          ValidarSeleccion();
        }else {
          noResult('Ningún código(CIE10) coincide con su busqueda.');
        }
      });
    });

    // Listar lesiones de localStorage
    ListarPuntosLocal();

    if (esModoConsulta) {
      consultarDatosPuntos();
      $('#bola_plus').remove();
      $('#btnQuitarS').remove();
      $('#btnGuardarD').remove();
    }else {

      // Click en el cuerpo para agrgar un punto
      $("#img_cuepo_frontal").click(function (event) {
        if(infoLesion[0] === undefined ){
          Notificate({
            tipo: 'info',
            titulo: 'Debes hacer esto primero:',
            descripcion: 'Seleccionar una o varias lesiones',
            duracion: 4
          });
        }else {
          var pos = ubicar(event);
          punto(pos.x , pos.y);
          quitarSeleccion();
        }

      });

      // Selección de las lesiones
      $("#bola_plus").click(function (e) {
        e.stopPropagation();
        $('.menu_lesiones').css({right: '0px'});
        $('.footer_m_lesiones').fadeIn('fast');
        $(".head_m_title b").text('Lesiones');
        $('.head_m_buscar').show('fast');
        $('.body_m_lesiones').css({top:'105px'});
        options.configuration.page = 1;
        paginator.view.generateButtons(options)
        .then(function(data) {
          if (data.datos !== null) {
            ListarCIE10(data.datos); // Reset
            ValidarSeleccion();
          }else {
            noResult('Ningún código(CIE10) coincide con su busqueda.');
          }
        });
      });

      // Evitar que se cierre el menú cuando doy click dentro de el:
      $(".menu_lesiones").click(function (e) {
        e.stopPropagation();
      });

      // Guardar los datos en localStorage:
      $("#btnGuardarD").click(function () {

        swal(
          {
            title: "¿Estas seguro de guardar el diagnóstico?",
            text: "Los datos que acabas de suministrar se guardaran para evitar perdidas.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4EC3F4",
            confirmButtonText: "Si, estoy de acuerdo",
            closeOnConfirm: false
          },

          function(){
            GuardarLocal();
          });
        });



      } //  Fin else


      function SaveAndRedirect(urlView) {

        if (esModoConsulta) {
            validarBarraProgreso(urlView);
        }else{
          swal(
            {
              title: "¿Estas seguro de guardar el diagnóstico?",
              text: "Los datos que acabas de suministrar se guardaran para evitar perdidas.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#4EC3F4",
              confirmButtonText: "Si, estoy de acuerdo",
              closeOnConfirm: false
            },

            function(isConfirm){
              if (isConfirm) {
                GuardarLocal();
                setTimeout(function () {
                  validarBarraProgreso(urlView);
                },2000);
              }else {
                validarBarraProgreso(urlView);
              }

          });

        }
      }

      //Guardar Local Storage al momento de irse de pagina
      $(".flechaCuerpoGuardarLocalI").click(function () {
        SaveAndRedirect("ctrlAntecedentesPaciente");
      });
      $(".flechaCuerpoGuardarLocalD").click(function () {
        SaveAndRedirect("ctrlTratamientoB");
      });


      // Efecto de rotación del cuerpo
      var rotarCuerpo = false;
      $("#btnRotarCuerpo").click(function () {
        $("#img_cuepo_frontal").fadeOut(200);
        if(!rotarCuerpo){
          $("#img_cuepo_frontal").attr("src",url+"Public/Img/ReporteAPH/body1.png");
          rotarCuerpo=true;
        }else {
          $("#img_cuepo_frontal").attr("src",url+"Public/Img/ReporteAPH/body2.png");
          rotarCuerpo=false;
        }
        $("#img_cuepo_frontal").fadeIn(200);
      });


      // Listar los puntos:
      $("#ListarPuntos").click(function (event) {
        $('.footer_m_lesiones').hide();
        $(".head_m_title b").text('Puntos');
        $('.head_m_buscar').hide();
        $('.body_m_lesiones').css({top:'48px'});
        listarPuntos(event);
      });


      // Sirve para cerrar el menu lateral(x)
      $(".head_m_close").click(function () {
        $('.menu_lesiones').css({right: '-1000px'});
        options.configuration.page = 1;
      });

      // Cerrar el menú lateral al dar click fuera de él:
      fuera.click(function() {
        $('.menu_lesiones').css({right: '-1000px'});
        options.configuration.page = 1;
      });


    }, function (err) {
      alert('No se pudó obtener el modo de trabajo.');
    });

  }); // Fin $(document).ready


  /**
  * Esta funcion devuelve la posicion en el eje x - y
  */
  function ubicar(event){
    var posicion = {
      x : event.clientX,
      y : event.clientY
    };
    return posicion;
  }


  /*
  * Esta funcion vuelve a dibujar el punto caundo se reorganizan los id
  * o se consulta de la BD
  */
  function ubicarPunto(posX, posY, idPunto) {
    $("#"+idPunto).css({
      top  : posY+"%",
      left : posX+"%"
    });
  }


  /*
  * Esta funcion dibuja un punto con las cordenadas especificadas
  */
  function punto(posX , posY){

    // Almacena la cantidad de puntos que hay en el cuerpo
    canLesiones++;

    // Arma la estructura del #id
    var idLesion = 'Puntolesion_' + canLesiones;

    // Ancho y alto del contenedor del cuerpo
    var ancho = $("#cont_cuerpo").width();
    var alto = $("#cont_cuerpo").height();

    // Distancia del scroll con respecto a la parte superior de la ventana
    var scroll = $(window).scrollTop();

    // Calculo de la posición  para el punto , teniendo en cuenta la posición del scroll y los 60px de alto de la bara de navegación de la página.
    var totalY = (posY + scroll) - 133;

    // Creación de un punto en el DOM
    $("#cont_cuerpo").append("<div class='lesion' id='"+idLesion+"' onclick='consultarLesion("+ lesiones.length +" , this.id, event)'></div>");

    // Ubicaciones en el eje x - y para el punto
    var puntoX =( (posX * 100)/ancho) - 0.4;
    var puntoY = (totalY * 100)/alto;

    // Ubicar el punto en las cordenadas correspondientes
    $("#" + idLesion).css({
      top  : puntoY + "%",
      left : puntoX + "%"
    });

    // Crear objeto temporal para almacenar la información del punto
    var tempLesion={
      'infoPunto':{
        'posX':puntoX,
        'posY':puntoY
      },
      'infoLesion':infoLesion
    };

    // Agreagar tempLesion al final del arreglo lesiones
    lesiones.push(tempLesion);

  }


  /**
  * Esta funcion se encarga buscar una lesión
  */
  function buscarLesion (idFiltro) {
    for (var i = 0; i < infoLesion.length; i++) {
      if(infoLesion[i].id == idFiltro) {
        return i;
      }
    }
    return -1;
  }


  /**
  * Esta funcion se encarga de obtener informacion relevante sobre la lesion
  */
  function InfoLesion(cie10, id, elemento){

    // Consulto el indice del arreglo por medio de la propiedad id
    var indice = buscarLesion(id);

    // Con el #id del elemento consulto el texto de la etiqueta <p>,
    // el cual es el nombre de la lesión
    var nombreLesion = $('#' + elemento + ' .item_text > p').text();
    var codigoLesion = $('#' + elemento + ' .item_codigo > p > span').text();

    // Valido si la lesión existe en el arreglo infoLesion
    if (buscarLesion(id) != -1) {

      // Elimino la lesión si existe en el arreglo infoLesion
      infoLesion.splice(indice , 1);

      // Animación para item que emulan las lesiones seleccionadas
      // en la barrar superior.
      $("#fracturaSelect_" + id).animate({
        width:'0px',
        opacity: 0
      }, 200 , function() {

        // Cuando termina la animación se elimina el elemento del DOM
        $("#fracturaSelect_" + id).remove();

      });

      // Setear la variable global
      seleccion = false;

    }

    // Si la lesión no esta en el arreglo infoLesion
    else {

      // Agragar clase  lesionActiva a la lesion seleccionada,
      // esto da el efecto de selección de color verde
      $('#' + elemento).addClass('lesionActiva');

      // Objeto temporal con la información de la lesión seleccionada
      var tempInfoLesion = {
        'nombre': nombreLesion,
        'cie10' : cie10,
        'id'    : id,
        'especificacion' : ''
      };

      // Agrego al final del arreglo infoLesion el objeto temporal
      infoLesion.push(tempInfoLesion);

      // Crear y imprimir en la barra superior un nuevo item
      // el cual representa a una lesión
      $("#cont-barraFracturasSelectId").append("\
      <li class='fracturaSelect' id='fracturaSelect_"+ id +"' title='"+ nombreLesion +"'>\
      <p>"+ codigoLesion +"</p>\
      <i class='fa fa-times' onclick=\"InfoLesion(null , "+ id +" ,'"+ elemento +"')\"></i>\
      </li>\
      ");

      // Setear la variable global
      seleccion = true;

    }

    // Actualizar cantidad de lesiones seleccionadas
    var bola_plus = document.getElementById('bola_plus');
    bola_plus.setAttribute('fracturasSeleccionadas' , infoLesion.length);

    // Validar si no hay lesiones seleccionadas y remover clase lesionActiva
    if (seleccion === false) {
      $('#'+elemento).removeClass('lesionActiva');
    }

  }


  /**
  * Esta función se encarga de recorrer todas las lesiones
  * por medio de la clas .lesion, por cada lesion recoge cierta informacion,
  * después se elimina el elemento y vulve y se reconstruye con la información
  * previamente recogida, y ya por último se ubica el punto en las cordenadas x - y.
  */
  function ordenarPuntos() {

    var aumento = 0;
    var idLesion = '';
    var idL = '';
    var onclickL = '';
    var posY;
    var posX;

    if (lesiones.length > 0) {

      // Recorrer los elementos con esta clase .lesion que sean hijos de #cont_cuerpo
      $('#cont_cuerpo > .lesion').each(function(indice, elemento) {


        // Sirve de contador
        aumento++;

        // Construye la sintaxis del #id del elemento
        idLesion = 'Puntolesion_' + aumento;

        // Almacena el atributo #id del elemeto
        idL = $(elemento).attr('id');

        // Almacena el atributo onclick() del elemeto
        onclickL = $(elemento).attr('onclick');

        // Consulta del arreglo de lesiones la posición x & y del punto
        posX = lesiones[indice].infoPunto.posX;
        posY = lesiones[indice].infoPunto.posY;

        // Eliminar elemento del DOM
        $(elemento).remove();

        // Imprimir punto reconstruido en el DOM
        $("#cont_cuerpo").append("<div class='lesion' id='"+ idLesion +"' onclick='consultarLesion("+ indice +", this.id, event)'></div>");

        // Ubicar el punto en las cordenadas x - y
        ubicarPunto(posX, posY, idLesion);
      });


    } else {

      // Cerrar el menu lateral
      $('.menu_lesiones').css({right: '-1000px'});

      // Eliminar elemento(Punto) del DOM
      $('#cont_cuerpo > .lesion').remove();

    }

  }


  /**
  * Esta funcion se encarga eliminar una lesión de un punto
  * si se elimina la última lesión se elimina el punto, automaticamente.
  */
  function EliminarLesion(indiceLesion, idFiltro, idElemento , eliminarPunto){

    // Setear variable si llega nula
    eliminarPunto = eliminarPunto || false;

    // Valida si quiero eliminar el punto, con todas sus lesiones
    if (eliminarPunto) {

      // Elimina la lesion
      lesiones.splice(indiceLesion , 1);

      // Eliminar elemento(Punto) del DOM
      $('#' + idElemento).remove();

      // Ordenar y reconstruir todos los puntos
      ordenarPuntos();

      // Cerrar menu lateral
      $('.menu_lesiones').css({right: '-1000px'});

      // alerta de exito de eliminación
      Notificate({
        tipo: 'success',
        titulo: 'Operación exitosa',
        descripcion: 'Se ha eliminado el punto correctamente.',
        duracion: 4
      });

    }else {

      /**
      * Este bloque de código se encarga de filtrar la lesión seleccionada
      * por medio del idFiltro, si se encuentra se elimina del arreglo
      */
      var infoLesionSeleccionada = lesiones[indiceLesion].infoLesion;

      for(var i = infoLesionSeleccionada.length-1; i>=0; i--){

        if (infoLesionSeleccionada[i].id == idFiltro){

          // Eliminar lesión especificada en el filtro
          infoLesionSeleccionada.splice(i , 1);

          // Lista de nuevo la información del punto
          consultarLesion(indiceLesion , idElemento);

          // Valida si se eliminarón todas las lesiones del punto
          if(infoLesionSeleccionada.length === 0){
            lesiones.splice(indiceLesion , 1);
            canLesiones--;

            // Cerrar menu lateral
            $('.menu_lesiones').css({right: '-1000px'});

            // Eliminar elemento del DOM
            $('#' + idElemento).remove();

            // Ordenar y reconstruir todos los puntos
            ordenarPuntos();

            // alerta de exito de eliminación
            Notificate({
              tipo: 'success',
              titulo: 'Operación exitosa',
              descripcion: 'Se ha eliminado el punto correctamente.',
              duracion: 4
            });

          }

        }

      }

    } // Fin else

  } // Fin EliminarLesion


  /**
  * Esta funcion se encarga de limpiar el efecto de seleccion de las lesiones
  */
  function quitarSeleccion(mensaje){

    // Remueve la clase lesionActiva de cada elemento <li> de la lista #listaLesiones
    // Esto elimina el efecto de selección de la lesión
    $('.body_m_lesiones > .item_lesion').each(function (indice , elemento) {
      $(elemento).removeClass('lesionActiva');
    });

    // Remueve la clase lesionActiva de cada elemento <li> de la lista
    // #cont-barraFracturasSelectId
    // Elimina de la barra superior todas las lesiones
    $('#cont-barraFracturasSelectId li').each(function (indice , elemento) {
      $(elemento).remove();
    });

    // Setear variable global
    seleccion = false;

    var msjExito = false;

    // Si no hay ninguna selección no saco el mensaje de exito
    if (infoLesion.length > 0) {
      msjExito = true;
    }

    // Vaciar información de la selección
    infoLesion = [];

    // Actualizar valor de la cantidad de lesiones seleccionadas
    var bola_plus = document.getElementById('bola_plus');
    bola_plus.setAttribute('fracturasSeleccionadas' , '0');


    // Muestra la alerta si la variable mensaje es true
    // Esta condición se ejecuta cuando elimino toda la selección
    if (mensaje) {

      if (msjExito) {
        // alerta de exito de eliminación
        Notificate({
          tipo: 'success',
          titulo: 'Operación exitosa',
          descripcion: 'Se a eliminado la seleccion de las lesiones correctamente.',
          duracion: 4
        });
      }else {
        // alerta de información cuando no hay seleccion
        Notificate({
          tipo: 'info',
          titulo: 'Informacion:',
          descripcion: 'No hay ninguna selección.',
          duracion: 4
        });
      }

    }

  }


  /**
  * Esta funcion se encarga localizar un punto en el cuerpo
  */
  function localizarPunto(id) {

    // Desactivar la localización del punto anterior
    $('#' + puntoAnteriorLocalizado).css({
      'background':'#1F95D0',
      'animation': 'punto 2s infinite'
    });

    // Cerrar menu lateral
    $('.menu_lesiones').css({right: '-1000px'});

    // Activar localización del punto solicitado
    $('#' + id).css({
      'background':'rgba(57, 194, 52, .89)',
      'animation': 'localizar 2s infinite'
    });

    // Después de 10 segundos se desactiva la localización del punto solicitado
    setTimeout(function(){
      $('#'+id).css({
        'background':'#1F95D0',
        'animation': 'punto 2s infinite'
      });
    },10000);

    // Setear var global con el id del punto solicitado
    puntoAnteriorLocalizado = id;

  }


  /**
  * Esta funcion se encarga de listar todos los puntos del cuerpo
  */
  function listarPuntos(event) {
    whichWorkMode.then(function (esModoConsulta) {

      // Valida que hayan puntos en el cuerpo para mostrar
      if (lesiones.length > 0) {

        var infoL = '';
        var idL;
        var onclickL;
        var str;

        // Si esta función ya se había ejecutado limpia los datos imprimidos en el DOM
        $(".body_m_lesiones").html('');

        // Recorrer los elementos con esta clase .lesion que sean hijos de #cont_cuerpo
        $('#cont_cuerpo > .lesion').each(function(indice, elemento) {

          // Recorre el arreglo infoLesion en la lesión seleccionada y arma la estructura
          // Html para concatenar en la estructura siguiente.
          for (var i = 0; i < 3; i++) {
            if (lesiones[indice].infoLesion[i]) {
              var Imprimir = (i == 2) ? 'CONSULTAR PARA VER EL RESTO.' : lesiones[indice].infoLesion[i].nombre;
              if (lesiones[indice].infoLesion[i]) {
                infoL += '<p>'+ Imprimir +'</p>\n';
              }
            }
          }

          // Almacena el atributo #id del elemeto
          idL = $(elemento).attr('id');

          // Almacena el atributo onclick() del elemeto
          onclickL = $(elemento).attr('onclick');

          // Sustraer el primer argumento de la función onclick()
          // el cual es un indice que apunta a una posición del arreglo lesiones
          str = onclickL.substring(16,17);

          // Contador para completar el titulo Punto # ?
          var contador = indice + 1;

          var btnEliminar = "\
          <div onclick=\"EliminarLesion("+ str +" , null , '"+ idL +"' ,  true )\" class='btn btn-eliminar tooltip'>\
          <span class='fa fa-trash-o'></span>\
          <span class='tooltiptext'>Eliminar</span>\
          </div>\
          ";

          if (esModoConsulta) {
            btnEliminar = "";
          }

          // Estructura de la consulta de un punto
          $(".body_m_lesiones").hide().append('\
          <div class="item_lesion item_punto">\
          <div class="item_codigo">\
          <p><strong>Punto:</strong><span>#'+ contador +'</span></p>\
          </div>\
          <div class="item_text">\
          <div class="item_list_lesiones">\
          '+ infoL +'\
          </div>\
          <div>\
          <div onclick="localizarPunto(\''+ idL +'\')" class="btn btn-consultar tooltip">\
          <span class="fa fa-map-marker"></span>\
          <span class="tooltiptext">Localizar</span>\
          </div>\
          <div onclick="consultarLesion('+ str +' , \''+ idL +'\', event, false)" class="btn btn-registrar tooltip">\
          <span class="fa fa fa-eye"></span>\
          <span class="tooltiptext">Consultar</span>\
          </div>\
          '+ btnEliminar +'\
          </div>\
          </div>\
          </div>\
          ').fadeIn('fast');

          // Reseteo de variables
          infoL = '';
          idL = '';
          str = '';

        });

        // Mostrar menu lateral
        event.stopPropagation();
        $('.menu_lesiones').css({right: '0px'});

      } else {

        // alerta de error
        Notificate({
          tipo: 'error',
          titulo: 'Error:',
          descripcion: 'No se ha agregado ningun punto.',
          duracion: 4
        });

      }

    }, function (err) {
      alert('No se pudó obtener el modo de trabajo.');
    });

  }


  /**
  * Esta funcion se encarga de agreagar una espescificación
  * a una lesion especifica.
  */
  function agregarEspecificacion(indiceLesion , indiceInfoLesision , idElemento) {

    // Obtener texto del input de la especificación
    var textoEspecificacion = $('#' + idElemento + ' .item_text  > textarea').val();

    // Localizar lesión y agreagar especificación
    lesiones[indiceLesion].infoLesion[indiceInfoLesision]
    .especificacion =  textoEspecificacion;

    // Notificación de exito
    Notificate({
      tipo: 'success',
      titulo: 'Agregar especificación',
      descripcion: 'Especificación agregada correctamente.',
      duracion: 4
    });

  }


  /**
  * Esta funcion se encarga crear un arreglo unico, eliminando los valores repetidos
  */
  function uniqBy(a, key) {
    var seen = {};
    return a.filter(function(item) {
      var k = key(item);
      return seen.hasOwnProperty(k) ? false : (seen[k] = true);
    });
  }

  /**
  * Esta funcion se encarga consultar la informacion de un punto(lesion)
  */
  function consultarLesion(indice , idElemento, event, agregar){
    whichWorkMode.then(function (esModoConsulta) {
      var consulta    = lesiones[indice];
      var info1       = consulta.infoPunto;
      var info2       = consulta.infoLesion;

      agregar = typeof agregar !== 'undefined' ?  agregar : true;

      /**
      * Si el usuario previamente ha seleccionado
      * lesiones y le da click a un punto
      * esta parte del código valida que las lesiones que se pretenden
      * agregar a dicho punto no esten ya agregadas.
      * Por tanto solo se agregan las lesiones que no esten.
      */
      if(seleccion && agregar){

        info2.forEach(function(el, i) {
          infoLesion.forEach(function(el2, i2) {
            if (el.id == el2.id) {
              infoLesion.splice(i2, 1);
            }
          });
        });

        infoLesion.forEach(function(el, i) {
          info2.push(el);
        });

        info2 = info2.sort(deMenorAMayor);

        quitarSeleccion();
        seleccion = false;
      }


      /**
      * Aquí lo que se hace es recorrer el array de infoLesion que obtuvimos
      * de la consulta de lesiones[indice] y armar la estructura en html para
      * imprimirla en la vista.
      */
      var i = 0;
      var idElement = "'"+ idElemento +"'";
      var idTxtInput = '';


      $(".body_m_lesiones").html('');
      $(".head_m_title b").text('Punto #' + idElemento.charAt(12));
      $('.head_m_buscar').hide();
      $('.body_m_lesiones').css({top:'48px'});

      info2.forEach(function (element, index, array) {
        i++;
        idTxtInput = 'idTxtInput-' + indice + '-' + index;

        var btnEliminar = '<button class="btn btn-eliminar" onclick="EliminarLesion('+ indice +','+ element.id +','+ idElement +')">\
        <span class="fa fa-trash"></span>\
        Eliminar\
        </button>';

        var onclickEspecificacion = '<button class="btn btn-registrar" onclick="agregarEspecificacion('+ indice +' , '+ index +'  , \''+ idTxtInput +'\')">\
        <span class="fa fa-commenting"></span>\
        Especificar\
        </button>';


        var soloLectura = "";

        if (esModoConsulta) {
          btnEliminar = "";
          onclickEspecificacion = "";
          soloLectura = 'readonly disabled class="bloquear" ';
        }


        $(".body_m_lesiones").hide().append('\
        <div class="item_lesion consultar" id="'+ idTxtInput +'">\
        <div class="item_codigo">\
        <p><strong>Código:</strong><span>'+ element.cie10 +'</span></p>\
        </div>\
        <div class="item_text block">\
        <p class="block">'+ element.nombre +'</p>\
        <textarea  rows="2" cols="2" '+soloLectura+' placeholder="Agregar Especificación">'+ element.especificacion +'</textarea>\
        </div>\
        '+ onclickEspecificacion +'\
        '+ btnEliminar +'\
        </div>\
        ').fadeIn('fast');

      });

      // Para abrir el menu lateral
      if (event) event.stopPropagation();
      $('.menu_lesiones').css({right: '0px'});
      $('.footer_m_lesiones').hide();

    }, function (err) {
      alert('No se pudó obtener el modo de trabajo.');
    });

  }


  /**
  * Genera la paginación de los registros de CIE10 y pone a escuchar el evento
  * click de los botones del paginador al cargar la página
  */
  function generarPaginador(msmNoResult) {
    msmNoResult = msmNoResult || 'No hay datos disponibles en estos momentos.';
    paginator.view.generateButtons(options)
    .then(function(data) {
      if (data.datos !== null) {
        ListarCIE10(data.datos); // Primera vez
      }else {
        noResult(msmNoResult);
      }
      $('#' + options.parent).on('click', 'li.btn_paginador', function() {
        Paginate(options, $(this), function(data) {
          if (data.datos !== null) {
            ListarCIE10(data.datos); // Segunda vez
            ValidarSeleccion();
          }else {
            noResult(msmNoResult);
          }
        });
      });
    });
  }


  /**
  * Cuando no se encuentran resultados al filtro solicitado
  */
  function noResult (msm) {
    $('.body_m_lesiones').html('');
    var structure = '\
    <div class="n_flex n_justify_center n_align_center whole_wrapper">\
    <div class="n_flex_col50 md_flex_col30 lg_flex_col60 block">\
    <img class="whole_wrapper img_no_data" src="'+ url +'Public/Img/ReporteAPH/no-results.png" alt="No hay reportes disponibles." />\
    </div>\
    <div class="n_flex n_flex_col100 n_justify_center">\
    <h3 style="text-align:center; opacity:.6;">'+ msm +'</h3>\
    </div>\
    </div>';

    $('.body_m_lesiones').hide().append(structure).fadeIn('slow');
  }


  /**
  * Crear e imprimir los datos paginados de los CIE10
  */
  function ListarCIE10(res) {

    // Llenar var global para los cie10
    listadoCIE10 = res;

    // Limpiar la lista la lista #listaLesiones antes de imprimir los nuevos datos
    $('.body_m_lesiones').html('');

    // Recorro el json res por cada iteración imprimo en el DOM
    // la estructura de una lesión
    $.each(res , function (index , valor) {
      $('.body_m_lesiones').hide().append('\
      <div class="item_lesion" onclick="InfoLesion(\''+ valor.codigoCIE10 +'\', '+ valor.idCIE10 +', this.id)" id="InfoLesion'+ valor.idCIE10 +'" >\
      <div class="item_codigo">\
      <p><strong>Código:</strong><span>' + valor.codigoCIE10 + '</span></p>\
      </div>\
      <div class="item_text">\
      <p>'+ valor.descripcionCIE10 +'</p>\
      </div>\
      </div>').fadeIn('fast');
    });

  }


  /**
  * listar los datos de los puntos
  */
  function consultarDatosPuntos() {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlLocalizacionLesiones/ListarDatosPuntos",
      data: {"idReporteAPH": idReporteAPH}
    }).done(function (res) {

      var  puntoTemp = [];

      // Recorro el json res por cada iteración creo un objeto temporal
      // y lo agrego al arreglo de lesiones
      $.each(res , function (indexPunto , valorPunto) {

        var lesionesTemp = [];
        var datosLesiones = valorPunto.datosLesiones;

        // Se encarga de recorrer las lesiones y agregarlos a lesionesTemp
        $.each(datosLesiones , function (indexLesiones , valorLesiones) {

          var objLesiones = {
            'nombre': valorLesiones.descripcionCIE10,
            'cie10' : valorLesiones.codigoCIE10,
            'id'    : valorLesiones.idLesion,
            'especificacion' : (valorLesiones.especificacionLesion != null) ? valorLesiones.especificacionLesion : ''
          };

          lesionesTemp.push(objLesiones);

        });

        // Construye objeto con las lesiones y las cordenadas x - y del punto
        var objPunto = {

          "infoLesion" : lesionesTemp,

          "infoPunto" : {
            'posX' : valorPunto.datosPunto.posX,
            'posY' : valorPunto.datosPunto.posY
          }

        };


        // Agrego al arreglo puntoTemp el objeto temporal objPunto
        puntoTemp.push(objPunto);

        // Almacena la cantidad de puntos que hay en el cuerpo
        canLesiones++;

        // Arma la estructura del #id
        var idLesion = 'Puntolesion_' + canLesiones;
        // i apunta al indice de la lesion ==> lesion[i]
        var i = puntoTemp.length - 1;

        // Creación de un punto en el DOM
        $("#cont_cuerpo").append("<div class='lesion' id='"+ idLesion +"' onclick='consultarLesion("+ i +" , this.id, event)'></div>");


        // Ubicar el punto en las cordenadas correspondientes
        $("#" + idLesion).css({
          top  : objPunto.infoPunto.posY + '%',
          left : objPunto.infoPunto.posX + '%'
        });

      });

      // Setear arreglo lesiones con puntoTemp
      lesiones = puntoTemp;

    }).fail(function () {

      // alerta de error
      Notificate({
        tipo: 'error',
        titulo: 'Error $Ajax',
        descripcion: 'ReporteAPH/ctrlLocalizacionLesiones/ListarDatosPuntos',
        duracion: 4
      });

    });
  }



  /**
  * Guardar la información en la DB
  */
  function GuardarDB() {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url + "ReporteAPH/ctrlLocalizacionLesiones/RegistrarPuntoLesion",
      data: {
        "datosLocalizacionLesiones": JSON.stringify(lesiones),
        "idReporteAPH" : idReporteAPH
      }
    }).done(function (res) {

      swal(res[0], "Tranquilo tus datos ya estan sanos y salvos", "success");

    }).fail(function () {

      // alerta de error
      Notificate({
        tipo: 'error',
        titulo: 'Error $Ajax',
        descripcion: 'ReporteAPH/ctrlLocalizacionLesiones/RegistrarPuntoLesion',
        duracion: 4
      });

    });
  }


  /**
  * Validar si hay un localStorage con info y si la hay la mustra en la vista
  */
  function ListarPuntosLocal() {

    // Consultar información del diagnostico de localStorage
    var lesionesLS = JSON.parse(localStorage.getItem("ReporteAPH-Lesiones"));

    // Validar que si hay datos en localStorage
    if (lesionesLS != null) {

      $.each(lesionesLS , function (index , valor) {
        canLesiones++;

        // Arma la estructura del #id
        var idLesion = 'Puntolesion_' + canLesiones;
        // i apunta al indice de la lesion ==> lesion[i]
        var i = index;

        // Creación de un punto en el DOM
        $("#cont_cuerpo").append("<div class='lesion' id='"+ idLesion +"' onclick='consultarLesion("+ i +" , this.id, event)'></div>");

        // Ubicar el punto en las cordenadas correspondientes
        $("#" + idLesion).css({
          top  : valor.infoPunto.posY + '%',
          left : valor.infoPunto.posX + '%'
        });

      });

      // Setear arreglo de lesiones
      lesiones = lesionesLS;

    }else {
      //console.log("No hay lesiones en localStorage");
    }

  }


  /**
  * Guardar la información en localStorage
  */
  function GuardarLocal() {

    // Guardar datos en localStorage
    localStorage.setItem("ReporteAPH-Lesiones",JSON.stringify(lesiones));

    // Validar sii se guardarón correctamente los datos
    var lesionesLocal = JSON.parse(localStorage.getItem("ReporteAPH-Lesiones"));

    if (lesionesLocal.length != null || lesionesLocal != 0) {
      // Alerta exito
      swal("Datos guardados correctamente", "Tranquilo tus datos ya estan sanos y salvos", "success");

    }else {
      // Aleta error
      swal("Ocurrio un error al guardar los datos", "Reintenta la operación si el problema persite comunicate con el administrador del sistema.", "error");
    }

  }


  /**
  * Compara las lesiones guardadas en infoLesion y las que se estan paginadas
  * y si son iguales les coloca la clase lesionActiva
  */
  function ValidarSeleccion() {
    listadoCIE10.forEach(function(el, i) {
      infoLesion.forEach(function(el2, i2) {
        if (el.idCIE10 == el2.id) {
          $('.body_m_lesiones').find('#InfoLesion' + el.idCIE10).addClass('lesionActiva');
        }
      });
    });
  }


  /**
  * Ordenar con la propiedad id los CIE10 dentro de un puento de manera ASC
  */
  function deMenorAMayor(elem1, elem2) {return elem1.id - elem2.id;}


  /**
  * Se utiliza para guardar los datos en localStorage y redireccionar a una vista
  * dependiendo de la flecha
  */
