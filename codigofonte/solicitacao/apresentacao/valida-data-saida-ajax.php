<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loDataEvento = $_REQUEST["dataEvento"];
$loDataSaida = $_REQUEST["dataSaida"];

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->ValidaDataSaida($loDataEvento,$loDataSaida);
echo json_encode($loRetrono);

?> 