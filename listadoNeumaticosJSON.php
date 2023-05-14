<?php
require_once("./clases/Neumatico.php");



$array= Neumatico::traerJSON("./archivos/neumaticos.json");

foreach($array as $n){
    echo($n->marca . " - " . $n->medidas . " - " . $n->precio . "\r\n");
}




?>