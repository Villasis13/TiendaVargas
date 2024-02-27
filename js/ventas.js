let array_productos = [];
let cal_datos_result = [];
function buscar_productos_comprar(){
    let valor = $('#productos_comprar').val()
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/listar_productos_comprar",
        data: {
            valor:valor
        },
    }).done(function (r){
        let datos = JSON.parse(r);
        let body = `<ul style="
                list-style: none;
                position: absolute;
                z-index: 999;
                background: #ffffff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                width: 310px;
                margin: 0;
                padding: 0;
                left: 3.5%">`
        if (datos.length > 0){
            datos.map(function (el,index){
                body+=
                    `
                     <li class="producto-sugerido"  onselect="" onclick="traerdatos_producto(${el.id_producto},'${el.producto_nombre}','${el.producto_stock}','${el.producto_precio}',${el.id_tipo_afectacion}, ${el.productos_impuesto_bolsa})">${el.producto_nombre}</li>
                     `
            })
        }else{
            body+=
                `<li class="sin-resultados">Sin resultados</li>`
        }
        body += `</ul>`
        $('#lista_productos_comprar').html(body)

        const style = document.createElement('style');
        style.innerHTML = `
            .producto-sugerido {
                padding: 5px;
                cursor: pointer;
            }
            
            .producto-sugerido:hover {
                background-color: #4451B6;
                color: #fff;
            }

            .sin-resultados {
                padding: 10px;
                color: #888;
            }
        `;
        document.head.appendChild(style);

    });
}
function traerdatos_producto(id_producto,producto_nombre, producto_stock, producto_precio, id_tipo_afectacion, productos_impuesto_bolsa){
    $('#lista_productos_comprar').html('')
    $('#productos_comprar').val('')

    // Buscar si el id_producto ya existe en el array
    const existeProducto = array_productos.some(producto => producto.id === id_producto);

    if (existeProducto) {
        respuesta('Ya se encuentra el producto en la lista', 'error');
        return;
    }

    let options = {
        id: id_producto,
        nombre: producto_nombre,
        stock: producto_stock,
        precio_unitario: producto_precio,
        subtotal: producto_precio,
        vender_cantidad: 1,
        id_tipo_afectacion: id_tipo_afectacion,
        productos_impuesto_bolsa: productos_impuesto_bolsa,
    }
    array_productos.push(options);
    llenar_tabla();
}
function llenar_tabla(){
    let body = ""
    if(array_productos.length > 0){
        array_productos.map(function (el,index){
            body += `
            <tr>
                <td class="nombre-producto">${el.nombre}</td>
                <td class="stock-producto">${el.stock}</td>
                <td>
                    <div class="input-group">
                        <input id="inputCantidad${index}" name="inputCantidad${index}" style="width: 2px !important;" type="number" class="form-control input-number" value="${el.vender_cantidad}" min="1" onchange="actualizar_cantidad(${index},${el.stock}); actualizar_subtotal(${index})">
                    </div>
                </td> 
                <td class="precio-unitario" id="precio_unitario${index}">${el.precio_unitario}</td>
                <td class="precio-total" id="precio_subtotal${index}">${el.subtotal}</td>
                <td>
                    <a class="bg-danger btn btn-sm text-white" onclick="accion_eliminar(${index})"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            `
        })
    }
    $('#tabla_vender').html(body)
    calcular_afectacion();
}
function actualizar_cantidad(index,stock){
    let cantidad = $('#inputCantidad'+index).val();

    if(cantidad <= stock){
        array_productos[index].vender_cantidad = cantidad;
    }else{
        $('#inputCantidad'+index).val(1);
        respuesta('La cantidad no debe ser mayor al stock','error');
    }
}
function accion_eliminar(index) {
    array_productos.splice(index,1)
    llenar_tabla()
}
function vaciar_listado(index) {
    array_productos=[];
    llenar_tabla()
}
function Consultar_serie_(){
    let  tipo_venta =  $("#tipo_comprobante").val();
    let vll = 0;
    if(tipo_venta == "01"){
        $("#id_tipo_documento").val('4');
        $("#id_tipo_documento__").attr('disabled',true);
        $("#id_tipo_documento__").val(4);
        $("#numero_documento").val('');
        $("#nombre_cliente").val('');
        $("#nombre_tipo_documento").html("Razon Social");
    }else if(tipo_venta == "03"){
        vll = $('#id_tipo_documento__').val();
        if (vll == 4){
            $('#id_tipo_documento__').val(2);
            $('#id_tipo_documento').val(2);
        }
        $("#id_tipo_documento__").attr('disabled',false);
        $("#numero_documento").val('11111111');
        $("#nombre_cliente").val('ANONIMO');
        $("#nombre_tipo_documento").html("Nombre");
    }
    let  concepto = "LISTAR_SERIE";
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/consultar_serie",
        data: {
            concepto:concepto,
            tipo_venta:tipo_venta
        },
        dataType: 'json',
        success:function (r) {
            let body = "";
            let serie = r;
            console.log(serie);
            body +=
                `
                <option value="${serie.id_serie}">${serie.serie}</option>
                `
            $("#serie").html(body);
            ConsultarCorrelativo__();
        }
    });
}
function calcular_afectacion(){
    let total_pago_cliente;
    let pago_cliente = $('#efectivo_recibido').val()
    total_pago_cliente = parseFloat(pago_cliente);

    let vuelto = 0.00;
    let op_exonerada = 0.00
    let op_gratuitas = 0.00
    let sumar_total = 0.00;
    let sumar_igv = 0.00;
    let sumar_exo = 0.00;
    let sumar_ina = 0.00;
    let sumar_gratuitas = 0.00;
    let total = 0.00;
    let v = 0.00;
    let igv = 0.00;
    let v2 = 0.00;
    let v3 = 0.00;
    let v4 = 0.00;
    let v5= 0.00;
    let v6= 0.00;
    let v7= 0.00;
    let impuesto_bolsa = 0.00;
    if(array_productos.length > 0){
        array_productos.map(function(el, index) {
            let precio_final;
            precio_final = parseFloat(el.precio_unitario);
            if(el.id_tipo_afectacion == 1){
                v += precio_final * 1;
                let menosC = precio_final * el.producto_procentaje_igv;
                sumar_igv += (menosC * el.vender_cantidad);
                v3 += ((precio_final - menosC) *  el.vender_cantidad);

            }else if(el.id_tipo_afectacion == 2){
                sumar_exo += parseFloat((precio_final * parseInt(el.vender_cantidad)).toFixed(2));
                if (el.productos_impuesto_bolsa == 1){
                    impuesto_bolsa+= el.cantidad * 0.50;
                }
            }else if(el.id_tipo_afectacion == 3){
                sumar_ina += (precio_final * 1) * el.vender_cantidad;
                v5 += sumar_ina.toFixed(2)
            }else if( el.id_tipo_afectacion == 4){
                sumar_gratuitas += (precio_final * 1) * el.vender_cantidad;
                v6 += sumar_gratuitas.toFixed(2);
            }
        });
        total = parseFloat(v3)  + parseFloat(v4)+  parseFloat(v5)  + parseFloat(sumar_igv) + parseFloat(impuesto_bolsa) ;
        v7 = total.toFixed(2);
        vuelto = total_pago_cliente -  sumar_exo
        $('#op_exoneradas').html(sumar_exo);
        $('#op_gratuitas').html(v6);
        $('#icbper').html(impuesto_bolsa);
        $('#total_venta_').html(sumar_exo);
        $('#total_venta').html(sumar_exo);
        $('#monto_total_venta').html(v7);
        $('#calcular_monto_total_').val(v7);
        $('#vuelto_').html(vuelto);
    }else{
        $('#op_exoneradas').html("00.00");
        $('#op_gratuitas').html("00.00");
        $('#total_venta_').html("00.00");
        $('#total_venta').html("00.00");
        $('#op_inafectada').html("00.00");
        $('#op_gravada').html("00.00");
        $('#icbper').html("00.00");
        $('#totaligv').html("00.00");
        $('#vuelto_').html("00.00");
        $('#vali_partir_total').val(0);
        $('#monto_total_venta').html("00.00");
        $('#calcular_monto_total_').val(0);
    }
    let obj = {
        op_exo : sumar_exo,
        op_gratu: v6,
        op_inafec:v5,
        op_grava:v3.toFixed(2),
        icbper:impuesto_bolsa,
        total_igv:sumar_igv.toFixed(2),
        total:v7,
        vuelto:vuelto,
        pago_cliente:total_pago_cliente
    }
    cal_datos_result = obj
}
function ConsultarCorrelativo__(){
    let id_serie =  $("#serie").val();
    let concepto = "LISTAR_NUMERO";
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/consultar_serie",
        data: {
            id_serie:id_serie,
            concepto:concepto
        },
        dataType: 'json',
        success:function (r) {
            $("#numero_venta").val(r);
        }
    });
}
function consultarCliente(){
    let num_doc = $('#numero_documento').val();
    $.ajax({
        type: "POST",
        url: urlweb + "api/Ventas/consultar_cliente",
        data: {
            num_doc:num_doc
        },
        dataType: 'json',
        success:function (r) {
            let cliente = r;
            console.log(cliente);
            if(cliente){
                respuesta('Cliente encontrado!','success')
                $('#nombre_cliente').val(cliente.cliente_nombre);
                $('#direccion_cliente').val(cliente.cliente_direccion);
            }else{
                consultarNumdocumento('id_tipo_documento','numero_documento','nombre_cliente','direccion_cliente');
            }
        }
    });
}
function cantidad_pagada(){
    var efectivoRecibido = document.getElementById("efectivo_recibido").value;
    document.getElementById("pago_con_cliente").textContent = efectivoRecibido;
}
function validar_vuelto(){
    var efectivoRecibido = document.getElementById("efectivo_recibido").value;
    var total_venta = parseFloat(document.getElementById("total_venta").textContent || 0);
    if(efectivoRecibido < total_venta){
        document.getElementById("efectivo_recibido").value = '';
        document.getElementById("vuelto_").textContent = '';
        respuesta("El efectivo debe ser mayor al total de venta!", "error");
    }
}
function actualizar_subtotal(index) {
    var inputCantidad = document.getElementById(`inputCantidad${index}`).value;
    var precio_unitario = document.getElementById(`precio_unitario${index}`).textContent;
    var subtotal = parseFloat(inputCantidad) * parseFloat(precio_unitario);
    document.getElementById(`precio_subtotal${index}`).textContent = subtotal.toFixed(2);
    calcular_afectacion();
}

