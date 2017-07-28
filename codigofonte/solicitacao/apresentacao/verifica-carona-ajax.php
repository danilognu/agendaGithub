<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loDados = $_REQUEST["dados"];

$loCarona = new caronaBO();
$loRetrono = $loCarona->VerificaCarona($loDados);
echo json_encode($loRetrono);

?> 