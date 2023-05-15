<?php

require_once("IParte1.php");
require_once("IParte2.php");
require_once("IParte3.php");
require_once("IParte4.php");


require_once("Neumatico.php"); 
use Poo\AccesoDatos;
require_once("AccesoDatos.php");


class NeumaticoBD extends Neumatico{
    
    protected ?string $pathFoto;
    protected ?int $id;


public function __construct(string $marca, string $medidas, ?float $precio=NULL, ?int $id=NULL, ?string $pathFoto=NULL)
{
    parent::__construct($marca, $medidas, $precio);
    $this->pathFoto = $pathFoto;
    $this->id = $id;
}

public function setPathFoto($path)   {
    $this->pathFoto=$path;
}

public function setId($id)   {
    $this->id=$id;
}

public function getId(){
    return $this->id;
}
public function getPathFoto(){
    return $this->pathFoto;
}
public function toJSON()
{
    $array= array("marca"=>$this->marca,"medidas"=>$this->medidas,"precio"=>$this->precio,"pathFoto"=>$this->pathFoto,"id"=>$this->id);
    return $array=json_encode($array);
}


public function agregar()
{

    
    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO neumaticos (marca, medidas, precio,foto)". "VALUES(:marca, :medidas, :precio, :foto)");
        
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
       

        

        return $consulta->execute();  
}


public static function traer()
{    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT * FROM neumaticos");
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        
        return $consulta; 
}



public static function eliminar(int $id): bool
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

    $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM neumaticos WHERE id = :id");
    
    $consulta->bindValue(':id', $id, PDO::PARAM_INT);

    return $consulta->execute();

}

public function modificar() : bool
{
        
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->retornarConsulta("UPDATE neumaticos SET marca=:marca,medidas=:medidas,precio=:precio,foto=:foto  WHERE id = :id");
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
           
   
            return $consulta->execute();

}

public function existe(array $obj){

    $flag=false;

    foreach($obj as $n){
        if($n->medidas == $this->medidas && $n->marca == $this->marca) {
        
            return true;
        }
    }

    if(!$flag){
        return false;
    }
   


}




public function subirFoto(string $path_final, string $extension)  {

   // $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
   // $path_final = "./neumaticos/imagenes/" . $this->marca .".". $date = date('his', time()) . "." . $extension;
    $uploadOk = TRUE;
    

    if (file_exists($path_final)) {
        echo "El archivo ya existe. Verifique";
        $uploadOk = FALSE;
    }else{

        if ($_FILES["foto"]["size"] > 500000 ) {
            echo "El archivo es demasiado grande. Verifique";
            $uploadOk = FALSE;
        }else{

            $esImagen = getimagesize($_FILES["foto"]["tmp_name"]);

            if($esImagen === FALSE) {

                if($extension != "jpg" && $extension != "png") {
                    echo "Solo son permitidos archivos con extension PNG o JPG.";
                    $uploadOk = FALSE;
                }
            }else{
                if ($uploadOk === FALSE) {

                    echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
                    return FALSE;

                } 
                else {
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $path_final)) {
                        //$this->pathFoto = $path_final;
                       
                        return true;
                    } else {
                        echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                        return FALSE;
                    }
                }
            }
        }
    }
}


public function guardarEnArchivo() {
   
    $exito=false;

    $extension = pathinfo($this->pathFoto, PATHINFO_EXTENSION);
    $pathNuevo= "./neumaticosBorrados/". $this->getId() . ".". $this->marca .".". "borrado"."." .date('his', time()) . "." . $extension;


    $ar= fopen("./archivos/neumaticosbd_borrados.txt", "a");
    if(fwrite($ar, $this->marca . "," . $this->medidas . "," . $this->precio . "," . $pathNuevo. "\r\n")){

        rename($this->pathFoto,$pathNuevo);

        $exito=true;
        $mensaje = "Se guardo el neumatico en archivo correctamente";
    }else{

        $exito=FALSE;
        $mensaje = "Ocurrio un error al guardar el neumatico en archivo";

    }

    return json_encode(array("exito"=>$exito,"mensaje"=>$mensaje));


}
/*guardarEnArchivo: escribirá en un archivo de texto (./archivos/neumaticosbd_borrados.txt) toda la
información del neumático más la nueva ubicación de la foto. La foto se moverá al subdirectorio
“./neumaticosBorrados/”, con el nombre formado por el id punto marca punto 'borrado' punto hora,
minutos y segundos del borrado (Ejemplo: 688.bridgestone.borrado.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/

}

?>