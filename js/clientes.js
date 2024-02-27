function guardar_editar_clientes(){
    var valor = true;
    var boton = "btn-agregar-cliente";
    var id_cliente = $('#id_cliente').val();
    var cliente_nombre = $('#cliente_nombre').val();
    var id_cliente_documento = $('#id_cliente_documento').val();
    var cliente_numdocumento = $('#cliente_numdocumento').val();
    var cliente_telefono = $('#cliente_telefono').val();
    var cliente_direccion = $('#cliente_direccion').val();
    valor = validar_campo_vacio('cliente_nombre',cliente_nombre, valor);
    valor = validar_campo_vacio('id_cliente_documento',id_cliente_documento, valor);
    valor = validar_campo_vacio('cliente_numdocumento',cliente_numdocumento, valor);

    if(valor){
        var cadena = "cliente_nombre=" + cliente_nombre +
            "&cliente_telefono=" + cliente_telefono+
            "&id_cliente_documento=" + id_cliente_documento+
            "&cliente_numdocumento=" + cliente_numdocumento+
            "&cliente_direccion=" + cliente_direccion+
            "&id_cliente=" + id_cliente;
        $.ajax({
            type: "POST",
            url: urlweb + "api/Clientes/guardar_editar_clientes",
            data: cadena,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        if(id_cliente != ""){
                            respuesta('¡Cliente Editado Exitosamente', 'success');
                        } else {
                            respuesta('¡Cliente guardado! Recargando...', 'success');
                        }
                        setTimeout(function () { location.reload(); }, 1000);
                        break;
                    case 2:
                        respuesta('Error al guardar cliente', 'error');
                        break;
                    case 3:
                        respuesta('N° de documento ya registrado', 'error');
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
}
function editar_clientes(id_cliente){
    let guardarid = id_cliente;
    $.ajax({
        type: "POST",
        url: urlweb + "api/Clientes/edicion_clientes",
        data: {
            guardarid :guardarid
        },
        dataType: 'json'
    }).done(function(datos_editar){
        console.log(datos_editar);
        let almacenar = datos_editar.result.code;
        $("#id_cliente").val(guardarid);
        $('#cliente_nombre').val(almacenar.cliente_nombre);
        $('#id_cliente_documento').val(almacenar.id_cliente_documento);
        $('#cliente_numdocumento').val(almacenar.cliente_numdocumento);
        $('#cliente_telefono').val(almacenar.cliente_telefono);
        $('#cliente_direccion').val(almacenar.cliente_direccion);
    });
    function edicion(cliente_nombre, cliente_apellidos, cliente_dni, cliente_celular,cliente_email,cliente_genero){
    }

}
function limpiar_clientes(){
    $('#id_cliente').val('');
    $('#cliente_nombre').val('');
    $('#cliente_apellidos').val('');
    $('#cliente_numdocumento').val('');
    $('#cliente_celular').val('');
    $('#cliente_email').val('');
    $('#cliente_genero').val('');
}
function eliminar_cliente(id_cliente){
    $.ajax({
        type: "POST",
        url: urlweb + "api/Clientes/eliminar_cliente",
        data: {
            id : id_cliente
        },
        dataType: 'json',
        success:function (r) {
            switch (r.result.code) {
                case 1:
                    respuesta('¡Cliente eliminado! Recargando...', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    break;
                case 2:
                    respuesta('Error al borrar cliente', 'error');
                    break;
                default:
                    respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                    break;
            }
        }
    });
}