<?php

require_once("./clases/NeumaticoBD.php");

$tabla= $_GET["tabla"];

$array= NeumaticoBD::traer();
$neumaticos =array();

foreach($array as $item){
    array_push($neumaticos, new NeumaticoBD($item['marca'], $item['medidas'], $item['precio']));
}

if($tabla== "mostrar"){
    
    $tabla = "<table> <TR><TD> ID </TD> <TD>MARCA</TD> <TD>MEDIDAS</TD>  <TD>PRECIO/TD> </TR>";

    foreach($neumaticos as $n){
        
       //echo($n['marca'] ." - " .  $n['medidas'] ." - " .  $n['precio']  . "\r\n");
        $tabla .= "<tr><td> $n->marca </td> <td>$n->medidas</td> <td>$n->precio</TD>  </TR>";
    }
}
$tabla.="</table>";
echo $tabla;

?>