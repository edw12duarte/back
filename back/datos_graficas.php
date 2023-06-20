
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
        $factor_ind = $datos['factor'];
        
        $datos_indicador_pais = ($datos['numerador']/$datos['denominador'])*$datos['factor'];

        echo '<script>
            var datos_indicador_pais = "'.$datos_indicador_pais.'"
            var factor_ind ="'.$factor_ind.'"
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

            $cod_municipio = strlen($datos['cod_municipio']) == 4 ? '0'.$datos['cod_municipio']: $datos['cod_municipio']; // Si el codigo de municipio es de 4 digitos, se le agrega un '0' al principio para que concida con el codigo del archivo json
            $denominador = ($datos['denominador'] == 0) ? 1 : $datos['denominador'];

            $valor = ($datos['numerador']/$denominador)*$datos['factor'];

            $datos_grafico_mapa[$cod_municipio] = $valor;
        }

        $datos_grafico_mapa = json_encode($datos_grafico_mapa);

        echo '<script>
            var datos_grafico_mapa = '.$datos_grafico_mapa.';
            </script>';


//Traer codigo, nombre y bandera departamento==============================================================================

        $sql_sentencia_0 = 'SELECT poblacion, bandera 
                            FROM departamento_cod
                            WHERE pk_id_departamento ='.$id_departamento;

        $query_datos_dep = mysqli_query($conexion, $sql_sentencia_0);
        
        $datos = mysqli_fetch_array($query_datos_dep);
        $poblacion_dep = $datos['poblacion'];
        $bandera_dep = $datos['bandera'];

        echo "<script>
            var poblacion_dep = '".$poblacion_dep."'
            </script>";


// ind max y min por ips======================================================================================================================

        $sql_sentencia_0 = 'SELECT  ips, valor
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha.'
                            GROUP BY ips 
                            ORDER BY valor ASC limit 1';

        $query_ips_menor = mysqli_query($conexion, $sql_sentencia_0);
                
        $datos_ips_menor = mysqli_fetch_assoc($query_ips_menor); //-----> mysqli_fetch_assoc: devuelve un objeto {name_1:valor_1, name_2:valor_2}
        $datos_ips_menor = json_encode($datos_ips_menor);


        $sql_sentencia_0 = 'SELECT  ips, valor
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha.'
                            GROUP BY ips 
                            ORDER BY valor DESC limit 1';

        $query_ips_mayor = mysqli_query($conexion, $sql_sentencia_0);
                
        $datos_ips_mayor = mysqli_fetch_object($query_ips_mayor); //-----> mysqli_fetch_assoc: devuelve un objeto {name_1:valor_1, name_2:valor_2}
        $datos_ips_mayor = json_encode($datos_ips_mayor);


        echo "<script>
            var datos_ips_mayor = '".$datos_ips_mayor."'
            var datos_ips_menor = '".$datos_ips_menor."'
            </script>";


//ind max y min por municipio===========================================================================================================================

        $sql_sentencia_0 = 'SELECT  municipio, valor
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha.'
                            GROUP BY municipio 
                            ORDER BY valor ASC limit 1';

        $query_muni_menor = mysqli_query($conexion, $sql_sentencia_0);
                
        $datos_muni_menor = mysqli_fetch_assoc($query_muni_menor); //-----> mysqli_fetch_assoc: devuelve un objeto {name_1:valor_1, name_2:valor_2}
        $datos_muni_menor = json_encode($datos_muni_menor);


        $sql_sentencia_0 = 'SELECT  municipio, valor
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha.'
                            GROUP BY municipio 
                            ORDER BY valor DESC limit 1';

        $query_muni_mayor = mysqli_query($conexion, $sql_sentencia_0);
                
        $datos_muni_mayor = mysqli_fetch_object($query_muni_mayor); //-----> mysqli_fetch_assoc: devuelve un objeto {name_1:valor_1, name_2:valor_2}
        $datos_muni_mayor = json_encode($datos_muni_mayor);


        echo "<script>
            var datos_muni_mayor = '".$datos_muni_mayor."'
            var datos_muni_menor = '".$datos_muni_menor."'
            </script>";

// Cantidad de municipios por departamento =====================================================================================

        $sql_sentencia_0 = 'SELECT  COUNT(DISTINCT (municipio)) as cant_mun
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha;

        $query_cant_muni = mysqli_query($conexion, $sql_sentencia_0);

        $cant_muni = mysqli_fetch_assoc($query_cant_muni); 
        $cant_muni = json_encode($cant_muni);


// Cantidad de municipios e ips por departamento =====================================================================================

        $sql_sentencia_0 = 'SELECT  COUNT(DISTINCT (ips)) as cant_ips
                            FROM datos_efectividad
                            WHERE indicador_id ='.$id_indicador.' and cod_depto='.$id_departamento.' and fecha='.$id_fecha;

        $query_cant_ips = mysqli_query($conexion, $sql_sentencia_0);

        $cant_ips = mysqli_fetch_assoc($query_cant_ips); 
        $cant_ips = json_encode($cant_ips);

        echo "<script>
            var cant_ips = '".$cant_ips."'
            var cant_muni = '".$cant_muni."'
            </script>";

    }else{
        echo 'fallo';
    }

    function colocar_bandera($bandera_dep){
        echo '<img src="'.$bandera_dep.'" style="border: 1px solid black;">';
    }
    
    
?>