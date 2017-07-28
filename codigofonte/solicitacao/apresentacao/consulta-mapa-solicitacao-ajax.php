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


if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["id_menu"])){ $loIdMenu = $_REQUEST["id_menu"]; }

if(isset($_REQUEST["ordenar"])){ $loOrdenar = $_REQUEST["ordenar"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }
if(isset($_REQUEST["dt_evento_ini"])){ $loDtEventoIni = $_REQUEST["dt_evento_ini"]; }
if(isset($_REQUEST["dt_evento_fim"])){ $loDtEventoFim = $_REQUEST["dt_evento_fim"]; }

if(isset($_REQUEST["codigo_origem"])){ $loCodigoOrigem = $_REQUEST["codigo_origem"]; }
if(isset($_REQUEST["codigo_destino"])){ $loCodigoDestino = $_REQUEST["codigo_destino"]; }

if(isset($_REQUEST["placa"])){ $loPlaca = $_REQUEST["placa"]; }
if(isset($_REQUEST["id_motorista"])){ $loIdMotorista = $_REQUEST["id_motorista"]; }

$loComum = new comumBO();

$loSolicitacao = new solicitacaoBO();

$loDadosC = array( 
            'id' => $loId 
          , 'ordenar' => $loOrdenar
          , 'situacao' => $loSituacao
          , 'dt_evento_ini' => $loDtEventoIni
          , 'dt_evento_fim' => $loDtEventoFim
          , 'codigo_origem' => $loCodigoOrigem
          , 'codigo_destino' => $loCodigoDestino
          , 'mapa_solicitacao' => 1
          , 'placa' => $loPlaca
          , 'id_motorista' => $loIdMotorista 
          , 'tela_solicitacao' => 1
    );

$loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX"  >
        <!--td > </td-->
  <?php

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => $loIdMenu 
                );

            $loItensConsulta =  $loSolicitacao->ListaItensConsulta($loDadosGrid);

                foreach ($loItensConsulta as $rowItem){
                    
                    $loItens = explode(",", $rowItem["campo_bd"]);   

                    foreach ($loItens as $item){

                        if($item == "ativo"){//verifica se é status

                            if($row["ativo"] == 1){
                                echo " <td> <span class='label label-sm label-success'> Ativo </span>  </td>";
                            }else{
                                echo " <td> <span class='label label-sm label-danger'> Desativado </span>  </td>";
                            }

                        }else{// demais itens

                            echo " <td onclick='Solicitacao.AbrirItemMapa(".$row["id_solicitacao"].");' style='cursor:pointer;'> ".$row[$item]." </td>";
                            
                        }
                    }
                }
                //Monta grid dinamica End

        ?>

    </tr>
<?php

    }
    
}

?>


