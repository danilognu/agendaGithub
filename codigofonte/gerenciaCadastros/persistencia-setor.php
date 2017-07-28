<?php

class setorBOA{


    public function ListaSetor($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 
                        id_setor, 
                        nome, 
                        id_pessoa_matriz,   
                        ativo                    
                    FROM setor 
                    WHERE 1=1 ".$mbDados;


        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loSetores = null;
        foreach ($query as $row) {
               
               
               $loSetores[] = array(
                     'id_setor'        => $row["id_setor"] 
                     ,'nome'                 => $row["nome"] 
                     ,'id_pessoa_matriz'     => $row["id_pessoa_matriz"] 
                     ,'ativo'                => $row["ativo"]
                );
               
        
        }

        return $loSetores;        



    }

    public function IncluirSetor($loDados){

        $loNome                 = utf8_decode($loDados["nome"]); 


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    setor (
                        nome, 
                        dt_cad, 
                        id_usuario_cad,
                        ativo,
                        id_pessoa_matriz                   
                     ) VALUES (                        
                         ?,?,?,?,?)";
         
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $loNome); 
        $query->bindValue(2, "NOW()");
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, 1); 
        $query->bindValue(5, $_SESSION["id_pessoa_matriz"]); 

        $query->execute(); 

        return true;


    }

    public function AlterarSetor($loDados){


        $loNome                 = utf8_decode($loDados["nome"]); 
        $loAtivo                = $loDados["status"];
        $loId                   = $loDados["id"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE setor SET
                        nome = ? ,
                        dt_alt = ?,
                        id_usuario_alt = ?,
                        ativo = ?
                WHERE id_setor = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome); 
        $query->bindValue(2, "NOW()"); 
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $loAtivo);
        $query->bindValue(5, $loId); 
        $query->execute(); 

        return true;         

    }

   
  

}
?>