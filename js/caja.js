$("#gestionar_caja").on('submit', function(e){
    e.preventDefault();
    var valor = true;
    var boton = "btn_estado_caja";
    var id_caja = $('#id_caja').val();
    var monto_caja = $('#monto_caja').val();
    valor = validar_campo_vacio('monto_caja', monto_caja, valor);
    if(valor){
        $.ajax({
            type: "POST",
            url: urlweb + "api/Caja/abrir_caja",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'Guardando...', true);
            },
            success:function (r) {
                // cambiar_estado_boton(boton, "<i class=\"fa fa-save fa-sm text-white-50\"></i> Guardar", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Abriendo caja! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);

                        break;
                    case 2:
                        respuesta('Error al abrir caja', 'error');
                        break;
                    case 3:
                        respuesta('¡Cerrando caja! Recargando...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
});
// function cerrar_caja(dependiente){
//     if(dependiente == 1){
//         $.ajax({
//             type: "POST",
//             url: urlweb + "api/Admin/datos_disponibles_caja",
//             success:function (r) {
//                 var almacenar = JSON.parse(r);
//                 console.log(almacenar);
//                 $('#id_caja').val(almacenar.id_caja);
//                 $('#monto_caja').val(almacenar.monto_caja).prop('readonly', true);
//             }
//         });
//     }else{
//         $('#monto_caja').prop('readonly', false);
//     }
// }

