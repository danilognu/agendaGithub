<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-cor.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php


$loId = null;
$loNome = null;
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }

                                            
$loComum = new comumBO();

$loCor = new corBO();

$loDadosC = array( 
            'id' => $loId 
        , 'nome' => $loNome
    );

$loLista =  $loCor->ListaCor($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX" >
        <td >
            <input type="checkbox" class="checkboxes" name="checkboxes-cor" value="<?php echo $row["id_cor"]; ?>" /> 
        </td>
        <td onclick="Cor.AbrirItem(<?php echo $row["id_cor"]; ?>);" style="cursor:pointer;"> <?php echo $row["nome"]; ?> </td>
        <td class="center" onclick="Cor.AbrirItem(<?php echo $row["id_cor"]; ?>);" style="cursor:pointer;">
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
                                           
        
