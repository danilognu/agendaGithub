<?php
include("../../comum/comum.php");  
include("../negocio-veiculo.php");

if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }else{$loDados = null;}

$loVeiculo = new veiculoBO();
$loRetrono = $loVeiculo->DesativarVeiculo($loDados);
echo json_encode($loRetrono);
?>