<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-localidade.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loStatus = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }


$loComum = new comumBO();

$loLocalidade = new localidadeBO();

$loDadosC = array( 
            'id' => $loId 
        , 'nome' => $loNome
        , 'status' => $loStatus
    );

$loLista =  $loLocalidade->ListaLocalidade($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX"  >
        <td>
            <input type="checkbox" class="checkboxes" name="checkboxes-localidade" value="<?php echo $row["id_localidade"]; ?>" /> </td>
  <?php

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => 11 
                );

            $loItensConsulta =  $loLocalidade->ListaItensConsulta($loDadosGrid);

                foreach ($loItensConsulta as $rowItem){
                    
                    $loItens = explode(",", $rowItem["campo_bd"]);   

                    foreach ($loItens as $item){



                        switch ($item) {
                            case "ativo":
                            
                                if($row["ativo"] == 1){
                                    echo " <td> <span class='label label-sm label-success'> Ativo </span>  </td>";
                                }else{
                                    echo " <td> <span class='label label-sm label-danger'> Desativado </span>  </td>";
                                }

                            break;
                            case "telefone":
                                echo " <td onclick='Localidade.AbrirItem(".$row["id_localidade"].");' style='cursor:pointer;' > (".$row["telefone_dd"].") ".substr($row["telefone"], 0, 4)."-".substr($row["telefone"], 4, 10)." </td>"; 
                            break;
                            case "garagem":
                                
                                if($row["garagem"] == "S"){ $loGaragemSN = "SIM"; }else{$loGaragemSN = "N&Atilde;O";}
                                echo " <td onclick='Localidade.AbrirItem(".$row["id_localidade"].");' style='cursor:pointer;' >".$loGaragemSN."</td>"; 
                            break;                            
                            default:
                                echo " <td onclick='Localidade.AbrirItem(".$row["id_localidade"].");' style='cursor:pointer;' > ".$row[$item]." </td>";

                        }


                       /*if($item == "ativo"){//verifica se é status

                            if($row["ativo"] == 1){
                                echo " <td> <span class='label label-sm label-success'> Ativo </span>  </td>";
                            }else{
                                echo " <td> <span class='label label-sm label-danger'> Desativado </span>  </td>";
                            }

                        }else{// demais itens

                            echo " <td onclick='Localidade.AbrirItem(".$row["id_localidade"].");' style='cursor:pointer;'> ".$row[$item]." </td>";
                            
                        }*/
                    }
                }
                //Monta grid dinamica End

        ?>

    </tr>
<?php

    }
    
}

?>


