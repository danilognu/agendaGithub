<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");

$loIdDestino = $_REQUEST["id_destino"];

$loDados = array("id_destino" => $loIdDestino);

$loConsulta = new solicitacaoBO();
$loRetrono = $loConsulta->ExcluirDestinoRota($loDados);

?>