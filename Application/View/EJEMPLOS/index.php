<!-- FLECHA DERECHA -->
<a href="<?=URL?>Modulo/Controlador" title="Siguiente" class="flecha-der">
  <li class="fa fa-long-arrow-right"></li>
</a>


<!-- FLECHA IZQUIERDA -->
<a href="<?=URL?>Modulo/Controlador" title="Volver" class="flecha-izq">
  <li class="fa fa-long-arrow-left"></li>
</a>


<!-- CONTENIDO -->
<div class="n_flex n_justify_center">

  <!-- CONTENIDO VISTA -->
  <div class="n_flex n_flex_col95 sm_flex_col90">

    <!-- TITULO VISTA -->
    <div class="n_flex n_flex_col100">
      <h1 class="titulo_vista">Ejemplos de implementación del estándar de diseño</h1>
    </div>

    <div class="n_flex n_flex_col100 n_justify_around">

      <!-- CONTENEDOR PRINCIPAL IZQUIERDO -->
      <div class="n_flex n_flex_col100 lg_flex_col50 horizontal_padding n_in_columns">

        <!-- GRID -->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Nuevas funcionalidades de la Grid basada en Flexbox</h3>
          </div>
          <div class="panel-contenido">
            <article class="block">
              <p>
                Se han incorporado nuevas funcionalidades a la grid del proyecto para hacer las cosas más simples a la hora de maquetar.
              </p>
            </article>
            <article class="block">
              <h6 class="block text_bold">Nuevos breakpoints (puntos de interrupción):</h6>
              <p class="block">
                Los breakpoints son medidas específicas que definen una resolución de pantalla específica.
                En la nueva actualización de la grid disponemos de los siguientes breakpoints:
              </p>

              <div class="code block vertical_padding horizontal_padding">
                <code>
<pre>
// SASS (Código .SCSS):
$specific_breakpoints: {
  n:  0,
  xs: 20em,
  sm: 34.375em,
  md: 48em,
  lg: 64em,
  xl: 78.5em,
  xxl: 100em
}
</pre>
                </code>
              </div>

              <p class="block">
                Cada uno de los breakpoints anteriores corresponde a una medida específica definida en 'em', que corresponde a su vez al tamaño de la letra 'M' mayúscula del documento HTML con su <samp>font-size</samp> predeterminado, esta medida por defecto equivale a 16px. <br><br>
                Si quieres saber cual es la medida específica en <samp>px</samp> de un breakpoint simplemente multiplícalo por esta medida. <br><br>
                <span class="text_bold">Por ejemplo</span>, el breakpoint <samp>xs</samp> que significa 'extra small' o 'extra pequeño' corresponde a 320px porque es el resultado de multiplicar 16px * 20em, donde 320px corresponde a la medida mínima de la resolución de pantalla de un smartphone hoy en día, por lo tanto podemos decir que entre <samp>xs</samp> y <samp>sm</samp> se encuentra la resolución 'móvil'. <br><br>
                Este breakpoint se lee de la siguiente manera: 'A partir de 320px en adelante, aplica los siguientes estilos...' o también 'A partir de la resolución móvil en adelante, aplica los siguientes estilos...'.
              </p>

              <h6 class="block text_bold">Las nuevas características de la Grid:</h6>
              <p class="block">
                Si has entendido bien lo mencionado anteriormente podrás entender fácilmente lo que se explicará a continuación:
                <br>
                La grid está basada en flexbox, por lo tanto, si necesitas hacer una columna responsive con una medida fija debes aplicarle la propriedad <samp>display: flex;</samp> al elemento que lo contiene, esta propiedad viene por defecto en las clases <samp>{breakpoint}_flex</samp>, donde {breakpoint} corresponde a cada uno de los identificadores de los breakpoints anteriores, es decir:
              </p>
              <div class="code block horizontal_padding vertical_padding">
                <code>
<pre>
  &lt;!-- Sé flexible a partir de la resolución 'n': --&gt;
  &lt;div class="n_flex"&gt;abc&lt;/div&gt;

  &lt;!-- Sé flexible a partir de la resolución 'xs': --&gt;
  &lt;div class="xs_flex"&gt;abc&lt;/div&gt;

  &lt;!-- Sé flexible a partir de la resolución 'sm': --&gt;
  &lt;div class="sm_flex"&gt;abc&lt;/div&gt;

  &lt;!-- Sé flexible a partir de la resolución 'md': --&gt;
  &lt;div class="md_flex"&gt;abc&lt;/div&gt;

  &lt;!-- Sé flexible a partir de la resolución 'lg': --&gt;
  &lt;div class="lg_flex"&gt;abc&lt;/div&gt;

  &lt;!-- Sé flexible a partir de la resolución 'xl': --&gt;
  &lt;div class="xl_flex"&gt;abc&lt;/div&gt;

  &lt;!-- Sé flexible a partir de la resolución 'xxl': --&gt;
  &lt;div class="xxl_flex"&gt;abc&lt;/div&gt;
</pre>
                </code>
              </div>

              <p class="block">
                Como ya te habrás dado cuenta, no es necesario especificar todos los breakpoints a un div para que sea siempre flexible, solo basta con especificar la clase <samp>'n_flex'</samp> y a partir de 0px en adelante será flexible.
              </p>
              <h6 class="text_bold block">Las columnas:</h6>
              <p class="block">
                En esta versión de la grid los nombres de las clases de las columnas son diferentes con el fin de marcar la diferencia entre lo viejo y lo nuevo. <br>
                El rango de separación de las columnas se encuentra dividido de 5 a 100, por lo tanto será más facil adaptar los contenidos porque la división puede ser más específica. Los números indican un porcentaje espécifico del contenedor del elemento y van de 5 en 5 hasta llegar a 100.
              </p>
              <p class="block">
                Para especificar una columna se usa la siguiente clase: <samp>{breakpoint}_flex_col{numero}</samp>
              </p>
              <h6 class="block text_bold">Ejemplo de columnas responsive:</h6>
              <div class="code block horizontal_padding vertical_padding">
                <code>
              <pre>
&lt;!-- Contenedor flexible obligatorio: --&gt;
&lt;div class="n_flex"&gt;
  &lt;!-- Columna del 50% del tamaño del contenedor: --&gt;
  &lt;div class="n_flex_col50"&gt;...&lt;/div&gt;

  &lt;!-- Columna del 50% del tamaño del contenedor: --&gt;
  &lt;div class="n_flex_col50"&gt;...&lt;/div&gt;
&lt;/div&gt;
              </pre>
                </code>
              </div>
              <p class="block">
                Bien, en el ejemplo anterior estamos separando el contenido en dos columnas que ocupan la mitad del tamaño de su contenedor, sin embargo, esta división se va a conservar siempre debido a que hemos especificado el breakpoint <samp>'n'</samp> (0px). Entonces, ¿qué deberíamos hacer para que las columnas se repartan el espacio disponible en un 50% para cada una pero solo desde la resolución 'tablet'?, ¿que tal si quisieramos que a partir de la resolución 'tablet' hacia abajo cada columna ocupase el 100% del contenedor?.
              </p>
              <p class="block">
                Fácil, para ello usemos como ejemplo esta misma página, la cual tiene dos columnas al 50% a partir de <samp>'md'</samp> (tablet), y el 100% a partir de <samp>'n'</samp> (0px).
              </p>

              <div class="code block horizontal_padding vertical_padding">
                <code>
