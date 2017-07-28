<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-combustivel.php");  ?>
<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}


//$loVeiculo = new veiculoBO();


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




                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="fa fa-glass"></i>
                                        <span class="caption-subject bold uppercase"> Combustivel</span>
                                    </div>
                                   
                                </div>

                                <h4><i class="fa fa-filter"></i> Filtro</h4>
                   

                                <form class="form-inline" role="form" id="form-filtro">
                                         <input type="hidden" nome="id-menu" id="id-menu" value="<?php echo $IdMenu; ?>" />


                                           <div class="form-group">
                                                 <label class="col-md-2 control-label" name="nome" >Nome</label>
                                                 <div class="col-md-3">
                                                    <input type="text" id="filtro-nome-modelo" class="form-control" size="50" >
                                                </div>                                           
                                           </div>
                                        
                                        <div class="form-group">
                                        </div>
                                        <div class="checkbox">
                                        </div>
                                                <a href="#" id="pesquisa" class="btn sbold dark"> Pesquisar
                                                        <i class="fa fa-search"></i>
                                                </a>
                                         <input type="hidden" name="nomenclatura" id="nomenclatura" value="RelatorioCombustivel" />
                                         <input type="hidden" name="titulo" id="titulo" value="Relatorio Combustivel" />         
                                    </form>

                                    <br />
                                    <br />


                    


                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <button id="btn-adicionar" class="btn sbold dark"> Adicionar
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button id="btn-desativar" class="btn sbold dark"> Desativar
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                </div>                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn-group pull-right">
                                                    <button class="btn dark  btn-outline dropdown-toggle" data-toggle="dropdown">Exportar
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                   <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="#" id="exportar-excel">
                                                                <i class="fa fa-file-excel-o"></i> Exportar Excel </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" id="exportar-pdf" >
                                                                <i class="fa fa-file-pdf-o"></i> Exportar PDF </a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th width="05%">
                                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /> </th>
                                                <!--th width="10%"> Codigo </th-->
                                                <th width="80%"> Nome </th>
                                                <th> Status </th>
                                            </tr>
                                        </thead>
                                        <tbody id="conteudo">
                                          
                                           <?php include("consulta-combustivel-ajax.php"); ?>

                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->


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

         <script src="js/combustivel.js" type="text/javascript"></script>

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
         <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>

        <!-- scripts END -->

    </body>

</html>