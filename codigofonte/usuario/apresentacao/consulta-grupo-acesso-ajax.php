<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../negocio-usuario.php");  ?>

<?php

/*$filtroStatus = "";
if(isset($_REQUEST["filtroStatus"])){
    $filtroStatus = $_REQUEST["filtroStatus"];
}*/
?>


        <?php
        //Lista Menu
        $loGrupo = new grupoAcessoBO();

        $loDadosC = array( 
                 'id' => '' 
            );

        $loListaMenu =  $loGrupo->ListaGrupoAcesso($loDadosC);

        if(count($loListaMenu) > 0 ){

            foreach ($loListaMenu as $row){
                
            ?>
        
            
            <tr class="odd gradeX">

                <td>
                    <input type="checkbox" class="checkboxes" value="1" /> </td>
                <td> <?php echo $row["nome"]; ?>  </td>
                <td> <button type="button" class="btn dark" onClick="GrupoAcesso.buttonAltera_onClick(<?php echo $row["id_grupo"]; ?>)" >Editar <i class="fa fa-edit"></i></button></td>
                <td> <button type="button" class="btn dark" onClick="GrupoAcesso.buttonGerenciar_onClick(<?php echo $row["id_grupo"]; ?>)" >Gerenciar <i class="fa fa-cogs"></i></button></td>
        
            </tr>



        <?php

            }
            
        }

        ?>








        


