<?php
include("../../comum/comum.php");  
include("../negocio-localidade.php");


$loDados = $_REQUEST["Dados"];

$loConsulta = new localidadeBO();

$loRetrono = $loConsulta->AlteraConsultaCliente($loDados);



?>