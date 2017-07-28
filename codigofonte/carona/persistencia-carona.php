<?php

class caronaBOA{


    public function ListaCarona($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 
                    solicitacao.id_solicitacao
                    ,pessoa_requisitante.id_pessoa as id_pessoa_requisitante 
                    ,pessoa_requisitante.nome as nome_requisitante 
                    ,setor.nome as nome_setor
                    ,projetos.nome as nome_projeto
                    ,DATE_FORMAT(solicitacao.dt_evento, '%d/%m/%Y %H:%i') dt_evento
                    ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida
                    ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev
                    ,status_solicitacao.nome as status_solicitacao
                    ,(SELECT COUNT(*) FROM passageiros WHERE passageiros.id_solicitacao = solicitacao.id_solicitacao) as qtd_passageiro_solicitacao
                    ,(SELECT COUNT(*) FROM destinos WHERE destinos.id_solicitacao = solicitacao.id_solicitacao) as qtd_destinos
                    ,veiculo.placa
                    ,veiculo.qtd_passageiro as qtd_passageiro_veiculo
                    ,motorista.nome as nome_motorista
                    ,solicitacao.id_localidade_origem
                    ,localidade.nome as nome_localidade_origem
                    ,(  
                        SELECT COUNT(*) conta_solicitacao_carona 
                        FROM solicitacao_carona 
                        WHERE id_solicitacao = solicitacao.id_solicitacao 
                        AND id_pessoa_solicitante = (SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"].")
                    ) as carona_solicitada 
                    ,(
                        SELECT localidade.nome FROM destinos 
                        INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                        WHERE id_solicitacao = solicitacao.id_solicitacao ORDER BY id_destino DESC LIMIT 1
                    ) as ultimo_destino
                FROM solicitacao
                    INNER JOIN pessoa pessoa_requisitante ON pessoa_requisitante.id_pessoa = solicitacao.id_pessoa_requisitante
                    INNER JOIN status_solicitacao ON status_solicitacao.id_status_solicitacao = solicitacao.id_status_solicitacao
                    LEFT JOIN pessoa motorista ON motorista.id_pessoa = solicitacao.id_pessoa_motorista
                    LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                    LEFT JOIN setor ON setor.id_setor = solicitacao.id_setor
                    LEFT JOIN projetos ON projetos.id_projeto = solicitacao.id_projeto
                    LEFT JOIN localidade ON localidade.id_localidade = solicitacao.id_localidade_origem
                WHERE 1=1 ".$mbDados;
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

         $loDestino[] = array('ultimo'=> 1);

        $loItensConsulta = null;
        foreach ($query as $row) {

                $loContaPassageiros = $row["qtd_passageiro_solicitacao"];
                if($row["nome_motorista"] != "" && $row["qtd_passageiro_solicitacao"] > 0){
                    $loContaPassageiros = $row["qtd_passageiro_solicitacao"];
                    $loContaPassageiros++;
                }
               
               
               $loItensConsulta[] = array(

                    'id_solicitacao'                        => $row["id_solicitacao"] 
                    ,'nome_requisitante'                    => $row["nome_requisitante"] 
                    ,'nome_setor'                           => $row["nome_setor"] 
                    ,'nome_projeto'                         => $row["nome_projeto"] 
                    ,'dt_evento'                            => $row["dt_evento"] 
                    ,'dt_saida'                             => $row["dt_saida"] 
                    ,'dt_retorno_prev'                      => $row["dt_retorno_prev"] 
                    ,'status_solicitacao'                   => $row["status_solicitacao"] 
                    ,'qtd_passageiro_solicitacao'           => $loContaPassageiros 
                    ,'qtd_destinos'                         => $row["qtd_destinos"] 
                    ,'placa'                                => $row["placa"] 
                    ,'qtd_passageiro_veiculo'               => $row["qtd_passageiro_veiculo"]
                    ,'nome_motorista'                       => $row["nome_motorista"] 
                    ,'carona_solicitada'                    => $row["carona_solicitada"]
                    ,'nome_localidade_origem'               => $row["nome_localidade_origem"]
                    ,'ultimo_destino'                       => $row["ultimo_destino"]
                    ,'id_pessoa_requisitante'               => $row["id_pessoa_requisitante"]

                );
               
        
        }
        

        return $loItensConsulta;        
    }



