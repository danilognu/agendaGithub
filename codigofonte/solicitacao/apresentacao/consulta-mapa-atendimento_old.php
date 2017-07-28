<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-solicitacao.php");  ?>

<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loSolicitacao = new solicitacaoBO();

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
                                        <i class="fa fa-map"></i>
                                        <span class="caption-subject bold uppercase"> Mapa Atendimentos </span>
                                    </div>
                                   
                                </div>

                                <h4><i class="fa fa-filter"></i> Filtro</h4>
                   

                                <form class="form-inline" role="form" id="form-filtro">



                                            <div class="form-group">
                                                Ordenar Por<br />
                                                <select class="form-control input-small" id="filtro-ordenar" name="status" >
                                                        <option value=""></option>
                                                        <option value="evento">Data Hora Evento</option>
                                                        <option value="cod_solic">Codigo Solic</option>
                                                        <option value="situacao">Situa&ccedil;&atilde;o</option>
                                                        <option value="origem">Origem</option>
                                                        <option value="destino">Destino</option>
                                                    </select>   
                                            </div>

                                           <div class="form-group">
                                                   Somente de <br />
                                                    <input type="text" id="filtro-data-inicio" class="form-control mask_date" size="10" name="" >
                                           </div>

                                          <div class="form-group">
                                                    ate <br />
                                                    <input type="text" id="filtro-data-fim" class="form-control mask_date" size="10" name="" >
                                           </div>


                                            <div class="form-group">
                                                Situa&ccedil;&atilde;o<br />
                                                <select class="form-control" nome="filtro-situacao" id="filtro-situacao" onClick="Solicitacao.Situacao_onClick(this);" >
                                                                    
                                                <?php   

                                                    $loListaSoli =  $loSolicitacao->ListaSituacao(0);
                                                    
                                                    echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaSoli as $row){
                                                            
                                                            $loSelected = "";
                                                            if($loIdStatusSolicitacao == $row["id_status_solicitacao"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id_status_solicitacao"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        } 

                                                        ?>                                      
                                                    
                                                    </select>
 
                                            </div>

                                            <br />
                                            <div class="form-group">
                                                Localidade Origem<br />
                                                <input type="checkbox" id="todas-origem"  >
                                                todas as localidade de origem
                                                <br />
                                                <input type="text" id="nome-origem" class="form-control" size="30" name="" >  
                                                <input type="hidden" id="codigo-origem" class="form-control" name="" >  
                                                  <a href="#" id="pesquisa-mapa-origem" class="btn btn-default origem">
                                                            <i class="fa fa-search"></i>
                                                    </a>                                                  
                                            </div>  

                                              <div class="form-group">
                                                Localidade Destino<br />
                                                <input type="checkbox" id="todas-destino"  >
                                                todas as localidade de destino
                                                <br />
                                                <input type="text" id="nome-destino" class="form-control " size="30" name="" >
                                                <input type="hidden" id="codigo-destino" class="form-control" name="" >   
                                                  <a href="#" id="pesquisa-mapa-destino" class="btn btn-default destino">
                                                            <i class="fa fa-search"></i>
                                                    </a>  
                                            </div>                                             
                                        
                                            <br />
                                            <div class="form-group">
                                                    <br />
                                                    <a href="#" id="pesquisa-mapa-atendimento" class="btn sbold dark">Pesquisar
                                                            <i class="fa fa-search"></i>
                                                    </a>                                        
                                            </div>


                                            <input type="hidden" name="id-menu-exp" id="id-menu-exp" value="<?php echo $IdMenu; ?>" />
                                            <input type="hidden" name="nomenclatura" id="nomenclatura" value="Solicitacao" />
                                            <input type="hidden" name="titulo" id="titulo" value="Relatorio Solicitacao" />         
                                    </form>



                    

                                    <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">

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
                                                            <a href="#" id="exportar-pdf">
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
                                                <th width="2px;"></th>
                                                <th>Solic.</th>
                                                <th>Setor</th> 
                                                <th>Data Partida</th> 
                                                <th>Data Chegada</th> 
                                                <th>Placa</th>
                                                <th>Motorista</th> 
                                                <th>Destino</th> 
                                            </tr>
                                        </thead>
                                        <tbody id="conteudo" >
   
                                           <?php include("consulta-mapa-atendimento-ajax.php"); ?>

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
           
        <div id="dialog-message" ></div>



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

        <script src="js/solicitacao.js" type="text/javascript"></script>
        <script src="../../comum/js/comum.js" type="text/javascript"></script>
        <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <!-- SCRIPTS PARA EXIBIR MODAL -->   
        <script src="../../../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <!-- scripts END -->

    </body>

</html>