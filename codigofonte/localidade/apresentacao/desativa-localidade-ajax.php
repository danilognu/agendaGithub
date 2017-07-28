<?php
include("../../comum/comum.php");  
include("../negocio-localidade.php");

if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }else{$loDados = null;}

$loLocalidade = new localidadeBO();
$loRetrono = $loLocalidade->DesativarLocalidade($loDados);
echo json_encode($loRetrono);
?>