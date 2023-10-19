<?php
namespace APP\Controller;
use APP\Model\VistaModelo;
class VistaControlador extends VistaModelo{

    public function ControlVistaControlador($vista){
        //COMPROBAMOS SI TRAE TEXTO O NO
        if($vista!=""){
            $respuesta=$this->ControlVistaModelo($vista);
        }else{
            $respuesta="login";
        }
        return $respuesta;
    }

}
?>