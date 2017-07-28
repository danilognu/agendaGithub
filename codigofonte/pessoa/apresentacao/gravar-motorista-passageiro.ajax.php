<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-pessoa.php");


$loDados = $_REQUEST["dados"];

$loCliente = new pessoaBO();

$loRetrono = $loCliente->GravarMotoristaPassageiro($loDados);

echo json_encode($loRetrono);

?>