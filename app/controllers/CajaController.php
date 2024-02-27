<?php
require 'app/models/Builder.php';
require 'app/models/Caja.php';
class CajaController
{
    private $encriptar;
    private $log;
    private $casa;
    private $builder;
    public function __construct()
    {
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->builder = new Builder();
        $this->caja = new Caja();
    }
    public function inicio(){
        try{
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
			$estado_caja = 0;
			$estado_caja_ = $this->caja->traer_estado_caja(date('Y-m-d'));
			if($estado_caja_){
				$estado_caja = 1;
				$datos_apertura_caja = $this->caja->datos_disponibles_x_dia(date('Y-m-d'));
			}else{
				$estado_caja = 0;
			}
			$fecha_caja = date('Y-m-d');
			$hora_caja = date('H:i:s');

            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'caja/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        }
        catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"". _SERVER_ ."\";</script>";
        }
    }
	public function abrir_caja(){
		try{
			$estado_caja_ = $this->caja->traer_estado_caja(date('Y-m-d'));
			$monto_caja = $_POST['monto_caja'];
			$id_caja = $estado_caja_->id_caja;
			if(!$estado_caja_){
				if($monto_caja != null){
					$result = $this->builder->save("caja",array('fecha_caja' => date("Y-m-d"), 'hora_caja'	=> date("H:i:s"), 'monto_caja' => $monto_caja, 'estado_caja' => 1));
				}else{
					$result = 2;
				}
			}else{
				$this->builder->update("caja",array('hora_caja_cierre'	=> date("H:i:s"), 'monto_caja_cierre' => $monto_caja, 'estado_caja' => 0), array('id_caja' => $id_caja));
				$result = 3;
			}
		} catch (Exception $e){
			$this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
			$message = $e->getMessage();
		}
		echo json_encode(array("result" => array("code" => $result, "message" => $message)));
	}
}