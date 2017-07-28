<?php
include("../../comum/comum.php");  
include("../negocio-motivo-nao-planejamento.php");


$loDados = $_REQUEST["dados"];

$loItens = new motivoNaoPlanejamentoBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>