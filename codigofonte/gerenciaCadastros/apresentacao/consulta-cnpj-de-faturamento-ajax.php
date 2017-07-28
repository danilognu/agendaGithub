<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../negocio-cnpj-de-faturamento.php");  ?>

<?php

$loStatus = 1;
if(isset($_REQUEST["status"])){
    $loStatus = $_REQUEST["status"];
}



$loCnpj = "";
if(isset($_REQUEST["cnpj"])){
    $loCnpj = $_REQUEST["cnpj"];
}

?>

        <?php
        //Lista Menu
        $loItens = new cnpjDeFaturamentoBO();

        $loDadosC = array( 
                'id' => ''
                , 'cnpj' => $loCnpj 
                , 'status' => $loStatus 
            );


        $loLista =  $loItens->Consultar($loDadosC);

        if(count($loLista) > 0 ){

            foreach ($loLista as $row){

                
            ?>
        
            
            <tr class="odd gradeX"  onclick="CentroDeCusto.AbrirItem(<?php echo $row["id"]; ?>);" style="cursor:pointer;">
                <td width="01%"> <?php echo $row["id"]; ?> </td>
                <td width="20%"> <?php echo $loItens->mask($row["cnpj"],'##.###.###/####-##'); ?> </td>
                <td width="70%"> <?php echo $row["descricao"]; ?> </td>
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








        


