<?php
include("../../comum/comum.php");  
include("../negocio-pessoa.php");

if(isset($_REQUEST["id_empresa"])){ $id_empresa = $_REQUEST["id_empresa"]; }else{$id_empresa = null;}

$loPessoa = new pessoaBO();
$loRetrono = $loPessoa->RemoverImagemLogo($id_empresa);
?>