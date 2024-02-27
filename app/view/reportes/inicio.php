<form method="post" enctype="multipart/form-data" id="buscar_historial_filtro">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3>HISTORIAL DE VENTAS</h3>
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-3">
                                <label for="desde">Desde</label>
                                <input name="desde" id="desde" type="date" class="form-control mt-2" value="<?= $fecha_hoy ?>">
                            </div>
                            <div class="col-lg-3">
                                <label for="hasta">Hasta</label>
                                <input type="date" name="hasta" id="hasta" class="form-control mt-2" value="<?= $fecha_hoy ?>">
                            </div>
                            <div class="col-lg-2 mt-4">
                                <button type="submit" id="btn_buscar" name="btn_buscar" class="form-control btn-success"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                        </form>
                        <div class="table mt-5">
                            <table class="table table-striped">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th>Detalle</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>Modo de pago</th>
                                </tr>
                                </thead>
                                <tbody id="cuerpo_tabla">
								<?php
                                if(count($ventas)>0){
									$contador = 1;
									foreach ($ventas as $v){
										?>
                                        <tr>
                                            <td><?= $contador ?></td>
                                            <td>Se realizó una venta el </td>
                                            <td><?= $v->venta_fecha ?></td>
                                            <td>al cliente <?= $v->cliente_nombre ?></td>
                                            <td>monto de <?= $v->venta_total ?></td>
                                            <td>pagó con <?= $v->tipo_pago_nombre ?></td>
                                        </tr>
										<?php
										$contador++;
									}
                                }else{
									?>
                                    <tr>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                    </tr>
									<?php
                                }
								?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>reportes.js"></script>