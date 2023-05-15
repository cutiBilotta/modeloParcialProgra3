<?php

require_once("./clases/NeumaticoBD.php");
$exito = false;
$obj_neumatico= $_POST["neumatico_json"];
$foto = $_FILES['foto']['name'];

$n= json_decode($obj_neumatico);

$extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
$path_fotoActual = "./neumaticos/imagenes/" . $n->marca .".". $date = date('his', time()) . "." . $extension;

$neumatico= new NeumaticoBD($n->marca, $n->medidas,$n->precio,$n->id, $path_fotoActual);
$lista = NeumaticoBD::traer();

foreach($lista as $item){
    if($item['id'] == $neumatico->getId()){
        $pathAntiguo= $item['foto'];
    }
}

if($neumatico->modificar()){

    $neumatico->subirFoto($path_fotoActual, $extension);

    $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    $pathNuevo= "./neumaticosModificados/". $neumatico->getId() . ".". $neumatico->marca .".". "modificado"."." .$date = date('his', time()) . "." . $extension;
    
    if(rename($pathAntiguo,$pathNuevo)){
       
        echo "SE PUDO MOVER EL ARCHIVO";
    }else{
        echo " NO SE PUDO MOVER EL ARCHIVO";

    }
}





/*modificarNeumaticoBDFoto.php: Se recibirán por POST los siguientes valores: neumatico_json (id, marca,
medidas y precio, en formato de cadena JSON) y la foto (para modificar un neumático en la base de datos).
Invocar al método modificar.
Nota: El valor del id, será el id del neumático 'original', mientras que el resto de los valores serán los del
neumático a ser modificado.
Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
“./neumaticosModificados/”, con el nombre formado por el id punto marca punto 'modificado' punto hora,
minutos y segundos de la modificación (Ejemplo: 987.fateo.modificado.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/

?>