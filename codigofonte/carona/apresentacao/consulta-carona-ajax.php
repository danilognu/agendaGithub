<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-carona.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loSituacao = null;
$loIdMenu = null;
$loLimit = 20;
$loDataSaida = null;
$loOrigem = null;
$loDataRetorno = null;
$loDestino = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }
if(isset($_REQUEST["id_menu"])){ $loIdMenu = $_REQUEST["id_menu"]; }
if(isset($_REQUEST["not_limit"])){$loLimit = 0;}

if(isset($_REQUEST["data-saida"])){ $loDataSaida = $_REQUEST["data-saida"]; }
if(isset($_REQUEST["select-origem"])){ $loOrigem = $_REQUEST["select-origem"]; }
if(isset($_REQUEST["data-retorno"])){ $loDataRetorno = $_REQUEST["data-retorno"]; }
if(isset($_REQUEST["select-destino"])){ $loDestino = $_REQUEST["select-destino"]; }


$loComum = new comumBO();
$loCarona = new caronaBO();


$loDadosC = array( 
            'id'                 => $loId 
          , 'situacao'           => $loSituacao
          , 'not_limit'          => $loLimit
          , 'dt_saida'           => $loDataSaida
          , 'dt_retorno_prev'    => $loDataRetorno
          , 'codigo_origem'      => $loOrigem
          , 'codigo_destino'     => $loDestino
    );

$loLista =  $loCarona->ListaCarona($loDadosC);


if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
        $loLiberaSolicitacao = true;
        if($row["qtd_passageiro_veiculo"] > 0){ if($row["qtd_passageiro_solicitacao"] >= $row["qtd_passageiro_veiculo"]){ $loLiberaSolicitacao = false; } }


        if($loLiberaSolicitacao){

            $loQtd_passageiro_veiculo = $row["qtd_passageiro_veiculo"];
            if($row["qtd_passageiro_veiculo"] == ""){ $loQtd_passageiro_veiculo = 0; }
            $loQtdVagasDispVeiculo  = $loQtd_passageiro_veiculo-$row["qtd_passageiro_solicitacao"];

    ?>

    <tr class="odd gradeX"  >
        <!--td></td-->

        <td style="cursor:pointer;"> 
            <ul class="nav nav-tabs">
                    <li class="dropdown btn-group btn-group-sm btn-group-solid">
                        <a href="javascript:;" class="btn grey-mint dropdown-toggle" data-toggle="dropdown"> 
                        <i class="fa fa-eye"></i> Qtd Disp:<?php echo $loQtdVagasDispVeiculo;?>                         
                        </a>
                        <ul class="dropdown-menu" role="menu">

                            <?php
                                $loListaPassageiros = $loCarona->ListaPassageiros($row["id_solicitacao"]);
                                if(count($loListaPassageiros) > 0 ){
                                    foreach ($loListaPassageiros as $rowPassageiros){

                                        if($rowPassageiros["motorista"] == 1){
                                            ?> 
                                            <li>
                                                <strong>Motorista:</strong> <br /> 
                                                <a href="#tab_1_3" tabindex="-1" data-toggle="tab"> <?php echo  $rowPassageiros["nome"]; ?> </a>
                                                <strong>Passageiros:</strong> <br /> 
                                            </li>                                            
                                            <?php
                                        }else{
                                            ?> 
                                            <li>                                                
                                                <a href="#tab_1_3" tabindex="-1" data-toggle="tab"> <?php echo  $rowPassageiros["nome"]; ?> </a>
                                            </li>                                            
                                            <?php
                                        }
                            ?>
                            <?php
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
        </td>    

        <td class="btn-group btn-group-sm btn-group-solid" style="cursor:pointer;"> 
            <ul class="nav nav-tabs">
                    <li class="dropdown btn-group btn-group-sm btn-group-solid">
                        <a href="javascript:;" class="btn grey-mint dropdown-toggle" data-toggle="dropdown"> 
                        <i class="fa fa-eye"></i> Qtd:<?php echo $row["qtd_destinos"];?>         
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <?php
                                $loListaDestinos = $loCarona->ListaDestino($row["id_solicitacao"]);
                                if(count($loListaDestinos) > 0 ){
                                    foreach ($loListaDestinos as $rowDestinos){

                                        if($rowDestinos["origem"] == 1){
                                            ?>
                                                <li>
                                                   <strong>Origem:</strong> <br /> 
                                                   <a href="#tab_1_3" tabindex="-1" data-toggle="tab"><?php echo  $rowDestinos["nome"]." - ".$rowDestinos["endereco"]; ?> </a>
                                                   <strong>Destinos:</strong> <br />
                                                </li>
                                            <?php    
                                        }else{
                                            ?>
                                                 <li>
                                                    <a href="#tab_1_3" tabindex="-1" data-toggle="tab"> <?php echo  $rowDestinos["nome"]." - ".$rowDestinos["endereco"]; ?> </a>
                                                </li>
                                            <?php
                                        }
                            ?>
                            <?php
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                </ul>            
        </td>    

        <td > 
            <?php echo $row["id_solicitacao"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>

        <td > 
            <?php echo $row["nome_requisitante"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>

        <td> 
            <?php echo $row["dt_saida"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>  

        <td> 
            <?php echo $row["dt_retorno_prev"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>    

        <td> 
            <?php echo $row["nome_localidade_origem"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>  

        <td> 
            <?php echo $row["ultimo_destino"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>          

        <td> 
            <?php echo $row["nome_motorista"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>  

        <td> 
            <?php echo $row["status_solicitacao"];?> 
            <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
        </td>       


        <td class="btn-group btn-group-sm btn-group-solid"> 
            <?php if($row["carona_solicitada"] == 0){ ?>
                <button type="button" class="btn sbold dark" title="Enviar Solicitacao" onclick="Carona.EnviaEmailAutorizador(<?php echo $row["id_pessoa_requisitante"];?>,<?php echo $row["id_solicitacao"];?>);" ><i class="fa fa-mail-forward"></i> </button>
            <?php }else{ 
                        $loDadosS = array("id_solicitacao" => $row["id_solicitacao"]);
                        $loItensCarona = $loCarona->ListaCaronasSolicitadas($loDadosS);
                        if($loItensCarona[0]["status"] == "S"){
                            echo "<span class='label label-sm label-warning'> <strong>Solicitado<strong> </span>";
                        }
                        if($loItensCarona[0]["status"] == "A"){
                            echo "<span class='label label-sm label-success'> <strong>Aprovado<strong> </span>";
                        }
                        if($loItensCarona[0]["status"] == "C"){
                            echo "<span class='label label-sm label-danger'> <strong>Negado<strong> </span>";
                        } 
             } ?>
        </td>                                                   

    </tr>
<?php

        }
    }
    
}

?>

