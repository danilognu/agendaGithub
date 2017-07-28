<?php
include("../../comum/comum.php");  
include("../negocio-pessoa.php");


$loDados = $_REQUEST["dados"];

$loCliente = new pessoaBO();

$loRetrono = $loCliente->GravarCliente($loDados);

echo json_encode($loRetrono);

?>