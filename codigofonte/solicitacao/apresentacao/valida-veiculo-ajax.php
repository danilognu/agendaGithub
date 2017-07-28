<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loDados = $_REQUEST["dados"];

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->ValidaVeiculo($loDados);
echo json_encode($loRetrono);

?> 