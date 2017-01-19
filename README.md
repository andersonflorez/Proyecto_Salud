# PROYECTO SALUD (891220) - INSTRUCCIONES GENERALES DE GIT
### Fecha inicio: 25 de Enero del 2016
Feliz año!

## INSTRUCCIONES INICIALES:

### 1. Clonar repositorio: <br>
Suponiendo que ya tienes GIT instalado y configurado correctamente... <br>

- Con la consola de windows: 
> - Presionar 'WINDOWS' + 'R' <br>
> - Escribir "cmd" <br>
> - Presionar 'Enter' <br>
> - Ingresar a 'www' (WAMP) o 'htdocs' (XAMPP), por ejemplo: cd c:/wamp/www/<br>
> - Ejecutar: git clone https://gitlab.com/odin161/PROYECTO_SALUD_DEV.git<br>
> - Introducir cuenta de usuario + contraseña de GitLab.com + 'Enter'<br>
> - Esperar aproximadamente 1 minuto o menos hasta que clone el repositorio<br>

- Con git-bash (Se instala con GIT):
> - Ir al directorio del servidor (WAMP o XAMPP) <br>
> - Click derecho a la carpeta de proyectos, en wamp es 'www', en xampp creo que es 'htdocs' o donde tengan sus proyectos php.<br>
> - Click en 'open git bash here' o algo asi...<br>
> - Al abrir la consola, ejecutar: git clone https://gitlab.com/odin161/PROYECTO_SALUD_DEV.git<br>
> - Introducir cuenta de usuario + contraseña de GitLab.com + 'Enter'<br>
> - Esperar aproximadamente 1 minuto o menos hasta que clone el repositorio<br>

### 2. Si realizaron el punto 1 bien, el repositorio debió ser clonado.
> - Ingresar a la carpeta del proyecto clonado: cd PROYECTO_SALUD_DEV<br>
> - Crear una nueva rama con el nombre de su proceso (IMPORTANTE!), por ejemplo: <br>
git checkout -b reporte_inicial<br>
Todo en minúsculas (Separado por _ si el nombre lleva espacios)<br>
> - Descargar la actualización de la rama de su proceso: git pull origin nombre_rama_proceso <br>
El nombre debe ser exactamente igual a como esta el nombre de la rama en gitlab, para buscar el nombre de la rama de su
proceso vayan a esta misma página a la seccion que dice "11 branches" al lado derecho de la sección de "commits".
> - FIN :), mentiras, empezar a trabajar...<br>

## CÓMO SUBIR ACTUALIZACIONES:
Suponiendo que estamos ubicados en el directorio 'PROYECTO_SALUD_DEV'...<br>
Ejecutar los siguientes comandos, en el mismo orden: <br>
> - git status       <br> Para ver los archivos que acabamos de modificar (aparecen en rojo), si no se modificó nada aparece: "nothing to commit, working directory clean"<br>
> - git add .        <br> Para preparar los archivos modificados<br>
> - git status       <br> Ahora deben aparecer en verde, lo que significa que están preparados<br>
> - git commit -m "Descripcion de lo que hicimos"     <br> Para confirmar los cambios que hicimos (confirmar archivos preparados)<br>
> - git status       <br> Debe aparecer "nothing to commit, working directory clean", lo que significa que ya se confirmaron los cambios<br>
> - git push origin nombre_proceso <br> Para subir nuestro trabajo a GitLab a la rama de nuestro proceso, por ej: git push origin reporte_inicial<br>
> - Introducir usuario + contraseña de GitLab... y fin<br>

## CÓMO DESCARGAR ACTUALIZACIONES:
Realizar los siguientes pasos (siempre) antes de comenzar a trabajar en el proyecto: <br>
Suponiendo que estamos ubicados en el directorio 'PROYECTO_SALUD_DEV'...
> - git pull origin desarrollo   : Descargar actualizaciones de GitLab de la rama desarrollo<br>
> - Introducir usuario + contraseña de GitLab... y fin<br>

## CÓMO DESHACER CAMBIOS:
Si llegado el caso que por algún motivo HAYAN MOVIDO ALGO, SE HAYA DAÑADO Y NO SEPAN COMO REPARARLO, 
no se preocupen, se pueden "desconfirmar" los últimos cambios que se hicieron, siempre y cuando no
hayan ejecutado el comando 'git commit':

Estando en el directorio 'PROYECTO_SALUD_DEV', ejecutar: git checkout -- nombre_archivo.extension

Ejemplo:
Jose tocó el archivo 'no_tocar.php' que esta dentro de la carpeta 'application',
dañó el archivo de alguna manera y no sabe que hacer.
> - Jose debe ingresar a 'PROYECTO_SALUD_DEV/application'<br>
> - Ejecutar: git status<br>

Si el achivo 'no_tocar.php' aparece de color rojo:
> - Ejecutar: git checkout -- no_tocar.php<br>

Si el archivo 'no_tocar.php' aparece de color verde:
> - Ejecutar: git reset head no_tocar.php<br>
> - Ejecutar: git checkout -- no_tocar.php<br>

Ahora el archivo 'no_tocar.php' vuelve a estar como antes.
Este comando le ha salvado la vida a Jose (pobre de jose si 891220 se entera), no seas como Jose por favor.

¿Y que pasa si Jose toco 5 archivos de la carpeta 'application' y los dañó todos?<br>
En ese caso, Jose debe ejecutar 'git checkout' directamente al nombre de la carpeta, como en el siguiente ejemplo:

> - Ejecutar: git status<br>

Si los achivos de la carpeta aparecen de color rojo:
> - Ejecutar: git checkout -- application/<br>

Si los achivos de la carpeta aparecen de color verde:
> - Ejecutar: git reset head application/<br>
> - Ejecutar: git checkout -- application/<br>

Listo. Como si Jose nunca hubiese tocado los benditos archivos.

## CÓMO TRABAJAR DESDE EL SENA:
Fácil, se configura el proxy:
> - git config --global http.proxy http://proxy2.sena.edu.co:80		<br> Proxy para http<br>
> - git config --global https.proxy https://proxy2.sena.edu.co:80	<br> Proxy para https<br>

Cuando llegues a casa debes desactivarlo:
> - git config --global --unset http.proxy		<br> Proxy para http<br>
> - git config --global --unset https.proxy 	<br> Proxy para https<br>
