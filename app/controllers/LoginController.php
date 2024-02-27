<?php
class LoginController{
    private $log;
    private $sesion;
    private $encriptar;
    private $validar;
    public function __construct()
    {
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->encriptar = new Encriptar();
        $this->validar = new Validar();
    }
    public function inicio(){
        require _VIEW_PATH_ . 'login/inicio.php';
    }
    public function validar_sesion(){
        $usuario = [];
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,32,'texto',0);
            if($ok_data){
                $usuario = $this->sesion->consultar_usuario($_POST['usuario_nickname']);
                if(isset($usuario->id_usuario)){
                    if(password_verify($_POST['usuario_contrasenha'], $usuario->usuario_contrasenha)){
                        $this->sesion->ultimo_logueo($usuario->id_usuario);
                        if(isset($_POST['app']) && $_POST['app'] == true){
                            $usuario = array(
                                "c_u" => $usuario->id_usuario,
                                "c_p" => $usuario->id_persona,
                                "_n" => $usuario->usuario_nickname,
                                "u_e" => $usuario->usuario_email,
                                "u_i" => _SERVER_ . $usuario->usuario_imagen,
                                "p_n" => $usuario->persona_nombre,
                                "p_p" => $usuario->persona_apellido_paterno,
                                "p_m" => $usuario->persona_apellido_materno,
                                "ru" => $usuario->id_rol,
                                "rn" => $usuario->rol_nombre,
                                "tn" => $this->encriptar->encriptacion_triple($usuario->usuario_contrasenha, $usuario->id_usuario, $usuario->usuario_creacion)
                            );
                        } else {
                            if(isset($_POST['recordar']) && $_POST['recordar'] == "true"){
                                $this->sesion->generar_sesion($usuario, true);
                            } else {
                                $this->sesion->generar_sesion($usuario);
                            }
                        }
                        $result = 1;
                    } else {
                        $result = 3;
                        $message = "Usuario o contraseña incorrectos";
                    }
                } else {
                    $result = 3;
                    $message = "Usuario o contraseña incorrectos";
                }
            } else {
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        if(isset($_POST['app']) && $_POST['app'] == true){
            $data = array(
                "result" => array("code" => $result, "message" => $message),
                "data" => $usuario);
        } else {
            $data = array("result" => array("code" => $result, "message" => $message));
        }
        echo json_encode($data);
    }
}
