<?php
include("../../comum/comum.php");  
include("../negocio-modelo.php");

if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }else{$loDados = null;}

$loModelo = new modeloBO();
$loRetrono = $loModelo->DesativarModelo($loDados);
echo json_encode($loRetrono);
?>