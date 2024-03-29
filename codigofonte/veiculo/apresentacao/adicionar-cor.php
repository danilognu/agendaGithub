<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-cor.php");  ?>

<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loCor = new corBO();

$loNome          = null;
$loIdCombustivel = null;
$loAtivo         = 1; 
$loIdCor         = null;
$loIdPessoaMatriz = null;
$loAcao = $_REQUEST["acao"];

if(isset($_REQUEST["id"]))
{
    $loIdCor = $_REQUEST["id"];

    
    $loDadosC = array( 'nome' => '', 'id' => $loIdCor );
    $loExibir = $loCor->ListaCor($loDadosC);


    foreach ($loExibir as $row){

        $loNome             = $row["nome"];
        $loAtivo            = $row["ativo"];
        $loIdPessoaMatriz   = $row["id_pessoa"];

    }
}

//Verifica se a cor foi cadastrada pelo usuario ou pelo TI 
$loDisabledStatus = NULL;
if(strlen($loIdPessoaMatriz) == 0){
    $loDisabledStatus = "disabled"; 
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

                    <div class="col-md-6 ">
                    
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-paint-brush"></i>
                                        <span class="caption-subject font-dark sbold uppercase">Cor do Veiculos</span>
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
                                                <label class="col-md-3 control-label">Status</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="status" <?php echo $loDisabledStatus; ?> >
                                                        <option <?php if($loAtivo == 1 ){ echo "selected"; }?> value="1" >Ativo</option>
                                                        <option <?php if($loAtivo != 1  ){ echo "selected"; }?> value="0" >Desativado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loIdCor ?>" />
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

        <script src="js/cor.js" type="text/javascript"></script>
        <script src="../../comum/js/comum.js" type="text/javascript"></script>
        <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <!-- SCRIPTS PARA EXIBIR MODAL -->   
        <script src="../../../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>


    </body>

</html>