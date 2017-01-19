<!-- CONTENEDOR PRINCIPAL DE LA PÁGINA -->
<div class="contenedor-principal">

  <!-- MENÚ IZQUIERDO -->
  <div class="menu-principal-maestras">

    <!-- MÓDULOS -->
    <ul class="ul-contenedor-modulos">

      <?php foreach ($this->menu as $Modulo) : ?>

        <!-- MÓDULO -->

        <li class="modulo" modulo="<?=$Modulo['NombreModulo']?>">
          <div class="text-container">
            <div class="grupo"><div><i class="fa fa-<?=$Modulo['Icono']?>"></i></div><span><?=$Modulo['NombreVistaModulo']?></span></div>
            <i class="flecha-derecha fa fa-angle-right"></i>
          </div>

          <!-- SUBMENÚ DEL MÓDULO -->
          <ul class="submenu-modulo">


            <?php

            foreach ($Modulo['Maestras'] as $Maestra):
              $ColumnasTabla = "";
              foreach ($Maestra['ColumnasTabla'] as $ColumnaTabla) {
                $ColumnasTabla .= $ColumnaTabla . "-";
              }
              $ColumnasTabla = substr($ColumnasTabla, 0, strlen($ColumnasTabla) - 1);
              ?>

              <li class="tabla-maestra" controlador="<?=$Maestra['Controlador']?>" tablaBD="<?=$Maestra['idTabla']?>" columnasTabla="<?=$ColumnasTabla?>"><span><?=$Maestra['NombreTablaVista']?></span>
              </li>

            <?php endforeach ?>

          </ul>
        </li>

      <?php endforeach ?>

    </ul>

  </div>

  <!-- CONTENEDOR DESPLEGABLE DE SUBMENÚS -->
  <ul class="ul-contenedor-submodulos" modulo=""></ul>

  <!-- MÓDULOS -->
  <div class="contenido-principal-maestra">

    <div class="informacion-inicial">

      <div class="tituloInfo">
        <h2>Configuración de tablas maestras</h2>
      </div>

      <div class="descripcion-pagina">
        <h4>Instrucciones:</h4>
        Selecciona una tabla de uno de los módulos del menú izquierdo para ver su contenido.
        Podrás realizar las siguientes acciones al momento de acceder a la configuración de una tabla:

        <ul class="lista-acciones">

          <li>
            <h4>Consultar registros</h4>
            <article>
              Cada tabla dispone de un paginador de datos en caso de haber mucha información, podrás elegir el número de datos que deseas ver, filtrar registros usando el buscador general ubicado en la parte superior derecha de la tabla o filtrar por campo en el buscador ubicado al final de cada columna
            </article>
          </li>

          <li>
            <h4>Registrar nueva información</h4>
            <article>
              Puedes agregar más registros a una tabla presionando click sobre el botón superior izquierdo en la sección de configuración de la tabla, solo deberás llenar la información del formulario que se despliega
            </article>
          </li>

          <li>
            <h4>Modificar datos</h4>
            <article>
              Presiona click en el botón azul con el ícono del lápiz que se encuentra en cada fila de la tabla para modificar su información
            </article>
          </li>

          <li>
            <h4>Activar o inactivar registros</h4>
            <article>
              Un registro puede ser inhabilitado presionando click en el botón de color rojo con el ícono de un candado que aparece al final de cada fila de la tabla, vuelva a presionarlo para habilitar el registro nuevamente.
              <br>
              Nota: Los registros inactivos no podrán ser usados en otras partes de la aplicación
            </article>
          </li>

        </ul>
      </div>

    </div>

    <div class="contenido-maestra">

      <div class="header-section">
        <div class="table-info">
          <h2><span><i class="fa fa-cog"></i>Módulo: </span><span id="nombre-modulo"></span></h2>
          <h2><span><i class="fa fa-table"></i>Tabla: </span><span id="nombre-tabla"></span></h2>
          <button id="btn-form-registro" class="new-row btn btn-consultar" title="Nuevo Registro">
            <div>
              <i class="fa fa-plus"></i>
            </div>
            <span>Nuevo Registro</span>
          </button>
        </div>
      </div>

      <div id="contenedor-tabla-maestra" class="table-section">
        <!-- ESTO SE RELLENA DINÁMICAMENTE -->
      </div>

    </div>



    <div class="formato-tabla" style="display:none;">
      <table  class="display compact">
        <thead id="headTable">
        </thead>
        <tfoot id="footTable">
        </tfoot>
      </table>
    </div>



    <div class="sweet-overlay" tabindex="-1">

    </div>

    <div class="sweet-alert show-input showSweetAlert" data-custom-class="" data-has-cancel-button="true" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="true" data-animation="slide-from-top" data-timer="null">

      <h2>Nuevo registro</h2>

      <fieldset>

      </fieldset>

      <div class="sa-error-container">
        <div class="icon"><i></i></div>
        <p>Complete todos los campos</p>
      </div>

      <div class="sa-button-container">
        <button class="cancel" tabindex="2" style="display: inline-block; box-shadow: none;">Cancelar</button>
        <div class="sa-confirm-button-container">
          <button id="btn-confirmar" onclick="ConfirmarEnvioFormulario();" class="confirm" tabindex="1" style="display: inline-block; box-shadow: rgba(140, 212, 245, 0.8) 0px 0px 2px, rgba(0, 0, 0, 0.0470588) 0px 0px 0px 1px inset; background-color: rgb(140, 212, 245);">OK</button>
        </div>
      </div>
    </div>


  </div>
</div>

<script>
document.querySelector('body').style.overflow = "hidden";
</script>
