<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../veiculo/negocio-veiculo.php");  ?>
<?php  include_once("../../gerenciaCadastros/negocio-setor.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loNome         = null;
$loNomeFantasia = null;
$loCpf          = null;
$loCep          = null;
$loEndereco     = null;
$loBairro       = null;
$loNumero       = null;
$loIdCidade     = null;
$loIdEstado     = null; 
$loComplemento  = null;
$loTelefoneDD   = null;
$loTelefone     = null;
$loCelulaDD     = null;
$loCelula       = null;
$loEmail        = null;
$loAtivo        = "1";
$loIdTipoPessoa = null;
$loDtCadastro     = null;
$loNumHabilitacao = null;
$loOrgaoHabilitacao = null;
$loCategoriaHabilitacao = null;
$loDataValidadeHabilitacao = null;
$loIDSetor = null;
$loIdGaragem = null;
$loNomeGaragem = null;
$loEnderecoGaragem = null;
$loIdLocalidadeGaragemAtual = null;

$loIndPassageiroCheck = ""; 
$loIndMotoristaCheck = ""; 
$loIndCondutorCheck = "";
$loAcao = "I";


$loComum = new comumBO();

$loVeiculo = new veiculoBO();

?>

<br />




                    
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <!--div class="portlet">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase"> Passageiro </span>
                                    </div>
                   
                                </div-->
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                        
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Nome*</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="nome-passageiro-modal" class="form-control"  value="<?php echo $loNome; ?>" >
                                                  </div>
                                            </div>


                                        <div class="form-group">
                                                <label class="col-md-1 control-label">CPF</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="cpf-passageiro-modal" class="form-control mask_cpf"  value="<?php echo $loCpf; ?>" >
                                                  </div>
                                            </div>   


                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Cep</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="cep-passageiro-modal" class="form-control mask_cep"  value="<?php echo $loCep; ?>" >
                                                  </div>
                                            </div>   

                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Endere&ccedil;o</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="endereco-passageiro-modal" class="form-control"  value="<?php echo $loEndereco; ?>" >
                                                  </div>
                                            </div>  

                                           <div class="form-group">
                                                <label class="col-md-1 control-label">Bairro</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="bairro-passageiro-modal" class="form-control"  value="<?php echo $loBairro; ?>" >
                                                  </div>
                                                  <label class="col-md-1 control-label">Nr.</label>
                                                  <div class="col-md-2">
                                                    <input type="text" id="numero-passageiro-modal" class="form-control mask_number"  value="<?php echo $loNumero; ?>" >
                                                  </div>
                                            </div>   


                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Estado</label>
                                                <div class="col-md-2">

                                                    <select class="form-control" nome="estado" id="estado" onchange="loacalizaCidadeSelect('');">
                                                    
                                                    <?php 

                                                        $loListaEstado = new comumBO();
                                                        
                                                        $loLista =  $loListaEstado->ListaEstado("");
                                                       
                                                       echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loLista as $row){
                                                            
                                                            $loSelected = "";
                                                            if($loIdEstado == $row["id_estado"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id_estado"]." ".$loSelected." >".$row["uf"]."</option>" ;      

                                                        }     
                                                    ?>
                                                    
                                                    </select>

                                                  </div>
                                                  <label class="col-md-1 control-label">Cidade</label>
                                                  <div class="col-md-5">

                                                    <select class="form-control" nome="cidade" id="cidade" class="cidade cidade-passageiro-modal" >
                                                    </select>


                                                  </div>
                                            </div>  
                                            
         
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Telefone*</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="telefone-passageiro-modal" class="form-control mask_telefone"  value="<?php echo $loTelefoneDD."".$loTelefone; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Celular </label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="celular-passageiro-modal" class="form-control mask_celular"  value="<?php echo $loCelulaDD."".$loCelula; ?>" >
                                                  </div>
                                            </div>



                                       <div class="form-group">
                                                <label class="col-md-1 control-label">E-mail*</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="email" id="email-passageiro-modal" class="form-control"  value="<?php echo $loEmail; ?>" > </div>
                                                </div>
                                            </div>

              
                                         

                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Setor</label>
                                                <div class="col-md-9">

                                                    <select class="form-control" id="setor-passageiro-modal" >
                                                    
                                                    <?php 

                                                    $loSetor = new setorBO();
                                                        
                                                    $loDadosC = array( 
                                                                'id' => '' 
                                                            );

                                                    $loListaSetor =  $loSetor->ListaSetor($loDadosC);
                                                    
                                                    echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaSetor as $row){
                                                            
                                                            $loSelected = "";
                                                            if($loIDSetor  == $row["id_setor"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id_setor"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        }     
                                                    ?>
                                                    
                                                    </select>
                                                    
                                
                                                </div>
                                            </div>


                                    </div>                                                                

                                            


                          </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" onClick="Solicitacao.buttonEnviaDadosCadastroPassageiro_onClick()" >Cadastrar</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao-passageiro-modal" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loIdPessoa; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->


                     <!-- Fim -->





<script>
</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>
