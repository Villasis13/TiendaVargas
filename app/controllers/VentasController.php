<?php
require 'app/models/Ventas.php';
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Archivo.php';
require 'app/models/Builder.php';
require 'app/models/Caja.php';
require 'app/models/Nmletras.php';
class VentasController
{
    private $usuario;
    private $numLetra;
    private $caja;
    private $rol;
    private $archivo;
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $ventas;
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
        $this->ventas = new Ventas();
        $this->builder = new Builder();
        $this->caja = new Caja();
        $this->numLetra = new Nmletras();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
//			$tipo_documento = $this->ventas->tipo_documento();
			$modo_pago = $this->ventas->tipo_pago();
			$clientes = $this->ventas->clientes();
			$cliente_documento = $this->ventas->listar_document();
			$estado_caja = $this->caja->traer_estado_caja(date('Y-m-d'));
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'ventas/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
    public function listar_productos_comprar(){
        try{
            $valor =  $_POST['valor'];
            $result = $this->ventas->listar_productos_comprar($valor);
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode($result);
    }
    public function consultar_serie(){
        try{
			$result = 2;
			$concepto =  $_POST['concepto'];
			if($concepto == "LISTAR_SERIE"){
				$result = $this->ventas->listar_serie($_POST['tipo_venta']);
			}else if($concepto == "LISTAR_NUMERO"){
				$result = $this->ventas->listar_correlativo($_POST['id_serie'])->correlativo;
			}
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode($result);
    }
    public function consultar_cliente(){
        try{
			$result = $this->ventas->consultar_cliente_x_numdocumento($_POST['num_doc']);
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        echo json_encode($result);
    }
	public function guardar_realizar_venta(){
		try{
			$result = 2;
			$estado_caja = $this->caja->traer_estado_caja(date('Y-m-d'));
//			VERIFICO EL ESTADO CAJA
			if($estado_caja){
				$array_productos = json_decode($_POST['array_productos']);
				$cal_datos_result = json_decode($_POST['cal_datos_result']);
				if(count($array_productos)>0){
//					VERIFICO SI CREO O LLAMO AL CLIENTE
					$cliente = $this->ventas->consultar_cliente_x_numdocumento($_POST['numero_documento']);
					if(!$cliente){
						$microtime_cliente = microtime(true);
						$result = $this->builder->save("clientes",array("id_cliente_documento" => $_POST['id_tipo_documento'], "cliente_nombre" => $_POST['nombre_cliente'], "cliente_numdocumento" => $_POST['numero_documento'], "cliente_direccion" => $_POST['direccion_cliente'], "cliente_telefono" => $_POST['telefono_cliente'], "cliente_microtime" => $microtime_cliente));
						$cliente = $this->ventas->ultimo_cliente($microtime_cliente);
					}
//					CALCULO TOTAL VENTA
					if((!$cliente && $result == 1) || $cliente){
						$total_venta=0;
						foreach ($array_productos as $p){
							$total_venta += $p->subtotal;
						}
//						GUARDO VENTA
						$microtime_ventas = microtime(true);
						$result = $this->builder->save("ventas", array('id_cliente' => $cliente->id_cliente, 'id_tipo_pago' => $_POST['modo_pago'], 'venta_serie' => $_POST['serie'], 'venta_correlativo' => $_POST['numero_venta'], 'venta_total' => $total_venta, 'venta_pago_cliente' => $_POST['efectivo_recibido'], 'venta_vuelto' => $cal_datos_result->vuelto, 'venta_fecha' => date('Y-m-d H:i:s'), 'venta_codigo' => $microtime_ventas, 'created_at' => date('Y-m-d H:i:s'),));
//						GUARDO DETALLE VENTA
						if($result == 1){
							$id_venta = $this->ventas->ultimo_id_venta($microtime_ventas)->id_venta;
							foreach ($array_productos as $c) {
								$result = $this->builder->save("ventas_detalle", array('id_venta' => $id_venta, 'id_producto ' => $c->id, 'venta_detalle_precio_unitario' => $c->precio_unitario, 'venta_detalle_nombre_producto' => $c->nombre, 'venta_detalle_cantidad' => $c->vender_cantidad, 'venta_detalle_valor_total' => $total_venta, 'created_at' => date('Y-m-d H:i:s')));
							}
//							RESTO STOCK DE LOS PRODUCTOS VENDIDOS
							if($result == 1){
								foreach ($array_productos as $c) {
									$result = $this->builder->update("productos", array('id_producto' => $c->id, 'producto_stock'=>$c->stock-$c->vender_cantidad,), array("id_producto" => $c->id,));
								}
								if($result == 1){
//									SUMO TOTAL A LA CAJA
									$result = $this->builder->update("caja", array('monto_caja' => $estado_caja->monto_caja+$total_venta), array("id_caja" => $estado_caja->id_caja));
									if($result == 1){
										$correlativo = $this->ventas->listar_ultimo_correlativo($_POST['serie']);
										$result = $this->builder->update("serie", array('correlativo' => $correlativo->correlativo+1), array('serie' => $correlativo->id_serie));
										if($result == 1){
											$id_venta_ = $id_venta;
										}else{
											$result = 10;
										}
									}else{
										$result = 9;
									}
								}else{
									$result = 8;
								}
							}else{
								$result = 7;
							}
						}else{
							$result = 6;
						}
					}else{
						$result = 5;
					}
				}else{
					$result = 4;
				}
			}else{
				$result = 3;
			}
		}catch(Exception $e) {
			$this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
			$message = $e->getMessage();
		}
		echo json_encode(array("result" => array("code" => $result, "id_venta" => $id_venta_)));
	}
	public function imprimir_pdf(){
		try{
			$id_venta = $_GET['id'];
			$datos_venta = $this->ventas->listar_datos_venta($id_venta);
			$datos_empresa = $this->ventas->listar_datos_empresa();
			$datos_detalle_venta = $this->ventas->listar_datos_detalle_venta($id_venta);
			$tipo_comprobante = "BOLETA DE VENTA ELECTRONICA";
			$serie_correlativo = $datos_venta->venta_serie."-".$datos_venta->venta_correlativo;
			$documento = "DNI: $datos_venta->cliente_numdocumento";
			$importe_letra = $this->numLetra->num2letras(intval($datos_venta->venta_total));
			$arrayImporte = explode(".", $datos_venta->venta_total);
			$montoLetras = $importe_letra . ' con ' . $arrayImporte[1] . '/100 ' . 'Soles';
			$dato_impresion = 'DATOS DE IMPRESIÓN:';
			require _VIEW_PATH_ . 'vista_pdf/inicio.php';
		}catch (Exception $e){
			$this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
			$message = $e->getMessage();
		}
	}
	public function detalle_venta(){
		try{
			$this->nav = new Navbar();
			$navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
			$id_venta = $_GET['id'];
			$datos_empresa = $this->ventas->listar_datos_empresa();
			$datos_venta = $this->ventas->listar_datos_venta($id_venta);
			$datos_detalle_venta = $this->ventas->listar_datos_detalle_venta($id_venta);
			require _VIEW_PATH_ . 'header.php';
			require _VIEW_PATH_ . 'navbar.php';
			require _VIEW_PATH_ . 'ventas/venta_detalle.php';
			require _VIEW_PATH_ . 'footer.php';
		}
		catch (Throwable $e){
			$this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
			echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
			echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
		}
	}
}