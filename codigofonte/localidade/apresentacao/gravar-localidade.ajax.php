<?php
include("../../comum/comum.php");  
include("../negocio-localidade.php");


$loDados = $_REQUEST["dados"];

$loLocalidade = new localidadeBO();

$loRetrono = $loLocalidade->GravarLocalidade($loDados);

echo json_encode($loRetrono);

?>