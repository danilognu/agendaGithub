<?php

class comumBOA{

    public function ListaEstado($mbDados) {

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_estado,nome,uf FROM estado WHERE 1=1 ORDER BY uf";
        $query= $pdo->prepare($loSql);
        $query->execute();          

        $loEstados = null;
        foreach ($query as $row) {

            $loEstados[] = array(
                'id_estado' => $row["id_estado"] 
                ,'nome' => $row["nome"] 
                ,'uf' => $row["uf"] 
            );

        }

        return  $loEstados;

    }

    public function ListaCidade($mbIdEstado,$mbIdCidade) {

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
        
        $loConsulta =  null;
        if($mbIdCidade != ""){
            $loConsulta = " AND id_cidade = ".$mbIdCidade; 
        }

        $loSql = "SELECT id_cidade,nome,id_estado FROM cidade WHERE id_estado = ".$mbIdEstado." ".$loConsulta;
        $query= $pdo->prepare($loSql);
        $query->execute();          

        $loEstados = null;
        foreach ($query as $row) {

            $loCidades[] = array(
                'id_cidade' => $row["id_cidade"] 
                ,'nome' => utf8_encode($row["nome"]) 
                ,'id_estado' => $row["id_estado"] 
            );

        }

        return  $loCidades;

    }

    public function ExibirNomeMenu($mdIdMenu){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT nome FROM menu WHERE id_menu = ".$mdIdMenu;

        $query= $pdo->prepare($loSql);
        $query->execute();  
        foreach ($query as $row) {
            $loNome = $row["nome"];
        }

        return $loNome;

    }

    public function VerificaPermissao($mbDados) {

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdUsuario  = $mbDados["id_usuario"];
        $loIdMenu     = $mbDados["id_menu"];

        $loSql = "SELECT 
                        permissoes.tipo
                    FROM usuario
                        INNER JOIN grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                        INNER JOIN permissoes ON permissoes.id_grupo = grupo_acesso.id_grupo
                    WHERE usuario.id_usuario = ".$loIdUsuario." 
                    AND permissoes.id_menu = ".$loIdMenu;
        
        $query= $pdo->prepare($loSql);
        $query->execute();  

        $loGrid = null;
        foreach ($query as $row) {
            
                $loGrid[] = array(
                    'tipo_acesso'   => $row["tipo"]
                );

        }

        return $loGrid;                


    }

    public function VerificaCarona(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT ind_carona FROM pessoa WHERE id_pessoa = ".$_SESSION["id_pessoa_matriz"];
        $query= $pdo->prepare($loSql);
        $query->execute();  

        $loCarona = false;
        foreach ($query as $row) {
                
                if($row["ind_carona"] == 1){
                    $loCarona = true;
                }
        }

        return $loCarona;   

    }

    public function ListaDadosAcessoUsuarioCorrente(){
        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT 
                    grupo_acesso.id_grupo
                    ,grupo_acesso.ind_usuario
                    ,grupo_acesso.ind_gestor
                    ,grupo_acesso.ind_operador
                    ,grupo_acesso.ind_adm
                    ,pessoa.id_pessoa
                FROM pessoa 
                INNER JOIN usuario ON usuario.id_pessoa_origem = pessoa.id_pessoa
                INNER JOIN grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                WHERE usuario.id_usuario = ".$_SESSION["id_usuario"];
        $query= $pdo->prepare($loSql);
        $query->execute();  

        $loGrid = null;
        foreach ($query as $row) {
            
                $loGrid[] = array(
                    'id_grupo'       => $row["id_grupo"]
                    ,'ind_usuario'   => $row["ind_usuario"]
                    ,'ind_gestor'    => $row["ind_gestor"]
                    ,'ind_operador'  => $row["ind_operador"]
                    ,'ind_adm'       => $row["ind_adm"]
                    ,'id_pessoa'     => $row["id_pessoa"]
                );

        }

        return $loGrid;   
    }

