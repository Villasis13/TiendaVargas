<?php
class Ventas
{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }

    public function listar_productos_comprar($valor){
        try {
            $sql = 'SELECT * FROM productos WHERE producto_nombre LIKE ? AND producto_stock > 0';
            $stm = $this->pdo->prepare($sql);
            $valor = '%' . $valor . '%'; // Agregar los caracteres '%' antes y después del valor
            $stm->execute([$valor]);
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_serie($id){
        try{
            $sql = 'select * from serie where tipocomp = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function consultar_cliente_x_numdocumento($numdoc){
        try{
            $sql = 'select * from clientes where cliente_numdocumento = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$numdoc]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function ultimo_cliente($microtime){
        try{
            $sql = 'select * from clientes where cliente_microtime = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$microtime]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_correlativo($id){
        try{
            $sql = 'select correlativo from serie where id_serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function ultimo_id_venta($microtime_ventas){
        try {
            $sql = 'SELECT id_venta FROM ventas where venta_codigo = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$microtime_ventas]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function tipo_documento(){
        try {
            $sql = 'SELECT * FROM tipo_documento';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_datos_venta($id){
        try {
            $sql = 'SELECT * FROM ventas v
         			inner join tipo_pago tp on v.id_tipo_pago = tp.id_tipo_pago
         			inner join clientes c on v.id_cliente = c.id_cliente
         			where v.id_venta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_ultimo_correlativo($serie){
        try {
            $sql = 'SELECT * FROM serie where serie = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$serie]);
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_datos_empresa(){
        try {
            $sql = 'SELECT * FROM empresa';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_datos_detalle_venta($id){
        try {
            $sql = 'SELECT * FROM ventas_detalle where id_venta = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function tipo_pago(){
        try {
            $sql = 'SELECT * FROM tipo_pago';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function clientes(){
        try {
            $sql = 'SELECT * FROM clientes';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function listar_document(){
        try {
            $sql = 'SELECT * FROM cliente_documento';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
    public function ultimo_documento(){
        try {
            $sql = 'SELECT * FROM documento ORDER BY id_documento DESC LIMIT 1';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetch();
        } catch (Throwable $e) {
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }
}