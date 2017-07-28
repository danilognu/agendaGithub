<?php
include('persistencia-localidade.php');

class localidadeBO{

    public function ListaLocalidade($loDados){

        $loDdConsulta = null;
        
        $loId = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loId = $loDados["id"];
            $loDdConsulta .=  " AND localidade.id_localidade = ".$loId; 

        }

        $loNome = null;
        if(isset($loDados["nome"]) && !empty($loDados["nome"]) ){
            $loNome = $loDados["nome"];
            $loDdConsulta .=  " AND localidade.nome like '%".$loNome."%'"; 

        }
        $loEndereco = null;
        if(isset($loDados["endereco"]) && !empty($loDados["endereco"]) ){
            $loEndereco = $loDados["endereco"];
            $loDdConsulta .=  " AND localidade.endereco like '%".$loEndereco."%'"; 

        }
        $loGaragem = null;
        if(isset($loDados["garagem"]) && !empty($loDados["garagem"]) ){
            $loGaragem = $loDados["garagem"];
            $loDdConsulta .=  " AND localidade.garagem = '".$loGaragem."'"; 

        }        


        if(isset($loDados["status"]) && strlen($loDados["status"]) >= 1){
            $loStatus= $loDados["status"];
            $loDdConsulta .=  " AND localidade.ativo in(".$loStatus.")";
        }else{
            $loDdConsulta .=  " AND localidade.ativo = 1";
        }


        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND localidade.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }        

        $loPessoa = new localidadeBOA();
        $loListaPessoas = $loPessoa->ListaLocalidade($loDdConsulta);

        return $loListaPessoas;

    }

    public function GravarLocalidade($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 
        $loValidacaoTela = "localidade";

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );

        if(isset($loDados["tela"]) && !empty($loDados["tela"])){
           if($loDados["tela"] == "solicitacao"){
               $loValidacaoTela = "solicitacao";
           } 
        }

        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome da Localidade.";

        }

        if( isset($loDados["id_cidade"]) && ($loDados["id_cidade"] == "" || $loDados["id_cidade"] == "null") && $loValidacaoTela == "solicitacao" ){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher Estado / Cidade.";          
        }
      
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loDadosLocalidade = new localidadeBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosLocalidade->IncluirLocalidade($loDados);
                $loIdLocalidade = $loDadosLocalidade->BuscaIDLocalidade();
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosLocalidade->AlterarLocalidade($loDados);
                $loIdLocalidade = $loDados["id"];
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido", "id" => $loIdLocalidade );
            }

        }

         return $loRetorno;

    }

    public function ListaItensConsulta($loDados){

        $loLocalidade = new localidadeBOA();
        $loItensConsulta = $loLocalidade->ListaItensConsulta($loDados);

        return $loItensConsulta;

    }

    public function GridConsultaItens($loDados){

        $loLocalidade = new localidadeBOA();
        $loGridItens = $loLocalidade->GridConsultaItens($loDados);

        return $loGridItens;

    }

    public function AlteraConsultaCliente($loDados){

        $loLocalidade = new localidadeBOA();
        $loConsulta = $loLocalidade->AlteraConsultaCliente($loDados);

        return $loConsulta;

    }  

    public function DesativarLocalidade($loDados){

       $loRetorno[] = null; 

        $loLocalidade = new localidadeBOA();
        $loDesativa = $loLocalidade->DesativarLocalidade($loDados);
        return $loRetorno;
    }

    public function ListaCategorias($loDados){

        $loDdConsulta = null;
        $loId = null;

        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loId = $loDados["id"];
            $loDdConsulta .=  " AND id_cat_localidade = ".$loId; 

        }else{
            $loDdConsulta .= " AND ativo = 1 ";
        }

        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }              

        $loCategoria = new localidadeBOA();
        $loLista = $loCategoria->ListaCategorias($loDdConsulta);

        return $loLista;

    }


    public function ListaLogradouro($loDados){

        $loLocalidade = new localidadeBOA();
        $loItens = $loLocalidade->ListaLogradouro($loDados);
        return $loItens;
    }

} 

?>