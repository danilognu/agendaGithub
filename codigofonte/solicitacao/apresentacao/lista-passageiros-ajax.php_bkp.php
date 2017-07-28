<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
<?php

$loDados = null;
if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }

if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }

$loPessoa = new pessoaBO();

?>
<table width="100%" class="table-rota bordasimples" >
    <thead>
        <tr>
            <th width="30%" >Nome  </th>
            <th width="25%" >Motorista </th> 
            <th width="10%" >A&ccedil;&atilde;o  </th> 
        </tr>
    </thead>
    <tbody  >
       <?php

            if(count($loDados) > 0 ){

                foreach ($loDados as $item){    

                      $loDadosC = array( 
                            'tipo_pessoa' => '4'
                            , 'id' => $item 
                        );

                        $loLista =  $loPessoa->ListaPessoa($loDadosC);

                        if(count($loLista) > 0 ){

                            foreach ($loLista as $row){     

                                if($row["ind_motorista"] == 1){ $loMotorista = "SIM"; }else{$loMotorista = "N&Atilde;O";}           
         ?>

                                    <tr class="odd gradeX"  >
                                        <td> <?php echo $row["nome"]; ?> </td>
                                        <td> <?php echo $loMotorista; ?> </td>
                                        <td> 
                                            <!--button type="button" onclick="Solicitacao.RemoverLinha(this);" class="btn sbold red"> 
                                                <i class="fa fa-close"></i> 
                                            </button-->
                                            <a href="#" class="btn-rota" onclick="Solicitacao.RemoverLinha(this);" ><i class="fa fa-close"></i> Remover </a>
                                            <input type="hidden" class="codigo-passageiros" value="<?php echo $row["id_pessoa"]; ?> " />
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



