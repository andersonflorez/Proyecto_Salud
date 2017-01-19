// Notificaciones
(function(global) {

  // Función global para eliminar la notificación manualmente:
  this.manuallyDestroy = function(notify) {
    $('#' + notify).fadeOut('fast', function() {
      $(this).remove();
    });
  };

  // Nombre de espacio Notify con SINGLETON:
  var Notify = {

    // Instancia única de la clase:
    _instance: null,

    // Función para obtener la instancia única de la clase:
    getInstance: function() {
      if (!this._instance) {

        // Propiedades y métodos de la clase:
        this._instance = {

          // Configuración predeterminada de las notificaciones:
          defaultconfig: {
            tipo: 'default',
            titulo: 'Notificacion',
            descripcion: '',
            duracion: 2500
          },

          // Función para obtener la configuración de la notificación:
          init: function(opt) {
            let options = null;
            if (opt) {
              options = {
                tipo: this.getType(opt.tipo),
                titulo: opt.titulo || this.defaultconfig.titulo,
                descripcion: opt.descripcion || this.defaultconfig.descripcion,
                duracion: this.getDelay(opt.duracion)
              };
            } else {
              options = this.defaultconfig;
            }
            return options;
          },

          // Función de validación de tipo de notificación:
          getType: function(tipo) {
            let Tipos = ['success', 'error', 'warning', 'info'];
            Tipo = Tipos.filter(function(elem) {
              return elem === tipo.toLowerCase();
            });
            return Tipo.length ? Tipo[0] : this.defaultconfig.tipo;
          },

          // Convertir tiempo de espera de destrucción de la notificación:
          getDelay: function(duracion) {
            if (!duracion || Number(duracion) === 0 || isNaN(duracion)) {
              return this.defaultconfig.duracion;
            }
            return Number(duracion) * 1000;
          },

          // Crea la estructura HTML de la notificación:
          create: function(config) {
            let icon;
            let id = Math.ceil(Math.random() * 1000 + 1);
            switch (config.tipo.toLowerCase()) {
              case 'success':
                icon = 'check';
              break;
              case 'error':
                icon = 'times';
              break;
              case 'warning':
                icon = 'exclamation';
              break;
              case 'info':
                icon = 'info';
              break;
            }
            let Estructura = '<div id="notify_' + id + '" class="' + config.tipo + ' notify n_flex n_nowrap block relative_element"><div class="icon n_flex n_align_center"><span class="n_flex n_justify_center n_align_center fa fa-' + icon + '"></span></div><div class="panel_info n_grow_up ovf_hidden n_flex n_align_center"><div class="n_flex n_align_center ovf_hidden relative_element"><div class="title n_flex n_justify_between n_grow_up ovf_hidden"><strong class="suspensive n_flex_col90">' + config.titulo + '</strong><span prmt="notify_' + id + '" onclick="manuallyDestroy($(this).attr(\'prmt\'))" class="n_flex_col_5 fa fa-times"></span></div><p class="relative_element">' + config.descripcion + '</p></div></div></div>';
            return Estructura;
          },

          // Crear el contenedor padre de las notificaciones:
          getParent: function() {
            if (!$('#notify_container').length) {
              let body = $('body');
              body.append('<div class="notify_container" id="notify_container"></div>');
            }
            let Parent = document.getElementById('notify_container');
            return Parent;
          },

          // Función para ejecutar la notificación:
          displayNotification: function(opt) {
            let config = this.init(opt);
            let structure = this.create(config);
            let parent = this.getParent();
            $(parent).append(structure);
            let notification = {
              node: $(parent).children().last(),
              config: config
            };
            notification.node.attr('duration', config.duracion);

            // Animación de aparición de la notificación:
            notification.node.animate({
              'opacity': '1',
              'margin-top': '0%'
            }, 350);
          },

          // Función para destruir la notificación:
          destroy: function(node) {
            window.setTimeout(function() {

              // Animación de desaparición de la notificación:
              $(node).animate({
                opacity: 0
              }, 300, function() {
                $(this).remove();
              });
            }, Number($(node).attr('duration')));
          },

          // Instancia del observador:
          observer: null,

          // Crear el objeto observer:
          createObserver: function() {
            let observer = new MutationObserver(function(mutations) {
              mutations.forEach(function(mutation) {
                var parent = this.getParent();
                // Cuando se despliegue una notificación:
                var addedNodes = mutation.addedNodes;
                for (var node in addedNodes) {
                  if (addedNodes.hasOwnProperty(node)) {
                    if ($(addedNodes[node]).hasClass('notify') && $(parent).children().length === 1) {
                      this.destroy(addedNodes[node]);
                    }
                  }
                }

                // Cuando se destruya una notificación:
                var removedNodes = mutation.removedNodes;
                for (var node in removedNodes) {
                  if (removedNodes.hasOwnProperty(node)) {
                    if ($(removedNodes[node]).hasClass('notify') && $(parent).children().length > 0) {
                      this.destroy($(parent).children().first());
                    }
                  }
                }

              }.bind(this));
            }.bind(this));

            return observer;
          },

          // Configuración del objeto observador:
          config: {childList: true},

          // Observar:
          observe: function() {
            if (!this.observer) {
              this.observer = this.createObserver();
              this.observer.observe(this.getParent(), this.config);
            }
          }

        };
      }
      return this._instance;
    }

  };

  // Para abrir una notificación se usa el siguiente método:
  this.Notificate = function(options) {
    obj = Notify.getInstance();
    obj.observe();
    obj.displayNotification(options);
  };

})(this);
