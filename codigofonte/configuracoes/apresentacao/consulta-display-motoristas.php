<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../modelo-configuracao.php");  ?>

<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
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
                    <div class="" style="padding-left:20px;padding-right:20px;">
                     
                     <!-- Inicio -->


                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="fa fa-cogs"></i>
                                        <span class="caption-subject bold uppercase">Display Motoristas</span>
                                    </div>
                                   
                                </div>

                          


                                    <table class="table table-striped table-bordered table-hover table-checkable" >
                                        <thead>
                                            <tr>

                                                <th> Cor Display </th>
                                                <th> Tempo (Hora/Minuto) </th>
                                                <th> Acao </th>
                                            </tr>
                                        </thead>

                                        <tbody  >

                                            <?php
                                                    $loItens = new configuracaoBO();

                                                    $loDadosC = array( 
                                                            'id_parametro' => '1,2,3'
                                                        );


                                                    $loLista =  $loItens->ListaDisplayMotorista($loDadosC);


                                                    if(count($loLista) > 0 ){                                                   

                                                        foreach ($loLista as $row){

                                                            if($row["id_parametro"] == 1){
                                                                //VERMELHO
                                                                $classCss = "bg-red-intense bg-font-red-intense bold";
                                                            }elseif($row["id_parametro"] == 2){
                                                                //AMARELO
                                                                $classCss = "bg-yellow-lemon bg-font-yellow-lemon bold";
                                                            }elseif($row["id_parametro"] == 3){
                                                                $classCss = "bg-green-jungle bg-font-green-jungle bold"; 
                                                            }

                                                        ?>
                                                    
                                                        
                                                        <tr class="odd gradeX" style="cursor:pointer;">

                                                            <td width="30%" class="<?php echo $classCss; ?>"> 
                                                                <?php echo $row["nome"]; ?> 
                                                            </td>
                                                            <td width="30%"> 
                                                                 <input type="text" id="valor<?php echo $row["id_vlr_parametro"]; ?>" class="mask_hora" value="<?php echo $row["valor"]; ?>" >
                                                            </td>
                                                            <td width="10%"> 
                                                                 <button type="button" class="btn dark " onClick="DisplayTempo.buttonAltera_onClick(<?php echo $row["id_parametro"]; ?>,<?php echo $row["id_vlr_parametro"]; ?>);" >
                                                                    Gravar <i class="fa fa-check"></i>
                                                                 </button>
                                                                 <span class="atualiza-tempo-<?php echo $row["id_vlr_parametro"]; ?>"></span>
                                                            </td>

                                                        </tr>

                                                    <?php

                                                        }
                                                        
                                                    }

                                                    ?>

                                           
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <input type="hidden" nome="id-menu" id="id-menu" value="<?php echo $IdMenu; ?>" />
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

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
        

        <script src="js/display-motoristas.js" type="text/javascript"></script>
        <script src="../../comum/js/comum.js" type="text/javascript"></script>
        <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>


        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <!-- scripts END -->

    </body>

</html>