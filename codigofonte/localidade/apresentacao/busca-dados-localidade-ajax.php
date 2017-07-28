<?php
include("../../comum/comum.php");  
include("../negocio-pessoa.php");


$loDados = $_REQUEST["dados"];

$loCliente = new pessoaBO();

$loRetrono = $loCliente->ListaPessoa($loDados);

$loNome = null;
if(count($loRetrono) > 0){
    foreach ($loRetrono as $row){

        $loNome = $row["nome"];
    }
}
echo json_encode($loNome);

?>