<pre>
&lt;!-- Contenedor flexible obligatorio: --&gt;
&lt;div class="n_flex"&gt;
  &lt;!-- 100% a partir de 0px, 50% a partir de tablet: --&gt;
  &lt;div class="n_flex_col100 md_flex_col50"&gt;...&lt;/div&gt;

  &lt;!-- 100% a partir de 0px, 50% a partir de tablet: --&gt;
  &lt;div class="n_flex_col100 md_flex_col50"&gt;...&lt;/div&gt;
&lt;/div&gt;
</pre>
                </code>
              </div>
              <p class="block">
                Podemos hacer mil y un ejemplos más como este para ilustrar el potencial de la grid, pero en realidad la implementación de ella depende de la necesidad de cada quién, solo es cuestión de práctica y creatividad para saber hacer las cosas. Si lograron entender los conceptos anteriores no tendrán ningún problema en adaptar sus contenidos.
              </p>

            </article>
          </div>
        </div>
        <!-- FIN GRID -->

        <!-- BOTONES -->
        <div class="panel block">

          <div class="panel-cabecera">
            <h3>Nuevo estilo de botones</h3>
          </div>

          <div class="panel-contenido">
            <article class="block">
              <p>
                Los botones siguen con su estructura básica anterior, el único cambio realizado ha sido el background completo.
              </p>
            </article>
            <h6 class="block text_bold">Botón Consultar</h6>
            <button class="btn btn-consultar block">Consultar</button>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;button class="btn btn-consultar"&gt;Consultar&lt;/button&gt;
</pre>
              </code>
            </div>
            <h6 class="block text_bold">Botón Registrar</h6>
            <button class="btn btn-registrar block">Registrar</button>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;button class="btn btn-registrar"&gt;Registrar&lt;/button&gt;
</pre>
              </code>
            </div>
            <h6 class="block text_bold">Botón Eliminar</h6>
            <button class="btn btn-eliminar block">Eliminar</button>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;button class="btn btn-eliminar"&gt;Eliminar&lt;/button&gt;
</pre>
              </code>
            </div>
            <h6 class="block text_bold">Botón Modificar</h6>
            <button class="btn btn-modificar block">Modificar</button>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;button class="btn btn-modificar"&gt;Modificar&lt;/button&gt;
</pre>
              </code>
            </div>
            <h6 class="block text_bold">Botón Cancelar</h6>
            <button class="btn btn-cancelar block">Cancelar</button>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;button class="btn btn-cancelar"&gt;Cancelar&lt;/button&gt;
</pre>
              </code>
            </div>
          </div>
        </div>
        <!-- FIN BOTONES -->


        <!-- NOTIFICACIONES -->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Notificaciones</h3>
          </div>
          <div class="panel-contenido">
            <article class="block">
              <p class="block">
                Las notificaciones se ejecutan desde javascript, llamando la función <samp>'Notificate'</samp> que recibe como parámetro un objeto con la configuración de la notificación.
              </p>
              <p>
                Existen 4 tipos de notificaciones en el estándar:
              </p>
            </article>
            <div class="block">
              <h6 class="text_bold">Notificación de éxito</h6>
              <div class="vertical_padding">
                <div class="code block vertical_padding horizontal_padding">
                  <code>
                    // Javascript (onclick): <br>
                    Notificate({<br>
                      &nbsp;&nbsp;tipo: 'success',<br>
                      &nbsp;&nbsp;titulo: 'Notificación de éxito',<br>
                      &nbsp;&nbsp;descripcion: 'Esta es una prueba de notificación de éxito.'<br>
                    });<br>
                  </code>
                </div>
                <button class="btn btn-consultar ejemplo_notificacion" target="success">probar</button>
              </div>
            </div>
            <div class="block">
              <h6 class="text_bold">Notificación de información</h6>
              <div class="vertical_padding">
                <div class="code block vertical_padding horizontal_padding">
                  <code>
                    // Javascript (onclick): <br>
                    Notificate({<br>
                      &nbsp;&nbsp;tipo: 'info',<br>
                      &nbsp;&nbsp;titulo: 'Notificación de información',<br>
                      &nbsp;&nbsp;descripcion: 'Esta es una prueba de notificación de información.'<br>
                    });<br>
                  </code>
                </div>
                <button class="btn btn-consultar ejemplo_notificacion" target="info">probar</button>
              </div>
            </div>
            <div class="block">
              <h6 class="text_bold">Notificación de advertencia</h6>
              <div class="vertical_padding">
                <div class="code block vertical_padding horizontal_padding">
                  <code>
                    // Javascript (onclick): <br>
                    Notificate({<br>
                      &nbsp;&nbsp;tipo: 'warning',<br>
                      &nbsp;&nbsp;titulo: 'Notificación de advertencia',<br>
                      &nbsp;&nbsp;descripcion: 'Esta es una prueba de notificación de advertencia.'<br>
                    });<br>
                  </code>
                </div>
                <button class="btn btn-consultar ejemplo_notificacion" target="warning">probar</button>
              </div>
            </div>
            <div>
              <h6 class="text_bold">Notificación de error</h6>
              <div class="vertical_padding">
                <div class="code block vertical_padding horizontal_padding">
                  <code>
                    // Javascript (onclick): <br>
                    Notificate({<br>
                      &nbsp;&nbsp;tipo: 'error',<br>
                      &nbsp;&nbsp;titulo: 'Notificación de error',<br>
                      &nbsp;&nbsp;descripcion: 'Esta es una prueba de notificación de error.'<br>
                    });<br>
                  </code>
                </div>
                <button class="btn btn-consultar ejemplo_notificacion" target="error">probar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- FIN NOTIFICACIONES -->

        <!-- DIALOGOS MODALES -->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Ventanas modales</h3>
          </div>
          <div class="panel-contenido">

            <article class="block">
              <p class="block">
                Las ventanas modales son otra forma de mostrar información al usuario, sin embargo no es bueno abusar de ellas. <br>
                <span class="text_bold">Nota: </span>Si tienes suficiente espacio en tu página para mostrar el contenido, no es necesario que uses una ventana modal.
              </p>
              <p>
                Aqui tenemos algunos ejemplos:
              </p>
            </article>
            <h6 class="block">Ventana modal con formulario:</h6>
            <div class="block">
              <button type="button" class="btn btn-consultar btn-modal" target="modal2">abrir</button>
            </div>

            <h6 class="block">Ventana modal con párrafos de información</h6>
            <div class="block">
              <button type="button" class="btn btn-consultar btn-modal" target="modal1">abrir</button>
            </div>

            <div class="modal-ventana whole_wrapper" id="modal1">
              <div class="modal relative_element">
                <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                  <h2>Ejemplo modal con información</h2>
                  <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                </div>
                <div class="modal-body">
                  <div class="panel block">
                    <div class="panel-contenido">
                      <article class="block">
                        <h6 class="text_bold block">Subtitulo</h6>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint aliquid eveniet necessitatibus, incidunt repellendus sequi esse modi ullam dolorum vitae eum? Quisquam iusto, possimus veniam laborum sed. Aliquam, iusto, tempore!
                        </p>
                    </div>
                  </div>

                  <div class="panel block">
                    <div class="panel-contenido">
                      <article class="block">
                        <h6 class="text_bold block">Subtitulo</h6>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint aliquid eveniet necessitatibus, incidunt repellendus sequi esse modi ullam dolorum vitae eum? Quisquam iusto, possimus veniam laborum sed. Aliquam, iusto, tempore!
                        </p>
                        </article>
                    </div>
                  </div>

                  <div class="panel block">
                    <div class="panel-contenido">
                      <article class="block">
                        <h6 class="text_bold block">Subtitulo</h6>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint aliquid eveniet necessitatibus, incidunt repellendus sequi esse modi ullam dolorum vitae eum? Quisquam iusto, possimus veniam laborum sed. Aliquam, iusto, tempore!
                        </p>
                        </article>
                    </div>
                  </div>
                </div>
                <div class="modal-footer n_flex n_justify_end">
                  <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Salir</button>
                </div>
              </div>
            </div>

            <div class="modal-ventana whole_wrapper" id="modal2">
              <div class="modal relative_element">
                <div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between">
                  <h2>Ejemplo modal con formulario</h2>
                  <span class="btn-cerrar-modal modal-cerrar fa fa-times"></span>
                </div>
                <form id="frmEjemploModal">
                <div class="modal-body">
                  <div class="panel block">
                    <div class="panel-contenido">
                      <!-- Inicio input -->
                      <div class="frmCont">
                        <label for="txtCaracteres">Caracteres latinos:</label>
                        <div class="frmInput">
                          <input class="input_data" type="text" name="txtCaracteres" data-rule-required="true" data-rule-RE_LatinCharacters="true">
                        </div>
                      </div>
                      <!-- fin input -->

                      <!-- Inicio input -->
                      <div class="frmCont">
                        <label for="txtEmail">Email:</label>
                        <div class="frmInput">
                          <input class="input_data" type="email" name="txtEmail" data-rule-required="true" data-rule-RE_Email="true">
                        </div>
                      </div>
                      <!-- fin input -->

                      <!-- Inicio input -->
                      <div class="frmCont">
                        <label for="txtNumero">Número:</label>
                        <div class="frmInput">
                          <input class="input_data" type="text" name="txtNumero" data-rule-required="true" data-rule-RE_Numbers="true">
                        </div>
                      </div>
                      <!-- fin input -->

                      <!-- Inicio select -->
                      <div class="frmCont">
                        <label for="txtSelect">Seleccione</label>
                        <div class="frmInput">
                          <select class="input_data" name="txtSelect" data-rule-RE_Select="0">
                            <option value="0">Seleccione una opción</option>
                            <option value="1">Opción 1</option>
                            <option value="2">Opción 2</option>
                            <option value="3">Opción 3</option>
                          </select>

                        </div>
                      </div>
                      <!-- fin select -->

                      <!-- Inicio textarea -->
                      <div class="frmCont">
                        <label for="txtTextArea">Descripción</label>
                        <div class="frmInput">
                          <textarea name="txtTextArea" rows="8" cols="40" data-rule-required="true"></textarea>
                        </div>
                      </div>
                      <!-- fin textarea -->
                      </div>
                  </div>
                </div>
                <div class="modal-footer n_flex n_justify_end">
                  <button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button">Cancelar</button>
                  <button type="submit" class="btn btn-registrar" name="button">enviar</button>
                </div>
                </form>
              </div>
            </div>

            <article class="block">
              <p>
                Para hacer una modal como las anteriores se requiere tener un elemento con clase <samp>'btn-modal'</samp>, esta clase permite abrir la modal especificando su <samp>'id'</samp> en el atributo <samp>'target'</samp>.
              </p>
            </article>
            <h6 class="block text_bold">Por ejemplo, un botón:</h6>

            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;!-- 'target' contiene el id de la modal a abrir --&gt;
