 <a href="<?=URL?>Programacion/ctrlConsultarUsuarios" title="Volver" class="flecha-izq">
  <li class="fa fa-long-arrow-left"></li>
</a>
 <h1 class="titulo_vista"><span class="fa fa-folder-open"></span> Informacion Completa </h1>
<div class="fila">
<div class="columna-4"></div>
<div class="columna-8">
<div class="row-2" >
<div class="panel">
<div class="panel-cabecera"><h3><strong>Citas Programadas</strong></h3></div>
<div class="panel-contenido" width="100%"  >   
    
<ul class="list_panel relative_element n_flex n_justify_start block">
<?php
foreach ($consultorio as $query) {
 echo ' 
 <div class="columna-3">
<li class="list_item n_dont_grow">
<div class="list_item_header n_flex n_nowrap ">
<div class="item_icon n_flex n_align_center">
<span class="fa fa-gitlab"></span></div>
<div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
<h5 class="text_bold suspensive">Especialista '.$query->medico.''.$query->medicoape.'</h5>
</div>
</div>
<div class="columna-3">
<div class="list_item_content suspensive_12">
<p class="paragraph">
<span class="text_bold">Datos paciente </span><br>
<div class="list_item_content suspensive_4">
<p>
'.$query->paciente.'
</p>
</div>
<div class="list_item_content suspensive_4" ><p>
'.$query->primerApellido.'<br></p></div>
<div class=" list_item_content suspensive_4" ><p>
Documento '.$query->numeroDocumento.'<br></p></div>
<div class="list_item_content suspensive_4" ><p>
Fecha '.$query->fecha.'<br><p/></div>
<div class="list_item_content suspensive_4"><p>
hora de inicio '.$query->horaInicial.' &nbsp; hora final '.$query->horaFinal.'<br></p></div>
<div class=" list_item_content suspensive_4 "><p>
Direccion cita '.$query->direccionCita.'<br></p></div>
<div class="list_item_content suspensive_4"><p>
Cup '.$query->nombreCUP.'</p> </div>
</p>
</div>
</div>
</li>
</div>
  ';
}
 ?>
</ul>
</div>
</div>
</div>
</div>
<div class="columna-4"></div>
</div>            