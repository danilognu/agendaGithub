<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-usuario.php");  ?>

<?php

$loNome = "";
if(isset($_REQUEST["nome"])){
    $loNome = $_REQUEST["nome"];
}

$loidUsuario = "";
if(isset($_REQUEST["id_usuario"])){
    $loidUsuario = $_REQUEST["id_usuario"];
}

echo $loidUsuario;

?>


        <?php
        //Lista Menu
        $loUsuario = new usuarioBO();

        $loDadosC = array( 
                'tipo' => 'consulta'
                , 'nome' => $loNome 
                , 'idNotUsuario' =>  $loidUsuario
            );

        $loLista =  $loUsuario->ListaUsuarios($loDadosC);

        if(count($loLista) > 0 ){

            foreach ($loLista as $row){


            $loDadosAut = array( 
                'id_usuario_alt' => $loidUsuario
                , 'id_usuario_autorizador' => $row["id_usuario"]
            );

            $loListaAutoriza =  $loUsuario->VerificaSeUsuarioAutoriza($loDadosAut);
            foreach ($loListaAutoriza as $rowAut){ $loContaAutorizador = $rowAut["conta"];  }
            if($loContaAutorizador > 0){ $CheckDisabled = "disabled"; $Title = "title='Atorizador já cadastrado'"; } else{ $CheckDisabled = ""; $Title = "";}

            ?>        
            
            <tr class="odd gradeX" <?php echo " ".$Title; ?> >
                <td>
                    <?php  if($loContaAutorizador == 0){ ?>
                    <input type="checkbox" class="checkboxes-autorizador" name="autorizadores[]" value="<?php echo $row["id_usuario"]; ?>" /> 
                    <?php }else{ ?>
                    <i class="fa fa-check" ></i>
                    <?php } ?>
                </td>
                <td> <?php echo utf8_encode($row["nome"]); ?>  </td>
                <td> <?php echo $row["login"]; ?> </td>

            </tr>



        <?php

            }
            
        }

        ?>








        


