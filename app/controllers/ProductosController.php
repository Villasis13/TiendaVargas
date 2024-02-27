<?php
require 'app/models/Productos.php';
require 'app/models/Builder.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
class ProductosController
{
    private $usuario;
    private $rol;
    private $archivo;
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $productos;
    private $builder;
    public function __construct()
    {
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
        $this->productos = new Productos();
        $this->builder = new Builder();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
			$productos = $this->productos->todos_productos();
			$medidas = $this->productos->todas_medida();
			$tipo_afectacion = $this->productos->listar_tipo_afectacion();
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'productos/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
	public function guardar_editar_productos(){
		$result = 2;
		$message = 'OK';
		try{
			$ok_data = true;
			if($ok_data){
				$id = $_POST['id_producto'];
				if($id == null){
					$validar_nombre = $this->productos->validar_x_nombre($_POST['producto_nombre']);
					if(!$validar_nombre){
						if($_POST['check_grupo'] != null){
							$producto_valor_unit = $_POST['producto_precio'] - ($_POST['producto_precio']*$_POST['check_grupo']);
						}else{
							$producto_valor_unit = $_POST['producto_precio'];
						}
						$result = $this->builder->save("productos", array("id_medida" => $_POST['id_medida'], "id_tipo_afectacion" => $_POST['id_tipo_afectacion'], "producto_nombre" => $_POST['producto_nombre'], "producto_precio" => $_POST['producto_precio'], "producto_stock" => $_POST['producto_stock'], "fecha_creacion" => date('Y-m-d H:i:s'), "producto_procentaje_igv" => $_POST['check_grupo'], "producto_valor_unit" => $producto_valor_unit, "productos_microtime" => microtime(true), "productos_impuesto_bolsa" => $_POST['productos_impuesto_bolsa']));
					}else{
						$result = 3;
					}
				}else{
					$validar_nombre = $this->productos->validar_x_nombre($_POST['producto_nombre']);
					if($_POST['id_producto'] == $validar_nombre->id_producto){
						$datos_actualizar = $this->productos->microtime_x_id($id);
						if(!$datos_actualizar->productos_microtime){
							$micro = microtime(true);
						}else{
							$micro = $datos_actualizar->productos_microtime;
						}
						if($_POST['check_grupo'] != null){
							$producto_valor_unit = $_POST['producto_precio'] - $_POST['producto_precio']*$_POST['check_grupo'];
						}else{
							$producto_valor_unit = $_POST['producto_precio'];
						}
						$result = $this->builder->update("productos", array("id_medida" => $_POST['id_medida'], "id_tipo_afectacion" => $_POST['id_tipo_afectacion'], "producto_nombre" => $_POST['producto_nombre'], "producto_precio" => $_POST['producto_precio'], "producto_stock" => $_POST['producto_stock'], "fecha_creacion" => date('Y-m-d H:i:s'), "producto_procentaje_igv" => $_POST['check_grupo'], "producto_valor_unit" => $producto_valor_unit, "productos_microtime" => $micro, "productos_impuesto_bolsa" => $_POST['productos_impuesto_bolsa'],), array("id_producto" => $id));
					}else{
						$result = 3;
					}
				}
			}else {
				$result = 6;
				$message = "Integridad de datos fallida. Algún parametro se está enviando mal";
			}
		} catch (Exception $e){
			$this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
			$message = $e->getMessage();
		}
		echo json_encode(array("result" => array("code" => $result, "message" => $message)));
	}
	public function edicion_productos(){
		$ok_data = true;
		$result = 2;
		$message = 'OK';
		try{
			if($ok_data){
				$result = $this->productos->listar_x_id( $_POST['guardarid']);
			} else {
				$result = 6;
			}
		} catch (Exception $e){
			$this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
			$message = $e->getMessage();
		}
		echo json_encode(array("result" => array("code" => $result, "message" => $message)));
	}
    public function listar_productos_input(){
        try{
            $valor =  $_POST['valor'];
            $result = $this->productos->listar_productos_input($valor);
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode($result);
    }
}