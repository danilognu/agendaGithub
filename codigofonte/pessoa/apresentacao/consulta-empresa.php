<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-pessoa.php");  ?>

<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}


$loPessoa = new pessoaBO();


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
                    <div class="" style="padding-left:20px;padding-right:20px;">
                     
                     <!-- Inicio -->


                       <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="fa fa-users"></i>
                                        <span class="caption-subject bold uppercase"> Empresa</span>
                                    </div>
                                   
                                </div>

                                <h4><i class="fa fa-filter"></i> Filtro</h4>
                   

                                <form class="form-inline" role="form">


                                        <div class="form-group">
                                               
                                                <label class="col-md-3 control-label">Codigo/Nome</label>
                                                <div class="col-md-2">
                                                    

                                                    <input type="text" id="filtro-codigo-empresa" class="form-control mask_number"  size="5" >

                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" id="filtro-nome-empresa" class="form-control" size="25" >
                                                </div>
                                                <div class="col-md-1">
                                                    <!--a href="#" id="" class="btn btn-default"><i class="fa fa-search"></i></a-->
                                                </div>
                                            </div>
                                           <div class="form-group">
                                                 <label class="col-md-2 control-label">CNPJ</label>
                                                 <div class="col-md-3">
                                                    <input type="text" id="filtro-cnpj-empresa" class="form-control mask_cnpj" size="20" >
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
                                            
                                            <div class="col-md-5">

                                                <div class="btn-group pull-right">
                                                    <button class="btn dark  btn-outline dropdown-toggle" data-toggle="dropdown">Colunas
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        
                                                            
                                                            <?php
                                                                $loGridItens =  $loPessoa->GridConsultaItens($IdMenu);

                                                                foreach ($loGridItens as $row){
                                                                    echo "<li> <input type='checkbox' ".$row["checked"]." name='grid-consulta' value='".$row["id_grid_consulta"]."'> ".$row["campo_visual"]."</li>";
                                                                }
                                                            ?>

                                                            <li>&nbsp</li>
                                                            <li>
                                                             <button id="btn-modifica-consulta" class="btn sbold dark"> 
                                                                OK                                                                    
                                                              </button>
                                                              
                                                              <button id="btn-cancela-consulta" class="btn sbold dark"> 
                                                                Cancelar                                                                    
                                                              </button>

                                                              <input type="hidden" nome="id-menu" id="id-menu" value="<?php echo $IdMenu; ?>" />

                                                            </li>    
                                                        
         
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-1">

                                                <div class="btn-group pull-right">
                                                    <button class="btn dark  btn-outline dropdown-toggle" data-toggle="dropdown">Exportar
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="exportado-excel-pessoa.php?tipo_pessoa=2&id_menu=<?php echo $IdMenu; ?>">
                                                                <i class="fa fa-file-excel-o"></i> Exportar Excel </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
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

                                                <?php

                                                //Cabeçalho da consulta dinamica 

                                               

                                                $loDadosC = array( 
                                                         'id_menu' => $IdMenu 
                                                    );

                                                $loItensConsulta =  $loPessoa->ListaItensConsulta($loDadosC);

                                                 foreach ($loItensConsulta as $row){
                                                     
                                                     $loItens = explode(",", $row["campo_visual"]);   

                                                      $contaItem = count($loItens);
                                                      $contador = 1;
                                                      foreach ($loItens as $item){

                                                            $ultimoItem = "";
                                                            if($contador == $contaItem){
                                                                $ultimoItem = "ultimo";
                                                            }  
                                                            
                                                            echo " <th> ".$item." </th>"; //errp 
                                                            $contador++; 
                                                      }
                                                 }

                                                ?>


                                            </tr>
                                        </thead>
                                        <tbody id="conteudo" >
                                           
                                           <?php include("consulta-empresa-ajax.php"); ?>

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

        <script src="js/empresa.js" type="text/javascript"></script>

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