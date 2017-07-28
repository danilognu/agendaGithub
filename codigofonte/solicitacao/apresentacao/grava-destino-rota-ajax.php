<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");

$loIdSolicitacao = $_REQUEST["id_solicitacao"];
$loIdLocalidade = $_REQUEST["codigoDestino"];

$loDados = array("id_solicitacao" => $loIdSolicitacao, "id_localidade" => $loIdLocalidade);

$loConsulta = new solicitacaoBO();
$loRetrono = $loConsulta->GravaDestinoRota($loDados);

?>