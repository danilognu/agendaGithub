<?php

class relatorioBOA{


    public function ListaRelatorioRateio($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT  
                        veiculo.placa
                        ,setor.nome as 'setor'
                        ,pessoa_requisitante.registro as 'registro'
                        ,pessoa_requisitante.nome as 'nome_requisitante'
                        ,centro_custo.nome as 'centro_custo'
                        ,cnpj_faturamento.cnpj as 'cnpj_faturamento'
                        ,solicitacao.finalidade
                        ,DATE_FORMAT(solicitacao.dt_saida,'%d/%m/%Y') as 'data_saida'
                        ,DATE_FORMAT(solicitacao.dt_saida,'%H:%i:%S') as 'hora_saida'
                        ,DATE_FORMAT(solicitacao.dt_retorno_prev,'%d/%m/%Y') as 'data_retorno_prev'
                        ,DATE_FORMAT(solicitacao.dt_retorno_prev,'%H:%i:%S') as 'hora_retorno_prev'
                        ,solicitacao.km_saida
                        ,solicitacao.km_retorno
                        ,(
                            SELECT 
                                localidade.nome
                            FROM destinos 
                            INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                            WHERE id_solicitacao = solicitacao.id_solicitacao ORDER BY id_destino DESC LIMIT  1
                        ) as 'ultimo_destino'
                        ,(
                            SELECT destinos.km_chegada  
                            FROM destinos 
                            WHERE destinos.id_solicitacao = solicitacao.id_solicitacao LIMIT 1
                        )  'maior_km_chegada'                        
                    FROM solicitacao
                    INNER JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                    INNER JOIN pessoa pessoa_requisitante ON pessoa_requisitante.id_pessoa = solicitacao.id_pessoa_requisitante

                    LEFT JOIN setor ON setor.id_setor =  solicitacao.id_setor
                    LEFT JOIN centro_custo ON centro_custo.id_centro_custo = solicitacao.id_centro_custo	
                    LEFT JOIN cnpj_faturamento ON cnpj_faturamento.id_cnpj_faturamento = solicitacao.id_cnpj_faturamento
                    WHERE 1=1 ".$mbDados;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loConsultaDados = null;
        foreach ($query as $row) {

            $loValorLocacao =+ $this->BuscaValorLocacaoSistemaLets($row["placa"]);

            $loTotalKm = 0;
            $loMaiorKmChegada = 0;
            if($row["maior_km_chegada"] == 0){
                $loMaiorKmChegada = $row["km_retorno"];
            }

            if($row["km_saida"] > 0 && $row["maior_km_chegada"] > 0){
                $loTotalKm = $row["km_saida"] + $row["maior_km_chegada"];
                $loMaiorKmChegada = $row["maior_km_chegada"];
            }

            $loConsultaDados[] = array(
                    'placa'                     => $row["placa"]
                    ,'setor'                    => $row["setor"]
                    ,'registro'                 => $row["registro"]
                    ,'nome_requisitante'        => $row["nome_requisitante"]
                    ,'centro_custo'             => $row["centro_custo"]
                    ,'cnpj_faturamento'         => $row["cnpj_faturamento"]
                    ,'ultimo_destino'           => $row["ultimo_destino"]
                    ,'finalidade'               => $row["finalidade"]
                    ,'data_saida'               => $row["data_saida"]
                    ,'hora_saida'               => $row["hora_saida"]
                    ,'km_saida'                 => $row["km_saida"]
                    ,'data_retorno_prev'        => $row["data_retorno_prev"]
                    ,'hora_retorno_prev'        => $row["hora_retorno_prev"]
                    ,'km_final'                 => $loMaiorKmChegada
                    ,'total'                    => $loTotalKm
                    ,'rateio'                   => 0
                    ,'valor_loc_sistema_lets'   => $loValorLocacao
                    ,'div'                      => ""
                    ,'rg'                       => ""
            );

        }

        return $loConsultaDados;  

    }


