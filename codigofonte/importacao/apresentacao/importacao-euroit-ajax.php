<?php session_start(); ?>
<?php  include("../../conexao-sqlsrv.php");  ?>
<?php  include("../../conexao.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-importacao.php");  ?>
<?php


if(isset($_REQUEST["strPlacas"])){
    $loStrPlacas = $_REQUEST["strPlacas"];
}

$loImportacao = new importacaoBO();
$loRetorno = $loImportacao->BuscaDadosveiculos($loStrPlacas);

echo json_encode($loRetorno);


?>  
