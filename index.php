<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.plot.ly/plotly-2.24.1.min.js" charset="utf-8"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    <title>Dashboard indicadores de salud</title>
</head>

<?php
    include 'back/procesos_back.php';
    include 'back/datos_graficas.php';
?>

<body>
    <section id="espacio_menu">
        <section id="menu">
            <h1>Indicadores Monitoreo de la calidad de la Atención IPS - Efectividad</h1>
            <form action="" method="POST">
                <ul>
                    <li>
                        <h4>Indicadores</h4>
                        <!--<select  id="id_indicador" class="select_filtro" name="id_indicador" onchange="cambiar()">-->
                        <select  id="filtro_indicador" class="select_filtro" name="id_indicador">
                            <?php
                                traer_options($conexion);
                            ?>
                        </select>
                    </li>
                    <li>
                        <h4>Departamento</h4>
                        <select id="filtro_departamento" class="select_filtro" name="id_departamento">
                        </select>
                        
                    </li>
                    <li>
                        <h4>Fecha</h4>
                        <select id="filtro_fecha" class="select_filtro" name="id_fecha">
                        </select>
                    </li> 
                </ul>
                <input class="btn" type="submit" name="filtros" value="Mostrar">
            </form>

            <div class="logo">
                <h1>Ministerio de salud y proteccion social</h1>
                <img src="source/1370px-Minsalud_Colombia.svg.png" alt="logo_minsalud">
            </div>
        </section>
    </section>
    <section id="principal">
        <div id="titulo_indicador">
            <h1>Nombre del indicador actual</h1>
        </div>
        <div id="contenido" >
            <div id="graficas">
                <div class="tarjeta_principal">
                    
                    <table class="table" id="info_depart">
                        <thead>
                            <td class="titulo_tabla" id='titulo_tabla_1' colspan="3"></td>
                            <tr>
                                <td>Cod departamento</td>
                                <td>habitantes</td>
                                <td>Bandera</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="codigo_departamento">codigo dep</td>
                                <td id="poblacion_departamento">000000</td>
                                <td id="bandera_departamento"><?php colocar_bandera($bandera_dep);?></td> <!--Aqui toco colocar la nbandera por php, porque haciendolo por el DOM, js presentaba errores-->
                            </tr>
                        </tbody>
                    </table>
                
                    <table class="table" id="info_muni">
                        <thead>
                            <td class="titulo_tabla" colspan="3">Numero de municipios de <span id="titulo_tabla_2"></span> : <span id="cant_municipios"></span></td>
                            <tr>
                                <td>Municipio Mayor indicador</td>
                                <td>Municipio Menor indicador</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="nombre_muni_mayor">No encontrado</td>
                                <td id="nombre_muni_menor">No encontrado</td>
                            </tr>
                            <tr>
                                <td id="valor_muni_mayor">No encontrado</td>
                                <td id="valor_muni_menor">No encontrado</td>
                            </tr>
                        </tbody>
                    </table>
                
                    <table class="table" id="info_ips">
                        <thead>
                            <td class="titulo_tabla" colspan="3">Numero de ips de <span id="titulo_tabla_3"></span> : <span id="cant_ips"></span></td>
                            <tr>
                                <td>Ips Mayor indicador</td>
                                <td>IPS Menor indicador</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="nombre_ips_mayor">No encontrado</td>
                                <td id="nombre_ips_menor">No encontrado</td>
                            </tr>
                            <tr>
                                <td id="valor_ips_mayor">No encontrado</td>
                                <td id="valor_ips_menor">No encontrado</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
                <div id="cont_graf_1">
                    <h3 class="titulo_graf_linea">Departamento</h3>
                    <div id="grafica1" class="graf_linea"></div>
                </div>
            </div>
            <div id="ind_map">
                <div class="grupo_tarjetas">
                    <div id="tarjeta_1" class="tarjeta">
                    </div>
                    <div id="tarjeta_mitad" class="tarjeta">
                    </div>
                    <div id="tarjeta_2" class="tarjeta">
                    </div>
                </div>
                <div id="mapa"></div>
            </div>
            <div class="barras_top">
                <div id="cont_muni_barras">
                    <h3 class="titulo_muni_barras"></h3>
                    <div id="muni_barras_top"></div>
                </div>
                <div id="cont_ips_barras">
                    <h3 class="titulo_ips_barras"></h3>
                    <div id="ips_barras_top"></div>
                </div>
            </div>
        </div>
        <hr>
    </section>
    <script src="js/app.js"></script>
    <script src="js/graficas.js"></script>
    <!--<script src="js/ajax.js"></script>
    <script src="js/jquery.min.js"></script>-->
</body>
<?php
    //include 'back/datos_graficas.php';
?>
</html>