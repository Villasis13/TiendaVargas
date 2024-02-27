<!-- Modal Agregar-->
<div class="modal fade" id="gestionCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">AGREGAR/EDITAR CLIENTES</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="hidden" id="id_cliente" name="id_cliente">
                                        <label for="cliente_nombre" class="col-form-label">Nombre completo</label>
                                        <input class="form-control" type="text" id="cliente_nombre" name="cliente_nombre" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <label for="id_cliente_documento" class="col-form-label">Tipo documento</label>
                                        <select id="id_cliente_documento" name="id_cliente_documento" class="form-control">
											<?php
											foreach ($cliente_documento as $do) {
												?>
                                                <option value="<?= $do->id_cliente_documento ?>" <?= $do->id_cliente_documento == 2 ? "selected" : "" ?>><?= $do->clientedocumento_identidad ?></option>
												<?php
											}
											?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="cliente_numdocumento" class="col-form-label">N° de documento</label>
                                        <input class="form-control" type="text" id="cliente_numdocumento" name="cliente_numdocumento" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="cliente_telefono" class="col-form-label">Teléfono</label>
                                        <input class="form-control" type="text" id="cliente_telefono" name="cliente_telefono" maxlength="9" placeholder="Ingrese Información...">
                                    </div>
                                    <div class="col-lg-8">
                                        <label class="col-form-label" for="cliente_direccion">Dirección</label>
                                        <textarea class="form-control" id="cliente_direccion" name="cliente_direccion" placeholder="Ingrese información..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-agregar-cliente" onclick="guardar_editar_clientes()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--Contenido-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 style="border-bottom: 2px solid #3E438D; font-size: 18px; font-weight: 500;color: #3E438D">Lista de Clientes Registrados</h1>
                    <button onclick="limpiar_clientes()" style="float: right; position: relative;" data-toggle="modal" id="botonmodal"  data-target="#gestionCliente" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Nombre Completo</th>
                                <th>N° de documento</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $contodor_cliente = 1;
                            foreach ($clientes as $c){
                                ?>
                                <tr>
                                    <td><?=$contodor_cliente?></td>
                                    <td><?=$c->cliente_nombre?></td>
                                    <td><?=$c->cliente_numdocumento?></td>
                                    <td><?=$c->cliente_telefono?></td>
                                    <td><?=$c->cliente_direccion;?></td>
                                    <td>
                                        <a type="button" data-toggle="modal" data-target="#gestionCliente"  class="btn btn-sm btn-warning text-white" onclick="editar_clientes(<?= $c->id_cliente ?>)"><i class="fa fa-pencil"></i> Editar</a>
                                    </td>
                                </tr>
                                <?php
								$contodor_cliente++;
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
<script src="<?php echo _SERVER_ . _JS_;?>clientes.js"></script>