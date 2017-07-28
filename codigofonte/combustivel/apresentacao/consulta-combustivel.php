<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-combustivel.php");  ?>
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
                    
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="fa fa-glass"></i>
                                        <span class="caption-subject bold uppercase"> Combustivel</span>
                                    </div>
                                   
                                </div>

                                <h4><i class="fa fa-filter"></i> Filtro</h4>
                   

                                <form class="form-inline" role="form">



                                           <div class="form-group">
                                                 <label class="col-md-2 control-label">Nome</label>
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn-group pull-right">
                                                    <button class="btn dark  btn-outline dropdown-toggle" data-toggle="dropdown">Exportar
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:window.print();">
                                                                <i class="fa fa-print"></i> Imprimir </a>
                                                        </li>
                                                        <!--li>
                                                            <a href="exportador-excel-usuario.php">
                                                                <i class="fa fa-file-pdf-o"></i> Exportar PDF </a>
                                                        </li-->
                                                        <li>
                                                            <a href="exportado-excel-usuario.php">
                                                                <i class="fa fa-file-excel-o"></i> Exportar Excel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /> </th>
                                                <th> Codigo </th>
                                                <th> Nome </th>
                                                <th> Status </th>
                                                <th> Ação </th>
                                            </tr>
                                        </thead>
                                        <tbody id="conteudo">
                                          
                                           
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                    
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

         <script src="js/combustivel.js" type="text/javascript"></script>

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
         <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>

    </body>

</html>