&lt;button class="btn-modal btn btn-consultar" target="modal1" type="button"&gt;abrir&lt;/button&gt;
</pre>
              </code>
            </div>
            <article class="block">
              <p>
                En cuanto a la modal solo debemos asegurarnos de que el atributo <samp>'id'</samp> sea igual al que especificamos en el atributo <samp>'target'</samp> del botón anterior.
              </p>
            </article>
            <h6 class="block text_bold">Una estructura de ventana modal válida sería la siguiente:</h6>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;!-- 'id' debe ser igual a 'target' --&gt;
&lt;div class="modal-ventana whole_wrapper" id="modal1"&gt;
  &lt;div class="modal relative_element"&gt;

    &lt;div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between"&gt;
      &lt;!-- Titulo de la ventana modal --&gt;
      &lt;h2&gt;Ejemplo modal con información&lt;/h2&gt;
      &lt;span class="btn-cerrar-modal modal-cerrar fa fa-times"&gt;&lt;/span&gt;
    &lt;/div&gt;

    &lt;div class="modal-body"&gt;
      &lt;!-- Contenido de la ventana modal --&gt;
      &lt;div class="panel block"&gt;
        &lt;div class="panel-contenido"&gt;
          &lt;article class="block"&gt;
            &lt;h6 class="text_bold block"&gt;Subtitulo&lt;/h6&gt;
            &lt;p&gt;
              Algo interesante iría aquí...
            &lt;/p&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="modal-footer n_flex n_justify_end"&gt;
      &lt;button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button"&gt;Salir&lt;/button&gt;
    &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;

</pre>
              </code>
            </div>
            <h6 class="block text_bold">Esta sería la estructura de una ventana modal con formulario:</h6>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;div class="modal-ventana whole_wrapper" id="modal2"&gt;
  &lt;div class="modal relative_element"&gt;

    &lt;div class="modal-header n_flex vertical_padding horizontal_padding n_justify_between"&gt;
      &lt;h2&gt;Ejemplo modal con formulario&lt;/h2&gt;
      &lt;span class="btn-cerrar-modal modal-cerrar fa fa-times"&gt;&lt;/span&gt;
    &lt;/div&gt;

    &lt;form id="frmEjemploModal"&gt;

      &lt;div class="modal-body"&gt;
        &lt;div class="panel block"&gt;
          &lt;div class="panel-contenido"&gt;

            &lt;div class="frmCont"&gt;
              &lt;label for="txtCaracteres"&gt;Campo:&lt;/label&gt;
              &lt;div class="frmInput"&gt;
                &lt;input class="input_data" type="text" name="txtCaracteres" data-rule-required="true" data-rule-RE_LatinCharacters="true"&gt;
              &lt;/div&gt;
            &lt;/div&gt;

            &lt;div class="frmCont"&gt;
              &lt;label for="txtEmail"&gt;Campo:&lt;/label&gt;
              &lt;div class="frmInput"&gt;
                &lt;input class="input_data" type="email" name="txtEmail" data-rule-required="true" data-rule-RE_Email="true"&gt;
              &lt;/div&gt;
            &lt;/div&gt;

            &lt;div class="frmCont"&gt;
              &lt;label for="txtNumero"&gt;Campo:&lt;/label&gt;
              &lt;div class="frmInput"&gt;
                &lt;input class="input_data" type="text" name="txtNumero" data-rule-required="true" data-rule-RE_Numbers="true"&gt;
              &lt;/div&gt;
            &lt;/div&gt;

          &lt;/div&gt;
        &lt;/div&gt;
      &lt;/div&gt;

      &lt;div class="modal-footer n_flex n_justify_end"&gt;
        &lt;button type="button" class="btn-cerrar-modal btn btn-cancelar"  name="button"&gt;Cancelar&lt;/button&gt;
        &lt;button type="submit" class="btn btn-registrar" name="button"&gt;enviar&lt;/button&gt;
      &lt;/div&gt;
    &lt;/form&gt;
  &lt;/div&gt;
&lt;/div&gt;

