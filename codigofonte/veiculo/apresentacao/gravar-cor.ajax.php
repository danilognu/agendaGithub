<?php
include("../../comum/comum.php");  
include("../negocio-cor.php");


$loDados = $_REQUEST["dados"];

$loCliente = new corBO();

$loRetrono = $loCliente->GravarCor($loDados);

echo json_encode($loRetrono);

?>