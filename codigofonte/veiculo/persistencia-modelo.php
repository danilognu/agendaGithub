<?php
class modeloBOA{


    public function ListaModelo($mbDados){
        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loDdConsulta = "";
        if(isset($_SESSION["id_pessoa_matriz"]) && !empty($_SESSION["id_pessoa_matriz"]) ){
            $loDdConsulta .= " AND id_pessoa = ".$_SESSION["id_pessoa_matriz"];
        }

        $loId = null;
        if(isset($mbDados["id"]) && !empty($mbDados["id"]) ){
            $loId = $mbDados["id"];
            $loDdConsulta .=  " AND id_modelo  = ".$loId; 

        }

        $loNome = null;
        if(isset($mbDados["nome"]) && !empty($mbDados["nome"]) ){
            $loNome = $mbDados["nome"];
            $loDdConsulta .=  " AND nome like '%".$loNome."%'"; 

        }

        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND modelo.id_pessoa = ".$_SESSION["id_pessoa_matriz"];
        }

        $loSql = "SELECT 
                    id_modelo
                    ,nome
                    ,ativo
                    ,dt_cad
                    ,dt_alt
                    ,id_usuario_cad
                    ,id_usuario_alt
                    ,id_pessoa 
                FROM modelo WHERE 1=1 ".$loDdConsulta." ORDER BY nome "  ;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loModelos = null;
        foreach ($query as $row) {   

             $loModelos[] = array(
                    'id_modelo'         => $row["id_modelo"]
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

        public function IncluirModelo($loDados){

        $loNome         = utf8_encode($loDados["nome"]);
        $loAtivo        = $loDados["status"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    modelo (
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

        return false;


    }

    public function AlterarModelo($loDados){

        

        $loNome         = utf8_encode($loDados["nome"]);
        $loAtivo        = $loDados["status"];
        $loId           = $loDados["id"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE modelo SET
                         nome = ?
                        ,ativo = ?
                        ,id_usuario_alt = ?
                        ,id_pessoa = ?
                        ,dt_alt = NOW()
                WHERE id_modelo = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loAtivo);
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(5, $loId);

        $query->execute(); 

        return true;         

    }

    public function DesativarModelo($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(count($loDados) > 0 ){
            foreach ($loDados as $item){
            
                $loSql = "UPDATE modelo SET ativo = 0 WHERE id_modelo = ".$item;
                $query= $pdo->prepare($loSql);
                $query->execute();
            }
        }

         return true;

     }


}

?>