</pre>
              </code>
            </div>
          </div>
        </div>
        <!-- FIN DIALOGOS MODALES -->

        <!-- TABLAS -->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Estilos de tablas</h3>
          </div>
          <div class="panel-contenido">

            <div class="n_flex">

              <div class="n_flex_col100 block">
                <h5 class="text_bold block"><ins>Tabla responsive</ins> (Transformación de estructura):</h5>

                <div class="n_flex_col100 block">
                  <p class="block">
                    Esta tabla es muy util ya que te permite adaptar completamente el contenido a voluntad, simplemente tienes que seguir los siguientes pasos:
                  </p>

                  <!-- Tabla responsive (Transformación de estructura): -->
                   <div class="n_flex_col100" id="tbl_ejemplo">

                    <table class="tbl_responsive" >
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Apellidos</th>
                          <th>Cargo</th>
                          <th>Twitter</th>
                          <th>ID</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Mart&iacute;n</td>
                          <td>Iglesias Lenci</td>
                          <td>Desarrollador</td>
                          <td>@martinigleu</td>
                          <td>1</td>
                        </tr>
                        <tr>
                          <td>Mart&iacute;n</td>
                          <td>Iglesias Lenci</td>
                          <td>Desarrollador</td>
                          <td>@martinigleu</td>
                          <td>2</td>
                        </tr>
                        <tr>
                          <td>Mart&iacute;n</td>
                          <td>Iglesias Lenci</td>
                          <td>Desarrollador</td>
                          <td>@martinigleu</td>
                          <td>3</td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                  <!-- Fin Tabla responsive (Transformación de estructura): -->


                  <ul>
                    <li class="block">
                      <h6><strong>1.</strong> Copia y pega la estructura de este ejemplo.</h6><br>


                      <div class="n_flex_col100">
                        <div class="code block vertical_padding horizontal_padding">
                          <code>
                            <pre>
&lt;!-- Tabla responsive (Transformación estructura): --&gt;
  &lt;div class="n_flex_col10id="tbl_ejemplo"&gt;

  &lt;table class="tbl_responsive" &gt;
    &lt;thead&gt;
      &lt;tr&gt;
        &lt;th&gt;Nombre&lt;/th&gt;
        &lt;th&gt;Apellidos&lt;/th&gt;
        &lt;th&gt;Cargo&lt;/th&gt;
        &lt;th&gt;Twitter&lt;/th&gt;
        &lt;th&gt;ID&lt;/th&gt;
      &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
      &lt;tr&gt;
        &lt;td&gt;Mart&iacute;n&lt;/td&gt;
        &lt;td&gt;Iglesias Lenci&lt;/td&gt;
        &lt;td&gt;Desarrollador&lt;/td&gt;
        &lt;td&gt;@martinigleu&lt;/td&gt;
        &lt;td&gt;1&lt;/td&gt;
      &lt;/tr&gt;
      &lt;tr&gt;
        &lt;td&gt;Mart&iacute;n&lt;/td&gt;
        &lt;td&gt;Iglesias Lenci&lt;/td&gt;
        &lt;td&gt;Desarrollador&lt;/td&gt;
        &lt;td&gt;@martinigleu&lt;/td&gt;
        &lt;td&gt;2&lt;/td&gt;
      &lt;/tr&gt;
      &lt;tr&gt;
        &lt;td&gt;Mart&iacute;n&lt;/td&gt;
        &lt;td&gt;Iglesias Lenci&lt;/td&gt;
        &lt;td&gt;Desarrollador&lt;/td&gt;
        &lt;td&gt;@martinigleu&lt;/td&gt;
        &lt;td&gt;3&lt;/td&gt;
      &lt;/tr&gt;
    &lt;/tbody&gt;
  &lt;/table&gt;

&lt;/div&gt;

                            </pre>
                          </code>
                        </div>
                      </div>
                    </li>
                    <li class="block">
                      <article>
                        <strong>2.</strong>
                          La estructura de este ejemplo tiene el siguiente id="tbl_ejemplo" este es de suma importancia ya que con este podras manipular facilmente la adaptabilidad, cabe destacar que lo puedes cambiar por una clase, solo ten presente que no puedes aplicar el id o class a la table directamente sino a un padre el cual puede ser un div.
                      </article>
                    </li>
                    <li class="block">
                      <article>
                        <strong>3.</strong>
                        Hecho los pasos anteriores solo falta que agregues unos cuantos estilos, por favor es obligatorio que uses un archivo .scss ya que algunos elementos de la tabla se generan dinamicamente gracias a sass, debes copiar y pegar  el codigo de la siguiente ruta en el .scss que vas a crear o tienes creado, y personalizonalizarlo dependiendo de tus necesidades.
                      </article>
                      <br>
                       <a href="#" class="block">
                         Public\Scss\Modulos\EJEMPLOS\ejemplo.scss :
                       </a>

                       <div class="n_flex_col100">
                         <div class="code block vertical_padding horizontal_padding">
                           <code>
                             <pre>
// Importante incluir estos dos archivos
@import "../../base/_variables.scss";
@import "../../base/_funciones.scss";

/**
* Configuración de la tabla responsive #tbl_ejemplo
*/
#tbl_ejemplo{
  margin-bottom: 3em; // Esto no es necesario

  // Con _hasta(md), hasta(tablet) manipulas la resolución de donde quieres que se transforme la tabla solo debes especificar la medida.
  @include _hasta(md) {

    // Para poder lograr el cambio de estructura de la tabla fue necesario eliminar las etiquetas de las columnas y colocarlas manualmente con el pseudo elemento ::before asi que es importante que coloques los nombres de las columnas asi:
    @include nombreCampos(
    "Nombre",
    "Apellidos",
    "Cargo",
    "Twitter",
    "ID"
    );
  }
}

// Fin Configuración de la tabla responsive #tbl_ejemplo

                             </pre>
                           </code>
                         </div>
                       </div>
                    </li>
                  </ul>
                </div>
              </div>




              <div class="n_flex_col100 block">
                <h5 class="text_bold block"><ins>Tabla con div reponsive</ins>  (Scroll)</h5>

                <div class="n_flex_col100 block">
                  <p class="block">
                    Esta tabla no es tan compleja como la anterior, simplemente cuando el contenido no cabe sale un scroll, para implementarla solo copia la estructura.
                  </p>

                </div>
              </div>


              <!-- Tabla con div reponsive (Scroll) -->
              <div class="n_flex_col100 block">

                <div class="tbl_container">
                  <table class="tbl_scroll">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Cargo</th>
                        <th>Twitter</th>
                        <th>ID</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Mart&iacute;n</td>
                        <td>Iglesias Lenci</td>
                        <td>Desarrollador</td>
                        <td>@martinigleu</td>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td>Mart&iacute;n</td>
                        <td>Iglesias Lenci</td>
                        <td>Desarrollador</td>
                        <td>@martinigleu</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td>Mart&iacute;n</td>
                        <td>Iglesias Lenci</td>
                        <td>Desarrollador</td>
                        <td>@martinigleu</td>
                        <td>3</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </div>
              <!-- Fin Tabla con div reponsive (Scroll) -->

              <h5 class="text_bold block">Estructura:</h5>
              <div class="n_flex_col100">
                <div class="code block vertical_padding horizontal_padding">
                  <code>
                    <pre>
