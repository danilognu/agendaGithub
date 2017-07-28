<?php
include('persistencia-veiculo.php');

class veiculoBO{

public function ListaVeiculo($loDados){    
    
    $loVeiculo = new veiculoBOA();
    $loListaVeiculo = $loVeiculo->ListaVeiculo($loDados);

    return $loListaVeiculo;
}

public function GravarVeiculo($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );

        if($loDados["placa"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Placa.";

        }
       if($loDados["id_modelo"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Modelo.";

        }
        if($loDados["id_combustivel"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Combustivel.";

        }
        if($loDados["id_cor"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Cor.";

        }
        if($loDados["status"] == 0 && $loDados["motivo_desativacao"] == "" ){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Para Desativar o Veiculo &eacute; preciso preencher o motivo.";
        }
      
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loDadosVeiculo = new veiculoBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosVeiculo->IncluirVeiculo($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosVeiculo->AlterarVeiculo($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }


   public function ListaNivelCombustivel($loDados){
        
        $loVeiculo = new veiculoBOA();
        $loListaVeiculo = $loVeiculo->ListaNivelCombustivel($loDados);

        return $loListaVeiculo;
    }

   public function ListaGaragem($loDados){
        
        $loVeiculo = new veiculoBOA();
        $loLista = $loVeiculo->ListaGaragem($loDados);

        return $loLista;
    }
   
    public function ListaItensConsulta($loDados){

        $loVeiculo = new veiculoBOA();
        $loItensConsulta = $loVeiculo->ListaItensConsulta($loDados);

        return $loItensConsulta;

    }

    public function GridConsultaItens($loDados){

        $loVeiculo = new veiculoBOA();
        $loGridItens = $loVeiculo->GridConsultaItens($loDados);

        return $loGridItens;

    }

    public function AlteraConsultaCliente($loDados){

        $loVeiculo = new veiculoBOA();
        $loConsulta = $loVeiculo->AlteraConsultaCliente($loDados);

        return $loConsulta;

    }  

    public function DesativarVeiculo($loDados){

       $loRetorno[] = null; 

        $loVeiculo = new veiculoBOA();
        $loDesativa = $loVeiculo->DesativarVeiculo($loDados);
        return $loRetorno;
    
    }
 

}



?>