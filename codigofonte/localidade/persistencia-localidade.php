<?php

class localidadeBOA{


    public function ListaLocalidade($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 
                        localidade.id_localidade, 
                        localidade.nome, 
                        categoria_localidades.id_cat_localidade,
                        categoria_localidades.nome as nome_categoria, 
                        localidade.id_pessoa_unidade, 
                        localidade.id_pessoa_matriz, 
                        localidade.longitude, 
                        localidade.latitude, 
                        localidade.cep, 
                        localidade.endereco, 
                        localidade.bairro, 
                        localidade.numero, 
                        localidade.complemento, 
                        cidade.id_cidade, 
                        cidade.nome as nome_cidade,
                        estado.id_estado, 
                        estado.uf as uf,
                        localidade.telefone_dd, 
                        localidade.telefone, 
                        localidade.telefone_dd2, 
                        localidade.telefone_2, 
                        localidade.garagem, 
                        localidade.cod_rastreamento, 
                        localidade.dt_cad, 
                        localidade.dt_alt, 
                        localidade.id_usuario_cad, 
                        localidade.id_usuario_alt,
                        localidade.ativo,
                        localidade.id_tipo_logradouro
                    FROM localidade
                    LEFT JOIN cidade ON cidade.id_cidade = localidade.id_cidade
                    LEFT JOIN estado ON estado.id_estado = cidade.id_estado
                    LEFT JOIN categoria_localidades ON categoria_localidades.id_cat_localidade = localidade.id_cat_localidade
                    WHERE 1=1 ".$mbDados;
                   //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loLocalidades = null;
        foreach ($query as $row) {
               
               
               $loLocalidades[] = array(
                     'id_localidade'        => $row["id_localidade"] 
                     ,'nome'                 => $row["nome"] 
                     ,'id_cat_localidade'    => $row["id_cat_localidade"] 
                     ,'nome_categoria'       => $row["nome_categoria"] 
                     ,'id_pessoa_unidade'    => $row["id_pessoa_unidade"] 
                     ,'id_pessoa_matriz'     => $row["id_pessoa_matriz"] 
                     ,'longitude'            => $row["longitude"] 
                     ,'latitude'             => $row["latitude"] 
                     ,'cep'                  => $row["cep"] 
                     ,'endereco'             => $row["endereco"] 
                     ,'bairro'               => $row["bairro"] 
                     ,'numero'               => $row["numero"] 
                     ,'complemento'          => $row["complemento"] 
                     ,'id_cidade'            => $row["id_cidade"] 
                     ,'nome_cidade'          => $row["nome_cidade"] 
                     ,'id_estado'            => $row["id_estado"]
                     ,'uf'                   => $row["uf"]
                     ,'telefone_dd'          => $row["telefone_dd"] 
                     ,'telefone'             => $row["telefone"] 
                     ,'telefone_dd2'         => $row["telefone_dd2"] 
                     ,'telefone_2'           => $row["telefone_2"] 
                     ,'garagem'              => $row["garagem"] 
                     ,'cod_rastreamento'     => $row["cod_rastreamento"] 
                     ,'dt_cad'               => $row["dt_cad"] 
                     ,'dt_alt'               => $row["dt_alt"] 
                     ,'id_usuario_cad'       => $row["id_usuario_cad"] 
                     ,'id_usuario_alt'       => $row["id_usuario_alt"]
                     ,'ativo'                => $row["ativo"]
                     ,'id_tipo_logradouro'   => $row["id_tipo_logradouro"]
                );
               
        
        }

        return $loLocalidades;        



    }

    public function IncluirLocalidade($loDados){

        $loNome                 = utf8_decode($loDados["nome"]); 
        $loCategoria            = utf8_decode($loDados["categoria"]); 
        $loIDPessoaUnidade      = $loDados["id_pessoa_unidade"]; 
        $loLongitude            = utf8_decode($loDados["longitude"]); 
        $loLatitude             = utf8_decode($loDados["latitude"]); 
        $loCep                  = $loDados["cep"]; 
        $loEndereco             = utf8_decode($loDados["endereco"]); 
        $loBairro               = utf8_decode($loDados["bairro"]); 
        $loNumero               = $loDados["numero"]; 
        $loComplemento          = utf8_decode($loDados["complemento"]); 
        $loIdCidade             = $loDados["id_cidade"]; 
        $loTelefoneDD           = substr($loDados["telefone"], 0,2); 
        $loTelefone             = substr($loDados["telefone"], 2,9);
        $loTelefoneDD2          = substr($loDados["telefone"], 0,2);
        $loTelefone2            = substr($loDados["telefone"], 2,9); 
        $loGaragem              = $loDados["garagem"]; 
        $loCodRastreamento      = $loDados["cod_rastreamento"]; 
        $loAtivo                = $loDados["status"];
        $loIdLogradouro         = $loDados["id_tipo_logradouro"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    localidade (
                        nome, 
                        id_cat_localidade, 
                        id_pessoa_unidade, 
                        id_pessoa_matriz, 
                        longitude, 
                        latitude, 
                        cep, 
                        endereco, 
                        bairro, 
                        numero, 
                        complemento, 
                        id_cidade, 
                        telefone_dd, 
                        telefone, 
                        telefone_dd2, 
                        telefone_2, 
                        garagem, 
                        cod_rastreamento,
                        id_usuario_cad,
                        ativo,
                        id_tipo_logradouro,
                        dt_cad                        
                     ) VALUES (                        
                         ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $loNome); 
        $query->bindValue(2, $loCategoria);
        $query->bindValue(3, $loIDPessoaUnidade); 
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]); 
        $query->bindValue(5, $loLongitude); 
        $query->bindValue(6, $loLatitude); 
        $query->bindValue(7, $loCep); 
        $query->bindValue(8, $loEndereco); 
        $query->bindValue(9, $loBairro); 
        $query->bindValue(10, $loNumero); 
        $query->bindValue(11, $loComplemento); 
        $query->bindValue(12, $loIdCidade); 
        $query->bindValue(13, $loTelefoneDD); 
        $query->bindValue(14, $loTelefone);
        $query->bindValue(15, $loTelefoneDD2);
        $query->bindValue(16, $loTelefone2); 
        $query->bindValue(17, $loGaragem); 
        $query->bindValue(18, $loCodRastreamento); 
        $query->bindValue(19, $_SESSION["id_usuario"]);
        $query->bindValue(20, $loAtivo); 
        $query->bindValue(21, $loIdLogradouro); 

