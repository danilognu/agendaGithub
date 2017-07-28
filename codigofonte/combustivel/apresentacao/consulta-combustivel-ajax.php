<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-combustivel.php");  ?>

<?php


$loId = null;
$loNome = null;
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }

                                            
$loComum = new comumBO();

$loModelo = new combustivelBO();

$loDadosC = array( 
            'id' => $loId 
        , 'nome' => $loNome
    );

$loLista =  $loModelo->ListaCombustivel($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX">
        <td>
            <input type="checkbox" class="checkboxes" value="1" /> </td>
        <td> <?php echo $row["id_combustivel"]; ?> </td>
        <td> <?php echo $row["nome"]; ?> </td>
        <td class="center">
        <?php if($row["ativo"] == 1){ ?>
            <span class="label label-sm label-success"> Ativo </span> 
            <?php }else{?>
            <span class="label label-sm label-danger"> Desativado </span> 
            <?php }?>
            
            </td>
        <td> 
            
            <a href="adicionar-combustivel.php?acao=U&id=<?php echo $row["id_combustivel"]; ?>" class="btn dark"> Editar
                <i class="fa fa-edit"></i>
            </a>

        </td>

    </tr>
<?php

    }
    
}

?>
                                           
        
