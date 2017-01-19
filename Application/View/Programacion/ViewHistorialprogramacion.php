
 <h1 class="titulo_vista"><span class="fa fa-calendar-o"></span> Historial programación </h1>
    <div class="fila">
      <div class="columna-2"></div>
      <div class="columna-9">
        <div class="panel">
          <div class="panel-cabecera"><h3><strong>Programaciones anteriores</strong></h3></div>
          <div class="panel-contenido">

            <div class="fila">
     <button type="submit" id="btnMostrar" class="btn btn-consultar regis" onclick="AbrirModal('modal1')">AGENDA ACTUAL</button>
         <?php foreach ($Personal as $TOR) {

echo '  <div class="panel-cabecera">

        <center>  <h3 class="text_bold ">'.$TOR->primerNombre.' &nbsp;  '.$TOR->primerApellido.'&nbsp; '.$TOR->segundoApellido.'</h3></center></div>';
} ?>
    </div><br><br>

              <div class="n_flex_col10id=""tbl_ejemplo">




             <table id="idiot" class="tbl_responsive">


             <thead>
        <tr>
          <th cellspacing="0" width="10%" >Hora de inicio</th>
          <th cellspacing="0" width="10%" >Hora de fin</th>
          <th cellspacing="0" width="10%" >Fecha de inicio</th>
          <th cellspacing="0" width="10%" >Fecha de fin</th>
          <!--<th>Dias</th>-->
        </tr>
        </thead>
        <tfoot>
        <tbody id="tabla" >
        </tbody>
      </table>
              </div>
          </div>
        </div>
      </div>
      <div class="columna-2"></div>
    </div>
    <br><br>
      <div class="modal-ventana whole_wrapper" id="modal1">
              <div class="modal relative_element">
                <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                  <h2>Agenda actual</h2>
                  <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>


                </div>
                <div class="modal-body">
                  <div class="panel block">
                    <div class="panel-contenido" id="Hello" >
                      <article class="block">
                        <p>

 <!-- <table class='tbl_responsive' id="consulta">
                  <thead>
                  <tr>
                  <th>Hora inicial</th>
                  <th>Hora final</th>
                   <th>Fecha inicial</th>
                    <th>Fecha final</th>
                    <th>Estado Agenda </th>
                    </tr></thead>
                    <tbody id="diagnostico" >
                    </tbody>
                    </table>
 -->




      </p>
      </div>
                  </div>
                </div>
                <div class="modal-footer n_flex n_justify_end">
          <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
                </div>
              </div>
            </div>
  <br>
  <br>
  <br>

<br>
               </div>
  </div>



  </body>
     <div class="columna-tablet-1 columna-1 columna-hd-1">
        </div>



</html>



<!--
$COL



-->
