<?php
include('persistencia.php');

class negocioBO{ 


 public function ListaBancos(){
        
        $loUsuario = new persistenciaBOA();
        $loRetorno = $loUsuario->ListaBancos();

        return $loRetorno;
  }

  public function ListaComandosSQL(){

        $loUsuario = new persistenciaBOA();
        $loRetorno = $loUsuario->ListaComandosSQL();

        return $loRetorno;

  }

  public function ListaPecaServico(){

        $loUsuario = new persistenciaBOA();
        $loRetorno = $loUsuario->ListaPecaServico();

        return $loRetorno;

  }

}   

?>