&lt;!-- Tabla con div reponsive (Scroll) --&gt;
&lt;div class="n_flex_col100"&gt;

  &lt;div class="tbl_container"&gt;
    &lt;table class="tbl_scroll"&gt;
      &lt;thead&gt;
        &lt;tr&gt;
          &lt;th&gt;Nombre&lt;/th&gt;
          &lt;th&gt;Apellidos&lt;/th&gt;
          &lt;th&gt;Cargo&lt;/th&gt;
          &lt;th&gt;Twitter&lt;/th&gt;
          &lt;th&gt;ID&lt;/th&gt;
        &lt;/tr&gt;
      &lt;/thead&gt;
      &lt;tbody&gt;
        &lt;tr&gt;
          &lt;td&gt;Mart&iacute;n&lt;/td&gt;
          &lt;td&gt;Iglesias Lenci&lt;/td&gt;
          &lt;td&gt;Desarrollador&lt;/td&gt;
          &lt;td&gt;@martinigleu&lt;/td&gt;
          &lt;td&gt;1&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
          &lt;td&gt;Mart&iacute;n&lt;/td&gt;
          &lt;td&gt;Iglesias Lenci&lt;/td&gt;
          &lt;td&gt;Desarrollador&lt;/td&gt;
          &lt;td&gt;@martinigleu&lt;/td&gt;
          &lt;td&gt;2&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
          &lt;td&gt;Mart&iacute;n&lt;/td&gt;
          &lt;td&gt;Iglesias Lenci&lt;/td&gt;
          &lt;td&gt;Desarrollador&lt;/td&gt;
          &lt;td&gt;@martinigleu&lt;/td&gt;
          &lt;td&gt;3&lt;/td&gt;
        &lt;/tr&gt;
      &lt;/tbody&gt;
    &lt;/table&gt;
  &lt;/div&gt;

&lt;/div&gt;
                    </pre>
                  </code>
                </div>
              </div>

            </div>

          </div>
        </div>
        <!-- FIN TABLAS -->

      </div>

      <!-- CONTENEDOR PRINCIPAL DERECHO -->
      <div class="n_flex n_flex_col100 lg_flex_col50 block horizontal_padding n_in_columns">

        <!-- VALIDACIONES-->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Validaciones con JQuery Validate</h3>
          </div>
          <div class="panel-contenido">
            <div class="block">
              <article class="block">
                <h6 class="block text_bold">Formularios:</h6>
                <p class="block">
                  Las validaciones a mostrar dependen directamente de la estructura del formulario. <br>
                </p>
                <h6 class="text_bold">Una estructura básica de formulario es la siguiente:</h6>
              </article>
              <div class="code block horizontal_padding vertical_padding">
                <code>
<pre>
&lt;form id="frm"&gt;
  &lt;div class="frmCont"&gt;
    &lt;label for="txtNombreCampo"&gt;Input básico:&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;input class="input_data" type="text" name="txtNombreCampo"&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/form&gt;
</pre>
                </code>
              </div>
              <article class="block">
                <p class="block">
                  Como se ilustra en el ejemplo anterior, todos los formularios deben tener un atributo <samp>'id'</samp> único el cual será posteriormente manipulado con javascript, además, todos los campos (inputs, selects, textareas, etc) deben estar contenidos dentro de un <samp>div</samp> con la clase <samp>'frmCont'</samp>.
                </p>
                <p class="block">
                  Es muy importante que los campos tengan la clase <samp>'input_data'</samp> que permite recolectar el valor del campo. También se debe especificar el nombre del campo con el atributo <samp>'name'</samp>.<br>
                </p>
                <h6 class="text_bold block">Validaciones:</h6>
                <p class="block">
                  Existen varios tipos de validaciones de campos, dichas validaciones reciben el nombre de <samp>'reglas'.</samp><br>
                  Una regla es un atributo del campo que permite validar algo en específico, por ejemplo, la regla más común se llama <samp>'required'</samp>, la cual valida que sea necesario llenar el campo para enviar el formulario.
                </p>
                <p class="block">
                  Para validar que un campo del formulario sea requerido, simplemente hay que agregarle un atributo adicional con el nombre de la validación, este atributo se denomina <samp>'data-rule'</samp>. Sin embargo <samp>'data-rule'</samp> por si solo no hace nada, debemos concatenarle el tipo de validacion que queremos hacer, en este caso la validacion <samp>'required'</samp> y asignarle el valor <samp>'true'</samp>, de la siguiente manera: <samp>data-rule-required="true"</samp>
                </p>
                <h6 class="text_bold block">Ejemplo data-rule:</h6>
              </article>
              <div class="code block horizontal_padding vertical_padding">
                <code>
                    &lt;input data-rule-required="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                </code>
              </div>
              <article class="block">
                <p class="block">
                  Además de la validación anterior, existen varios tipos de validaciones estándar:
                </p>
                <p class="block">
                  <span class="text_bold">RE_LatinCharacters:</span><br>
                  Solo permite texto incluyendo los caracteres especiales utilizados en latino america.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_LatinCharacters="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>

                <p class="block">
                  <span class="text_bold">RE_Email:</span><br>
                  Valida el formato de un email.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Email="true" class="input_data" type="email" name="txtNombreCampo"&gt;
                  </code>
                </div>

                <p class="block">
                  <span class="text_bold">RE_Numbers:</span><br>
                  Solo permite números enteros.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Numbers="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_NumbersIntDecimal:</span><br>
                  Permite solo números enteros y decimales
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_NumbersIntDecimal="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_Passwords:</span><br>
                   Valida lo mínimo que solicita una contraseña, que al menos sean números y letras (creación de passwords).
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Passwords="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_URL:</span><br>
                   Valida el ingreso de una url correcta.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_URL="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_Username, RE_Passwords2: </span><br>
                  Valida lo mínimo y lo máximo (en número de caracteres y en contenido) para nombres de usuario y/o contraseñas.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Username="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_Date:</span><br>
                   Valida formato de fecha DD/MM/YYYY para todas las fechas o campos de tipo date
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Date="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_Image(JPG, JPEG y PNG) -RE_Doc(DOC, DOCX, PDF):</span><br>
                   Estas reglas permiten validar si el formato de una imagen o documento es soportado.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Image="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_WWW:</span><br>
                   Validar si la url ingresada contiene su respectivo dominio.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_WWW="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_hours:</span><br>
                   Para los campos de tipo hora con formato 24 horas.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_hours="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
                <p class="block">
                  <span class="text_bold">RE_Select:</span><br>
                   Para validar la selección de un item válido en un elemento select.
                </p>
                <div class="code block horizontal_padding vertical_padding">
                  <code>
                    &lt;input data-rule-RE_Select="true" class="input_data" type="text" name="txtNombreCampo"&gt;
                  </code>
                </div>
              </article>
              <h6 class="block text_bold">Ejemplo de formulario con validaciones:</h6>
            </div>
            <form class="block" id="frmEjemplo">

              <div class="frmCont">
                <label for="txtCaracteresLatinos">Caracteres latinos:</label>
                <div class="frmInput">
                  <input class="input_data" type="text" name="txtCaracteresLatinos" data-rule-required="true" data-rule-RE_LatinCharacters="true">
                </div>
              </div>

              <div class="frmCont">
                <label for="txtEmail">Email:</label>
                <div class="frmInput">
                  <input class="input_data" type="email" name="txtEmail" data-rule-required="true" data-rule-RE_Email="true">
                </div>
              </div>

              <div class="frmCont">
                <label for="txtNumero">Número:</label>
                <div class="frmInput">
                  <input class="input_data" type="text" name="txtNumero" data-rule-required="true" data-rule-RE_Numbers="true">
                </div>
              </div>

              <div class="frmCont">
                <label for="txtImg">Cargar imagen:</label>
                <div class="frmInput">
                  <input class="input_data" type="file" name="txtImg" data-rule-required="true" data-rule-RE_Image="true">
                </div>
              </div>

              <div class="frmCont">
                <label for="txtSelect">Selección</label>
                <div class="frmInput">
                  <select class="input_data" name="txtSelect" data-rule-RE_Select="0">
                    <option value="0">Seleccione una opción</option>
                    <option value="1">Opción 1</option>
                    <option value="2">Opción 2</option>
                    <option value="3">Opción 3</option>
                  </select>
                </div>
              </div>

              <div class="frmCont">
                <label for="txtTextarea">Descripción</label>
                <div class="frmInput">
                  <textarea class="input_data" name="txtTextarea" rows="8" cols="40" data-rule-required="true"></textarea>
                </div>
              </div>

              <div class="frmCont">
                <label for="txtSelect2">Select2</label>
                <div class="frmInput frmInput_select2">
                  <select class="select input_data" name="txtSelect2" data-rule-RE_Select="0">
                    <option value="0" selected>Seleccione una opción</option>
                    <option value="1">Opción 1</option>
                    <option value="2">Opción 2</option>
                    <option value="3">Opción 3</option>
                  </select>
                </div>
              </div>

              <button type="submit" class="btn btn-registrar" name="button" id="btnFormEjemplo">Enviar</button>

            </form>
            <article class="block">
              <p>
                El formulario anterior está compuesto por la siguiente estructura:
              </p>
            </article>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;form class="block" id="frmEjemplo"&gt;

  &lt;div class="frmCont"&gt;
    &lt;label for="txtCaracteresLatinos"&gt;Caracteres latinos:&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;input class="input_data" type="text" name="txtCaracteresLatinos" data-rule-required="true" data-rule-RE_LatinCharacters="true"&gt;
    &lt;/div&gt;
  &lt;/div&gt;

  &lt;div class="frmCont"&gt;
    &lt;label for="txtEmail"&gt;Email:&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;input class="input_data" type="email" name="txtEmail" data-rule-required="true" data-rule-RE_Email="true"&gt;
    &lt;/div&gt;
  &lt;/div&gt;

  &lt;div class="frmCont"&gt;
    &lt;label for="txtNumero"&gt;Número:&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;input class="input_data" type="text" name="txtNumero" data-rule-required="true" data-rule-RE_Numbers="true"&gt;
    &lt;/div&gt;
  &lt;/div&gt;

  &lt;div class="frmCont"&gt;
    &lt;label for="txtImg"&gt;Cargar imagen:&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;input class="input_data" type="file" name="txtImg" data-rule-required="true" data-rule-RE_Image="true"&gt;
    &lt;/div&gt;
  &lt;/div&gt;

  &lt;div class="frmCont"&gt;
    &lt;label for="txtSelect"&gt;Selección&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;select class="input_data" name="txtSelect" data-rule-RE_Select="0"&gt;
        &lt;option value="0"&gt;Seleccione una opción&lt;/option&gt;
        &lt;option value="1"&gt;Opción 1&lt;/option&gt;
        &lt;option value="2"&gt;Opción 2&lt;/option&gt;
        &lt;option value="3"&gt;Opción 3&lt;/option&gt;
      &lt;/select&gt;

    &lt;/div&gt;
  &lt;/div&gt;

  &lt;div class="frmCont"&gt;
    &lt;label for="txtTextarea"&gt;Descripción&lt;/label&gt;
    &lt;div class="frmInput"&gt;
      &lt;textarea class="input_data" name="txtTextarea" rows="8" cols="40" data-rule-required="true"&gt;&lt;/textarea&gt;
    &lt;/div&gt;
  &lt;/div&gt;

  &lt;button type="submit" class="btn btn-registrar" name="button" id="btnFormEjemplo"&gt;Enviar&lt;/button&gt;

