<?php
include("../../comum/comum.php");  
include("../negocio-usuario.php");


$loDados = $_REQUEST["camposMarcados"];
$loIdUsuario = $_REQUEST["id_usuario"];


$loUsuario = new usuarioBO();

$loRetrono = $loUsuario->IncluirUsuarioAutorizador($loDados,$loIdUsuario);


?>