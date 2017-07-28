<?php
include("../../comum/comum.php");  
include("../../localidade/negocio-localidade.php"); 

$loDados = $_REQUEST["dados"];

$loLocalidade = new localidadeBO();
$loRetrono = $loLocalidade->GravarLocalidade($loDados);

//Bsuca Dados Localidade
$loDadosLocalidade = $loLocalidade->ListaLocalidade($loRetrono); 


$loNome = utf8_encode($loDadosLocalidade[0]["nome"]);
$loCidadeEstado = $loDadosLocalidade[0]["nome_cidade"]."/".$loDadosLocalidade[0]["uf"];
$someArray=array('nome'=> $loNome, 'cidadeEstado'=> $loCidadeEstado )+$loRetrono;

echo json_encode($someArray);

?>