<?php
include('persistencia-cor.php');

class corBO{

    public function ListaCor($loDados){
        
        $loCor = new corBOA();
        $loListaCor = $loCor->ListaCor($loDados);

        return $loListaCor;
    }

public function GravarCor($loDados){


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


            $loDadosCor = new corBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosCor->IncluirCor($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosCor->AlterarCor($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }

    public function DesativarCor($loDados){

       $loRetorno[] = null; 

        $loDadosCor = new corBOA();
        $loRetorno = $loDadosCor->DesativarCor($loDados);
        return $loRetorno;
    }  

}


?>