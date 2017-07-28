<?php
include("../../comum/comum.php");  
include("../negocio-pessoa.php");

if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }else{$loDados = null;}

$loMotoristaP = new pessoaBO();
$loRetrono = $loMotoristaP->DesativarPessoa($loDados);
echo json_encode($loRetrono);
?>