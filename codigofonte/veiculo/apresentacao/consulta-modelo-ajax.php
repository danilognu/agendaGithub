<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-modelo.php");  ?>

<?php


$loId = null;
$loNome = null;
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }

                                            
$loComum = new comumBO();

$loModelo = new modeloBO();

$loDadosC = array( 
            'id' => $loId 
        , 'nome' => $loNome
    );

$loLista =  $loModelo->ListaModelo($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX">
        <td>
            <input type="checkbox" class="checkboxes" name="checkboxes-modelo" value="<?php echo $row["id_modelo"]; ?>" /> 
        </td>
        <!--td onclick="Modelo.AbrirItem(<?php //echo $row["id_modelo"]; ?>);" style="cursor:pointer;"> <?php //echo $row["id_modelo"]; ?> </td-->
        <td onclick="Modelo.AbrirItem(<?php echo $row["id_modelo"]; ?>);" style="cursor:pointer;"> <?php echo $row["nome"]; ?> </td>
        <td class="center" onclick="Modelo.AbrirItem(<?php echo $row["id_modelo"]; ?>);" style="cursor:pointer;" >
        <?php if($row["ativo"] == 1){ ?>
            <span class="label label-sm label-success"> Ativo </span> 
            <?php }else{?>
            <span class="label label-sm label-danger"> Desativado </span> 
            <?php }?>
            
            </td>

    </tr>
<?php

    }
    
}

?>
                                           
        
