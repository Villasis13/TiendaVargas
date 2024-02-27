<div class="modal fade" id="gestionProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
<!--				<h4 class="modal-title" id="exampleModalLabel">Gestionar Producto</h4>-->
                <p class="modal-title w-100" id="exampleModalLabel" style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Gestionar Producto</p>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
            <form method="post" enctype="multipart/form-data" id="guardar_editar_productos">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <b class="text-primary">Información del Producto</b>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" id="id_producto" name="id_producto">
                                            <label for="producto_nombre" class="col-form-label">Nombre del producto</label>
                                            <input class="form-control" type="text" id="producto_nombre" name="producto_nombre" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="producto_stock" class="col-form-label">Stock</label>
                                            <input class="form-control" type="text" id="producto_stock" name="producto_stock" maxlength="100">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="producto_precio" class="col-form-label">Precio</label>
                                            <input class="form-control" type="text" id="producto_precio" name="producto_precio" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="id_medida" class="col-form-label">Unidad</label>
                                            <select class="form-control" name="id_medida" id="id_medida">
                                                <option value="">Escoger</option>
												<?php foreach ($medidas as $m){?>
                                                    <option value="<?= $m->id_medida ?>"><?= $m->nombre_medida?></option>
												<?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <b class="text-primary">Información Adicional</b>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <label for="id_tipo_afectacion" class="col-form-label">Tipo Afectación</label>
                                            <select class="form-control" name="id_tipo_afectacion" id="id_tipo_afectacion">
                                                <option value="">Escoger</option>
												<?php foreach ($tipo_afectacion as $ta){
													?>
                                                    <option value="<?= $ta->id_tipo_afectacion ?>" <?php if ($ta->id_tipo_afectacion == 2) echo "selected"; ?>>
														<?= $ta->descripcion ?>
                                                    </option>
													<?php
												}
												?>
                                            </select>
                                        </div>
                                        <div class="col-lg-5">
                                            <label for="productos_impuesto_bolsa" class="col-form-label">IMPUESTO BOLSA</label>
                                            <select class="form-control" name="productos_impuesto_bolsa" id="productos_impuesto_bolsa">
                                                <option value="0">NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: none" id="check_igv">
                                        <div class="row mt-2 d-flex">
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-3 align-items-center justify-content-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="0.10" type="radio" id="diez_check" name="check_grupo">
                                                    <label class="form-check-label" for="diez_check">10%</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 align-items-center justify-content-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="0.18" type="radio" id="dieciocho_check" name="check_grupo">
                                                    <label class="form-check-label" for="dieciocho_check">18%</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-agregar-producto"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
                    <p style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Lista de Productos Registrados</p>
					<button onclick="limpiar_productos()" style="float: right; position: relative;" data-toggle="modal" id="botonmodal"  data-target="#gestionProducto" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
							<thead class="text-capitalize">
							<tr>
								<th>#</th>
								<th>Nombre del producto</th>
								<th>Stock disponible</th>
								<th>Precio</th>
								<th>Opciones</th>
							</tr>
							</thead>
							<tbody>
							<?php
                            $contador = 1;
							foreach ($productos as $p){
								?>
								<tr>
                                    <td><?=$contador;?></td>

									<td>
										<?=$p->producto_nombre;?>
                                    </td>
                                    <td>
                                        <?=$p->producto_stock;?>
                                        <?=$p->nombre_medida;?>
                                    </td>
									<td>
                                        S/. <?=$p->producto_precio;?>
                                    </td>
									<td>
										<a type="button" data-toggle="modal" data-target="#gestionProducto"  class="btn btn-sm btn-warning text-white" onclick="editar_productos(<?= $p->id_producto?>)"><i class="fa fa-pencil"></i> Editar</a>
									</td>
								</tr>
								<?php
                                $contador++;
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
<script src="<?php echo _SERVER_ . _JS_;?>productos.js"></script>
<script>
    $(document).ready(function() {
        $('#dieciocho_check, #diez_check').change(function() {
            var otherCheckboxId = (this.id === 'dieciocho_check') ? 'diez_check' : 'dieciocho_check';
            $('#' + otherCheckboxId).prop('checked', false);
        });
    });

    $(document).ready(function() {
        $('#id_tipo_afectacion').change(function() {
            var id_tipo_afectacion = $(this).val();

            if (id_tipo_afectacion == 1) {
                $('#check_igv').show(500);
                $('#dieciocho_check').prop('checked', false);
                $('#diez_check').prop('checked', false);
            } else {
                $('#check_igv').hide(500);
                $('#dieciocho_check').prop('checked', false);
                $('#diez_check').prop('checked', false);
            }
        });

        $('#id_tipo_afectacion').trigger('change');
    });
</script>

