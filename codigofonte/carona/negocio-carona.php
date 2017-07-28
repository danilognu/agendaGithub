<?php
include('persistencia-carona.php');
require_once '../../comum/PHPMailer-master/class.phpmailer.php';

class caronaBO{

    public function ListaCarona($loDados){

        $loComumParametros = new comumBO();
        $loDdConsulta = null;


        $loId = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loId = $loDados["id"];
            $loDdConsulta .=  " AND solicitacao.id_solicitacao = ".$loId; 
        }
        $loSituacao = null;
        if(isset($loDados["situacao"]) && !empty($loDados["situacao"]) ){
            $loSituacao = $loDados["situacao"];
            $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao IN(".$loSituacao.")"; 
        }else{
            if(!isset($loDados["id"])){
                $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao NOT IN(4,5) "; 
            }
        }
        
        if(isset($loDados["mapa_solicitacao"]) && !empty($loDados["mapa_solicitacao"]) ){
            if(!isset($loDados["situacao"]) && empty($loDados["situacao"]) ){
                $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao = 1"; 
            }
        }
        

        $loCodigoOrigem = null;
        if(isset($loDados["codigo_origem"]) && !empty($loDados["codigo_origem"]) ){
            $loCodigoOrigem = $loDados["codigo_origem"];
            $loDdConsulta .=  " AND localidade.id_localidade = ".$loCodigoOrigem; 
        }

