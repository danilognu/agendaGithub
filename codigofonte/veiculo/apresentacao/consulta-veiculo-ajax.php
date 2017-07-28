<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-veiculo.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php


$loId = null;
$loChassi = null;
$loPlaca = null;
$loStatus = null;

if(isset($_REQUEST["chassi"])){ $loChassi = $_REQUEST["chassi"]; }
if(isset($_REQUEST["placa"])){ $loPlaca = $_REQUEST["placa"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }

                                            
$loComum = new comumBO();

$loVeiculo = new veiculoBO();

$loDadosC = array( 
          'id' => $loId 
        , 'placa' => $loPlaca
        , 'chassi' => $loChassi
        , 'status' => $loStatus
    );

$loLista =  $loVeiculo->ListaVeiculo($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX" >
        <td>
            <input type="checkbox" class="checkboxes" name="checkboxes-veiculo" value="<?php echo $row["id_veiculo"]; ?>" /> </td>
 <?php

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => 5 
                );

            $loItensConsulta =  $loVeiculo->ListaItensConsulta($loDadosGrid);

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

                            echo " <td onclick='Veiculo.AbrirItem(".$row["id_veiculo"].");' style='cursor:pointer;'> ".$row[$item]." </td>";
                            
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
                                           
        
