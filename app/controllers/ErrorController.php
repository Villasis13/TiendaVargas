<?php
class ErrorController{
    public function __construct()
    {

    }
    public function inicio(){
        require _VIEW_PATH_ . 'error/error.php';
    }
    public function mantenimiento(){
        require _VIEW_PATH_ . 'error/mantenimiento.php';
    }
    public function error_critico(){
        require _VIEW_PATH_ . 'error/error_critico.php';
    }
}
