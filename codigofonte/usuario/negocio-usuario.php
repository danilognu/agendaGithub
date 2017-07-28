<?php
include_once('persistencia-usuario.php');

class usuarioBO{

    public function ListaUsuarios($loDados){

        $loUsuario = new usuarioBOA();

        $loTipo = $loDados["tipo"];

        $loDadosEnvio = "";
        switch ($loTipo) {
            case "exibir":
                $loID = $loDados["id"];
                $loDadosEnvio = " AND usuario.id_usuario = ".$loID;
                break;
        }

        if(isset($loDados["filtroStatus"]) && !empty($loDados["filtroStatus"]) || (isset($loDados["filtroStatus"]) && $loDados["filtroStatus"] == "0") ){     
            $loDadosEnvio .= " AND usuario.ativo = ".$loDados["filtroStatus"];
        }

        $loNome = null;
        if(isset($loDados["nome"]) && !empty($loDados["nome"]) ){
            $loNome = $loDados["nome"];
            $loDadosEnvio .=  " AND usuario.nome like  '%".$loNome."%'"; 

        }


        if($_SESSION["supervisor"] != 1){    
            $loDadosEnvio .= " AND usuario.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }

        if(isset($loDados["idNotUsuario"]) && !empty($loDados["idNotUsuario"]) ){
            $loDadosEnvio .= " AND usuario.id_usuario NOT IN(".$loDados["idNotUsuario"].")";
        }
        if(isset($loDados["idmax"]) && !empty($loDados["idmax"]) ){
            $loDadosEnvio .= " AND usuario.id_usuario >= ".$loDados["idmax"];
        }

        //Não exibe supervisor
        $loDadosEnvio .= " AND usuario.id_usuario NOT IN(32)";

        $loListaUsuarios = $loUsuario->ListaUsuarios($loDadosEnvio);

        return $loListaUsuarios;

    }

    public function GravarUsuario($loDados,$loCodigosPessoaQuemAutorizo,$loCodigosPessoaQuemMeAutoriza){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );


        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o nome.";

        }

        if($loDados["login"] == ""){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o login.";
        }

        if($loDados["senha"] != ""){

            if( $loDados["confirSenha"] == ""){
                $loResultadoOperacao = true;
                $loResultadoMessagem = "Favor preencher a cofirmação de senha.";
            }

            if($loDados["senha"] != $loDados["confirSenha"]){
                $loResultadoOperacao = true;
                $loResultadoMessagem = " A senha esta diferente da confirmação de senha. ";
            }

        }

        if(isset($loDados["email"]) && $loDados["email"] == "" ){
             $loResultadoOperacao = true;
             $loResultadoMessagem = "Favor preencher o e-mail.";
        }
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loDadosUsuario = new usuarioBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosUsuario->IncluirUsuario($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosUsuario->AlterarUsuario($loDados,$loCodigosPessoaQuemAutorizo,$loCodigosPessoaQuemMeAutoriza);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }

     public function PesquisaAutorizadoresUsuario($mbUsuario){

         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->PesquisaAutorizadoresUsuario($mbUsuario);

         return $loRetrono;

     }

     public function PesquisaQueAutorizaUsuarioCorrente($mbUsuario){

         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->PesquisaQueAutorizaUsuarioCorrente($mbUsuario);

         return $loRetrono;

     }     

     public function IncluirUsuarioAutorizador($mbItens,$mbIdUsuario){
         
         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->IncluirUsuarioAutorizador($mbItens,$mbIdUsuario);

         return $loRetrono;

     }

     public function VerificaSeUsuarioAutoriza($mbDados){
         
         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->VerificaSeUsuarioAutoriza($mbDados);

         return $loRetrono;

     }

     public function ExcluirUsuarioAutorizador($mbDados){
         
         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->ExcluirUsuarioAutorizador($mbDados);

         if($loRetrono){
             $loRetorno = array("erro" => false, "messagem" => "Incluido" );
         }

         return $loRetrono;

     }

     public function BuscaNomeFilial($mbDados){
         
         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->BuscaNomeFilial($mbDados);

         return $loRetrono;

     }     

     public function BuscaIDGrupoUsuarioLogado(){
         
         $loUsuario = new usuarioBOA();

         $loRetrono = $loUsuario->BuscaIDGrupoUsuarioLogado();

         return $loRetrono;

     }     

} 

?>