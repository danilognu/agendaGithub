<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");


$loIdSolicitacao = $_REQUEST["id"];
$loStatus = $_REQUEST["status"];

$loConsulta = new solicitacaoBO();

$loRetrono = $loConsulta->AtualizaStatusSolicitacao($loIdSolicitacao,$loStatus);

?>