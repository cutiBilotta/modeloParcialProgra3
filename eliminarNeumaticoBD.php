<?php

require_once("./clases/NeumaticoBD.php");

$n_json= $_POST["neumatico_json"];
$exito=false;
$n = json_decode($n_json);
$neumaticoBD= new NeumaticoBD($n->marca,$n->medidas,$n->precio, $n->id);

   
    $array = NeumaticoBD::traer();
    

    foreach($array as $item){
     // echo $item['marca'] ." - " . $item['medidas']." - " .$item['precio']." - " . $item['id'];
        if($item['id'] == $n->id){

            if(NeumaticoBD::eliminar($item['id'])){
                $exito = true;
                $mensaje= "El item solicitado ha sido eliminado con exito";
                $neumaticoBD->guardarJSON('./archivos/neumaticos_eliminados.json');

            }
            break;
        }
    }

  if(!$exito){
    $mensaje= "Ocurrio un error al eliminar el item solicitado";
  }
  echo $retorno = json_encode(array("exito"=>$exito,"mensaje"=>$mensaje));
    return $retorno;


?>