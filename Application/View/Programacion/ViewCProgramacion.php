<body>
<a href="<?=URL?>Programacion/ctrlConsultarUsuarios" title="Volver" class="flecha-izq">
  <li class="fa fa-long-arrow-left"></li>
</a>
<section class="calendario">

<div class="contenido-calendario">
  <div class="encabezado-calendario">
    <div class="encabezado-titulo" id="informa">
          <p><span>Calendario </span>| Domiciliaria </p>


    </div>
    <!--<div class="encabezado-titulo2">
          <p><span>Calendario</span></p>
    </div> -->
    <div class="encabezado-meses">
      <ul>
        <li id="hora"><strong id="faa"></strong></li>
      </ul>
        <ul>
          <li name="izquierda" ><button onclick="cll(1)" type="button" name="AnteriorMes" class="li1 fa fa-chevron-left"></button></li>
          <li class="li2" id="li2"></li>
          <li  id="derecha"><button onclick="cll(2)" type="button" name="SiguienteMes" class="li3 fa fa-chevron-right"></button></li>
        </ul>
    </div>
  <!--  <div class="encabezado-meses" width="10%" >
  </div>--><br><br><br>
    <div class="encabezado-nuevo2 "><div class="n_flex block">

    </div>
      <div class="n_flex">
        <div class="sm_flex_col1 md_flex_col2 lg_flex_col2 horizontal_padding">
          <input placeholder="ss" class="fa fa-search btn btn-consultar datepicker-here" data-language='en' data-min-view="months" type="button" data-view="months" data-date-format="MM yyyy" id="buscar"></input>
        </div>
      <div class="sm_flex_col1 md_flex_col2 lg_flex_col2">
        <ul id="ListaImprimir"></ul>
      </div><div class="sm_flex_col0 md_flex_col1 lg_flex_col2 horizontal_padding">
      </div>
      <div class="sm_flex_col1 md_flex_col2 lg_flex_col2">
        <button class="btn-modal btn btn-consultar " target="modal1" type="button" id="seguido">Ver turnos</button>
      </div>
        </div>
    </div>

  </div>
  <div class="cuerpo-calendario">
    <div class="cuerpo-titulo">
      <ul>
        <li><a href="#">Domingo</a></li>
        <li><a href="#">Lunes</a></li>
        <li><a href="#">Martes</a></li>
        <li><a href="#">Miércoles</a></li>
        <li><a href="#">Jueves</a></li>
        <li><a href="#">Viernes</a></li>
        <li><a href="#">Sábado</a></li>
      </ul>
    </div>
    <div class="cuerpo-titulo2">
      <ul>
        <li><a href="">D</a></li>
        <li><a href="">L</a></li>
        <li><a href="">M</a></li>
        <li><a href="">M</a></li>
        <li><a href="">J</a></li>
        <li><a href="">V</a></li>
        <li><a href="">S</a></li>
      </ul>
    </div>
     <div class="cuerpo-dias " id="cuerpo-dias"></div>
<!-- 'id' debe ser igual a 'target' -->
<div class="modal-ventana whole_wrapper"   id="modal1">
  <div class="modal relative_element">

    <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
      <!-- Titulo de la ventana modal -->
      <h2>Turnos</h2>
      <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
    </div>

    <div class="modal-body">
      <!-- Contenido de la ventana modal -->
      <div class="panel block">

      </div>
      <div class="panel block">

        <div class="panel-contenido">

          <article class="block">
            <h6 class="text_bold block">Turnos que tiene actualmente</h6>
  <table class="tbl_responsive">
    <tbody id="body">
    </tbody>
  </table>

        </div>
      </div>
    </div>

    <div class="modal-footer n_flex n_justify_end">
      <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
    </div>
  </div>
</div>

  </div>
   <div class="modal-ventana whole_wrapper" id="modal2">
              <div class="modal relative_element">
                <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                  <h3 id="lola">Citas programadas</h3>
                  <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                </div>

                <div class="modal-body" id="bobadas" >

                  <table class='tbl_responsive' id="mostrar">
                  <thead>
                  <tr>
                  <th>Nombre Paciente</th>
                  <th>Apellido Paciente</th>
                   <th>Numero documento</th>
                    <th>Hora inicialr</th>
                    <th>Hora final</th>
                    <th>Fecha</th>
                    <th>Direccion</th>
                    <th>Nombre CUP</th>
                    </tr></thead>
                    <tbody id="mostrarcositas" >
                    </tbody>
                    </table>

                </div>
                <div class="modal-footer n_flex n_justify_end">
                  <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
                </div>
              </div>
            </div>
</section>
</body>