&lt;/form&gt;
</pre>
              </code>
            </div>
            <h6 class="block text_bold">Validar el formulario con javascript:</h6>
            <article class="block">
              <p class="block">
                Para llevar a cabo la validación de un formulario se requiere llamar la función <samp>'ValidateForm'</samp>, la cual recibe como parámetro el <samp>'id'</samp> de nuestro formulario y una función callback que se ejecuta cuando el formulario ha sido enviado y está correctamente diligenciado, dicho callback trae consigo un objeto llamado 'formdata' con la información ingresada en el formulario. La información está compuesta por el nombre de cada campo (atributo <samp>'name'</samp>) y su valor correspondiente diligenciado en el formulario.
              </p>
            </article>
            <h6 class="block text_bold">Script para validar el formulario anterior: </h6>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
// Validar formulario del panel
ValidateForm('frmEjemplo', function(formdata) {
  /**
  * Este es el callback de la validación,
  * esta función se ejecuta cuando el
  * formulario ha sido validado correctamente
  * El objeto formdata contiene todos los datos
  * ingresados en el formulario
  */

  console.log(formdata);

  let descripcion = 'Revisa la consola del navegador para ver los datos que has enviado';

  Notificate({
    titulo: 'Formulario enviado!',
    descripcion: descripcion,
    tipo: 'success',
    duracion: 4
  });

  // Ejemplo de petición ajax:
  DoPostAjax({
    url: 'ejemplos/ctrlEjemplos/PruebaAjax',
    data: formdata
  }, function(err, data) {
    if (err) {
      // Si ocurre algún error:
      Notificate({
        titulo: 'Ha ocurrido un error',
        descripcion: 'Error inesperado al enviar la información, por favor intentelo nuevamente',
        tipo: 'error',
        duracion: 4
      });
    } else {
      // Si todo sale bien:
      Notificate({
        titulo: 'Información recibida',
        descripcion: data,
        tipo: 'info',
        duracion: 4
      });
    }
  });

});
</pre>
              </code>
            </div>
          </div>
        </div>
        <!-- FIN VALIDACIONES -->

        <!-- PANEL DE LISTAS -->
        <div class="panel block">
          <div class="panel-cabecera">
            <h3>Botones de paginación y panel de listas</h3>
          </div>
          <div class="panel-contenido">
            <article class="block">
              <h6 class="text_bold">Diseño barra busqueda:</h6>
            </article>
            <div class="n_flex_col100 horizontal_padding ovf_initial block">
              <!-- BARRA BUSQUEDA -->
              <div class="barra-filtro ">

              <!--BÓTON DE CONFIGURACIÓN-->
              <div class=" btn-barra-filtro "><span class="fa fa-search"></span></div>
              <!--INPUT DE CONFIGURACIÓN-->
              <div class=" input-barra"><input type="search" id="txtinputBusqueda" value=""></div>
              <!--BÓTON QUE DESPLIEGA EL EL MENÚ DE CONFIGURACIÓN-->
              <div class="btn-barra-menu"><span class="fa fa-cog"><span class="fa fa-caret-down"></span></span></div>
              <!--MENÚ DE CONFIGURACIÓN-->
              <form class="menu-filtro " style="display: none;">

                <!--OPCIONES DE FILTRO-->
                <div class="contenido-menu-filtro">
                  <h5 class="toggle"><span class="fa fa-wrench"></span>Opciones de Filtro</h5>
                  <div class="contenedor n_flex n_justify_around" id="filtro-general" style="display:flex">
                    <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                      <label for="">Filtrar por:</label>

                      <select class="" name="">
                        <option value="">Todas</option>
                        <option value="">Aprobadas</option>
                        <option value="">Rechazas</option>
                        <option value="">Por evaluar</option>
                      </select>
                    </div>
                    <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                      <label for="">N° de registros:</label>
                      <select class="" name="">
                        <option value="">5</option>
                        <option value="">10</option>
                        <option value="">20</option>
                        <option value="">50</option>
                        <option value="">Todos</option>
                      </select>
                    </div>
                  </div>
                </div><!--FIN OPCIONES DE FILTRO-->

                <!--OPCIONES DE BÚSQUEDA-->
                <div class="contenido-menu-filtro">
                  <h5 class="toggle"><span class="fa fa-search"></span>Opciones de Búsqueda</h5>
                  <div class="contenedor n_flex " id="filtro-avanzado">
                    <div class="contenedor-input  n_flex n_flex_col50 lg_flex_col50 md_flex_col100">
                      <label for="">Buscar por:</label>
                      <select id="txtColumnaBusqueda">
                        <option value="Nombre">Nombre</option>
                        <option value="Apellido">Apellido</option>
                        <option value="Documento">Documento</option>
                      </select>
                    </div>
                    <div class="contenedor-input  n_flex n_flex_col100">
                      <label for="">Que la palabra se encuentre:</label>
                      <div class="n_flex n_justify_start n_flex_col100">
                        <div class="n-checkbox n_flex n_justify_between">
                          <label class="descripcion-checkbox" for="radComienzo">Al comienzo</label>
                          <div class="contenedor-checkbox">
                            <input type="radio" name="like" value="" id="radComienzo">
                            <label class="fa fa-check" for="radComienzo"></label>
                          </div>
                        </div>
                        <div class="n-checkbox n_flex n_justify_between">
                          <label class="descripcion-checkbox" for="radMedio">En medio</label>
                          <div class="contenedor-checkbox">
                            <input type="radio" name="like" value="" id="radMedio">
                            <label class="fa fa-check" for="radMedio"></label>
                          </div>
                        </div>
                        <div class="n-checkbox n_flex n_justify_between">
                          <label class="descripcion-checkbox" for="radFinal">Al final</label>
                          <div class="contenedor-checkbox">
                            <input type="radio" name="like" value="" id="radFinal">
                            <label class="fa fa-check" for="radFinal"></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div><!--FIN OPCIONES DE BÚSQUEDA-->

                <!--OPCIONES DE FECHAS-->
                <div class="contenido-menu-filtro">
                  <h5 class="toggle"><span class="fa fa-calendar"></span>Buscar por fechas</h5>
                  <div class="contenedor n_flex n_justify_around" id="filtro-fechas">
                    <div class="contenedor-input  n_flex n_flex_col100  lg_flex_col50 md_flex_col100">
                      <label for="">Primera fecha:</label>
                      <input type="Date" id="fechaInicio">
                    </div>
                    <div class="contenedor-input  n_flex n_flex_col100  lg_flex_col50 md_flex_col100" id="contenidoFechaFin">
                      <label for="">Segunda fecha:</label>
                      <input type="Date" id="fechaFin">
                    </div>
                    <div class="contenedor-input n_flex n_flex_col100" id="contenidoFechaFin">
                      <div class="texto n_flex n_justify_around">
                        <div class="texto-icono n_flex n_justify_center n_align_center">
                          <span class="fa fa-info"></span>
                        </div>
                        <p class="n_flex n_flex_col100 xs_flex_col75 md_flex_col85">
                          <label>¿Qué es esto?</label>
                          ipsam rerum iste optio odio expedita recusandae est,
                          quos ea autem amet sunt atque dignissimos adipisci, s
                          int asperiores corrupti. Saepe, deserunt.</p>
                        </div>
                      </div>
                    </div>
                  </div><!--FIN OPCIONES DE FECHAS-->

                  <!--ORDENAR-->
                  <div class="contenido-menu-filtro">
                    <h5 class="toggle"><span class="fa fa-sort"></span>Ordenar</h5>
                    <div class="contenedor" id="filtro-order">
                      <div class="contenedor-input  n_flex n_flex_col100">
                        <label for="">Ordenar de forma:</label>
                        <div class="n_flex n_justify_start n_flex_col100">
                          <div class="n-checkbox n_justify_between ">
                            <label class="descripcion-checkbox" for="radDescendente">Descendente </label>
                            <div class="contenedor-checkbox ">
                              <input type="radio" name="orderBy" value="DESC" id="radDescendente">
                              <label class="fa fa-check" for="radDescendente"></label>
                            </div>
                          </div>
                          <div class="n-checkbox  n_flex n_justify_between ">
                            <label class="descripcion-checkbox" for="radAscendente">Ascendente </label>
                            <div class="contenedor-checkbox ">
                              <input type="radio" name="orderBy" value="ASC" id="radAscendente">
                              <label class="fa fa-check" for="radAscendente"></label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!--FIN ORDENAR-->


                </form> <!-- FIN MENÚ DE CONFIGURACIÓN-->

              </div>
            </div>

            <article class="block">
              <h6 class="text_bold">Botones de paginación:</h6>
            </article>
            <div class="n_flex_col100 horizontal_padding">
              <ul class="paginador block"  id="paginadorDinamico"></ul>
            </div>
            <article class="block">
              <p>Código de implementación de botones de paginación:</p>
            </article>
            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;ul class="paginador" id="paginadorDinamico" &gt;&lt;/ul&gt;
