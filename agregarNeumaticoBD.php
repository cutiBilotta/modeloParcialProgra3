
<?php

require_once("./clases/NeumaticoBD.php");

$marca = $_POST["marca"];
$medidas = $_POST["medidas"];
$precio = $_POST["precio"];
$foto = $_FILES["foto"]['name'];
$neumaticos= array();
$exito = false;
$extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
$path_final = "./neumaticos/imagenes/" . $marca .".". $date = date('his', time()) . "." . $extension;
$n= new NeumaticoBD($marca, $medidas, $precio, NULL,  $path_final);

$array =NeumaticoBD::traer();
foreach($array as $item){
    array_push($neumaticos, new NeumaticoBD($item['marca'],$item['medidas'], $item['precio'] , NULL, $foto));
}

$rta= ($n->existe($neumaticos));

if($rta == False){
    if($n->subirFoto($path_final, $extension) && $n->Agregar()){
        $mensaje= "El neumatico ha sido dado de alta con exito";
        $exito= true;
    }else{
        $mensaje= "Ocurrio un error al dar de alta el empleado";
    }

}else{
    $mensaje= "El neumatico ya existe en la base de datos";
}



echo $retorno = json_encode(array("exito"=>$exito,"mensaje"=>$mensaje));
return $retorno;


?>