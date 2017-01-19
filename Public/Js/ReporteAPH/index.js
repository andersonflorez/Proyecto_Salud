/**
* Se encarga de la consulta de los reportesAPH,
* a traves del paginador con los filtros disponoibles.
*/

(function (global) {

  /*jshint multistr: true */
  /* jshint eqnull:true */

  whichWorkMode.then(function (esModoConsulta) {

    var frm = '#formMenuFiltro',
    options = {  // Configuración Basica para el paginador
      parent: 'paginadorReportes',
      url: 'ReporteAPH/CtrlIndex/ListarReportes',
      configuration: {
        tableName: '?',
        limit: 5
      }
    };
    // Limpiar localStorage
    if (esModoConsulta || esModoConsulta == -1) {
      var idDespachoNotificate = localStorage.getItem('ReporteAPH-idDespachoNotificate') || "0";
      var confirmacion = localStorage.getItem("ReporteAPH-Confirmacion") || "false";
      localStorage.clear();
      localStorage.setItem('ReporteAPH-idDespachoNotificate', idDespachoNotificate);
      localStorage.setItem('ReporteAPH-Confirmacion',confirmacion);

      // Para cambiar disponibilidad de la ambulancia
      $('#cambiar_estado_ambu').click(function () {
        swal(
          {
            title: "¿Estas seguro de cambiar la disponibilidad?",
            text: "Si estás seguro, se cambiara el estado de la ambulancia en la que este asignado a disponible, y por tanto recibirás nuevas emergencias.",
            showCancelButton: true,
            confirmButtonColor: "#4EC3F4",
            confirmButtonText: "OK",
            closeOnConfirm: false
          },

          function(){
            $.post(url + "ReporteAPH/CtrlIndex/CambiarDisponibilidad",{request: "ajax"},function(data){
              if (Number(data) == 1) {
                swal('Cambio de disponibilidad de ambulancia relializado exitosamente.', '', "success");
              }else if (Number(data) == 2) {
                swal('No se pudó cambiar la disponibilidad debido a que la ambulancia no esta ocupada.', '', "error");
              }else {
                swal('Ocurrio un error al cambiar la disponibilidad.', '', "error");
              }
            });
          });
        });

      }

      // Genera el paginador la primera vez cuando carga la página
      paginator.view.generateButtons(options)
      .then(function(data) {
        if (data.datos !== null) {
          createView(data.datos); // Primera vez
          // $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
        }else {
          noResult('No hay reportes APH disponibles en estos momentos.');
        }
      });


      // Genera el paginador cada vez que se presiona un boton que hace parte del mismo
      $('#' + options.parent).on('click', 'li.btn_paginador', function() {
        Paginate(options, $(this), function(data) {
          if (data.datos !== null) {
            createView(data.datos); // Segunda vez
            // $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
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

      $('#reset_search').click(function (event) {
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
            // $(frm + ' .valueTodosLimit').val(data.cantidadRegistros);
          }else {
            noResult('No se encontraron resultados que coincidan con el filtro solicitado.');
          }
        });
      };

      var createView = function (data) {
        $('#ListarReportes').html('');
        $.each(data, function (index) {
          crateStructure({
            idR: this.idReporteAPH,
            infoBasica: createData(this),
            nombre: this.nombreCompleto,
            fecha: this.fechaHoraFinalizacion,
            descripcion: this.informacionInicial,
            ambulancia: this.idAmbulancia,
            personal: this.personal == null ? 'No disponible' : createPersonal(this.personal)
          });
        });
      };

      var crateStructure = function (data) {
        $("<div>", {
          class: 'contenedor_HC block'
        }).append(
          $('<div>', {
            class: 'informacionBasica'
          }).append(
            $('<div>', {
              class: 'fotoPaciente'
            }).append(
              $('<div>', {
                class: 'foto',
              }).append(
                $('<img>', {
                  src: url + 'Public/Img/ReporteAPH/profile-default.png',
                })
              )
            ),
            $('<div>', {
              class: 'infoBasica'
            }).append(data.infoBasica)
          ),
          $('<div>', {
            class: 'datosExtras'
          }).append(
            $('<div>', {
              class: 'encabezado_datosExtras'
            }).append(
              $('<h3>', {
                text: data.nombre
              }),
              $('<h6>', {
                text: data.fecha
              })
            ),
            $('<div>', {
              class: 'descripcion_datosExtras'
            }).append(
              $('<div>', {
                class: 'cont_dEx'
              }).append(
                $('<h5>', {
                  id: 'des_hc'
                }).append(
                  $('<strong>', {
                    text: 'Descripcion Inicial'
                  })
                ),
                $('<p>', {
                  text: data.descripcion
                })
              ),
              $('<div>', {
                class: 'cont_dEx personalAmbula'
              }).append(
                $('<h5>', {
                  text: 'Personal Encargado'
                }),
                $('<p>', {
                  text: data.ambulancia
                }).prepend(
                  $('<span>', {
                    class: 'item-datoB-hc',
                    text: 'Ambulancia:'
                  })
                ),
                $(data.personal)
              ),
              $('<div>', {
                class: 'n_flex whole_wrapper'
              }).append(
                $('<div>', {
                  class: 'n_flex n_flex_col100 lg_flex_col50 n_justify_center'
                }).append(
                  $('<div>', {
                    class: 'n_flex n_flex_col100 md_flex_col50 horizontal_padding'
                  }).append(
                    esModoConsulta != false ?
                    $('<button>', {
                      class: 'btn btn-consultar btn_h whole_wrapper',
                      text: 'Ver Reporte'
                    }).on('click', function () {
                      ConsultarReporteAPH( data.idR );
                    }) :   $('<button>', {
                      class: 'btn btn-consultar btn_h whole_wrapper',
                      text: 'Ver Reporte'
                    })
                  ),
                  $('<div>', {
                    class: 'n_flex n_flex_col100 md_flex_col50 horizontal_padding'
                  }).append(
                    $('<button>', {
                      class: 'btn btn-registrar btn_h whole_wrapper',
                      text: 'Exportar PDF'
                    }).on('click', function () {
                      window.open(url + 'ReporteAPH/CtrlGenerarReporteAPH/ReporteAPH/'+ data.idR);
                    })
                  )
                )
              )
            )
          )
        ).hide().appendTo('#ListarReportes').fadeIn('slow');
      };

      var createData = function (data) {
        var // Variables locales
        allStructureData = '',
        labels = ['Cod.Reporte', 'Identificación', 'Edad', 'Género' ,'Teléfono'],
        icons = ['fa-star', 'fa-newspaper-o', 'fa-birthday-cake', 'fa-venus-mars' ,'fa-phone'],
        text = [
          data.idReporteAPH,
          data.numeroDocumento,
          data.edadPaciente,
          data.genero == 'F' ? 'Femenino' : 'Masculino' ,
          data.telefonoFijo == null ?'No Disponible' : data.telefonoFijo
        ];
        for (var i = 0; i < 5; i++) {
          var structureData = '<div class="dato">\
          <p class="tituloDato">\
          <span class="fa '+ icons[i] +'"></span><span class="dosPuntos">'+ labels[i] +'</span>\
          </p>\
          <p class="textDato">'+ text[i] +'</p>\
          </div>';

          allStructureData += structureData;
        }
        return allStructureData;
      };

      var createPersonal = function (personal) {
        var allPersonal =  '';
        $.each(personal, function () {
          var structurePersonal = '<p><span class="item-datoB-hc">'+ this.descripcionRol +':</span>'+ this.nombreCompleto +'</p>';
          allPersonal += structurePersonal;
        });
        return allPersonal;
      };

      var noResult = function (msm) {
        $('#ListarReportes').html('');
        var structure = '\
        <div class="n_flex n_justify_center whole_wrapper" ng-if="!reportesAPH">\
        <div class="n_flex_col50 md_flex_col30 lg_flex_col25 block">\
        <img class="whole_wrapper img_no_data" src="'+ url +'Public/Img/Todos/no-results.png" alt="No hay reportes disponibles." />\
        </div>\
        <div class="n_flex n_flex_col100 n_justify_center">\
        <h3 style="text-align:center; opacity:.6;">'+ msm +'</h3>\
        </div>\
        </div>';

        $('#ListarReportes').hide().append(structure).fadeIn('slow');
      };

      var ConsultarReporteAPH = function ( id ) {
        DoPostAjax({
          url: 'ReporteAPH/CtrlIndex/ConsultarReporteAPH',
          data: {
            request: 'ajax',
            idReporteAph: id
          }
        }, function (err, res) {
          var data = JSON.parse( res );
          console.log(data);

          // Permite redireccionar a la primera vista del reporte
          var redirect = false;

          // Limpiar localStorage
          localStorage.clear();

          if (data.reporte != null) {
            // Local Storage idReporteAPH(vista ==> CtrlLocalizacionLesiones)
            localStorage.setItem( 'ReporteAPH-idReporteAPH', id );

            // Local Storage hora de confirmacion(vista ==> CtrlResultadosAtencion)
            localStorage.setItem( 'ReporteAPH-HoraConfirmacion', JSON.stringify(data.reporte.fechaHoraArriboEscena) );

            // Local Storage Informacion General(vista ==> ctrlInformacionGeneral)
            var objReporteI = {
              IDESTipoEvento: (data.reporte.idTiposEvento != null) ? data.reporte.idTiposEvento.split(',') : '',
              PersonalQueAtiende :(data.reporte.nombrePersonal != null) ? data.reporte.nombrePersonal.split('-') : '',
              informacion: {
                direccion: data.reporte.ubicacionIncidente || '',
                puntoreferencia: data.reporte.puntoReferencia || '',
                descripcionEmergencia: data.reporte.informacionInicial || ''
              },
              Triage: data.reporte.idTriage || 0,
              Tiempos: {
                despacho: getDate(data.reporte.fechaHoraDespacho, 'time'),
                arriboEscena: getDate(data.reporte.fechaHoraArriboEscena, 'time'),
                arriboIPS: getDate(data.reporte.fechaHoraArriboIPS, 'time'),
                finAtencion: getDate(data.reporte.fechaHoraFinalizacion, 'time')
              },
              Cuidados: (data.reporte.cuidadoAntesArribo != null) ? data.reporte.cuidadoAntesArribo.split(',') : '',
            };
            localStorage.setItem( 'ReporteAPH-ReporteInicial', JSON.stringify(objReporteI) );


            // Local Storage paciente(vista ==> CtrlTipoEvento)
            if (data.reporte.numeroDocumento) {
              var objPaciente = {
                id: data.reporte.idPAciente || '',
                documento: data.reporte.numeroDocumento || '',
                idAcompanante: data.reporte.idAcompanante || '',
                documentoAcompanante: data.reporte.identificacionA || ''
              };
              localStorage.setItem( 'ReporteAPH-Paciente', JSON.stringify(objPaciente) );
            }


            // Local Storage Aseguramiento(vista ==> ctrlMotivoConsulta)
            if (data.reporte.idTipoAseguramiento) {
              var objAseguramiento = {
                id: data.reporte.idTipoAseguramiento || 0
              };
              localStorage.setItem( 'ReporteAPH-Aseguramiento', JSON.stringify(objAseguramiento) );
            }


            if (data.reporte.idAfectadoAccidenteTransito) {
              // Local Storage Afectado(vista ==> ctrlMotivoConsulta)
              var objAfectado = {
                id: data.reporte.idAfectadoAccidenteTransito || '',
                placa: data.reporte.placaVehiculo || '',
                codigoAseguradora: data.reporte.codigoAseguradora || '',
                numeroPoliza: data.reporte.numeroPoliza || ''
              };
              localStorage.setItem( 'ReporteAPH-Afectado', JSON.stringify(objAfectado) );
            }


            // Local Storage ExamenFisico(vista ==> CtrlAntecedentesPaciente)
            var ocular = validarGlasgow('Ocular', data.reporte.especificacionOcular),
            verbal = validarGlasgow('Verbal', data.reporte.especificacionVerbal),
            motor = validarGlasgow('Motor', data.reporte.especificacionMotor),
            objExamenFisicoAPH = {
              TablaGlasgow: {
                "ocular": ocular,
                "verbal": verbal,
                "motor": motor,
                "descripcionOcular": (ocular == 'No Evaluable') ? data.reporte.especificacionOcular : '',
                "descripcionVerbal": (verbal == 'No Evaluable') ? data.reporte.especificacionVerbal : '',
                "descripcionMotor": (motor == 'No Evaluable') ? data.reporte.especificacionMotor : ''
              },
              Respiracion: {
                "valor": data.reporte.respiracion_min,
                "estado": data.reporte.estadoRespiracion || '',
                "spo": data.reporte.SpO2 || '',
                horaUltimaIngesta: data.reporte.ultimaIngesta || '',
                fechaUltimaIngesta: ""
              },
              Pulso: {
                "valor": data.reporte.pulsaciones_min || '',
                "estado": data.reporte.estadoPulso || ''
              },
              PresionArterial: {
                "sistolica": data.reporte.sistolica || '',
                "diastolica": data.reporte.diastolica || '',
                "glucometria": data.reporte.glucometria || ''
              },
              Conciencia: {
                "estado": data.reporte.conciencia || '',
                "glasgow": Number(data.reporte.glasgow || 0)
              },
              Pupilas: {
                "derecha": data.reporte.estadoPupilaD || '',
                "izquierda": data.reporte.estadoPupilaI || '',
                "izquierdaDilatacion": Number(data.reporte.gradoDilatacionPI || 0),
                "derechaDilatacion": Number(data.reporte.gradoDilatacionPD || 0)
              },
              Piel: (data.reporte.piel != null) ? data.reporte.piel.split(',') : '',
              EstadoHemodinamico: data.reporte.estadoHemodinamico || '',
              EspecificacionExamen: data.reporte.EspecifiqueExamenFisico || '',
              Antecedentes: {},
              horaExamenFisico: data.reporte.horaExamenFisico || ''
            };

            // Validar si hay fecha hora ultima ingesta
            if (data.reporte.ultimaIngesta) {
              var fechaHoraUltimaI = data.reporte.ultimaIngesta.split(" ");
              objExamenFisicoAPH.Respiracion.fechaUltimaIngesta = fechaHoraUltimaI[0];
              objExamenFisicoAPH.Respiracion.horaUltimaIngesta = fechaHoraUltimaI[1];
            }

            // Validar si existen antecedentes asociados a la consulta
            var isDataNull = (data.antecedentes != null) ? false : true;

            getTiposAntecedentes(data.antecedentes, isDataNull)
            .then(function (data) {
              objExamenFisicoAPH.Antecedentes = data;
              localStorage.setItem( 'ReporteAPH-ExamenFisicoAPH', JSON.stringify(objExamenFisicoAPH) );
            });

            // Local Storage Tratamientos Basicos(vista ==> CtrlTratamientoB)
            var objTratamientoB = {
              idTipoTratamiento: [],
              observacionTratamiento: data.reporte.descripcionTratamiento || ''
            };
            var objTratamientoBaOxigeno = {
              idTipoTratamiento: [],
              descripcionOxigeno: ''
            };

            if (data.tratamientos != null && data.tratamientos.length > 0) {
              data.tratamientos.forEach(function (el, i) {
                if (el.categoriaTratamientoAph == 'Tratamiento Basico') {
                  if (el.idTipoTratamiento != 8) {
                    objTratamientoB.idTipoTratamiento.push(el.idTipoTratamiento);
                  }else {
                    objTratamientoBaOxigeno.idTipoTratamiento.push(el.idTipoTratamiento);
                    objTratamientoBaOxigeno.descripcionOxigeno = Number(el.valor);
                  }
                }
              });

              localStorage.setItem( 'ReporteAPH-tratamientoBasico', JSON.stringify(objTratamientoB) );
              localStorage.setItem( 'ReporteAPH-tratamientoBasicoOxigeno', JSON.stringify(objTratamientoBaOxigeno) );
            }


            // Local Storage Tratamientos Avanzados(vista ==> CtrlTratamientoA)
            var objTratamientoA = {
              idTipoTratamiento: [],
              observacionTratamiento: data.reporte.descripcionTratamientoAvanzado || '',
              desfibrilacion: ""
            },
            objTratamientoAvDextrosa = {
              idTipoTratamiento: [],
              descripcionDextrosa: ''
            },
            objTratamientoAvDesfibrilacion = {
              julios1: '',
              hora1: "",
              julios2: '',
              hora2: "",
              julios3: '',
              hora3: ""
            };

            if (data.tratamientos != null && data.tratamientos.length > 0) {
              data.tratamientos.forEach(function (el, i) {
                if (el.categoriaTratamientoAph == "Tratamiento Avanzado") {
                  if (el.idTipoTratamiento != 22) {
                    objTratamientoA.idTipoTratamiento.push(el.idTipoTratamiento);
                  }else {
                    objTratamientoAvDextrosa.idTipoTratamiento.push(el.idTipoTratamiento);
                    objTratamientoAvDextrosa.descripcionDextrosa = Number(el.valor);
                  }
                }
              });
            }

            if (data.desfibrilaciones != null && data.desfibrilaciones.length > 0) {
              if (data.desfibrilaciones[0] != null) {
                objTratamientoAvDesfibrilacion.julios1 = Number(data.desfibrilaciones[0].joules);
                objTratamientoAvDesfibrilacion.hora1 = data.desfibrilaciones[0].horaDesfibrilacion;
              }

              if (data.desfibrilaciones[1] != null) {
                objTratamientoAvDesfibrilacion.julios2 = Number(data.desfibrilaciones[1].joules);
                objTratamientoAvDesfibrilacion.hora2 = data.desfibrilaciones[1].horaDesfibrilacion;
              }

              if (data.desfibrilaciones[2] != null) {
                objTratamientoAvDesfibrilacion.julios3 = Number(data.desfibrilaciones[2].joules);
                objTratamientoAvDesfibrilacion.hora3 = data.desfibrilaciones[2].horaDesfibrilacion;
              }

              localStorage.setItem( 'ReporteAPH-tratamientoAvanzadoDesfibrilacion', JSON.stringify(objTratamientoAvDesfibrilacion) );
            }

            localStorage.setItem( 'ReporteAPH-tratamientoAvanzado', JSON.stringify(objTratamientoA) );
            localStorage.setItem( 'ReporteAPH-tratamientoAvanzadoDextrosa', JSON.stringify(objTratamientoAvDextrosa) );


            // Local Storage urgencias(vista ==> ctrlMotivoConsulta)
            if (data.motivosConsulta != null) {
              var objUrgencias = [];
              data.motivosConsulta.forEach(function (el, indice) {
                objUrgencias.push(el.idMotivoConsulta);
              });
              localStorage.setItem( 'ReporteAPH-Urgencias', JSON.stringify(objUrgencias) );
            } // Fin validación existencia motivosConsulta


            // Local Storage Medicamentos(vista ==> CtrlMedicamento)
            var arrMedicamento = [];
            if (data.medicamentos != null && data.medicamentos.length > 0) {
              data.medicamentos.forEach(function (el, i) {
                arrMedicamento.push({
                  idLocalStorage: i + 1,
                  id: Number(el.idmedicamento),
                  dosis: el.dosis,
                  hora: el.hora,
                  viaAdministracion: el.viaAdministracion,
                  cantidad: el.cantidadUnidades,
                  nombre: el.nombreRecurso
                });
              });

              localStorage.setItem( 'ReporteAPH-Medicamento', JSON.stringify(arrMedicamento) );
            }


            // Local Storage ResultadoFinal(vista ==> CtrlResultadosAtencion)
            var objResultadoFinal = {
              resultado: data.reporte.evaluacionResultado || '',
              institucion: data.reporte.institucionReceptora || '',
              complicacion: data.reporte.complicaciones || '',
              entregaPaciente: data.reporte.situacionEntrega || '',
              testigoUno: {},
              testigoDos: {},
              presionArterial: data.reporte.presionArterialEntrega || '',
              pulso: data.reporte.pulsoEntrega || '',
              respiracion: data.reporte.respiracionEntrega || '',
              nombreotroPersonal: data.reporte.nombreOtroPersonalControlM || '',
              controlMedico: [],
              protocolo: Number(data.reporte.protocolo),
              idCertificado: data.reporte.idCertificadoAtencion,
              TAPHPresente: Boolean(data.reporte.TAPHPresente),
              TPAPHPresente: Boolean(data.reporte.TPAPHPresente),
              otroPersonalPresente: Boolean(data.reporte.otroPersonalControlM),
              arribo: data.reporte.fechaHoraArriboIPS || ''
            };

            if (data.viasComunicacion != null) {
              data.viasComunicacion.forEach(function (el, i) {
                objResultadoFinal.controlMedico.push(el.viaComunicacion);
              });
            }

            if (data.testigos != null) {

              objResultadoFinal.testigoUno = {
                "nombre": (data.testigos != null) ? data.testigos[0].nombreTestigo : '',
                "cedula": (data.testigos != null) ? data.testigos[0].identificacionTestigo : ''
              };
              if (data.testigos.length == 2) {
                objResultadoFinal.testigoDos = {
                  "nombre": (data.testigos != null) ? data.testigos[1].nombreTestigo : '',
                  "cedula": (data.testigos != null) ? data.testigos[1].identificacionTestigo : ''
                };
              }

            }

            localStorage.setItem( 'ReporteAPH-ResultadoFinal', JSON.stringify(objResultadoFinal) );

            // Fecha hora finalización de la emergencia
            var hora = String(data.reporte.fechaHoraFinalizacion);
            localStorage.setItem('ReporteAPH-fechaHF', JSON.stringify(hora));

            // Paramedico que realizó la HC
            var objParamedicoAtiende = {
              nombre: data.reporte.nombreAtiende.trim() || "",
              apellido: data.reporte.apellidoAtiende.trim() || "",
              documento: data.reporte.documentoAtiende.trim() || "",
              urlFirma: data.reporte.urlFirmaAtiende || "",
              urlFoto: data.reporte.urlFotoAtiende || ""
            };

            localStorage.setItem('ReporteAPH-ParamedicoAtencion', JSON.stringify(objParamedicoAtiende));

            if (data.reporte.documentoRecibe != null) {
              var objMedicoRecibe = {
                nombre: data.reporte.nombreRecibe.trim() || '',
                apellido: data.reporte.apellidoRecibe.trim() || '',
                documento: data.reporte.documentoRecibe.trim() || '',
                urlFoto: data.reporte.urlFotoRecibe || '',
                urlFirma: data.reporte.urlFirmaRecibe || ''
              };

              localStorage.setItem( 'ReporteAPH-MedicoRecibe', JSON.stringify(objMedicoRecibe) );
            }


            // Local Storage Migas de Pan(vista ==> ALL)
            var views = [
              "ctrlInformacionGeneral",
              "CtrlTipoEvento",
              "ctrlMotivoConsulta",
              "ctrlAntecedentesPaciente",
              "ctrlLocalizacionLesiones",
              "ctrlTratamientoB",
              "ctrlTratamientoA",
              "ctrlMedicamento",
              "ctrlResultadosAtencion"
            ];
            localStorage.setItem( 'ReporteAPH-vista', JSON.stringify(views) );

            redirect = true;
          } // Fin validación existencia reporte


          // Redireccionar a la primera vista del ReportesAPH
          if (redirect) {
            window.location = url + "ReporteAPH/CtrlInformacionGeneral";
          }else {
            Notificate({
              titulo: 'Ha ocurrido un error',
              descripcion: 'No se puedó consultar el reporte APH.',
              tipo: 'error',
              duracion: 3
            });
          }

        }); // Fin callback DoPostAjax
      };


      var getDate = function ( DATE, get ) {
        var date = '';
        if (DATE) {
          date = new Date(DATE);
          var HH = date.getHours();
          var MM = date.getMinutes();
          var SS = date.getSeconds();
          if (HH < 10) HH = "0" + HH;
          if (MM < 10) MM = "0" + MM;
          if (SS < 10) SS = "0" + SS;

          if (get == 'time') return HH + ":" + MM + ":" + SS;
        }
        return date;
      };

      var validarGlasgow = function (tipo, valor) {
        var // Coinciden con la tabla glasgow
        tiposOcular = ['Ninguna', 'Dolor', 'Llamado', 'Espontanea'],
        tiposVerbal = ['Ninguna', 'Gemidos', 'Inapropiadas', 'Desorientado', 'Normal'],
        tiposMotor  = ['Ninguna', 'Extension', 'Flexion', 'Retirada', 'Localizacion', 'Obedece'],
        arr = [];

        if (tipo == 'Ocular') {
          arr = tiposOcular;
        }else if (tipo == 'Verbal') {
          arr = tiposVerbal;
        }else if (tipo == 'Motor') {
          arr = tiposMotor;
        }

        var res = arr.some(function (el) {
          return el === String(valor);
        });

        return (res) ? valor : 'No Evaluable';
      };

      var getTiposAntecedentes = function (consulta, isDataNull) {
        return new Promise(function (resolve, reject) {
          DoPostAjax({
            url: 'ReporteAPH/ctrlTipoAntecedente/ListarTipoAntecedente'
          }, function(err, data) {
            if (err) {
              // Si ocurre algún error:
              Notificate({
                titulo: 'Ha ocurrido un error',
                descripcion: 'No se puede listar los antecedentes',
                tipo: 'error',
                duracion: 4
              });
              reject(err);
            } else {
              var listado = JSON.parse(data),
              count = 0,
              Izquierda = [],
              Derecha = [];

              if (!isDataNull) {
                listado.forEach(function(el, i) {
                  consulta.forEach(function(el2, i2) {
                    if (el.idTipoAntecedente == el2.idTipoAntecedente) {
                      el.si = true;
                      el.especificacion = el2.especificacion;
                    }
                  });
                });
              }

              listado.forEach(function(el, i) {
                if (!el.hasOwnProperty('si')) {
                  el.si = false;
                }
              });

              chunk = listado.chunk(2);
              resolve({
                "Derecha" : chunk[0],
                "Izquierda": chunk[1]
              });
            }
          });

        });
      };

      if (error === "error") {
        Notificate({
          titulo: 'Ha ocurrido un error',
          descripcion: 'No se puede ingresar a los resultados de atención sin haber completado el reporte.',
          tipo: 'error',
          duracion: 8
        });
      }

    }, function (err) {
      Notificate({
        titulo: 'Ha ocurrido un error',
        descripcion: 'No se pudó obtener el modo de trabajo.',
        tipo: 'error',
        duracion: 8
      });
    }); // Fin reject promise WhichWorkMode
  })(this);
