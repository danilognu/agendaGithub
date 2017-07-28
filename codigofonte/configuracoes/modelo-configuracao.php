<?php
include('persistencia-configuracao.php');

class configuracaoBO{

    public function ListaDisplayMotorista($loDados){
       
        $loConsultar = new configuracaoBOA();
        $loLista = $loConsultar->ListaDisplayMotorista($loDados);

        return $loLista;

    }

    public function ModificaVlrParametro($loDados){
       
        $loConsultar = new configuracaoBOA();
        $loLista = $loConsultar->ModificaVlrParametro($loDados);

        return $loLista;

    }



} 

?>