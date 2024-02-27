<?php
require 'app/models/Clientes.php';
require 'app/models/Builder.php';
require 'app/models/Ventas.php';
class ClientesController
{
    private $encriptar;
    private $ventas;
    private $log;
    private $clientes;
    private $builder;
    public function __construct()
    {
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->clientes = new Clientes();
        $this->builder = new Builder();
        $this->ventas = new Ventas();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
            $clientes = $this->clientes->todos_clientes();
			$cliente_documento = $this->ventas->listar_document();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'clientes/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function guardar_editar_clientes(){
        $result = 2;
        $message = 'OK';
        try{
            $ok_data = true;
            if($ok_data){
                $id = $_POST['id_cliente'];
                if($id == null){
                    $validar_dni = $this->clientes->validar_x_dni($_POST['cliente_dni']);
                    if($validar_dni){
                        $result = 3;
                    }else{
                        $result = $this->builder->save("clientes", array("id_cliente_documento" => $_POST['id_cliente_documento'], "cliente_nombre" => $_POST['cliente_nombre'], "cliente_numdocumento" => $_POST['cliente_numdocumento'], "cliente_direccion" => $_POST['cliente_direccion'], "cliente_telefono" => $_POST['cliente_telefono'], "cliente_microtime" => microtime(true)));
                    }
                }else{
                    $validar = $this->clientes->validar_x_id_nombre($_POST['cliente_numdocumento'],$id);
                    if($validar){
                        $result = 3;
                    }else{
                        $result = $this->builder->update("clientes", array("id_cliente_documento" => $_POST['id_cliente_documento'], "cliente_nombre" => $_POST['cliente_nombre'], "cliente_numdocumento" => $_POST['cliente_numdocumento'], "cliente_direccion" => $_POST['cliente_direccion'], "cliente_telefono" => $_POST['cliente_telefono'], "cliente_microtime" => microtime(true)),array("id_cliente" => $id));
                    }
                }
            }else {
                $result = 6;
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
    public function edicion_clientes(){
        $ok_data = true;
        $result = 2;
        $message = 'OK';
        try{
            if($ok_data){
                $id = $_POST['guardarid'];
                $result = $this->clientes->listar_x_id($id);
            } else {
                $result = 6;
            }
        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }
}