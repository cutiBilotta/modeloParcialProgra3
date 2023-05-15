<?php

require_once("./clases/NeumaticoBD.php");
$exito = false;
$obj_neumatico= $_POST["obj_neumatico"];
$mensaje= json_encode("");

$n = json_decode($obj_neumatico);
$neumaticoBD= new NeumaticoBD($n->marca, $n->medidas);

$array= NeumaticoBD::traer();

foreach($array as $item){
    if($item['marca'] == $neumaticoBD->marca && $item['medidas'] == $neumaticoBD->medidas){
        
        $neumaticoBD->precio = $item['precio'];
        $neumaticoBD->setPathFoto($item['foto']);
        $neumaticoBD->setId($item['id']);

        $mensaje = $neumaticoBD->toJSON();
        echo $mensaje;
       
    }
}



return $mensaje;


?>

