<?php
require 'app/models/Rol.php';
require 'app/models/Menu.php';
class RolController{
    private $rol;
    private $menu;
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    public function __construct()
    {
        $this->rol = new Rol();
        $this->menu = new Menu();
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $roles = $this->rol->listar_roles();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'rol/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function accesos(){
        try{
            if(!$this->validar->validar_parametro('id', 'GET',true,true,11,'numero',0)){
                throw new Exception('ID no declarado');
            }
            $menus = $this->menu->listar_menus();
            $rol = $this->rol->listar_rol($_GET['id']);
            require _VIEW_PATH_ . 'rol/accesos.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<br><br><div style='text-align: center'><h3>Ocurrió Un Error Al Cargar Los Permisos</h3></div>";
        }
    }
    public function guardar_rol(){
        $rol = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('rol_nombre', 'POST',true,$ok_data,20,'texto',0);
            $ok_data = $this->validar->validar_parametro('rol_descripcion', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('rol_estado', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',false,$ok_data,11,'numero',0);
            if($ok_data){
                $model = new Rol();
                if(!empty($_POST['id_rol'])){
                    $model->id_rol = $_POST['id_rol'];
                    $validar_duplicados = false;
                } else {
                    $validar_duplicados = $this->rol->buscar_rol($_POST['rol_nombre']);
                }
                if($validar_duplicados){
                    $result = 3;
                    $message = "Ya existe un rol registrado con este nombre";
                } else {
                    $model->rol_nombre = $_POST['rol_nombre'];
                    $model->rol_descripcion = $_POST['rol_descripcion'];
                    $model->rol_estado = $_POST['rol_estado'];
                    $result = $this->rol->guardar_rol($model);
                    if($result == 1){
                        if(!empty($_POST['id_rol'])){
                            $rol = array(
                                "id_rol" => $_POST['id_rol'],
                                "rol_nombre" => $_POST['rol_nombre'],
                                "rol_descripcion" => $_POST['rol_descripcion'],
                                "rol_estado" => $_POST['rol_estado']
                            );
                        }
                    }
                }
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "rol" => $rol)));
    }
    public function gestionar_acceso_rol(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_menu', 'POST',false,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',false,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('relacion', 'POST',false,$ok_data,11,'numero',0);
            if($ok_data){
                if($_POST['relacion'] == 1 || $_POST['relacion'] == 0){
                    switch (intval($_POST['relacion'])){
                        case 0:
                            $result = $this->menu->eliminar_relacion($_POST['id_rol'], $_POST['id_menu']);
                            break;
                        case 1:
                            $result = $this->menu->agregar_relacion($_POST['id_rol'], $_POST['id_menu']);
                            break;
                    }
                }
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
}
