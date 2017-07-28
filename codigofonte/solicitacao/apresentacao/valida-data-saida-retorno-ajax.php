<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loDataRetornoPrevisto = $_REQUEST["dataRetornoPrevisto"];
$loDataSaida = $_REQUEST["dataSaida"];

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->ValidaDataSaidaRetorno($loDataRetornoPrevisto,$loDataSaida);
echo json_encode($loRetrono);

?> 