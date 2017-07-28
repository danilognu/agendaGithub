<?php
include("../../comum/comum.php");  
include("../negocio-categoria-localidades.php");


$loDados = $_REQUEST["dados"];

$loItens = new categoriaLocalidadesBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>