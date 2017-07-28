<?php
include("../negocio-login.php");

$loEmail = $_REQUEST["email"];

$loUsuario = new usuarioBO();

$loDadosC = array( 'email' => $loEmail );
$loRetorno = $loUsuario->VerificaEmail($loDadosC);

echo json_encode($loRetorno);

?>