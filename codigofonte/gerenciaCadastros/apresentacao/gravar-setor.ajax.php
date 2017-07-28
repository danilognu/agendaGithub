<?php
include("../../comum/comum.php");  
include("../negocio-setor.php");


$loDados = $_REQUEST["dados"];

$loSetor = new setorBO();

$loRetrono = $loSetor->GravarSetor($loDados);

echo json_encode($loRetrono);

?>