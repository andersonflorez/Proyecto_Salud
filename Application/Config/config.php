<?php

/**
* Configuración general del proyecto:
*/

/**
* Configuración de reporte de errores:
* Útil para ver cualquier error (hasta los mas pequeños) durante la etapa de desarrollo
*/
define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
}

/**
* Configuración de URLs
* Aqui se auto detectan las rutas de la aplicación.
* No tocar nada a menos que sepa lo que esta haciendo.
*
* URL_PUBLIC_FOLDER:
* Es el directorio que contiene todos los archivos públicos.
* El unico directorio al que tendrán acceso los usuarios.
* Por lo tanto los usuarios no podrán ingresar a ningún archivo
* que este dentro de "/application" o ningún otro
* archivo que no se encuentre en el directorio público.
*
* URL_PROTOCOL:
* El protocolo a usar, no cambiarlo a menos de saber lo que
* se está haciendo.
*
* URL_DOMAIN:
* El dominio de la aplicación (localhost), no cambiarlo a
* menos de saber lo que se está haciendo.
*
* URL_SUB_FOLDER:
* Subcarpeta, aunque no se use, dejarlo tal y como está.
*
* URL:
* Es la URL final autoconstruida por cada uno de los segmentos anteriores.
*/
define('URL_PUBLIC_FOLDER', 'Public');
define('URL_PROTOCOL', 'http://');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

/**
* Configuración general de la base de datos:
* Aqui se definen todas y cada una de las características de la base de datos:
*/
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost:3306');
define('DB_NAME', 'bd_proyecto_salud');
define('DB_USER', 'root');
define('DB_PASS', '1234');
define('DB_CHARSET', 'utf8');
