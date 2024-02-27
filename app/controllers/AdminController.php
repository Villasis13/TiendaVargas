<?php
require 'app/models/Caja.php';
require 'app/models/Builder.php';
class AdminController{
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $caja;
    private $builder;
    public function __construct()
    {
        $this->encriptar = new Encriptar();
        $this->log = new Log();
		$this->validar = new Validar();
        $this->sesion = new Sesion();
        $this->caja = new Caja();
        $this->builder = new Builder();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'admin/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function finalizar_sesion(){
        $this->sesion->finalizar_sesion();
    }
}

