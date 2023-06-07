<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <title>Dashboard indicadores de salud</title>
</head>

<?php
include 'back/procesos_back.php';
?>

<body>
    <section id="espacio_menu">
        <section id="menu">
            <h1>Indicadores Monitoreo de la calidad de la Atención IPS - Efectividad</h1>
            <form action="" method="POST">
                <ul>
                    <li>
                        <h4>Indicadores</h4>
                        <select  id="id_indicador" class="select_filtro" name="id_indicador" onchange="cambiar()">
                            
                            <option value="9999999">Todos</option>
                            <option value="1111">Todos1</option>
                            <?php
                                //traer_options($conexion);
                            ?>
                        </select>
                    </li>
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
                <input class="btn" type="submit" name="traer_id" value="Mostrar">
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
                <div class="graf_1"></div>
                <div class="graf_2">
                    <h1>Nombre del Municipio</h1>
                    <div class="tarjeta_muni">
                        <h1>Valor indicador: 100</h1>
                        <h5>unidades</h5>
                    </div>
                </div>
                <div class="graf_3"></div>
            </div>
            <div id="ind_map">
                <div id="mapa"></div>
                <div class="grupo_tarjetas">
                    <div class="tarjeta">
                        <h3>Nombre país</h3>
                        <h1>Valor indicador: 100</h1>
                        <h5>unidades</h5>
                    </div>
                    <div class="tarjeta">
                        <h3>Nombre departamento </h3>
                        <h1>Valor indicador: 100</h1>
                        <h5>unidades</h5>
                    </div>
                </div>
            </div>
            <div class="grafica_4">
                <?php
                    include 'back/datos_ajax.php';
                ?>
            </div>
        </div>
        <section id="tabla">
        </section>
    </section>
    <script src="js/app.js"></script>
    <!--<script src="js/ajax.js"></script>
    <script src="js/jquery.min.js"></script>-->
</body>
</html>