<?php
include("../../comum/comum.php");  
include("../negocio-grupo-acesso.php");


$loDados = $_REQUEST["dados"];

$loGrupo = new grupoAcessoBO();

$loRetrono = $loGrupo->AlteraGrupoAcessoIdentificacao($loDados);

echo json_encode($loRetrono);

?>