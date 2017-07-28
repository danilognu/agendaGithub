<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-pessoa.php");  ?>
<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loPessoa = new pessoaBO();


$loNome         = null;
$loNomeFantasia = null;
$loCnpj         = null;
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
$DtCadastro     = null;
$loIdPessoa     = 0;
$loLogoCaminho  = NULL;
$loLogoNome     = NULL;
$loCarona       = NULL;

$loAcao = $_REQUEST["acao"];
$IDMenu = $_REQUEST["id_menu"]; 

if(isset($_REQUEST["id"]))
{
    $loIdPessoa = $_REQUEST["id"];

    $loCliente = new pessoaBO();
    $loDadosC = array( 'tipo_pessoa' => '1', 'id' => $loIdPessoa, 'status' => '0,1' );
    $loExibir = $loCliente->ListaPessoa($loDadosC);


    foreach ($loExibir as $row){

        $loNome         = $row["nome"];
        $loNomeFantasia = $row["nome_fantasia"];
        $loCnpj         = $row["cnpj"];
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
        $loLogoCaminho  = $row["arquivo_logo_caminho"];
        $loLogoNome     = $row["arquivo_logo"];

        if($row["ind_carona"] == 1){ $loCarona = "checked"; }

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
        <link href="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="page-container-bg-solid page-boxed">
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
                                        <span class="caption-subject font-dark sbold uppercase">Empresa</span>
                                    </div>
                   
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form" id="form-empresa" method="post" enctype="multipart/form-data" >
                                        <div class="form-body">
                                        
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Raz&atilde;o Social; *</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="nome" name="nome" class="form-control"  value="<?php echo $loNome; ?>" >
                                                  </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Nome Fantasia</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="nomeFantasia" name="nomeFantasia" class="form-control"  value="<?php echo $loNomeFantasia; ?>" >
                                                  </div>
                                            </div>

                                        <div class="form-group">
                                                <label class="col-md-3 control-label">CNPJ *</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="cnpj" name="cnpj" class="form-control mask_cnpj"  value="<?php echo $loCnpj; ?>" >
                                                  </div>
                                            </div>   


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cep</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="cep" name="cep" class="form-control mask_cep"  value="<?php echo $loCep; ?>" >
                                                  </div>
                                            </div>   

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Endere&ccedilo</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="endereco" name="endereco" class="form-control"  value="<?php echo $loEndereco; ?>" >
                                                  </div>
                                            </div>  

                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Bairro</label>
                                                <div class="col-md-5">
                                                    <input type="text" id="bairro" name="bairro" class="form-control"  value="<?php echo $loBairro; ?>" >
                                                  </div>
                                                  <label class="col-md-1 control-label">Nr.</label>
                                                  <div class="col-md-2">
                                                    <input type="text" id="numero" name="numero" class="form-control mask_number"  value="<?php echo $loNumero; ?>" >
                                                  </div>
                                            </div>   

                                            
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Estado</label>
                                                <div class="col-md-2">

                                                    <select class="form-control" name="estado" id="estado" onchange="loacalizaCidadeSelect('');">
                                                    
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

                                                    <select class="form-control" name="cidade" id="cidade" class="cidade" >
                                                    </select>


                                                  </div>
                                            </div>  

                                                                                                                                                         

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Complemento</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="complemento" name="complemento" class="form-control"  value="<?php echo $loComplemento; ?>" >
                                                  </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Telefone </label>
                                                <div class="col-md-3">
                                                    <input type="text" id="telefone" name="telefone" class="form-control mask_telefone"  value="<?php echo $loTelefoneDD."".$loTelefone; ?>" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Celular </label>
                                                  <div class="col-md-3">
                                                    <input type="text" id="celular" name="celular" class="form-control mask_celular"  value="<?php echo $loCelulaDD."".$loCelula; ?>" >
                                                  </div>
                                            </div>                                             

                                       <div class="form-group">
                                                <label class="col-md-3 control-label">E-mail</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="email" id="email" name="email" class="form-control"  value="<?php echo $loEmail; ?>" > </div>
                                                </div>
                                            </div>

     
                             
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Status</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="status" name="status" >
                                                        <option <?php if($loAtivo == 1 ){ echo "selected"; }?> value="1" >Ativo</option>
                                                        <option <?php if($loAtivo != 1  ){ echo "selected"; }?> value="0" >Desativado</option>
                                                    </select>
                                                </div>
                                            </div>

                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Carona</label>
                                                <div class="col-md-3">

                                                   <input type="checkbox" name="ind-carona" <?php echo $loCarona; ?> class="make-switch" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                
                                                <label class="control-label col-md-3"> </label>
                                                <div class="col-md-3">
                                                    <h5>Logo Empresa </h5> 

                                                    <?php if($loLogoNome != ""){ ?>
                                                        <img id="ImageLogo" src="<?php echo $loLogoCaminho.$loLogoNome; ?>" width="90" height="50"  >
                                                    <?php } ?>

                                                    <input id="imageUpload" name="arquivo" type="file" >
                                                    <!--div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="input-group input-large">
                                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                <span class="fileinput-filename"> </span>
                                                            </div>
                                                            <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> Arquivo </span>
                                                                <span class="fileinput-exists"> Alterar </span>
                                                                <input type="file" name="..."> </span>
                                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remover </a>
                                                        </div-->
                                                    </div>
                                                    <br /><br />
                                                    <?php if(strlen($loLogoCaminho) > 0 ){ ?>
                                                    <button type="button" class="btn red" id="btn-remover-logo" >Remover Imagem</button>
                                                    <?php } ?>

                                        </div>
                                        
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao" name="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" name="id" value="<?php echo $loIdPessoa; ?>" />
                                                    <input type="hidden" nome="id-menu" id="id-menu" value="<?php echo $IDMenu; ?>" />

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

        <script src="js/empresa.js" type="text/javascript"></script>

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
        <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>


        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <!-- scripts END -->

        <?php
            if($loAcao == "U"){
              echo "<script> loacalizaCidadeSelect(".$loIdCidade."); </script>";  
            }
            if(isset($_REQUEST["erro"]) && isset($_REQUEST["messagem"])){

                $loMessagemImg = "";
                if($_REQUEST["messagem"] == "uplaod_erro"){
                    $loMessagemImg = "Problema ao realizar Upload da Imagem!";
                }

                if($_REQUEST["messagem"] == "upload_formato"){
                    $loMessagemImg = "Formato da Imagem invalido o formato deve ser, jpg ou png!";
                }

                if($loMessagemImg != ""){

                    echo  "<script>
                                bootbox.dialog({
                                        message: '".$loMessagemImg."',
                                        title: 'Aviso',
                                        buttons: {
                                        success: {
                                            label: 'OK',
                                            className: 'dark'
                                        }
                                        }
                                    });
                        </script>";
                }

            }

         ?>        

    </body>

</html>