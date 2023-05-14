<?php


require_once("./clases/Neumatico.php");

$marca = $_POST["marca"];
$medidas = $_POST["medidas"];
$precio = $_POST["precio"];

$n= new Neumatico( $marca, $medidas, $precio);


$n->guardarJSON("./archivos/neumaticos.json");







?>