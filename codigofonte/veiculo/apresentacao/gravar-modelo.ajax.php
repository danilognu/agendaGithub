<?php
include("../../comum/comum.php");  
include("../negocio-modelo.php");


$loDados = $_REQUEST["dados"];

$loCliente = new modeloBO();

$loRetrono = $loCliente->GravarCliente($loDados);

echo json_encode($loRetrono);

?>