</pre>
              </code>
            </div>

            <article class="block">
              <p>Código Javascript para pasar los botones:</p>
            </article>

            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
var options = {
  parent: 'paginadorDinamico',
  url: 'EJEMPLOS/CtrlEjemplos/PruebaPaginador',
  configuration: {
    tableName: 'tbl_reporteinicial', // Es recomendable hacer esto desde el controlador
    limit: 5,
    // Datos opcionales
    nameColumnDateTime: 'fechaHoraAproximadaEmergencia',
    filterDateTimeStart: '2016-03-01',
    filterDateTimeEnd: '2016-05-29',
    nameColumnFilter: 'estadoTablaReporteInicial',
    filter: 'estos,son,filtros,lo que sea separado por comas',
    nameColumnOrderBy: '',
    orderBy: ''
  }
};

paginator.view.generateButtons(options)
.then(function (data) {
  console.log("primero: " , data);
  $('#' + options.parent).on('click', 'li.btn_paginador', function () {
    Paginate(options, $(this), function(data) {
      console.log(data);
    });
  });
});
</pre>
              </code>
            </div>
            <article class="block">
              <h6 class="text_bold block">Paneles para listar contenido:</h6>
              <p>
                Hay 4 tipos de paneles para listar contenidos. Al ser listas, deben estar contenidos dentro de una lista sin orden (<samp>'ul'</samp>), la cual puede tener las propiedades responsive de la grid para que los paneles se adapten
              </p>
            </article>
            <article class="block">
              <h6 class="text_bold">Panel de listas sencillo:</h6>
            </article>

            <ul class="list_panel relative_element n_flex n_justify_start block">

              <li class="list_item n_dont_grow">
                <div class="list_item_header n_flex n_nowrap">
                  <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                    <h5 class="text_bold suspensive">Título</h5>
                  </div>
                </div>

                <div class="list_item_content suspensive_4">
                  <p class="paragraph">
                    <span class="text_bold">Subtitulo:</span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
                  </p>
                </div>
              </li>

            </ul>

            <article class="block">
              <p>Para implementar este panel se requiere del siguiente código:</p>
            </article>

            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;ul class="list_panel relative_element n_flex n_justify_start block"&gt;

  &lt;li class="list_item n_dont_grow"&gt;
    &lt;div class="list_item_header n_flex n_nowrap"&gt;
      &lt;div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"&gt;
        &lt;h5 class="text_bold suspensive"&gt;Título&lt;/h5&gt;
      &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="list_item_content suspensive_4"&gt;
      &lt;p class="paragraph"&gt;
        &lt;span class="text_bold"&gt;Subtitulo:&lt;/span&gt;
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
      &lt;/p&gt;
    &lt;/div&gt;
  &lt;/li&gt;