    public function ListaPassageiros($mbIdSolicitacao){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        $loSql = "SELECT 
                    pessoa.nome
                    ,1 as motorista 
                 FROM solicitacao 
                 INNER JOIN pessoa ON pessoa.id_pessoa = solicitacao.id_pessoa_motorista
                 WHERE id_solicitacao = ".$mbIdSolicitacao."
                    UNION 
                SELECT 
                    pessoa.nome 
                    ,0 as motorista
                FROM passageiros 
                INNER JOIN pessoa ON pessoa.id_pessoa = passageiros.id_pessoa_passageiro
                WHERE passageiros.id_solicitacao = ".$mbIdSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loItensConsulta = null;
        foreach ($query as $row) {
               
               
               $loItensConsulta[] = array(
                     'nome' => $row["nome"] 
                    ,'motorista' => $row["motorista"]
                );   
        }

        return $loItensConsulta;         
    }

    public function ListaDestino($mbIdSolicitacao){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        $loSql = "SELECT 
                    localidade.nome
                    ,localidade.endereco
                    ,1 as origem
                FROM solicitacao
                INNER JOIN localidade ON localidade.id_localidade = solicitacao.id_localidade_origem
                WHERE solicitacao.id_solicitacao = ".$mbIdSolicitacao."
                UNION
                SELECT 
                    localidade.nome
                    ,localidade.endereco
                    ,0 as origem
                FROM destinos
                INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                WHERE destinos.id_solicitacao = ".$mbIdSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loItensConsulta = null;
        foreach ($query as $row) {
               
               
               $loItensConsulta[] = array(
                    'nome' => $row["nome"] 
                    ,'endereco' => $row["endereco"] 
                    ,'origem'   => $row["origem"]
                );   
        }

        return $loItensConsulta;         
    }

    public function DadosEnvioEmail($mbIdPessoa){

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

    public function ListaPessoas($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        $loSql = "SELECT 
                    pessoa.id_pessoa
                    ,pessoa.nome
                    ,pessoa.nome_fantasia
                    ,pessoa.cpf
                    ,pessoa.cnpj
                    ,pessoa.inscricao_estadual
                    ,pessoa.cep
                    ,pessoa.endereco
                    ,pessoa.bairro
                    ,pessoa.numero
                    ,cidade.id_cidade
                    ,cidade.id_estado
                    ,cidade.nome as nome_cidade
                    ,estado.uf as uf
                    ,pessoa.email
                    FROM pessoa
                    INNER JOIN tipo_pessoa ON tipo_pessoa.id_tipo_pessoa = pessoa.id_tipo_pessoa
                    LEFT JOIN cidade ON cidade.id_cidade = pessoa.id_cidade
                    LEFT JOIN estado ON estado.id_estado = cidade.id_estado
                    LEFT JOIN setor ON setor.id_setor = pessoa.id_setor
                    LEFT JOIN localidade garagem ON garagem.id_localidade = pessoa.id_localidade_garagem_atual
                    WHERE 1=1 ".$mbDados;
       //echo $loSql;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loPessoas = null;
        foreach ($query as $row) {
               
               
               $loPessoas[] = array(
                    'id_pessoa'             => $row["id_pessoa"]
                    ,'nome'                 => $row["nome"]
                    ,'nome_fantasia'        => $row["nome_fantasia"]
                    ,'cpf'                  => $row["cpf"]
                    ,'cnpj'                 => $row["cnpj"]
                    ,'inscricao_estadual'   => $row["inscricao_estadual"]
                    ,'cep'                  => $row["cep"]
                    ,'endereco'             => $row["endereco"]
                    ,'bairro'               => $row["bairro"]
                    ,'numero'               => $row["numero"]
                    ,'id_cidade'            => $row["id_cidade"]
                    ,'id_estado'            => $row["id_estado"]
                    ,'email'                => $row["email"]
                 );
               
        
        }

        return $loPessoas;        



    }

    public function GravaSolicitacaoDeCarona($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();    

        /*----------------------------
            Difinição dos Status
            A = Aprovado
            C = Cancelado
            S = Solicitado
        ------------------------------
        */    

        $loIdSolicitacao       = $mbDados["id_solicitacao"];
        $loIdPessoaAutorizante = $mbDados["id_pessoa_autorizante"];
        $loIdPessoaSolicitante = $this->BuscaPessoaUsuario();

        $loSql = "INSERT INTO solicitacao_carona
                    (
                         id_solicitacao
                        ,id_pessoa_solicitante
                        ,id_pessoa_autorizador
                        ,id_usuario_cad
                        ,dt_cad	
                        ,status
                    )VALUES(
                         ?
                        ,?
                        ,?
                        ,?
                        ,NOW()
                        ,'S'	                    
                    )";

        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loIdSolicitacao);
        $query->bindValue(2, $loIdPessoaSolicitante);
        $query->bindValue(3, $loIdPessoaAutorizante);
        $query->bindValue(4, $_SESSION["id_usuario"]);

        $query->execute(); 

        return false;                    

    }

