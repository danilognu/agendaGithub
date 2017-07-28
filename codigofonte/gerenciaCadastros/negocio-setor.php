<?php
include('persistencia-setor.php');

class setorBO{

    public function ListaSetor($loDados){

        $loDdConsulta = null;

        $loId = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loId = $loDados["id"];
            $loDdConsulta .=  " AND id_setor = ".$loId; 

        }

        $loNome = null;
        if(isset($loDados["nome"]) && !empty($loDados["nome"]) ){
            $loNome = $loDados["nome"];
            $loDdConsulta .=  " AND nome like '%".$loNome."%'"; 

        }
        
        

        if(isset($loDados["status"]) && strlen($loDados["status"]) >= 1){
            $loStatus= $loDados["status"];
            $loDdConsulta .=  " AND ativo in(".$loStatus.")";
        }else{
            $loDdConsulta .=  " AND ativo = 1";
        }


        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }       


        $loSetor = new setorBOA();
        $loLista = $loSetor->ListaSetor($loDdConsulta);

        return $loLista;

    }

    public function GravarSetor($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );



        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome da Localidade.";

        }
      
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loDadosSetor = new setorBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosSetor->IncluirSetor($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosSetor->AlterarSetor($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }



} 

?>