<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../modelo-configuracao.php");  ?>
<?php

$loIdParametro = NULL; 
$loIdVlrParametro = NULL;
$loValor = NULL;

if(isset($_REQUEST["id_parametro"])){ $loIdParametro = $_REQUEST["id_parametro"]; }
if(isset($_REQUEST["id_vlr_parametro"])){ $loIdVlrParametro = $_REQUEST["id_vlr_parametro"]; }
if(isset($_REQUEST["valor"])){ $loValor = $_REQUEST["valor"]; }


$loConfiguracao = new configuracaoBO();

$loDados = array( 
            'id_parametro' => $loIdParametro 
          , 'id_vlr_parametro' => $loIdVlrParametro
          , 'valor'  =>$loValor
    );

$loRetorno = $loConfiguracao->ModificaVlrParametro($loDados);

return $loRetorno;

?>
