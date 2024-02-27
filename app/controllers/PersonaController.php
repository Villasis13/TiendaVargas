<?php
require 'app/models/Persona.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
class PersonaController
{
    private $usuario;
    private $rol;
    private $archivo;
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $persona;
    public function __construct()
    {
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->persona = new Persona();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $personas = $this->persona->listar_personas();
            $roles = $this->rol->listar_roles_superadmin();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'persona/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function listar_personas(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listMenu($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'personas/all.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);;
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function guardar_nueva_persona(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('persona_nombre', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paterno', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_materno', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_nacimiento', 'POST',true,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('persona_telefono', 'POST',true,$ok_data,15,'texto',0);
            if($ok_data){
                $model = new Persona();
                $microtime = microtime(true);
                $model->persona_nombre = $_POST['persona_nombre'];
                $model->persona_apellido_paterno = $_POST['persona_apellido_paterno'];
                $model->persona_apellido_materno = $_POST['persona_apellido_materno'];
                $model->persona_nacimiento = $_POST['persona_nacimiento'];
                $model->persona_telefono = $_POST['persona_telefono'];
                $model->person_codigo = $microtime;
                $guardar_persona = $this->persona->guardar_persona($model);
                if($guardar_persona==1){
                    $result = 1;
                }else{
                    $result = 2;
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
    public function eliminar_persona(){
        $menu = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_persona', 'POST',true,$ok_data,11,'numero',0);
            if($ok_data){
                $result = $this->persona->eliminar_persona($_POST['id_persona']);
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
}