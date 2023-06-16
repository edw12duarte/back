
<?php
    include 'bd/conexion.php';

    
    if (isset($_POST['filtros'])){
        $id_indicador = $_POST['id_indicador'];
        $id_departamento = $_POST['id_departamento'];
        $id_fecha = $_POST['id_fecha'];



//TRAE NOMBRE DE INDICADOR, DEPARTAMENTO Y FECHA =========================================================
        $sql_sentencia_0 = 'SELECT nombre_departamento 
                            FROM departamento_cod
                            WHERE pk_id_departamento = '.$id_departamento;
        
        $sql_sentencia_1 ='SELECT nombre_indicador 
                            FROM indicador_cod 
                            WHERE pk_id_indicador ='.$id_indicador;

        $query_nombre_departamento = mysqli_query($conexion ,$sql_sentencia_0);
        $query_nombre_indicador = mysqli_query($conexion ,$sql_sentencia_1);

        $nombre_departamento = mysqli_fetch_array($query_nombre_departamento)[0];
        $nombre_indicador = mysqli_fetch_array($query_nombre_indicador)[0];

        echo'<script>
            var nombre_departamento = "'.$nombre_departamento.'"
            var nombre_indicador = "'.$nombre_indicador.'"
            var fecha = "'.$id_fecha.'"
            var id_departamento ="'.$id_departamento.'"
            var id_indicador = "'.$id_indicador.'"
            </script>';



//Trae los datos de la grafica 'LINEA'======================================================
        $sql_sentencia_0 = 'SELECT fecha, AVG(factor) as factor, sum(numerador) as numerador, sum(denominador) as denominador 
                            FROM datos_efectividad 
                            WHERE indicador_id = '.$id_indicador.' and cod_depto= '.$id_departamento.'
                            GROUP BY fecha';

        $query_grafica_linea = mysqli_query($conexion ,$sql_sentencia_0);
        $datos_grafica_linea= [];

        while($datos= mysqli_fetch_array($query_grafica_linea)){
            $fecha = $datos['fecha'];
            
            $valor = ($datos['numerador']/$datos['denominador'])*$datos['factor'];
            $datos_grafica_linea[$fecha] = $valor;
        }

        $datos_grafica_linea = json_encode($datos_grafica_linea);

        echo '<script>
            var datos_grafica_linea = '.$datos_grafica_linea.';
            </script>';



//Traer datos para grafica indicador_pais==============================================================================
        $sql_sentencia_0 = 'SELECT avg(factor) as factor, SUM(numerador) as numerador, SUM(denominador) as denominador
                            FROM datos_efectividad 
                            WHERE indicador_id = '.$id_indicador.' and fecha='.$id_fecha;

        $query_indicador_pais = mysqli_query($conexion ,$sql_sentencia_0);

        $datos = mysqli_fetch_array($query_indicador_pais);
        
        $datos_indicador_pais = ($datos['numerador']/$datos['denominador'])*$datos['factor'];

        echo '<script>
            var datos_indicador_pais = "'.$datos_indicador_pais.'"
            </script>';



//Traer datos para grafica indicador_departamento ==============================================================================
        $sql_sentencia_0 = 'SELECT avg(factor) as factor, SUM(numerador) as numerador, SUM(denominador) as denominador
                            FROM datos_efectividad 
                            WHERE indicador_id = '.$id_indicador.' and fecha='.$id_fecha.' and cod_depto ='.$id_departamento;

        $query_indicador_depart = mysqli_query($conexion ,$sql_sentencia_0);

        $datos = mysqli_fetch_array($query_indicador_depart);
        $denominador = ($datos['denominador'] == 0) ? 1 : $datos['denominador'];

        $datos_indicador_depart = ($datos['numerador']/$denominador)*$datos['factor'];

        echo '<script>
            var datos_indicador_depart = "'.$datos_indicador_depart.'"
            </script>';



//Traer datos para grafica top barras municipios ==============================================================================
        $sql_sentencia_0 = 'SELECT valor, municipio, SUM(numerador) as numerador, SUM(denominador) as denominador, AVG(factor) as factor
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha.'
                            GROUP BY municipio
                            ORDER BY valor DESC limit 10';

        $query_barras_muni = mysqli_query($conexion, $sql_sentencia_0);
        $datos_barras_muni = [];

        while($datos = mysqli_fetch_array($query_barras_muni)){

            $municipio = $datos['municipio'];
            $denominador = ($datos['denominador'] == 0) ? 1 : $datos['denominador'];

            $valor = ($datos['numerador']/$denominador)*$datos['factor'];

            $datos_barras_muni[$municipio] = $valor;
        }

        $datos_barras_muni = json_encode($datos_barras_muni);

        echo '<script>
            var datos_barras_muni = '.$datos_barras_muni.';
            </script>';



//Traer datos para grafica top barras IPS ==============================================================================
        $sql_sentencia_0 = 'SELECT ips, valor
                            FROM datos_efectividad
                            WHERE indicador_id = '.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha.'
                            GROUP BY ips
                            ORDER BY valor DESC limit 10';

        $query_barras_ips = mysqli_query($conexion, $sql_sentencia_0);
        $datos_barras_ips = [];

        while($datos = mysqli_fetch_array($query_barras_ips)){

            $ips = $datos['ips'];
            $valor = $datos['valor'];
            $datos_barras_ips[$ips] = $valor;
        }

        $datos_barras_ips = json_encode($datos_barras_ips);

        echo '<script>
        var datos_barras_ips = '.$datos_barras_ips.';
        </script>';

//Traer datos para MAPA ==============================================================================

        $sql_sentencia_0 = 'SELECT cod_municipio, sum(numerador) as numerador, SUM(denominador) as denominador, avg(factor) as factor
                            FROM datos_efectividad
                            where cod_depto = '.$id_departamento.' and indicador_id = '.$id_indicador.' and fecha = '.$id_fecha.'
                            GROUP BY cod_municipio';

        $query_grafico_mapa = mysqli_query($conexion, $sql_sentencia_0);
        $datos_grafico_mapa = [];

        while($datos = mysqli_fetch_array($query_grafico_mapa)){

            $cod_municipio = $datos['cod_municipio'];
            $denominador = ($datos['denominador'] == 0) ? 1 : $datos['denominador'];

            $valor = ($datos['numerador']/$denominador)*$datos['factor'];

            $datos_grafico_mapa[$cod_municipio] = $valor;
        }

        $datos_grafico_mapa = json_encode($datos_grafico_mapa);

        echo '<script>
            var datos_grafico_mapa = '.$datos_grafico_mapa.';
            </script>';



    }else{
        echo 'else';
    }
    

    
?>