    public function PendenciasDeAutorizacaoCarona(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();     

        $loIdGrupoAcesso = NULL;
        $loSqlVerificaGrupo = "SELECT id_grupo FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"];
        $queryGrupoAcesso= $pdo->prepare($loSqlVerificaGrupo);
        $queryGrupoAcesso->execute();  
        foreach ($queryGrupoAcesso as $rowGrupoAcesso) {
            $loIdGrupoAcesso = $rowGrupoAcesso["id_grupo"];           
        }

        $loGrid = null;
        if($loIdGrupoAcesso == 4){ // Se for operador mostratodas as solicitações de carona

            $loSql = "SELECT 
                    solicitacao_carona.id_solicitacao
                        ,pessoa_solicitante.nome as 'pessoa_solicitante'
                FROM solicitacao_carona 
                INNER JOIN pessoa pessoa_solicitante ON pessoa_solicitante.id_pessoa = solicitacao_carona.id_pessoa_solicitante
                INNER JOIN solicitacao ON solicitacao.id_solicitacao = solicitacao_carona.id_solicitacao
                AND (solicitacao_carona.status IS NULL OR solicitacao_carona.status  = 'S') AND solicitacao.id_status_solicitacao NOT IN(4,5) ";

            $query= $pdo->prepare($loSql);
            $query->execute();  

            $loGrid = null;
            foreach ($query as $row) {
                
                    $loGrid[] = array(
                        'id_solicitacao'        => $row["id_solicitacao"]
                        ,'pessoa_solicitante'   => $row["pessoa_solicitante"]
                    );
            }                

        }
       /* }else{ // Se nao for operador mostra somente de quem ele autoriza e as dele mesmo

            $loSql = "SELECT 
                        solicitacao_carona.id_solicitacao
                            ,pessoa_solicitante.nome as 'pessoa_solicitante'
                    FROM solicitacao_carona 
                    INNER JOIN pessoa pessoa_solicitante ON pessoa_solicitante.id_pessoa = solicitacao_carona.id_pessoa_solicitante
                    INNER JOIN solicitacao ON solicitacao.id_solicitacao = solicitacao_carona.id_solicitacao
                    WHERE solicitacao.id_status_solicitacao NOT IN(4,5) AND id_pessoa_autorizador IN(
                        SELECT id_pessoa_origem FROM usuario where id_usuario = ".$_SESSION["id_usuario"]."
                    ) AND solicitacao_carona.status IS NULL
                    /*Verica aqui pessoa que o usuario autoriza e que estão como requisitante na solcitacao  */
                   /* AND solicitacao_carona.id_solicitacao IN(
                        SELECT id_solicitacao FROM solicitacao
                        WHERE solicitacao.id_pessoa_requisitante = (
                            SELECT autorizadores.id_pessoa_filho 
                            FROM autorizadores 
                            WHERE id_pessoa_pai = (SELECT id_pessoa_origem FROM usuario where id_usuario = ".$_SESSION["id_usuario"].")
                            ) 
                        )
                    OR 
                    /*Verifica aqui toda as solicitacoes que o usuario esta como requisitante*/
                  /*  solicitacao_carona.id_solicitacao IN(
                        SELECT id_solicitacao FROM solicitacao
                        WHERE solicitacao.id_pessoa_requisitante = (SELECT id_pessoa_origem FROM usuario where id_usuario = ".$_SESSION["id_usuario"].") 
                        )
                    GROUP BY 
                        solicitacao_carona.id_solicitacao
                        ,pessoa_solicitante.nome";

        }*/


        return $loGrid;                    

    }

    public function BuscaLogoEmpresa(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();           

        $loSql = "SELECT arquivo_logo_caminho,arquivo_logo FROM pessoa WHERE id_pessoa = ".$_SESSION["id_pessoa_matriz"];
        $query= $pdo->prepare($loSql);
        $query->execute();  

        $loGrid = null;
        foreach ($query as $row) {
            
                $loGrid[] = array(
                    'arquivo_logo_caminho'        => $row["arquivo_logo_caminho"]
                    ,'arquivo_logo'               => $row["arquivo_logo"]
                );
        }

        return $loGrid;    

    }

}

?>