    public function BuscaPessoaUsuario(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();             

        $loSql = "SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"];
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loIdPessoa = null;
        foreach ($query as $row) {
            $loIdPessoa = $row["id_pessoa_origem"];
        }

        return  $loIdPessoa;
    }

    public function BuscaDadosSolicitacaoEmail($idSolicitacao){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();  

        $loSql = "SELECT 
                        id_solicitacao 
                        ,requisitante.nome as requisitante
                        ,motorista.nome as motorista
                        ,veiculo.placa
                        ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida
                        ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev
                    FROM solicitacao
                    LEFT JOIN pessoa requisitante ON requisitante.id_pessoa = solicitacao.id_pessoa_requisitante
                    LEFT JOIN pessoa motorista ON motorista.id_pessoa = solicitacao.id_pessoa_motorista
                    LEFT JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                    WHERE solicitacao.id_solicitacao = ".$idSolicitacao;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loIdPessoa = null;
        foreach ($query as $row) {

            $loHTMlEmial = "<strong>Codigo Solicitacao:</strong> ".$row["id_solicitacao"]."<br />";
            $loHTMlEmial .= "<strong>Requisitante:</strong> ".$row["requisitante"]."<br />";
            $loHTMlEmial .= "<strong>Motorista:</strong> ".$row["motorista"]."<br />";
            $loHTMlEmial .= "<strong>Placa:</strong> ".$row["placa"]."<br />";
            $loHTMlEmial .= "<strong>Data Saida:</strong> ".$row["dt_saida"]."<br />";
            $loHTMlEmial .= "<strong>Retorno Prev:</strong> ".$row["dt_retorno_prev"]."<br />";           

        }

        return  $loHTMlEmial;

    }

     public function ListaCaronasSolicitadas($loDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();             

        $IdSolicitacao = $loDados["id_solicitacao"];

        $loSql = "SELECT 
                    id_solicitacao
                    ,solicitante.id_pessoa as id_pessoa_solicitante
                    ,solicitante.nome  as nome_pessoa_solicitante
                    ,DATE_FORMAT(solicitacao_carona.dt_cad, '%d/%m/%Y %H:%i') dt_cad
                    ,status
                FROM solicitacao_carona
                INNER JOIN pessoa solicitante ON solicitante.id_pessoa = solicitacao_carona.id_pessoa_solicitante
                WHERE  solicitacao_carona.id_solicitacao = ".$IdSolicitacao."
                AND solicitacao_carona.id_pessoa_solicitante IN(
                    SELECT id_pessoa_origem FROM usuario WHERE usuario.id_usuario = ".$_SESSION["id_usuario"]."
                )";
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
                );
               
        
        }

        return $loItens;                  

    }

    public function ListaTodosOsOperadores(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();          

        $loSql = "SELECT 
                        pessoa.nome
                        ,pessoa.email 
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

                );
        
        }
        return $loItens;   
    }

}
?>