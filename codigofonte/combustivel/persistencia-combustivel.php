<?php
class combustivelBOA{


    public function ListaCombustivel($mbDados){
        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loDdConsulta = "";
        if(isset($_SESSION["id_pessoa_matriz"]) && !empty($_SESSION["id_pessoa_matriz"]) ){
            $loDdConsulta .= " AND id_pessoa = ".$_SESSION["id_pessoa_matriz"];
        }

        $loNome = null;
        if(isset($mbDados["nome"]) && !empty($mbDados["nome"]) ){
            $loNome = $mbDados["nome"];
            $loDdConsulta .=  " AND nome like '%".$loNome."%'"; 

        }

        $loSql = "SELECT 
                    id_combustivel
                    ,nome
                    ,ativo
                    ,dt_cad
                    ,dt_alt
                    ,id_usuario_cad
                    ,id_usuario_alt
                    ,id_pessoa 
                FROM combustivel WHERE 1=1 ".$loDdConsulta." ORDER BY nome "  ;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loModelos = null;
        foreach ($query as $row) {   

             $loModelos[] = array(
                    'id_combustivel'    => $row["id_combustivel"]
                    ,'nome'             => $row["nome"]
                    ,'ativo'            => $row["ativo"] 
                    ,'dt_cad'           => $row["dt_cad"] 
                    ,'dt_alt'           => $row["dt_alt"] 
                    ,'id_usuario_cad'   => $row["id_usuario_cad"]  
                    ,'id_usuario_alt'   => $row["id_usuario_alt"]   
                    ,'id_pessoa'        => $row["id_pessoa"]    
             );

             

        }

        return $loModelos; 
    }

        public function IncluirCombustivel($loDados){

        $loNome         = utf8_encode($loDados["nome"]);
        $loAtivo        = $loDados["status"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    combustivel (
                        nome
                        ,ativo
                        ,id_usuario_cad
                        ,id_pessoa
                        ,dt_cad
                     ) VALUES (                        
                         ?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loAtivo);
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]);
        $query->execute(); 

        return true;


    }

    public function AlterarCombustivel($loDados){

        

        $loNome         = utf8_encode($loDados["nome"]);
        $loAtivo        = $loDados["status"];
        $loId           = $loDados["id"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE combustivel SET
                         nome = ?
                        ,ativo = ?
                        ,id_usuario_alt = ?
                        ,id_pessoa = ?
                        ,dt_alt = NOW()
                WHERE id_combustivel = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loAtivo);
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(5, $loId);
        $query->execute(); 
     
        return true;         

    }


}

?>