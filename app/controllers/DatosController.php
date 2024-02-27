<?php
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
class DatosController{
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
    public function guardar_contrasenha(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('contrasenha', 'POST',true,$ok_data,16,'texto',0);
            if($ok_data){
                $result = $this->usuario->guardar_contrasenha($this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_), password_hash($_POST['contrasenha'], PASSWORD_BCRYPT));
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
    public function guardar_usuario(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('usuario_nicknamep', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_emailp', 'POST',false,$ok_data,60,'email',0);
            $ok_data = $this->validar->validar_parametro('usuario_imagenp', 'FILES',false,$ok_data,0,['jpg','png'],['jpg','png']);
            if($ok_data){
                $model = new Usuario();
                if($this->usuario->validar_nickname_edicion(str_replace(" ", "",$_POST['usuario_nicknamep']), $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_))){
                    $result = 3;
                    $message = "Ya existe un usuario con este nickname registrado";
                } else {
                    if($this->usuario->validar_correo_edicion($_POST['usuario_emailp'], $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_))){
                        $result = 4;
                        $message = "Ya existe un usuario con este correo registrado";
                    } else {
                        $usuario = $this->usuario->listar_usuario($this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_));
                        $model->id_usuario = $usuario->id_usuario;
                        $model->id_rol = $usuario->id_rol;
                        $model->usuario_nickname = $_POST['usuario_nicknamep'];
                        $model->usuario_email = $_POST['usuario_emailp'];
                        if($_FILES['usuario_imagenp']['name'] != null) {
                            $ext = pathinfo($_FILES['usuario_imagenp']['name'], PATHINFO_EXTENSION);
                            $file_path = "media/usuarios/" . $usuario->id_persona . '_' .date('dmYHis') . "." . $ext;
                            if($this->archivo->subir_imagen_comprimida($_FILES['usuario_imagenp']['tmp_name'], $file_path,false)){
                                $model->usuario_imagen = $file_path;
                            } else {
                                $model->usuario_imagen = $usuario->usuario_imagen;
                            }
                        } else {
                            $model->usuario_imagen = $usuario->usuario_imagen;
                        }
                        $model->usuario_estado = $usuario->usuario_estado;
                        $result = $this->usuario->guardar_usuario($model);
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
    public function guardar_datos(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('persona_nombrep', 'POST',true,$ok_data,100,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_paternop', 'POST',true,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_apellido_maternop', 'POST',false,$ok_data,30,'texto',0);
            $ok_data = $this->validar->validar_parametro('persona_nacimientop', 'POST',false,$ok_data,100,'fecha','fecha');
            $ok_data = $this->validar->validar_parametro('persona_telefonop', 'POST',true,$ok_data,15,'texto',0);
            if($ok_data){
                $model = new Usuario();
                $model->id_persona = $this->encriptar->desencriptar($_SESSION['c_p'],_FULL_KEY_);
                $model->persona_nombre = $_POST['persona_nombrep'];
                $model->persona_apellido_paterno = $_POST['persona_apellido_paternop'];
                $model->persona_apellido_materno = $_POST['persona_apellido_maternop'];
                $model->persona_nacimiento = $_POST['persona_nacimientop'];
                $model->persona_telefono = $_POST['persona_telefonop'];
                $result = $this->usuario->guardar_persona($model);
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
