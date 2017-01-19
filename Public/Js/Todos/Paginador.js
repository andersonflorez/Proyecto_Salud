/*
* PAGINATOR SCRIPT V1.0.0
* El presente script ha sido creado con el fin de gestionar
* la paginación dinámica de registros.
*/

var paginator = {
  // Funciones de interacción con la base de datos y otras operaciones:
  model: {
    configuration: {
      // Datos requeridos
      tableName: '',
      fields: '*',
      limit: 5,
      page: 1,

      // Datos opcionales
      nameColumnDateTime: '',
      filterDateTimeStart: '',
      filterDateTimeEnd: '',
      nameColumnFilter: '',
      filter: '',
      nameColumnOrderBy: '',
      orderBy: ''
    },

    queryDataBase: function(targetUrl, configuration) {
      return new Promise(function(done, reject) {
        if (!configuration.tableName) {
          let error = 'No se ha especificado un nombre de tabla';
          reject(error);
        } else {
          DoPostAjax({
            url: targetUrl,
            data: configuration
          }, function(err, res) {
            data = JSON.parse(res);
            if (!isNaN(data.cantidadRegistros)) {
              done(data);
            } else if (err) {
              let error = 'Ha ocurrido un error, no se ha podido realizar la petición';
              reject(error);
            }
          });
        }
      });
    },

    getConfiguration: function(config) {
      for (var prop in this.configuration) {
        if (!(prop in config)) {
          config[prop] = this.configuration[prop];
        }
      }
      return config;
    }
  },

  // Funciones de interacción con la vista
  view: {
    generateButtons: function(options) {
      let getEstructure = this.getEstructure;
      return new Promise(function(done, reject) {
        let config = paginator.model.getConfiguration(options.configuration);
        let ajaxPetition = paginator.model.queryDataBase(options.url, config);

        ajaxPetition.then(function(data) {
          let totalPages = Math.ceil(Number(data.cantidadRegistros) / Number(options.configuration.limit));
          let estructure = getEstructure(totalPages);
          $('#' + options.parent).html(estructure);
          done(data);
        })
        .catch(function(err) {
          alert(err);
        });
      }); // fin Promise
    },

    getEstructure: function(totalPages) {
      let estructure = '<li class="btn_paginador slider anterior"><span class="fa fa-angle-double-left"></span></li>';
      let print = (totalPages > 4) ? 5 : totalPages;

      for (var i = 1; i <= print; i++) {
        let clase = '';
        if (i == 1) {
          clase = 'initial active';
        } else if (i == 2) {
          clase = 'first';
        } else if (i == 3) {
          clase = 'center';
        } else if (i == 4) {
          clase = 'end';
        } else if (i == 5 && totalPages > 5) {
          clase = 'final puntos_final';
        }
        estructure += '<li class="btn_paginador ' + clase + '"><span class="pagina">' + (i == 5 ? totalPages : i) + '</span></li>';
      }

      estructure += '<li class="btn_paginador slider siguiente"><span class="fa fa-angle-double-right"></span></li>';
      return estructure;
    },

    paginate: function(btn) {
      let newBtn = this.newBtn;
      let validatePoint = this.validatePoint;
      let resetPages = this.resetPages;
      return new Promise(function(done, reject) {
        // Si el botón clickeado no es el que está activo:
        if (!btn.hasClass('active')) {

          // Identificar el botón activo:
          let parent = btn.parent();
          let active = parent.find('li.btn_paginador.active');
          let initial = parent.find('li.btn_paginador.initial');
          let final = parent.find('li.btn_paginador.final');
          let first = parent.find('li.btn_paginador.first');
          let center = parent.find('li.btn_paginador.center');
          let end = parent.find('li.btn_paginador.end');
          let finalNum = Number(final.text());
          let initialNum = Number(initial.text());
          let activeNum = Number(active.text());

          // Si el botón clickeado es un pasador:
          if (btn.hasClass('slider')) {
            let target;

            // Si el botón clickeado es 'siguiente':
            if (btn.hasClass('siguiente')) {

              if (active.hasClass('end') && activeNum < (finalNum - 1)) {
                active.removeClass('end').addClass('center');
                center.removeClass('center').addClass('first');
                first.remove();
                newBtn({
                  element: active,
                  numberPage: activeNum + 1,
                  isAfter: true,
                  class: 'end'
                });
              }else if (active.hasClass('center') && Number(end.text()) < (finalNum - 1)) {
                active.removeClass('center').addClass('first');
                end.removeClass('end');
                active.next().addClass('center');
                first.remove();
                newBtn({
                  element: active.next(),
                  numberPage: activeNum + 2,
                  isAfter: true,
                  class: 'end'
                });
              }

              // Capturar el botón siguiente en 'target':
              target = active.next();

            } else {

              if (active.hasClass('first') && activeNum !== 2) {
                active.removeClass('first').addClass('center');
                center.removeClass('center').addClass('end');
                end.remove();
                newBtn({
                  element: active,
                  numberPage: activeNum - 1,
                  isAfter: false,
                  class: 'first'
                });
              }else if (active.hasClass('center') && Number(first.text()) > 2) {
                active.removeClass('center').addClass('end');
                first.removeClass('first').addClass('center');
                active.prev().addClass('center');
                end.remove();
                newBtn({
                  element: active.prev(),
                  numberPage: activeNum - 2,
                  isAfter: false,
                  class: 'first'
                });
              }

              // Capturar el botón anterior en 'target':
              target = active.prev();

            }

            validatePoint(true, initial, finalNum);
            validatePoint(false, final, finalNum);

            // Si 'target' no es un pasador entonces paginar:
            if (!target.hasClass('slider')) {
              // Aqui iría el código para actualizar la vista
              done(Number(target.text()));

              active.removeClass('active');
              target.addClass('active').removeClass('hide_btn');
            }

          } else {
            // Aqui iría el código para actualizar la vista
            done(Number(btn.text()));

            if (btn.hasClass('initial')) {
              resetPages(false, parent, function() {
                validatePoint(true, initial, finalNum);
                validatePoint(false, final, finalNum);
              });
            }
            if (btn.hasClass('final')) {
              resetPages(true, parent, function() {
                validatePoint(true, initial, finalNum);
                validatePoint(false, final, finalNum);
              });
            }

            active.removeClass('active');
            btn.addClass('active');
          }

        }
      }); // Fin Promise
    },

    newBtn: function(config) {
      let estructure = '<li class="btn_paginador ' + config.class + '"><span class="pagina">' + config.numberPage + '</span></li>';
      if (config.isAfter) {
        $(estructure).insertAfter(config.element); // Después
      }else {
        $(estructure).insertBefore(config.element); // Antes
      }
    },

    validatePoint: function(isInitial, element, finalNum) {
      if (finalNum > 1) {
        if (isInitial) {
          if (Number(element.next().text()) === 2 || finalNum === 1) {
            element.removeClass('puntos_inicial');
          }else {
            element.addClass('puntos_inicial');
          }
        }else {
          if (Number(element.prev().text()) === (finalNum - 1)) {
            element.removeClass('puntos_final');
          }else {
            element.addClass('puntos_final');
          }
        }
      }
    },

    resetPages: function(isRight, parent, callback) {
      let finalNum = Number(parent.find('li.btn_paginador.final').text()) - 4;
      parent.find('li.btn_paginador .pagina').each(function(index) {
        if (!$(this).parent().hasClass('final') && !$(this).parent().hasClass('initial')) {
          if (isRight) {
            finalNum++;
            $(this).text(finalNum);
          }else {
            $(this).text(index + 1);
          }
        }
      });
      callback();
    }

  }
};
