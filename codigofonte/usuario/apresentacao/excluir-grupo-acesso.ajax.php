<?php
include("../../comum/comum.php");  
include("../negocio-grupo-acesso.php");


$loDados = $_REQUEST["id_grupo"];

$loGrupo = new grupoAcessoBO();

$loRetrono = $loGrupo->ExcluirGrupo($loDados);

//echo json_encode($loRetrono);

?>