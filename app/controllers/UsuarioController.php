<?php
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
class UsuarioController{
    private $usuario;
    private $rol;
    private $archivo;
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    public function __construct()
    {
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            if($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_) == 2){
                $usuarios = $this->usuario->listar_usuarios_superadmin();
                $roles = $this->rol->listar_roles_superadmin();
            } else {
                $usuarios = $this->usuario->listar_usuarios();
                $roles = $this->rol->listar_roles_usuario();
            }
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'usuario/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function guardar_nuevo_usuario(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('persona_nombre', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paterno', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_materno', 'POST',false,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_nacimiento', 'POST',false,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('persona_telefono', 'POST',true,$ok_data,15,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_rol', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,70,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_email', 'POST',false,$ok_data,60,'email',0);
            $ok_data = $this->validar->validar_parametro('usuario_imagen', 'FILES',false,$ok_data,0,['jpg','png'],['jpg','png']);
            $ok_data = $this->validar->validar_parametro('usuario_estado', 'POST',true,$ok_data,1,'numero',0);
            if($ok_data){
                $model = new Usuario();
                if($this->usuario->validar_nickname(str_replace( " ", "",$_POST['usuario_nickname']))){
                    $result = 3;
                    $message = "Ya existe un usuario con este nickname registrado";
                } else {
                    if($this->usuario->validar_correo($_POST['usuario_email'])){
                        $result = 4;
                        $message = "Ya existe un usuario con este correo registrado";
                    } else {
                        $microtime = microtime(true);
                        $model->persona_nombre = $_POST['persona_nombre'];
                        $model->persona_apellido_paterno = $_POST['persona_apellido_paterno'];
                        $model->persona_apellido_materno = $_POST['persona_apellido_materno'];
                        $model->persona_nacimiento = $_POST['persona_nacimiento'];
                        $model->persona_telefono = $_POST['persona_telefono'];
                        $model->person_codigo = $microtime;
                        $guardar_persona = $this->usuario->guardar_persona($model);
                        if($guardar_persona == 1){
                            $id_persona = $this->usuario->listar_persona_microtime($microtime);
                            $model->id_persona = $id_persona;
                            $model->id_rol = $_POST['id_rol'];
                            $model->usuario_nickname = str_replace( " ", "",$_POST['usuario_nickname']);
                            $model->usuario_contrasenha = password_hash($_POST['usuario_contrasenha'], PASSWORD_BCRYPT);
                            $model->usuario_email = $_POST['usuario_email'];
                            if($_FILES['usuario_imagen']['name'] != null) {
                                $ext = pathinfo($_FILES['usuario_imagen']['name'], PATHINFO_EXTENSION);
                                $file_path = "media/usuarios/" . $id_persona . '_' .date('dmYHis') . "." . $ext;
                                if($this->archivo->subir_imagen_comprimida($_FILES['usuario_imagen']['tmp_name'], $file_path,false)){
                                    $model->usuario_imagen = $file_path;
                                } else {
                                    $model->usuario_imagen = 'media/usuarios/usuario.jpg';
                                }
                            } else {
                                $model->usuario_imagen = 'media/usuarios/usuario.jpg';
                            }
                            $model->usuario_estado = $_POST['usuario_estado'];
                            $result = $this->usuario->guardar_usuario($model);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
    public function guardar_edicion_usuario(){
        $usuario = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('id_rol_e', 'POST',true,$ok_data,11,'numero',0);
            $ok_data = $this->validar->validar_parametro('usuario_nickname_e', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_email_e', 'POST',false,$ok_data,60,'email',0);
            $ok_data = $this->validar->validar_parametro('usuario_imagen_e', 'FILES',false,$ok_data,0,['jpg','png'],['jpg','png']);
            $ok_data = $this->validar->validar_parametro('usuario_estado_e', 'POST',true,$ok_data,1,'numero',0);
            $ok_data = $this->validar->validar_parametro('id_usuario', 'POST',false,$ok_data,11,'numero',0);
            if($ok_data){
                $model = new Usuario();
                if($this->usuario->validar_nickname_edicion(str_replace(" ", "",$_POST['usuario_nickname_e']), $_POST['id_usuario'])){
                    $result = 3;
                    $message = "Ya existe un usuario con este nickname registrado";
                } else {
                    if($this->usuario->validar_correo_edicion($_POST['usuario_email_e'], $_POST['id_usuario'])){
                        $result = 4;
                        $message = "Ya existe un usuario con este correo registrado";
                    } else {
                        $usuario = $this->usuario->listar_usuario($_POST['id_usuario']);
                        $model->id_usuario = $_POST['id_usuario'];
                        $model->id_rol = $_POST['id_rol_e'];
                        $model->usuario_nickname = $_POST['usuario_nickname_e'];
                        $model->usuario_email = $_POST['usuario_email_e'];
                        if($_FILES['usuario_imagen_e']['name'] != null) {
                            $ext = pathinfo($_FILES['usuario_imagen_e']['name'], PATHINFO_EXTENSION);
                            $file_path = "media/usuarios/" . $usuario->id_persona . '_' .date('dmYHis') . "." . $ext;
                            if($this->archivo->subir_imagen_comprimida($_FILES['usuario_imagen_e']['tmp_name'], $file_path,false)){
                                $model->usuario_imagen = $file_path;
                            } else {
                                $model->usuario_imagen = $usuario->usuario_imagen;
                            }
                        } else {
                            $model->usuario_imagen = $usuario->usuario_imagen;
                        }
                        $model->usuario_estado = $_POST['usuario_estado_e'];
                        $result = $this->usuario->guardar_usuario($model);
                        if($result == 1){
                            $usuario = $this->usuario->listar_usuario($_POST['id_usuario']);
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
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "usuario" => $usuario)));
    }
    public function guardar_edicion_persona(){
        $persona = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('persona_nombre_e', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paterno_e', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_materno_e', 'POST',false,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_nacimiento_e', 'POST',false,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('persona_telefono_e', 'POST',true,$ok_data,15,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_persona', 'POST',true,$ok_data,11,'numero',0);
            if($ok_data){
                $model = new Usuario();
                $model->id_persona = $_POST['id_persona'];
                $model->persona_nombre = $_POST['persona_nombre_e'];
                $model->persona_apellido_paterno = $_POST['persona_apellido_paterno_e'];
                $model->persona_apellido_materno = $_POST['persona_apellido_materno_e'];
                $model->persona_nacimiento = $_POST['persona_nacimiento_e'];
                $model->persona_telefono = $_POST['persona_telefono_e'];
                $result = $this->usuario->guardar_persona($model);
                if($result == 1){
                    $persona = array(
                        "id_persona" => $_POST['id_persona'],
                        "persona_nombre" => $_POST['persona_nombre_e'],
                        "persona_apellido_paterno" => $_POST['persona_apellido_paterno_e'],
                        "persona_apellido_materno" => $_POST['persona_apellido_materno_e'],
                        "persona_nacimiento" => $_POST['persona_nacimiento_e'],
                        "persona_telefono" => $_POST['persona_telefono_e']
                    );
                }
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "persona" => $persona)));
    }
    public function restablecer_contrasenha(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('contrasenha', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('id_usuario', 'POST',true,$ok_data,11,'numero',0);
            if($ok_data){
                $result = $this->usuario->guardar_contrasenha($_POST['id_usuario'], password_hash($_POST['contrasenha'], PASSWORD_BCRYPT));
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
