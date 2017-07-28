<?php
include("../../comum/comum.php");  
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php");

$loIdMotorista = $_REQUEST["id_motorista"];

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->ValidaMotorista($loIdMotorista);
echo json_encode($loRetrono);

?> 