<?php

class pessoaBOA{


    public function ListaPessoas($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        /*if(strlen($mbDados) > 0){
            $mbDados = "AND ".$mbDados;
        }*/

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
                    ,pessoa.sexo
                    ,pessoa.email
                    ,pessoa.telefone_dd
                    ,pessoa.telefone
                    ,pessoa.telefone_dd2
                    ,pessoa.telefone2
                    ,pessoa.celular_dd
                    ,pessoa.celular
                    ,tipo_pessoa.id_tipo_pessoa
                    ,tipo_pessoa.nome as nome_tipo_pessoa
                    ,pessoa.nome_mae
                    ,pessoa.nome_pai
                    ,pessoa.dt_nascimento
                    ,pessoa.id_estado_civil
                    ,pessoa.dt_casamento
                    ,pessoa.rg
                    ,pessoa.orgao_emissor_rg
                    ,pessoa.complemento
                    ,pessoa.dt_cadastro
                    ,pessoa.dt_alt
                    ,pessoa.id_usuario_cad
                    ,pessoa.id_usuario_alt
                    ,pessoa.ativo
                    ,pessoa.num_habilitacao
                    ,pessoa.orgao_habilitacao
                    ,pessoa.categoria_habilitacao
                    ,DATE_FORMAT(pessoa.validade_habilitacao, '%d/%m/%Y') validade_habilitacao
                    ,pessoa.id_pessoa_cliente
                    ,pessoa.ind_passageiro
                    ,pessoa.ind_motorista
                    ,pessoa.ind_condutor
                    ,setor.id_setor
                    ,setor.nome nome_setor
                    ,garagem.id_localidade as id_garagem
                    ,garagem.nome as nome_garagem
                    ,garagem.endereco as endereco_garagem
                    ,pessoa.id_localidade_garagem_atual 
                    ,pessoa.arquivo_logo_caminho
                    ,pessoa.arquivo_logo
                    ,pessoa.ind_carona
                    ,usuario.id_pessoa_origem as id_pessoa_usuario
                    ,pessoa.registro
                    FROM pessoa
                    INNER JOIN tipo_pessoa ON tipo_pessoa.id_tipo_pessoa = pessoa.id_tipo_pessoa
                    LEFT JOIN cidade ON cidade.id_cidade = pessoa.id_cidade
                    LEFT JOIN estado ON estado.id_estado = cidade.id_estado
                    LEFT JOIN setor ON setor.id_setor = pessoa.id_setor
                    LEFT JOIN localidade garagem ON garagem.id_localidade = pessoa.id_localidade_garagem_atual
                    LEFT JOIN usuario ON usuario.id_pessoa_origem = pessoa.id_pessoa
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
                    ,'sexo'                 => $row["sexo"]
                    ,'email'                => $row["email"]
                    ,'telefone_dd'          => $row["telefone_dd"]
                    ,'telefone'             => $row["telefone"]
                    ,'telefone_dd2'         => $row["telefone_dd2"]
                    ,'telefone2'            => $row["telefone2"]
                    ,'celular_dd'           => $row["celular_dd"]
                    ,'celular'              => $row["celular"]
                    ,'id_tipo_pessoa'       => $row["id_tipo_pessoa"]
                    ,'nome_tipo_pessoa'     => $row["nome_tipo_pessoa"]
                    ,'nome_mae'             => $row["nome_mae"]
                    ,'nome_pai'             => $row["nome_pai"]
                    ,'dt_nascimento'        => $row["dt_nascimento"]
                    ,'id_estado_civil'      => $row["id_estado_civil"]
                    ,'dt_casamento'         => $row["dt_casamento"]
                    ,'rg'                   => $row["rg"]
                    ,'complemento'          => $row["complemento"]
                    ,'dt_cadastro'          => $row["dt_cadastro"]
                    ,'dt_alt'               => $row["dt_alt"]
                    ,'id_usuario_cad'       => $row["id_usuario_cad"]
                    ,'id_usuario_alt'       => $row["id_usuario_alt"]
                    ,'ativo'                => $row["ativo"]
                    ,'num_habilitacao'      => $row["num_habilitacao"]
                    ,'orgao_habilitacao'    => $row["orgao_habilitacao"]
                    ,'categoria_habilitacao' => $row["categoria_habilitacao"]
                    ,'validade_habilitacao'  => $row["validade_habilitacao"]
                    ,'id_pessoa_cliente'     => $row["id_pessoa_cliente"]
                    ,'nome_cidade'           => $row["nome_cidade"]
                    ,'uf'                    => $row["uf"]
                    ,'ind_passageiro'        => $row["ind_passageiro"]
                    ,'ind_motorista'         => $row["ind_motorista"]
                    ,'ind_condutor'          => $row["ind_condutor"]
                    ,'id_setor'              => $row["id_setor"]
                    ,'nome_setor'            => $row["nome_setor"]
                    ,'id_garagem'            => $row["id_garagem"]
                    ,'nome_garagem'          => $row["nome_garagem"]
                    ,'endereco_garagem'      => $row["endereco_garagem"]  
                    ,'id_localidade_garagem_atual' => $row["id_localidade_garagem_atual"]  
                    ,'arquivo_logo_caminho'  => $row["arquivo_logo_caminho"]
                    ,'arquivo_logo'          => $row["arquivo_logo"]
                    ,'ind_carona'            => $row["ind_carona"]
                    ,'id_pessoa_usuario'     => $row["id_pessoa_usuario"]
                    ,'registro'              => $row["registro"]   
                 );
               
        
        }

        return $loPessoas;        



    }

    public function IncluirCliente($loDados){

        $loNome         = utf8_decode($loDados["nome"]);
        $loNomeFantasia = utf8_decode($loDados["nome_fantasia"]);
        $loCnpj         = $loDados["cnpj"];
        $loCep          = $loDados["cep"];
        $loEndereco     = utf8_decode($loDados["endereco"]);
        $loBairro       = utf8_decode($loDados["bairro"]);
        $loNumero       = $loDados["numero"];
        $loIdCidade     = $loDados["id_cidade"];
        $loComplemento  = utf8_decode($loDados["complemento"]);
        $loTelefoneDD   = substr($loDados["telefone"], 0,2);
        $loTelefone     = substr($loDados["telefone"], 2,9);
        $loCelularDD    = substr($loDados["celular"], 0,2);
        $loCelular      = substr($loDados["celular"], 2,9);
        $loEmail        = $loDados["email"];
        $loAtivo        = $loDados["status"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    pessoa (
                        nome
                        ,nome_fantasia
                        ,cnpj
                        ,cep
                        ,endereco
                        ,bairro
                        ,numero
                        ,id_cidade
                        ,complemento
                        ,telefone_dd
                        ,telefone
                        ,celular_dd
                        ,celular
                        ,email
                        ,ativo
                        ,id_usuario_cad
                        ,id_tipo_pessoa
                        ,dt_cadastro
                        ,id_pessoa_matriz 
                     ) VALUES (                        
                         ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,2,NOW(),?)";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loNomeFantasia);
        $query->bindValue(3, $loCnpj);
        $query->bindValue(4, $loCep);
        $query->bindValue(5, $loEndereco);
        $query->bindValue(6, $loBairro);
        $query->bindValue(7, $loNumero);
        $query->bindValue(8, $loIdCidade);
        $query->bindValue(9, $loComplemento);
        $query->bindValue(10, $loTelefoneDD);
        $query->bindValue(11, $loTelefone);
        $query->bindValue(12, $loCelularDD);
        $query->bindValue(13, $loCelular);
        $query->bindValue(14, $loEmail);
        $query->bindValue(15, $loAtivo);
        $query->bindValue(16, $_SESSION["id_usuario"]);
        $query->bindValue(17, $_SESSION["id_pessoa_matriz"]);

        $query->execute(); 

        return false;


    }

    public function AlterarCliente($loDados){


        $loNome         = utf8_decode($loDados["nome"]);
        $loNomeFantasia = utf8_decode($loDados["nome_fantasia"]);
        $loCnpj         = $loDados["cnpj"];
        $loCep          = $loDados["cep"];
        $loEndereco     = utf8_decode($loDados["endereco"]);
        $loBairro       = utf8_decode($loDados["bairro"]);
        $loNumero       = $loDados["numero"];
        $loIdCidade     = $loDados["id_cidade"];
        $loComplemento  = utf8_decode($loDados["complemento"]);
        $loTelefoneDD   = substr($loDados["telefone"], 0,2);
        $loTelefone     = substr($loDados["telefone"], 2,9);
        $loCelularDD    = substr($loDados["celular"], 0,2);
        $loCelular      = substr($loDados["celular"], 2,9);
        $loEmail        = $loDados["email"];
        $loAtivo        = $loDados["status"];
        $loId           = $loDados["id"];

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE pessoa SET
                        nome = ?
                        ,nome_fantasia = ?
                        ,cnpj = ?
                        ,cep = ?
                        ,endereco = ?
                        ,bairro = ?
                        ,numero = ?
                        ,id_cidade = ?
                        ,complemento = ?
                        ,telefone_dd = ?
                        ,telefone = ?
                        ,celular_dd = ?
                        ,celular = ?
                        ,email = ?
                        ,ativo = ?
                        ,id_usuario_alt = ?
                        ,id_pessoa_matriz = ?
                WHERE id_pessoa = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loNomeFantasia);
        $query->bindValue(3, $loCnpj);
        $query->bindValue(4, $loCep);
        $query->bindValue(5, $loEndereco);
        $query->bindValue(6, $loBairro);
        $query->bindValue(7, $loNumero);
        $query->bindValue(8, $loIdCidade);
        $query->bindValue(9, $loComplemento);
        $query->bindValue(10, $loTelefoneDD);
        $query->bindValue(11, $loTelefone);
        $query->bindValue(12, $loCelularDD);
        $query->bindValue(13, $loCelular);
        $query->bindValue(14, $loEmail);
        $query->bindValue(15, $loAtivo);
        $query->bindValue(16, $_SESSION["id_usuario"]);
        $query->bindValue(17, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(18, $loId);
        $query->execute(); 

        return true;         

    }


    public function IncluirEmpresa($loDados,$loArquivoLogo){

        $loNome         = utf8_decode($loDados["nome"]);
        $loNomeFantasia = utf8_decode($loDados["nome_fantasia"]);
        $loCnpj         = $loDados["cnpj"];
        $loCep          = $loDados["cep"];
        $loEndereco     = utf8_decode($loDados["endereco"]);
        $loBairro       = utf8_decode($loDados["bairro"]);
        $loNumero       = $loDados["numero"];
        $loIdCidade     = $loDados["id_cidade"];
        $loComplemento  = utf8_decode($loDados["complemento"]);
        $loTelefoneDD   = substr($loDados["telefone"], 0,2);
        $loTelefone     = substr($loDados["telefone"], 2,9);
        $loCelularDD    = substr($loDados["celular"], 0,2);
        $loCelular      = substr($loDados["celular"], 2,9);
        $loEmail        = $loDados["email"];
        $loAtivo        = $loDados["status"];
        $loCarona       = $loDados["ind_carona"];

        //Logo Img
        $loDiretorio = NULL;
        $loNomeArquivo = NULL;

        if($loArquivoLogo["nome_arquivo"] != ""){
            $loDiretorio = $loArquivoLogo["diretorio"];
            $loNomeArquivo = $loArquivoLogo["nome_arquivo"];
        }

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    pessoa (
                        nome
                        ,nome_fantasia
                        ,cnpj
                        ,cep
                        ,endereco
                        ,bairro
                        ,numero
                        ,id_cidade
                        ,complemento
                        ,telefone_dd
                        ,telefone
                        ,celular_dd
                        ,celular
                        ,email
                        ,ativo
                        ,id_usuario_cad
                        ,arquivo_logo
                        ,arquivo_logo_caminho
                        ,ind_carona
                        ,id_tipo_pessoa
                        ,dt_cadastro
                     ) VALUES (                        
                         ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,NOW())";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loNomeFantasia);
        $query->bindValue(3, $loCnpj);
        $query->bindValue(4, $loCep);
        $query->bindValue(5, $loEndereco);
        $query->bindValue(6, $loBairro);
        $query->bindValue(7, $loNumero);
        $query->bindValue(8, $loIdCidade);
        $query->bindValue(9, $loComplemento);
        $query->bindValue(10, $loTelefoneDD);
        $query->bindValue(11, $loTelefone);
        $query->bindValue(12, $loCelularDD);
        $query->bindValue(13, $loCelular);
        $query->bindValue(14, $loEmail);
        $query->bindValue(15, $loAtivo);
        $query->bindValue(16, $_SESSION["id_usuario"]);
        $query->bindValue(17, $loNomeArquivo);
        $query->bindValue(18, $loDiretorio);
        $query->bindValue(19, $loCarona);
        $query->execute(); 

        return true;


    }

    public function AlterarEmpresa($loDados,$loArquivoLogo){

        $loNome         = utf8_decode($loDados["nome"]);
        $loNomeFantasia = utf8_decode($loDados["nome_fantasia"]);
        $loCnpj         = $loDados["cnpj"];
        $loCep          = $loDados["cep"];
        $loEndereco     = utf8_decode($loDados["endereco"]);
        $loBairro       = utf8_decode($loDados["bairro"]);
        $loNumero       = $loDados["numero"];
        $loIdCidade     = $loDados["id_cidade"];
        $loComplemento  = utf8_decode($loDados["complemento"]);
        $loTelefoneDD   = substr($loDados["telefone"], 0,2);
        $loTelefone     = substr($loDados["telefone"], 2,9);
        $loCelularDD    = substr($loDados["celular"], 0,2);
        $loCelular      = substr($loDados["celular"], 2,9);
        $loEmail        = $loDados["email"];
        $loAtivo        = $loDados["status"];
        $loId           = $loDados["id"];
        $loCarona       = $loDados["ind_carona"];

        //Logo Img
        $loDiretorio = NULL;
        $loNomeArquivo = NULL;

        if($loArquivoLogo["nome_arquivo"] != ""){
            $loDiretorio = $loArquivoLogo["diretorio"];
            $loNomeArquivo = $loArquivoLogo["nome_arquivo"];
        }


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE pessoa SET
                        nome = ?
                        ,nome_fantasia = ?
                        ,cnpj = ?
                        ,cep = ?
                        ,endereco = ?
                        ,bairro = ?
                        ,numero = ?
                        ,id_cidade = ?
                        ,complemento = ?
                        ,telefone_dd = ?
                        ,telefone = ?
                        ,celular_dd = ?
                        ,celular = ?
                        ,email = ?
                        ,ativo = ?
                        ,id_usuario_alt = ?
                        ,arquivo_logo = ?
                        ,arquivo_logo_caminho = ?
                        ,ind_carona = ?
                WHERE id_pessoa = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loNomeFantasia);
        $query->bindValue(3, $loCnpj);
        $query->bindValue(4, $loCep);
        $query->bindValue(5, $loEndereco);
        $query->bindValue(6, $loBairro);
        $query->bindValue(7, $loNumero);
        $query->bindValue(8, $loIdCidade);
        $query->bindValue(9, $loComplemento);
        $query->bindValue(10, $loTelefoneDD);
        $query->bindValue(11, $loTelefone);
        $query->bindValue(12, $loCelularDD);
        $query->bindValue(13, $loCelular);
        $query->bindValue(14, $loEmail);
        $query->bindValue(15, $loAtivo);
        $query->bindValue(16, $_SESSION["id_usuario"]);
        $query->bindValue(17, $loNomeArquivo);
        $query->bindValue(18, $loDiretorio);
        $query->bindValue(19, $loCarona);
        $query->bindValue(20, $loId);
        $query->execute(); 

        return true;         

    }



    public function IncluirMotoristaPassageiro($loDados){


        $loComumParametros = new comumBO();
        

        $loNome         = utf8_decode($loDados["nome"]);
        $loCpf          = $loDados["cpf"];
        $loCep          = $loDados["cep"];
        $loEndereco     = utf8_decode($loDados["endereco"]);
        $loBairro       = utf8_decode($loDados["bairro"]);
        $loNumero       = $loDados["numero"];
        $loIdCidade     = $loDados["id_cidade"];
        $loComplemento  = utf8_decode($loDados["complemento"]);
        $loTelefoneDD   = substr($loDados["telefone"], 0,2);
        $loTelefone     = substr($loDados["telefone"], 2,9);
        $loCelularDD    = substr($loDados["celular"], 0,2);
        $loCelular      = substr($loDados["celular"], 2,9);
        $loEmail        = $loDados["email"];
        $loAtivo        = $loDados["status"];
        $loIdSetor      = $loDados["id_setor"];
        $loIdGaragem    = $loDados["id_localidade_garagem"];
        $loRegistro     = $loDados["registro"];

        $loNumHabilitacao = $loDados["num_habilitacao"];
        $loOrgaoHabilitacao = $loDados["orgao_habilitacao"];
        $loDataValidadeHabilitacao = $loComumParametros->AdicionaDate($loDados["data_validade_habilitacao"]);
        $loCategoriaHabilitacao = $loDados["categoria_habilitacao"];
        //$loCodigoCliente = $loDados["cliente"];
        $loIndPassageiro = $loDados["ind_passageiro"];
        $loIndMotorista = $loDados["ind_motorista"];
        $loIndCondutor = $loDados["ind_condutor"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    pessoa (
                        nome
                        ,cpf
                        ,cep
                        ,endereco
                        ,bairro
                        ,numero
                        ,id_cidade
                        ,complemento
                        ,telefone_dd
                        ,telefone
                        ,celular_dd
                        ,celular
                        ,email
                        ,ativo
                        ,id_usuario_cad
                        ,num_habilitacao
                        ,orgao_habilitacao
                        ,categoria_habilitacao
                        ,validade_habilitacao
                        ,pessoa.id_pessoa_matriz
                        ,ind_passageiro
                        ,ind_motorista
                        ,ind_condutor
                        ,id_setor
                        ,id_tipo_pessoa
                        ,id_localidade_garagem_atual
                        ,registro
                        ,dt_cadastro
                     ) VALUES (                        
                         ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loCpf);
        $query->bindValue(3, $loCep);
        $query->bindValue(4, $loEndereco);
        $query->bindValue(5, $loBairro);
        $query->bindValue(6, $loNumero);
        $query->bindValue(7, $loIdCidade);
        $query->bindValue(8, $loComplemento);
        $query->bindValue(9, $loTelefoneDD);
        $query->bindValue(10, $loTelefone);
        $query->bindValue(11, $loCelularDD);
        $query->bindValue(12, $loCelular);
        $query->bindValue(13, $loEmail);
        $query->bindValue(14, $loAtivo);
        $query->bindValue(15, $_SESSION["id_usuario"]);
        $query->bindValue(16, $loNumHabilitacao);
        $query->bindValue(17, $loOrgaoHabilitacao);
        $query->bindValue(18, $loCategoriaHabilitacao);
        $query->bindValue(19, $loDataValidadeHabilitacao);
        $query->bindValue(20, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(21, $loIndPassageiro);
        $query->bindValue(22, $loIndMotorista);
        $query->bindValue(23, $loIndCondutor);
        $query->bindValue(24, $loIdSetor);
        $query->bindValue(25, 4);
        $query->bindValue(26, $loIdGaragem);
        $query->bindValue(27, $loRegistro);
        $query->execute(); 

        
        if(isset($loDados["confirma_cadastro_usuario"]) && $loDados["confirma_cadastro_usuario"] == 1){

            $mbIdPessoaUsuario = NULL;
            $loSqlMax = "SELECT MAX(id_pessoa) as id_pessoa FROM pessoa";
            $queryMax = $pdo->prepare($loSqlMax);
            $queryMax->execute();   
            foreach ($queryMax as $rowMax) { $mbIdPessoaUsuario = $rowMax["id_pessoa"]; }                  

            $this->CriaUsuario($loDados,$mbIdPessoaUsuario);
        }

        return true;

    }


    public function AlterarMotoristaPassageiro($loDados){


        $loComumParametros = new comumBO();

        $loNome         = utf8_decode($loDados["nome"]);
        $loCpf          = $loDados["cpf"];
        $loCep          = $loDados["cep"];
        $loEndereco     = utf8_decode($loDados["endereco"]);
        $loBairro       = utf8_decode($loDados["bairro"]);
        $loNumero       = $loDados["numero"];
        $loIdCidade     = $loDados["id_cidade"];
        $loComplemento  = utf8_decode($loDados["complemento"]);
        $loTelefoneDD   = substr($loDados["telefone"], 0,2);
        $loTelefone     = substr($loDados["telefone"], 2,9);
        $loCelularDD    = substr($loDados["celular"], 0,2);
        $loCelular      = substr($loDados["celular"], 2,9);
        $loEmail        = $loDados["email"];
        $loAtivo        = $loDados["status"];
        $loId           = $loDados["id"];
        $loIdSetor      = $loDados["id_setor"];
        $loRegistro     = $loDados["registro"];

        $loIdGaragem    = $loDados["id_localidade_garagem"];
        $loMotivoTrocaGaragem = $loDados["motivo_garagem"];        
        
        $loNumHabilitacao = $loDados["num_habilitacao"];
        $loOrgaoHabilitacao = $loDados["orgao_habilitacao"];
        $loDataValidadeHabilitacao = $loComumParametros->AdicionaDate($loDados["data_validade_habilitacao"]);
        $loCategoriaHabilitacao = $loDados["categoria_habilitacao"];
        //$loCodigoCliente = $loDados["cliente"];
        $loIndPassageiro = $loDados["ind_passageiro"];
        $loIndMotorista = $loDados["ind_motorista"];
        $loIndCondutor = $loDados["ind_condutor"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

       if(strlen($loIdGaragem) > 0){ 
            $id_localidade_garagem_atual = null;
            $loSqlGargemAtual = "SELECT id_localidade_garagem_atual FROM pessoa WHERE id_pessoa = ".$loId;
            $queryGargemAtual = $pdo->prepare($loSqlGargemAtual);
            $queryGargemAtual->execute();    
            foreach ($queryGargemAtual as $rowGargemAtual) { $id_localidade_garagem_atual = $rowGargemAtual["id_localidade_garagem_atual"]; }
       }  


        $loRetornoGaragemValida = $this->VerificaGaragemAtual($loId,$loIdGaragem);
        //echo $loRetornoGaragemValida["conta_garem_igual"];
        //echo strlen($loIdGaragem);
        //exit;
        if(strlen($loIdGaragem) > 0 && $loRetornoGaragemValida["conta_garem_igual"] == 0){ 
            $loDadoGaragem = array(
                        "id_pessoa_motorista" => $loId
                        , "id_localidade_garagem_origem" => $id_localidade_garagem_atual
                        , 'id_localidade_garagem_destino' => $loIdGaragem
                        , "motivo_alteracao" => $loMotivoTrocaGaragem
                        , "ativa" => 1 
                     );
            //echo "entro"; 
            $this->InserirLocalidadeGaragem($loDadoGaragem);
        }

        //LOG 
        $loStatusAtual = $this->BuscaStatusPessoa($loId);
        $loLogAlteracaoStatus = "";
        if($loStatusAtual != $loAtivo){
            $loLogAlteracaoStatus = ",valor_anterior_status = ".$loStatusAtual.",dt_alt_status = NOW() ,id_usuario_alt_status = ".$_SESSION["id_usuario"];
        }

        //verifica se adata é a mesma cadastrada 
        $loRetornoDataHabilitacao = $this->BuscaDataHabilitacaoPessoa($loId,$loDataValidadeHabilitacao);
        $loLogAlteracaoDtHabilitacao = "";
        if($loRetornoDataHabilitacao["verifica_data_diff"] == 0){
             $loLogAlteracaoDtHabilitacao = ",valor_anterior_dt_validade_habilitacao = '".$loRetornoDataHabilitacao["dt_validade_habilitacao_atual"]."'
                                             ,dt_alt_dt_validade_habilitacao = NOW() 
                                             ,id_usuario_alt_dt_validade_habilitacao = ".$_SESSION["id_usuario"];
        }


       $loSql = "UPDATE pessoa SET
                        nome = ?
                        ,cpf = ?
                        ,cep = ?
                        ,endereco = ?
                        ,bairro = ?
                        ,numero = ?
                        ,id_cidade = ?
                        ,complemento = ?
                        ,telefone_dd = ?
                        ,telefone = ?
                        ,celular_dd = ?
                        ,celular = ?
                        ,email = ?
                        ,ativo = ?
                        ,id_usuario_alt = ?
                        ,num_habilitacao = ?
                        ,orgao_habilitacao = ?
                        ,categoria_habilitacao = ?
                        ,validade_habilitacao = ?
                        ,pessoa.id_pessoa_matriz = ?
                        ,ind_passageiro = ?
                        ,ind_motorista = ?
                        ,ind_condutor = ?
                        ,id_setor = ?
                        ,id_localidade_garagem_atual = ?
                        ,registro = ?
                        ,dt_alt = NOW()
                        ".$loLogAlteracaoStatus."
                        ".$loLogAlteracaoDtHabilitacao."
                WHERE id_pessoa = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loCpf);
        $query->bindValue(3, $loCep);
        $query->bindValue(4, $loEndereco);
        $query->bindValue(5, $loBairro);
        $query->bindValue(6, $loNumero);
        $query->bindValue(7, $loIdCidade);
        $query->bindValue(8, $loComplemento);
        $query->bindValue(9, $loTelefoneDD);
        $query->bindValue(10, $loTelefone);
        $query->bindValue(11, $loCelularDD);
        $query->bindValue(12, $loCelular);
        $query->bindValue(13, $loEmail);
        $query->bindValue(14, $loAtivo);
        $query->bindValue(15, $_SESSION["id_usuario"]);
        $query->bindValue(16, $loNumHabilitacao);
        $query->bindValue(17, $loOrgaoHabilitacao);
        $query->bindValue(18, $loCategoriaHabilitacao);
        $query->bindValue(19, $loDataValidadeHabilitacao);
        $query->bindValue(20, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(21, $loIndPassageiro);
        $query->bindValue(22, $loIndMotorista);
        $query->bindValue(23, $loIndCondutor);
        $query->bindValue(24, $loIdSetor);
        $query->bindValue(25, $loIdGaragem);
        $query->bindValue(26, $loRegistro);
        $query->bindValue(27, $loId);
        $query->execute(); 

       if(isset($loDados["confirma_cadastro_usuario"]) && $loDados["confirma_cadastro_usuario"] == 1){

            if($loDados["id_pessoa_usuario"] == ""){         
                $this->CriaUsuario($loDados,$loId);
            }else{
                $this->AlteraUsuario($loDados,$loId);
            }
        }


        return true;   
    }

    public function CriaUsuario($loDados,$id_pessoa){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loNome = utf8_decode($loDados["nome"]);
        $loLogin = utf8_decode($loDados["login"]);
        $loSenha = base64_encode($loDados["confi_senha"]);

        $loSql = "INSERT INTO 
                    usuario (
                        nome
                        ,login
                        ,senha
                        ,ativo
                        ,id_pessoa_matriz
                        ,id_grupo
                        ,id_pessoa_origem
                        ,dt_cadastro
                    ) VALUES (?,?,?,?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loLogin);
        $query->bindValue(3, $loSenha);
        $query->bindValue(4, 1);
        $query->bindValue(5, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(6, 2);
        $query->bindValue(7, $id_pessoa);
        $query->execute();      

        $losqlM = "SELECT MAX(id_usuario) id_usuario  FROM usuario";
        $queryM= $pdo->prepare($losqlM);
        $queryM->execute();    

        $loDadosUsuarios = null;
        foreach ($queryM as $rowM) {
           $this->InserirCamposTabelasDinamica($rowM["id_usuario"]);      
        }     

    }


    public function AlteraUsuario($loDados,$id_pessoa){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loNome = utf8_decode($loDados["nome"]);
        $loLogin = utf8_decode($loDados["login"]);
        $loId    = $loDados["id"];

        $updateSenha = NULL;
        if(isset($loDados["confi_senha"]) && !empty($loDados["confi_senha"])){
            $updateSenha = ",senha = '".base64_encode($loDados["confi_senha"])."'";
        }
        
        $loSql = "UPDATE
                    usuario SET 
                         nome = '".$loNome."'
                        ,login = '".$loLogin."'
                        ,".$updateSenha."
                        ,dt_alt = NOW()
                    WHERE id_pessoa_origem = ". $id_pessoa;
         
        $query= $pdo->prepare($loSql);
        $query->execute();      
        return true;
    }

     public function InserirCamposTabelasDinamica($mbIdUsuario){


       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();


        //Verifica aqui telas ira permitir tabelas dinamicas
        $loSql = "SELECT id_menu,nome FROM MENU WHERE grid_dinamico = 1";
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loUsuarios = null;
        foreach ($query as $row) {
        
            //Pega os itens definidos como padrao para as consultas
            $loSqlGridC = "SELECT id_grid_consulta FROM grid_consulta WHERE id_menu =  ".$row["id_menu"]." AND ind_padrao = 1";

            $queryGridC= $pdo->prepare($loSqlGridC);
            $queryGridC->execute();    

            $loStrIDGridConsulta = "";
            $loStrINConsulta = "";
            foreach ($queryGridC as $rowGridC) {
                $loStrIDGridConsulta .= $rowGridC["id_grid_consulta"].",";
            }
            $loStrINConsulta = substr($loStrIDGridConsulta,0,-1);


            $loSqlInsert = "INSERT INTO usuario_consulta 
                                (id_usuario,id_menu,id_grid_consulta) 
                            VALUES 
                                (".$mbIdUsuario.",".$row["id_menu"].",'".$loStrINConsulta."')";

           echo  $loSqlInsert;
          
           $queryInsert= $pdo->prepare($loSqlInsert);
           $queryInsert->execute();                                 


        }        

    }

    public function ListaDadosUsuario($loIdPessoa){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        $loSql = "SELECT 
                    id_pessoa_origem
                    ,id_usuario
                    ,login
                    ,senha
                FROM 
                    usuario 
                WHERE id_pessoa_origem = ".$loIdPessoa;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loConsulta = null;
        foreach ($query as $row) {
               
               $loConsulta[] = array(
                    'id_pessoa_origem'  => $row["id_pessoa_origem"]
                    ,'id_usuario'       => $row["id_usuario"]
                    ,'login'            => $row["login"]
                    ,'senha'            => $row["senha"]
                );
               
        
        }
        return $loConsulta;
    }


    public function ListaItensConsulta($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdMenu = $loDados["id_menu"];

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

    public function AlteraConsultaCliente($loDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdMenu = $loDados["id_menu"];
        $loStrConsulta = substr($loDados["strConsulta"],0,-1);

        $loSql = "UPDATE usuario_consulta set id_grid_consulta = '".$loStrConsulta."' WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$loIdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();



    }

     public function DesativarMotoristaPassageiro($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(count($loDados) > 0 ){
            foreach ($loDados as $item){
            
                $loSql = "UPDATE pessoa SET ativo = 0 WHERE id_pessoa = ".$item;
                $query= $pdo->prepare($loSql);
                $query->execute();
            }
        }

         return true;

     }

     public function DesativarPessoa($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(count($loDados) > 0 ){
            foreach ($loDados as $item){
            
                $loSql = "UPDATE pessoa SET ativo = 0 WHERE id_pessoa = ".$item;
                $query= $pdo->prepare($loSql);
                $query->execute();
            }
        }

         return true;

     }

    public function ListaDadosEmpresa($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

        $loIdPessoa = $loDados["id"];
        $loSql = "SELECT nome FROM pessoa WHERE id_tipo_pessoa = 1 AND id_pessoa = ".$loIdPessoa;
        $query= $pdo->prepare($loSql);
        $query->execute();

        $loConsulta = null;
        foreach ($query as $row) {
               
               $loConsulta[] = array(
                    'nome'      => $row["nome"]
                );
        
        }
        return $loConsulta;  

    }

    public function ListaMotoristaVencHabilitacao($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao(); 

        $loSql = " SELECT 
                        pessoa.id_pessoa
                        ,pessoa.nome
                        ,setor.nome as nome_setor
                        ,DATE_FORMAT(pessoa.validade_habilitacao, '%d/%m/%Y') validade_habilitacao 
                        ,pessoa.telefone_dd
                        ,pessoa.telefone
                        ,pessoa.categoria_habilitacao
                        ,DATEDIFF(pessoa.validade_habilitacao,NOW()) as DiasparaVenc
                        ,DATEDIFF(NOW(),pessoa.validade_habilitacao) as DiasVenc
                    FROM 
                        pessoa 
                        LEFT JOIN setor ON setor.id_setor = pessoa.id_setor
                    WHERE 
                        id_tipo_pessoa = 4 AND pessoa.ativo = 1
                        AND
                        DATEDIFF(pessoa.validade_habilitacao,NOW()) <= 60
                    ".$mbDados;
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();

        $loConsulta = null;
        foreach ($query as $row) {
               
               $loConsulta[] = array(
                    'id_pessoa'              => $row["id_pessoa"]
                    ,'nome'                  => $row["nome"]
                    ,'nome_setor'            => $row["nome_setor"]
                    ,'validade_habilitacao'  => $row["validade_habilitacao"]
                    ,'telefone_dd'           => $row["telefone_dd"]
                    ,'telefone'              => $row["telefone"]
                    ,'categoria_habilitacao' => $row["categoria_habilitacao"]
                    ,'DiasparaVenc'          => $row["DiasparaVenc"]
                    ,'DiasVenc'              => $row["DiasVenc"]
                );
        
        }
        return $loConsulta;  

    }

    public function InserirLocalidadeGaragem($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();         


        $id_pessoa_motorista = $mbDados["id_pessoa_motorista"];
        $id_localidade_garagem_origem = $mbDados["id_localidade_garagem_origem"];
        $id_localidade_garagem_destino = $mbDados["id_localidade_garagem_destino"];
        $motivo_alteracao = $mbDados["motivo_alteracao"];
        $ativa = $mbDados["ativa"];

        $loSqlUp = "UPDATE movimentacao_garagem_mot SET ativo = 0 WHERE id_pessoa_motorista = ".$id_pessoa_motorista;
        $queryUp = $pdo->prepare($loSqlUp);
        $queryUp->execute();         

            $loSql = "INSERT INTO 
                        movimentacao_garagem_mot 
                        (   
                            id_pessoa_motorista
                            ,id_localidade_garagem_origem
                            ,id_localidade_garagem_destino
                            ,motivo_alteracao
                            ,ativo
                            ,data_inc
                        ) 
                    VALUES (
                                ".$id_pessoa_motorista."
                                ,".$id_localidade_garagem_origem."
                                ,".$id_localidade_garagem_destino."
                                ,'".$motivo_alteracao."'
                                ,".$ativa."
                                ,NOW()
                            )";
            $query= $pdo->prepare($loSql);
            $query->execute();                  

    }

    public function ListaHistorioGargem($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();          

        $id_motorista = $mbDados["id_motorista"];

        $loSql = "SELECT  
                        origem.nome as origem
                        ,destino.nome as destino
                        ,pessoa.nome as motorista
                        ,movimentacao_garagem_mot.motivo_alteracao
                        ,movimentacao_garagem_mot.ativo
                        ,DATE_FORMAT(movimentacao_garagem_mot.data_inc, '%d/%m/%Y %H:%i') data_inc
                    FROM movimentacao_garagem_mot
                    INNER JOIN localidade origem ON origem.id_localidade = movimentacao_garagem_mot.id_localidade_garagem_origem
                    LEFT JOIN localidade destino ON destino.id_localidade = movimentacao_garagem_mot.id_localidade_garagem_destino
                    INNER JOIN pessoa ON pessoa.id_pessoa = movimentacao_garagem_mot.id_pessoa_motorista
                    WHERE pessoa.id_pessoa = ".$id_motorista." ORDER BY movimentacao_garagem_mot.data_inc DESC" ;
        $query= $pdo->prepare($loSql);
        $query->execute();

        $loConsulta = null;
        foreach ($query as $row) {
               
               $loConsulta[] = array(
                    'origem'            => $row["origem"]
                    ,'destino'          => $row["destino"]
                    ,'motorista'        => $row["motorista"]
                    ,'motivo_alteracao' => $row["motivo_alteracao"]
                    ,'ativo'            => $row["ativo"]
                    ,'data_inc'         => $row["data_inc"]
                );
        
        }
        return $loConsulta;                     

    }

    public function VerificaGaragemAtual($mbMotorista,$mbGaragem){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

        $loContaItemVazio = null;
        $loSqlVazio = "SELECT COUNT(id_localidade_garagem_atual) contagem FROM pessoa WHERE id_pessoa = ".$mbMotorista." AND (id_localidade_garagem_atual = 0 OR id_localidade_garagem_atual IS NULL) ";
        $queryVazio= $pdo->prepare($loSqlVazio);
        $queryVazio->execute();

        foreach ($queryVazio as $rowVazio) {
            $loContaItemVazio = $rowVazio["contagem"];
        }

        $loContaItemIgualdade = null;
        $loSqlIgualdade = "SELECT COUNT(id_localidade_garagem_atual) contagem FROM pessoa WHERE  id_pessoa = ".$mbMotorista." AND id_localidade_garagem_atual = ".$mbGaragem;
        $queryIgualdade= $pdo->prepare($loSqlIgualdade);
        $queryIgualdade->execute();

        foreach ($queryIgualdade as $rowIgualdade) {
            $loContaItemIgualdade = $rowIgualdade["contagem"];
        }


        $loRetorno = array("conta_garem_vazio" => $loContaItemVazio, "conta_garem_igual" => $loContaItemIgualdade );
        return $loRetorno;


    }

    public function BuscaIDPessoa (){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

        $loSql = "SELECT MAX(id_pessoa) id_pessoa FROM pessoa";
        $query= $pdo->prepare($loSql);
        $query->execute();

        foreach ($query as $row) {
            $loId = $row["id_pessoa"];
        }

        return $loId;
    }

    public function BuscaStatusPessoa($mbId){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

        $loSql = "SELECT ativo FROM pessoa WHERE id_pessoa  = ".$mbId;
        $query= $pdo->prepare($loSql);
        $query->execute();

        $loRetorno = "";
        foreach ($query as $row) {
            $loRetorno = $row["ativo"];
        }

        return $loRetorno;

    }

    public function BuscaDataHabilitacaoPessoa($mbIdPessoa,$mbData){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

        $loSql = "SELECT 
                    validade_habilitacao
                    ,id_pessoa
                    ,(SELECT COUNT(validade_habilitacao) FROM pessoa WHERE id_pessoa = ".$mbIdPessoa." AND validade_habilitacao = '".$mbData."') conta
                FROM pessoa WHERE id_pessoa = ".$mbIdPessoa;
        $query= $pdo->prepare($loSql);
        $query->execute();

        $loItens = NULL;
        foreach ($query as $row) {

            $loItens = array(
                        'dt_validade_habilitacao_atual' => $row["validade_habilitacao"]
                        ,'verifica_data_diff'           => $row["conta"]
                    );

        }

        return $loItens;

    }

    public function ListaLog($mdDados){

        $loIdPessoa = $mdDados["id"]; 

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

        $loSql = "SELECT  /*STATUS*/
                    pessoa.id_usuario_alt_status as 'id_usuario_alt',
                    pessoa_usuario_status.nome as 'nome_usuario',
                    DATE_FORMAT(pessoa.dt_alt_status, '%d/%m/%Y %H:%i') as 'dt_alt'
                    ,'status' as 'alterado'
                    ,pessoa.valor_anterior_status as 'valor_alterado'
                    ,pessoa.ativo as 'valor_atual'
                FROM pessoa 
                LEFT JOIN usuario ON usuario.id_usuario = pessoa.id_usuario_alt_status
                LEFT JOIN pessoa pessoa_usuario_status  ON  pessoa_usuario_status.id_pessoa = usuario.id_pessoa_origem
                WHERE pessoa.id_pessoa = ".$loIdPessoa."
                            UNION 
                SELECT  /*HABILITACAO*/
                        pessoa.id_usuario_alt_status as 'id_usuario_alt'
                        ,pessoa_usuario_status.nome as 'nome_usuario'
                        ,DATE_FORMAT(pessoa.dt_alt_dt_validade_habilitacao, '%d/%m/%Y %H:%i') as 'dt_alt'
                        ,'data habilita&ccedil;&atilde;o' as 'alterado'
                        ,DATE_FORMAT(pessoa.valor_anterior_dt_validade_habilitacao, '%d/%m/%Y %H:%i') as 'valor_alterado'
                        ,DATE_FORMAT(pessoa.validade_habilitacao, '%d/%m/%Y %H:%i') as 'valor_atual'
                FROM pessoa 
                LEFT JOIN usuario ON usuario.id_usuario = pessoa.id_usuario_alt_dt_validade_habilitacao
                LEFT JOIN pessoa pessoa_usuario_status  ON  pessoa_usuario_status.id_pessoa = usuario.id_pessoa_origem
                WHERE pessoa.id_pessoa = ".$loIdPessoa;

        $query= $pdo->prepare($loSql);
        $query->execute();

         $loConsulta = NULL;
        foreach ($query as $row) {


            $loConsulta[] = array(
                    'id_usuario_alt'          => $row["id_usuario_alt"]
                    ,'dt_alt'                 => $row["dt_alt"]
                    ,'nome_usuario'           => $row["nome_usuario"]
                    ,'item_alterado'          => $row["alterado"]
                    ,'valor_alterado'         => $row["valor_alterado"]
                    ,'valor_atual'         => $row["valor_atual"]
                );

        }

        return $loConsulta;

    }

    public function ValidaLogin($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();          

        $loLogin = $mbDados["login"];

        $loSql = "SELECT COUNT(id_usuario) conta FROM usuario WHERE login = '".$loLogin."'";
        $query= $pdo->prepare($loSql);
        $query->execute();

        $loRetorno = true;
        foreach ($query as $row) {
            $row["conta"] == 1 ?  $loRetorno = false : $loRetorno = true; 
        }
        return $loRetorno;

    }

    public function RemoverImagemLogo($mbIdEmpresa){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao(); 

        $loSql = "UPDATE pessoa SET arquivo_logo = NULL, arquivo_logo_caminho = NULL WHERE id_pessoa = ".$mbIdEmpresa;
        $query= $pdo->prepare($loSql);
        $query->execute();

        return true;
    }

}
?>