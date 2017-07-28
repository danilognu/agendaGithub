<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../localidade/negocio-localidade.php");  ?>
<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
<?php  include_once("../../gerenciaCadastros/negocio-motivo-nao-planejamento.php");  ?>
<?php  include_once("../negocio-solicitacao.php");  ?>


<?php

if(isset($_REQUEST["id_solicitacao"])){
    
    $loId = $_REQUEST["id_solicitacao"];
    $loNome = "";
    $loEndereco = "";

    $loLocalidade = new localidadeBO();
    $loPessoa = new pessoaBO();
    $loSolicitacao = new solicitacaoBO();
    $loMotivoNaoPlanejamento = new motivoNaoPlanejamentoBO();

}



?>

<div class="form-group">
    <div class="col-md-5">
    <strong>Adiconar Destinos</strong>
    <select class="form-control select2me" name="options2" id="select-paradas-rota" >
        <option value=""></option>
        <?php
            $loDadosCOrigem = array( 
                    'nome' => $loNome
                    , 'endereco' => $loEndereco
                    , 'status' => '1'
                );

                $loLista =  $loLocalidade->ListaLocalidade($loDadosCOrigem);

                if(count($loLista) > 0){

                    foreach ($loLista as $row){
                        ?>
                        <option value="<?php echo $row["id_localidade"].":".$row["nome"]; ?>"><?php echo $row["nome"]; ?></option>
                        <?php
                    }
                }
                        
            ?>
    </select>
    </div>

    <br />

    <div class="col-md-3">
        <a href="#" id="btn-adicionar-item-paradas-rota" class="btn btn-default"><i class="fa fa-plus"></i></i></a>
        <!--a href="#" id="pesquisa-rota-paradas-rota" class="btn btn-default paradas"><i class="fa fa-search"></i></a-->
    </div>
</div>



<table class="table table-hover tabela-rota-atendimento"   >
    <thead>
        <tr>
            <th width="20%" align="left">Localidades </th>
            <th width="10%" align="left">Dt Partida </th>
            <th width="6%" align="left">Km Saida </th>
            <th width="10%" align="left">Dt Chegada </th>
            <th width="7%" align="left">Km Chegada </th>
            <th width="7%"  align="left">Planejado </th>
            <th width="15%"  align="left">Motivo n&atilde;o Planejamento</th>
            <th width="7%"  align="left">Realizado </th>
            <th width="2%"  align="left">Outros </th>
            <th width="10%" align="left">Ac&atilde;o </th>
        </tr>
    </thead>
    <tbody  >
    <?php
                        $loDadosDestino = array( 
                        'id_solicitacao' => $loId
                        );

                    $loListaDestinos =  $loSolicitacao->ListaDestinos($loDadosDestino);

                    if(count($loListaDestinos) > 0 ){

                        foreach ($loListaDestinos as $rowDestino){               
            ?>

                                    <tr class="odd gradeX rota-itens"   >
                                    <td align="left"> <?php echo $rowDestino["nome"]; ?> <input type="hidden" name="id-destino"  value="<?php echo $rowDestino["id_destino"]; ?>"  > </td>
                                    <td class="data-partida">
                                         <span class="nao-editando"> <?php echo $rowDestino["dt_partida"]; ?> <span>
                                         <span class="editando" style="display:none;" >
                                            <input type="text" class="form-control input-sm mask_date_hora" name="data-partida"  value="<?php echo $rowDestino["dt_partida"]; ?>"  > 
                                        <span>
                                    </td>
                                    <td> <input type="text" class="form-control input-sm mask_number" name="km-partida"  value="<?php echo $rowDestino["km_saida"]; ?>" > </td>
                                    <td> <input type="text" class="form-control input-sm mask_date_hora" name="data-chegada"  value="<?php echo $rowDestino["dt_chegada"]; ?>"  > </td>
                                    <td> <input type="text" class="form-control input-sm mask_number" name="km-chegada"  value="<?php echo $rowDestino["km_chegada"]; ?>" > </td>
                                    <td> 
                                    <?php //echo "->".is_null($rowDestino["ind_planejado"]); ?>
                                        <select class="form-control input-sm" name="ind-planejado" onChange="Solicitacao.VerificaMotivoNaoPlaRota(this);" >
                                            <option value="ND"  <?php if(is_null($rowDestino["ind_planejado"])){ echo "selected"; } ?>></option>
                                            <option value="1" <?php if($rowDestino["ind_planejado"] == 1){ echo "selected"; } ?> >Sim</option>
                                            <option value="0" <?php if($rowDestino["ind_planejado"] == 0 && !is_null($rowDestino["ind_planejado"]) ){ echo "selected"; } ?> >N&atilde;o</option>
                                        </select>
                                    </td>
                                    <td>

                                    <?php if($rowDestino["id_mot_plan"] == 0 || $rowDestino["id_mot_plan"] == ""){ $disabledMot = "disabled"; }else $disabledMot = ""; ?>
                                    <select class="form-control input-sm" name="motivo-nao-plan"  <?php echo $disabledMot; ?>  >


                                            <?php 

                                                    $loDadosS = array('id' => '' );                                                                   
                                                    $loListaNaoPla =  $loMotivoNaoPlanejamento->Consultar($loDadosS);
                                                    
                                                    echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaNaoPla as $row){
                                                            
                                                            $loSelected = "";
                                                            if($rowDestino["id_mot_plan"] == $row["id"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        }     
                                            ?>

                                        </select>

                                    </td>
                                    <td> 
                                        <select class="form-control input-sm" name="ind-realizado">
                                            <option value="" if(is_null($rowDestino["ind_planejado"])){ echo "selected"; } ?> </option>
                                            <option value="1" <?php if($rowDestino["ind_realizado"] == 1){ echo "selected"; } ?> >Sim</option>
                                            <option value="0" <?php if($rowDestino["ind_realizado"] == 0 && !is_null($rowDestino["ind_realizado"])){ echo "selected"; } ?> >N&atilde;o</option>
                                        </select>

                                    </td>
                                    <td>
                                        <button type="button" class="btn default" onClick="Solicitacao.modalObsOutrosRota(this);"  ><i class="fa fa-book"></i></button>
                                    </td>
                                    <td>
                                        <button type="button" name="salvar" class="btn dark" onClick="Solicitacao.RotaItensDestino(this);"  > <i class="fa fa-save"></i></button>
                                        <button type="button" name="excluir" class="btn dark" onClick="Solicitacao.ExcluirDestino(this);"  > <i class="fa fa-times-circle"></i></button>
                                    </td>
                                </tr>

            <?php
                    }
                }
                
            ?>
    </tbody>
</table>

<?php if(isset($_REQUEST["id_solicitacao"])){ ?>
    
    <script>
        jQuery(document).ready(function() {
            FormInputMask.init(); // init metronic core componets
        });
    </script>

<?php } ?>

