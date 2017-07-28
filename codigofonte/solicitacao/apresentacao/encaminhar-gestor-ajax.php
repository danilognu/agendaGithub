<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php"); 

$loIdSolicitacao = $_REQUEST["id_solicitacao"];
$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->EncaminharGestorAutorizador($loIdSolicitacao);
$loRetrono = $loSolicitacao->EncaminharGestorOperador($loIdSolicitacao);


echo json_encode($loRetrono);

?>