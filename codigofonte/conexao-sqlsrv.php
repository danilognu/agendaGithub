<?php

Class ConexaoSqlSrv{

    public function IniciaConexaoSqlSrv(){   

       try {
            $hostname = "srvaqabd";
            $dbname = "etools_lets";
            $username = "euroitlogin";
            $pw = "Admin123#";
            //$pdo = new PDO ("mysql:host=".$hostname.";dbname=".$dbname."", $username, $pw); 
            $pdo = new PDO("sqlsrv:Server=".$hostname.";Database=".$dbname."", $username, $pw);
        } catch (PDOException $e) {
            echo "Erro de Conexão " . $e->getMessage() . "\n";
            exit;
        }

        return $pdo;

    }

}

//$loConexao = new ConexaoSqlSrv();
//$pdo = $loConexao->IniciaConexaoSqlSrv();



/*$loSql = "SELECT A009_cd_veiculo FROM T009_VEICULO WHERE A009_placa_veiculo = 'BAK6237' "  ;

$query= $pdo->prepare($loSql);
$query->execute();    

$loVeiculos = null;
foreach ($query as $row) { 

    echo $row["A009_cd_veiculo"];  
}*/



?>