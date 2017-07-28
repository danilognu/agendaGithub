<?php
class grupoAcessoBOA{


    public function ListaGrupoAcesso($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loDdConsulta = "";
        $loId = null;
        if(isset($mbDados["id"]) && !empty($mbDados["id"]) ){
            $loId = $mbDados["id"];
            $loDdConsulta .=  " AND id_grupo = ".$loId; 

        }


        $loSql = "SELECT id_grupo,nome,ind_gestor,ind_operador,ind_adm,ind_usuario
                  FROM grupo_acesso WHERE 1 = 1 ".$loDdConsulta." ORDER BY nome";

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loGrupo = null;
        foreach ($query as $row) {
               
               
               $loGrupo[] = array(
                    'id_grupo'       =>$row["id_grupo"] , 
                    'nome'           =>$row["nome"], 
                    'ind_gestor'     =>$row["ind_gestor"],
                    'ind_operador'   =>$row["ind_operador"],
                    'ind_adm'        =>$row["ind_adm"]
                    ,'ind_usuario'   =>$row["ind_usuario"]
                );
               
        
        }

        return $loGrupo;        



    }

    public function IncluirGrupo($loDados){

        $loNome = utf8_decode($loDados["nome"]);

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    grupo_acesso (
                        nome
                        ,dt_cad
                        ,id_usuario_cad
                        ,id_pessoa_matriz
                    ) VALUES (?,?,?,?)";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, "NOW()");
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]);
        $query->execute(); 

        return true;


    }

    public function AlterarGrupo($loDados){



        $loNome = utf8_decode($loDados["nome"]);
        $loId = $loDados["id"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

       $loSql = "UPDATE grupo_acesso SET
                         nome = ?
                         ,dt_alt = ?
                         ,id_usuario_alt = ?
                WHERE id_grupo = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, "NOW()");
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $loId);
        $query->execute(); 

        return true;         

    }


 public function ListaMenuMae(){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_menu,nome FROM menu WHERE ind_ativo = 1 AND id_menu_mae IS NULL ORDER BY id_menu";

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loMenu = null;
        foreach ($query as $row) {
               
               
               $loMenu[] = array(
                    'id_menu'       =>$row['id_menu'] , 
                    'nome'           =>$row['nome'], 
                );
               
        
        }

        return $loMenu;   

    }

 public function ListaMenuFilho($mbId){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_menu,nome FROM menu WHERE ind_ativo = 1 AND id_menu_mae IS NOT NULL AND id_menu_mae = ".$mbId." ORDER BY id_menu";
        //echo  $loSql;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loMenu = null;
        foreach ($query as $row) {
               
               
               $loMenu[] = array(
                    'id_menu'       =>$row['id_menu'] , 
                    'nome'           =>$row['nome'], 
                );
               
        
        }

        return $loMenu;   
        
    }

    public function VerificaPermissao($loDados){

        $loIdGrupo = $loDados["id_grupo"];
        $loIdUsuario = $loDados["id_usuario"];
        $loIdMenu = $loDados["id_menu"];


        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        $loSql = "SELECT permissoes.tipo 
                  FROM grupo_acesso
                  INNER JOIN permissoes ON permissoes.id_grupo = grupo_acesso.id_grupo
                  WHERE 
                  permissoes.id_grupo = ".$loIdGrupo." 
                  AND id_menu = ".$loIdMenu;
        
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loPerm = null;
        foreach ($query as $row) {
               
               
               $loPerm[] = array(
                    'tipo'       =>$row['tipo'] , 
                );
               
        
        }

        return $loPerm;   

    }

     public function GravarPermissao($loDados){
     
         
         $loidGrupo = $loDados["id_grupo"];
         $loidMenu = $loDados["id_menu"];
         $loParam = $loDados["perm"];
         $loAcesso = $loDados["acesso"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

         //Verifica se ja existe
         $loSql = "SELECT 
                        COUNT(*) item_perm 
                    FROM permissoes 
                    WHERE id_grupo = ".$loidGrupo." 
                    AND id_menu = ".$loidMenu."  
                    AND tipo = '".$loParam."'";
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loContagem = 0;
        foreach ($query as $row) {
            $loContagem = $row["item_perm"];
        }

        //echo "Contagem = " . $loContagem . "Acesso = " .$loAcesso; 
        if($loContagem > 0 && $loAcesso == 1){

            $loSqlD = "DELETE FROM permissoes 
                        WHERE id_grupo = ".$loidGrupo."  
                        AND id_menu = ".$loidMenu." 
                        AND tipo = '".$loParam."'";
            $query= $pdo->prepare($loSqlD);
            $query->execute();  

             return true;    

        }else{

            $loSqlI = "INSERT INTO permissoes 
                            (
                                id_usuario
                                ,id_grupo
                                ,id_menu
                                ,tipo) 
                        VALUES (
                                    ?
                                   ,?
                                   ,?
                                   ,?
                             )";

            $query= $pdo->prepare($loSqlI);
            $query->bindValue(1, $_SESSION["id_usuario"]);
            $query->bindValue(2, $loidGrupo);
            $query->bindValue(3, $loidMenu);
            $query->bindValue(4, $loParam);
            $query->execute(); 

            return true;                    

        }
     
     }


     public function ExcluirGrupo($loDados){

         $loIdGrupo = $loDados;

         $loConexao = new Conexao();
         $pdo = $loConexao->IniciaConexao();

         $loSql = "DELETE FROM grupo_acesso WHERE id_grupo = ".$loIdGrupo;
         $query= $pdo->prepare($loSql);
         $query->execute();  

         return true; 

     }

     public function AlteraGrupoAcessoIdentificacao($loDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();

       $loIndGestor = $loDados["ind_gestor"];
       $loIndOperador = $loDados["ind_operador"];
       $loIndAdm = $loDados["ind_adm"];
       $loIdGrupo = $loDados["id_grupo"];
       $loIndUsuario = $loDados["ind_usuario"];


        $loSql = "UPDATE grupo_acesso SET 
                            ind_gestor = ".$loIndGestor."
                            , ind_operador = ".$loIndOperador."
                            , ind_adm = ".$loIndAdm."
                            , ind_usuario = ".$loIndUsuario."
                 WHERE id_grupo = ".$loIdGrupo; 

        $query= $pdo->prepare($loSql);
        $query->execute();  

        return true; 

     }



}
?>