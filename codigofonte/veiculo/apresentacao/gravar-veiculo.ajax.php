<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-veiculo.php");


$loDados = $_REQUEST["dados"];

$loVeiculo = new veiculoBO();

$loRetrono = $loVeiculo->GravarVeiculo($loDados);

echo json_encode($loRetrono);

?>