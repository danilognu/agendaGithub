<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");


$loIdSolicitacao = $_REQUEST["id_solicitacao"];
$loIdMotivoCancelamento = $_REQUEST["id_motivo_cancelamento"];

$loConsulta = new solicitacaoBO();

$loDados = array( 'id_solicitacao' => $loIdSolicitacao, 'id_motivo_cancelamento' => $loIdMotivoCancelamento);
$loRetrono = $loConsulta->GravarMotivoCancelamento($loDados);

?>

