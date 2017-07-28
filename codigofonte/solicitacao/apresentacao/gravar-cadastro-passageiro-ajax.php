<?php
include("../../comum/comum.php");  
include("../../pessoa/negocio-pessoa.php");

$loDados = $_REQUEST["dados"];

$loPessoa = new pessoaBO();
$loRetrono = $loPessoa->GravarMotoristaPassageiro($loDados);

//Bsuca Dados Passageiro
$loDadosPessoa = $loPessoa->ListaPessoa($loRetrono); 

$loNomePassageiro = $loDadosPessoa[0]["nome"];
$someArray=array('nome'=> $loNomePassageiro )+$loRetrono;

echo json_encode($someArray);

?>