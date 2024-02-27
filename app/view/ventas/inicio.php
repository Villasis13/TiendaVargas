<div class="container">
    <form method="post" enctype="multipart/form-data" id="formulario_realizar_venta">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
<!--                        ADVERTENCIA ABRIR CAJA-->
                        <div class="row">
                            <?php
                            if(!$estado_caja){
                                ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="alert alert-danger" role="alert">
                                        Antes de continuar con la venta, es necesario que proceda a <a href="<?= _SERVER_ ?>caja/inicio" class="alert-link">abrir la caja</a>.
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <!--            PRODUCTOS-->
                            <div class="col-lg-8">
                                <div class="row d-flex align-items-center mb-3">
                                    <div class="col-lg-12">
                                        <p style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Productos</p>
                                        <label for="productos_comprar" class="text-primary mb-2"><i class="fa fa-search "></i>  Nombre de producto</label>
                                        <input class="form-control mt-2" id="productos_comprar" placeholder="Ingrese información...">
                                        <div class="" id="lista_productos_comprar"></div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-lg-6">
                                        <h3 class="mt-3">Total Venta: S/.<span id="total_venta">00.00</span></h3>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3 d-flex justify-content-center">
                                        <a style="background: #F20505" class="btn text-white" onclick="vaciar_listado()">Vaciar Listado</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-body">
                                            <div class="table">
                                                <table class="table table-striped">
                                                    <thead class="text-capitalize">
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Stock</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Total</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tabla_vender">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
<!--                            DATOS DE VENTA-->
                            <div class="col-lg-3">
                                <p style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Datos de venta</p>
                                <input type="hidden" id="id_venta" name="id_venta">
                                <div class="row d-flex align-items-center">
                                    <div class="col-lg-6">
                                        <label for="tipo_comprobante">Comprobante</label>
                                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control mt-2">
                                            <option value="03">Boleta</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="modo_pago">Tipo Pago</label>
                                        <select class="form-control mt-2" id="modo_pago" name="modo_pago" >
											<?php foreach ($modo_pago as $g){?>
                                                <option value="<?= $g->id_tipo_pago ?>"><?= $g->tipo_pago_nombre?></option>
											<?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="serie" class="mt-3">Serie</label>
                                        <select id="serie" name="serie" class="form-control">
                                        </select>
<!--                                        <input id="serie" name="serie" class="form-control" readonly value="">-->
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="numero_venta" class="mt-3">N° Venta</label>
                                        <input id="numero_venta" name="numero_venta" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-5">
                                        <label for="efectivo_recibido" class="mt-3">Efectivo recibido</label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input name="efectivo_recibido" class="form-control mt-2" id="efectivo_recibido" onblur="validar_vuelto()" oninput="cantidad_pagada();calcular_afectacion()" onkeyup="validar_numeros(this.id)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <!--                            CLIENTE INFORMACIÓN-->
                            <div class="col-lg-12">
                                <p style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Cliente</p>
                                <div class="row d-flex align-items-center">
                                    <div class="col-lg-3">
                                        <label for="id_tipo_documento">Tipo Documento</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <select id="id_tipo_documento__" name="id_tipo_documento__" class="form-control">
											<?php
											foreach ($cliente_documento as $do) {
												?>
                                                <option value="<?= $do->id_cliente_documento ?>" <?= $do->id_cliente_documento == 2 ? "selected" : "" ?>><?= $do->clientedocumento_identidad ?></option>
												<?php
											}
											?>
                                        </select>
                                        <input type="hidden" name="id_tipo_documento" id="id_tipo_documento" value="2">
                                    </div>
                                    <div class="col-lg-1">
                                        <label for="numero_documento">DNI</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="numero_documento" name="numero_documento" type="text" class="form-control" onblur="consultarCliente()">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center mt-3">
                                    <div class="col-lg-2">
                                        <label for="nombre_cliente" id="nombre_tipo_documento">Nombre</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" value="ANONIMO"  class="form-control " id="nombre_cliente" name="nombre_cliente">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="telefono_cliente">Teléfono</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="telefono_cliente" name="telefono_cliente" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center mt-3">
                                    <div class="col-lg-12">
                                        <textarea class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Dirección"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            DETALLE COMPRA-->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Detalle de cuenta</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="p-0">
                                    <li class="d-flex pb-1">
                                        <small class="d-block mb-1" style="color: #a1acb8 !important;opacity: 1">Operaciones</small>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Exoneradas</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_exoneradas">00.00</h6>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Op. Gratuitas</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="op_gratuitas">00.00</h6>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">ICBPER</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="icbper">00.00</h6>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>



                                    <li class="d-flex mb-2 pb-1"  id="cantidad_en_cuotas" style="display: none!important;">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <input type="hidden" name="venta_total_ver" id="venta_total_ver">
                                                <h6 class="mb-0">Monto por cuota</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="monto_cuota_a_pagaar">00.00</h6>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Pagó con</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="pago_con_cliente">00.00</h6>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Vuelto</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0 color_negro" id="vuelto_">00.00</h6>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-2 pb-1">
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h4 class="mb-0 text-danger">TOTAL</h4>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h5 class="mb-0 text-danger" id="total_venta_">00.00</h5>
                                                <span class="text-muted">Soles</span>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="d-flex mb-2 pb-1 mt-5">
                                        <button style="background: #38BF34" class="btn text-white w-100" id="btn_realizar_venta">Realizar Venta</button>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>ventas.js"></script>

<script>
    $(document).ready(function(){
        Consultar_serie_()
    });
    let agg_producto = document.getElementById('productos_comprar');

    if(agg_producto && agg_producto.addEventListener){
        agg_producto.addEventListener('keyup',function (){
            buscar_productos_comprar()
        });
    }


    let id_tipo_documento__ = document.getElementById('id_tipo_documento__');
    if(id_tipo_documento__ && id_tipo_documento__.addEventListener) {
        id_tipo_documento__.addEventListener('change', function () {
            cambiar_tipo_comprobante(this.id)
        });
    }

    function cambiar_tipo_comprobante(id){
        let valor = $('#'+id).val();
        if(valor == 4 ){
            $('#tipo_comprobante').val('01');
        }else{
            $('#tipo_comprobante').val('03');
        }
        $('#id_tipo_documento').val(valor);
        Consultar_serie_();
    }

</script>