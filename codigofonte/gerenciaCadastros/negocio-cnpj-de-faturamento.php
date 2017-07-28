<?php
include('persistencia-cnpj-de-faturamento.php');

class cnpjDeFaturamentoBO{

    public function Consultar($loDados){

        $loDdConsulta = null;

        $loId = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loId = $loDados["id"];
            $loDdConsulta .=  " AND id_cnpj_faturamento = ".$loId; 

        }

        $loCnpj = null;
        if(isset($loDados["cnpj"]) && !empty($loDados["cnpj"]) ){
            $loCnpj = $loDados["cnpj"];
            $loDdConsulta .=  " AND cnpj = ".$loCnpj; 

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


        $loConsultar = new cnpjDeFaturamentoBOA();
        $loLista = $loConsultar->Consultar($loDdConsulta);

        return $loLista;

    }

    public function Gravar($loDados){

        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );



        if($loDados["cnpj"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o CNPJ.";

        }
      
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loItens = new cnpjDeFaturamentoBOA();

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

    function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                $maskared .= $mask[$i];
            }
        }
        return $maskared;
     }



} 

?>