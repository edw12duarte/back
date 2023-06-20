<?php
//Trae la info del filtro de indicadores
    include 'bd/conexion.php';

    function traer_options($conexion){
        $query_indicadores = mysqli_query($conexion ,'SELECT * FROM indicador_cod');

        while($indicadores = mysqli_fetch_array($query_indicadores)){
            $indicador_id = $indicadores['pk_id_indicador'];
            $nombre_indicador = $indicadores['nombre_indicador'];

            echo '
                <option value="'.$indicador_id.'">'.$nombre_indicador.'</option>
            ';
        }
    }

?>