    public function ListaAtencimentosPorSetor($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT 
                    solicitacao.id_solicitacao
                    ,setor.nome as nome_setor
                    ,motorista.nome as nome_motorista
                    ,origem.nome as nome_origem
                    ,origem.endereco as endereco_origem
                    ,veiculo.placa
                    ,solicitacao.km_saida
                    ,solicitacao.km_retorno
                    ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida
                    ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev
                    ,solicitacao.id_veiculo
                    ,DATE_FORMAT(solicitacao.dt_partida, '%d/%m/%Y %H:%i') dt_partida
                    ,DATE_FORMAT(solicitacao.dt_chegada, '%d/%m/%Y %H:%i') dt_chegada
                    ,solicitacao.id_pessoa_motorista
                    ,solicitacao.id_pessoa_requisitante
                    ,solicitacao.id_setor
                    ,solicitacao.id_localidade_origem
                    ,solicitacao.ind_planejado 
                    ,(
                        SELECT 
                            localidade.nome
                        FROM destinos 
                        INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                        WHERE id_solicitacao = solicitacao.id_solicitacao ORDER BY id_destino DESC LIMIT  1
                    ) ultimo_destino
                    ,(SELECT COUNT(*) FROM passageiros WHERE id_solicitacao = solicitacao.id_solicitacao) as qtdPassageiro
                FROM solicitacao
                LEFT JOIN setor ON solicitacao.id_setor = setor.id_setor
                LEFT JOIN pessoa motorista ON motorista.id_pessoa =  solicitacao.id_pessoa_motorista
                LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                LEFT JOIN localidade origem ON origem.id_localidade =  solicitacao.id_localidade_origem
                WHERE 1=1 ".$mbDados;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loConsultaDados = null;
        foreach ($query as $row) {

             $loConsultaDados[] = array(
                    'id_solicitacao'            => $row["id_solicitacao"]
                    ,'nome_setor'               => $row["nome_setor"]
                    ,'nome_motorista'           => $row["nome_motorista"]
                    ,'nome_origem'              => $row["nome_origem"]
                    ,'endereco_origem'          => $row["endereco_origem"]
                    ,'placa'                    => $row["placa"]
                    ,'km_saida'                 => $row["km_saida"]
                    ,'km_retorno'               => $row["km_retorno"]
                    ,'dt_saida'                 => $row["dt_saida"]
                    ,'dt_retorno_prev'          => $row["dt_retorno_prev"]
                    ,'dt_partida'               => $row["dt_partida"]
                    ,'dt_chegada'               => $row["dt_chegada"]
                    ,'ultimo_destino'           => $row["ultimo_destino"]
                    ,'tempo_origem'             => 0
                    ,'qtdPassageiro'            => $row["qtdPassageiro"]
                    ,'km_percentual'            => ''                    
                );
        }

        return $loConsultaDados;               

    }

    public function BuscaValorLocacaoSistemaLets($mbPlaca){

        
        $loConexao = new ConexaoSqlSrv();
        $pdo = $loConexao->IniciaConexaoSqlSrv(); 

        $loValorVeiculo = 0;
        $loSql = "SELECT TOP 1 T092.A092_valor
                    FROM T009_VEICULO T009 
                INNER JOIN T095_CON_VEICULO T095 ON T095.A009_cd_veiculo = T009.A009_cd_veiculo
                INNER JOIN T087_CONTRATO T087 ON T087.A087_cd_contrato = T095.A087_seq_contrato AND T087.A087_seq_contrato = T095.A087_seq_contrato
                INNER JOIN T092_CON_FORMA_PGTO T092 ON T092.A087_cd_contrato = T087.A087_cd_contrato AND T092.A087_seq_contrato = T087.A087_seq_contrato
                WHERE T009.A009_placa_veiculo IN('".$mbPlaca."') 
                ORDER BY T087.A087_dt_retorno DESC";

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loPessoas = null;
        foreach ($query as $row) {
            $loValorVeiculo = $row["A092_valor"];
        }

        return $loValorVeiculo;                 
        
    }


    public function TempoAtendimento($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = "AND ".$mbDados;
        }

        $loSql = "SELECT 
                        solicitacao.id_solicitacao
                        ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida
                        ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev
                        ,setor.nome as setor
                        ,localidade.nome as garagem
                        ,motorista.nome as motorista
                        ,TIMEDIFF(solicitacao.dt_saida, solicitacao.dt_retorno_prev) tempoAtendimento
                        ,TIMEDIFF(solicitacao.dt_chegada,solicitacao.dt_partida) as tempoDeslocamento
                    FROM solicitacao
                    INNER JOIN setor ON setor.id_setor = solicitacao.id_setor
                    INNER JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                    LEFT JOIN localidade ON localidade.id_localidade = veiculo.id_localidade_garagem
                    INNER JOIN pessoa motorista ON motorista.id_pessoa = solicitacao.id_pessoa_motorista
                    WHERE 1=1 ".$mbDados." ORDER BY solicitacao.dt_saida ";
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loPessoas = null;
        foreach ($query as $row) {
               
               
               $loPessoas[] = array(
                    'id_solicitacao'       => $row["id_solicitacao"]
                    ,'dt_saida'            => $row["dt_saida"]
                    ,'dt_retorno_prev'     => $row["dt_retorno_prev"]
                     ,'setor'              => $row["setor"]
                     ,'garagem'            => $row["garagem"]
                     ,'motorista'          => $row["motorista"]
                     ,'tempoAtendimento'   => $row["tempoAtendimento"]
                     ,'tempoDeslocamento'  => $row["tempoDeslocamento"]
                     ,'passageiros'        => $this->ListaPassageiros($row["id_solicitacao"])
       
                );
               
        
        }

        return $loPessoas;        



    }

    public function ListaPassageiros($loId){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        $loSql = "SELECT pessoa.nome FROM passageiros 
                  INNER JOIN pessoa ON pessoa.id_pessoa = passageiros.id_pessoa_passageiro
                  WHERE id_solicitacao = ".$loId;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loGrid = null;
        foreach ($query as $row) {
               $loGrid[] = array(
                    'nome'       => $row["nome"]
               );
        }
        return $loGrid;                   
    }

   
}
?>