<?php
class Database{
    private static $db;

    public static function getConnection(){
        try{
            if(empty(self::$db)){
                $pdo = new PDO('mysql:host='._SERVER_DB_.';dbname='._DB_.';charset=utf8',_USER_DB_,_PASSWORD_DB_);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db = $pdo;
            }
            return self::$db;
        } catch (Throwable $e){
            if($_SESSION['acceso'] == 1){
                require 'app/controllers/ErrorController.php';
                $clase = 'ErrorController';
                $accion = 'error_critico';
                $controller = new $clase;
                $controller->$accion();
                echo "<script language=\"javascript\">console.log(\"". $e->getMessage()."\");</script>";
            } else {
                echo json_encode(
                    array(
                        "result" => array(
                            "code" => 2,
                            "message" => 'Error de Conexión de Base de Datos')
                    ));
            }
            exit;
        }
    }
}
