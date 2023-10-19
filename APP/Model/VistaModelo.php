<?php
namespace APP\Model;

class VistaModelo{

    protected function ControlVistaModelo($vista){
        /* VALIDAR ARCHIVOS*/
        $listaurl=["menu"]; //PALABRAS PERMITIDAS POR EL URL ("ARCHIVOS CONTENT")

        if(in_array($vista,$listaurl)){
            //VERIFICA SI EXISTE EL ARCHIVO
            if(is_file("./APP/View/Content/".$vista.".php")){
                //CREA EL ARCHIVO
                $content="./APP/View/Content/".$vista.".php";
            }else{
                $content="404";
            }
            //SI NO EXISTE EL ARCHIVO, REDIRECCIONA AL LOGIN
        }elseif($vista=="login" || $vista=="index"){
            $content="login";
        }else{
            $content="404";
        }
        return $content;
    }
}
?>