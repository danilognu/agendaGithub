<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../negocio-setor.php");  ?>
<?php

$loStatus = 1;
if(isset($_REQUEST["status"])){
    $loStatus = $_REQUEST["status"];
}



$loNome = "";
if(isset($_REQUEST["nome"])){
    $loNome = $_REQUEST["nome"];
}

?>

        <?php
        //Lista Menu
        $loSetor = new setorBO();

        $loDadosC = array( 
                'id' => ''
                , 'nome' => $loNome 
                , 'status' => $loStatus 
            );


        $loLista =  $loSetor->ListaSetor($loDadosC);

        if(count($loLista) > 0 ){

            foreach ($loLista as $row){
                
            ?>
        
            
            <tr class="odd gradeX"  onclick="Setor.AbrirItem(<?php echo $row["id_setor"]; ?>);" style="cursor:pointer;">
                <td width="01%"> <?php //echo $row["id_setor"]; ?> </td>
                <td width="70%"> <?php echo $row["nome"]; ?> </td>
                <td class="center">
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








        


