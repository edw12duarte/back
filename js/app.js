
//funcion que agrega las options traidas con el ajax
var insertar_options = function(respuesta){

    respuesta_departamento = respuesta.split('///')[0];
    respuesta_fecha = respuesta.split('///')[1];

    $('#filtro_departamento').html(respuesta_departamento);
    $('#filtro_fecha').html(respuesta_fecha);
}


//llamado ajax a selects_dinamicos.php
var ajax_ind = function(){
    var opt_act = $('#filtro_indicador').val();

    $.ajax({
        url: "back/selects_dinamicos.php",
        type:  "POST",
        datatype: 'json',
        data: {id_indicador : opt_act},
        success: function(respuesta) {
            insertar_options(respuesta);
        },
        error: function(){
            alert('Error en el envio:')
        }
    })
}


$(document).ready(ajax_ind);
$('#filtro_indicador').change(ajax_ind);
