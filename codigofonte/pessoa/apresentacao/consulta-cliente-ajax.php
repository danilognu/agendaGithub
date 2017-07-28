<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-pessoa.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loCnpj = null;
$loStatus = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["cnpj"])){ $loCnpj = $_REQUEST["cnpj"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }


$loComum = new comumBO();

$loPessoa = new pessoaBO();

$loDadosC = array( 
        'tipo_pessoa' => 2
        , 'id' => $loId 
        , 'nome' => $loNome
        , 'cnpj' => $loCnpj 
        , 'status' => $loStatus
    );

$loLista =  $loPessoa->ListaPessoa($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX"   >
        <td>
            <input type="checkbox" class="checkboxes" name="checkboxes-cliente" value="<?php echo $row["id_pessoa"]; ?>" /> 
        </td>


        <?php

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => 4 
                );

            $loItensConsulta =  $loPessoa->ListaItensConsulta($loDadosGrid);

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

                            echo " <td onclick='Pessoa.AbrirItem(".$row["id_pessoa"].");' style='cursor:pointer;' > ".$row[$item]." </td>";
                            
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



