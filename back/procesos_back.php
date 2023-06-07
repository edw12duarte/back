<?php
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


/*  <form action="" method="POST">
        <ul>
            <li>
                <h4>Departamento</h4>
                <select class="select_filtro" name="id_region">
                    <option value="9999999">Todos</option>
                </select>
                
            </li>
            <li>
                <h4>Fecha</h4>
                <select class="select_filtro" name="id_fecha">
                    <option value="9999999">Todos</option>
                </select>
            </li> 
        </ul>
        
    </form>
    */
?>

