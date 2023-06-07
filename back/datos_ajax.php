<?php
/*
    if(isset($_POST['id_ind'])){
        $indicador_actual = $_POST['id_ind'];
        echo '<h1>'.$indicador_actual.'</h1>';
    }else{
        echo'<h1>Otro problema</h1>';
    }


    //echo '<h1>'.$_POST['id_int'].'</h1>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $json = file_get_contents('php://input');

        // Decodificar la cadena JSON en un array asociativo
        $data = json_decode($json);

        if (isset($data)) {
            $nombre = $_POST['id_int'];
            echo "El nombre es: " . $nombre;
        } else {
            echo "No se recibió el parámetro 'nombre'";
        }
    } else {
        echo "Acceso inválido al archivo PHP";
}
*/
$s = $_POST['id_indicador'];
echo $s;

?>