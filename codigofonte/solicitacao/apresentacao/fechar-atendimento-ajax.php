<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");

$loIdSolicitacao = $_REQUEST["id_solicitacao"];
$loConsulta = new solicitacaoBO();
$loRetrono = $loConsulta->FechaSolicitacao($loIdSolicitacao);

?>