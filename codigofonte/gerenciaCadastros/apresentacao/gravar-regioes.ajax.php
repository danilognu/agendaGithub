<?php
include("../../comum/comum.php");  
include("../negocio-regioes.php");


$loDados = $_REQUEST["dados"];

$loItens = new regioesBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>