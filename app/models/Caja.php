<?php
class Caja
{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function traer_estado_caja($fecha_hoy){
        try{
            $sql = 'select * from caja where fecha_caja = ? and monto_caja_cierre is null';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function datos_disponibles_x_dia($fecha_hoy){
        try{
            $sql = 'select * from caja where fecha_caja = ? and monto_caja_cierre is null';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_hoy]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
}