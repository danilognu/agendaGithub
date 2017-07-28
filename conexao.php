<?php

try {
    $hostname = "integradorbd.mysql.dbaas.com.br";
    $dbname = "integradorbd";
    $username = "integradorbd";
    $pw = "Admin123";
    $pdo = new PDO ("mysql:host=".$hostname.";dbname=".$dbname."", $username, $pw); 
  } catch (PDOException $e) {
    echo "Erro de Conexão " . $e->getMessage() . "\n";
    exit;
  }

/*
//Caso senha seja esquecida
$losenha = md5('adm456');
//altera senha adm
echo ="UPDATE usuario set senha = '".$losenha."' where id_usuario = 1";
*/

?>