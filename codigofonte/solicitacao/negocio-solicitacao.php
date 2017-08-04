<?php
include('persistencia-solicitacao.php');
require_once '../../comum/PHPMailer-master/class.phpmailer.php';
require_once '../../comum/PHPMailer-master/PHPMailerAutoload.php';


class solicitacaoBO{

    public function ListaSolicitacao($loDados){

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
            if($loSituacao == 0){
                $loSituacao = "1,2,3,6,7";
            }

            $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao IN(".$loSituacao.")"; 
        }else{
            if(!isset($loDados["id"])){
                $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao NOT IN(4,5) "; 
            }
        }

        if( isset($loDados["nome_requisitante"])  && !empty($loDados["nome_requisitante"]) ){
            $loDdConsulta .=  " AND pessoa_motorista_passageiro.nome LIKE '%".$loDados["nome_requisitante"]."%'"; 
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

        $loSituacao = null;
        if( (isset($loDados["dt_evento_ini"]) && !empty($loDados["dt_evento_ini"])) && (isset($loDados["dt_evento_fim"]) && !empty($loDados["dt_evento_fim"])) ){
            $loDtEventoIni = $loComumParametros->AdicionaDate($loDados["dt_evento_ini"]);
            $loDtEventoFim = $loComumParametros->AdicionaDate($loDados["dt_evento_fim"]);
            $loDdConsulta .=  " AND dt_evento >= '".$loDtEventoIni." 00:00' and dt_evento <= '".$loDtEventoFim." 23:59'"; 
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


        if(isset($loDados["ind_carona"]) && $loDados["ind_carona"] == 1){
            $loDdConsulta .=  " AND solicitacao.id_solicitacao IN(
                    SELECT id_solicitacao FROM solicitacao_carona 
                    WHERE solicitacao_carona.id_solicitacao = solicitacao.id_solicitacao
                    AND solicitacao_carona.id_pessoa_autorizador IN( 
                        SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"].")
                  AND solicitacao_carona.status IS NULL ) ";
        }

       //Verifica Grupo de Acesso Usuario Corrente
       if( isset($loDados["tela_solicitacao"]) && $loDados["tela_solicitacao"] == 1 ){
            $loCodigoGrupoUsuario = $this->VerificaGrupoAcessoUsuario();
            //Comentado tela de solicitacao so exibia as solicitações feitas pelo usuario requisitante 
           /* if($loCodigoGrupoUsuario["ind_usuario"] == 1 || $loCodigoGrupoUsuario["ind_gestor"] == 1 ){
                $loDdConsulta .=  " AND solicitacao.id_pessoa_requisitante IN( SELECT id_pessoa_origem FROM usuario where id_usuario = ".$_SESSION["id_usuario"].")";
            }*/

            if($loCodigoGrupoUsuario["ind_usuario"] == "1" || $loCodigoGrupoUsuario["ind_gestor"] == "1"){
                $loDdConsulta .=  " AND ( ( 
	                                    solicitacao.id_pessoa_requisitante IN( SELECT id_pessoa_origem FROM usuario where id_usuario =  ".$_SESSION["id_usuario"].") 
                                        OR 
                                        solicitacao.id_pessoa_requisitante IN( 
                                        SELECT id_pessoa_filho FROM autorizadores WHERE id_pessoa_pai IN(SELECT id_pessoa_origem FROM usuario WHERE id_usuario =  ".$_SESSION["id_usuario"].")
                                        ) 
                                    ) OR solicitacao.id_usuario_cad = ".$_SESSION["id_usuario"]. ") " ;
            }


       }
       if( isset($loDados["tela_atendimento"]) && $loDados["tela_atendimento"] == 1 ){

            $loCodigoGrupoUsuario = $this->VerificaGrupoAcessoUsuario();
            if($loCodigoGrupoUsuario["ind_usuario"] == "1" || $loCodigoGrupoUsuario["ind_gestor"] == "1"){
                $loDdConsulta .=  " AND ( ( 
	                                    solicitacao.id_pessoa_requisitante IN( SELECT id_pessoa_origem FROM usuario where id_usuario =  ".$_SESSION["id_usuario"].") 
                                        OR 
                                        solicitacao.id_pessoa_requisitante IN( 
                                        SELECT id_pessoa_filho FROM autorizadores WHERE id_pessoa_pai IN(SELECT id_pessoa_origem FROM usuario WHERE id_usuario =  ".$_SESSION["id_usuario"].")
                                        ) 
                                    ) OR solicitacao.id_usuario_cad = ".$_SESSION["id_usuario"]. ")";
            }

        }

        //Verifica se a aprovação é via email
        if(isset($loDados["aprovacao_via_email"])){
            $loIsAprovacaoViaEmail = true;
        }else{
            $loIsAprovacaoViaEmail = false;
        }

        if( (isset($_SESSION["supervisor"]) && $_SESSION["supervisor"] != 1) && !$loIsAprovacaoViaEmail ){    
            $loDdConsulta .= " AND solicitacao.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }   

        //ORDER BY \/
        $loLimit = null;
        if(isset($loDados["not_limit"]) && !empty($loDados["not_limit"]) ){
            $loLimit = $loDados["not_limit"];
            if($loLimit > 0 ){
                $loDdConsulta .=  " ORDER BY solicitacao.id_solicitacao DESC LIMIT ".$loLimit; 
            }

        }

        if(isset($loDados["ordenar"]) && !empty($loDados["ordenar"]) ){
            
            switch ($loDados["ordenar"]) {
                case "evento":
                    $loDdConsulta .=  " ORDER BY solicitacao.dt_evento "; 
                    break;
                case "cod_solic":
                    $loDdConsulta .=  " ORDER BY solicitacao.id_solicitacao ";
                    break;
                case "situacao":
                   $loDdConsulta .=  " ORDER BY status_solicitacao.nome "; 
                    break;
                case "origem":
                    $loDdConsulta .=  " ORDER BY localidade.nome "; 
                    break;
                case "destino":
                    $loDdConsulta .=  " ORDER BY (
                                        SELECT 
                                            localidade.nome 
                                        FROM destinos 
                                        INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                                        WHERE destinos.id_solicitacao = solicitacao.id_solicitacao
                                        ORDER BY destinos.id_destino DESC LIMIT 1
                                        ) ";    
                  break;                                        
            }

        }




        $loSolicitacao = new solicitacaoBOA();
        $loLista = $loSolicitacao->ListaSolicitacao($loDdConsulta);

        return $loLista;

    }

    public function GravarSolicitacao($loDados,$loCodigosParada,$loCodigosPassageiro,$loCodigosOrigem,$loDadosAtendimento){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );


        if($loDados["dt_retorno_prev"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher data de retorno previsto.";

        }     

        if($loDados["dt_saida"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher data de saida.";

        }

        if($loDados["dt_evento"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher data do evento.";

        }   

        if($loDados["id_status_solicitacao"] == ""){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher a Situação.";
        }

        if($loDados["id_status_solicitacao"] == "5" && $loDadosAtendimento["id_veiculo"] == "" ){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o veiculo para fechar.";
        }
        
        if($loDados["id_status_solicitacao"] == "5" && $loDadosAtendimento["id_pessoa_motorista"] == "" ){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o motorista para fechar.";
        }
      

        if($loDados["id_status_solicitacao"] == 4 && $loDados["id_motivo_cancelamento"] == ""){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o motivo do cancelamento.";
        }



        if(count($loCodigosPassageiro) == 0){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher um Passageiro.";            
        }
        if(count($loCodigosOrigem) == 0){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher um Destino de Origem.";            
        }
        if(count($loCodigosParada) == 0){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher um Destino.";            
        }

        $loVericaSaidaComHabilitacao = $this->VerificaDataValidadeHabilitacaoConsultor($loDados["dt_saida"]);

        if($loVericaSaidaComHabilitacao && $loDados["ind_com_motorista"] == 0){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Condutor com a data de validade da habilita&ccedil;&atilde;o vencida, considerando a data de saida.";            
        }

        $loVericaRetornoPrevComHabilitacao = $this->VerificaDataValidadeHabilitacaoConsultor($loDados["dt_retorno_prev"]);

        if($loVericaRetornoPrevComHabilitacao && $loDados["ind_com_motorista"] == 0){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Condutor com a data de validade da habilita&ccedil;&atilde;o vencida, considerando a data de retorno prev.";            
        }

        if($loDados["ind_viagem"] == 0 && $loDados["ind_com_motorista"] == 0){
            $loCategoriasRequisitante = $this->BuscaCategoriaRequisitante($loDados["codigoRequisitante"]);
           
            if($loCategoriasRequisitante["ind_condutor"] == 0 || $loCategoriasRequisitante["ind_condutor"] == ""){
                $loResultadoOperacao = true;
                $loResultadoMessagem = "Por favor, selecione o tipo da solita&ccedil;&atilde;o, 'Viagem' ou 'Com Motorista' "; 
            }
        }

        //Verifica Categoria Requisitante da viagem e tipo de solicitação
        if($loDados["ind_com_motorista"] == 0){
            $loCategoriasRequisitante = $this->BuscaCategoriaRequisitante($loDados["codigoRequisitante"]);

            if($loCategoriasRequisitante["ind_passageiro"] == 1 && $loDados["ind_viagem"] == 1 ){
                if($loCategoriasRequisitante["ind_condutor"] == 0 || $loCategoriasRequisitante["ind_condutor"] == ""){
                    $loResultadoOperacao = true;
                    $loResultadoMessagem = "Requisitante &eacute; um passageiro, n&atilde;o pode solicitar uma viagem, por favor, selecione o tipo da solita&ccedil;&atilde;o como: 'Com Motorista'! ";  
                }
            }
        }

        
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{

            $loIdSolicitacaoRetorno  = null;
            $loDadosSolicitacao = new solicitacaoBOA();

            if($loDados["acao"] == "I"){
                $loIdSolicitacaoRetorno = $loDadosSolicitacao->IncluirSolicitacao($loDados,$loCodigosParada,$loCodigosPassageiro,$loCodigosOrigem);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosSolicitacao->AlterarSolicitacao($loDados,$loCodigosParada,$loCodigosPassageiro,$loCodigosOrigem,$loDadosAtendimento);
            }


            $loRetorno = array("erro" => false, "messagem" => "Incluido", "id_solicitacao" => $loIdSolicitacaoRetorno);


        }

         return $loRetorno;

    }

    public function BuscaCategoriaRequisitante($loDados){

        $loSolicitacao= new solicitacaoBOA();
        $loItensConsulta = $loSolicitacao->BuscaCategoriaRequisitante($loDados);

        return $loItensConsulta;

    }

    public function VerificaIgualdadeDestinos($loDados,$loId){

        $loSolicitacao= new solicitacaoBOA();
        $loItensConsulta = $loSolicitacao->VerificaIgualdadeDestinos($loDados,$loId);

        return $loItensConsulta;

    }

    public function ListaItensConsulta($loDados){

        $loSolicitacao= new solicitacaoBOA();
        $loItensConsulta = $loSolicitacao->ListaItensConsulta($loDados);

        return $loItensConsulta;

    }

    public function GridConsultaItens($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loGridItens = $loSolicitacao->GridConsultaItens($loDados);

        return $loGridItens;

    }

    public function AlteraConsultaSolicitacao($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->AlteraConsultaSolicitacao($loDados);

        return $loConsulta;

    }  

    public function ListaSituacao($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaSituacao($loDados);

        return $loConsulta;

    }  

    public function ListaPassageiros($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaPassageiros($loDados);

        return $loConsulta;

    }  

    
    public function ListaOrigem($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaOrigem($loDados);

        return $loConsulta;

    }  

    public function ListaDestinos($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaDestinos($loDados);

        return $loConsulta;

    }  


    public function ListaMapaAtendimentos($loDados){

        $loComumParametros = new comumBO();
        $loDdConsulta = null;



        $loSituacao = null;
        if(isset($loDados["situacao"]) && !empty($loDados["situacao"]) ){
            $loSituacao = $loDados["situacao"];
            $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao IN(".$loSituacao.")"; 
        }else{
             $loDdConsulta .=  " AND status_solicitacao.id_status_solicitacao IN(2,3)"; 
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

        $loSituacao = null;
        if( (isset($loDados["dt_evento_ini"]) && !empty($loDados["dt_evento_ini"])) && (isset($loDados["dt_evento_fim"]) && !empty($loDados["dt_evento_fim"])) ){
            $loDtEventoIni = $loComumParametros->AdicionaDate($loDados["dt_evento_ini"]);
            $loDtEventoFim = $loComumParametros->AdicionaDate($loDados["dt_evento_fim"]);
            $loDdConsulta .=  " AND dt_evento >= '".$loDtEventoIni." 00:00' and dt_evento <= '".$loDtEventoFim." 23:59'"; 
        }

        if(isset($loDados["ordenar"]) && !empty($loDados["ordenar"]) ){
            
            switch ($loDados["ordenar"]) {
                case "evento":
                    $loDdConsulta .=  " ORDER BY solicitacao.dt_evento "; 
                    break;
                case "cod_solic":
                    $loDdConsulta .=  " ORDER BY solicitacao.id_solicitacao ";
                    break;
                case "situacao":
                   $loDdConsulta .=  " ORDER BY status_solicitacao.nome "; 
                    break;
                case "origem":
                    $loDdConsulta .=  " ORDER BY localidade.nome "; 
                    break;
                case "destino":
                    $loDdConsulta .=  " ORDER BY (
                                        SELECT 
                                            localidade.nome 
                                        FROM destinos 
                                        INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                                        WHERE destinos.id_solicitacao = solicitacao.id_solicitacao
                                        ORDER BY destinos.id_destino DESC LIMIT 1
                                        ) ";    
                  break;                                        
            }

        }


        $loLimit = null;
        if(isset($loDados["not_limit"]) && !empty($loDados["not_limit"]) ){
            $loLimit = $loDados["not_limit"];
            if($loLimit > 0 ){
                $loDdConsulta .=  " ORDER BY id_solicitacao DESC LIMIT ".$loLimit; 
            }

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


        
        $loSolicitacao = new solicitacaoBOA();
        $loLista = $loSolicitacao->ListaMapaAtendimentos($loDdConsulta);

        return $loLista;

    }

    public function AutorizacaoPDF($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->AutorizacaoPDF($loDados);

        return $loConsulta;

    }  

    public function EnviarEmailAtorizacaoMotorista($mbDados){

        $loNome = NULL;
        $loEmail = NULL;
        $loArquivo = $mbDados["arquivo"];
        $loPasta = $mbDados["pasta"];


        $loSolicitacao = new solicitacaoBOA();
        $loDados = $loSolicitacao->DadosEnvioEmail($mbDados);
        foreach ($loDados as $row){
            $loNome  = $row["nome"];
            $loEmail = $row["email"];
        }

        


        // Instanciar a classe para envio de email
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); 

        // Vamos tentar realizar o envio
        try {

           $loComumParametros = new comumBO();
           $loDdEmail = $loComumParametros->ConfiguracaoHostEmail();

            $mail->Host = $loDdEmail["HOST"];
            $mail->Port = $loDdEmail["PORTA"]; 

            // Remetente
            $mail->AddReplyTo($loDdEmail["EMAIL"], 'Agendamento Lets');
            $mail->SetFrom($loDdEmail["EMAIL"], 'Agendamento Lets');

            // Destinatário
            $mail->AddAddress($loEmail, 'Destinatario');

            // Assunto
            $mail->Subject = 'Autorizacao Agendamento';

            // Mensagem para clientes de email sem suporte a HTML
            $mail->AltBody = 'Autorizacao Agendamento';

            // Mensagem para clientes de email com suporte a HTML
            $mail->MsgHTML('<p>'.$loNome.' Segue a autorizacao em anexo.</p>');

            // Adicionar anexo
            $caminho = $loPasta."/";
            $ficheiro = $loArquivo;

            $mail->AddAttachment($caminho.$ficheiro);

            // Enviar email
            $mail->Send();

            //echo "Mensagem enviada!";
        }
        catch (phpmailerException $e) {
            // Mensagens de erro do PHPMailer
            echo $e->errorMessage();
        }
        catch (Exception $e) {
            // Outras mensagens de erro
            echo $e->getMessage();
        }


    }    


   public function DisplayMotoristas($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->DisplayMotoristas($loDados);

        return $loConsulta;

    }  

   public function ListaRequisitante($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaRequisitante($loDados);

        return $loConsulta;

    }      

    public function GavaAtendimentoRotas($loDados){

        $loIndPanejado = $loDados["ind_planejado"];
        $loMotivoNaoPlanejadmento = $loDados["id_mot_plan"];
        $loResultadoOperacao = false;
        
        if($loIndPanejado == "0" && $loMotivoNaoPlanejadmento == ""){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Motivo do nao Planejamento.";
        }
     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{

             $loSolicitacao = new solicitacaoBOA();
             $loConsulta = $loSolicitacao->GavaAtendimentoRotas($loDados);
             $loRetorno = array("erro" => false, "messagem" => '');

        }

        return $loRetorno;

    }

    public function GavaAtendimentoRotasObsOutros($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->GavaAtendimentoRotasObsOutros($loDados);

        return $loConsulta;

    }

    public function RemoveDestino($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->RemoveDestino($loDados);

        return $loConsulta;        
    }

    public function ListaLocalidade($loDados){

        $loDdConsulta = "";

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
        $loId = null;
        if(isset($loDados["id_localidade"]) && !empty($loDados["id_localidade"]) ){
            $loId = $loDados["id_localidade"];
            $loDdConsulta .=  " AND localidade.id_localidade = ".$loId; 

        }

        $loIdsolicitacao = null;
        if(isset($loDados["id_solicitacao"]) && !empty($loDados["id_solicitacao"]) ){
            $loIdsolicitacao = $loDados["id_solicitacao"];
        }

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaLocalidade($loDdConsulta,$loIdsolicitacao);

        return $loConsulta;        
    }

    public function ValidaDataSaida($loDataEvento,$loDataSaida){

        $loDiaEvento = substr($loDataEvento, 0, 2);
        $loMesEvento = substr($loDataEvento, 2, 2);
        $loAnoEvento = substr($loDataEvento, 4, 4);
        $loHoraEvento = substr($loDataEvento, 8, 4);
        $loDataEventoMask = $loDiaEvento.$loMesEvento.$loAnoEvento.$loHoraEvento; 

        $loDiaSaida = substr($loDataSaida, 0, 2);
        $loMesSaida = substr($loDataSaida, 2, 2);
        $loAnoSaida = substr($loDataSaida, 4, 4);
        $loHoraSaida = substr($loDataSaida, 8, 4);
        $loDataSaidaMask = $loDiaSaida.$loMesSaida.$loAnoSaida.$loHoraSaida;

        if($loDataSaidaMask > $loDataEventoMask){
            $retornoMsg = "Data de Saida n&atilde;o pode ser maior que a Data do Evento.";
            $retornoValida = 0;
        }else{
            $retornoMsg = "";
            $retornoValida = 1;
        }

        $loRetorno = array("valida" => $retornoValida, "messagem" => $retornoMsg );

        return $loRetorno;        

    }

    public function ValidaDataSaidaRetorno($loDataRetornoPrevisto,$loDataSaida){

        $loDia = substr($loDataRetornoPrevisto, 0, 2);
        $loMes = substr($loDataRetornoPrevisto, 2, 2);
        $loAno = substr($loDataRetornoPrevisto, 4, 4);
        $loHora = substr($loDataRetornoPrevisto, 6, 4);
        $loDataRetornoPrevistoMask = $loDia.$loMes.$loAno.$loHora; 

        $loDia = substr($loDataSaida, 0, 2);
        $loMes = substr($loDataSaida, 2, 2);
        $loAno = substr($loDataSaida, 4, 4);
        $loHora = substr($loDataSaida, 6, 4);
        $loDataSaidaMask = $loDia.$loMes.$loAno.$loHora; 

        if($loDataRetornoPrevistoMask < $loDataSaidaMask){
            $retornoDataMsg = "Data de Retorno n&atilde;o pode ser menos que a Data de Saida.";
            $retornoDataValida = 0;
        }else{
            $retornoDataMsg = "";
            $retornoDataValida = 1;
        }

        $loDia = substr($loDataRetornoPrevisto, 0, 2);
        $loMes = substr($loDataRetornoPrevisto, 2, 2);
        $loAno = substr($loDataRetornoPrevisto, 4, 4);
        $loHora = substr($loDataRetornoPrevisto, 6, 4);
        $loDataRetornoPrevistoMask = $loDia.$loMes.$loAno; 

        $loDia = substr($loDataSaida, 0, 2);
        $loMes = substr($loDataSaida, 2, 2);
        $loAno = substr($loDataSaida, 4, 4);
        $loHora = substr($loDataSaida, 6, 4);
        $loDataSaidaMask = $loDia.$loMes.$loAno; 

        if($loDataRetornoPrevistoMask > $loDataSaidaMask){
            $retornoPerNoiteMsg = "verifica_per_noite";
            $retornoPerNoiteValida = 0;
        }else{
            $retornoPerNoiteMsg = "verifica_per_noite";
            $retornoPerNoiteValida = 1;           
        }

        $loRetorno = array(
                "valida_data" => $retornoDataValida, "messagem_data" => $retornoDataMsg
                ,"valida_per_noite" => $retornoPerNoiteValida, "messagem_per_noite" => $retornoPerNoiteMsg 
        );
        return $loRetorno;        
    }

    public function FechaSolicitacao($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->FechaSolicitacao($loDados);

        return $loConsulta;     

    }

    public function GravaDestinoRota($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->GravaDestinoRota($loDados);

        return $loConsulta;     

    }

    public function ExcluirDestinoRota($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ExcluirDestinoRota($loDados);

        return $loConsulta;     

    }

    public function ValidaPlaca($loPlaca){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ValidaPlaca($loPlaca);

        return $loConsulta; 

    }

    public function GravarMotivoCancelamento($loDados){
        
        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->GravarMotivoCancelamento($loDados);

        return $loConsulta;     

    }

    public function ValidaMotorista($loIdMotorista){

        $loSolicitacao = new solicitacaoBOA();
        $loRetornoConsulta = $loSolicitacao->ValidaMotorista($loIdMotorista);

        $loRetorno = array("erro" => false, "messagem" => '');
        if($loRetornoConsulta == false){
            $loRetorno = array("erro" => true, "messagem" => 'Motorista com habilita&ccedil;&atilde;o vencida, por favor, selecione outro.');
        }

        return $loRetorno;     

    }

    public function ValidaVeiculo($mbDados){

        $loSolicitacao = new solicitacaoBOA();
        $loRetornoQtdPassageiro = $loSolicitacao->ValidaQtdPassageiro($mbDados);

         $loRetornoVeiculoEmUso = $loSolicitacao->VerificaVeiculoEmUso($mbDados);        

        $loRetorno = array("erro" => false, "messagem" => '');
        if($loRetornoQtdPassageiro){
            $loRetorno = array("erro" => true, "messagem" => 'Veiculo n&atilde;o comporta esta quantidade de passageiros.');
        }
        if($loRetornoVeiculoEmUso){
             $loRetorno = array("erro" => true, "messagem" => 'Veiculo em uso n&atilde;o pode ser adicionado.');
        }

        return $loRetorno;     

    }

    public function VerificaSePassageiroeMotorista($mbDados){
        
        $loSolicitacao = new solicitacaoBOA();
        $loRetorno = $loSolicitacao->VerificaSePassageiroeMotorista($mbDados);  

        return $loRetorno;

    }

    public function VerificaSeExisteCaronaPendentedeAprovacao(){
        
        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->VerificaSeExisteCaronaPendentedeAprovacao();

        return $loConsulta;     
        
    }

    public function ListaCaronasSolicitadas($mbDados){

        $loConsulta = NULL;
        if(!isset($mbDados["status"])){
            $loConsulta .= "AND (status IS NULL OR status = 'S') ";
        }
        
        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaCaronasSolicitadas($mbDados,$loConsulta);

        return $loConsulta;     
        
    }

    public function AprovacaoNegacaoCarona($mbDados){

        $loStatus = $mbDados["status"];

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->AtualizaSolicitacaoCarona($mbDados);

        if($loStatus == "A"){
            $loConsulta = $loSolicitacao->GavaDadosSolicitacao($mbDados);
            $this->EmailCarona($mbDados,$loStatus);
        }
        if($loStatus == "C"){
            $this->EmailCarona($mbDados,$loStatus);
        }

        return $loConsulta;               

    }

    public function EmailCarona($mbDados,$mbStatus){

        $loNomeSolicitante = NULL;
        $loEmailSolicitante = NULL;
        $loNomeRequisitante = NULL;
        $loEmailRequisitante = NULL;

        $loIdPessoaSolicitante = $mbDados["id_pessoa_solicitante"];
        $loIdSolicitacao = $mbDados["id_solicitacao"];

        $loSolicitacao = new solicitacaoBOA();
        $loDados = $loSolicitacao->DadosEnvioPessoaEmail($loIdPessoaSolicitante);
        foreach ($loDados as $row){
            $loNomeSolicitante  = $row["nome"];
            $loEmailSolicitante = $row["email"];
        }

        $loDadosRequisitante = $loSolicitacao->CarregaEmailRequisitante($mbDados["id_solicitacao"]);
        foreach ($loDadosRequisitante as $row){
            $loNomeRequisitante  = $row["nome"];
            $loEmailRequisitante = $row["email"];
        }

        /*======================================================*/
        //Dados corpo do email.
        $loDadosSolic = array("id" => $loIdSolicitacao, "aprovacao_via_email" => 1);
        $loDadosCorpo = $this->ListaSolicitacao($loDadosSolic);
        foreach ($loDadosCorpo as $row){
            $loDataSaida = $row["dt_saida"];
            $loDataRetornoPrev = $row["dt_retorno_prev"];
            $loFinalidade = $row["finalidade"];
            $loLocalidadeOrigem = $row["nome_localidade"];
        }

        //Busca dados destinos
        $loLocalidadeDestinos = "";
        $loDadosDestino = array("id_solicitacao" => $loIdSolicitacao);
        $loDadosDestinos = $this->ListaDestinos($loDadosDestino);
        foreach ($loDadosDestinos as $row){    

            $loLocalidadeDestinos .= $row["nome"]."<br />";

        }
        /*====================================================*/


        // Instanciar a classe para envio de email
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); 
        // Vamos tentar realizar o envio
        try {

            $loComumParametros = new comumBO();
            $loDdEmail = $loComumParametros->ConfiguracaoHostEmail();

            $mail->Host = $loDdEmail["HOST"];
            $mail->Port = $loDdEmail["PORTA"]; 

            // Remetente
            $mail->AddReplyTo($loDdEmail["EMAIL"], utf8_decode('Solicitação de Carona'));
            $mail->SetFrom($loDdEmail["EMAIL"], utf8_decode('Solicitação de Carona'));

            // Destinatário
            $mail->AddAddress($loEmailSolicitante, 'Destinatario');
            if($mbStatus == "A"){ // So envia email para o Requisitante quando Aprovado.
                $mail->AddAddress($loEmailRequisitante);
            }

            // Assunto
            $mail->Subject = utf8_decode('Solicitação de Carona');

            // Mensagem para clientes de email sem suporte a HTML
            $mail->AltBody = utf8_decode('Solicitação de Carona');
            //Adiconar Messagem
            if($mbStatus == "A"){ // Aprovado

                $loMessagemHTML = "<strong> Solicitação de Número:</strong> $loIdSolicitacao <strong> foi Aprovada.  </strong>
                                <p> <strong>Requisitante:</strong> ". $loNomeRequisitante . "  <strong> Codigo solicita&ccedil;&atilde;o: </strong> ".$loIdSolicitacao." <p>
                                <p> <strong>Data Saida:</strong> ".$loDataSaida." <strong>Data Retorno:</strong> ".$loDataRetornoPrev." </p>
                                <p> <strong>Finalidade:</strong> ".$loFinalidade." </p>";

                $loMessagemOrigmDestHTML  = " <p> <strong>Origem:</strong> ".$loLocalidadeOrigem." </p>
                                              <p> <strong>Destino:</strong> ".$loLocalidadeDestinos." </p>";                               

            }
            if($mbStatus == "C"){ // Negado

                 $loMessagemHTML = "<strong> Solicitação de Número:</strong> $loIdSolicitacao <strong> foi negada pelo gestor. </strong>
                                <p> <strong>Requisitante:</strong> ". $loNomeRequisitante . "  <strong> Codigo solicita&ccedil;&atilde;o: </strong> ".$loIdSolicitacao." <p>
                                <p> <strong>Data Saida:</strong> ".$loDataSaida." <strong>Data Retorno:</strong> ".$loDataRetornoPrev." </p>
                                <p> <strong>Finalidade:</strong> ".$loFinalidade." </p>";

                $loMessagemOrigmDestHTML  = " <p> <strong>Origem:</strong> ".$loLocalidadeOrigem." </p>
                                              <p> <strong>Destino:</strong> ".$loLocalidadeDestinos." </p>";                                
      
            }

            $loMessagemHTML = utf8_decode($loMessagemHTML).$loMessagemOrigmDestHTML;
            // Mensagem para clientes de email com suporte a HTML
            $mail->MsgHTML($loMessagemHTML);

            // Adicionar anexo
            // Enviar email
            $mail->Send();

             $loRetorno = array("erro" => false, "mensagem" => "");

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

    public function CarregaEmailRequisitante($mbIdSolicitacao){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->CarregaEmailRequisitante($mbIdSolicitacao);

        return $loConsulta;  

    }

    public function ListaVeiculo($mbDados){    


        $loDdConsulta = "";

        $loNome = null;
        if(isset($mbDados["id"]) && !empty($mbDados["id"]) ){
            $loNome = $mbDados["id"];
            $loDdConsulta .=  " AND id_veiculo = ".$loNome; 

        }

        $loPlaca = null;
        if(isset($mbDados["placa"]) && !empty($mbDados["placa"]) ){
            $loPlaca = $mbDados["placa"];
            $loDdConsulta .=  " AND veiculo.placa like '%".$loPlaca."%'";

        }

        $loChassi = null;
        if(isset($mbDados["chassi"]) && !empty($mbDados["chassi"]) ){
            $loChassi = $mbDados["chassi"];
            $loDdConsulta .=  " AND veiculo.chassi like '%".$loChassi."%'";

        }

        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND veiculo.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }    

        $loVeiculo = new solicitacaoBOA();
        $loListaVeiculo = $loVeiculo->ListaVeiculo($loDdConsulta);

        return $loListaVeiculo;
    }

    public function VerificaGrupoAcessoUsuario(){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->VerificaGrupoAcessoUsuario();

        return $loConsulta;          
    }

    public function VerificaAutorizadorUsuarioCorrente($mbIdSolicitacao){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->VerificaAutorizadorUsuarioCorrente($mbIdSolicitacao);

        return $loConsulta;                 
    }

    public function EncaminharEmailAprovacao($mbIdSolicitacao){


        $loNomeRequisitante = NULL;
        $loDataSaida = NULL;
        $loDataRetornoPrev = NULL;
        $loFinalidade = NULL;
        $loLocalidadeOrigem = NULL;
        $loLocalidadeDestinos = NULL;
        $loMessagemHTML = NULL;
        $loPessoaPassageiro = NULL;
        $loNomeAutorizador = NULL;
        $loEmailAutorizador = NULL;
        $loEmailAutorizadorArray = NULL;
        $loRetorno = NULL;
        $loDadosAutorizador = 0;
        $loEmailRequisitante = "";

        $loDados = array("id" => $mbIdSolicitacao, "aprovacao_via_email" => 1);

        //Dados corpo do email.
        $loDadosCorpo = $this->ListaSolicitacao($loDados);
        foreach ($loDadosCorpo as $row){

            $loNomeRequisitante = $row["nome_requisitante"];
            $loDataSaida = $row["dt_saida"];
            $loDataRetornoPrev = $row["dt_retorno_prev"];
            $loFinalidade = $row["finalidade"];
            $loLocalidadeOrigem = $row["nome_localidade"];
            $loEmailRequisitante = $row["email_requisitante"];


        }

        //Busca dados destinos
        $loDadosDestino = array("id_solicitacao" => $mbIdSolicitacao);
        $loDadosDestinos = $this->ListaDestinos($loDadosDestino);
        foreach ($loDadosDestinos as $row){    

            $loLocalidadeDestinos .= $row["nome"]."<br />";

        }

        if($loEmailRequisitante != ""){

            $loMessagemHTML = "<strong> Solicita&ccedil;&atilde;o de N&uacute;mero:</strong> $mbIdSolicitacao <strong> foi Aprovada.  </strong>
                                <p> <strong>Requisitante:</strong> ". $loNomeRequisitante . "  <strong> Codigo solicita&ccedil;&atilde;o: </strong> ".$mbIdSolicitacao." <p>
                                <p> <strong>Data Saida:</strong> ".$loDataSaida." <strong>Data Retorno:</strong> ".$loDataRetornoPrev." </p>
                                <p> <strong>Finalidade:</strong> ".$loFinalidade." </p>
                                <p> <strong>Origem:</strong> ".$loLocalidadeOrigem." </p>
                                <p> <strong>Destino:</strong> ".$loLocalidadeDestinos." </p>";

            $loMessagemHTML = $loMessagemHTML;

        
            // Instanciar a classe para envio de email
            $mail = new PHPMailer(true);
            $mail->IsSMTP(); 
            // Vamos tentar realizar o envio
            try {

                $loComumParametros = new comumBO();
                $loDdEmail = $loComumParametros->ConfiguracaoHostEmail();

                $mail->Host = $loDdEmail["HOST"];
                $mail->Port = $loDdEmail["PORTA"]; 

                // Remetente
                $mail->AddReplyTo($loDdEmail["EMAIL"], utf8_decode('Solicitação Aprovada'));
                $mail->SetFrom($loDdEmail["EMAIL"], utf8_decode('Solicitação Aprovada'));

                // Destinatário
                $mail->AddAddress($loEmailRequisitante);


                // Assunto
                $mail->Subject = utf8_decode('Solicitação Aprovada');

                // Mensagem para clientes de email sem suporte a HTML
                $mail->AltBody = utf8_decode('Solicitação Aprovada');


                // Mensagem para clientes de email com suporte a HTML
                $mail->MsgHTML($loMessagemHTML);

                // Adicionar anexo
                // Enviar email
                $mail->Send();

                $loRetorno = array("erro" => false, "mensagem" => "");

                //echo "Mensagem enviada!";
           }
            catch (phpmailerException $e) {
                // Mensagens de erro do PHPMailer
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage() );
            }
            catch (Exception $e) {
                // Outras mensagens de erro
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage() );
            }

        }else{
            $loRetorno = array("erro" => true, "mensagem" => "Requisitante sem Email." );
        }

        /*$headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: lets@lets.com.br'.utf8_decode('Solicitação Aprovada');

        $enviaremail = mail("danilo.souza@lets.com.br", "teste", "", $headers);*/

        return $loRetorno;



    }


 public function EncaminharEmailNaoAprovacao($mbIdSolicitacao){


        $loNomeRequisitante = NULL;
        $loDataSaida = NULL;
        $loDataRetornoPrev = NULL;
        $loFinalidade = NULL;
        $loLocalidadeOrigem = NULL;
        $loLocalidadeDestinos = NULL;
        $loMessagemHTML = NULL;
        $loPessoaPassageiro = NULL;
        $loNomeAutorizador = NULL;
        $loEmailAutorizador = NULL;
        $loEmailAutorizadorArray = NULL;
        $loRetorno = NULL;
        $loDadosAutorizador = 0;
        $loEmailRequisitante = "";

        $loDados = array("id" => $mbIdSolicitacao, "aprovacao_via_email" => 1);

        //Dados corpo do email.
        $loDadosCorpo = $this->ListaSolicitacao($loDados);
        foreach ($loDadosCorpo as $row){

            $loNomeRequisitante = $row["nome_requisitante"];
            $loDataSaida = $row["dt_saida"];
            $loDataRetornoPrev = $row["dt_retorno_prev"];
            $loFinalidade = $row["finalidade"];
            $loLocalidadeOrigem = $row["nome_localidade"];
            $loEmailRequisitante = $row["email_requisitante"];

        }

        //Busca dados destinos
        $loDadosDestino = array("id_solicitacao" => $mbIdSolicitacao);
        $loDadosDestinos = $this->ListaDestinos($loDadosDestino);
        foreach ($loDadosDestinos as $row){    

            $loLocalidadeDestinos .= $row["nome"]."<br />";

        }

        if($loEmailRequisitante != ""){

            $loMessagemHTML = "<strong> Solicitação de Número:</strong> $mbIdSolicitacao <strong> Não foi aprovada pelo gestor.  </strong>
                                <p> <strong>Requisitante:</strong> ". $loNomeRequisitante . "  <strong> Codigo solicita&ccedil;&atilde;o: </strong> ".$mbIdSolicitacao." <p>
                                <p> <strong>Data Saida:</strong> ".$loDataSaida." <strong>Data Retorno:</strong> ".$loDataRetornoPrev." </p>
                                <p> <strong>Finalidade:</strong> ".$loFinalidade." </p>
                                <p> <strong>Origem:</strong> ".$loLocalidadeOrigem." </p>
                                <p> <strong>Destino:</strong> ".$loLocalidadeDestinos." </p>";

        
            // Instanciar a classe para envio de email
            $mail = new PHPMailer(true);
            $mail->IsSMTP();

            // Vamos tentar realizar o envio
            try {

                $loComumParametros = new comumBO();
                $loDdEmail = $loComumParametros->ConfiguracaoHostEmail();

                $mail->Host = $loDdEmail["HOST"];
                $mail->Port = $loDdEmail["PORTA"];                 

                // Remetente
                $mail->AddReplyTo($loDdEmail["EMAIL"], utf8_decode('Solicitação Não Aprovada'));
                $mail->SetFrom($loDdEmail["EMAIL"], utf8_decode('Solicitação Não Aprovada'));

                // Destinatário
                $mail->AddAddress($loEmailRequisitante);

                // Assunto
                $mail->Subject = utf8_decode('Solicitação Não Aprovada');

                // Mensagem para clientes de email sem suporte a HTML
                $mail->AltBody = utf8_decode('Solicitação Não Aprovada');


                // Mensagem para clientes de email com suporte a HTML
                $mail->MsgHTML($loMessagemHTML);

                // Adicionar anexo
                // Enviar email
                $mail->Send();

                $loRetorno = array("erro" => false, "mensagem" => "");

                //echo "Mensagem enviada!";
            }
            catch (phpmailerException $e) {
                // Mensagens de erro do PHPMailer
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage() );
            }
            catch (Exception $e) {
                // Outras mensagens de erro
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage() );
            }

        }else{
            $loRetorno = array("erro" => true, "mensagem" => "Requisitante sem Email." );
        }


        return $loRetorno;

    }    

    public function EncaminharGestorAutorizador($mbIdSolicitacao){

        $loNomeRequisitante = NULL;
        $loDataSaida = NULL;
        $loDataRetornoPrev = NULL;
        $loFinalidade = NULL;
        $loLocalidadeOrigem = NULL;
        $loLocalidadeDestinos = NULL;
        $loMessagemHTML = NULL;
        $loPessoaPassageiro = NULL;
        $loNomeAutorizador = NULL;
        $loEmailAutorizador = NULL;
        $loEmailAutorizadorArray = NULL;
        $loRetorno = NULL;
        $loDadosAutorizador = 0;

        $loDados = array("id" => $mbIdSolicitacao, "aprovacao_via_email" => 1);

        //Dados corpo do email.
        $loDadosCorpo = $this->ListaSolicitacao($loDados);
        foreach ($loDadosCorpo as $row){

            $loNomeRequisitante = $row["nome_requisitante"];
            $loDataSaida = $row["dt_saida"];
            $loDataRetornoPrev = $row["dt_retorno_prev"];
            $loFinalidade = $row["finalidade"];
            $loLocalidadeOrigem = $row["nome_localidade"];

        }
        //Busca dados destinos
        $loDadosDestino = array("id_solicitacao" => $mbIdSolicitacao);
        $loDadosDestinos = $this->ListaDestinos($loDadosDestino);
        foreach ($loDadosDestinos as $row){    

            $loLocalidadeDestinos .= $row["nome"]."<br />";

        }

        //Busca dados passageiro
        $loDadosPassageiro = array("id_solicitacao" => $mbIdSolicitacao);
        $loDadosPassageiros = $this->ListaPassageiros($loDadosPassageiro);
        foreach ($loDadosPassageiros as $row){    

            $loPessoaPassageiro .= $row["nome"]."<br />";

        }



        //Busca Email do Autorizador do usuario para envio
        $loDadosAutorizador = $this->VerificaAutorizadorUsuarioCorrente($mbIdSolicitacao);
        if(count($loDadosAutorizador) > 0){

            foreach ($loDadosAutorizador as $row){    

                $loNomeAutorizador .= $row["nome"];
                $loEmailAutorizadorArray[] = array("email" => $row["email"], 'id_usuario' => $row["id_usuario"]);

            }
            
            $loMessagemHTML = "<strong> Solicita&ccedil;&atilde;o de Aprova&ccedil;&atilde;o de Viagem </strong>
                                <p> <strong>Requisitante:</strong> ". $loNomeRequisitante . "  <strong> Codigo solicita&ccedil;&atilde;o: </strong> ".$mbIdSolicitacao." <p>
                                <p> <strong>Data Saida:</strong> ".$loDataSaida." <strong>Data Retorno:</strong> ".$loDataRetornoPrev." </p>
                                <p> <strong>Finalidade:</strong> ".$loFinalidade." </p>
                                <p> <strong>Origem:</strong> ".$loLocalidadeOrigem." </p>
                                <p> <strong>Destino:</strong> ".$loLocalidadeDestinos." </p>";


            // Instanciar a classe para envio de email
            $mail = new PHPMailer(true);
            $mail->IsSMTP(); 

            // Vamos tentar realizar o envio
            try {

                $loComumParametros = new comumBO();
                $loDdEmail = $loComumParametros->ConfiguracaoHostEmail();

                $mail->Host = $loDdEmail["HOST"];
                $mail->Port = $loDdEmail["PORTA"]; 
                

                // Remetente
                $mail->AddReplyTo($loDdEmail["EMAIL"], utf8_decode('Solicitação de Aprovação de Viagem'));
                $mail->SetFrom($loDdEmail["EMAIL"], utf8_decode('Solicitação de Aprovação de Viagem'));

                // Destinatário
                foreach ($loEmailAutorizadorArray as $row){   
                    $mail->AddAddress($row["email"]);

                     $loMessagemHTML .= "<a href='http://sistema2.lets.com.br:89/codigofonte/solicitacao/apresentacao/solicitacao-aprovacao-via-email.php?id_solicitacao=".$mbIdSolicitacao."&tipo_aprovacao=S&id_usuario=".$row["id_usuario"]."'> 
                                                        Aprovar 
                                                    </a> 
                                                    &nbsp;&nbsp; 
                                                    <a href='http://sistema2.lets.com.br:89/codigofonte/solicitacao/apresentacao/solicitacao-aprovacao-via-email.php?id_solicitacao=".$mbIdSolicitacao."&tipo_aprovacao=N&id_usuario=".$row["id_usuario"]."'> 
                                                        N&atilde;o Aprovar 
                                                    </a> ";
                    
                }

                // Assunto
                $mail->Subject = utf8_decode('Solicitação de Aprovação de Viagem');

                // Mensagem para clientes de email sem suporte a HTML
                $mail->AltBody = utf8_decode('Solicitação de Aprovação de Viagem');


                // Mensagem para clientes de email com suporte a HTML
                $mail->MsgHTML($loMessagemHTML);

                // Adicionar anexo
                // Enviar email
                $mail->Send();

                $loRetorno = array("erro" => false, "mensagem" => "");

                //echo "Mensagem enviada!";
            }
            catch (phpmailerException $e) {
                // Mensagens de erro do PHPMailer
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage(), "autorizador" => count($loDadosAutorizador) );
            }
            catch (Exception $e) {
                // Outras mensagens de erro
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage(), "autorizador" => count($loDadosAutorizador) );
            }

        }else{
             $loRetorno = array("erro" => true, "mensagem" => "", "autorizador" => $loDadosAutorizador);
        }//-*--f(count($loDadosAutorizador) > 0){


         if($loDadosAutorizador == 0){
             $loEnvioGestor = array("id_status_solicitacao" => '3', "ind_encaminhado_gestor" => "0", "id_solicitacao" => $mbIdSolicitacao); //Aprova
         }else{
             $loEnvioGestor = array("id_status_solicitacao" => '2', "ind_encaminhado_gestor" => "1", "id_solicitacao" => $mbIdSolicitacao);//Encaminha Gestor
         }
         $this->AtualizaDadosSolicitacaoGestor( $loEnvioGestor );   

        return $loRetorno;


    }


 public function EncaminharGestorOperador($mbIdSolicitacao){

        $loNomeRequisitante = NULL;
        $loDataSaida = NULL;
        $loDataRetornoPrev = NULL;
        $loFinalidade = NULL;
        $loLocalidadeOrigem = NULL;
        $loLocalidadeDestinos = NULL;
        $loMessagemHTML = NULL;
        $loPessoaPassageiro = NULL;
        $loNomeAutorizador = NULL;
        $loEmailAutorizador = NULL;
        $loEmailAutorizadorArray = NULL;
        $loRetorno = NULL;
        $loDadosAutorizador = 0;

        $loDados = array("id" => $mbIdSolicitacao, "aprovacao_via_email" => 1);

        //Dados corpo do email.
        $loDadosCorpo = $this->ListaSolicitacao($loDados);
        foreach ($loDadosCorpo as $row){

            $loNomeRequisitante = $row["nome_requisitante"];
            $loDataSaida = $row["dt_saida"];
            $loDataRetornoPrev = $row["dt_retorno_prev"];
            $loFinalidade = $row["finalidade"];
            $loLocalidadeOrigem = $row["nome_localidade"];

        }
        //Busca dados destinos
        $loDadosDestino = array("id_solicitacao" => $mbIdSolicitacao);
        $loDadosDestinos = $this->ListaDestinos($loDadosDestino);
        foreach ($loDadosDestinos as $row){    

            $loLocalidadeDestinos .= $row["nome"]."<br />";

        }

        //Busca dados passageiro
        $loDadosPassageiro = array("id_solicitacao" => $mbIdSolicitacao);
        $loDadosPassageiros = $this->ListaPassageiros($loDadosPassageiro);
        foreach ($loDadosPassageiros as $row){    

            $loPessoaPassageiro .= $row["nome"]."<br />";

        }



        //Busca Email do Autorizador do usuario para envio
        $loDadosAutorizador = $this->VerificaAutorizadorUsuarioCorrente($mbIdSolicitacao);
        if(count($loDadosAutorizador) > 0){

            foreach ($loDadosAutorizador as $row){    

                $loNomeAutorizador .= $row["nome"];
                $loEmailAutorizadorArray[] = array("email" => $row["email"], 'id_usuario' => $row["id_usuario"]);

            }
            
            $loMessagemHTML = "<strong> Solicita&ccedil;&atilde;o de Aprova&ccedil;&atilde;o de Viagem </strong>
                                <p> <strong>Requisitante:</strong> ". $loNomeRequisitante . "  <strong> Codigo solicita&ccedil;&atilde;o: </strong> ".$mbIdSolicitacao." <p>
                                <p> <strong>Data Saida:</strong> ".$loDataSaida." <strong>Data Retorno:</strong> ".$loDataRetornoPrev." </p>
                                <p> <strong>Finalidade:</strong> ".$loFinalidade." </p>
                                <p> <strong>Origem:</strong> ".$loLocalidadeOrigem." </p>
                                <p> <strong>Destino:</strong> ".$loLocalidadeDestinos." </p>";


            // Instanciar a classe para envio de email
            $mail = new PHPMailer(true);
            $mail->IsSMTP();

            // Vamos tentar realizar o envio
            try {

                $loComumParametros = new comumBO();
                $loDdEmail = $loComumParametros->ConfiguracaoHostEmail();

                $mail->Host = $loDdEmail["HOST"];
                $mail->Port = $loDdEmail["PORTA"];                 

                // Remetente
                $mail->AddReplyTo($loDdEmail["EMAIL"], utf8_decode('Solicitação de Aprovação de Viagem'));
                $mail->SetFrom($loDdEmail["EMAIL"], utf8_decode('Solicitação de Aprovação de Viagem'));

                // Destinatário
                $loDadosOperadores = $this->ListaTodosOsOperadores();

                if(count($loDadosOperadores) > 0){
                    foreach ($loDadosOperadores as $row){

                        if($row["email"] != ""){

                            $mail->AddAddress($row["email"]);


                            $loMessagemHTML .= "<a href='http://sistema2.lets.com.br:89/codigofonte/solicitacao/apresentacao/solicitacao-aprovacao-via-email.php?id_solicitacao=".$mbIdSolicitacao."&tipo_aprovacao=S&id_usuario=".$row["id_usuario"]."'> 
                                                        Aprovar 
                                                    </a> 
                                                    &nbsp;&nbsp; 
                                                    <a href='http://sistema2.lets.com.br:89/codigofonte/solicitacao/apresentacao/solicitacao-aprovacao-via-email.php?id_solicitacao=".$mbIdSolicitacao."&tipo_aprovacao=N&id_usuario=".$row["id_usuario"]."'> 
                                                        N&atilde;o Aprovar 
                                                    </a> ";


                        }
                    }
                }

                // Assunto
                $mail->Subject = utf8_decode('Solicitação de Aprovação de Viagem');

                // Mensagem para clientes de email sem suporte a HTML
                $mail->AltBody = utf8_decode('Solicitação de Aprovação de Viagem');


                // Mensagem para clientes de email com suporte a HTML
                $mail->MsgHTML($loMessagemHTML);

                // Adicionar anexo
                // Enviar email
                $mail->Send();

                $loRetorno = array("erro" => false, "mensagem" => "");

                //echo "Mensagem enviada!";
            }
            catch (phpmailerException $e) {
                // Mensagens de erro do PHPMailer
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage(), "autorizador" => count($loDadosAutorizador) );
            }
            catch (Exception $e) {
                // Outras mensagens de erro
                $loRetorno = array("erro" => true, "mensagem" => $e->errorMessage(), "autorizador" => count($loDadosAutorizador) );
            }

        }else{
             $loRetorno = array("erro" => true, "mensagem" => "", "autorizador" => $loDadosAutorizador);
        }//-*--f(count($loDadosAutorizador) > 0){


         if($loDadosAutorizador == 0){
             $loEnvioGestor = array("id_status_solicitacao" => '3', "ind_encaminhado_gestor" => "0", "id_solicitacao" => $mbIdSolicitacao); //Aprova
         }else{
             $loEnvioGestor = array("id_status_solicitacao" => '2', "ind_encaminhado_gestor" => "1", "id_solicitacao" => $mbIdSolicitacao);//Encaminha Gestor
         }
         $this->AtualizaDadosSolicitacaoGestor( $loEnvioGestor );   

        return $loRetorno;


    }


   public function ListaTodosOsOperadores(){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ListaTodosOsOperadores();

        return $loConsulta;       

    }

    public function AprovacaoViaEmail($loDados){

        $loTipoAprovacao = $loDados["tipo_aprovacao"];
        $loIdsolicitacao = $loDados["id_solicitacao"];

        $loSolicitacao = new solicitacaoBOA();
        $RetornoEmail = NULL;

        if($loTipoAprovacao == "S"){

            $loConsulta = $loSolicitacao->AprovaSolicitacao($loDados);
            $RetornoEmail = $this->EncaminharEmailAprovacao($loIdsolicitacao);

        }else{

            $loConsulta = $loSolicitacao->NaoAprovaSolicitacaoSolicitacao($loDados);
            $RetornoEmail = $this->EncaminharEmailNaoAprovacao($loIdsolicitacao);

        }

        return $RetornoEmail; 

    }

    public function AtualizaDadosSolicitacaoGestor($loDados){
       
        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->AtualizaDadosSolicitacaoGestor($loDados);

        return $loConsulta;         
    }

    public function VerificaDataValidadeHabilitacaoConsultor($loData){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->VerificaDataValidadeHabilitacaoConsultor($loData);

        return $loConsulta;                 
    }

    public function UsuarioCorrenteAutoriza($loIdsolicitacao){
       
        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->UsuarioCorrenteAutoriza($loIdsolicitacao);

        return $loConsulta;

    }

    public function AtualizaStatusSolicitacao($loIdsolicitacao,$loStatu){
       
        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->AtualizaStatusSolicitacao($loIdsolicitacao,$loStatu);

        return $loConsulta;        

    }

    public function VerificaUsuarioCondutorPessoa($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->VerificaUsuarioCondutorPessoa($loDados);

        return $loConsulta;            
    }

    public function VerificaUsuarioConsutor(){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->VerificaUsuarioConsutor();

        return $loConsulta;            
    }

    public function ValidaDataEvento($loDados){

        $loSolicitacao = new solicitacaoBOA();
        $loConsulta = $loSolicitacao->ValidaDataEvento($loDados);

        return $loConsulta;          

    }  

} 

?>