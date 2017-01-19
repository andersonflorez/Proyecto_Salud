<!--FLECHA DERECHA-->
<a  title="Siguiente" class="flecha-der flechaCuerpoGuardarLocalD" >
  <li class="fa fa-long-arrow-right"></li>
</a>


<!--FLECHA IZQUIERDA-->
<a  title="Volver" class="flecha-izq flechaCuerpoGuardarLocalI">
  <li class="fa fa-long-arrow-left"></li>
</a>


<div class="barraFracturasSelect">
  <ul class="cont-barraFracturasSelect" id="cont-barraFracturasSelectId"></ul>
</div>


<div class="fila aling align-center margin-top">
  <div class="columna--10 columna-hd--10 columna-movil--10 columna-tablet--10" >
    <div >
      <div class="cont_menu_bolitas">
        <div class="menu_bolitas">
          <div class="icono_bola" id="btnRotarCuerpo">
            <div class="fa fa-repeat" title="Rotar cuerpo"></div>
          </div>
          <div class="icono_bola" id="bola_plus" fracturasSeleccionadas = '0'>
            <div class="fa fa-plus" title="Agrergar fractura"></div>
          </div>
          <div class="icono_bola" id="ListarPuntos">
            <div class="fa fa-list-alt" title="Listar puntos" ></div>
          </div>
          <div class="icono_bola"  onclick="quitarSeleccion(true)" id="btnQuitarS">
            <div class="fa fa-trash-o" title="Eliminar selección" ></div>
          </div>
          <div class="icono_bola" id="btnGuardarD">
            <div class="fa fa-floppy-o" title="Guardar diagnostico" ></div>
          </div>
        </div>
      </div>

      <div id="cont_cuerpo">
        <img id="img_cuepo_frontal" src="<?=URL?>Public/Img/ReporteAPH/body2.png"/>
      </div>

    </div>
  </div>
</div>


<!-- MENU LATERAL -->
<div class="menu_lesiones">
  <div class="head_m_lesiones">
    <div class="head_m_title"><b>Lesiones</b></div>
    <div class="cont_head_m_close">
      <div class="head_m_close"></div>
    </div>
  </div>

  <div class="head_m_buscar">
    <input type="search" id="filterCie10"  placeholder="Filtrar lesiones..." >
  </div>

  <div class="body_m_lesiones"></div>

  <div class="footer_m_lesiones">
    <div class="n_flex n_justify_center horizontal_padding">
      <ul class="paginador" id="paginadorCI10"></ul>
    </div>
  </div>
</div>
