<?php
include("../../comum/comum.php");  
include("../negocio-cnpj-de-faturamento.php");


$loDados = $_REQUEST["dados"];

$loItens = new cnpjDeFaturamentoBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>