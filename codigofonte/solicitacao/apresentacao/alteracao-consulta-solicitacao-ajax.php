<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");


$loDados = $_REQUEST["Dados"];

$loConsulta = new solicitacaoBO();

$loRetrono = $loConsulta->AlteraConsultaSolicitacao($loDados);



?>