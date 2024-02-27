$("#buscar_historial_filtro").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = "btn_buscar";
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    valor = validar_campo_vacio('desde', desde, valor);
    valor = validar_campo_vacio('hasta', hasta, valor);
    if(valor){
        if(desde<=hasta){
            valor = true;
        }else{
            respuesta('Fechas incorrectas','error')
            valor = false;
        }
    }
    if(valor){
        $.ajax({
            type: "POST",
            url: urlweb + "api/Reportes/traer_datos_filtro",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Buscando...', true);
            },
        }).done(function (r){
            cambiar_estado_boton(boton, "<i class=\"fa fa-search fa-sm text-white-50\"></i> Buscar", false);
            let datos = r;
            let body = '';
            console.log(datos);
            if(datos.length > 0){
                respuesta('Datos encontrados', 'success')
                let contador = 1;
                datos.map(function(el,index){
                    body +=
                        `
                            <tr>
                                <td>${contador}</td>
                                <td>Se realizó una venta el</td>
                                <td>${el.venta_fecha}</td>
                                <td>al cliente ${el.cliente_nombre}</td>
                                <td>monto de ${el.venta_monto}</td>
                                <td>pagó con ${el.tipo_pago_nombre}</td>
                            </tr>
                        `
                    contador++;
                })
            }else{
                respuesta('Datos no encontrados', 'error')
                body = `

                `;
            }
            $('#cuerpo_tabla').html(body);
        });
    }
});
