<?php
include('persistencia-modelo.php');

class modeloBO{

    public function ListaModelo($loDados){
        
        $loModelo = new modeloBOA();
        $loListaModelo = $loModelo->ListaModelo($loDados);

        return $loListaModelo;
    }

public function GravarCliente($loDados){


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


            $loDadosModelo = new modeloBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosModelo->IncluirModelo($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosModelo->AlterarModelo($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }
    
    public function DesativarModelo($loDados){

       $loRetorno[] = null; 

        $loDadosModelo = new modeloBOA();
        $loDesativa = $loDadosModelo->DesativarModelo($loDados);
        return $loRetorno;
    }


}


?>