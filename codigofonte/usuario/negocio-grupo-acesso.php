<?php
include('persistencia-grupo-acesso.php');

class grupoAcessoBO{

    public function ListaGrupoAcesso($loDados){

        $loGrupo = new grupoAcessoBOA();


        $loLista = $loGrupo->ListaGrupoAcesso($loDados);

        return $loLista;

    }

    public function GravarGrupo($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );


        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o nome.";

        }

         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loGrupo = new grupoAcessoBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loGrupo->IncluirGrupo($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loGrupo->AlterarGrupo($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }


     public function ListaMenuMae(){

        $loGrupo = new grupoAcessoBOA();

        $loLista = $loGrupo->ListaMenuMae();

        return $loLista;

    }


    public function ListaMenuFilho($loId){

        $loGrupo = new grupoAcessoBOA();

        $loLista = $loGrupo->ListaMenuFilho($loId);

        return $loLista;

    }

    public function VerificaPermissao($loDados){

        $loGrupo = new grupoAcessoBOA();

        $loLista = $loGrupo->VerificaPermissao($loDados);

        return $loLista;

    }

    public function GravarPermissao($loDados){

        $loGrupo = new grupoAcessoBOA();

        $loLista = $loGrupo->GravarPermissao($loDados);

        return $loLista;

    }

    public function ExcluirGrupo($loDados){

        $loGrupo = new grupoAcessoBOA();

        $loLista = $loGrupo->ExcluirGrupo($loDados);

        return $loLista;

    }

    public function AlteraGrupoAcessoIdentificacao($loDados){

        $loGrupo = new grupoAcessoBOA();

        $loLista = $loGrupo->AlteraGrupoAcessoIdentificacao($loDados);
        

        $loRetorno = array("erro" => false, "messagem" => "Incluido" );
        return  $loRetorno;

    }   


} 

?>