<?php

class TipoLogradouroBOA{


    public function Consultar($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 
                        id_tipo_logradouro, 
                        nome, 
                        id_pessoa_matriz,   
                        ativo                    
                    FROM tipo_logradouro 
                    WHERE 1=1 ".$mbDados;
    
        
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loSetores = null;
        foreach ($query as $row) {
               
               
               $loSetores[] = array(
                     'id'                    => $row["id_tipo_logradouro"] 
                     ,'nome'                 => $row["nome"] 
                     ,'id_pessoa_matriz'     => $row["id_pessoa_matriz"] 
                     ,'ativo'                => $row["ativo"]
                );
               
        
        }

        return $loSetores;        



    }

    public function Incluir($loDados){

        $loNome = utf8_decode($loDados["nome"]); 


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    tipo_logradouro (
                        nome, 
                        id_usuario_cad,
                        ativo,
                        id_pessoa_matriz, 
                        dt_cad                   
                     ) VALUES (                        
                         ?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $loNome); 
        $query->bindValue(2, $_SESSION["id_usuario"]);
        $query->bindValue(3, 1); 
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]); 

        $query->execute(); 

        return true;


    }

    public function Alterar($loDados){


        $loNome                 = utf8_decode($loDados["nome"]); 
        $loAtivo                = $loDados["status"];
        $loId                   = $loDados["id"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE tipo_logradouro SET
                        nome = ? ,
                        dt_alt = ?,
                        id_usuario_alt = ?,
                        ativo = ?
                WHERE id_tipo_logradouro = ? ";
        
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