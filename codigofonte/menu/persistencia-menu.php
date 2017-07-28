<?php


class menuBOA{ 
    
    public function ListaMenu(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_menu,id_menu_mae,nome,url,css_icon FROM menu WHERE id_menu_mae IS NULL AND ind_ativo = 1 ORDER BY ordenacao";
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