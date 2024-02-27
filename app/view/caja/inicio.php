<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card border-left-primary shadow h-100 py-2">
							<form method="post" enctype="multipart/form-data" id="gestionar_caja">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-12 d-flex justify-content-center">
											<h3><span id="estado_caja"></span></h3>
										</div>
									</div>
									<div class="row d-flex justify-content-center align-items-center">
										<div class="col-lg-1">
											<span style="font-size: 22px; font-weight: bold; color: #033E8C">S/. </span>
										</div>
										<div class="col-lg-3">
											<input name="monto_caja" id="monto_caja" type="text" class="form-control" placeholder="Ingrese cantidad">
										</div>
									</div>
									<div class="row mt-4">
										<div class="col-lg-12 d-flex justify-content-center">
											<button type="submit" class="btn btn-success" id="btn_estado_caja"><span id="estado_caja_boton"></span></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>caja.js"></script>
<script>
    var estadoCajaElement = document.getElementById('estado_caja');
    var estadoCajaBotonElement = document.getElementById('estado_caja_boton');
    var estadoCaja = <?= $estado_caja ?>;
    var datos_apertura = <?= json_encode($datos_apertura_caja); ?>;
    if (estadoCaja === 0) {
        estadoCajaElement.textContent = 'Caja cerrada';
        estadoCajaElement.style.color = '#F20505';
        estadoCajaBotonElement.textContent = 'Abrir caja';
        $(document).ready(function(){$("#monto_caja").show();});
        $(document).ready(function(){$("#hora_caja").show();});
        $(document).ready(function(){$("#fecha_caja").show();});
    } else if (estadoCaja === 1) {
        estadoCajaElement.textContent = 'Caja abierta';
        estadoCajaElement.style.color = '#38BF34';
        estadoCajaBotonElement.textContent = 'Cerrar caja';
        document.getElementById("monto_caja").readOnly = true;
        document.getElementById('monto_caja').value = datos_apertura.monto_caja;

        document.getElementById('btn_estado_caja').classList.remove('btn-success');
        document.getElementById('btn_estado_caja').classList.add('btn-danger');
    }
</script>