<div class="separacion">
<div class="panel">
  <div class="panel-contenido">

<div class="md-fondo" id="m2">
<div class="md-modal md-efecto1 " >
<div class="md-titulo">
<h3>Personal De La Ambulancia</h3>
<span  onclick="cerrarModal('m2')" id="cierre">X</span>
 </div>
  <div class="md-contenido">
    <form id="frm">
      <label for="sl">Persona 1:</label>
      <select id="sl">
        <option>T.A.M</option>
        <option>T.A.B</option>
      </select>


      <label for="plcAmbulancia">Persona 2:</label>
      <select id="sl">
        <option>T.A.M</option>
        <option>T.A.B</option>
      </select><br>
        <label for="estAmbulancia">Persona 3:</label>
        <select id="sl">
          <option>T.A.M</option>
          <option>T.A.B</option>
        </select></span><br>
     <div class="md-botones">
       <div class="izquierda">
         <button type="button" class="btn btn-eliminar" onclick="cerrarModal('m2')">Cerrar</button>
       </div>
       <div class="derecha">
           <button type="submit" class="btn btn-modificar ">Modificar Asignación</button>
       </div>


     </div>
    </form>
   </div>
     </div>
</div>
    <div id="paginacion" class="box jplist">

            <!-- ios button: show/hide panel -->
            <div class="jplist-ios-button">
              <i class="fa fa-sort"></i>
              Opciones
            </div>

            <!-- panel -->
            <div class="jplist-panel box panel-top">

              <div
                 class="jplist-drop-down"
                 data-control-type="items-per-page-drop-down"
                 data-control-name="paging"
                 data-control-action="paging">

                 <ul>

                  <li><span data-number="8" data-default="true"> 8 por pagina </span></li>
                  <li><span data-number="16" > 16 por pagina </span></li>

                 </ul>
              </div>

              <div
                 class="jplist-label"
                 data-type="Página {current} de {pages}"
                 data-control-type="pagination-info"
                 data-control-name="paging"
                 data-control-action="paging">
              </div>

              <div
                 class="jplist-pagination"
                 data-control-type="pagination"
                 data-control-name="paging"
                 data-control-action="paging">
              </div>

            </div>

            <!-- data -->
            <div class="list  text-shadow">


                    <div class="despacho list List-item ">
                          <div class="cabeza">
                            <label>CAC 735</label>
                          </div>
                          <div class="cuerpo">
                            <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                          </div>
                          <div class="pies">
                        <div class="alinear">
                          <div class="izquierda" >T.A.B</div>
                          <div class="derecha">



                                      <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>                                      <label for="1" class="rdo-redondo"></label>



                          </div>

                        </div>

                          </div>

                        </div>
                        <div class="despacho list List-item ">
                              <div class="cabeza">
                                <label>CAC 735</label>
                              </div>
                              <div class="cuerpo">
                                <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                              </div>
                              <div class="pies">
                            <div class="alinear">
                              <div class="izquierda" >T.A.B</div>
                              <div class="derecha">



                                          <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>


                              </div>

                            </div>

                              </div>

                            </div>
                            <div class="despacho list List-item ">
                                  <div class="cabeza">
                                    <label>CAC 735</label>
                                  </div>
                                  <div class="cuerpo">
                                    <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                  </div>
                                  <div class="pies">
                                <div class="alinear">
                                  <div class="izquierda" >T.A.B</div>
                                  <div class="derecha">
                                  <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                  </div>

                                </div>

                                  </div>

                                </div>
                                <div class="despacho list List-item ">
                                      <div class="cabeza">
                                        <label>CAC 735</label>
                                      </div>
                                      <div class="cuerpo">
                                        <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                      </div>
                                      <div class="pies">
                                    <div class="alinear">
                                      <div class="izquierda" >T.A.B</div>
                                      <div class="derecha">
                                        <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                      </div>

                                    </div>

                                      </div>

                                    </div>
                                    <div class="despacho list List-item ">
                                          <div class="cabeza">
                                            <label>CAC 735</label>
                                          </div>
                                          <div class="cuerpo">
                                            <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                          </div>
                                          <div class="pies">
                                        <div class="alinear">
                                          <div class="izquierda" >T.A.B</div>
                                          <div class="derecha">
                                            <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                          </div>

                                        </div>

                                          </div>

                                        </div>
                                        <div class="despacho list List-item ">
                                              <div class="cabeza">
                                                <label>CAC 735</label>
                                              </div>
                                              <div class="cuerpo">
                                                <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                              </div>
                                              <div class="pies">
                                            <div class="alinear">
                                              <div class="izquierda" >T.A.B</div>
                                              <div class="derecha">
                                            <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                              </div>

                                            </div>

                                              </div>

                                            </div>
                                            <div class="despacho list List-item ">
                                                  <div class="cabeza">
                                                    <label>CAC 735</label>
                                                  </div>
                                                  <div class="cuerpo">
                                                    <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                  </div>
                                                  <div class="pies">
                                                <div class="alinear">
                                                  <div class="izquierda" >T.A.B</div>
                                                  <div class="derecha">
                                                    <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                  </div>

                                                </div>

                                                  </div>

                                                </div>
                                                <div class="despacho list List-item ">
                                                      <div class="cabeza">
                                                        <label>CAC 735</label>
                                                      </div>
                                                      <div class="cuerpo">
                                                        <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                      </div>
                                                      <div class="pies">
                                                    <div class="alinear">
                                                      <div class="izquierda" >T.A.B</div>
                                                      <div class="derecha">
                                                      <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                      </div>

                                                    </div>

                                                      </div>

                                                    </div>
                                                    <div class="despacho list List-item ">
                                                          <div class="cabeza">
                                                            <label>CAC 735</label>
                                                          </div>
                                                          <div class="cuerpo">
                                                            <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                          </div>
                                                          <div class="pies">
                                                        <div class="alinear">
                                                          <div class="izquierda" >T.A.B</div>
                                                          <div class="derecha">
                                                            <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                          </div>

                                                        </div>

                                                          </div>

                                                        </div>
                                                        <div class="despacho list List-item ">
                                                              <div class="cabeza">
                                                                <label>CAC 735</label>
                                                              </div>
                                                              <div class="cuerpo">
                                                                <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                              </div>
                                                              <div class="pies">
                                                            <div class="alinear">
                                                              <div class="izquierda" >T.A.B</div>
                                                              <div class="derecha">
                                                                <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                              </div>

                                                            </div>

                                                              </div>

                                                            </div>
                                                            <div class="despacho list List-item ">
                                                                  <div class="cabeza">
                                                                    <label>CAC 735</label>
                                                                  </div>
                                                                  <div class="cuerpo">
                                                                    <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                                  </div>
                                                                  <div class="pies">
                                                                <div class="alinear">
                                                                  <div class="izquierda" >T.A.B</div>
                                                                  <div class="derecha">
                                                                  <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                                  </div>

                                                                </div>

                                                                  </div>

                                                                </div>
                                                                <div class="despacho list List-item ">
                                                                      <div class="cabeza">
                                                                        <label>CAC 735</label>
                                                                      </div>
                                                                      <div class="cuerpo">
                                                                        <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                                      </div>
                                                                      <div class="pies">
                                                                    <div class="alinear">
                                                                      <div class="izquierda" >T.A.B</div>
                                                                      <div class="derecha">
                                                                        <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                                      </div>

                                                                    </div>

                                                                      </div>

                                                                    </div>
                                                                    <div class="despacho list List-item ">
                                                                          <div class="cabeza">
                                                                            <label>CAC 735</label>
                                                                          </div>
                                                                          <div class="cuerpo">
                                                                            <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                                          </div>
                                                                          <div class="pies">
                                                                        <div class="alinear">
                                                                          <div class="izquierda" >T.A.B</div>
                                                                          <div class="derecha">
                                                                          <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                                          </div>

                                                                        </div>

                                                                          </div>

                                                                        </div>
                                                                        <div class="despacho list List-item ">
                                                                              <div class="cabeza">
                                                                                <label>CAC 735</label>
                                                                              </div>
                                                                              <div class="cuerpo">
                                                                                <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                                              </div>
                                                                              <div class="pies">
                                                                            <div class="alinear">
                                                                              <div class="izquierda" >T.A.B</div>
                                                                              <div class="derecha">
                                                                                <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                                              </div>

                                                                            </div>

                                                                              </div>

                                                                            </div>
                                                                            <div class="despacho list List-item ">
                                                                                  <div class="cabeza">
                                                                                    <label>CAC 735</label>
                                                                                  </div>
                                                                                  <div class="cuerpo">
                                                                                    <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                                                  </div>
                                                                                  <div class="pies">
                                                                                <div class="alinear">
                                                                                  <div class="izquierda" >T.A.B</div>
                                                                                  <div class="derecha">
                                                                                    <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                                                  </div>

                                                                                </div>

                                                                                  </div>

                                                                                </div>
                                                                                <div class="despacho list List-item ">
                                                                                      <div class="cabeza">
                                                                                        <label>CAC 735</label>
                                                                                      </div>
                                                                                      <div class="cuerpo">
                                                                                        <img src="<?=URL?>Public/Img/Despachador/ambulance.png" class="cont">
                                                                                      </div>
                                                                                      <div class="pies">
                                                                                    <div class="alinear">
                                                                                      <div class="izquierda" >T.A.B</div>
                                                                                      <div class="derecha">
                                                                                        <button class="btn btn-modificar"  onclick="AbrirModal('m2')">Editar</button>
                                                                                      </div>

                                                                                    </div>

                                                                                      </div>

                                                                                    </div>



            </div>






          </div>

  </div>
</div>
</div>
