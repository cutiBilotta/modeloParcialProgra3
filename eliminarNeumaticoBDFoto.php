<?php

require_once("./clases/NeumaticoBD.php");

$n_json= $_POST["neumatico_json"];
$exito=false;
$n = json_decode($n_json);
$neumaticoBD= new NeumaticoBD($n->marca,$n->medidas,$n->precio, $n->id, $n->pathFoto);

   
    $array = NeumaticoBD::traer();
    

    foreach($array as $item){
      echo"entre al foreach\n";

      if($item['id'] == $n->id){
          echo"entre al primer if\n";
            
          if(NeumaticoBD::eliminar($item['id'])){
              echo "entre al segundo if\n";
                $neumaticoBD->guardarEnArchivo();
                $exito = true;
                $mensaje= "El item solicitado ha sido eliminado con exito";

            }
            break;
        }
    }

  if(!$exito){
    $mensaje= "Ocurrio un error al eliminar el item solicitado";
  }
  echo $retorno = json_encode(array("exito"=>$exito,"mensaje"=>$mensaje));
    return $retorno;


    /*eliminarNeumaticoBDFoto.php: Se recibe el parámetro neumatico_json (id, marca, medidas, precio y pathFoto
en formato de cadena JSON) por POST. Se deberá borrar el neumático (invocando al método eliminar).
Si se pudo borrar en la base de datos, invocar al método guardarEnArchivo.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los neumáticos
borrados y sus respectivas imagenes.*/
?>
