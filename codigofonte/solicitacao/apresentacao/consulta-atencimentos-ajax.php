<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-solicitacao.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loSituacao = null;
$loIdMenu = null;
$loLimit = 20;
$loIndCarona = 0;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }else{ $loSituacao = "2,3,6,7"; }
if(isset($_REQUEST["id_menu"])){ $loIdMenu = $_REQUEST["id_menu"]; }

if(isset($_REQUEST["ind_carona"])){ $loIndCarona = $_REQUEST["ind_carona"]; }

if(isset($_REQUEST["not_limit"])){$loLimit = 0;}


//Verifica Grupo Acesso Usuario
$loGrupoAcessoUser = $loSolicitacao->VerificaGrupoAcessoUsuario();
$loGrupoAcessoOperador = $loGrupoAcessoUser["ind_operador"];



$loComum = new comumBO();

$loSolicitacao = new solicitacaoBO();

$loDadosC = array( 
            'id' => $loId 
          , 'situacao'   => $loSituacao
          , 'not_limit'  => $loLimit
          , 'ind_carona' => $loIndCarona
          , 'tela_atendimento' => 1
    );

$loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX"  >
        <td style="width:1px;"> </td>
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

                            ?>
                            <td onclick="Solicitacao.AbrirItemAtendimento(<?php echo $row["id_solicitacao"];?>);" style="cursor:pointer;"> 
                                <?php echo $row[$item];?> 
                                <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
                            </td>
                            <?php
                            
                        }
                    }

   
               }


                //echo "<td>".$loIndCarona.",".$loCaronaPendente."</td>";
                if($loGrupoAcessoOperador == 1){

                   $loDadosS = array("id_solicitacao" => $row["id_solicitacao"], 'status' => 'S' );
                   $loRetornoS = $loSolicitacao->ListaCaronasSolicitadas($loDadosS);
                   $loBtnExibeCarona = false;
                   if(count($loRetornoS) > 0){
                       foreach ($loRetornoS as $loItemSolicCarona){
                           if( $loItemSolicCarona["status"] == "" || $loItemSolicCarona["status"] == "S" ){
                                $loBtnExibeCarona = true; 
                           }
                       }
                   } 

                   if( $loBtnExibeCarona ) {
                        echo " <td>  
                                <div class='btn-group btn-group-sm btn-group-solid'>";
                                        echo  "<button value='".$row["id_solicitacao"]."' class='btn btn-success verificar-caronas'>Verificar <i class='fa fa-check'></i></button>";
                        echo "</div> 
                        </td>"; 
                    }else{
                        echo "<td></td>";
                    }
                }
                //Monta grid dinamica End

        ?>

    </tr>
<?php

    }
    
}

?>


