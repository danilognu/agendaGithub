<?php
include('persistencia-combustivel.php');

class combustivelBO{

    public function ListaCombustivel($loDados){
        
        $loCombustivel = new combustivelBOA();
        $loListaCombustivel = $loCombustivel->ListaCombustivel($loDados);

        return $loListaCombustivel;
    }

public function GravarCombustivel($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );

        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome.";

        }
      
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loDadosCombustivel = new combustivelBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosCombustivel->IncluirCombustivel($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosCombustivel->AlterarCombustivel($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }

    public function DesativarCombustivel($loDados){

       $loRetorno[] = null; 

        $loDadosCombustivel = new combustivelBOA();
        $loRetorno = $loDadosCombustivel->DesativarCombustivel($loDados);
        return $loRetorno;
    }  

}


?>