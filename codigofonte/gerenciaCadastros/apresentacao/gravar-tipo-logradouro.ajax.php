<?php
include("../../comum/comum.php");  
include("../negocio-tipo-logradouro.php");


$loDados = $_REQUEST["dados"];

$loItens = new TipoLogradouroBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>