<?php

require_once("./clases/NeumaticoBD.php");
$exito= false;
$neumatico_json = $_POST['neumatico_json'];

    $n = json_decode($neumatico_json);
    $neumaticoAux = new NeumaticoBD($n->marca,$n->medidas,$n->precio, $n->id);

    $array = NeumaticoBD::traer();

    foreach($array as $item){
        if($item['id'] == $n->id){
             if($neumaticoAux->Modificar()){
                $mensaje= "El neumatico solicitado ha sido modificado con exito";
                $exito=true;

            }
            break;
        }
    }
    if(!$exito){
        $mensaje= "El neumatico solicitado no se pudo modificar";
    
    }

    echo $retorno = json_encode(array("exito"=>$exito,"mensaje"=>$mensaje));
    return $retorno;    
   

?>