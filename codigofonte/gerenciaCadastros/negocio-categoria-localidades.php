<?php
include('persistencia-categoria-localidades.php');

class categoriaLocalidadesBO{

    public function Consultar($loDados){

        $loDdConsulta = null;

        $loId = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loId = $loDados["id"];
            $loDdConsulta .=  " AND id_cat_localidade = ".$loId; 

        }

        $loNome = null;
        if(isset($loDados["nome"]) && !empty($loDados["nome"]) ){
            $loNome = $loDados["nome"];
            $loDdConsulta .=  " AND nome like '%".$loNome."%'"; 

        }
        $loStatus= null;
        if(isset($loDados["status"]) && strlen($loDados["status"]) >= 1){
            $loStatus= $loDados["status"];
            $loDdConsulta .=  " AND ativo in(".$loStatus.")";
        }else{
            $loDdConsulta .=  " AND ativo = 1";
        }


        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }       


        $loConsultar = new categoriaLocalidadesBOA();
        $loLista = $loConsultar->Consultar($loDdConsulta);

        return $loLista;

    }

    public function Gravar($loDados){

        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loItens = new categoriaLocalidadesBOA();

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );



        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome da Localidade.";

        }
      
       $loListaUtilizacao = $loItens->VerificaLocalidadeUtilizada($loDados);
       if($loListaUtilizacao > 0 && $loDados["status"] == 0){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Categoria em uso não pode ser desativada!";
       }
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            if($loDados["acao"] == "I"){
                $loRetorno = $loItens->Incluir($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loItens->Alterar($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }



} 

?>