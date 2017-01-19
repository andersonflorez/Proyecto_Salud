
(function(global) {

  // 'use strict';
  /*jshint multistr: true */

  var frm = '#formMenuFiltro',
  options = {  // Configuración Basica para el paginador
    parent: 'paginadorControlAutorizacion',
    url: 'ReporteAPH/ctrlControlAutorizacion/ListarAutorizaciones',
    configuration: {
      tableName: '?',
      limit: 5
    }
  };


  // Genera el paginador la primera vez cuando carga la página
  paginator.view.generateButtons(options)
  .then(function(data) {
    if (data.datos !== null) {
      createView(data.datos); // Primera vez
      $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
    }else {
      noResult('No hay autorizaciones en estos momentos.');
    }
  });


  // Genera el paginador cada vez que se presiona un boton que hace parte del mismo
  $('#' + options.parent).on('click', 'li.btn_paginador', function() {
    Paginate(options, $(this), function(data) {
      if (data.datos !== null) {
        createView(data.datos); // Segunda vez
        $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
      }else {
        noResult(msmNoResult);
      }
    });
  });



  // Click en el icono de buscar:
  $('#btnBuscar').click(function () {
    filter();
  });

  // Evento enter en el campo de busqueda:
  $('#txtinputBusqueda').keyup(function(e){
    if(e.keyCode == 13) {
      filter();
    }
  });

  // Input filtrar por:
  $(frm + ' .filterBy').change(function () {
    filter();
  });

  // Input filtrar por:
  $(frm + ' .limit').change(function () {
    filter();
  });

  // Input buscar por:
  $(frm + ' .nameColumnFilter').change(function () {
    // if ($('#txtinputBusqueda').val()) {
    filter();
    // }
  });

  // Input ordenar por:
  $(frm + ' .nameColumnOrderBy').change(function () {
    filter();
  });

  // Input ordenar por:
  $(frm + ' .orderBy').change(function () {
    filter();
  });

  // Validar fechas filtro:
  ValidateForm('formMenuFiltro', function(date) {
    options.configuration.filterDateTimeStart = date.initialDate;
    options.configuration.filterDateTimeEnd = date.finalDate;
    filter();
  });

  $('.reset_search').click(function (event) {
    options.configuration.filterDateTimeStart = '';
    options.configuration.filterDateTimeEnd = '';
    $('#txtinputBusqueda').val('');
    filter();
    event.stopPropagation();
  });


  var filter = function () {

    var config = JSON.parse(JSON.stringify($('#formMenuFiltro').serializeArray()));

    options.configuration.limit = Number(config[0].value);
    options.configuration.page = 1;
    options.configuration.nameColumnFilter = Number(config[1].value);
    options.configuration.filter = $('#txtinputBusqueda').val() || '';
    options.configuration.nameColumnOrderBy = Number(config[4].value);
    options.configuration.orderBy = config[5].value;


    paginator.view.generateButtons(options)
    .then(function(data) {
      if (data.datos !== null) {
        createView(data.datos); // Filtro
        $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
      }else {
        noResult('No se encontraron resultados que coincidan con el filtro solicitado.');
      }
    });
  };

  var createView = function (data) {
    $('#contenedorNotificaciones').html('');
    $.each(data, function (index) {
      crateStructure({
        idAutorizacion: this.idTemporalAutorizacion,
        nombre: this.nombreCompleto,
        descripcion: this.descripcionAutorizacion,
        estado: this.estadoEvaluacion,
        descripcionAutorizacion: this.Descripcion,
        fechaEnvio: this.fechaEnvio,
        foto: this.urlFoto
      });
    });
  };

  // en caso que no hallan datos
  var noResult = function (msm) {
    $('#contenedorNotificaciones').html('');
    var structure = '\
    <div class="n_flex n_justify_center whole_wrapper" ng-if="!Autorizaciones">\
    <div class="n_flex_col50 md_flex_col30 lg_flex_col25 block">\
    <img class="whole_wrapper img_no_data" src="'+ url +'Public/Img/Todos/no-results.png" alt="No hay autorizaciones disponibles." />\
    </div>\
    <div class="n_flex n_flex_col100 n_justify_center">\
    <h3 style="text-align:center; opacity:.6;">'+ msm +'</h3>\
    </div>\
    </div>';

    $('#contenedorNotificaciones').hide().append(structure).fadeIn('slow');
  }; // FIN en caso que no hallan datos

  var crateStructure = function (data) {

    if (data.estado == "Por Evaluar") {
      StructureRegistry(data);
    }else{
      StructureQuery(data)
    }

  }


  // estructura para las autorizaciones por evaluar
  var StructureRegistry = function (data) {
    var urlImagen = '';
    var codigoAutorizacion = '';
    if (data.foto == null) {
      urlImagen = url+'Public/Img/ReporteAPH/usuarioVacio.jpeg';
    }else {
      urlImagen = url+data.foto;
    }
    if (data.idAutorizacion < 10) {
      codigoAutorizacion = '0'+data.idAutorizacion;
    }else {
        codigoAutorizacion = data.idAutorizacion;
    }

    $("<div>",{
      class: 'n_flex n_flex_col100 horizontal_padding n_justify_around'
    }).append(
      $("<div>",{
        class:'panel block'
      }).append(

        $("<div>",{
          class:'panel-contenido contenedor-consulta'
        }).append(
          $("<div>",{
            class:'panel-consulta',
            id:'panel-consulta'+data.idAutorizacion
          }).append(
            $("<span>",{
              class:'fa fa-arrow-right icon-atras'
            }).on('click', function () {
              $('#panel-consulta'+data.idAutorizacion).css({
                left:'100%',
                transition: '0.5s'

              })
            })
          ),
          $("<div>",{
            class:'autorizacion'
          }).append(
            $("<div>",{
              class:'codigoAutorizacion'
            }).append(
              $("<p>",{
                text:'Cód.'
              }).append(
                $("<span>",{
                  text:'#'+codigoAutorizacion
                })
              )

            ),
            $("<div>",{
              class:'autorizacion-header'
            }).append(
              $("<div>",{
                class:'imagen'
              }).append(
                $('<img>',{
                  src:urlImagen
                })
              ),
              $("<div>",{
                class:'informacion'
              }).append(
                $("<label>",{
                  class:'nombre-envia',
                  text:data.nombre
                }),
                $("<p>",{
                  text:data.descripcion
                }),
                $("<div>",{
                  class:'sub-inforamacion'
                }).append(
                  $("<p>").append(
                    $("<span>",{
                      text:data.descripcionAutorizacion + " | "
                    }),
                    $("<span>",{
                      text:data.estado + " | ",
                      id:'estadoAutorizacion'+data.idAutorizacion
                    }),
                    $("<span>",{
                      text:data.fechaEnvio
                    })

                  )

                )

              )
            ),
            $("<div>",{
              class:'autorizacion-body',
              id:'autorizacion-body'+data.idAutorizacion
            }).append(
              $("<textarea>",{
                placeholder:'Respuesta de autorización...',
                id:'textArea'+data.idAutorizacion
              }),
              $("<div>",{
                class:'botones'
              }).append(
                $("<button>",{
                  type:'button',
                  valor:'Rechazada',
                  class:'btnEvaluar btn btn-eliminar',
                  text:'Rechazar'
                }).on('click', function () {
                  ConfirmarRespuesta(data.idAutorizacion,0);
                }),
                $("<button>",{
                  type:'button',
                  valor:'Aprobada',
                  class:'btnEvaluar btn btn-registrar',
                  text:'Aprobada'
                }).on('click', function () {
                  ConfirmarRespuesta(data.idAutorizacion,1);

                })

              )
            )
          )
        )

      )
    ).hide().appendTo('#contenedorNotificaciones').fadeIn('slow');
  }


  // funcion que crea las autorizaciones ya evaluadas
  var StructureQuery = function (data) {
    var urlImagen = '';
    var codigoAutorizacion = '';
    if (data.foto == null) {
      urlImagen = url+'Public/Img/ReporteAPH/usuarioVacio.jpeg';
    }else {
      urlImagen = url+data.foto;

    }
    if (data.idAutorizacion < 10) {
      codigoAutorizacion = '0'+data.idAutorizacion;
    }else {
        codigoAutorizacion = data.idAutorizacion;
    }

    $("<div>",{
      class: 'n_flex n_flex_col100 horizontal_padding n_justify_around'
    }).append(
      $("<div>",{
        class:'panel block'
      }).append(

        $("<div>",{
          class:'panel-contenido contenedor-consulta'
        }).append(
          $("<div>",{
            class:'panel-consulta',
            id:'panel-consulta'+data.idAutorizacion
          }).append(
            $("<span>",{
              class:'fa fa-arrow-right icon-atras'
            }).on('click', function () {
              $('#panel-consulta'+data.idAutorizacion).css({
                left:'100%',
                transition: '0.5s'

              })
            })
          ),
          $("<div>",{
            class:'autorizacion'
          }).append(
            $("<div>",{
              class:'codigoAutorizacion'
            }).append(
              $("<p>",{
                text:'Cód.'
              }).append(
                $("<span>",{
                  text:'#'+codigoAutorizacion
                })
              )

            ),
            $("<div>",{
              class:'autorizacion-header'
            }).append(
              $("<div>",{
                class:'imagen'
              }).append(
                $('<img>',{
                  src:urlImagen
                })
              ),
              $("<div>",{
                class:'informacion'
              }).append(
                $("<label>",{
                  class:'nombre-envia',
                  text:data.nombre
                }),
                $("<p>",{
                  text:data.descripcion
                }),
                $("<div>",{
                  class:'sub-inforamacion'
                }).append(
                  $("<p>").append(
                    $("<span>",{
                      text:data.descripcionAutorizacion + " | "
                    }),
                    $("<span>",{
                      text:data.estado + " | "
                    }),
                    $("<span>",{
                      text:data.fechaEnvio
                    })

                  )

                )

              )
            ),
            $("<div>",{
              class:'autorizacion-body',
              id:'autorizacion-body'+data.idAutorizacion
            }).append(
              $("<div>",{
                class:'botones-consulta'
              }).append(
                $("<button>",{
                  type:'button',
                  valor:'Rechazada',
                  class:'btnEvaluar btn btn-consultar'
                }).append(
                  $('<span>',{
                    class:'fa fa-eye'
                  })
                ).on('click', function () {
                  ConsultarAutorizacion(data.idAutorizacion);
                })


              )
            )
          )
        )

      )
    ).hide().appendTo('#contenedorNotificaciones').fadeIn('slow');

  }


  // se encarga de actualizar la autorizacion evaluada
  var Reemplazar = function (idbody,estado) {

    $('#estadoAutorizacion'+idbody).text(estado+" | ");
    $('#autorizacion-body'+idbody).empty();
    $('#autorizacion-body'+idbody).append(
      $("<div>",{
        class:'autorizacion-body',
        id:'autorizacion-body'+idbody
      }).append(
        $("<div>",{
          class:'botones-consulta'
        }).append(
          $("<button>",{
            type:'button',
            valor:'Rechazada',
            class:'btnEvaluar btn btn-consultar'
          }).append(
            $('<span>',{
              class:'fa fa-eye'
            })
          ).on('click', function () {
            ConsultarAutorizacion(idbody);
          })


        )
      )

    )

  }


  // consulta la autorizacion cuando se oprime el boton  consultar
  var ConsultarAutorizacion = function (idAutorizacion) {

    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:url+'ReporteAPH/ctrlControlAutorizacion/ConsultarAutorizacion',
      data: {'idAutorizacion':idAutorizacion}
    }).done(function(data){
      crearPanelConsulta(data);
    }).fail(function () {
      console.log('estoy entrando al fail de consultarAutorizacion');
    })
  }

