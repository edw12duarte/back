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
    <title>Dashboard indicadores de salud</title>
</head>

<?php
    include 'back/procesos_back.php';
    include 'back/datos_graficas.php'
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
                    <div class="info_depart">
                        <table class="table">
                            <thead>
                                <td class="titulo_tabla" colspan="3">Nombre del departamento</td>
                                <tr>
                                    <td>habitantes</td>
                                    <td>Bandera</td>
                                    <td>Cod Departamento</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1000000</td>
                                    <td>bandera</td>
                                    <td>codigo departamento</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="info_muni">
                        <table class="table">
                            <thead>
                                <td class="titulo_tabla" colspan="3">Numero de municipios: <span>###</span></td>
                                <tr>
                                    <td>Municipio Mayor indicador</td>
                                    <td>Municipio Menor indicador</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1000000</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="info_ips">
                        <table class="table">
                            <thead>
                                <td class="titulo_tabla" colspan="3">Numero de ips: <span>###</span></td>
                                <tr>
                                    <td>Ips Mayor indicador</td>
                                    <td>IPS Menor indicador</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1000000</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="grafica1" class="graf_1"></div>
            </div>
            <div id="ind_map">
                <div class="grupo_tarjetas">
                    <div id="tarjeta_1" class="tarjeta">
                    </div>
                    <div id="tarjeta_2" class="tarjeta">
                    </div>
                </div>
                <div id="mapa"></div>
            </div>
            <div class="barras_top">
                <div id="muni_barras_top"></div>
                <div id="ips_barras_top"></div>
            </div>
        </div>
        <section id="tabla_bruto">
            <div id="num_registros"></div>
            <div id="tabla_registros"></div>
        </section>
    </section>
    <script src="js/app.js"></script>
    <script src="js/graficas.js"></script>
    <!--<script src="js/ajax.js"></script>
    <script src="js/jquery.min.js"></script>-->
</body>
</html>