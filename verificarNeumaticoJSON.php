<?php

require_once("./clases/Neumatico.php");
$exito = false;
$marca= $_POST["marca"];
$medidas= $_POST["medidas"];

$n = new Neumatico($marca, $medidas);
$mensaje = $n->verificarNeumaticoJSON($n);

echo $mensaje;
return $mensaje;


?>