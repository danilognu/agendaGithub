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

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }
if(isset($_REQUEST["id_menu"])){ $loIdMenu = $_REQUEST["id_menu"]; }
if(isset($_REQUEST["not_limit"])){$loLimit = 0;}


$loComum = new comumBO();
$loSolicitacao = new solicitacaoBO();


$loDadosC = array( 
            'id' => $loId 
          , 'situacao' => $loSituacao
          , 'not_limit'  =>$loLimit
          , 'tela_solicitacao' => 1
    );

$loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX"  >
        <td></td>
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
                            <td onclick="Solicitacao.AbrirItem(<?php echo $row["id_solicitacao"];?>);" style="cursor:pointer;"> 
                                <?php echo $row[$item];?> 
                                <span style="visibility: hidden;" ><?php echo $row["id_solicitacao"];?></span> 
                            </td>
                            <?php
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

