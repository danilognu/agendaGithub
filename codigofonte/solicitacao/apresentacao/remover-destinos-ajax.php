<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loDados = $_REQUEST["id_destino"];

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->RemoveDestino($loDados);

?> 