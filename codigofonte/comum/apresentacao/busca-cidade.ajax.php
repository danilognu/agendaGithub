<?php
include("../../conexao.php");
include("../negocio-comum.php");

$loIdEstado = $_REQUEST["id_estado"];
$loIdCidade = $_REQUEST["id_cidade"];

$loListaCidade = new comumBO();
$loLista = $loListaCidade->ListaCidade($loIdEstado,$loIdCidade);

$loCidades = null;
foreach ($loLista as $row){

    $loCidades .= "<option value=".$row["id_cidade"]." >".utf8_decode($row["nome"])."</option>" ;      

}   

echo $loCidades;

?>