        $loCodigoDestino = null;
        if(isset($loDados["codigo_destino"]) && !empty($loDados["codigo_destino"]) ){
            $loCodigoDestino = $loDados["codigo_destino"];
            $loDdConsulta .=  " AND solicitacao.id_solicitacao in(
                                    SELECT destinos.id_solicitacao FROM destinos 
                                    iNNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                                    WHERE localidade.id_localidade = ".$loCodigoDestino."
                                )"; 
        }        

        $loDtSaida = null;
        if( (isset($loDados["dt_saida"]) && !empty($loDados["dt_saida"])) ){
            $loDtSaida = $loComumParametros->AdicionaComBarraDataHora($loDados["dt_saida"]);
            $loDdConsulta .=  " AND dt_saida >= '".$loDtSaida." 00:00' and dt_saida <= '".$loDtSaida." 23:59'"; 
        }

        $loDtRetornoPrev = null;
        if( (isset($loDados["dt_retorno_prev"]) && !empty($loDados["dt_retorno_prev"]))  ){
            $loDtRetornoPrev = $loComumParametros->AdicionaComBarraDataHora($loDados["dt_retorno_prev"]);
            $loDdConsulta .=  " AND dt_evento >= '".$loDtRetornoPrev." 00:00' and dt_evento <= '".$loDtRetornoPrev." 23:59'"; 
        }


        $loPlaca = null;
        if(isset($loDados["placa"]) && !empty($loDados["placa"]) ){
            $loPlaca = $loDados["placa"];
            $loDdConsulta .=  " AND veiculo.placa = '".$loPlaca."'"; 
        }
        $loIdMotorista = null;
        if(isset($loDados["id_motorista"]) && !empty($loDados["id_motorista"]) ){
            $loIdMotorista = $loDados["id_motorista"];
            $loDdConsulta .=  " AND solicitacao.id_pessoa_motorista = ".$loIdMotorista; 
        }

       /* $loDdConsulta .=  " AND (SELECT COUNT(id_passageiros) conta_passageiro
                            FROM passageiros conta_passageiro_exitente
                            WHERE id_solicitacao = solicitacao.id_solicitacao 
                            AND id_pessoa_passageiro IN(SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"]." )) = 0";*/



        $loLimit = null;
        if(isset($loDados["not_limit"]) && !empty($loDados["not_limit"]) ){
            $loLimit = $loDados["not_limit"];
            if($loLimit > 0 ){
                $loDdConsulta .=  " ORDER BY solicitacao.id_solicitacao DESC LIMIT ".$loLimit; 
            }

        }



        //Verifica se a quantidade de passageiros do veiculo ja foi prenchida
        //$loDdConsulta .=  " AND (SELECT COUNT(id_passageiros) FROM passageiros WHERE id_solicitacao = solicitacao.id_solicitacao ) < veiculo.qtd_passageiro "; 

      
        $loCarona = new caronaBOA();
        $loLista = $loCarona->ListaCarona($loDdConsulta);

        return $loLista;

    }

    public function BuscaPessoaUsuario(){

        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->BuscaPessoaUsuario();

        return $loConsulta;   

    }

  
    public function EnviaEmailAutorizador($mbDados){

        $loIdPessoaAutorizante      = $mbDados["id_pessoa_autorizante"];
        $loIdSolicitacao            = $mbDados["id_solicitacao"]; 
        $loNomePessoaSolicitante    = $_SESSION["nome"];
        $loNome                     = NULL;
        $loEmail                    = NULL;


        //Grava dados Solicitacao de Carona
        $this->GravaSolicitacaoDeCarona($mbDados);
        //Pega informações para envio do EnviaEmailAutorizador
        $loTextoEmail = $this->BuscaDadosSolicitacaoEmail($loIdSolicitacao);
        
        $loCarona = new caronaBOA();
        $loDados = $loCarona->DadosEnvioEmail($loIdPessoaAutorizante);
        foreach ($loDados as $row){
            $loNome  = $row["nome"];
            $loEmail = $row["email"];
        }

        $loIdPessoaUsuario = $this->BuscaPessoaUsuario();

        // Instanciar a classe para envio de email
        $mail = new PHPMailer(true);

        // Vamos tentar realizar o envio
        try {

            // Remetente
            $mail->AddReplyTo('lets@Lets.com', utf8_decode('Solicitação de Carona'));
            $mail->SetFrom('lets@Lets.com', utf8_decode('Solicitação de Carona'));

            // Destinatário
           // $mail->AddAddress($loEmail, 'Destinatário');
            $loDadosOperadores = $this->ListaTodosOsOperadores();

            foreach ($loDadosOperadores as $row){

                if($row["email"] != ""){
                    $mail->AddAddress($row["email"], 'Destinatário');
                }
            }

            // Assunto
            $mail->Subject = utf8_decode('Solicitação de Carona');

            // Mensagem para clientes de email sem suporte a HTML
            $mail->AltBody = utf8_decode('Solicitação de Carona');

            // Mensagem para clientes de email com suporte a HTML
            $loHTML = "<strong>Solicitação de Carona.</strong> <br />";
            $loHTML .= "<p>Segue um solicitação de carona para: <strong>".$loNomePessoaSolicitante."</strong> </p>";
            $loHTML .= "<br />".$loTextoEmail;
            $loMntVar = "id_pessoa_solicitante=".$loIdPessoaUsuario."&id_solicitacao=".$loIdSolicitacao."&status=A&via_email=1";
            $loHTML .= "<p>
                            <a href='http://sistema2.lets.com.br:89/codigofonte/solicitacao/apresentacao/envia-aprovacao-negacao-carona-ajax.php?id_pessoa_solicitante=".$loIdPessoaUsuario."&id_solicitacao=".$loIdSolicitacao."&status=A&via_email=1&tipo=email'>
                                Aprovar
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href='http://sistema2.lets.com.br:89/codigofonte/solicitacao/apresentacao/envia-aprovacao-negacao-carona-ajax.php?id_pessoa_solicitante=".$loIdPessoaUsuario."&id_solicitacao=".$loIdSolicitacao."&status=C&via_email=1&tipo=email'>
                            Não Aprovar</a>
                        </p>";

            $loHTML = utf8_decode($loHTML);
            $mail->MsgHTML($loHTML);

            // Adicionar anexo
            //$caminho = $loPasta."/";
            //$ficheiro = $loArquivo;

            //$mail->AddAttachment($caminho.$ficheiro);

            // Enviar email
            $mail->Send();

            $loRetorno = array("erro" => false, "mensagem" => $loIdSolicitacao);

            //echo "Mensagem enviada!";
        }
        catch (phpmailerException $e) {
            // Mensagens de erro do PHPMailer
            $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage());
        }
        catch (Exception $e) {
            // Outras mensagens de erro
            $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage());
        }

        return $loRetorno;

    }    

    public function ListaTodosOsOperadores(){

        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->ListaTodosOsOperadores();

        return $loConsulta;       

    }

    public function BuscaDadosSolicitacaoEmail($mbDados){

        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->BuscaDadosSolicitacaoEmail($mbDados);

        return $loConsulta;     

    }

    public function ListaCaronasSolicitadas($mbDados){

        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->ListaCaronasSolicitadas($mbDados);

        return $loConsulta;     

    }

    public function GravaSolicitacaoDeCarona($mbDados){

        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->GravaSolicitacaoDeCarona($mbDados);

        return $loConsulta;     

    }

    public function ListaPassageiros($loDados){
        
        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->ListaPassageiros($loDados);

        return $loConsulta;     

    }

    public function ListaDestino($loDados){
        
        $loCarona = new caronaBOA();
        $loConsulta = $loCarona->ListaDestino($loDados);

        return $loConsulta;     

    }

    public function ListaPessoa($loDados){


        $loDdConsulta = null;
        
        if(isset($loDados["tipo_pessoa"])){
            $loTipoPessoa = $loDados["tipo_pessoa"];
            $loDdConsulta =  " AND tipo_pessoa.id_tipo_pessoa IN(".$loTipoPessoa.")"; 
        }

        $loID = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loID = $loDados["id"];
            $loDdConsulta .=  " AND pessoa.id_pessoa = ".$loID; 

        }
        $loNome = null;
        if(isset($loDados["nome"]) && !empty($loDados["nome"]) ){
            $loNome = $loDados["nome"];
            $loDdConsulta .=  " AND pessoa.nome like '%".utf8_decode($loNome)."%'"; 

        }
        $loCnpj = null;
        if(isset($loDados["cnpj"]) && !empty($loDados["cnpj"]) ){
            $loCnpj = $loDados["cnpj"];
            $loDdConsulta .=  " AND pessoa.cnpj like '%".$loCnpj."%'"; 

        }        
        $loCpf = null;
        if(isset($loDados["cpf"]) && !empty($loDados["cpf"]) ){
            $loCpf = $loDados["cpf"];
            $loDdConsulta .=  " AND pessoa.cpf like '%".$loCpf."%'"; 

        }
        $loStatus = null;
        if(isset($loDados["status"]) && strlen($loDados["status"]) >= 1){
            $loStatus= $loDados["status"];
            $loDdConsulta .=  " AND pessoa.ativo in(".$loStatus.")";
        }else{
            $loDdConsulta .=  " AND pessoa.ativo = 1";
        }
        $loIndPassageiro = null;
        if(isset($loDados["ind_passageiro"]) && !empty($loDados["ind_passageiro"]) ){
            $loIndPassageiro = $loDados["ind_passageiro"];
            $loDdConsulta .=  " AND pessoa.ind_passageiro = ".$loIndPassageiro; 

        }
        $loIndMotorista = null;
        if(isset($loDados["ind_motorista"]) && !empty($loDados["ind_motorista"]) ){
            $loIndMotorista = $loDados["ind_motorista"];
            $loDdConsulta .=  " AND pessoa.ind_motorista = ".$loIndMotorista; 

        } 
        $loIndCondutor = null;
        if(isset($loDados["ind_condutor"]) && !empty($loDados["ind_condutor"]) ){
            $loIndCondutor = $loDados["ind_condutor"];
            $loDdConsulta .=  " AND pessoa.ind_condutor = ".$loIndCondutor; 

        }        

        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND pessoa.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }

        $loDdConsulta .= " AND id_pessoa IN(
                                        SELECT id_pessoa_pai 
                                        FROM autorizadores WHERE id_pessoa_filho IN(
                                                SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"].")
                                      )";

        $loCarona = new caronaBOA();
        $loListaPessoas = $loCarona->ListaPessoas($loDdConsulta);

        return $loListaPessoas;

    }


} 

?>