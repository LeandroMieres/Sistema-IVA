<?php 
namespace APP\controller;
use APP\Model\Modelo;

class loginControlador extends Modelo{

    public function inicialSesion(){

        $nombre=$this->evitarInjeccion($_POST['']);
		$contraseña=$this->evitarInjeccion($_POST['']);

        if($nombre=="" || $contraseña==""){
            /* echo error ingresar datos */
        }else{
            if($this->VerificarDatos(" ",$nombre)){
                /* echo "error" */
            } else {
                if($this->VerificarDatos(" /* ingresar expresion */ ",$contraseña)){
                    /* echo "error" */
                }else{
                    $usuario=$this->consultarDatos("SELECT * FROM usuario WHERE /* usuario */='$nombre'");

                    if($usuario->rowCount()==1){

                        $usuario=$usuario->fetch();

                        if($usuario['/* ingresar usuario */']==$usuario && password_verify($contraseña,$usuario['/* ingresar contraseña */'])){

                            $_SESSION['id']=$usuario['id'];
                            $_SESSION['nombre']=$usuario['nombre'];
                            $_SESSION['apellido']=$usuario['contraseña'];

                            if(headers_sent()){
                                echo "<script> window.location.href='".APP_URL."menu/'; </script>";
                            }else{
                                header("Location: ".APP_URL."menu/");
                            }
                        }else{
                            /* error */
                        }
                    }else{
                       /*  error */
                    }
                }
            }
        }
    
    }
    public function cerrarSesion(){

        session_destroy();
        
        if(headers_sent()){
            echo "<script> window.location.href='".APP_URL."login/'; </script>";
        }else{
            header("Location: ".APP_URL."login/");
        }
    }
}
?>