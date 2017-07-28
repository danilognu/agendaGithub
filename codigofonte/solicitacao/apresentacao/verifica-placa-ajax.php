<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loPlaca = $_REQUEST["placa"];

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->ValidaPlaca($loPlaca);
echo json_encode($loRetrono);

?> 