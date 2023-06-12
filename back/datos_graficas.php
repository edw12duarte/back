
<?php
    include 'bd/conexion.php';

    $sql_sentencia_1='SELECT * FROM indicador_cod';
    $query_indicadores = mysqli_query($conexion ,$sql_sentencia_1);

    $x= [];
    while($indicadores = mysqli_fetch_array($query_indicadores)){
        array_push($x, $indicadores['pk_id_indicador']); 
    }
    $x = json_encode($x);
    echo '<script>
            var x = '.$x.';
        </script>';

?>