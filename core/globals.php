<?php
define('_MANTENIMIENTO_WS', 0);
define('_MANTENIMIENTO_WEB', 0);
date_default_timezone_set('America/Lima');
define('_SERVER_', 'http://127.0.0.1/TiendaVargas/');
define('_SERVER_DB_', 'localhost');
define('_STYLES_bt5_', 'styles/bt5/');
define('_DB_', 'tienda_vargas');
define('_USER_DB_', 'root');
define('_PASSWORD_DB_', '');
define('_FULL_KEY_','ñklmqz');
define('_TITLE_', 'TiendaVargas');
define('_STYLES_ALL_', 'styles/');
define('_STYLES_ADMIN_', 'styles/admin/');
define('_STYLES_LOGIN_', 'styles/login/');
define('_STYLES_INDEX_', 'styles/inicio/');
define('_STYLES_ASSETS_', 'styles/assets/');
define('_TODO_LOGIN_', 'styles/todo_login/');
define('_ICON_', 'styles/Logo_original.png');
define('_ICON2_', 'styles/muñeco.png');
define('_JS_','js/');
define('_VIEW_PATH_', 'app/view/');
define('_CONTROLLER_PATH_', 'app/controllers/');
define('_LIBS_', 'libs/');
define('_TIEMPO_COOKIE',1 * 1 * 60 * 60);
define('_VERSION_','0.1');
define('_MYSITE_','');

function exception_error_handler($severidad, $mensaje, $fichero, $linea) {
    $cadena =  '[LEVEL]: ' . $severidad . ' IN ' . $fichero . ': ' . $linea . '[MESSAGGE]' . $mensaje . "\n";
    $log = new Log();
    $log->insertar($cadena, "Excepcion No Manejada");
}