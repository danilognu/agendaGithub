<?php
include("../../comum/comum.php");  
include("../negocio-centro-de-custo.php");


$loDados = $_REQUEST["dados"];

$loItens = new centroDeCustoBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>