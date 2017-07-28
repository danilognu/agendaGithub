<?php
include("../../comum/comum.php");  
include("../negocio-usuario.php");


$loDados = $_REQUEST["dados"];


$loUsuario = new usuarioBO();

$loRetrono = $loUsuario->ExcluirUsuarioAutorizador($loDados);

echo json_encode($loRetrono);

?>