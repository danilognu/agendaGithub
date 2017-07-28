<?php
include("../../comum/comum.php");  
include("../negocio-pessoa.php");


$loDados = $_REQUEST["Dados"];

$loConsultaCliente = new pessoaBO();

$loRetrono = $loConsultaCliente->AlteraConsultaCliente($loDados);



?>