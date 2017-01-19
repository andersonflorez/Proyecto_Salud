<body>
  <a href="<?=URL?>Programacion/ctrlConsultarUsuarios" title="Volver" class="flecha-izq">
    <li class="fa fa-long-arrow-left"></li>
  </a>
<section class="calendario">

<div class="contenido-calendario">
  <div class="encabezado-calendario">

    <div class="encabezado-titulo">
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
    <div class="encabezado-nuevo"><center><button class="btn-modal btn btn-registrar block" target="modal1" type="button" id="seguido">Ingresar turno</button></center></div>
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
<div class="modal-ventana whole_wrapper" id="modal1">
  <div class="modal relative_element">

    <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
      <!-- Titulo de la ventana modal -->
      <h2>Turnos</h2>
      <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
    </div>

    <div class="modal-body">
      <!-- Contenido de la ventana modal -->
      <div class="panel block">
        <div class="panel-contenido">
          <article class="block">
            <h6 class="text_bold block">Seleccione los turnos</h6>

  <table class="tbl_responsive" >
    <thead>
      <tr>
        <th>Primer turno</th>
        <th>Segundo turno</th>
        <th>Tercer turno</th>
        <th>Cuarto turno</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>00:00 a 06:00
          <div class="cont-checkbox">
            <div class="checkbox">
               <input value="1" type="checkbox" name="TxtPersona" class="seleccion">
              <label><span class="fa fa-check"></span></label>
              </div>
        </div>
        </td>
        <td>06:00 a 12:00
           <div class="cont-checkbox">
            <div class="checkbox">
               <input value="2" type="checkbox" name="TxtPersona" class="seleccion">
              <label><span class="fa fa-check"></span></label>
              </div>
        </div>
        </td>
        <td>12:00 a 18:00
           <div class="cont-checkbox">
            <div class="checkbox">
               <input   type="checkbox" name="TxtPersona" class="seleccion" value="3">
              <label><span class="fa fa-check"></span></label>
            </div>
        </div>
        </td>
        <td>18:00 a 00:00
           <div class="cont-checkbox">
            <div class="checkbox">
               <input value="4" type="checkbox" name="TxtPersona" class="seleccion">
              <label><span class="fa fa-check"></span></label>
              </div>
        </div>
        </td>
      </tr>
    </tbody>
  </table>
        </div>
      </div>
    </div>

    <div class="modal-footer n_flex n_justify_end">
    <button class="btn btn-registrar guardar">Registrar</button>
      <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
    </div>
  </div>
</div>
<!--modal 2 -->
<div class="modal-ventana whole_wrapper" id="modal2">
  <div class="modal relative_element">

    <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
      <!-- Titulo de la ventana modal -->
      <h2>Programacion</h2>
      <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
    </div>

    <div class="modal-body">
      <!-- Contenido de la ventana modal -->
      <div class="panel block">
        <div class="panel-contenido">
          <article class="block">
            <h6 class="text_bold block">Programacion actual</h6>

  <table class="tbl_responsive" >
    <thead>
      <tr>
        <th>Turno de inicio</th>
        <th>Turno de fin</th>
        <th>Fecha de inicio</th>
        <th>Fecha de fin</th>
      </tr>
    </thead>
    <tbody>
      <tr id="Programacion">

      </tr>
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
</section>
</body>
