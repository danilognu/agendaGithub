<?php
include("../../comum/comum.php");  
include("../negocio-combustivel.php");


$loDados = $_REQUEST["dados"];

$loCliente = new combustivelBO();

$loRetrono = $loCliente->GravarCombustivel($loDados);

echo json_encode($loRetrono);

?>