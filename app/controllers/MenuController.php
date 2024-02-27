<?php
require 'app/models/Menu.php';
require 'app/models/Rol.php';
class MenuController{
    private $menu;
    private $rol;
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    public function __construct()
    {
        $this->menu = new Menu();
        $this->rol = new Rol();
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $menus = $this->menu->listar_menus();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'menu/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function roles(){
        try{
            if(!$this->validar->validar_parametro('id', 'GET',true,true,11,'numero',0)){
                throw new Exception('ID no declarado');
            }
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $roles = $this->rol->listar_roles();
            $menu = $this->menu->listar_menu($_GET['id']);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'menu/roles.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function opciones(){
        try{
            if(!$this->validar->validar_parametro('id', 'GET',true,true,11,'numero',0)){
                throw new Exception('ID no declarado');
            }
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $opciones = $this->menu->listar_opciones($_GET['id']);
            $menu = $this->menu->listar_menu($_GET['id']);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'menu/opciones.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function gestion_permisos(){
        try{
            if(!$this->validar->validar_parametro('id', 'GET',true,true,11,'numero',0)){
                throw new Exception('ID no declarado');
            }
            $opcion = $this->menu->listar_opcion($_GET['id']);
            $permisos = $this->menu->listar_permisos($_GET['id']);
            require _VIEW_PATH_ . 'menu/permisos.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<br><br><div style='text-align: center'><h3>Ocurrió Un Error Al Cargar Los Permisos</h3></div>";
        }
    }
    public function gestion_restricciones(){
        try{
            if(!$this->validar->validar_parametro('id', 'GET',true,true,11,'numero',0)){
                throw new Exception('ID no declarado');
            }
            $opcion = $this->menu->listar_opcion($_GET['id']);
            $roles = $this->rol->listar_roles();
            require _VIEW_PATH_ . 'menu/restricciones.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<br><br><div style='text-align: center'><h3>Ocurrió Un Error Al Cargar Los Permisos</h3></div>";
        }
    }
    public function iconos(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'menu/iconos.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function guardar_menu(){
        $menu = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('menu_nombre', 'POST',true,$ok_data,20,'texto',0);
            $ok_data = $this->validar->validar_parametro('menu_controlador', 'POST',true,$ok_data,20,'texto',0);
            $ok_data = $this->validar->validar_parametro('menu_icono', 'POST',false,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('menu_orden', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('menu_mostrar', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('menu_estado', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_menu', 'POST',false,$ok_data,11,'numero',0);

            if($ok_data){
                $model = new Menu();
                if(!empty($_POST['id_menu'])){
                    $model->id_menu = $_POST['id_menu'];
                    $validar_duplicados = false;
                } else {
                    $validar_duplicados = $this->menu->buscar_menu_controlador(ucfirst(strtolower($_POST['menu_controlador'])));
                }
                if($validar_duplicados){
                    $result = 3;
                    $message = "Ya existe un menú con ese controlador registrado";
                } else {
                    $model->menu_nombre = $_POST['menu_nombre'];
                    $model->menu_controlador = ucfirst(strtolower($_POST['menu_controlador']));
                    $model->menu_icono = $_POST['menu_icono'];
                    $model->menu_orden = $_POST['menu_orden'];
                    $model->menu_mostrar = $_POST['menu_mostrar'];
                    $model->menu_estado = $_POST['menu_estado'];
                    $result = $this->menu->guardar_menu($model);
                    if($result == 1){
                        if(!empty($_POST['id_menu'])){
                            $menu = array(
                                "id_menu" => $_POST['id_menu'],
                                "menu_nombre" => $_POST['menu_nombre'],
                                "menu_controlador" => $_POST['menu_controlador'],
                                "menu_icono" => $_POST['menu_icono'],
                                "menu_orden" => $_POST['menu_orden'],
                                "menu_mostrar" => $_POST['menu_mostrar'],
                                "menu_estado" => $_POST['menu_estado']
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "menu" => $menu)));
    }
    public function guardar_opcion(){
        $opcion = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('opcion_nombre', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('opcion_funcion', 'POST',true,$ok_data,35,'texto',0);
            $ok_data = $this->validar->validar_parametro('opcion_icono', 'POST',false,$ok_data,20,'texto',0);
            $ok_data = $this->validar->validar_parametro('opcion_mostrar', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('opcion_orden', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('opcion_estado', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_menu', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_opcion', 'POST',false,$ok_data,11,'numero',0);

            if($ok_data){
                $model = new Menu();
                if(!empty($_POST['id_opcion'])){
                    $model->id_opcion = $_POST['id_opcion'];
                    $validar_duplicados = false;
                } else {
                    $validar_duplicados = $this->menu->buscar_opcion_menu($_POST['id_menu'],strtolower($_POST['opcion_funcion']));
                }
                if($validar_duplicados){
                    $result = 3;
                    $message = "Ya existe una opción con ese menu registrado";
                } else {
                    $model->id_menu = $_POST['id_menu'];
                    $model->opcion_nombre = $_POST['opcion_nombre'];
                    $model->opcion_funcion = strtolower($_POST['opcion_funcion']);
                    $model->opcion_icono = $_POST['opcion_icono'];
                    $model->opcion_mostrar = $_POST['opcion_mostrar'];
                    $model->opcion_orden = $_POST['opcion_orden'];
                    $model->opcion_estado = $_POST['opcion_estado'];
                    $result = $this->menu->guardar_opcion($model);
                    if($result == 1){
                        if(!empty($_POST['id_opcion'])){
                            $opcion = array(
                                "id_opcion" => $_POST['id_opcion'],
                                "opcion_nombre" => $_POST['opcion_nombre'],
                                "opcion_funcion" => $_POST['opcion_funcion'],
                                "opcion_icono" => $_POST['opcion_icono'],
                                "opcion_mostrar" => $_POST['opcion_mostrar'],
                                "opcion_orden" => $_POST['opcion_orden'],
                                "opcion_estado" => $_POST['opcion_estado']
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "opcion" => $opcion)));
    }
    public function configurar_relacion(){
        $menu = [];
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "menu" => $menu)));
    }
    public function agregar_permiso(){
        $permiso = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('permiso_accion', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_opcion', 'POST',true,$ok_data,11,'numero',0);
            if($ok_data){
                $model = new Menu();
                $validar_duplicados = $this->menu->buscar_permiso_opcion($_POST['id_opcion'], $_POST['permiso_accion']);
                if($validar_duplicados){
                    $result = 3;
                    $message = "Ya existe un permiso en la opción consultada";
                } else {
                    $model->id_opcion = $_POST['id_opcion'];
                    $model->permiso_accion = strtolower(str_replace(" ", "",$_POST['permiso_accion']));
                    $model->permiso_estado = $_POST['permiso_estado'];
                    $result = $this->menu->guardar_permiso($model);
                }
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "permiso" => $permiso)));
    }
    public function eliminar_permiso(){
        $permiso = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_permiso', 'POST',true,$ok_data,11,'numero',0);
            if($ok_data){
                $result = $this->menu->eliminar_permiso($_POST['id_permiso']);
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "permiso" => $permiso)));
    }
    public function configurar_acceso(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',false,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_opcion', 'POST',false,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('relacion', 'POST',false,$ok_data,11,'numero',0);

            if($ok_data){
                if($_POST['relacion'] == 1 || $_POST['relacion'] == 0){
                    switch (intval($_POST['relacion'])){
                        case 0:
                            $result = $this->menu->agregar_restriccion($_POST['id_rol'], $_POST['id_opcion']);
                            break;
                        case 1:
                            $result = $this->menu->eliminar_restriccion($_POST['id_rol'], $_POST['id_opcion']);
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