$("#formulario_realizar_venta").on('submit', function(e){
    e.preventDefault()
    // DATOS DE VENTA
    var valor = true;
    var boton = "btn_realizar_venta";
    var id_venta = $("#id_venta").val();
    var tipo_comprobante = $("#tipo_comprobante").val();
    var modo_pago = $("#modo_pago").val();
    var serie = $("#serie").val();
    var numero_venta = $("#numero_venta").val();
    var efectivo_recibido = $("#efectivo_recibido").val();

    // CLIENTE INFORMACIÓN
    var id_tipo_documento = $("#id_tipo_documento").val();
    var numero_documento = $("#numero_documento").val();
    var nombre_cliente = $("#nombre_cliente").val();
    var telefono_cliente = $("#telefono_cliente").val();
    var direccion_cliente = $("#direccion_cliente").val();

    valor = validar_campo_vacio('tipo_comprobante',tipo_comprobante, valor);
    valor = validar_campo_vacio('modo_pago',modo_pago, valor);
    valor = validar_campo_vacio('serie',serie, valor);
    valor = validar_campo_vacio('numero_venta',numero_venta, valor);
    valor = validar_campo_vacio('efectivo_recibido',efectivo_recibido, valor);
    valor = validar_campo_vacio('id_tipo_documento',id_tipo_documento, valor);
    valor = validar_campo_vacio('numero_documento',numero_documento, valor);
    valor = validar_campo_vacio('nombre_cliente',nombre_cliente, valor);

    let productos_array = new FormData(this);
    productos_array.append('array_productos' , JSON.stringify(array_productos));
    productos_array.append('cal_datos_result' , JSON.stringify(cal_datos_result))
    if(valor){
        $.ajax({
            type: "POST",
            url: urlweb + "api/Ventas/guardar_realizar_venta",
            data:productos_array,
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Vendiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Realizar Venta", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Venta Realizada! Recargando...', 'success');
                        setTimeout(function () {
                            window.open(urlweb + 'Ventas/detalle_venta/' + r.result.id_venta, '_self');
                        }, 1000);
                        break;
                    case 2:
                        respuesta('Error al realizar venta', 'error');
                        break;
                    case 3:
                        respuesta('Es necesario que proceda a abrir la caja', 'error');
                        break;
                    case 4:
                        respuesta('Antes debe escoger un producto', 'error');
                        break;
                    case 5:
                        respuesta('Error con datos del cliente', 'error');
                        break;
                    case 6:
                        respuesta('Venta no realizada', 'error');
                        break;
                    case 7:
                        respuesta('No se guardó detalle venta', 'error');
                        break;
                    case 8:
                        respuesta('No se restó stock', 'error');
                        break;
                    case 9:
                        respuesta('No se sumó venta a la caja', 'error');
                        break;
                    case 10:
                        respuesta('Correlativo no actualizado', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
})
function consultarNumdocumento(DocumentType, idValue,customerName = null , customerAddress= null,clientStatus = null,nombreVENTAWEB = null){
    // nombreVENTAWEB se agrego nomas para que funcione en la pagina web
    let tipoDocumento= "";
    let valorNum ="";
    let tipoRespuesta ="";
    if(DocumentType){
        tipoDocumento = $('#'+DocumentType).val();
    }
    if(idValue){
        valorNum = $('#'+idValue).val();
    }
    $('#'+clientStatus).html("");
    // verificamos que tipo de documento es
    respuesta('Buscando....', 'info');

    if(tipoDocumento == 4){
        if(valorNum.length == 11){
            if (!isNaN(valorNum)){
                if(valorNum=="00000000000"){
                    respuesta('Proveedor Extranjero', 'success');
                    tipoRespuesta = "text-success";
                    $('#'+clientStatus).html("HABIDO");
                }else{
                    var formData = new FormData();
                    formData.append("token", "A5UB9oaNM7VPs4NgZsPfZXu9SAzxmPI5Yyvzo5B5b5i2NQn5KruzvMXus4Ma");
                    formData.append("ruc", valorNum);
                    var request = new XMLHttpRequest();
                    request.open("POST", "https://api.migo.pe/api/v1/ruc");
                    request.setRequestHeader("Accept", "application/json");
                    request.send(formData);
                    $('.loader').show();
                    request.onload = function() {
                        var data = JSON.parse(this.response);
                        if(data.success){
                            $('.loader').hide();
                            respuesta('Datos Encontrados', 'success');
                            if(data.condicion_de_domicilio=="NO HABIDO"){
                                respuesta('Este ruc se encuentra como NO HABIDO.', 'error');
                                tipoRespuesta = "text-danger";
                            }else{
                                $('#'+customerName).val(data.nombre_o_razon_social);
                                $('#'+customerAddress).val(data.direccion);
                                tipoRespuesta = "text-success";
                            }
                            $('#'+clientStatus).html(data.condicion_de_domicilio);
                            $('#'+clientStatus).addClass(tipoRespuesta);

                        }else{
                            $('.loader').hide();
                            respuesta(data.message, 'error');
                        }
                    };
                }
            }else{
                respuesta('El ruc debe contener solo números.', 'error');
                $('#'+clientStatus).html("");
            }
        }else{
            respuesta('El ruc debe contener 11 dígitos.', 'error');
            $('#'+clientStatus).html("");
        }
    }else{
        if(valorNum.length == 8){
            if (!isNaN(valorNum)){
                if(valorNum=="00000000"){
                    respuesta('CLIENTE GENERAL', 'success');
                    $('#'+clientStatus).html("HABIDO");
                }else{
                    var formData = new FormData();
                    formData.append("token", "A5UB9oaNM7VPs4NgZsPfZXu9SAzxmPI5Yyvzo5B5b5i2NQn5KruzvMXus4Ma");
                    formData.append("dni", valorNum);
                    var request = new XMLHttpRequest();
                    request.open("POST", "https://api.migo.pe/api/v1/dni");
                    request.setRequestHeader("Accept", "application/json");
                    request.send(formData);
                    $('.loader').show();
                    request.onload = function() {
                        var data = JSON.parse(this.response);
                        if(data.success){
                            $('.loader').hide();
                            tipoRespuesta = "text-success";
                            respuesta('Datos Encontrados', 'success');
                            $('#'+customerName).val(data.nombre);
                            if(customerAddress){
                                $('#'+customerAddress).val("");
                            }
                            // solo sirve para la web ya que ahi se tiene que visualizar en un card el nombre del cliente
                            // if(nombreVENTAWEB){
                            //     $('#'+nombreVENTAWEB).html('<i class="fa fa-user"></i> ' +data.nombre);
                            // }
                            $('#'+clientStatus).html("HABIDO");
                            $('#'+clientStatus).addClass(tipoRespuesta);
                        }else{
                            $('.loader').hide();
                            tipoRespuesta = "text-danger";
                            respuesta(data.message, 'error');
                            $('#'+clientStatus).addClass(tipoRespuesta);
                        }
                    };
                }
            }else{
                respuesta('El DNI debe contener solo números.', 'error');
                $('#'+clientStatus).html("");
            }
        }else{
            respuesta('El DNI debe contener 8 dígitos.', 'error');
            $('#'+clientStatus).html("");
        }
    }

    // if(customerAddress){
    //     direccionCliente = $('#'+customerAddress).val();
    // }




}