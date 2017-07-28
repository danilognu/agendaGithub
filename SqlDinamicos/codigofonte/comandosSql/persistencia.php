<?php

class persistenciaBOA{ 

    public function ListaBancos(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT name, database_id, create_date FROM sys.databases WHERE name IN('ETOOLS_LETS','ETOOLS_LETS_HOMOLOGA','ETOOLS_DESENVOLVIMENTO');";
        $query = $pdo->prepare($loSql);
        $query->execute();

        $Grid[] = null;
        foreach ($query as $row) {
             
             $Grid[] = array(
                        'nome'  => $row['name'] 
                       );

        }

        return $Grid;

    }

    public function ListaComandosSQL(){

        //Listas Comandos (SQL) Cadastrado pelo ADM
        
        $loConexao = new ConexaoBase();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_comando,nome,comando_sql,descricao FROM comandos";      
        $query = $pdo->prepare($loSql);
        $query->execute();

        $Grid = null;
        foreach ($query as $row) {
             
             $Grid[] = array(
                        'id_comando'  => $row['id_comando'] 
                        ,'nome'  => utf8_decode($row['nome']) 
                        ,'descricao' => utf8_decode($row["descricao"])
                        ,'comando_sql'  => $row['comando_sql'] 
                       );

        }
        return $Grid;  

    }

    public function RecuperaTipoDaColuna($mbDados){

        $loConexao = new ConexaoBase();
        $pdo = $loConexao->IniciaConexao();

        $loNomeTabela = $loDados["tabela"];
        $loNomeColuna = $loDados["coluna"];

        $loSql = "SELECT 
                        ty.name 
                    FROM 
                        sys.tables tb
                    INNER JOIN sys.columns cl  ON tb.object_id = cl.object_id
                    INNER JOIN sys.types ty ON ty.system_type_id = cl.system_type_id
                    WHERE 
                        tb.object_id = cl.object_id
                        AND tb.name = '".$loNomeTabela."' 
                        AND cl.name = '".$loNomeColuna."'";
        $query = $pdo->prepare($loSql);
        $query->execute();

        $Grid = null;
        foreach ($query as $row) {
             
             $Grid[] = array(
                        'tipoColuna'  => $row['name'] 
                       );

        }
        return $Grid;                          

    }

    public function ListaPecaServico(){

       $loConexao = new ConexaoBase();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT T215.A215_nom_peca,T213.A213_nom_grupo,T215.A215_tipo
                    FROM T215_PECA_SERVICO T215
                  INNER JOIN T213_GRUPO_PECA T213 ON T213.A213_cod_grupo = T215.A213_cod_grupo";
        $query = $pdo->prepare($loSql);
        $query->execute();

        $Grid = null;
        $loTipoPeca = "";
        foreach ($query as $row) {
             
             if($row['A213_nom_grupo']  == "P"){
                 $loTipoPeca = "Pe&ccedil;a";
             }else{
                 $loTipoPeca = "Servi&ccedil;o";
             }


             $Grid[] = array(
                        'A215_nom_peca'     => $row['A215_nom_peca'] 
                        ,'A213_nom_grupo'   => $row['A213_nom_grupo'] 
                        ,'tipoPeca'         => $$loTipoPeca
                       );

        }
        return $Grid;   

    }
   
}



?>