<?php

Class Conexao{

    public function IniciaConexao(){   

       try {
            $hostname = "localhost";
            $dbname = "agenda_lets";
            $username = "root";
            $pw = "";
            $pdo = new PDO ("mysql:host=".$hostname.";dbname=".$dbname."", $username, $pw); 
        } catch (PDOException $e) {
            echo "Erro de Conexão " . $e->getMessage() . "\n";
            exit;
        }

        return $pdo;

    }

}



?>