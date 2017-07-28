<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-pessoa.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-setor.php");  ?>
<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loPessoa = new pessoaBO();


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
$loIdPessoaUsuario = null;
$loIndMotorista = null;
$loIndCondutor = null;
$loRegistro = null;

$loIndPassageiroCheck = ""; 
$loIndMotoristaCheck = ""; 
$loIndCondutorCheck = "";

//Usuario
$loLogin = "";
$loSenha = null;
$loIdUsuario = null;
$loIdPessoa     = 0;
$loAcao = $_REQUEST["acao"];

if($loAcao == "I"){
    $loSenha = "123";
}


if(isset($_REQUEST["id"]))
{
    $loIdPessoa = $_REQUEST["id"];

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
        $loRegistro     = $row["registro"];

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

    $loDadosUsuario = $loPessoa->ListaDadosUsuario($loIdPessoa);
    if(count($loDadosUsuario) > 0){
        foreach ($loDadosUsuario as $row){
            
            $loLogin = $row["login"];
            //$loSenha = $row["senha"];
            $loIdUsuario = $row["id_usuario"];
        }
    }
}




?>  
<html>

    <head>
        
        <title>Agenda Lets | </title>
        
         <!-- CABECALHO BEGIN -->
         <?php include("../../comum/apresentacao/cabecalho.php"); ?>
         <!-- CABECALHO HEAD -->
        <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

        <style>
        
        /*input:hover{
            border:1px solid #FF8C00;
        }*/
        input[type=text]:focus {
            border:1px solid #FF8C00;
        }
        input[type=email]:focus {
            border:1px solid #FF8C00;
        }
        select:hover {
            border:1px solid #FF8C00;
        }

        select[nome="estado"]:focus{
            border:1px solid #FF8C00;
        } 

        select[nome="cidade"]:focus{
            border:1px solid #FF8C00;
        }       

        </style>
 
    </head>

    <body class="page-container-bg-solid page-boxed">

        <div id="dialog-modal"></div>

        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN  TOP -->
            <?php include("../../comum/apresentacao/topo.php"); ?>
            <!-- END  TOP -->

            <!-- BEGIN  MENU -->            
            <?php include("../../menu/apresentacao/menu-horizontal.php"); ?>
            <!-- END  MENU -->




        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head">
                    <div class="container">
                        
                    </div>
                </div>
                <!-- END PAGE HEAD-->




                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="" style="padding-left:30px;">
                     
                     <!-- Inicio -->


                       <div class="row">

                    <div class="col-md-7 ">
                    
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase"> Pessoa </span>
                                    </div>
                   
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                        
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Nome *</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="nome" class="form-control"  value="<?php echo $loNome; ?>" >
                                                  </div>
                                            </div>


                                        <div class="form-group">
                                                <label class="col-md-3 control-label">CPF *</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="cpf" class="form-control mask_cpf"  value="<?php echo $loCpf; ?>" >
                                                  </div>
                                            </div>   


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cep *</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="cep" class="form-control mask_cep"  value="<?php echo $loCep; ?>" >
                                                  </div>

                                                <label class="col-md-2 control-label">Registro</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="registro" class="form-control"  value="<?php echo $loRegistro; ?>" >
                                                </div>

                                            </div>   

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Endere&ccedil;o *</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="endereco" class="form-control"  value="<?php echo $loEndereco; ?>" >
                                                  </div>
                                            </div>  

                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Bairro *</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="bairro" class="form-control"  value="<?php echo $loBairro; ?>" >
                                                  </div>
                                                  <label class="col-md-1 control-label">Nr. *</label>
                                                  <div class="col-md-2">
                                                    <input type="text" id="numero" class="form-control mask_number"  value="<?php echo $loNumero; ?>" >
                                                  </div>
                                            </div>   

                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Estado *</label>
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
                                                  <label class="col-md-2 control-label">Cidade *</label>
                                                  <div class="col-md-5">

                                                    <select class="form-control" nome="cidade" id="cidade" class="cidade" >
                                                    </select>


                                                  </div>
                                            </div>  

                                                                                                                                                         

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Complemento</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="complemento" class="form-control"  value="<?php echo $loComplemento; ?>" >
                                                  </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Telefone *</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="telefone" class="form-control mask_telefone"  value="<?php echo $loTelefoneDD."".$loTelefone; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Celular </label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="celular" class="form-control mask_celular"  value="<?php echo $loCelulaDD."".$loCelula; ?>" >
                                                  </div>
                                            </div>



                                       <div class="form-group">
                                                <label class="col-md-3 control-label">E-mail *</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="email" id="email" class="form-control"  value="<?php echo $loEmail; ?>" > </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" id="ind-passageiro" <?php echo $loIndPassageiroCheck; ?> >
                                                     Passageiro
                                                     <input type="checkbox" class="motorista" id="ind-motorista" <?php echo $loIndMotoristaCheck; ?> >
                                                     Motorista
                                                     <input type="checkbox" class="motorista" id="ind-condutor" <?php echo $loIndCondutorCheck; ?> >
                                                     Condutor
                                                </div>
                                            </div>

                                            <div class="form-group motorista-condutor-div">
                                                <label class="col-md-3 control-label">Num Habilita&ccedil;&atilde;o *</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="num-habilitacao" class="form-control"  value="<?php echo $loNumHabilitacao; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Org&atilde;o</label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="orgao-habilitacao" class="form-control"  value="<?php echo $loOrgaoHabilitacao; ?>" >
                                                  </div>
                                            </div>  
     
                                           <div class="form-group motorista-condutor-div">
                                                <label class="col-md-3 control-label">Dt Validade * </label>
                                                <div class="col-md-3">
                                                    <input type="text" id="data-validade-habilitacao" class="form-control mask_date"  value="<?php echo $loDataValidadeHabilitacao; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Categoria.</label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="categoria-habilitacao" class="form-control"  value="<?php echo $loCategoriaHabilitacao; ?>" >
                                                  </div>
                                            </div>  

                                        



                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Setor</label>
                                                                        <div class="col-md-9">

                                                                            <select class="form-control" nome="setor" id="setor" >
                                                                            
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



                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Garagem</label>
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" id="garagem-nome" value="<?php echo $loNomeGaragem." - ".$loEnderecoGaragem; ?>" >
                                                                        <input type="hidden" class="form-control" id="garagem-codigo" value="<?php echo $loIdGaragem; ?>" >
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                    <a href="#" id="pesquisa-garagem" title="Pesquisa Garagem" class="btn btn-default"><i class="fa fa-search"></i></a>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <a href="#" id="pesquisa-historico" title="Historico Garagem" class="btn btn-default"><i class="fa fa-book"></i></a>
                                                                    </div>                                                                    
                                                                </div>




                                                            <div class="form-group motivo-troca-garagem" style="display:none;">
                                                                <label class="col-md-3 control-label"></label>
                                                                <div class="col-md-7">
                                                                    Motivo troca garagem*
                                                                    <textarea class="form-control" rows="2" id="motivo-troca-garagem"></textarea>
                                                                </div>
                                                            </div>                                                                

                                            


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Status</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" id="status">
                                                        <option <?php if($loAtivo == 1 ){ echo "selected"; }?> value="1" >Ativo</option>
                                                        <option <?php if($loAtivo != 1  ){ echo "selected"; }?> value="0" >Desativado</option>
                                                    </select>                                                    
                                                </div>
                                                
                                                 <div class="col-md-1"> 
                                                     <!--a href="#" title="Log de altera&ccedil;&atilde;o status" ><i class="fa fa-commenting-o"></i></a-->
                                                <a href="javascript:;" id="btn-log-alteracoes" title="Log de altera&ccedil;&atilde;o" class="btn btn-sm grey-cascade"> 
                                                      <i class="fa fa-commenting-o"></i>
                                                 </a>
                                                 </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-5">
                                                    Configurar Usuario ?<input type="checkbox" class="form-control" id="cadastra-usuario" <?php  if($loLogin != ""){ echo "checked";  } ?>>
                                                </div>
                                         </div>


                                        <div class="form-group cadastraUsuario">
                                                <label class="col-md-3 control-label">Login*</label>
                                                <div class="col-md-2">
                                                    <div class="input-inline input-medium">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                            </span>
                                                            <input type="text" id="login" class="form-control" value="<?php echo $loLogin; ?>" > 
                                                            <input type="hidden" id="id-pessoa-usuario" value="<?php echo $loIdPessoaUsuario; ?>" />                                                            
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group cadastraUsuario">
                                                <label class="col-md-3 control-label">Senha*</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-icon">
                                                            <i class="fa fa-lock fa-fw"></i>
                                                            <input id="senha" class="form-control" type="password" name="senha" value="<?php echo $loSenha; ?>" /> </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group cadastraUsuario">
                                                <label class="col-md-3 control-label">Confirmar Senha*</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-icon">
                                                            <i class="fa fa-lock fa-fw"></i>
                                                            <input id="confi-senha" class="form-control" type="password" name="confi-senha" value="<?php echo $loSenha; ?>" /> </div>
                                                    </div>
                                                </div>
                                            </div>



                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loIdPessoa; ?>" />
                                                    <input type="hidden" nome="id-menu" id="id-menu" value="<?php echo $IdMenu; ?>" />
                                                    <input type="hidden" nome="id-garagem-atual" id="id-garagem-atual" value="<?php echo $loIdLocalidadeGaragemAtual; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->

                            </div><!--<div class="col-md-6 ">-->
                    
                    </div>


                     <!-- Fim -->


                    </div>
                </div>
                <!-- END PAGE CONTENT BODY -->
                <!-- END CONTENT BODY -->






            </div>
            <!-- END CONTENT -->
           




        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->


       
      
        <!-- BEGIN INNER FOOTER -->
        <?php include("../../comum/apresentacao/rodape.php"); ?>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->



        <!-- scripts BEGIN -->
        <?php include("../../comum/apresentacao/scripts.php"); ?>


        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>

        <script src="js/motorista-passageiro.js" type="text/javascript"></script>
        <script src="../../comum/js/comum.js" type="text/javascript"></script>
        <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <!-- SCRIPTS PARA EXIBIR MODAL -->   
        <script src="../../../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <!-- scripts END -->

        <?php
            if($loAcao == "U"){
              echo "<script> loacalizaCidadeSelect(".$loIdCidade."); </script>";  
            }

            if($loLogin != ""){
                echo "<script>  $('.cadastraUsuario').show();  </script>";  
            }
            if($loIndMotorista == 1){ echo "<script> $('.motorista-condutor-div').show(); </script>"; }
            if($loIndCondutor == 1){ echo "<script>  $('.motorista-condutor-div').show(); </script>"; }
         ?>

    </body>

</html>