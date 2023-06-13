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

    /*
    function envio_filtros(){
        if(isset($_POST['filtros'])){
            $id_indicador = $_POST['id_indicador'];
            $id_departamento = $_POST['id_departamento'];
            $id_fecha = $_POST['id_fecha'];
            
            echo '<h1>id indicador= '.$id_indicador.'<br>
                    id departamento='.$id_departamento.'<br>
                    id fecha = '.$id_fecha.'
                </h1>';
        }
    }
    */
?>

