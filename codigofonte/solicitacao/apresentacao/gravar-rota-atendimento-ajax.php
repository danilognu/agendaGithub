<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");


$loDados = $_REQUEST["dados"];

$loConsulta = new solicitacaoBO();

$loRetrono = $loConsulta->GavaAtendimentoRotas($loDados);

echo json_encode($loRetrono);

?>