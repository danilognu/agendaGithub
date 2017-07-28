<?php
include("../../comum/comum.php");  
include("../negocio-veiculo.php");


$loDados = $_REQUEST["Dados"];

$loConsulta = new veiculoBO();

$loRetrono = $loConsulta->AlteraConsultaCliente($loDados);



?>