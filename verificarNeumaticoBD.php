<?php

require_once("./clases/NeumaticoBD.php");
$exito = false;
$obj_neumatico= $_POST["obj_neumatico"];
$mensaje= json_encode("");

$n = json_decode($obj_neumatico);

$nAux = new NeumaticoBD($n->marca, $n->medidas);
$mensaje = json_decode("");

$array= NeumaticoBD::traer();

foreach($array as $item){
    if($item['marca'] == $nAux->marca && $item['medidas'] == $nAux->medidas){
        
        $nAux= (object) $item;
       // $mensaje = $nAux->toJSON();
        $mensaje= $nAux->marca . " - " . $nAux->medidas . " - " . $nAux->precio . " - " . $nAux->id . " \r\n" ;
        echo ($mensaje);

        //aca no puedo llamar al metodo toJSON para que me muestre la informacion
    }
}



return $mensaje;


?>

