<?php
    
    include '../bd/conexion.php';

    $id_indicador = $_POST['id_indicador'];

    $sql_departamento = 'SELECT DISTINCT DE.cod_depto, DC.nombre_departamento 
                        FROM datos_efectividad as DE
                        LEFT JOIN departamento_cod as DC
                        ON DE.cod_depto = DC.pk_id_departamento
                        WHERE DE.indicador_id ='.$id_indicador;

    $query_departamento = mysqli_query($conexion,$sql_departamento);
    $respuesta_departamento = '';

    while ($datos_depto = mysqli_fetch_array($query_departamento)) {
        $id_departamento = $datos_depto['cod_depto'];
        $nombre_departamento = $datos_depto['nombre_departamento'];

        $respuesta_departamento = $respuesta_departamento.'<option value="'.$id_departamento.'">'.$nombre_departamento.'</option>';
    }


    $sql_fecha = 'SELECT DISTINCT fecha 
                FROM datos_efectividad
                WHERE indicador_id='.$id_indicador.'
                ORDER BY fecha';

    $query_fecha = mysqli_query($conexion,$sql_fecha);
    $respuesta_fecha = '';

    while ($datos_fecha = mysqli_fetch_array($query_fecha)) {
        $fecha = $datos_fecha['fecha'];

        $respuesta_fecha = $respuesta_fecha.'<option value="'.$fecha.'">'.$fecha.'</option>';
    }

    echo $respuesta_departamento.'///'.$respuesta_fecha

?>