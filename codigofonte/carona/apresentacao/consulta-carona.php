<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-carona.php");  ?>
<?php  include_once("../../localidade/negocio-localidade.php");  ?>

<?php
$loNome = null;
$loEndereco = null;

if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}


$loCarona = new caronaBO();
$loLocalidade = new localidadeBO();


?>
<html>

    <head>
        
        <title>Agenda Lets | </title>
        
         <!-- CABECALHO BEGIN -->
         <?php include("../../comum/apresentacao/cabecalho.php"); ?>
         <!-- CABECALHO HEAD -->
        <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />


        <link href="../../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
 
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


                       <!-- BEGIN TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet">
                                    <div class="caption font-dark">
                                        <i class="fa fa-automobile"></i>
                                        <span class="caption-subject bold uppercase"> Pesquisa Carona </span>
                                    </div>
                                   
                                </div>

                


                                <!-- ================================================================================================================ -->
                                    <form role="form" method="post" id="form-filtro">
                                        <div class="row" style=" width: 80%;">
                                            <div class="col-md-2">
                                                Dt Saida
                                                 <input type="text" class="form-control form-control input-sm mask_date_hora" name="data-saida" value="" > 
                                            </div>
                                            <div class="col-md-3">Origem
                                                <select class="form-control select2me" name="select-origem" >
                                                        <option value=""></option>
                                                        <?php
                                                            $loDadosCOrigem = array( 
                                                                    'nome' => $loNome
                                                                    , 'endereco' => $loEndereco
                                                                    , 'status' => '1'
                                                                );

                                                                $loLista =  $loLocalidade->ListaLocalidade($loDadosC);

                                                                if(count($loLista) > 0){

                                                                    foreach ($loLista as $row){
                                                                        ?>
                                                                        <option value="<?php echo $row["id_localidade"]; ?>"><?php echo $row["nome"]." - ".$row["endereco"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }                                                                        
                                                            ?>
                                                </select>
                                            </div>
                                            <div class="col-md-1"><br />
                                                <a href="#" id="pesquisa-rota-paradas" class="btn btn-default paradas"><i class="fa fa-search"></i></a>
                                            </div>
                                            <div class="col-md-2">
                                                Dt Retorno
                                                <input type="text" class="form-control form-control input-sm mask_date_hora" name="data-retorno" value="" > 
                                            </div>
                                            <div class="col-md-3">
                                                Destino
                                                <select class="form-control select2me" name="select-destino" >
                                                        <option value=""></option>
                                                        <?php
                                                            $loDadosCOrigem = array( 
                                                                    'nome' => $loNome
                                                                    , 'endereco' => $loEndereco
                                                                    , 'status' => '1'
                                                                );

                                                                $loLista =  $loLocalidade->ListaLocalidade($loDadosC);

                                                                if(count($loLista) > 0){

                                                                    foreach ($loLista as $row){
                                                                        ?>
                                                                        <option value="<?php echo $row["id_localidade"]; ?>"><?php echo $row["nome"]." - ".$row["endereco"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }                                                                        
                                                            ?>
                                                </select>
                                            </div>
                                             <div class="col-md-1"><br />
                                                <a href="#" id="pesquisa-rota-paradas" class="btn btn-default"><i class="fa fa-search"></i></a>
                                            </div>
                                            <div class="col-md-2"><br />
                                                <a href="#" id="pesquisa-carona" class="btn dark">Pesquisar <i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                <!-- ================================================================================================================ -->




                                <table class="table table-striped table-bordered table-hover dataTable" id="sample_1_ativar_se_preciso">
                                        <thead>
                                            <tr>
                                                <!--th width="1%"></th-->
                                                <th> Passageiros </th>
                                                <th> Paradas </th>
                                                <th> Cod </th>
                                                <th> Requisitante </th>
                                                <th> Dt Saida </th>
                                                <th> Dt Retorno </th>
                                                <th> Origem </th>
                                                <th> Destino </th>
                                                <th> Motorista </th>
                                                <th> Status </th>
                                                <th> Solicitar </th>
                                             </tr>
                                        </thead>
                                        <tbody id="conteudo" >
   
                                           <?php include("consulta-carona-ajax.php"); ?>

                                        </tbody>
                                    </table>





                                </div>
                            </div>
                            <!-- END  TABLE PORTLET-->


                     <!-- Fim -->


                    </div>
                </div>
                <!-- END PAGE CONTENT BODY -->
                <!-- END CONTENT BODY -->






            </div>
            <!-- END CONTENT -->
           




        </div>

        <div id="dialog-message"></div>

        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
      
        <!-- BEGIN INNER FOOTER -->
        <?php include("../../comum/apresentacao/rodape.php"); ?>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->



        <!-- scripts BEGIN -->
        <?php include("../../comum/apresentacao/scripts.php"); ?>

         <script src="js/carona.js" type="text/javascript"></script>

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
         <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>

        <!-- scripts END -->

    </body>

</html>