<?php
include("../../comum/comum.php");  
include("../negocio-projetos.php");


$loDados = $_REQUEST["dados"];

$loItens = new projetosBO();

$loRetrono = $loItens->Gravar($loDados);

echo json_encode($loRetrono);

?>