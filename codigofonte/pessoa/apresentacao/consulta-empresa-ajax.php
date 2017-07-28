<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-pessoa.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loCnpj = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["cnpj"])){ $loCnpj = $_REQUEST["cnpj"]; }


$loComum = new comumBO();

$loPessoa = new pessoaBO();

$loDadosC = array( 
        'tipo_pessoa' => 1
        , 'id' => $loId 
        , 'nome' => $loNome
        , 'cnpj' => $loCnpj 
    );

$loLista =  $loPessoa->ListaPessoa($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX"  onclick="Pessoa.AbrirItem(<?php echo $row["id_pessoa"]; ?>);" style="cursor:pointer;" >

        <?php

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => 24 
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

                            echo " <td> ".$row[$item]." </td>";
                            
                        }
                    }
                }
                //Monta grid dinamica End

        ?>


        <?php //Antigo comentado ?>
        <!--td> <?php //echo $row["id_pessoa"]; ?> </td-->
        <!--td> <?php //echo $row["nome"]; ?> </td-->
        <!--td> <?php //echo $loComum->Mask($row["cnpj"],'##.###.###/####-##'); ?> </td>
        <!--td> <?php //echo $row["email"]; ?> </td-->
        <!--td class="center">
        <?php //if($row["ativo"] == 1){ ?>
            <span class="label label-sm label-success"> Ativo </span> 
            <?php //}else{?>
            <span class="label label-sm label-danger"> Desativado </span> 
            <?php //}?>
            
        </td-->



        <!--td> 
            
            <a href="adicionar-cliente.php?acao=U&id=<?php //echo $row["id_pessoa"]; ?>" class="btn dark"> Editar
                <i class="fa fa-edit"></i>
            </a>

        </td-->

    </tr>
<?php

    }
    
}

?>



