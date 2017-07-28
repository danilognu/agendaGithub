<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../veiculo/negocio-veiculo.php");  ?>
<?php  include_once("../../gerenciaCadastros/negocio-setor.php");  ?>
<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
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



if(isset($_REQUEST["id_pessoa"]))
{
    $loIdPessoa = $_REQUEST["id_pessoa"];

    $loCliente = new pessoaBO();
    $loDadosC = array( 'tipo_pessoa' => '4,5,6', 'id' => $loIdPessoa, 'status' => '0,1' );
    $loExibir = $loCliente->ListaPessoa($loDadosC);


    foreach ($loExibir as $row){

        $loNome         = $row["nome"];
        $loNomeFantasia = $row["nome_fantasia"];
        $loCpf         = $row["cpf"];
        $loCep          = $row["cep"];
        $loEndereco     = $row["endereco"];
        $loBairro       = $row["bairro"];
        $loNumero       = $row["numero"];
        $loIdCidade     = $row["id_cidade"];
        $loIdEstado     = $row["id_estado"];
        $loComplemento  = $row["complemento"];
        $loTelefoneDD   = $row["telefone_dd"];
        $loTelefone     = $row["telefone"];
        $loCelulaDD     = $row["celular_dd"];
        $loCelula       = $row["celular"];
        $loEmail        = $row["email"];
        $loAtivo        = $row["ativo"];
        $loIdTipoPessoa = $row["id_tipo_pessoa"];
        $DtCadastro     = $row["dt_cadastro"];

        $loIndPassageiro  = $row["ind_passageiro"];
        $loIndMotorista   = $row["ind_motorista"];  
        $loIndCondutor    = $row["ind_condutor"];      

        $loNumHabilitacao           = $row["num_habilitacao"];
        $loOrgaoHabilitacao         = $row["orgao_habilitacao"];
        $loCategoriaHabilitacao     = $row["categoria_habilitacao"];
        $loDataValidadeHabilitacao  = $row["validade_habilitacao"];
        $loCodigoCliente            = $row["id_pessoa_cliente"]; 
        $loIDSetor                  = $row["id_setor"];
        $loIdGaragem                = $row["id_garagem"];
        $loNomeGaragem              = $row["nome_garagem"];
        $loEnderecoGaragem          = $row["endereco_garagem"];
        $loIdLocalidadeGaragemAtual = $row["id_localidade_garagem_atual"];
        $loIdPessoaUsuario          = $row["id_pessoa_usuario"];


         if($loIndPassageiro == 1){ $loIndPassageiroCheck = "checked"; }
         if($loIndMotorista == 1){ $loIndMotoristaCheck = "checked"; }
         if($loIndCondutor == 1){ $loIndCondutorCheck = "checked"; }



    }

   /* $loDadosUsuario = $loPessoa->ListaDadosUsuario($loIdPessoa);
    if(count($loDadosUsuario) > 0){
        foreach ($loDadosUsuario as $row){
            
            $loLogin = $row["login"];
            //$loSenha = $row["senha"];
            $loIdUsuario = $row["id_usuario"];
        }
    }*/
}

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
                                                    <input type="text" disabled id="nome-passageiro-modal" class="form-control"  value="<?php echo $loNome; ?>" >
                                                  </div>
                                            </div>


                                        <div class="form-group">
                                                <label class="col-md-1 control-label">CPF</label>
                                                <div class="col-md-5">
                                                    <input type="text" disabled id="cpf-passageiro-modal" class="form-control mask_cpf"  value="<?php echo $loCpf; ?>" >
                                                  </div>
                                            </div>   


                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Cep</label>
                                                <div class="col-md-3">
                                                    <input type="text" disabled id="cep-passageiro-modal" class="form-control mask_cep"  value="<?php echo $loCep; ?>" >
                                                  </div>
                                            </div>   

                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Endere&ccedil;o</label>
                                                <div class="col-md-9">
                                                    <input type="text" disabled id="endereco-passageiro-modal" class="form-control"  value="<?php echo $loEndereco; ?>" >
                                                  </div>
                                            </div>  

                                           <div class="form-group">
                                                <label class="col-md-1 control-label">Bairro</label>
                                                <div class="col-md-5">
                                                    <input type="text" disabled id="bairro-passageiro-modal" class="form-control"  value="<?php echo $loBairro; ?>" >
                                                  </div>
                                                  <label class="col-md-1 control-label">Nr.</label>
                                                  <div class="col-md-2">
                                                    <input type="text" disabled id="numero-passageiro-modal" class="form-control mask_number"  value="<?php echo $loNumero; ?>" >
                                                  </div>
                                            </div>   


                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Estado</label>
                                                <div class="col-md-2">

                                                    <select class="form-control" disabled nome="estado" id="estado" onchange="loacalizaCidadeSelect('');">
                                                    
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

                                                    <select class="form-control" disabled nome="cidade" id="cidade" class="cidade cidade-passageiro-modal" >
                                                    </select>


                                                  </div>
                                            </div>  
                                            
         
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Telefone*</label>
                                                <div class="col-md-3">
                                                    <input type="text" disabled id="telefone-passageiro-modal" class="form-control mask_telefone"  value="<?php echo $loTelefoneDD."".$loTelefone; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Celular </label>
                                                  <div class="col-md-3">
                                                    <input type="text" disabled id="celular-passageiro-modal" class="form-control mask_celular"  value="<?php echo $loCelulaDD."".$loCelula; ?>" >
                                                  </div>
                                            </div>



                                       <div class="form-group">
                                                <label class="col-md-1 control-label">E-mail*</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="email" disabled id="email-passageiro-modal" class="form-control"  value="<?php echo $loEmail; ?>" > </div>
                                                </div>
                                            </div>

              
                                         

                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Setor</label>
                                                <div class="col-md-9">

                                                    <select class="form-control" disabled id="setor-passageiro-modal" >
                                                    
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
                        
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->


                     <!-- Fim -->





<script>
</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>
