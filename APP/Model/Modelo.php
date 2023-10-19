<?php 
namespace APP\Model;
use \PDO;

//VERIFICA SI EXISTE EL ARCHIVO SERVER.PHP
if(file_exists(__DIR__."/../../config/server.php")){
    require_once(__DIR__."/../../config/server.php");
}

class Modelo{
    private $SERVER=BD_SERVER;
    private $DB=BD_NAME;
    private $USER=BD_USER;
    private $PASS=BD_PASS;

    protected function conectar(){
        $conexion = new PDO("mysql:host=".$this->SERVER.";dbname=".$this->DB, $this->USER, $this->PASS);
        return $conexion;
    }

    protected function consultarDatos($consulta){ //CONSULTA PREPARADA
        $sql= $this->conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }
   
    protected function eliminarDatos($tabla,$campo,$id){
        $sql=$this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
        $sql->bindParam(":id",$id);
        $sql->execute();
        
        return $sql;
    }

    protected function guardarDatos($tabla,$datos){
        $sql="INSERT INTO ".$tabla." VALUES(null,". $datos .")";

    }

    protected function actualizarDatos($tabla,$datos,$condicion){
        $sql="UPDATE ".$tabla." SET ". $datos ." WHERE ".$condicion;
        
    }

    public function evitarInjeccion($caracteres){
        //Ingresar caracteres de posible injecion
        $caracter=["<script>", "</script>", "<script src", "<script type=",
        "SELECT * FROM", "SELECT ", " SELECT ", "DELETE FROM", "INSERT INTO",
        "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES", "SHOW DATABASES",
        "<?php", "?>", "--", "^", "<", ">", "==", "=", ";", "::"];
        
        //Limpieza de espcios,etc
        $caracteres=trim($caracteres);
        $caracteres=stripcslashes($caracteres);

        foreach ($caracter as $strings) {
            $caracteres=str_ireplace($strings, "",$caracteres);
        }
        $caracteres=trim($caracteres);
        $caracteres=stripcslashes($caracteres);

        return $caracteres;
    }
    //EXPRESIONES REGULARES
    protected function VerificarDatos($expresion,$caracteres){
        if (preg_match("/^".$expresion."$/",$caracteres)) {
            return false;
        } else {
            return true;
        }
    }

    public function seleccionarDatos($tipo,$tabla,$campo,$id,$datos,$condicion){
        $tipo=$this->evitarInjeccion($tipo);
        $tabla=$this->evitarInjeccion($tabla);
        $campo=$this->evitarInjeccion($campo);
        $id=$this->evitarInjeccion($id);
        $datos=$this->evitarInjeccion($datos);
        $condicion=$this->evitarInjeccion($condicion);

        if($tipo=="Unico"){
            $sql=$this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
            $sql->bindParam(":ID",$id);
        }elseif($tipo=="Normal"){
            $sql=$this->conectar()->prepare("SELECT $campo FROM $tabla");
        }
        $sql->execute();
    
        return $sql;
    }
}
?>