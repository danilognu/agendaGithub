<?php

class solicitacaoBOA{


    public function ListaSolicitacao($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 	solicitacao.id_solicitacao, 
                            pessoa_matriz.id_pessoa as id_pessoa_matriz, 
                            pessoa_matriz.nome as nome_pessoa_matriz,
                            pessoa_motorista_passageiro.id_pessoa as id_pessoa_requisitante, 
                            pessoa_motorista_passageiro.nome as nome_requisitante,
                            pessoa_motorista_passageiro.email as email_requisitante,
                            pessoa_motorista_passageiro.ind_condutor,
                            pessoa_motorista_passageiro.ind_passageiro,
                            setor.id_setor as id_setor, 
                            setor.nome as nome_setor,
                            projetos.id_projeto, 
                            projetos.nome as nome_projeto,
                            DATE_FORMAT(solicitacao.dt_evento, '%d/%m/%Y %H:%i') dt_evento,
                            DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida, 
                            DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev, 
                            solicitacao.finalidade, 
                            solicitacao.ind_viagem, 
                            solicitacao.ind_com_motorista, 
                            solicitacao.ind_pernoite, 
                            solicitacao.ind_retorno_previsto, 
                            localidade.id_localidade, 
                            localidade.nome as nome_localidade,
                            solicitacao.ind_aberto, 
                            solicitacao.dt_cad, 
                            DATE_FORMAT(solicitacao.dt_alt, '%d/%m/%Y %H:%i') dt_alt, 
                            solicitacao.id_usuario_cad, 
                            solicitacao.id_usuario_alt, 
                            usuario_alt.nome as usuario_nome,
                            status_solicitacao.id_status_solicitacao, 
                            status_solicitacao.nome as nome_status,
                            solicitacao.id_usuario_abertura, 
                            usuario_abertura.nome as nome_usuario_abertura,
                            DATE_FORMAT(solicitacao.dt_abertura, '%d/%m/%Y %H:%i') dt_abertura,
                            gestor.id_pessoa as id_gestor, 
                            gestor.nome as nome_gestor,
                            DATE_FORMAT(solicitacao.dt_enc_gestor, '%d/%m/%Y %H:%i') dt_enc_gestor,
                            solicitacao.id_usuario_aprovado, 
                            usuario_aprovado.nome as nome_usuario_aprovado,
                            DATE_FORMAT(solicitacao.dt_aprovado, '%d/%m/%Y %H:%i') dt_aprovado,
                            solicitacao.id_usuario_cancelamento, 
                            usuario_cancelamento.nome as nome_usuario_cancelamento,
                            DATE_FORMAT(solicitacao.dt_cancelamento, '%d/%m/%Y %H:%i') dt_cancelamento,
                            solicitacao.id_motivo_cancelamento,
                            veiculo.id_veiculo,
                            veiculo.placa,
                            motorista.id_pessoa as id_motorista,
                            motorista.nome as nome_motorista,
                            solicitacao.km_saida,
                            solicitacao.km_retorno,
                            DATE_FORMAT(solicitacao.dt_partida, '%d/%m/%Y %H:%i') dt_partida,
                            DATE_FORMAT(solicitacao.dt_chegada, '%d/%m/%Y %H:%i') dt_chegada,
                            solicitacao.km_partida, 
                            solicitacao.km_chegada, 
                            solicitacao.ind_planejado, 
                            solicitacao.obs_realizado,
                            solicitacao.ind_realizado,
                            motivo_nao_planejamento.id_mot_plan,
                            motivo_nao_planejamento.nome as nome_nao_planejamento
                            ,(
                                SELECT 
                                    localidade.nome 
                                FROM destinos 
                                INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                                WHERE destinos.id_solicitacao = solicitacao.id_solicitacao
                                ORDER BY destinos.id_destino DESC LIMIT 1
                            ) as destino,
                            DATE_FORMAT(solicitacao.dt_fechado, '%d/%m/%Y %H:%i') dt_fechado,
                            solicitacao.id_usuario_fechado,
                            usuario_fechado.nome nome_usuario_fechado,
                            (SELECT COUNT(id_solicitacao) FROM passageiros WHERE id_solicitacao = solicitacao.id_solicitacao) as qtd_passageiro,
                            centro_custo.id_centro_custo,
                            centro_custo.nome as nome_centro_de_custo
                             ,(
                                SELECT COUNT(id_solicitacao) FROM solicitacao_carona 
                                WHERE solicitacao_carona.id_solicitacao = solicitacao.id_solicitacao
                                AND solicitacao_carona.id_pessoa_autorizador IN( 
                                    SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"].")
                            ) as verifica_carona   
                            ,veiculo.qtd_passageiro as qtd_passageiro_veiculo       
                            ,solicitacao.ind_encaminhado_gestor
                            ,solicitacao.ind_status_retornado
                            ,solicitacao.id_cnpj_faturamento            
                            FROM 
                            solicitacao 
                            INNER JOIN pessoa pessoa_matriz ON pessoa_matriz.id_pessoa = solicitacao.id_pessoa_matriz
                            LEFT JOIN pessoa pessoa_motorista_passageiro ON pessoa_motorista_passageiro.id_pessoa = solicitacao.id_pessoa_requisitante
                            LEFT JOIN projetos ON projetos.id_projeto = solicitacao.id_projeto
                            LEFT JOIN localidade ON localidade.id_localidade = solicitacao.id_localidade_origem
                            LEFT JOIN status_solicitacao ON status_solicitacao.id_status_solicitacao = solicitacao.id_status_solicitacao
                            LEFT JOIN usuario usuario_abertura ON usuario_abertura.id_usuario = solicitacao.id_usuario_abertura
                            LEFT JOIN pessoa gestor ON gestor.id_pessoa = solicitacao.id_pessoa_gestor
                            LEFT JOIN usuario usuario_aprovado ON usuario_aprovado.id_usuario = solicitacao.id_usuario_aprovado
                            LEFT JOIN usuario usuario_cancelamento ON usuario_cancelamento.id_usuario = solicitacao.id_usuario_cancelamento
                            LEFT JOIN usuario usuario_fechado ON usuario_fechado.id_usuario = solicitacao.id_usuario_fechado
                            LEFT JOIN setor ON setor.id_setor = solicitacao.id_setor
                            LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                            LEFT JOIN pessoa motorista ON motorista.id_pessoa =  solicitacao.id_pessoa_motorista
                            LEFT JOIN motivo_nao_planejamento ON motivo_nao_planejamento.id_mot_plan = solicitacao.id_mot_plan
                            LEFT JOIN centro_custo ON centro_custo.id_centro_custo = solicitacao.id_centro_custo
                            LEFT JOIN usuario usuario_alt ON usuario_alt.id_usuario = solicitacao.id_usuario_alt
                    WHERE 1=1 ".$mbDados;
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

         $loDestino[] = array('ultimo'=> 1);

        $loSolicitacoes = null;
        foreach ($query as $row) {
               
               
               $loSolicitacoes[] = array(
                     'id_localidade'                => $row["id_localidade"] 
                     ,'id_solicitacao'              => $row["id_solicitacao"]  
                     ,'id_pessoa_matriz'            => $row["id_pessoa_matriz"]  
                     ,'nome_pessoa_matriz'          => $row["nome_pessoa_matriz"] 
                     ,'id_pessoa_requisitante'      => $row["id_pessoa_requisitante"]  
                     ,'nome_requisitante'           => $row["nome_requisitante"] 
                     ,'id_setor'                    => $row["id_setor"]  
                     ,'nome_setor'                  => $row["nome_setor"] 
                     ,'id_projeto'                  => $row["id_projeto"]  
                     ,'nome_projeto'                => $row["nome_projeto"] 
                     ,'dt_evento'                   => $row["dt_evento"]  
                     ,'dt_saida'                    => $row["dt_saida"]  
                     ,'dt_retorno_prev'             => $row["dt_retorno_prev"]  
                     ,'finalidade'                  => $row["finalidade"]  
                     ,'ind_viagem'                  => $row["ind_viagem"]  
                     ,'ind_com_motorista'           => $row["ind_com_motorista"]  
                     ,'ind_pernoite'                => $row["ind_pernoite"]  
                     ,'ind_retorno_previsto'        => $row["ind_retorno_previsto"]  
                     ,'id_localidade'               => $row["id_localidade"]  
                     ,'nome_localidade'             => $row["nome_localidade"] 
                     ,'ind_aberto'                  => $row["ind_aberto"]  
                     ,'dt_cad'                      => $row["dt_cad"]  
                     ,'dt_alt'                      => $row["dt_alt"]  
                     ,'id_usuario_cad'              => $row["id_usuario_cad"]  
                     ,'id_usuario_alt'              => $row["id_usuario_alt"] 
                     ,'usuario_nome'                => $row["usuario_nome"]  
                     ,'id_status_solicitacao'       => $row["id_status_solicitacao"]  
                     ,'nome_status'                 => $row["nome_status"] 
                     ,'id_usuario_abertura'         => $row["id_usuario_abertura"]  
                     ,'nome_usuario_abertura'       => $row["nome_usuario_abertura"] 
                     ,'dt_abertura'                 => $row["dt_abertura"] 
                     ,'id_gestor'                   => $row["id_gestor"]  
                     ,'nome_gestor'                 => $row["nome_gestor"] 
                     ,'dt_enc_gestor'               => $row["dt_enc_gestor"] 
                     ,'id_usuario_aprovado'         => $row["id_usuario_aprovado"]  
                     ,'nome_usuario_aprovado'       => $row["nome_usuario_aprovado"] 
                     ,'dt_aprovado'                 => $row["dt_aprovado"]  
                     ,'id_usuario_cancelamento'     => $row["id_usuario_cancelamento"]  
                     ,'nome_usuario_cancelamento'   => $row["nome_usuario_cancelamento"] 
                     ,'dt_cancelamento'             => $row["dt_cancelamento"]  
                     ,'id_motivo_cancelamento'      => $row["id_motivo_cancelamento"]
                     ,'id_veiculo'                  => $row["id_veiculo"]
                     ,'placa'                       => $row["placa"]
                     ,'id_motorista'                => $row["id_motorista"]
                     ,'nome_motorista'              => $row["nome_motorista"]
                     ,'km_saida'                    => $row["km_saida"]
                     ,'km_retorno'                  => $row["km_retorno"]
                     ,'dt_partida'                  => $row["dt_partida"]
                     ,'dt_chegada'                  => $row["dt_chegada"] 
                     ,'km_partida'                  => $row["km_partida"] 
                     ,'km_chegada'                  => $row["km_chegada"] 
                     ,'ind_planejado'               => $row["ind_planejado"] 
                     ,'ind_realizado'               => $row["ind_realizado"]
                     ,'obs_realizado'               => $row["obs_realizado"]
                     ,'id_mot_plan'                 => $row["id_mot_plan"]
                     ,'nome_nao_planejamento'       => $row["nome_nao_planejamento"]
                     ,'ultimo_destino'              => $row["destino"]
                     ,'dt_fechado'                  => $row["dt_fechado"]
                     ,'id_usuario_fechado'          => $row["id_usuario_fechado"]
                     ,'nome_usuario_fechado'        => $row["nome_usuario_fechado"]
                     ,'qtd_passageiro'              => $row["qtd_passageiro"]
                     ,'id_centro_custo'             => $row["id_centro_custo"]
                     ,'nome_centro_de_custo'        => $row["nome_centro_de_custo"]
                     ,'verifica_carona'             => $row["verifica_carona"]
                     ,'qtd_passageiro_veiculo'      => $row["qtd_passageiro_veiculo"]
                     ,'ind_encaminhado_gestor'      => $row["ind_encaminhado_gestor"]
                     ,'ind_condutor'                => $row["ind_condutor"]
                     ,'ind_passageiro'              => $row["ind_passageiro"]
                     ,'email_requisitante'          => $row["email_requisitante"]
                     ,'ind_status_retornado'        => $row["ind_status_retornado"]
                     ,'id_cnpj_faturamento'         => $row["id_cnpj_faturamento"]
                );
               
        
        }

        return $loSolicitacoes;        



    }

