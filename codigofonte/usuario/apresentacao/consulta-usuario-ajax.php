<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../negocio-usuario.php");  ?>

<?php

$filtroStatus = "";
if(isset($_REQUEST["filtroStatus"])){
    $filtroStatus = $_REQUEST["filtroStatus"];
}else{
     $filtroStatus = 1;
}

if(isset($_REQUEST["status"])){
    $filtroStatus = $_REQUEST["status"];
}

?>


        <?php
        //Lista Menu
        $loUsuario = new usuarioBO();

        $loDadosC = array( 
                'tipo' => 'consulta'
                , 'id' => '' 
                , 'filtroStatus' => $filtroStatus 
            );

        $loListaMenu =  $loUsuario->ListaUsuarios($loDadosC);

        if(count($loListaMenu) > 0 ){

            foreach ($loListaMenu as $row){
                
            ?>
        
            
            <tr class="odd gradeX"  onclick="Usuario.AbrirItem(<?php echo $row["id_usuario"]; ?>);" style="cursor:pointer;">
                <td></td>
                <td width="40%"> <?php echo utf8_encode($row["nome"]); ?> </td>
                <td width="20%"> <?php echo $row["login"]; ?> </td>
                <td width="30%"> <?php echo $row["email"]; ?> </td>
                <td class="center" width="10%" >
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








        


