<?php


class menuBOA{ 
    
    public function ListaMenu(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        /*Verifica Permissão Pai ---------*/
        $loSqlGrupo = "SELECT id_grupo FROM usuario WHERE id_usuario = ".$_SESSION["id_usuario"];
        $queryGrupo = $pdo->prepare($loSqlGrupo);
        $queryGrupo->execute();
        $loIdGrupo = 0;
        foreach ($queryGrupo as $rowGrupo) {
            $loIdGrupo = $rowGrupo["id_grupo"];
        }


        $loSqlP = "SELECT id_menu,id_menu_mae,nome,url,css_icon FROM menu WHERE id_menu_mae IS NULL AND ind_ativo = 1 ORDER BY ordenacao ";
        $queryP = $pdo->prepare($loSqlP);
        $queryP->execute();
        $loMontaStr = "";
        foreach($queryP as $rowMenuLiberado){

               $loLiberado = false; 
               $loSqlVP = "SELECT COUNT(*) conta_acesso 
                            FROM permissoes 
                            WHERE permissoes.id_menu IN(SELECT id_menu FROM menu WHERE id_menu_mae = ".$rowMenuLiberado["id_menu"]." )  
                            AND permissoes.id_grupo = ".$loIdGrupo." 
                            AND permissoes.tipo = 'C'";
               //echo $loSqlVP;
               $queryVP = $pdo->prepare($loSqlVP);
               $queryVP->execute();
               foreach ($queryVP as $rowVP) {
                    if($rowVP["conta_acesso"] > 0){
                        $loLiberado = true;
                    }
               }

               if($loLiberado){
                    $loMontaStr .= $rowMenuLiberado["id_menu"].",";
               }            
        }

        if($_SESSION["supervisor"]){ 
            $loWhereIdMenu = "";
        }else{
            $loMontaStr = substr_replace($loMontaStr, '', -1);
            $loWhereIdMenu = " AND id_menu IN(".$loMontaStr.")";
        }

        //Dados menu
        $loSql = "SELECT id_menu,id_menu_mae,nome,url,css_icon FROM menu WHERE id_menu_mae IS NULL AND ind_ativo = 1 ".$loWhereIdMenu." ORDER BY ordenacao";
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();

        
        foreach ($query as $row) {

            $menu_itens[] = array(
                'id_menu'       =>$row['id_menu'] , 
                'id_menu_mae'   =>$row['id_menu_mae'], 
                'nome'          =>$row['nome'], 
                'url'           =>$row['url'],
                'css_icon'      =>$row['css_icon']
            );

        }

       return $menu_itens;

    }

    public function ListaSubMenu($mbArea){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
       
        
        $loSql = "SELECT 
                        menu.id_menu
                        ,menu.id_menu_mae
                        ,menu.nome
                        ,menu.url
                        ,menu.css_icon  
                FROM 
                        menu 
                WHERE 
                    menu.id_menu_mae = ".$mbArea." 
                    AND menu.ind_ativo = 1 
                    ORDER BY ordenacao ";

        $query= $pdo->prepare($loSql);
        $query->execute();

        $menu_itens = null; 

        foreach ($query as $row) {


            $loLiberaAcesso = false;
            if($_SESSION["supervisor"] == 1){
                $loLiberaAcesso = true;
            }else{

                $loSqlPermissao = "SELECT COUNT(*) conta_acesso FROM usuario 
                                        INNER JOIN permissoes ON permissoes.id_grupo = usuario.id_grupo 
                                        WHERE usuario.id_usuario = ".$_SESSION["id_usuario"]."
                                        AND permissoes.id_menu = ".$row["id_menu"]."
                                        AND permissoes.tipo = 'C'";
                //echo $loSqlPermissao;
                $queryPermissao = $pdo->prepare($loSqlPermissao);
                $queryPermissao->execute(); 

                foreach ($queryPermissao as $rowPermissao) {
                    //echo "conta_acesso= ".$rowPermissao["conta_acesso"];
                    if($rowPermissao["conta_acesso"] > 0){
                        $loLiberaAcesso = true;
                    }
                }     

            }                           
            
            if($loLiberaAcesso){            
                $menu_itens[] = array(
                        'id_menu'       =>$row['id_menu'] , 
                        'id_menu_mae'   =>$row['id_menu_mae'], 
                        'nome'          =>$row['nome'], 
                        'url'           =>$row['url'],
                        'css_icon'      =>$row['css_icon']
                    );
            }
            

        }

        return $menu_itens;

    }

}

?>