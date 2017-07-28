<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-relatorio.php");  ?>

<?php  //Implementações de class ------------------------------------- ?>
<?php  include("../../veiculo/negocio-veiculo.php");  ?>
<?php  include("../../pessoa/negocio-pessoa.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-setor.php");  ?>
<?php  include("../../localidade/negocio-localidade.php");  ?>
<?php

if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loRelatorio = new relatorioBO();
$loVeiculo = new veiculoBO();
$loPessoa = new pessoaBO();
$loSetor = new setorBO();
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
                    <div class="" style="padding-left:30px;">
                     
                     <!-- Inicio -->


                       <div class="row">

                    <div class="col-md-8 ">
                    
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase">Relatorio Solicita&ccedil;&atilde;o por Rateio</span>
                                    </div>
                   
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form" id="form-relatorio" method="POST" >
                                        <div class="form-body">
                                        
                                           <div class="form-group">
                                                <label class="col-md-2 control-label">Data Saida*</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="data-saida" id="data-saida" class="form-control mask_date_hora"  value="" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Data Retorno*</label>
                                                  <div class="col-md-3">
                                                    <input type="text" name="data-retorno" id="data-retorno" class="form-control mask_date_hora"  value="" >
                                                  </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Veiculo</label>
                                                <div class="col-md-3">

                                                      <select class="form-control select2me" name="select-veiculo" id="select-veiculo" >
                                                        <option value=""></option>
                                                        <?php

                                                                $loDadosVeiculo = array( 'id' => NULL );

                                                                $loListaVeiculos =  $loVeiculo->ListaVeiculo($loDadosVeiculo);

                                                                if(count($loListaVeiculos) > 0){

                                                                    foreach ($loListaVeiculos as $rowVeiculo){

                                                                            $loSelected = "";
                                                                            if($loIdVeiculo == $rowVeiculo["id_veiculo"]){
                                                                                $loSelected = "selected";
                                                                            }

                                                                        ?>
                                                                        <option <?php echo $loSelected; ?> value="<?php echo $rowVeiculo["id_veiculo"]; ?>"><?php echo $rowVeiculo["placa"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                        
                                                            ?>
                                                        </select>

                                                  </div>
                                            </div>
                                            


                                           <!--div class="form-group">
                                                <label class="col-md-2 control-label">Data Inicio Prev*</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="data-inic-prev" id="data-inic-prev" class="form-control mask_date_hora"  value="" >
                                                  </div>
                                                  <label class="col-md-2 control-label">Data Termino Prev</label>
                                                  <div class="col-md-3">
                                                    <input type="text" name="data-termino-prev" id="data-termino-prev" class="form-control mask_date_hora"  value="" >
                                                  </div>
                                            </div-->



                                            <!--div class="form-group">
                                                <label class="col-md-2 control-label">Motorista</label>
                                                <div class="col-md-8">

                                                    <select class="form-control select2me" name="select-motorista" id="select-motorista" >
                                                    <option value=""></option>
                                                    <?php

                                                          /*  $loDadosMotorista= array( 'tipo_pessoa' => '4,5,6', 'ind_motorista' => 1, 'id' => NULL );

                                                            $loListaMotoristas =  $loPessoa->ListaPessoa($loDadosMotorista);

                                                            if(count($loListaMotoristas) > 0){

                                                                foreach ($loListaMotoristas as $rowMotorista){

                                                                        $loSelected = "";
                                                                        if($loIdMotorista == $rowMotorista["id_pessoa"]){
                                                                            $loSelected = "selected";
                                                                        }

                                                                    ?>
                                                                    <option <?php echo $loSelected; ?> value="<?php echo $rowMotorista["id_pessoa"]; ?>"><?php echo $rowMotorista["nome"]; ?></option>
                                                                    <?php
                                                                }
                                                            }*/
                                                                    
                                                        ?>
                                                    </select>

                                                  </div>
                                            </div-->



                                            <!--div class="form-group">
                                                <label class="col-md-2 control-label">Requisitante</label>
                                                <div class="col-md-4">

                                                    <select class="form-control select2me" name="select-requisitante" id="select-requisitante" >
                                                    <option value=""></option>
                                                    <?php

                                                          /*  $loDadosRequisitante= array( 'tipo_pessoa' => '4,5,6', 'id' => NULL );

                                                            $loListaRequisitante =  $loPessoa->ListaPessoa($loDadosRequisitante);

                                                            if(count($loListaRequisitante) > 0){

                                                                foreach ($loListaRequisitante as $rowRequisitante){

                                                                        /*$loSelected = "";
                                                                        if($loIdMotorista == $rowRequisitante["id_pessoa"]){
                                                                            $loSelected = "selected";
                                                                        }*/

                                                                    ?>
                                                                    <option <?php //echo $loSelected; ?> value="<?php //echo $rowRequisitante["id_pessoa"]; ?>"><?php //echo $rowRequisitante["nome"]; ?></option>
                                                                    <?php
                                                            /*    }
                                                            }*/
                                                                    
                                                        ?>
                                                    </select>

                                                  </div>

                                                        <label class="col-md-1 control-label">Setor</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control input-sm" name="setor" id="setor">

                                                            <?php 

                                                                 /*   $loDadosS = array('nome' => '' );                                                                   
                                                                    $loListaSetor =  $loSetor->ListaSetor($loDadosS);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        foreach ($loListaSetor as $row){
                                                                            
                                                                            $loSelected = "";
                                                                            if($loIdSetor == $row["id_setor"]){
                                                                                $loSelected = "selected";
                                                                            }

                                                                            echo "<option value=".$row["id_setor"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                        }    */ 
                                                                    ?>
                                                                  </select>
                                                             </div>

                                            </div-->                                            



                                           <!--div class="form-group">
                                                <label class="col-md-2 control-label">Localidade Origem</label>
                                                <div class="col-md-4">

                                                    <select class="form-control select2me" name="select-origem" id="select-origem" >
                                                        <option value=""></option>
                                                        <?php
                                                           /* $loDadosOrigem = array( 
                                                                    'nome' => ''
                                                                    , 'status' => '1'
                                                                );

                                                                $loLista =  $loLocalidade->ListaLocalidade($loDadosOrigem);

                                                                if(count($loLista) > 0){

                                                                    foreach ($loLista as $row){
                                                                        ?>
                                                                        <option value="<?php echo $row["id_localidade"]; ?>"><?php echo $row["nome"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }*/
                                                                        
                                                            ?>
                                                    </select>

                                                  </div>

                                                    <label class="col-md-4 control-label"></label>
                                                    <div class="col-md-6">
                                                        <input type="checkbox" name="ind-viagem" id="ind-viagem"  >
                                                        Viagem
                                                        <input type="checkbox" name="ind-com-motorista" id="ind-com-motorista"  >
                                                        Com Motorista
                                                        <input type="checkbox" name="ind-pernoite" id="ind-pernoite"  >
                                                        Pernoite
                                                    </div>                                                  

                                            </div-->   

                                            <!--div class="form-group">

                                                <label class="col-md-2 control-label">Localidade Destino</label>
                                                <div class="col-md-4">

                                                        <select class="form-control select2me" name="select-destino" id="select-destino" >
                                                        <option value=""></option>
                                                        <?php
                                                           /* $loDadosDestino = array( 
                                                                    'nome' => ''
                                                                    , 'status' => '1'
                                                                );

                                                                $loLista =  $loLocalidade->ListaLocalidade($loDadosDestino);

                                                                if(count($loLista) > 0){

                                                                    foreach ($loLista as $row){
                                                                        ?>
                                                                        <option value="<?php echo $row["id_localidade"]; ?>"><?php echo $row["nome"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }*/
                                                                        
                                                            ?>
                                                    </select>

                                                  </div>  

                                                   <label class="col-md-1 control-label">Panejado</label>
                                                        <div class="col-md-2">
                                                            <select class="form-control input-sm" name="planejado" id="planejado">
                                                                <option value="" ></option>
                                                                <option value="1" >SIM</option>
                                                                <option value="0" >NAO</option>
                                                             </select>
                                                       </div>

                                            </div--> 



                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-gerar-excel-rateio-solicitacao" > Excel <i class="fa fa-file-excel-o"></i></button>
                                                    <!--button type="button" class="btn dark"> PDF <i class="fa fa-file-pdf-o"></i></button-->
                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loIdPessoa; ?>" />
                                                    <input type="hidden" nome="id-menu" id="id-menu" value="<?php echo $IDMenu; ?>" />
                                                    <input type="hidden" name="exportar-excel" id="exportar-excel" value="" />
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

        <script src="js/relatorios.js" type="text/javascript"></script>

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