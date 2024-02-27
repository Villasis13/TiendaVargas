<?php
class Reportes
{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function Ventas(){
        try{
            $sql = 'SELECT *
					FROM ventas v
					INNER JOIN clientes c ON v.id_cliente = c.id_cliente
					INNER JOIN tipo_pago tp ON v.id_tipo_pago = tp.id_tipo_pago
					WHERE DATE(v.venta_fecha) = CURDATE()
					ORDER BY c.id_cliente DESC';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function Compras(){
        try{
            $sql = 'select * from formato_ingreso fi inner join proveedor p on fi.id_proveedor = p.id_proveedor 
         			order by fi.fecha_ingreso desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function VentasPorRangoFecha($desde, $hasta){
        try{
            $sql = 'SELECT * FROM ventas v 
                    INNER JOIN clientes c ON v.id_cliente = c.id_cliente
                    INNER JOIN tipo_pago tp ON v.id_tipo_pago = tp.id_tipo_pago
                    WHERE v.venta_fecha BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 1 DAY) - INTERVAL 1 SECOND
                    ORDER BY v.id_venta DESC';
            $stm = $this->pdo->prepare($sql);
            $stm->bindParam(':desde', $desde);
            $stm->bindParam(':hasta', $hasta);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


}
