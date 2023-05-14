<?php

require_once("./clases/NeumaticoBD.php");

$tabla= $_GET["tabla"];

$array= NeumaticoBD::traer();
if($tabla== "mostrar"){
    foreach($array as $n){
       echo($n['marca'] ." - " .  $n['medidas'] ." - " .  $n['precio']  . "\r\n");
    }
}

?>