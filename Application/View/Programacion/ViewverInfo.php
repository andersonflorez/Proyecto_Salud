<a href="<?=URL?>Programacion/ctrlConsultarUsuarios" title="Volver" class="flecha-izq">
<li class="fa fa-long-arrow-left"></li>
</a>



<h1 class="titulo_vista"><span class="fa fa-folder-open"></span> Información Completa </h1>

<div class="n_flex n_justify_center">
<div class="n_flex n_flex_col95 sm_flex_col90">
<div class="n_flex n_flex_col100 n_justify_around">
<div class="n_flex n_flex_col100 horizontal_padding">
<div class="panel block">
<div class="panel-contenido" style="overflow-x: auto;">
        <div class="panel-cabecera"><h3><strong>Consultar Personal</strong></h3></div>
        <div class="panel-contenido">
<div class="fila">
<label class="columna-1">Primer Nombre:</label>
<input type="text" class="columna-2" id="Primero"  value="<?php  echo $INFO->primerNombre ?>" readonly>
<div class="columna-1"></div>
<label class="columna-1">Segundo Nombre:</label>
<input type="text" class="columna-2" id="Segundo" value="<?php echo $INFO->segundoNombre?>" readonly>
</div><br>
<div class="fila">
<label class="columna-1"> Primer Apellido:</label>
<input type="text"  class="columna-2" id="tercero" value="<?php echo $INFO->primerApellido?>" readonly>
<div class="columna-1"></div>
<label class="columna-1">Segundo Apellido:</label>
<input type="text"  class="columna-2" id="cuarto" value="<?php echo $INFO->segundoApellido?>" readonly>
</div><br>
<div class="fila">
<label class="columna-1">Telefono:</label>
<input type="text"  class="columna-2" id="quinto" value="<?php echo $INFO->telefono?>" readonly>
<div class="columna-1"></div>
<label  class="columna-1">Dirección:</label>
<input type="text" class="columna-2" id="sexto" value="<?php echo $INFO->direccion?>" readonly>
</div><br>
<div class="fila">
<label  class="columna-1">Numero de documento:</label>
<input type="text"  class="columna-2" id="septimo" value="<?php echo $INFO->numeroDocumento?>" readonly>
<div class="columna-1"></div>
<label  class="columna-1">Sexo:</label>
<input type="text" class="columna-2" id="octavo" value="<?php echo $INFO->sexo?>" readonly>
</div><br>
<div class="fila">
<label class="columna-1"> Lugar de nacimiento:</label>
<input type="text"  class="columna-2" id="noveno" value="<?php echo $INFO->lugarNacimiento?>" readonly>
<div class="columna-1"></div>
<label  class="columna-1">Fecha de nacimiento:</label>
<input type="text"  class="columna-2" id="decimo"  value="<?php echo $INFO->fechaNacimiento?>" readonly>
</div><br>
<div class="fila">
<label class="columna-1"> Ciudad:</label>
<input type="text"  class="columna-2"  id="once" value="<?php echo $INFO->ciudad?>" readonly>
<div class="columna-1"></div>
<label  class="columna-1">Departamento:</label>
<input type="text"  class="columna-2" id="doce" value="<?php echo $INFO->departamento?>" readonly>
</div><br>
<div class="fila">
<label  class="columna-1">Correo:</label>
<input type="text"  class="columna-2" id="trece" value="<?php echo $INFO->correoElectronico?>" readonly>
<div class="columna-1"></div>
<label  class="columna-1">Estado persona:</label>
<input type="text" class="columna-2" id="catorce" value="<?php echo $INFO->estadotablaPersona?>" readonly>
</div><br>
<div class="fila">
<label  class="columna-1">Pais:</label>
<input type="text"  class="columna-2" id="quince" value="<?php echo $INFO->pais?>"  readonly>
<div class="columna-1"></div>
<label  class="columna-1">grupo Sanguineo:</label>
<input type="text" class="columna-2" id="dieciseis" value="<?php echo $INFO->grupoSanguineo?>" readonly>
</div><br>
<div class="fila">
<label class="columna-1">Dependencia:</label>
<input type="text"  class="columna-2"  id="diecisiete" value="<?php echo $INFO->dependencia?>" readonly>
<div class="columna-1" ></div>
<label class="columna-1">Rol:</label>
<input type="text"  class="columna-2"  id="dieciosho" value="<?php echo $INFO->descripcionRol?>" readonly>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