&lt;/ul&gt;
</pre>
              </code>
            </div>

            <article class="block">
              <h6 class="text_bold">Panel de listas con ícono:</h6>
            </article>

            <ul class="list_panel relative_element n_flex n_justify_start block">

              <li class="list_item n_dont_grow">
                <div class="list_item_header n_flex n_nowrap">
                  <div class="item_icon n_flex n_align_center">
                    <span class="fa fa-gitlab"></span>
                  </div>
                  <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                    <h5 class="text_bold suspensive">Título tiene puntos suspensivos</h5>
                  </div>
                </div>

                <div class="list_item_content suspensive_4">
                  <p class="paragraph">
                    <span class="text_bold">Subtitulo:</span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
                  </p>
                </div>
              </li>

            </ul>

            <article class="block">
              <p>Para implementar este panel se requiere del siguiente código:</p>
            </article>

            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;ul class="list_panel relative_element n_flex n_justify_start block"&gt;

  &lt;li class="list_item n_dont_grow"&gt;
    &lt;div class="list_item_header n_flex n_nowrap"&gt;
      &lt;div class="item_icon n_flex n_align_center"&gt;
        &lt;span class="fa fa-gitlab"&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"&gt;
        &lt;h5 class="text_bold suspensive"&gt;Título tiene puntos suspensivos&lt;/h5&gt;
      &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="list_item_content suspensive_4"&gt;
      &lt;p class="paragraph"&gt;
        &lt;span class="text_bold"&gt;Subtitulo:&lt;/span&gt;
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
      &lt;/p&gt;
    &lt;/div&gt;
  &lt;/li&gt;

&lt;/ul&gt;
</pre>
              </code>
            </div>

            <article class="block">
              <h6 class="text_bold">Panel de listas con varias filas de contenido:</h6>
            </article>

            <ul class="list_panel relative_element n_flex n_justify_start block">

              <li class="list_item n_dont_grow">
                <div class="list_item_header n_flex n_nowrap">
                  <div class="item_icon n_flex n_align_center">
                    <span class="fa fa-gitlab"></span>
                  </div>
                  <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                    <h5 class="text_bold suspensive">Título</h5>
                  </div>
                </div>

                <div class="list_item_content suspensive_4">
                  <p class="paragraph">
                    <span class="text_bold">Subtitulo:</span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
                  </p>
                </div>

                <div class="list_item_content">
                  <p class="suspensive">
                    <span class="text_bold">Subtitulo:</span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis, consequuntur!
                  </p>
                </div>

                <div class="list_item_content">
                  <p class="suspensive">
                    <span class="text_bold">Subtitulo:</span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, omnis.
                  </p>
                </div>
              </li>

            </ul>

            <article class="block">
              <p>Para implementar este panel se requiere del siguiente código:</p>
            </article>

            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;ul class="list_panel relative_element n_flex n_justify_start block"&gt;

  &lt;li class="list_item n_dont_grow"&gt;
    &lt;div class="list_item_header n_flex n_nowrap"&gt;
      &lt;div class="item_icon n_flex n_align_center"&gt;
        &lt;span class="fa fa-gitlab"&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"&gt;
        &lt;h5 class="text_bold suspensive"&gt;Título&lt;/h5&gt;
      &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="list_item_content suspensive_4"&gt;
      &lt;p class="paragraph"&gt;
        &lt;span class="text_bold"&gt;Subtitulo:&lt;/span&gt;
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
      &lt;/p&gt;
    &lt;/div&gt;

    &lt;div class="list_item_content"&gt;
      &lt;p class="suspensive"&gt;
        &lt;span class="text_bold"&gt;Subtitulo:&lt;/span&gt;
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis, consequuntur!
      &lt;/p&gt;
    &lt;/div&gt;

    &lt;div class="list_item_content"&gt;
      &lt;p class="suspensive"&gt;
        &lt;span class="text_bold"&gt;Subtitulo:&lt;/span&gt;
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, omnis.
      &lt;/p&gt;
    &lt;/div&gt;
  &lt;/li&gt;

&lt;/ul&gt;
</pre>
              </code>
            </div>

            <article class="block">
              <h6 class="text_bold">Panel de listas con footer:</h6>
            </article>

            <ul class="list_panel relative_element n_flex n_justify_start block">

              <li class="list_item n_dont_grow">
                <div class="list_item_header n_flex n_nowrap">
                  <div class="item_icon n_flex n_align_center">
                    <span class="fa fa-gitlab"></span>
                  </div>
                  <div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden">
                    <h5 class="text_bold suspensive">Título</h5>
                  </div>
                </div>

                <div class="list_item_content suspensive_3">
                  <p class="paragraph">
                    <span class="text_bold">Subtitulo:</span>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
                  </p>
                </div>

                <div class="list_item_footer n_flex n_justify_between horizontal_padding">
                  <div class="footer_element">
                    <span><i class="fa fa-calendar"></i> 17/04/2016</span>
                  </div>
                  <div class="footer_element n_flex">
                    <div class="tooltip separate_right">
                      <span class="button"><i class="fa fa-download"></i></span>
                      <span class="tooltiptext">Descargar</span>
                    </div>
                    <div class="counter tooltip">
                      <span><i class="fa fa-bell"></i></span>
                      <span>0</span>
                      <span class="tooltiptext">Contador</span>
                    </div>
                  </div>
                </div>
              </li>

            </ul>

            <article class="block">
              <p>Para implementar este panel se requiere del siguiente código:</p>
            </article>

            <div class="code block vertical_padding horizontal_padding">
              <code>
<pre>
&lt;ul class="list_panel relative_element n_flex n_justify_start block"&gt;

  &lt;li class="list_item n_dont_grow"&gt;
    &lt;div class="list_item_header n_flex n_nowrap"&gt;
      &lt;div class="item_icon n_flex n_align_center"&gt;
        &lt;span class="fa fa-gitlab"&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;div class="item_title n_grow_up horizontal_padding vertical_padding ovf_hidden"&gt;
        &lt;h5 class="text_bold suspensive"&gt;Título&lt;/h5&gt;
      &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="list_item_content suspensive_3"&gt;
      &lt;p class="paragraph"&gt;
        &lt;span class="text_bold"&gt;Subtitulo:&lt;/span&gt;
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus sapiente unde quod quis aperiam iusto at aliquid suscipit eveniet similique! Repellendus, voluptatibus. Ab dicta, obcaecati neque quibusdam ullam nulla. Quae.
      &lt;/p&gt;
    &lt;/div&gt;

    &lt;div class="list_item_footer n_flex n_justify_between horizontal_padding"&gt;
      &lt;div class="footer_element"&gt;
        &lt;span&gt;&lt;i class="fa fa-calendar"&gt;&lt;/i&gt; 17/04/2016&lt;/span&gt;
      &lt;/div&gt;
      &lt;div class="footer_element n_flex"&gt;
        &lt;div class="tooltip separate_right"&gt;
          &lt;span class="button"&gt;&lt;i class="fa fa-download"&gt;&lt;/i&gt;&lt;/span&gt;
          &lt;span class="tooltiptext"&gt;Descargar&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="counter tooltip"&gt;
          &lt;span&gt;&lt;i class="fa fa-bell"&gt;&lt;/i&gt;&lt;/span&gt;
          &lt;span&gt;0&lt;/span&gt;
          &lt;span class="tooltiptext"&gt;Contador&lt;/span&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/li&gt;

&lt;/ul&gt;
</pre>
              </code>
            </div>

          </div>
        </div>
        <!-- FIN PANEL LISTAS -->

      </div>
    </div>


  </div>

</div> <!-- FIN CONTENIDO VISTA -->