//el ajax que se encarga de actualizar los datos en la BD
  var ConfirmarRespuesta = function (id, mensaje) {
    var estado = '';
    var des = $('#textArea'+id).val();
    if (mensaje == 1) {
      mensaje = "Está seguro de aprobar la autorización, después de confirmar no podrá deshacer los cambio."
      estado = 'Aprobada';
    }else {
      mensaje = "Está seguro de rechazar la autorización, después de confirmar no podrá deshacer los cambio."
      estado = 'Rechazada';
    }
    var parametros = {
      "id" : id,
      "estado" : estado,
      "des" : des
    };
    swal({
      title: "Estás seguro?",
      text: mensaje,
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#2ECC71",
      confirmButtonText: "Confirmar",
      closeOnConfirm: true
    },
    function(){
      $.ajax({
        type:'POST',
        dataType:'JSON',
        url:url+'ReporteAPH/ctrlControlAutorizacion/insertarRespuestaAutorizacion',
        data: parametros
      }).done(function(e,i){

        if (e) {

          Notificate({
            tipo: 'success',
            titulo: 'Autorización evaluada.',
            descripcion: 'La evaluación fue llevada acabo exitosamente.'
          });
          Reemplazar(id,estado);
          ConsultarParamedico();
        }else {
          Notificate({
            tipo: 'warning',
            titulo: 'Autorización NO evaluada.',
            descripcion: 'No se ha podido evaluar, intentelo nuevamente.'
          });
        }


      }).fail(function (e) {
        Notificate({
          tipo: 'error',
          titulo: 'Error ',
          descripcion: 'Error al intentar evaluar la autorización.'
        });

      })
    });

  }

  //crea la notificacion cuando se envia una nueva autorizacion
  this.crearNotificacion = function (idParamedico) {
    var idNotificacion = 'nueva-notificacion'+idParamedico;
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:url+'ReporteAPH/ctrlControlAutorizacion/ConsultarParamedico',
      data: {'idParamedico':idParamedico}
    }).done(function(data){
      console.log(data);
      $("<div>",{
        class:'nueva-notificacion',
        id:idNotificacion
      }).append(
        $("<div>",{
          class:'nueva-notificacion-header'
        }).append(
          $("<img>",{
            src:url+data[0].urlFoto
          })
        ),
        $("<div>",{
          class:'nueva-notificacion-body'
        }).append(
          $("<li>",{
            class:'fa fa-times'
          }).on('click',function () {
            eliminarNotificacion(idNotificacion);

          }),
          $("<h5>",{
            text:data[0].nombreCompleto
          }),
          $("<span>",{
            text:data[0].fechaEnvio
          }).on('click',function () {
            filter();
            eliminarNotificacion(idNotificacion);
          }),
          $("<div>",{
            class:'suspensive_2'
          }).append(
            $("<p>",{
              class:'paragraph',
              text:data[0].descripcionAutorizacion
            })
          ).on('click',function () {
            filter();
            eliminarNotificacion(idNotificacion);
          })
        )
      ).hide().appendTo('#contenedor-nueva-notificacion').fadeIn('slow');

    }).fail(function () {
      console.log('estoy entrando al fail de consultarAutorizacion');
    })
  };

  var crearPanelConsulta = function (data) {

    var urlImagen = '';
    if (data[0].urlFoto == null) {
      urlImagen = url+'Public/Img/ReporteAPH/usuarioVacio.jpeg';
    }else {
      urlImagen = url+data[0].urlFoto;
    }
    $('#panel-consulta'+data[0].idTemporalAutorizacion).css({
      left:'0',
      transition: '0.5s'

    })


    $("<div>",{
      class: 'n_flex n_flex_col100 horizontal_padding n_justify_around h100'
    }).append(
      $("<div>",{
        class:'panel block no_box'
      }).append(
        $("<div>",{
          class:'panel-contenido contenedor-consulta'
        }).append(
          $("<div>",{
            class:'panel-consulta',
            id:'panel-consulta'+data[0].idTemporalAutorizacion
          }),
          $("<div>",{
            class:'autorizacion'
          }).append(
            $("<div>",{
              class:'autorizacion-header'
            }).append(
              $("<div>",{
                class:'imagen'
              }).append(
                $('<img>',{
                  src:urlImagen
                })
              ),
              $("<div>",{
                class:'informacion'
              }).append(
                $("<label>",{
                  class:'nombre-envia',
                  text:data[0].nombreCompleto
                }),
                $("<p>",{
                  class:'respuesta',
                  text:data[0].correoElectronico

                }),
                $("<div>",{
                  class:'sub-inforamacion'
                }).append(
                  $("<p>").append(
                    $("<span>",{
                      text:data[0].estadoEvaluacion+' |'
                    }),
                    $("<span>",{
                      text:data[0].fechaEvaluacion
                    }),
                    $("<p>",{
                      text:data[0].observacionRespuestaAutorizacion
                    })

                  )

                )

              )
            ),
            $("<div>",{
              class:'autorizacion-body',
              id:'autorizacion-body'+data[0].idTemporalAutorizacion
            }).append(
              $("<div>",{
                class:'botones-consulta'
              })
            )
          )
        )

      )
    ).hide().appendTo( '#panel-consulta'+data[0].idTemporalAutorizacion ).fadeIn( 'slow' );
  }

  //elimina la notificacion
  var eliminarNotificacion = function ( elemento ) {
    console.log( '#'+elemento );
    $( '#'+elemento ).remove();
  }

  $( '#reset_search' ).click(function () {

      $( '#contenedor-nueva-notificacion' ).empty();

  });

})(this);