    public function IncluirSolicitacao($loDados,$loCodigosParadas,$loCodigosPassageiros,$loCodigosOrigem){

        $loComumParametros = new comumBO();

        $loDataEvento = $loComumParametros->AdicionaDataHora($loDados["dt_evento"]);
        $loIdSetor = $loDados["id_setor"];
        $loIdProjeto =  $loDados["id_projeto"];
        $loFinalidade = utf8_decode($loDados["finalidade"]);
        $loIndViagem = $loDados["ind_viagem"];
        $loIndComMotorista =  $loDados["ind_com_motorista"];
        $loIndPernoite = $loDados["ind_pernoite"];
        $loDataSaida = $loComumParametros->AdicionaDataHora($loDados["dt_saida"]);
        $loDataRetorno = $loComumParametros->AdicionaDataHora($loDados["dt_retorno_prev"]);
        $loIdStatusSolic = $loDados["id_status_solicitacao"];
        $CodigoRequisitante = $loDados["codigoRequisitante"];
        $loIdPessoaGestor = $loDados["id_pessoa_gestor"];
        $loCentroDeCusto = $loDados["id_centro_custo"];
        $loIndEncaminhadoGestor = $loDados["id_encaminhado_gestor"];
        $loIdCnpjFaturamento = $loDados["id_cnpj_faturamento"];
        
        $loDtEncGestor = NULL;
        if(!empty($loIdPessoaGestor)){ $loDtEncGestor = date('Y-m-d H:i:s'); }

        //Pega codigo localidade Origem
        $loIdOrigem = NULL;
        if(!empty($loCodigosOrigem) && count($loCodigosOrigem) > 0){ $loIdOrigem = $loCodigosOrigem[0]; }



        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    solicitacao (
                        dt_evento
                        ,id_setor
                        ,id_projeto
                        ,finalidade
                        ,ind_viagem
                        ,ind_com_motorista
                        ,ind_pernoite
                        ,dt_saida
                        ,dt_retorno_prev
                        ,id_status_solicitacao
                        ,id_pessoa_requisitante
                        ,id_usuario_abertura
                        ,id_usuario_cad
                        ,id_pessoa_matriz
                        ,id_localidade_origem
                        ,id_pessoa_gestor
                        ,dt_enc_gestor
                        ,id_centro_custo
                        ,id_cnpj_faturamento
                        ,dt_abertura
                        ,dt_cad                     
                     ) 
                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW() )";

         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loDataEvento); 
        $query->bindValue(2, $loIdSetor);
        $query->bindValue(3, $loIdProjeto);
        $query->bindValue(4, $loFinalidade);
        $query->bindValue(5, $loIndViagem);
        $query->bindValue(6, $loIndComMotorista);
        $query->bindValue(7, $loIndPernoite);
        $query->bindValue(8, $loDataSaida);
        $query->bindValue(9, $loDataRetorno);
        $query->bindValue(10, $loIdStatusSolic);
        $query->bindValue(11, $CodigoRequisitante);
        $query->bindValue(12, $_SESSION["id_usuario"]);
        $query->bindValue(13, $_SESSION["id_usuario"]);
        $query->bindValue(14, $_SESSION["id_pessoa_matriz"]); 
        $query->bindValue(15, $loIdOrigem); 
        $query->bindValue(16, $loIdPessoaGestor); 
        $query->bindValue(17, $loDtEncGestor);
        $query->bindValue(18, $loCentroDeCusto); 
        $query->bindValue(19, $loIdCnpjFaturamento); 
        $query->execute(); 


        $loSqlMax = "SELECT MAX(id_solicitacao) id_solicitacao_max FROM solicitacao";
        $queryMax = $pdo->prepare($loSqlMax);
        $queryMax->execute(); 
        foreach ($queryMax as $row) {
            $loIDSolicitacao = $row["id_solicitacao_max"];

            //Paradas --
            if(!is_null($loCodigosParadas)){
                foreach ($loCodigosParadas as $rowParada) {

                    $loDadosParada = array(
                        'id_solicitacao'      => $loIDSolicitacao
                        ,'destino'             => $rowParada
                    );
                    $this->IncluirDestinos($loDadosParada);

                }
            }

             //Passageiros --
             if(!is_null($loCodigosPassageiros)){
                foreach ($loCodigosPassageiros as $rowPassageiro) {

                    $loDadosPassageiro = array(
                        'id_solicitacao'      => $loIDSolicitacao
                        ,'passageiro'         => $rowPassageiro
                    );
                    $this->IncluirPassageiro($loDadosPassageiro);

                }
             }

            //Se Usuario Condutor Adiciona ele como motorista 
           /* $loCondutor = $this->VerificaUsuarioConsutor();
            if($loCondutor["ind_condutor"]){ //condutor
                $loSqlMot = "UPDATE solicitacao SET id_pessoa_motorista = ".$loCondutor["id_pessoa"]." WHERE id_solicitacao = ".$loIDSolicitacao;
                $queryMot = $pdo->prepare($loSqlMot);
                $queryMot->execute(); 
            }*/     
            // Verifica se Requisitante é condutor se for adiciona como motorista
            $loCondutor = $this->VerificaRequisitanteMotorista($CodigoRequisitante);
            if($loCondutor["ind_condutor"] && $loIndComMotorista == 0){ //condutor
                $loSqlMot = "UPDATE solicitacao SET id_pessoa_motorista = ".$CodigoRequisitante." WHERE id_solicitacao = ".$loIDSolicitacao;
                $queryMot = $pdo->prepare($loSqlMot);
                $queryMot->execute(); 
            }     
             
            if($loIndEncaminhadoGestor == "1"){
                $loSqlG = "UPDATE solicitacao SET 
                                ind_encaminhado_gestor = 1
                                , dt_encaminhado_gestor = NOW()
                                , id_usuario_encaminhado_gestor = ".$_SESSION["id_usuario"]." 
                           WHERE id_solicitacao = ".$loIDSolicitacao;
                $queryG = $pdo->prepare($loSqlG);
                $queryG->execute();                 
            }       

        }
         

        return $loIDSolicitacao;

    }

    public function IncluirDestinos($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIDSolicitacao = $loDados["id_solicitacao"];
        $destino = ltrim($loDados["destino"]);
        

        $loSqlDes = "INSERT INTO destinos (id_solicitacao,id_localidade,id_usuario_cad,dt_cad) VALUES (?,?,?,NOW())";

        $queryDes = $pdo->prepare($loSqlDes);
        $queryDes->bindValue(1, $loIDSolicitacao ); 
        $queryDes->bindValue(2, $destino ); 
        $queryDes->bindValue(3, $_SESSION["id_usuario"] ); 
        $queryDes->execute(); 
    }

   public function IncluirPassageiro($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIDSolicitacao = $loDados["id_solicitacao"];
        $passageiro = ltrim($loDados["passageiro"]);

        $loSql = "INSERT INTO passageiros (id_solicitacao,id_pessoa_passageiro,id_usuario_cad,dt_cad) VALUES (?,?,?,NOW())";

        $query = $pdo->prepare($loSql);
        $query->bindValue(1, $loIDSolicitacao ); 
        $query->bindValue(2, $passageiro ); 
        $query->bindValue(3, $_SESSION["id_usuario"] ); 
        $query->execute(); 
    }

    public function AlterarSolicitacao($loDados,$loCodigosParadas,$loCodigosPassageiros,$loCodigosOrigem,$loDadosAtendimento){

        $loComumParametros = new comumBO();

        $loDataEvento = $loComumParametros->AdicionaDataHora($loDados["dt_evento"]);
        $loIdSetor = $loDados["id_setor"];
        $loIdProjeto =  $loDados["id_projeto"];
        $loFinalidade = utf8_decode($loDados["finalidade"]);
        $loIndViagem = $loDados["ind_viagem"];
        $loIndComMotorista =  $loDados["ind_com_motorista"];
        $loIndPernoite = $loDados["ind_pernoite"];
        $loDataSaida = $loComumParametros->AdicionaDataHora($loDados["dt_saida"]);
        $loDataRetorno = $loComumParametros->AdicionaDataHora($loDados["dt_retorno_prev"]);
        $loIdStatusSolic = $loDados["id_status_solicitacao"];
        $CodigoRequisitante = $loDados["codigoRequisitante"];
        $loIDSolicitacao = $loDados["id"];
        $loIdMotivoCancelamento = $loDados["id_motivo_cancelamento"];
        $loIndEncaminhadoGestor = $loDados["id_encaminhado_gestor"];
        $loIdCnpjFaturamento = $loDados["id_cnpj_faturamento"];


        //Atendumento
        $loIdVeiculo = $loDadosAtendimento["id_veiculo"];
        $loIdMotorista = $loDadosAtendimento["id_pessoa_motorista"];
        $loKmSaida = $loDadosAtendimento["km_saida"];
        $loKmRetorno = $loDadosAtendimento["km_retorno"];

        //ROTA
        $loDataPartida = NULL;
        if(!empty($loDadosAtendimento["dt_partida"])){ 
            $loDataPartida = $loComumParametros->AdicionaDataHora($loDadosAtendimento["dt_partida"]); 
        }
        $loDataChegada = NULL;
        if(!empty($loDadosAtendimento["dt_partida"])){ 
            $loDataChegada = $loComumParametros->AdicionaDataHora($loDadosAtendimento["dt_chegada"]); 
        }
        
        $loKmPartida = $loDadosAtendimento["km_partida"]; 
        $loKmChegada = $loDadosAtendimento["km_chegada"]; 
        $loIndPlanejado = $loDadosAtendimento["ind_planejado"]; 
        $loObsRealizado = $loDadosAtendimento["obs_realizado"]; 
        $loIdMotivoNaoPlan = $loDadosAtendimento["id_mot_plan"];
        $loIndRealizado = $loDadosAtendimento["ind_realizado"];
        $loIdPessoaGestor = $loDados["id_pessoa_gestor"];
        $loCentroDeCusto = $loDados["id_centro_custo"];

        $loDtEncGestor = "NULL";
        if(!empty($loIdPessoaGestor)){ $loDtEncGestor = "NOW()"; }

        //Pega codigo localidade Origem
        $loIdOrigem = NULL;
        if(!empty($loCodigosOrigem) && count($loCodigosOrigem) > 0){ $loIdOrigem = $loCodigosOrigem[0]; }

        $loAddUpdate = "";
        if($loIdMotorista != ""){
            $loAddUpdate .= " ,id_pessoa_motorista = ".$loIdMotorista;
        }
        /*if($loIndEncaminhadoGestor == "1"){
            $loAddUpdate .= ", ind_encaminhado_gestor = 1 
                             , dt_encaminhado_gestor = NOW() 
                             , id_usuario_encaminhado_gestor = ".$_SESSION["id_usuario"]."  ";
        }*/     


        //Verifica regra para voltar o status da solicitação para aberto quando algum dos campos for alterado
        // * Data do Evento, Data Saida, Data Retorno e Destinos
        $loSolicitacaoClass = new solicitacaoBO();
        $loGrupoAcessoUser = $loSolicitacaoClass->VerificaGrupoAcessoUsuario();

        if( $loGrupoAcessoUser["ind_usuario"] == 1 || $loGrupoAcessoUser["ind_gestor"] == 1 ){

            $ItensBusca = array("id" => $loDados["id"]);
            $ItensSolicRegra = $loSolicitacaoClass->ListaSolicitacao($ItensBusca);
            $ItensRemocao = array("/", ":"," ");

            foreach ($ItensSolicRegra as $row){

                $loDataEventoConferencia = $loComumParametros->AdicionaDataHora(str_replace($ItensRemocao, "", $row["dt_evento"]));
                $loDataSaidaConferencia = $loComumParametros->AdicionaDataHora(str_replace($ItensRemocao, "", $row["dt_saida"]));
                $loDataRetornoPrevConferencia = $loComumParametros->AdicionaDataHora(str_replace($ItensRemocao, "", $row["dt_retorno_prev"]));
                $loOrigemConferencia = $row["nome_localidade"];
                
                    if(count($loCodigosParadas) > 0){            
                        $loParaAlterada = $this->VerificaIgualdadeDestinos($loCodigosParadas,$loDados["id"]);
                    }
                    //echo "entro1";
                    if( $loDataEventoConferencia != $loDataEvento || $loDataSaidaConferencia != $loDataSaida || $loDataRetornoPrevConferencia != $loDataRetorno || $loParaAlterada == 1 ){
                        $loVoltarStatusDaSolicitacao = 1;
                        $loIdStatusSolic = 1;  
                        //echo "entro2";                      
                        //não é utilizado se precisar utilizar aqui é gravado ind quando realizaod alt no banco
                        $loAddUpdate .= " ,ind_status_retornado = 1"; 
                    }else{
                        $loVoltarStatusDaSolicitacao = 0;
                        //echo "entro3";
                    }
            }

        }


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE 
                    solicitacao
                SET
                         dt_evento = ?
                        ,id_setor = ?
                        ,id_projeto = ?
                        ,finalidade = ?
                        ,ind_viagem = ?
                        ,ind_com_motorista = ?
                        ,ind_pernoite = ?
                        ,dt_saida = ?
                        ,dt_retorno_prev = ?
                        ,id_status_solicitacao = ?
                        ,id_pessoa_requisitante = ?
                        ,id_usuario_alt = ?
                        ,id_pessoa_matriz = ?
                        ,id_localidade_origem = ?
                        ,id_motivo_cancelamento = ?
                        ,id_veiculo = ?
                        ,km_saida = ?
                        ,km_retorno = ?
                        ,dt_partida = ?
                        ,dt_chegada = ? 
                        ,km_partida = ? 
                        ,km_chegada = ? 
                        ,ind_planejado = ? 
                        ,obs_realizado = ? 
                        ,id_mot_plan = ?
                        ,ind_realizado = ?
                        ,id_centro_custo = ?
                        ,id_cnpj_faturamento = ?
                        ,dt_alt  = NOW()
                        ".$loAddUpdate."
                WHERE 
                id_solicitacao = ".$loIDSolicitacao; 

            $query = $pdo->prepare($loSql);
            $query->bindValue(1, $loDataEvento); 
            $query->bindValue(2, $loIdSetor);
            $query->bindValue(3, $loIdProjeto);
            $query->bindValue(4, $loFinalidade);
            $query->bindValue(5, $loIndViagem);
            $query->bindValue(6, $loIndComMotorista);
            $query->bindValue(7, $loIndPernoite);
            $query->bindValue(8, $loDataSaida);
            $query->bindValue(9, $loDataRetorno);
            $query->bindValue(10, $loIdStatusSolic);
            $query->bindValue(11, $CodigoRequisitante);
            $query->bindValue(12, $_SESSION["id_usuario"]);
            $query->bindValue(13, $_SESSION["id_pessoa_matriz"]); 
            $query->bindValue(14, $loIdOrigem); 
            $query->bindValue(15, $loIdMotivoCancelamento); 
            $query->bindValue(16, $loIdVeiculo);
            $query->bindValue(17, $loKmSaida); 
            $query->bindValue(18, $loKmRetorno); 
            $query->bindValue(19, $loDataPartida);
            $query->bindValue(20, $loDataChegada); 
            $query->bindValue(21, $loKmPartida); 
            $query->bindValue(22, $loKmChegada); 
            $query->bindValue(23, $loIndPlanejado); 
            $query->bindValue(24, $loObsRealizado); 
            $query->bindValue(25, $loIdMotivoNaoPlan);
            $query->bindValue(26, $loIndRealizado);
            $query->bindValue(27, $loCentroDeCusto);
            $query->bindValue(28, $loIdCnpjFaturamento);
            
            $query->execute(); 

/*
            if($loIdStatusSolic == 1){
                $loSqlEnc = "UPDATE solicitacao SET id_usuario_abertura = ".$_SESSION["id_usuario"].", dt_abertura = NOW() WHERE id_solicitacao = ".$loIDSolicitacao;
                $queryEnc = $pdo->prepare($loSqlEnc);
                $queryEnc->execute(); 
            }   
*/

            if($loIdStatusSolic == 3){

                $loContaAprovadoV = 0;
                $loSqlValidaAprovado = "SELECT COUNT(*) conta_aprovado FROM solicitacao WHERE id_solicitacao = ".$loIDSolicitacao." AND id_usuario_aprovado IS NULL";
                $queryValidaAprovado = $pdo->prepare($loSqlValidaAprovado);
                $queryValidaAprovado->execute(); 
                foreach ($queryValidaAprovado as $rowValidaAprovado) { $loContaAprovadoV = $rowValidaAprovado["conta_aprovado"]; } 

                if($loContaAprovadoV == 1){
                    $loSqlApro = "UPDATE solicitacao SET id_usuario_aprovado = ".$_SESSION["id_usuario"].", dt_aprovado = NOW() WHERE id_solicitacao = ".$loIDSolicitacao;
                    $queryApro = $pdo->prepare($loSqlApro);
                    $queryApro->execute(); 
                }

            }

            if($loIdStatusSolic == 4){
                $loSqlCan = "UPDATE solicitacao SET id_usuario_cancelamento = ".$_SESSION["id_usuario"].", dt_cancelamento = NOW() WHERE id_solicitacao = ".$loIDSolicitacao;
                $queryCan = $pdo->prepare($loSqlCan);
                $queryCan->execute(); 
            }     
            
            if($loIdStatusSolic == 5){
                $loSqlCan = "UPDATE solicitacao SET id_usuario_fechado = ".$_SESSION["id_usuario"].", dt_fechado = NOW() WHERE id_solicitacao = ".$loIDSolicitacao;
                $queryCan = $pdo->prepare($loSqlCan);
                $queryCan->execute(); 
            }     
            

            //Comentado pois estava dando problema quando alterava o item deleta tudo nao pode mais :()
            /*$loSqlDDestino = "DELETE FROM destinos WHERE id_solicitacao = ".$loIDSolicitacao;
            $queryDDestino = $pdo->prepare($loSqlDDestino);
            $queryDDestino->execute();*/ 

            $loSqlDPassageiros = "DELETE FROM passageiros WHERE id_solicitacao = ".$loIDSolicitacao;
            $queryDPassageiros = $pdo->prepare($loSqlDPassageiros);
            $queryDPassageiros->execute(); 
  

           //PARADAS INICIO -------------------------------------------------------------------------------------------------------------------------------           
           if(count($loCodigosParadas)){
                foreach ($loCodigosParadas as $codigoItens) {

                    $Itens = explode(":", $codigoItens); 

                    if(count($Itens) > 1){
                        $id_destino = $Itens[1];
                    }else{
                        $id_destino = 0;
                    }                    
                    
                    $id_localidade = $Itens[0];
                    $contaItemDestino = 0;

                    if( $id_destino > 0 ){
                        $loSqlContaDestino = "SELECT COUNT(*) cont_destino 
                                            FROM destinos 
                                            WHERE id_solicitacao = ".$loIDSolicitacao." 
                                            AND id_localidade = ".$id_localidade." 
                                            AND id_destino = ".$id_destino;
                        $queryContaDestino = $pdo->prepare($loSqlContaDestino);
                        $queryContaDestino->execute();    
                        foreach ($queryContaDestino as $rowContaDestino) { $contaItemDestino = $rowContaDestino["cont_destino"]; }  
                    }

                    if($contaItemDestino == 0){
                        $loDadosParada = array('id_solicitacao' => $loIDSolicitacao,'destino' => $id_localidade);
                        $this->IncluirDestinos($loDadosParada);
                    }

                }
           }
           //PARADAS FIM -------------------------------------------------------------------------------------------------------------------------------

            //Passageiros INICIO --
            if(count($loCodigosPassageiros)){
                foreach ($loCodigosPassageiros as $rowPassageiro) {

                $loDadosPassageiro = array(
                    'id_solicitacao'      => $loIDSolicitacao
                    ,'passageiro'         => $rowPassageiro
                );
                $this->IncluirPassageiro($loDadosPassageiro);

                }
            }
            //Passageiro FIM --

            
            //Altera Status do Veiculo 
            $this->AlteraStatusVeiculo($loIdVeiculo,$loIdStatusSolic);


        return true;         

    }

    public function AlteraStatusVeiculo($loIdVeiculo,$loIdStatusSolic){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if($loIdStatusSolic == "4" || $loIdStatusSolic == "5"){
            $loSituacao = "D";
        }else{
            $loSituacao = "U";
        }
        $loSql = "UPDATE veiculo SET situacao = '".$loSituacao."' WHERE id_veiculo = ".$loIdVeiculo;
        $query = $pdo->prepare($loSql);
        $query->execute();   

        return true;
    }

    public function ListaItensConsulta($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdMenu = $loDados["id_menu"];
        //if($loIdMenu == 30) $loIdMenu = 12;

        //Busca Itens para consulta
        $loSqlC = "SELECT id_grid_consulta FROM usuario_consulta WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$loIdMenu;    
        $query = $pdo->prepare($loSqlC);
        $query->execute();    

        foreach ($query as $row) { $id_grid_consulta = $row["id_grid_consulta"]; }  


        $loSql = "SELECT id_grid_consulta,campo_bd,campo_visual FROM grid_consulta WHERE id_grid_consulta IN(".$id_grid_consulta.") AND id_menu = ".$loIdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loConsulta = null;
        foreach ($query as $row) {
               
               $loConsulta[] = array(
                    'id_grid_consulta'      => $row["id_grid_consulta"]
                    ,'campo_bd'             => $row["campo_bd"]
                    ,'campo_visual'         => $row["campo_visual"]
                );
               
        
        }

        return $loConsulta;  


    }

    public function GridConsultaItens($IdMenu){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        //Verifica itens selecionados
        $loSqlBsCheck = "SELECT id_grid_consulta FROM usuario_consulta WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$IdMenu;
        $queryBsCheck = $pdo->prepare($loSqlBsCheck);
        $queryBsCheck->execute(); 
        foreach ($queryBsCheck as $row) {
               $ItensSelecionados = $row["id_grid_consulta"];         
        } 
        
        //Lista todos os itens da tabela cliente depara
        $loSql = "SELECT id_grid_consulta,campo_bd,campo_visual FROM grid_consulta WHERE id_menu = ".$IdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {


            $checked = "";
            $loItens = explode(",", $ItensSelecionados);   
            $contaItem = count($loItens);
            foreach ($loItens as $item){

                if($item == $row["id_grid_consulta"]){ $checked = "checked"; }

            }


             $loGrid[] = array(
                    'campo_visual'       => $row["campo_visual"]
                    ,'campo_bd'          => $row["campo_bd"]
                    ,'id_grid_consulta'  => $row["id_grid_consulta"]
                    ,'checked'           => $checked
                );

        }

        return $loGrid;

    }

    public function AlteraConsultaSolicitacao($loDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdMenu = $loDados["id_menu"];
        $loStrConsulta = substr($loDados["strConsulta"],0,-1);

        $loSql = "UPDATE usuario_consulta set id_grid_consulta = '".$loStrConsulta."' WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$loIdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();



    }    


    public function ListaSituacao($loDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_status_solicitacao,nome FROM status_solicitacao ORDER BY id_status_solicitacao";
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_status_solicitacao'       => $row["id_status_solicitacao"]
                    ,'nome'                       => $row["nome"]
                );

        }

        return $loGrid;

    }   

    public function ListaPassageiros($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdSolicitacao = $loDados["id_solicitacao"];

        $loSql = "SELECT 
                    id_solicitacao
                    ,pessoa.id_pessoa 
                    ,pessoa.nome
                    ,pessoa.telefone_dd
                    ,pessoa.telefone
                    ,pessoa.ind_motorista
                FROM passageiros 
                INNER JOIN pessoa ON pessoa.id_pessoa = passageiros.id_pessoa_passageiro
                WHERE id_solicitacao = ".$loIdSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_solicitacao'       => $row["id_solicitacao"]
                    ,'id_pessoa'           => $row["id_pessoa"]
                    ,'nome'                => $row["nome"]
                    ,'telefone_dd'         => $row["telefone_dd"]
                    ,'telefone'            => $row["telefone"]
                    ,'ind_motorista'       => $row["ind_motorista"]
                );

        }

        return $loGrid;
        

    }


   public function ListaOrigem($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdSolicitacao = $loDados["id_solicitacao"];

        $loSql = "SELECT  
                    localidade.id_localidade
                    ,localidade.nome
                    ,localidade.endereco
                    ,cidade.nome as nome_cidade
                    ,estado.uf
                FROM solicitacao
                INNER JOIN localidade ON localidade.id_localidade = solicitacao.id_localidade_origem
                LEFT JOIN cidade ON cidade.id_cidade = localidade.id_cidade
                LEFT JOIN estado ON estado.id_estado = cidade.id_estado
                WHERE solicitacao.id_solicitacao = ".$loIdSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id'       => $row["id_localidade"]
                    ,'nome'    => $row["nome"]
                    ,'endereco'=> $row["endereco"]
                    ,'nome_cidade' => $row["nome_cidade"]
                    ,'uf' => $row["uf"]
                );

        }

        return $loGrid;
        

    }

    public function ListaDestinos($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loConsulta = "";        
        if(isset($loDados["id_solicitacao"]) && !empty($loDados["id_solicitacao"]) ){
            $loIdSolicitacao = $loDados["id_solicitacao"];
            $loConsulta .= " AND solicitacao.id_solicitacao = ".$loIdSolicitacao;
        }

        if(isset($loDados["id_destino"]) && !empty($loDados["id_destino"]) ){
            $loIdSolicitacao = $loDados["id_destino"];
            $loConsulta .= " AND destinos.id_destino = ".$loIdSolicitacao;
        }

        if(isset($loDados["ultimo"]) && !empty($loDados["ultimo"]) && $loDados["ultimo"] == 1 ){
            $loConsulta .= " ORDER BY id_destino DESC LIMIT 1";
        }else{
            $loConsulta .= " ORDER BY id_destino ASC";
        }

        $loSql = "SELECT  
                    destinos.id_destino
                    ,localidade.id_localidade
                    ,localidade.nome
                    ,localidade.endereco
                    ,DATE_FORMAT(destinos.dt_partida , '%d/%m/%Y %H:%i') dt_partida
                    ,DATE_FORMAT(destinos.dt_chegada , '%d/%m/%Y %H:%i') dt_chegada
                    ,destinos.km_saida 
                    ,destinos.km_chegada 
                    ,destinos.ind_planejado 
                    ,destinos.id_mot_plan 
                    ,destinos.ind_realizado 
                    ,destinos.outros  
                    ,destinos.id_usuario_alt 
                    ,destinos.dt_alt 
                    ,cidade.nome as nome_cidade
                    ,estado.uf                    
                FROM solicitacao
                INNER JOIN destinos ON destinos.id_solicitacao = solicitacao.id_solicitacao
                INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                LEFT JOIN cidade ON cidade.id_cidade = localidade.id_cidade
                LEFT JOIN estado ON estado.id_estado = cidade.id_estado                
                WHERE 1=1 ".$loConsulta;

        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        $loContaItens = 1;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_destino'        => $row["id_destino"]
                    ,'id_localidade'    => $row["id_localidade"]
                    ,'nome'             => $row["nome"]
                    ,'endereco'         => $row["endereco"]
                    ,'dt_partida'       => $row["dt_partida"] 
                    ,'dt_chegada'       => $row["dt_chegada"]
                    ,'km_saida'         => $row["km_saida"]
                    ,'km_chegada'       => $row["km_chegada"]
                    ,'ind_planejado'    => $row["ind_planejado"] 
                    ,'id_mot_plan'      => $row["id_mot_plan"] 
                    ,'ind_realizado'    => $row["ind_realizado"] 
                    ,'outros'           => $row["outros"] 
                    ,'id_usuario_alt'   => $row["id_usuario_alt"] 
                    ,'dt_alt'           => $row["dt_alt"]
                    ,'nome_cidade'      => $row["nome_cidade"]
                    ,'uf'               => $row["uf"]
                    ,'contagem'         => $loContaItens
                );
                $loContaItens++;

        }

        return $loGrid;
        

    }

    public function ListaMapaAtendimentos($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 
                    solicitacao.id_solicitacao
                    ,setor.nome as nome_setor
                    ,DATE_FORMAT(solicitacao.dt_partida, '%d/%m/%Y %H:%i') dt_partida 
                    ,DATE_FORMAT(solicitacao.dt_chegada, '%d/%m/%Y %H:%i') dt_chegada 
                    ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida 
                    ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev 
                    ,status_solicitacao.nome as nome_situacao
                    ,veiculo.placa
                    ,pessoa.nome as nome_motorista
                    ,(
                        SELECT 
                            localidade.nome 
                        FROM destinos 
                        INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                        WHERE destinos.id_solicitacao = solicitacao.id_solicitacao
                        ORDER BY destinos.id_destino DESC LIMIT 1
                    ) as destino
                    FROM solicitacao
                    LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                    LEFT JOIN setor ON setor.id_setor = solicitacao.id_setor
                    LEFT JOIN status_solicitacao ON status_solicitacao.id_status_solicitacao = solicitacao.id_status_solicitacao
                    LEFT JOIN pessoa ON pessoa.id_pessoa = solicitacao.id_pessoa_motorista
                    WHERE 1=1 ".$mbDados;

        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_solicitacao'   => $row["id_solicitacao"]
                    ,'nome_setor'      => $row["nome_setor"]
                    ,'dt_saida'        => $row["dt_saida"]
                    ,'dt_retorno_prev' => $row["dt_retorno_prev"]
                    ,'dt_partida'      => $row["dt_partida"]
                    ,'dt_chegada'      => $row["dt_chegada"]
                    ,'nome_situacao'   => $row["nome_situacao"]
                    ,'destino'         => $row["destino"]
                    ,'placa'           => $row["placa"]
                    ,'nome_motorista'  => $row["nome_motorista"]
                );

        }

        return $loGrid;

    }

    public function AutorizacaoPDF($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();    

        $IdSolicitacao = $mbDados["id_solicitacao"];

        $loSql = "SELECT 
                    solicitacao.id_solicitacao
                    ,setor.nome as nome_setor
                    ,requisitante.nome as nome_requisitante
                    ,requisitante.telefone_dd as dd_requisitante
                    ,requisitante.telefone as telefone_requisitante
                    ,solicitacao.finalidade 
                    ,DATE_FORMAT(solicitacao.dt_abertura, '%d/%m/%Y %H:%i') dt_abertura 
                    ,DATE_FORMAT(solicitacao.dt_aprovado, '%d/%m/%Y %H:%i') dt_aprovado 
                    ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida 
                    ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev 
                    ,origem.nome as nome_origem
                    ,veiculo.placa 
                    ,modelo.nome as nome_modelo
                    ,motorista.nome as nome_motorista
                    ,motorista.telefone_dd as dd_motorista
                    ,motorista.telefone as telefone_motorista
                FROM solicitacao
                    LEFT JOIN setor ON setor.id_setor = solicitacao.id_setor
                    LEFT JOIN pessoa requisitante ON requisitante.id_pessoa = solicitacao.id_pessoa_requisitante
                    LEFT JOIN localidade origem ON origem.id_localidade = solicitacao.id_localidade_origem
                    LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                    LEFT JOIN modelo ON modelo.id_modelo = veiculo.id_modelo
                    LEFT JOIN pessoa motorista ON motorista.id_pessoa = solicitacao.id_pessoa_motorista
                WHERE id_solicitacao = ".$IdSolicitacao;

        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_solicitacao'            => $row["id_solicitacao"]
                    ,'nome_setor'               => $row["nome_setor"]
                    ,'nome_requisitante'        => $row["nome_requisitante"]
                    ,'dd_requisitante'          => $row["dd_requisitante"]
                    ,'telefone_requisitante'    => $row["telefone_requisitante"]
                    ,'finalidade'               => $row["finalidade"] 
                    ,'dt_abertura'              => $row["dt_abertura"]
                    ,'dt_aprovado'              => $row["dt_aprovado"]
                    ,'dt_saida'                 => $row["dt_saida"]
                    ,'dt_retorno_prev'          => $row["dt_retorno_prev"]
                    ,'nome_origem'              => $row["nome_origem"]
                    ,'placa'                    => $row["placa"]
                    ,'nome_modelo'              => $row["nome_modelo"]
                    ,'nome_motorista'           => $row["nome_motorista"]
                    ,'dd_motorista'             => $row["dd_motorista"]
                    ,'telefone_motorista'       => $row["telefone_motorista"]
                    ,'destinos'                 => $this->DestinosAturizacaoPDF($IdSolicitacao)
                    ,'passageiros'              => $this->PassageirosAturizacaoPDF($IdSolicitacao)
                );

        }

        return $loGrid; 

    }

    public function DestinosAturizacaoPDF($mbId){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();            

        $loSql = "SELECT 
                    localidade.nome 
                FROM destinos 
                INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                WHERE destinos.id_solicitacao = ".$mbId." 
                ORDER BY destinos.id_destino ";
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'nome'            => $row["nome"]
                );
        }
        return $loGrid;                 
    }

    public function PassageirosAturizacaoPDF($mbId){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();            

        $loSql = "SELECT 
                    pessoa.nome
                    ,pessoa.telefone_dd
                    ,pessoa.telefone	
                FROM passageiros 
                INNER JOIN pessoa ON pessoa.id_pessoa = passageiros.id_pessoa_passageiro
                WHERE passageiros.id_solicitacao = ".$mbId." 
                ORDER BY pessoa.nome ";
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'nome'            => $row["nome"]
                    ,'telefone_dd'    => $row["telefone_dd"]
                    ,'telefone'       => $row["telefone"]
                );
        }
        return $loGrid;                 
    }

    public function DadosEnvioEmail($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();       

       $loIdSolicitacao = $mbDados["id_solicitacao"];
       $loSql = "SELECT 
                    requisitante.nome
                    ,requisitante.email 
                FROM solicitacao 
                INNER JOIN pessoa requisitante ON requisitante.id_pessoa = solicitacao.id_pessoa_requisitante
                WHERE solicitacao.id_solicitacao = ".$loIdSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'nome'      => $row["nome"]
                    ,'email'    => $row["email"]
                );
        }

        return $loGrid;  
    }

    public function DisplayMotoristas($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();    

        $loSql = " SELECT 
                        solicitacao.id_solicitacao
                        ,setor.nome as setor
                        ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida 
                        ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev 
                        ,veiculo.placa
                        ,motorista.nome as motorista
                        ,status_solicitacao.nome situacao
                        ,(
                            SELECT localidade.nome
                            FROM destinos 
                            INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                            WHERE destinos.id_solicitacao = solicitacao.id_solicitacao 
                            ORDER BY  id_destino DESC LIMIT 1
                        ) as destino
                    FROM solicitacao
                        INNER JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                        INNER JOIN pessoa motorista ON motorista.id_pessoa = solicitacao.id_pessoa_motorista
                        INNER JOIN status_solicitacao ON status_solicitacao.id_status_solicitacao = solicitacao.id_status_solicitacao
                        LEFT JOIN setor ON setor.id_setor = solicitacao.id_setor
                    WHERE status_solicitacao.id_status_solicitacao = 3 AND motorista.ind_motorista = 1
                    ORDER BY solicitacao.dt_saida";
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_solicitacao'        => $row["id_solicitacao"]
                    ,'setor'                => $row["setor"]
                    ,'dt_saida'             => $row["dt_saida"]
                    ,'dt_retorno_prev'      => $row["dt_retorno_prev"]
                    ,'placa'                => $row["placa"]
                    ,'motorista'            => $row["motorista"]
                    ,'situacao'             => $row["situacao"]
                    ,'destino'              => $row["destino"]
                );
        }

        return $loGrid;                      
    }

   public function ListaRequisitante($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

       $loIdUsuario = $mbDados["id_usuario"];

        $loSql = "SELECT  
                        pessoa.id_pessoa
                        ,pessoa.nome as nome_pessoa
                        ,setor.id_setor as id_setor
                        ,setor.nome as nome_setor
                        ,pessoa.ind_passageiro
                        ,pessoa.ind_condutor
                   FROM usuario
                    INNER JOIN pessoa ON pessoa.id_pessoa = usuario.id_pessoa_origem
                    LEFT JOIN setor ON setor.id_setor = pessoa.id_setor
                   WHERE usuario.id_usuario = ".$loIdUsuario;
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {
        
            $loGrid[] = array(
                    'id_pessoa_requisitante' => $row["id_pessoa"]
                    ,'nome_requisitante'     => $row["nome_pessoa"]
                    ,'id_setor'              => $row["id_setor"]
                    ,'ind_passageiro'        => $row["ind_passageiro"]
                    ,'ind_condutor'          => $row["ind_condutor"]
                );
        }

        return $loGrid;                      
    }

    public function GavaAtendimentoRotas($mbDados){

        $loComumParametros = new comumBO();

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();  

        $loDataPartida   = $loComumParametros->AdicionaDataHora($mbDados["data_partida"]);
        $loDataChegada   = $loComumParametros->AdicionaDataHora($mbDados["data_chegada"]);
        $loKmPartida     = $mbDados["km_partida"];
        $loKmChegada     = $mbDados["km_chegada"];
        $loIndPlanejado  = $mbDados["ind_planejado"];
        $loIdMotNaoPlan  = $mbDados["id_mot_plan"];
        $loIndRealizado  = $mbDados["ind_realizado"];
        $loIdDestino     = $mbDados["id_destino"];


        $loSql = "UPDATE 
                    destinos SET 
                    dt_partida = ?
                    , dt_chegada = ?
                    , km_saida = ?
                    , km_chegada = ?
                    , ind_planejado = ?
                    , id_mot_plan = ?
                    , ind_realizado = ?
                    , id_usuario_alt = ?
                    , dt_alt = NOW()
                    WHERE id_destino = ? ";
        $query = $pdo->prepare($loSql);
        $query->bindValue(1, $loDataPartida); 
        $query->bindValue(2, $loDataChegada);
        $query->bindValue(3, $loKmPartida);
        $query->bindValue(4, $loKmChegada);
        $query->bindValue(5, $loIndPlanejado);
        $query->bindValue(6, $loIdMotNaoPlan);
        $query->bindValue(7, $loIndRealizado);
        $query->bindValue(8, $_SESSION["id_usuario"]);
        $query->bindValue(9, $loIdDestino);
        $query->execute();                     

        return true;
    }

    public function GavaAtendimentoRotasObsOutros($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();  
        
        $loId = $mbDados["id_destino"];
        $loObs = $mbDados["obs"];

        $loSql = "UPDATE destinos SET outros = '".$loObs."' WHERE id_destino = ".$loId;
        $query = $pdo->prepare($loSql);
        $query->execute(); 

        return true;

    }

    public function RemoveDestino($mbId){
        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao(); 

        $loSolicitacaoClass = new solicitacaoBO();
        $loGrupoAcessoUser = $loSolicitacaoClass->VerificaGrupoAcessoUsuario();

        if( $loGrupoAcessoUser["ind_usuario"] == 1 || $loGrupoAcessoUser["ind_gestor"] == 1 ){
        
            $loSqlStatus = "UPDATE solicitacao SET id_status_solicitacao = 1 where id_solicitacao = (SELECT id_solicitacao FROM destinos WHERE id_destino = ".$mbId.")";
            $queryStatus = $pdo->prepare($loSqlStatus);
            $queryStatus->execute();     

        }    

        $loSql = "DELETE FROM destinos WHERE id_destino = ".$mbId;
        $query = $pdo->prepare($loSql);
        $query->execute(); 

    }

     public function ListaLocalidade($mbDados,$mbId){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSqlUnion ="";
        if($mbId != ""){
            $loSqlUnion = "UNION
                    SELECT 
                        localidade.id_localidade, 
                        localidade.nome, 
                        localidade.endereco,
                        destinos.id_destino
                    FROM localidade
                    LEFT JOIN categoria_localidades 
                        ON categoria_localidades.id_cat_localidade = localidade.id_cat_localidade
                    INNER JOIN destinos 
                        ON destinos.id_localidade = localidade.id_localidade AND destinos.id_solicitacao = ".$mbId;
        }


        $loSql = "SELECT 
                        localidade.id_localidade, 
                        localidade.nome, 
                        localidade.endereco, 
                        0 as id_destino
                    FROM localidade
                    LEFT JOIN categoria_localidades 
                        ON categoria_localidades.id_cat_localidade = localidade.id_cat_localidade
                    WHERE 1=1 ".$mbDados. " ".$loSqlUnion;
                    
        //echo $loSql;    
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loLocalidades = null;
        foreach ($query as $row) {
               
               
               $loLocalidades[] = array(
                     'id_localidade'        => $row["id_localidade"] 
                     ,'nome'                 => $row["nome"] 
                     ,'endereco'             => $row["endereco"] 
                     ,'id_destino'           => $row["id_destino"]
                );
               
        
        }

        return $loLocalidades;        



    }

    public function FechaSolicitacao($mbIdSolicitacao){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE solicitacao 
                    SET id_status_solicitacao = 5
                    , id_usuario_fechado = ".$_SESSION["id_usuario"]."
                    , dt_fechado = NOW() 
                    WHERE id_solicitacao = ".$mbIdSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute(); 

        $loSqlV = "select id_veiculo from solicitacao where id_solicitacao = ".$mbIdSolicitacao;
        $queryV= $pdo->prepare($loSqlV);
        $queryV->execute(); 
        foreach ($queryV as $rowV) { $this->AlteraStatusVeiculo($rowV["id_veiculo"],5); }

        return true;
    }

    public function GravaDestinoRota($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdSolicitacao = $mbDados["id_solicitacao"];
        $loIdLocalidade = $mbDados["id_localidade"];

        $loSql = "INSERT INTO destinos (id_solicitacao,id_localidade) VALUES (".$loIdSolicitacao.",".$loIdLocalidade.")";
        $query= $pdo->prepare($loSql);
        $query->execute();  
        
         return true;
    }

    public function ExcluirDestinoRota($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loId = $mbDados["id_destino"];

        $loSql = "DELETE FROM destinos WHERE id_destino = ".$loId;
        $query= $pdo->prepare($loSql);
        $query->execute();  
        
         return true;

    }

    public function ValidaPlaca($mbPlaca){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();  

        $loSqlCont = "SELECT COUNT(placa) conta_placa  FROM veiculo WHERE placa = '".$mbPlaca."'";
        $queryCont= $pdo->prepare($loSqlCont);
        $queryCont->execute();    

        $contagem = 0;
        foreach ($queryCont as $rowCont) { $contagem = $rowCont["conta_placa"]; }

        $loSqlCd = "SELECT id_veiculo  FROM veiculo WHERE placa = '".$mbPlaca."'";
        $queryCd= $pdo->prepare($loSqlCd);
        $queryCd->execute();    

        $id_veiculo = null;
        foreach ($queryCd as $rowCd) { $id_veiculo = $rowCd["id_veiculo"];  }  


        $loDados = array(
                'contagem'        => $contagem 
                ,'id_veiculo'     => $id_veiculo 
                ,'messagem'       => "Placa invalida"
        );


        return $loDados;
    }  

    public function GravarMotivoCancelamento($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdSolicitacao = $mbDados["id_solicitacao"];
        $loIdMotivoCancelamento = $mbDados["id_motivo_cancelamento"];

        $loSql = "UPDATE solicitacao SET 
                     id_motivo_cancelamento = ".$loIdMotivoCancelamento."
                    ,id_status_solicitacao = 4
                    ,id_usuario_cancelamento = ".$_SESSION["id_usuario"]."
                    ,dt_cancelamento = NOW()
                  WHERE id_solicitacao = ".$loIdSolicitacao;
        
        $query= $pdo->prepare($loSql);
        $query->execute(); 


        $loSqlV = "select id_veiculo from solicitacao where id_solicitacao = ".$loIdSolicitacao;
        $queryV= $pdo->prepare($loSqlV);
        $queryV->execute(); 
        foreach ($queryV as $rowV) { $this->AlteraStatusVeiculo($rowV["id_veiculo"],4); }
          

        return true;
    }  

    public function ValidaMotorista($loIdMotorista){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        //Verifica se motorista esta com a habilitacao vencida
        $loSql = "  SELECT 
                        COUNT(*) conta_motorista_vencido
                    FROM 
                    pessoa 
                        LEFT JOIN setor ON setor.id_setor = pessoa.id_setor
                    WHERE 
                        id_tipo_pessoa = 4 AND pessoa.ativo = 1
                    AND
                        DATEDIFF(pessoa.validade_habilitacao,NOW()) < 0 AND id_pessoa = ".$loIdMotorista."
                    ORDER BY DATEDIFF(NOW(),pessoa.validade_habilitacao) DESC";
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loHabilitado = true;
        foreach ($query as $row) { if($row["conta_motorista_vencido"] == 1){ $loHabilitado = false; }  }     

        return $loHabilitado;             

    }

    public function VerificaSeExisteCaronaPendentedeAprovacao(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();   

        $loIdGrupoAcesso = NULL;
        $loSqlVerificaGrupo = "SELECT id_grupo FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"];
        $queryGrupoAcesso= $pdo->prepare($loSqlVerificaGrupo);
        $queryGrupoAcesso->execute();  
        foreach ($queryGrupoAcesso as $rowGrupoAcesso) {
            $loIdGrupoAcesso = $rowGrupoAcesso["id_grupo"];           
        }

        $loWhere = "";
       /* if($loIdGrupoAcesso != 4){ // se não for operador exibir somente as carona de quem ele autoriza.
            $loWhere = "AND solicitacao_carona.id_pessoa_autorizador IN(
                        SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"]."
                    )";
        }*/                

        $loSql = "SELECT COUNT(id_pessoa_autorizador) as carona_pendente
                  FROM solicitacao_carona 
                  WHERE (status IS NULL OR status = 'C') ".$loWhere;
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loCarona = 0;
        foreach ($query as $row) { $loCarona = $row["carona_pendente"];  }     

        return $loCarona;                         

    }
    public function ListaCaronasSolicitadas($loDados,$loConsulta){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();             

        $IdSolicitacao = $loDados["id_solicitacao"];

        $loIdGrupoAcesso = NULL;
        $loSqlVerificaGrupo = "SELECT id_grupo FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"];
        $queryGrupoAcesso= $pdo->prepare($loSqlVerificaGrupo);
        $queryGrupoAcesso->execute();  
        foreach ($queryGrupoAcesso as $rowGrupoAcesso) {
            $loIdGrupoAcesso = $rowGrupoAcesso["id_grupo"];           
        }

        $loWhere = "";
        if($loIdGrupoAcesso != 4){ // Se nao for operador mostra somente os que ele pode autorizar
            $loWhere = " AND solicitacao_carona.id_pessoa_autorizador IN(SELECT id_pessoa_origem FROM usuario WHERE usuario.id_usuario = ".$_SESSION["id_usuario"].")";
        }

        $loSql = "SELECT 
                        solicitacao.id_solicitacao
                        ,solicitante.id_pessoa as id_pessoa_solicitante
                        ,solicitante.nome  as nome_pessoa_solicitante
                        ,DATE_FORMAT(solicitacao_carona.dt_cad, '%d/%m/%Y %H:%i') dt_cad
                        ,status
                        ,origem.nome as origem 	
                        ,(
                        SELECT 
                            localidade.nome 
                        FROM destinos 
                        INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade 
                        WHERE destinos.id_solicitacao = solicitacao.id_solicitacao
                        ORDER BY destinos.id_destino DESC LIMIT 1
                        ) as ultimo_destino
                        ,(SELECT COUNT(id_passageiros) FROM passageiros where id_solicitacao = solicitacao.id_solicitacao) qtd_passageiro
                        ,solicitacao.id_pessoa_motorista
                        ,veiculo.qtd_passageiro as qtd_passageiro_veiculo
                FROM solicitacao_carona
                INNER JOIN pessoa solicitante ON solicitante.id_pessoa = solicitacao_carona.id_pessoa_solicitante
                INNER JOIN solicitacao ON solicitacao.id_solicitacao = solicitacao_carona.id_solicitacao
                INNER JOIN localidade origem ON origem.id_localidade = solicitacao.id_localidade_origem
                LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                WHERE  
                    solicitacao.id_solicitacao = ".$IdSolicitacao." ".$loWhere." ".$loConsulta;
        //echo  $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loItens = null;
        foreach ($query as $row) {
               
               
               $loItens[] = array(
                     'id_solicitacao'               => $row["id_solicitacao"] 
                     ,'id_pessoa_solicitante'       => $row["id_pessoa_solicitante"] 
                     ,'nome_pessoa_solicitante'     => $row["nome_pessoa_solicitante"] 
                     ,'dt_cad'                      => $row["dt_cad"]
                     ,'status'                      => $row["status"]
                     ,'origem'                      => $row["origem"]
                     ,'ultimo_destino'              => $row["ultimo_destino"]
                     ,'qtd_passageiro'              => $row["qtd_passageiro"]
                     ,'id_pessoa_motorista'         => $row["id_pessoa_motorista"]
                     ,'qtd_passageiro_veiculo'      => $row["qtd_passageiro_veiculo"]
                );
               
        
        }

        return $loItens;                  

    }

    public function AtualizaSolicitacaoCarona($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao(); 

        $loStatus = $loDados["status"];
        $loIdPessoaSolicitante = $loDados["id_pessoa_solicitante"];
        $loIdSolicitacao = $loDados["id_solicitacao"];

        $loSql = "UPDATE solicitacao_carona 
                    SET 
                      status = '". $loStatus."'
                    , dt_aprovacao_cancelamento = NOW() 
                  WHERE id_solicitacao = ".$loIdSolicitacao." 
                  AND id_pessoa_solicitante = ".$loIdPessoaSolicitante." 
                  AND (status = 'S' OR status IS NULL)";
       $query= $pdo->prepare($loSql);
       $query->execute();   

       return true;

    }

    public function GavaDadosSolicitacao($loDados){


        $loIdSolicitacao = $loDados["id_solicitacao"];
        $loIdPessoaSolicitante = $loDados["id_pessoa_solicitante"];

        $loDadosPassageiro  = NULL;
        $loDadosPassageiro = array(
                    'id_solicitacao'      => $loIdSolicitacao
                    ,'passageiro'         => $loIdPessoaSolicitante
                );
        $this->IncluirPassageiro($loDadosPassageiro);

        return true;

    }

    public function DadosEnvioPessoaEmail($mbIdPessoa){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT nome,email FROM pessoa WHERE id_pessoa = ".$mbIdPessoa;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loItensConsulta = null;
        foreach ($query as $row) {
               
               $loItensConsulta[] = array(
                    'nome' => $row["nome"] 
                    ,'email' => $row["email"] 
                );   
        }

        return $loItensConsulta;   

    }
    
    public function CarregaEmailRequisitante($mbIdSolicitacao){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
    
        $loSql = "SELECT pessoa.nome,pessoa.email
                    FROM solicitacao 
                    INNER JOIN pessoa ON pessoa.id_pessoa = solicitacao.id_pessoa_requisitante
                    WHERE id_solicitacao = ".$mbIdSolicitacao;
        $query = $pdo->prepare($loSql);
        $query->execute();   

        $loItensConsulta = null;
        foreach ($query as $row) {
               
               
               $loItensConsulta[] = array(
                     'nome' => $row["nome"] 
                    ,'email' => $row["email"] 
                );   
        }
        return $loItensConsulta;  

    }

    public function ValidaQtdPassageiro($loDados){

        $loIdSolicitacao = $loDados["id_solicitacao"];
        $loIdVeiculo = $loDados["id_veiculo"];

        $loQtdPassageiroSolicitacao = NULL; 
        $loQtdPassageiroVeiculo = NULL;

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSqlP = "SELECT COUNT(id_passageiros) conta_passageiro_solicitacao
                    FROM passageiros 
                    WHERE id_solicitacao = ".$loIdSolicitacao;
        $queryP= $pdo->prepare($loSqlP);
        $queryP->execute();    

        foreach ($queryP as $rowP) { $loQtdPassageiroSolicitacao = $rowP["conta_passageiro_solicitacao"];  }  

        $loSqlV = "SELECT qtd_passageiro FROM veiculo WHERE id_veiculo = ".$loIdVeiculo;
        $queryV = $pdo->prepare($loSqlV);
        $queryV->execute();    

        foreach ($queryV as $rowV) { $loQtdPassageiroVeiculo = $rowV["qtd_passageiro"];  }     

        if( $loQtdPassageiroSolicitacao > $loQtdPassageiroVeiculo){
            $loRetorno = true;    
        }else{
            $loRetorno = false;
        }

        return $loRetorno;

    }


    public function ListaVeiculo($mbConsulta){

           
            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();

            $loSql = "SELECT 
                        veiculo.id_veiculo
                        ,modelo.id_modelo
                        ,modelo.nome as nomeModelo
                        ,combustivel.id_combustivel
                        ,combustivel.nome as nomeCombustivel
                        ,cor.id_cor
                        ,cor.nome as nomeCor
                        ,veiculo.placa
                        ,veiculo.chassi
                        ,veiculo.renavam
                        ,veiculo.ano_veiculo
                        ,veiculo.ano_modelo
                        ,veiculo.num_motor
                        ,veiculo.id_pessoa_matriz
                        ,veiculo.id_pessoa_cad
                        ,veiculo.dt_cad
                        ,veiculo.dt_alt
                        ,veiculo.id_usuario_cad
                        ,veiculo.id_usuario_alt 
                        ,veiculo.ativo
                        ,nivel_combustivel.id_nivel_combustivel
                        ,nivel_combustivel.nome as nomeNivelCombustivel
                        ,veiculo.qtd_passageiro 
                        ,veiculo.portas 
                        ,veiculo.km 
                        ,veiculo.exclusivo 
                        ,DATE_FORMAT(veiculo.data_substituidoDev, '%d/%m/%Y') data_substituidoDev
                        ,veiculo.id_localidade_garagem
                        ,veiculo.situacao
                        ,veiculo.motivo_desativacao
                        ,DATE_FORMAT(veiculo.dt_alt_status, '%d/%m/%Y %H:%i') dt_alt_status
                    FROM veiculo 
                    LEFT JOIN modelo ON modelo.id_modelo = veiculo.id_modelo
                    LEFT JOIN combustivel ON combustivel.id_combustivel = veiculo.id_combustivel
                    LEFT JOIN cor ON cor.id_cor = veiculo.id_cor
                    LEFT JOIN nivel_combustivel ON nivel_combustivel.id_nivel_combustivel = veiculo.id_nivel_combustivel
                    WHERE 1=1  ".$mbConsulta." ORDER BY modelo.nome ";

            $query= $pdo->prepare($loSql);
            $query->execute();    

            $loVeiculos = null;
            foreach ($query as $row) {   

                $loDataSaidaSoli    = NULL;
                $loDataRetronoSoli  = NULl; 
                $loSqlSoli = "SELECT  
                            veiculo.placa
                            ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida
                            ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev
                        FROM veiculo
                        INNER JOIN solicitacao ON solicitacao.id_veiculo = veiculo.id_veiculo
                        INNER JOIN status_solicitacao ON status_solicitacao.id_status_solicitacao = solicitacao.id_status_solicitacao
                        WHERE status_solicitacao.id_status_solicitacao in(1,2,3) AND veiculo.id_veiculo = ".$row["id_veiculo"]." 
                        ORDER BY solicitacao.id_solicitacao DESC LIMIT 1 ";
                        $querySoli= $pdo->prepare($loSqlSoli);
                        $querySoli->execute();  
                        foreach ($querySoli as $rowSoli) { 
                           if($rowSoli["dt_saida"] != ""){
                                $loDataSaidaSoli = $rowSoli["dt_saida"];
                                $loDataRetronoSoli  = $rowSoli["dt_retorno_prev"]; 
                           }     
                        }


                $loVeiculos[] = array(
                        'id_veiculo'              => $row["id_veiculo"] 
                        ,'id_modelo'              => $row["id_modelo"]
                        ,'nomeModelo'             => $row["nomeModelo"]
                        ,'id_combustivel'         => $row["id_combustivel"]
                        ,'nomeCombustivel'        => $row["nomeCombustivel"]
                        ,'id_cor'                 => $row["id_cor"]
                        ,'nomeCor'                => $row["nomeCor"]
                        ,'placa'                  => $row["placa"]
                        ,'chassi'                 => $row["chassi"]
                        ,'renavam'                => $row["renavam"]
                        ,'ano_veiculo'            => $row["ano_veiculo"]
                        ,'ano_modelo'             => $row["ano_modelo"] 
                        ,'num_motor'              => $row["num_motor"]
                        ,'id_pessoa_matriz'       => $row["id_pessoa_matriz"]
                        ,'id_pessoa_cad'          => $row["id_pessoa_cad"]
                        ,'dt_cad'                 => $row["dt_cad"] 
                        ,'dt_alt'                 => $row["dt_alt"]
                        ,'id_usuario_cad'         => $row["id_usuario_cad"] 
                        ,'id_usuario_alt'         => $row["id_usuario_alt"]
                        ,'ativo'                  => $row["ativo"] 
                        ,'id_nivel_combustivel'   => $row["id_nivel_combustivel"]
                        ,'nomeNivelCombustivel'   => $row["nomeNivelCombustivel"]
                        ,'qtd_passageiro'         => $row["qtd_passageiro"] 
                        ,'portas'                 => $row["portas"] 
                        ,'km'                     => $row["km"]
                        ,'exclusivo'              => $row["exclusivo"]  
                        ,'data_substituidoDev'    => $row["data_substituidoDev"]
                        ,'id_localidade_garagem'  => $row["id_localidade_garagem"]
                        ,'situacao'               => $row["situacao"] 
                        ,'motivo_desativacao'     => $row["motivo_desativacao"] 
                        ,'dt_alt_status'          => $row["dt_alt_status"]
                        ,'dt_saida_solicitacao'   => $loDataSaidaSoli
                        ,'dt_retorno_solicitacao' =>  $loDataRetronoSoli
                );

                

            }

            return $loVeiculos; 
        }

        public function VerificaGrupoAcessoUsuario(){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();
            
            $loGrupo = NULL;

            $loSql = "SELECT 
                            grupo_acesso.id_grupo 
                            ,grupo_acesso.ind_usuario
                            ,grupo_acesso.ind_operador
                            ,grupo_acesso.ind_gestor
                            ,grupo_acesso.ind_adm
                        FROM usuario 
                        INNER JOIN grupo_acesso ON grupo_acesso.id_grupo =  usuario.id_grupo
                        WHERE id_usuario = ".$_SESSION["id_usuario"];

            $query = $pdo->prepare($loSql);
            $query->execute();    
            foreach ($query as $row) { 

               $loGrupo = array(
                            'id_grupo'              => $row["id_grupo"] 
                            ,'ind_usuario'          => $row["ind_usuario"]
                            ,'ind_operador'         => $row["ind_operador"]
                            ,'ind_gestor'           => $row["ind_gestor"]
                            ,'ind_adm'              => $row["ind_adm"]
                        );   
            }                             

            return $loGrupo;

        }


        public function VerificaRequisitanteMotorista($mbIdRequisitante){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();

            $loSql = "SELECT 
                            pessoa.ind_condutor
                            ,pessoa.id_pessoa
                            ,pessoa.ind_passageiro
                            ,pessoa.ind_motorista
                        FROM usuario 
                        INNER JOIN pessoa ON pessoa.id_pessoa = usuario.id_pessoa_origem
                        WHERE pessoa.id_pessoa = ".$mbIdRequisitante;
            $query = $pdo->prepare($loSql);
            $query->execute();    
            
            $loIndCondutor = false;
            $loIndPassageiro = false;
            $indMotorista = false;
            foreach ($query as $row) { 

                if($row["ind_condutor"] == "1"){$loIndCondutor = true;} 
                if($row["ind_passageiro"] == "1"){$loIndPassageiro = true;} 
                if($row["ind_motorista"] == "1"){$indMotorista = true;}  
            
                $loItensConsulta = array(
                     'ind_condutor' => $loIndCondutor
                    ,'id_pessoa'    => $row["id_pessoa"] 
                    ,'ind_passageiro' => $loIndPassageiro
                    ,'ind_motorista' => $indMotorista
                );   

            }                             

            return $loItensConsulta;       
        }


        public function VerificaUsuarioConsutor(){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();

            $loSql = "SELECT pessoa.ind_condutor,pessoa.id_pessoa,pessoa.ind_passageiro
                        FROM usuario 
                        INNER JOIN pessoa ON pessoa.id_pessoa = usuario.id_pessoa_origem
                        WHERE id_usuario = ".$_SESSION["id_usuario"];
            $query = $pdo->prepare($loSql);
            $query->execute();    
            $loIndCondutor = false;
            $loIndPassageiro = false;
            foreach ($query as $row) { 

                if($row["ind_condutor"] == "1"){$loIndCondutor = true;} 
                if($row["ind_passageiro"] == "1"){$loIndPassageiro = true;}  
            
                $loItensConsulta = array(
                     'ind_condutor' => $loIndCondutor
                    ,'id_pessoa'    => $row["id_pessoa"] 
                    ,'ind_passageiro' => $loIndPassageiro
                );   

            }                             

            return $loItensConsulta;       
        }

        public function VerificaUsuarioCondutorPessoa($mbIdPessoa){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();

            $loSql = "SELECT 
                             pessoa.ind_condutor
                        FROM usuario 
                        INNER JOIN pessoa ON pessoa.id_pessoa = usuario.id_pessoa_origem
                        WHERE pessoa.id_pessoa = ".$mbIdPessoa;
            //echo $loSql;
            $query = $pdo->prepare($loSql);
            $query->execute();    

            $loItensConsulta = NULL;
            foreach ($query as $row) { 

                $loItensConsulta = array(
                     'ind_condutor' => $row["ind_condutor"] 
                );   

            }                             

            return $loItensConsulta;       
        }

        public function VerificaAutorizadorUsuarioCorrente($mbIdSolicitacao){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();            

            $loSql = "SELECT pessoa.nome,pessoa.email,usuario.id_usuario FROM autorizadores 
                        INNER JOIN pessoa ON pessoa.id_pessoa = autorizadores.id_pessoa_pai
                        INNER JOIN usuario ON usuario.id_pessoa_origem = pessoa.id_pessoa
                        WHERE id_pessoa_filho IN(SELECT id_pessoa_requisitante FROM solicitacao WHERE id_solicitacao = ".$mbIdSolicitacao.")";
            $query = $pdo->prepare($loSql);
            $query->execute();    
            $loItensConsulta = NULL;
            foreach ($query as $row) { 

                $loItensConsulta[] = array(
                     'nome'     => $row["nome"] 
                    ,'email'    => $row["email"] 
                    ,'id_usuario' => $row["id_usuario"]
                );   

            }

            return $loItensConsulta;                       

        }

        public function VerificaDataValidadeHabilitacaoConsultor($mbData){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();   

            $loComumParametros = new comumBO();
            $loData = $loComumParametros->AdicionaDataHora($mbData); 

            $loDifDataAbilitacao = false;

            $loSql = "SELECT 
                        DATEDIFF(pessoa.validade_habilitacao,'".$loData."')  as 'tempo' ,pessoa.validade_habilitacao
                    FROM pessoa 
                    WHERE id_pessoa IN(SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"].")";
            $query = $pdo->prepare($loSql);
            $query->execute();  
            foreach ($query as $row) { 
                if( $row["tempo"] < 0 ){
                    $loDifDataAbilitacao = true;
                }                       
            }

            return $loDifDataAbilitacao;

        }

        public function UsuarioCorrenteAutoriza($mbSolicitacao){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao(); 

            $loLiberado = 0;  

            /*Verifica se requisitante da solicitacao é autorizado pelo usuario corrente */
            $loSql = "SELECT COUNT(*)  conta FROM usuario
                        INNER JOIN  pessoa ON pessoa.id_pessoa = usuario.id_pessoa_origem
                        INNER JOIN autorizadores ON autorizadores.id_pessoa_pai = pessoa.id_pessoa
                        WHERE id_usuario = ".$_SESSION["id_usuario"]."  
                        AND autorizadores.id_pessoa_filho = (SELECT id_pessoa_requisitante FROM solicitacao WHERE id_solicitacao = ".$mbSolicitacao.")";
            $query = $pdo->prepare($loSql);
            $query->execute();    
            foreach ($query as $row) { 
                $loLiberado = $row["conta"];
            }

            return $loLiberado;
        }

        public function AtualizaStatusSolicitacao($mbIdsolicitacao,$mbStatus){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao(); 

            $loSql = "UPDATE solicitacao SET id_status_solicitacao = ".$mbStatus." WHERE id_solicitacao = ".$mbIdsolicitacao;
            $query = $pdo->prepare($loSql);
            $query->execute();    

            return $loStatus;

        }

        public function ValidaDataEvento($loDados){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao(); 

            $loItensConsulta = NULL;

            $loComumParametros = new comumBO();
            $loDataEvento = $loComumParametros->AdicionaDataHora($loDados["dt_evento"]);

            $loSql = "SELECT DATEDIFF('".$loDataEvento."',NOW()) as dias ";
            $query = $pdo->prepare($loSql);
            $query->execute(); 

            foreach ($query as $row) { 

                 $loItensConsulta = array(
                      'dias'       => $row["dias"] 
                     ,'messagem'  => 'Data do Evento nao pode ser menos que a Data Atual.'
                ); 

            }

            return $loItensConsulta;

        }

        public function BuscaCategoriaRequisitante($loIdPessoa){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao(); 

            $loItensConsulta = NULL;

            $loSql = "SELECT ind_passageiro,ind_motorista,ind_condutor FROM pessoa WHERE id_pessoa = ".$loIdPessoa;
            $query = $pdo->prepare($loSql);
            $query->execute(); 

            foreach ($query as $row) { 

                $loItensConsulta = array(
                      'ind_passageiro'       => $row["ind_passageiro"] 
                     ,'ind_motorista'        => $row["ind_motorista"] 
                     ,'ind_condutor'         => $row["ind_condutor"]
                ); 

            }

            return $loItensConsulta;


        }

        public function VerificaIgualdadeDestinos($loDados,$loIDSolicitacao){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();             

             $loIdDestinosIn = "";
             $loRetornarStatus = 0;
            
            if(!is_null($loDados)){
                foreach ($loDados as $rowParada) {

                    $Itens = explode(":", $rowParada); 

                    if(count($Itens) > 1){
                        $id_destino = $Itens[1];
                    }else{
                        $id_destino = 0;
                        $loRetornarStatus = 1;
                    }    

                    if($id_destino > 0){

                        $loContaDestino = 0;
                        $loSqlContDest = "SELECT COUNT(id_destino) conta FROM destinos where id_destino = ".$id_destino;
                        $queryContDest = $pdo->prepare($loSqlContDest);
                        $queryContDest->execute(); 
                        foreach ($queryContDest as $rowContDest) { 
                            $loContaDestino = $rowContDest["conta"];
                        }

                        if($loContaDestino == 0){
                            $loRetornarStatus = 1;
                        }
                    }

                }
            }


            return $loRetornarStatus;

        }

        public function AtualizaDadosSolicitacaoGestor($mbDados){

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();                  

            $IdStatus = $mbDados["id_status_solicitacao"];
            $IdSolicitacao = $mbDados["id_solicitacao"];
            $IndGestor =  $mbDados["ind_encaminhado_gestor"];

            $loSql = "SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"];
            $query = $pdo->prepare($loSql);
            $query->execute(); 
            foreach ($query as $row) { 
                $loIdPessoa = $row["id_pessoa_origem"];
            }

            if( $IdStatus == 2 ){//Encaminhado ao Gestor

                $loSql = "UPDATE solicitacao 
                        SET id_status_solicitacao = ".$IdStatus."
                        , ind_encaminhado_gestor = ".$IndGestor." 
                        , id_pessoa_gestor = ".$loIdPessoa."
                        , dt_enc_gestor = NOW()
                        WHERE id_solicitacao = ".$IdSolicitacao;
                $query = $pdo->prepare($loSql);
                $query->execute(); 

            }else{//Aprovado

                $loSql = "UPDATE solicitacao 
                            SET id_status_solicitacao = ".$IdStatus."
                            , ind_encaminhado_gestor = ".$IndGestor." 
                            , id_usuario_aprovado = ".$_SESSION["id_usuario"]."
                            , dt_aprovado = NOW()
                            WHERE id_solicitacao = ".$IdSolicitacao;
                $query = $pdo->prepare($loSql);
                $query->execute(); 

            }

            return true;            
        }

        public function AprovaSolicitacao($mbDados){

            /* Altera Status da Solicitação para Aprovado */
            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();        

            $loIdSolicitacao = $mbDados["id_solicitacao"];
            $loIdUsuario = $mbDados["id_usuario"];

            $loSql = "UPDATE solicitacao 
                        SET 
                        id_status_solicitacao = 3 
                        ,id_usuario_alt = ".$loIdUsuario."
                        ,dt_alt = NOW()
                        ,id_usuario_aprovado = ".$loIdUsuario."
                        ,dt_aprovado = NOW()
                        WHERE id_solicitacao = ".$loIdSolicitacao;

            $query = $pdo->prepare($loSql);
            $query->execute(); 

            return true;
        }

        public function NaoAprovaSolicitacaoSolicitacao($mbDados){

            /*Altera Status da Solicitacao como nao aprovado pelo gestor*/
            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();        

            $loIdSolicitacao = $mbDados["id_solicitacao"];

            $loSql = "UPDATE solicitacao 
                        SET 
                        id_status_solicitacao = 8 
                      WHERE id_solicitacao = ".$loIdSolicitacao;

            $query = $pdo->prepare($loSql);
            $query->execute(); 

            return true;

        }

    public function ListaTodosOsOperadores(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();          

        $loSql = "SELECT 
                        pessoa.nome
                        ,pessoa.email
                        ,usuario.id_usuario 
                    FROM usuario 
                         INNER JOIN pessoa ON pessoa.id_pessoa = usuario.id_pessoa_origem
                    WHERE 
                        usuario.id_grupo = 4 
                        AND usuario.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"]."
                        AND usuario.ativo = 1";
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loItens = null;
        foreach ($query as $row) {
               
               $loItens[] = array(
                      'nome'   => $row["nome"] 
                     ,'email'  => $row["email"] 
                     ,'id_usuario' => $row["id_usuario"]

                );
        
        }
        return $loItens;   
    }

    public function VerificaVeiculoEmUso($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();          

        $loIdSolicitacao = $mbDados["id_solicitacao"];
        $loIdVeiculo = $mbDados["id_veiculo"];

        $loSql = "SELECT count(id_veiculo) veiculo_em_uso 
                    FROM veiculo 
                    WHERE id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"]." 
                    AND situacao = 'U' 
                    AND id_veiculo = ".$loIdVeiculo;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loVeiculoEmUso = false;
        foreach ($query as $row) {
               
            if($row["veiculo_em_uso"] == 1){
                $loVeiculoEmUso = true;
            }
        
        }
        return $loVeiculoEmUso; 

    }

    public function VerificaSePassageiroeMotorista($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();           

        $loIdSolicitacao = $mbDados; 

        $loSql = "SELECT COUNT(id_solicitacao) contagem FROM passageiros 
                    WHERE id_solicitacao = ".$loIdSolicitacao." 
                    AND id_pessoa_passageiro = (
                        SELECT id_pessoa_motorista FROM solicitacao WHERE id_solicitacao = ".$loIdSolicitacao."
                  )";
        $query= $pdo->prepare($loSql);
        $query->execute(); 
        $loContagemMotoristaPassageiro = 0;
        foreach ($query as $row) {
            $loContagemMotoristaPassageiro = $row["contagem"]; 
        }       

        return $loContagemMotoristaPassageiro;           

    }

}
?>