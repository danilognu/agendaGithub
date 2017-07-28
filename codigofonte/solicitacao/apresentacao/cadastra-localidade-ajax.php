<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../veiculo/negocio-veiculo.php");  ?>
<?php  include("../../localidade/negocio-localidade.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loLocalidade = new localidadeBO();

$loNome                 = null; 
$loIdCategoria          = null; 
$loIDPessoaUnidade      = null; 
$loIDPessoaMatriz       = null; 
$loLongitude            = null; 
$loLatitude             = null; 
$loCep                  = null; 
$loEndereco             = null; 
$loBairro               = null; 
$loNumero               = null; 
$loComplemento          = null; 
$loIdCidade             = null; 
$loTelefoneDD           = null; 
$loTelefone             = null;
$loTelefoneDD2          = null;
$loTelefone2            = null; 
$loGaragem              = null; 
$loCodRastreamento      = null; 
$loId                   = null;
$loAtivo                = 1;
$loIdEstado             = null;
$loIdLogradouro         = null;
$loTipolocalidade       = null;
$loAcao = "I";

if(isset($_POST["tipolocalidade"])){
    $loTipolocalidade = $_POST["tipolocalidade"];
}

$loComum = new comumBO();

$loVeiculo = new veiculoBO();

?>

<br />


                         <div class="portlet light bordered">

                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                        
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Nome*</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="nome-localidade-modal" class="form-control"  value="<?php echo $loNome; ?>" >
                                                  </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Categoria</label>
                                                <div class="col-md-9">
                                                    
                                                <select class="form-control" nome="categoria-localidade-modal" id="categoria-localidade-modal" >
                                                    
                                                    <?php 

                                                       $loDadosCate = array('id' => '' );                                                                   
                                                       $loListaCate =  $loLocalidade->ListaCategorias($loDadosCate);
                                                       
                                                       echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaCate as $row){
                                                            
                                                            $loSelected = "";
                                                            if($loIdCategoria == $row["id_cat_localidade"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id_cat_localidade"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        }     
                                                    ?>
                                                    
                                                    </select>

                                                  </div>
                                            </div>


                                           <div class="form-group">
                                                <label class="col-md-1 control-label">Longitude</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="longitude-localidade-modal" class="form-control"  value="<?php echo $loLatitude; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Latitude</label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="latitude-localidade-modal" class="form-control"  value="<?php echo $loLongitude; ?>" >
                                                  </div>
                                            </div>   




                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Cep</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="cep-localidade-modal" class="form-control mask_cep"  value="<?php echo $loCep; ?>" >
                                                  </div>
                                                <label class="col-md-2 control-label">Logradouro</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="logradouro-localidade-modal">
                                                    <?php 

                                                        
                                                      $loListaLogradouro =  $loLocalidade->ListaLogradouro(0);
                                                       
                                                       echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaLogradouro as $row){
                                                            
                                                                $loSelected = "";
                                                                if($loIdLogradouro == $row["id_tipo_logradouro"]){
                                                                    $loSelected = "selected";
                                                                }

                                                                echo "<option value=".$row["id_tipo_logradouro"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        }     
                                                    ?>
                                                    </select>                                                
                                                    </div>
                                            </div>                                              

                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Endere&ccedil;o</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="endereco-localidade-modal" class="form-control"  value="<?php echo $loEndereco; ?>" >
                                                  </div>
                                            </div>  

                                           <div class="form-group">
                                                <label class="col-md-1 control-label">Bairro</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="bairro-localidade-modal" class="form-control"  value="<?php echo $loBairro; ?>" >
                                                  </div>
                                                  <label class="col-md-1 control-label">Nr.</label>
                                                  <div class="col-md-2">
                                                    <input type="text" id="numero-localidade-modal" class="form-control mask_number"  value="<?php echo $loNumero; ?>" >
                                                  </div>
                                            </div>   

                                            
                                           <div class="form-group">
                                                <label class="col-md-1 control-label">Estado*</label>
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
                                                  <label class="col-md-1 control-label">Cidade*</label>
                                                  <div class="col-md-5">

                                                    <select class="form-control" nome="cidade" id="cidade" class="cidade" >
                                                    </select>


                                                  </div>
                                            </div>  


                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Telefone </label>
                                                <div class="col-md-3">
                                                    <input type="text" id="telefone-localidade-modal" class="form-control mask_telefone"  value="<?php echo $loTelefoneDD."".$loTelefone; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Telefone 2 </label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="telefone2-localidade-modal" class="form-control mask_telefone"  value="<?php echo $loTelefoneDD2."".$loTelefone2; ?>" >
                                                  </div>
                                            </div>                                             


                                       <div class="form-group">
                                                <label class="col-md-1 control-label">Garagem</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="garagem-localidade-modal">
                                                        <option  value="" ></option>
                                                        <option <?php if($loGaragem == 'S' ){ echo "selected"; }?>  value="S" >SIM</option>
                                                        <option <?php if($loGaragem == 'N' ){ echo "selected"; }?> value="N" >N&atilde;o</option>
                                                    </select>                                                </div>
                                                <label class="col-md-1 control-label">Status</label>
                                                <div class="col-md-3">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" onClick="Solicitacao.buttonEnviaDadosCadastroLocalidade_onClick()" >Cadastrar Localidade</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao-localidade-modal" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loId; ?>" />
                                                    <input type="hidden" id="id-menu" value="<?php echo $IdMenu; ?>" />
                                                    <input type="hidden" id="tipo-localidade-modal" value="<?php echo $loTipolocalidade; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


<script>
</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>