<?php

session_start();
include 'persistencia-login.php';

class usuarioBO{ 



    public function VerificaUsuario($Dados){

        $loUsuario = new usuarioBOA();

        $loDadosUsuarios =  $loUsuario->VerificaUsuario($Dados);

        $loMessagem = "";
        if($loDadosUsuarios['id_usuario'] == ""){
            $loMessagem = "Login ou senha, Incorretos!";
        }

        $loDadosRetorno = array(
                            "id_usuario" => $loDadosUsuarios['id_usuario'], 
                            "nome"       => $loDadosUsuarios['nome'],
                            "login"      => $loDadosUsuarios['login'],
                            "messagem"   => $loMessagem,
                            "id_grupo"   => $loDadosUsuarios["id_grupo"]
                            );

        
        $_SESSION["id_usuario"] = $loDadosUsuarios['id_usuario'];
        $_SESSION["nome"] = $loDadosUsuarios['nome'];
        $_SESSION["login"] = $loDadosUsuarios['login'];
        $_SESSION["id_pessoa_matriz"] = $loDadosUsuarios['id_pessoa_matriz'];
        $_SESSION["supervisor"] = $loDadosUsuarios['ind_supervisor'];

        return $loDadosRetorno;
    }

    public function VerificaEmail($loDados){

        $loEmail = $loDados["email"];
        
        $loUsuario = new usuarioBOA();
        $loRetorno = $loUsuario->VerificaEmail($loDados);

        if(count($loRetorno) > 0 && $loEmail != ""){
            foreach ($loRetorno as $row){

                $loIdUsuario    = $row["id_usuario"];
                $loNome         = $row["nome"];
                $loEmail        = $row["email"];

                $loNovaSenha = rand(0, 10000);
                $loNovaSenha64 = base64_encode($loNovaSenha);

                $loUsuario->AtualizaRecuperacaoSenha($loIdUsuario,$loNovaSenha64);
                $this->EnviarEmailRecuperarSenha($loEmail,$loNome,$loNovaSenha);
                $loRetorno = array("localizado" => 1, "messagem" => "Um e-mail foi enviado com as informações de acesso! ".$loNovaSenha );

            }
        }else{
             $loRetorno = array("localizado" => 0, "messagem" => "E-mail não incorreto!" );
        }


        return $loRetorno;
    }

    public function EnviarEmailRecuperarSenha($mbEmail,$mbNome,$mbSenha){

        //base64_encode()
         $para = $mbEmail;
         $assunto = "Agenda Let's";
         $mensagem = $mbNome." segue nova senha de acesso: ".$mbSenha;

        $headers =  "Content-Type:text/html; charset=UTF-8\n";
        $headers .= "From:  lets.com.br\n"; 
        $headers .= "X-Sender:  \n"; 
        $headers .= "X-Mailer: PHP  v".phpversion()."\n";
        $headers .= "X-IP:  ".$_SERVER['REMOTE_ADDR']."\n";
        $headers .= "Return-Path:  \n"; 
        $headers .= "MIME-Version: 1.0\n";

        mail($para, $assunto, $mensagem, $headers);  //função que faz o envio do email.

    }


}   

?>