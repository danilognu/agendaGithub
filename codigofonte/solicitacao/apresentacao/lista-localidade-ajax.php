<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-solicitacao.php");  ?>
<?php

$loDados = null;
$loConsulta = null;
if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }
if(isset($_REQUEST["consulta"])){ $loConsulta = $_REQUEST["consulta"]; }
if(isset($_REQUEST["id_solicitacao"])){ $loIdsolicitacao = $_REQUEST["id_solicitacao"]; }

$loSolicitacao= new solicitacaoBO();

?>
<!--h5><?php //echo $loConsulta; ?></h5-->

<table width="100%" class="table-rota bordasimples" >
    <thead>
        <tr>
            <th width="80%" >Nome </th>
            <th width="10%" >A&ccedil;&atilde;o </th> 
        </tr>
    </thead>
    <tbody  >
       <?php

            if(count($loDados) > 0 ){

                foreach ($loDados as $item){    

                      $loDadosC = array( 
                             'id_localidade' => $item
                             ,'id_solicitacao' => ''
                        );


                        $loLista =  $loSolicitacao->ListaLocalidade($loDadosC);

                        if(count($loLista) > 0 ){

                            foreach ($loLista as $row){     

                                if( $loConsulta == "paradas"){ 
                                    $value = $row["id_localidade"].":".$row["id_destino"];
                                    $onclick = "Solicitacao.RemoverLinhaParadas(this,".$row["id_destino"].");"; 
                                }else{ 
                                    $value = $row["id_localidade"]; 
                                    $onclick = "Solicitacao.RemoverLinha(this);";
                                }

         ?>

                                    <tr class="odd gradeX"  >
                                        <td> <?php echo $row["nome"]; ?> - <?php echo $row["endereco"]; ?> </td>
                                        <td> 
                                            <!--button type="button" onclick="<?php //echo $onclick;?>" class="btn sbold red"> 
                                                <i class="fa fa-close"></i>
                                            </button-->
                                             <a href="#" class="btn-rota" onclick="<?php echo $onclick;?>" ><i class="fa fa-close"></i> Remover </a>
                                             <input type="hidden" class="codigo-localidade-<?php echo $loConsulta; ?>" value="<?php echo $value;?>" />
                                         </td>
                                    </tr>

       <?php
                        }
                    }
                }
                
            }
            ?>
    </tbody>
</table>



