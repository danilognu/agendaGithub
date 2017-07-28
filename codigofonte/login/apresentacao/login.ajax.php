<?php
include("../negocio-login.php");


$loArray = $_REQUEST['query'];

$sAcao = $loArray['acao'];

$loUsuario = new usuarioBO();

$loRetronoUser = $loUsuario->VerificaUsuario($loArray);

echo json_encode($loRetronoUser);


?>