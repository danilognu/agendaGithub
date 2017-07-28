<?php

Class Conexao{

    public function IniciaConexao(){   

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

?>