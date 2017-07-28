<?php

class cnpjDeFaturamentoBOA{


    public function Consultar($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(strlen($mbDados) > 0){
            $mbDados = " ".$mbDados;
        }

        $loSql = "SELECT 
                        id_cnpj_faturamento
                        ,cnpj
                        ,descricao
                        ,id_usuario_cad
                        ,id_usuario_alt
                        ,dt_cad
                        ,dt_alt
                        ,id_pessoa_matriz
                        ,ativo
                    FROM cnpj_faturamento 
                    WHERE 1=1 ".$mbDados;


        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loItens = null;
        foreach ($query as $row) {
               
               
               $loItens[] = array(
                     'id'                    => $row["id_cnpj_faturamento"] 
                     ,'cnpj'                 => $row["cnpj"] 
                     ,'descricao'            => $row["descricao"] 
                     ,'id_pessoa_matriz'     => $row["id_pessoa_matriz"] 
                     ,'ativo'                => $row["ativo"]
                );
               
        
        }

        return $loItens;        



    }

    public function Incluir($loDados){

        $loCNPJ = $loDados["cnpj"]; 
        $loDescricao = utf8_decode($loDados["descricao"]); 


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    cnpj_faturamento (
                        cnpj, 
                        descricao,
                        ativo,
                        id_usuario_cad,
                        id_pessoa_matriz, 
                        dt_cad                   
                     ) VALUES (                        
                         ?,?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $loCNPJ);
        $query->bindValue(2, $loDescricao);
        $query->bindValue(3, 1); 
        $query->bindValue(4, $_SESSION["id_usuario"]);        
        $query->bindValue(5, $_SESSION["id_pessoa_matriz"]); 

        $query->execute(); 

        return true;


    }

    public function Alterar($loDados){


        $loCNPJ                 = $loDados["cnpj"]; 
        $loDescricao            = utf8_decode($loDados["descricao"]); 
        $loAtivo                = $loDados["status"];
        $loId                   = $loDados["id"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


       $loSql = "UPDATE cnpj_faturamento SET
                        cnpj = ? ,
                        descricao = ? ,
                        id_usuario_alt = ?,
                        ativo = ? ,                       
                        dt_alt = NOW()
                WHERE id_cnpj_faturamento = ?";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loCNPJ);
        $query->bindValue(2, $loDescricao); 
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $loAtivo);
        $query->bindValue(5, $loId); 
        $query->execute(); 

        return true;         

    }

   
  

}
?>