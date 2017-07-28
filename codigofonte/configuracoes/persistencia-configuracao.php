<?php
class configuracaoBOA{


   public function ListaDisplayMotorista($mbDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

       

        $loIdParametros = $mbDados["id_parametro"];
        $loSql = "SELECT 
                    parametros.id_parametro
                    ,valor_parametro.id_vlr_parametro 
                    ,parametros.nome
                    ,valor_parametro.valor
                FROM parametros
                INNER JOIN valor_parametro ON valor_parametro.id_parametro = parametros.id_parametro
                WHERE valor_parametro.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"]."
                AND parametros.id_parametro in(".$loIdParametros.")";
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loGrid = null;
        foreach ($query as $row) {   

             $loGrid[] = array(
                    'id_parametro'     => $row["id_parametro"] 
                    ,'id_vlr_parametro' => $row["id_vlr_parametro"] 
                    ,'nome'             => $row["nome"]
                    ,'valor'            => $row["valor"]

             );  

        }
        return $loGrid;  
   }

   public function ModificaVlrParametro($mbDados){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao(); 

        $loComumParametros = new comumBO();

       $loIdParametro = $mbDados["id_parametro"];
       $loIdVlrParametro = $mbDados["id_vlr_parametro"];
       $loValor = $loComumParametros->AdicionaHora($mbDados["valor"]);

       $loSqlD = "DELETE FROM valor_parametro WHERE id_vlr_parametro = ".$loIdVlrParametro;
       $queryD= $pdo->prepare($loSqlD);
       $queryD->execute();


       $loSql = "INSERT INTO 
                valor_parametro (
                        id_parametro
                        ,id_pessoa_matriz
                        ,valor
                        ,id_usuario_cad
                        ) 
                 VALUES (".$loIdParametro.",".$_SESSION["id_pessoa_matriz"].",'".$loValor."',".$_SESSION["id_usuario"].")";

       echo $loSql;
       $query= $pdo->prepare($loSql);
       $query->execute();    

       return true;             

   }




}

?>