<?php

class Neumatico{

    public string $marca;
    public string $medidas;
    public ?float $precio;


    public function __construct(string $marca, string $medidas, ?float $precio= null)
    {
        $this->marca= $marca;
        $this->medidas=$medidas;
        $this->precio=$precio;

    }
  

    public function toJSON()
    {
        $array= array("marca"=>$this->marca,"medidas"=>$this->medidas,"precio"=>$this->precio);
        return $array=json_encode($array);
    }

    public function guardarJSON(string $path)
    {
        $ar= fopen("$path", "a");
        if(fwrite($ar,$this->ToJSON(). "\r\n")){
            $existe=TRUE;
            $mensaje = "Se guardo el usuario en archivo correctamente";
        }else{
            $existe=FALSE;
            $mensaje = "Ocurrio un error al guardar el usuario en archivo";

        }

        return json_encode(array("existe"=>$existe,"mensaje"=>$mensaje));
    }

    public static function traerJSON(string $path){
        $ar=fopen("$path", "r");
        $neumaticos= array();

        while(!feof($ar)){
            $linea = fgets($ar);
            $neumaticoAr = json_decode($linea);
            if(isset($neumaticoAr)){
                $neumatico = new Neumatico( $neumaticoAr->marca, $neumaticoAr->medidas,$neumaticoAr->precio);
                array_push($neumaticos, $neumatico);
            }
        }

        fclose(($ar));

        return $neumaticos;

        
    }

    public static function verificarNeumaticoJSON($neumatico){
        $array=  Neumatico::traerJSON("./archivos/neumaticos.json");

        
        $mensaje=0;
        $existe = false;
 
        foreach($array as $n){
             if($neumatico->marca == $n->marca && $neumatico->medidas == $n->medidas){
                 $mensaje+= strval($n->precio);
                 $existe=true;
                 
             }
        }
 
        if(!$existe){
            $mensaje="No se ha encontrado un neumatico igual en el registro";
        }
        return json_encode(array("existe"=>$existe,"mensaje"=>$mensaje));
 
     }

   



     /*
    public function Agregar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO usuarios (nombre, correo, clave, id_perfil)"
                                                    . "VALUES(:nombre, :correo, :clave, :id_perfil)");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);


        return $consulta->execute();   
    }

    public static function TraerTodos()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT u.id, u.nombre, u.correo, u.clave, u.id_perfil , p.descripcion FROM usuarios as u
                                                        INNER JOIN perfiles as p ON u.id_perfil = p.id ");
        
        $consulta->execute();
        

        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        
       
        return $consulta; 
    }

    public static function TraerUno(string $correo, string $clave)
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT nombre, correo, clave, id_perfil FROM usuarios WHERE (correo = :correo) AND (clave=:clave)");   
        
        $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);

        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        return $consulta; 
    }

    public static function TraerUnoId(int $id)
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id, nombre, correo, clave, id_perfil FROM usuarios WHERE id = :id")   ;
        
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        return $consulta; 
    }
    public function Modificar() : bool
    {
        
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->retornarConsulta("UPDATE usuarios SET nombre = :nombre, correo = :correo, 
                                                            clave = :clave, id_perfil = :id_perfil WHERE id = :id");
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
           
   
            return $consulta->execute();
        
    }

     
    public static function Eliminar(int $id): bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }

    }*/

}
?>
