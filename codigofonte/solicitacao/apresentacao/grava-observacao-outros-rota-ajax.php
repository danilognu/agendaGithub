<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");


$loIdDestino = $_REQUEST["id_destino"];
$loObs = $_REQUEST["obs"];

$loConsulta = new solicitacaoBO();

$loDados = array( 'id_destino' => $loIdDestino, 'obs' => $loObs);
$loRetrono = $loConsulta->GavaAtendimentoRotasObsOutros($loDados);

?>

