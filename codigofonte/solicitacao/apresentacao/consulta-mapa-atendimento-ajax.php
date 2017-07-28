<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-solicitacao.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loStatus = null;
$loIdMenu = null;
$loOrdenar = null;
$loSituacao = null;
$loDtEventoIni = null;
$loDtEventoFim = null;
$loDtEventoFim = null;
$loCodigoOrigem = null;
$loCodigoDestino = null;
$loPlaca = null;
$loIdMotorista = null;
$loLimit = 20;


if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["id_menu"])){ $loIdMenu = $_REQUEST["id_menu"]; }

if(isset($_REQUEST["ordenar"])){ $loOrdenar = $_REQUEST["ordenar"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }
if(isset($_REQUEST["dt_evento_ini"])){ $loDtEventoIni = $_REQUEST["dt_evento_ini"]; }
if(isset($_REQUEST["dt_evento_fim"])){ $loDtEventoFim = $_REQUEST["dt_evento_fim"]; }
if(isset($_REQUEST["codigo_origem"])){ $loCodigoOrigem = $_REQUEST["codigo_origem"]; }
if(isset($_REQUEST["codigo_destino"])){ $loCodigoDestino = $_REQUEST["codigo_destino"]; }

if(isset($_REQUEST["ind_carona"])){ $loIndCarona = $_REQUEST["ind_carona"]; }



if(isset($_REQUEST["placa"])){ $loPlaca = $_REQUEST["placa"]; }
if(isset($_REQUEST["id_motorista"])){ $loIdMotorista = $_REQUEST["id_motorista"]; }

if(isset($_REQUEST["not_limit"])){$loLimit = 0;}

$loComum = new comumBO();

$loSolicitacao = new solicitacaoBO();

$loDadosC = array( 
            'id' => $loId 
          , 'ordenar' => $loOrdenar
          , 'situacao' => '2,3,6,7'
          , 'dt_evento_ini' => $loDtEventoIni
          , 'dt_evento_fim' => $loDtEventoFim
          , 'codigo_origem' => $loCodigoOrigem
          , 'codigo_destino' => $loCodigoDestino
          , 'not_limit'  =>$loLimit
          , 'placa'  => $loPlaca
          , 'id_motorista' => $loIdMotorista
          , 'tela_atendimento' => 1
    );


$loLista =  $loSolicitacao->ListaMapaAtendimentos($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX" onclick="Solicitacao.AbrirItemMapa(<?php echo $row["id_solicitacao"];?>);" style="cursor:pointer;"  >
        <td > <?php echo $row["id_solicitacao"]; ?> </td>
        <td > <?php echo $row["nome_setor"]; ?> </td>
        <td > <?php echo $row["dt_saida"]; ?> </td>
        <td > <?php echo $row["dt_retorno_prev"]; ?> </td>
        <td > <?php echo $row["placa"]; ?> </td>
        <td > <?php echo $row["nome_motorista"]; ?> </td>
        <td > <?php echo $row["destino"]; ?> </td>
    </tr>
<?php

    }
    
}

?>