        $query->execute(); 

        return true;


    }

    public function AlterarLocalidade($loDados){


        $loNome                 = utf8_decode($loDados["nome"]); 
        $loCategoria            = utf8_decode($loDados["categoria"]); 
        $loIDPessoaUnidade      = ""; 
        $loLongitude            = utf8_decode($loDados["longitude"]); 
        $loLatitude             = utf8_decode($loDados["latitude"]); 
        $loCep                  = $loDados["cep"]; 
        $loEndereco             = utf8_decode($loDados["endereco"]); 
        $loBairro               = utf8_decode($loDados["bairro"]); 
        $loNumero               = $loDados["numero"]; 
        $loComplemento          = utf8_decode($loDados["complemento"]); 
        $loIdCidade             = $loDados["id_cidade"]; 
        $loTelefoneDD           = substr($loDados["telefone"], 0,2); 
        $loTelefone             = substr($loDados["telefone"], 2,9);
        $loTelefoneDD2          = substr($loDados["telefone2"], 0,2);
        $loTelefone2            = substr($loDados["telefone2"], 2,9); 
        $loGaragem              = $loDados["garagem"]; 
        $loCodRastreamento      = $loDados["cod_rastreamento"]; 
        $loId                   = $loDados["id"];
        $loAtivo                = $loDados["status"];
        $loIdLogradouro         = $loDados["id_tipo_logradouro"];

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE localidade SET
                        nome = ? , 
                        id_cat_localidade = ? , 
                        id_pessoa_unidade = ? , 
                        id_pessoa_matriz = ? , 
                        longitude = ? , 
                        latitude = ? , 
                        cep = ? , 
                        endereco = ? , 
                        bairro = ? , 
                        numero = ? , 
                        complemento = ? , 
                        id_cidade = ? , 
                        telefone_dd = ? , 
                        telefone = ? , 
                        telefone_dd2 = ? , 
                        telefone_2 = ? , 
                        garagem = ? , 
                        cod_rastreamento = ? , 
                        id_usuario_alt = ? ,
                        ativo = ? ,
                        id_tipo_logradouro = ?,
                        dt_alt = NOW() 
                WHERE id_localidade = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome); 
        $query->bindValue(2, $loCategoria);
        $query->bindValue(3, $loIDPessoaUnidade); 
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]); 
        $query->bindValue(5, $loLongitude); 
        $query->bindValue(6, $loLatitude); 
        $query->bindValue(7, $loCep); 
        $query->bindValue(8, $loEndereco); 
        $query->bindValue(9, $loBairro); 
        $query->bindValue(10, $loNumero); 
        $query->bindValue(11, $loComplemento); 
        $query->bindValue(12, $loIdCidade); 
        $query->bindValue(13, $loTelefoneDD); 
        $query->bindValue(14, $loTelefone);
        $query->bindValue(15, $loTelefoneDD2);
        $query->bindValue(16, $loTelefone2); 
        $query->bindValue(17, $loGaragem); 
        $query->bindValue(18, $loCodRastreamento); 
        $query->bindValue(19, $_SESSION["id_usuario"]);
        $query->bindValue(20, $loAtivo);
        $query->bindValue(21, $loIdLogradouro);
        $query->bindValue(22, $loId); 
        $query->execute(); 

        return true;         

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

     public function DesativarLocalidade($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(count($loDados) > 0 ){
            foreach ($loDados as $item){
            
                $loSql = "UPDATE localidade SET ativo = 0 WHERE id_localidade = ".$item;
                $query= $pdo->prepare($loSql);
                $query->execute();
            }
        }

         return true;

     }

     public function ListaCategorias($mdDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_cat_localidade,nome FROM categoria_localidades WHERE 1=1 ".$mdDados;
        $query= $pdo->prepare($loSql);
        $query->execute();
        
        $loGrid = null;
        foreach ($query as $row) {

              $loGrid[] = array(
                    'id_cat_localidade'       => $row["id_cat_localidade"]
                    ,'nome'                   => $row["nome"]
                );
        }

        return $loGrid;

     }

     public function ListaLogradouro($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();         

         $loSql = "SELECT id_tipo_logradouro,nome FROM tipo_logradouro ORDER BY nome";
         $query= $pdo->prepare($loSql);
         $query->execute();
        
         $loGrid = null;
         foreach ($query as $row) {

            $loGrid[] = array(
                    'id_tipo_logradouro'       => $row["id_tipo_logradouro"]
                    ,'nome'                   => $row["nome"]
                );
         }

         return $loGrid;

     }

    public function BuscaIDLocalidade (){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();  

        $loSql = "SELECT MAX(id_localidade) id_localidade FROM localidade";
        $query= $pdo->prepare($loSql);
        $query->execute();

        foreach ($query as $row) {
            $loId = $row["id_localidade"];
        }

        return $loId;
    }

}
?>