<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");


$loIdDestino = $_REQUEST["id_destino"];
$loObs = NULL;

$loConsulta = new solicitacaoBO();

$loDados = array( 'id_destino' => $loIdDestino);
$loRetrono = $loConsulta->ListaDestinos($loDados);

 if(count($loRetrono) > 0 ){
    foreach ($loRetrono as $row){ 
        $loObs = $row["outros"];
    }
 }   
?>

<textarea rows="4" cols="55" id="textareaObsOutros" ><?php  echo $loObs; ?></textarea>