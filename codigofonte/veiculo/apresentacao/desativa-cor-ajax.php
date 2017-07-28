<?php
include("../../comum/comum.php");  
include("../negocio-cor.php");

if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }else{$loDados = null;}

$loCor = new corBO();
$loRetrono = $loCor->DesativarCor($loDados);
echo json_encode($loRetrono);
?>