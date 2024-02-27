<style>
    .ancho_card_{
        height: 200px;
        width: 60%;
        border-radius: 24px;
        background: white;
        margin-top: -30px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
    .border_numero{
        position: absolute;
        width: 50px!important;
        height: 50px!important;
        background: #ecf0f6!important;
        border-radius: 50px!important;
        display: flex!important;
        justify-content: center!important;
        align-items: center;
        font-size: 20px!important;
        font-weight: 600;
        margin-left: -25px;
        bottom: 65px;
    }
</style>
<div class="modal fade" id="modalCorreoVenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Envío del comprobante por correo electrónico.</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormularioEnviarComprobanteEmail"  method="POST" enctype = "multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="correoDestino"><i class="fa-solid fa-envelope"></i> Correo de destino</label>
                            <input type="email" name="correoDestino" id="correoDestino" class="form-control" placeholder="Ingrese Información...">
                            <input type="hidden" name="id_venta" id="id_venta" class="form-control" value="{{$venta->id_venta}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="envirMensaje">Enviar <i class="fa-regular fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="row m-2">
                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
                        <p style="color: green; margin: 0px"><i class="fa fa-check-circle"></i> Pago Realizado Correctamente</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="row mt-5  mb-5" >
                    <div class="col-lg-1 col-md-12 col-sm-12"></div>
                    <div class="col-lg-5 col-md-12 col-sm-12 d-flex justify-content-center">
                        <div style="background: #ecf0f6;height: auto;border-radius: 24px;width: 80%;">
                            <div class="d-flex justify-content-center ">
                                <div class="ancho_card_" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;height: auto">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3" id="nombre_client_web" style="color: #3cb815">
                                                <i class="fa fa-user"></i > <?= $datos_venta->cliente_nombre?>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3" id="num_document_client_web" style="color: #3cb815">
                                                <i class="fa fa-credit-card-alt"></i > <?= $datos_venta->cliente_numdocumento;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 mt-1 mb-1">
                                        <div class="row "  >
                                            <div class="col-lg-12 d-flex align-items-center justify-content-center mt-1 mb-1">
                                                <h4>Tienda Vargas</h4>
                                            </div>
                                            <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                <label class="venta_titulo_tich">Numero de orden</label>
                                                <p style="margin: 0px"><b><?= $datos_venta->venta_serie. "-" .$datos_venta->venta_correlativo; ?></b></p>
                                            </div>
                                            <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                <label class="venta_titulo_tich">Moneda</label>
                                                <b class="cambiar_tipo_moneda_nombre">Soles</b>
                                            </div>
                                            <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                <label class="venta_titulo_tich">Fecha de Pago:</label>
                                                <b class="cambiar_tipo_moneda_nombre"><?= date("d-m-Y", strtotime($datos_venta->venta_fecha));?></b>
                                            </div>
                                            <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                <label class="venta_titulo_tich">Forma de Pago:</label>
                                                <b class="cambiar_tipo_moneda_nombre">EFECTIVO</b>
                                            </div>
                                            <div class="col-lg-12 d-flex align-items-center mt-2 mb-2">
                                                <label class="venta_titulo_tich">Productos :</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row h-auto" id="con_items_product">
											<?php $a = 0.00;
											foreach($datos_detalle_venta as $item){?>
                                                <div class="col-lg-12 d-flex align-items-center justify-content-between mt-1 mb-1">
                                                    <label class="venta_titulo_tich"><?=$item->venta_detalle_nombre_producto?></label>
                                                    <b><?=$item->venta_detalle_valor_unitario?> <b style="font-size: 11px">x <?=$item->venta_detalle_cantidad?></b></b>
                                                </div>
												<?php
												$a += $item->venta_detalle_cantidad * $item->venta_detalle_precio_unitario;
											}
											?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row" >
                                            <div class="col-lg-12 d-flex align-items-center justify-content-between mt-2 mb-2">
                                                <div class="redondos_ti"></div>
                                                <div class="fi"></div>
                                                <div class="redondos_ti_r"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row" >
                                            <div class="col-lg-7" style="flex-direction: column;display: flex;justify-content: center">
                                                <label class="venta_titulo_tich" >Monto Pagado</label>
                                                <div class="d-flex align-items-center">
                                                    <b class="me-1" style="font-size: 30px;color: #3cb815" id="total_cantidad__moneda"><?= $datos_venta->venta_pago_cliente ?></b>
                                                    <label class="venta_titulo_tich cambiar_tipo_moneda">Soles</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center justify-content-center flex-column">
                        <div class="w-100 mt-4 mb-3" style="background: #ecf0f6;border-radius: 24px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-4 col-sm-4">
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">OP. GRATUITA:</h6>
                                            <h5>S/. 00.00</h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">OP. INAFECTA:</h6>
                                            <h5>S/. 00.00</h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">OP. GRAVADA:</h6>
                                            <h5>S/. 00.00
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">OP. EXONERADA:</h6>
                                            <h5>S/. 00.00 </h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">OP. ICBPER:</h6>
                                            <h5>00.00</h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">PRECIO TOTAL:</h6>
                                            <h4 class="text-danger">S/. <?php echo number_format($datos_venta->venta_total ,2);?></h4>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">PAGÓ CON:</h6>
                                            <h5>S/. <?= number_format($datos_venta->venta_pago_cliente , 2);?></h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-3 mb-3">
                                            <h6 style="margin: 0px">VUELTO:</h6>
                                            <h5>S/. <?= number_format($datos_venta->venta_vuelto , 2);?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center flex-column w-100">
                            <a class="btn text-white bg-primary w-50 mb-2" href="<?= _SERVER_ ?>Ventas/imprimir_pdf/<?= $datos_venta->id_venta?>" target="_blank"><i class="fa-solid fa-file-pdf"></i> Imprimir en PDF</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12"></div>
                </div>
            </div>
        </div>
    </div>
</div>
