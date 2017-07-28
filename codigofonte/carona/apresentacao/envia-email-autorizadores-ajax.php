<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-carona.php");

$loIdPessoaAutorizante = $_REQUEST["id_pessoa"];
$loIdSolicitacao = $_REQUEST["id_solicitacao"];

$loDados = array("id_pessoa_autorizante" => $loIdPessoaAutorizante, "id_solicitacao" => $loIdSolicitacao );

$loCarona = new caronaBO();
$loRetrono = $loCarona->EnviaEmailAutorizador($loDados);
echo json_encode($loRetrono);

?> 