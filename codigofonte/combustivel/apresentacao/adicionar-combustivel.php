<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-combustivel.php");  ?>


<?php


$loNome          = null;
$loIdCombustivel = null;
$loAtivo         = 1; 
$loAcao = $_REQUEST["acao"];

if(isset($_REQUEST["id"]))
{
    $loIdCombustivel = $_REQUEST["id"];

    $loCombustivel = new combustivelBO();
    $loDadosC = array( 'nome' => '', 'id' => $loIdCombustivel );
    $loExibir = $loCombustivel->ListaCombustivel($loDadosC);


    foreach ($loExibir as $row){

        $loNome         = $row["nome"];
        $loAtivo        = $row["ativo"];

    }
}


?>  

<html lang="en">


    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title> Agenda Lets | Modelo </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        
        <?php include("../../comum/apresentacao/css-base.php"); ?>

        <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

   </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

        <?php include("../../comum/apresentacao/menu-top.php"); ?>

        <div class="clearfix"> </div>

        <!-- BEGIN RECIPIENTE -->
        <div class="page-container">
           <?php include("../../comum/apresentacao/menu.php"); ?>
         </div>

            <!-- BEGIN CONTEUDO -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTEUDO BODY -->
                <div class="page-content">

                    
         


                    <div class="row">

                    <div class="col-md-6 ">
                    
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-glass"></i>
                                        <span class="caption-subject font-dark sbold uppercase">Combustivel</span>
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
                                                    <select class="form-control" id="status">
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
                                                    <input type="hidden" id="id" value="<?php echo $loIdCombustivel; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->

                            </div><!--<div class="col-md-6 ">-->
                    
                    </div>
                </div>
                <!-- END CONTEUDO BODY -->
            </div>
            <!-- END CONTEUDO -->

        </div>
        <!-- END RECIPIENTE -->



        <!-- BEGIN RODA PÉ -->
        <div class="page-footer">
            <div class="page-footer-inner"> Agenda Let´s 
                <a href="http://www.lets.com.br" title="agenda lets" target="_blank">Lets.com.br</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END RODA PÉ -->


        <?php include("../../comum/apresentacao/script-base.php"); ?>


        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>

        <script src="js/combustivel.js" type="text/javascript"></script>
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

