<?php
require_once("./clases/NeumaticoBD.php");

$n_json= $_POST["neumatico_json"];
$exito= false;
$mensaje;

$n= json_decode($n_json);
$n= new NeumaticoBD( $n->marca, $n->medidas, $n->precio);


if($n->agregar()){
    $exito=true;
    $mensaje = "Se ha agregado el neumatico con exito";

}

if(!$exito){
    $mensaje= "Ocurrio un error al agregar el neumatico solicitado";
}

echo $retorno = json_encode(array("exito"=>$exito,"mensaje"=>$mensaje));
return $retorno;


?>