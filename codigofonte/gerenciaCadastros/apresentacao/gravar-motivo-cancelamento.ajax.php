<?php
include("../../comum/comum.php");  
include("../negocio-motivo-cancelamento.php");


$loDados = $_REQUEST["dados"];

$loItens = new motivoCancelamentoBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>