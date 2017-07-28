<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");


$loDados = $_REQUEST["dados"];
$loDadosAtendimento = $_REQUEST["dadosAtendimento"];

$loCodigosParada = NULL;
if(isset($_REQUEST["codigosParada"]) && !empty($_REQUEST["codigosParada"]) ){
    $loCodigosParada = $_REQUEST["codigosParada"];
}

$loCodigosPassageiro = NULL;
if(isset($_REQUEST["codigosPassageiro"]) && !empty($_REQUEST["codigosPassageiro"]) ){
    $loCodigosPassageiro = $_REQUEST["codigosPassageiro"];
}

$loCodigosOrigem = NULL;
if(isset($_REQUEST["codigosOrigem"]) && !empty($_REQUEST["codigosOrigem"]) ){
    $loCodigosOrigem = $_REQUEST["codigosOrigem"];
}


$loSolicitacao = new solicitacaoBO();

$loRetrono = $loSolicitacao->GravarSolicitacao($loDados,$loCodigosParada,$loCodigosPassageiro,$loCodigosOrigem,$loDadosAtendimento);
echo json_encode($loRetrono);

?> 