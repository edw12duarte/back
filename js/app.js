
function cambiar(){
    var cambio= document.getElementById('id_indicador').value;
    var data_end = 'id_indicador='+cambio;

    $.ajax({
        data: data_end, 
        url: 'back/datos_ajax.php',
        type: 'POST',
        beforesend: function() {
            alert('paila');
            },
        success: function (mensaje_oper) {
            alert('Funciono '+ mensaje_oper);
        }
        })
}















/*

let ajax_ind = function(){
    var opt_act = $('.select_filtro').val();
    console.log(opt_act);

    $.ajax({
        url: 'back/datos_ajax.php',
        type: 'POST',
        datatype: 'json',
        data: {
            id_ind : opt_act
        },
        success: function(data) {
            alert('Datos enviados satifactoriamente');
        },
        error: function(data){
            alert('Error en el envio')
        }
    }).done(
        console.log('exito '+ opt_act)
    );
}

$(document).ready(ajax_ind);

$('.select_filtro').change(ajax_ind);
*/