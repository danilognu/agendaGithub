<?php
include("../../comum/comum.php");  
include("../negocio-combustivel.php");

if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }else{$loDados = null;}

$loCombustivel = new combustivelBO();
$loRetrono = $loCombustivel->DesativarCombustivel($loDados);
echo json_encode($loRetrono);
?>