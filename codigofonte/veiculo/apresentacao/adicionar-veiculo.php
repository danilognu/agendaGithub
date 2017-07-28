<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-modelo.php");  ?>
<?php  include("../negocio-combustivel.php");  ?>
<?php  include("../negocio-cor.php");  ?>
<?php  include("../negocio-veiculo.php");  ?>
<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loVeiculo = new veiculoBO();

$loIdVeiculo = null;
$loIdModelo = null;
$loNomeModelo = null;
$loIdCombustivel = null;
$loNomeCombustivel = null;
$loIdCor = null;
$loNome = null;
$loPlaca = null;
$loChassi = null;
$loRenavam = null;
$loAnoVeiculo = null;
$loAnoModelo = null;
$loNumMotor = null;
$loIdPessoaMatriz = null;
$loIdPessoaCad = null;
$loDtCad = null;
$loDtAlt = null;
$loIdUsuarioCad = null;
$loIdUsuarioAlt  = null;
$loAtivo         = 1; 
$loIdNivelCombustivel = null;

$loQtdPassageiro = 5; 
$loPortas  = null;
$loKm  = null;
$loExclusivo = null; 
$lodata_substituidoDev  = null; 
$loIdGaragem = null;
$loIndExclusivoCheck = "";
$loSituacao = null;
$loMotivoDesativacao = null;
$loDataHoraDesativacao = null;
$loUsuarioDesativacao = null;

$loAcao = $_REQUEST["acao"];



if(isset($_REQUEST["id"]))
{
    $loIdVeiculo = $_REQUEST["id"];

    $loDadosC = array( 'nome' => '', 'id' => $loIdVeiculo, 'status' => '0,1' );
    $loExibir = $loVeiculo->ListaVeiculo($loDadosC);


    foreach ($loExibir as $row){

        $loIdVeiculo            = $row["id_veiculo"];
        $loIdModelo             = $row["id_modelo"];
        $loNomeModelo           = $row["nomeModelo"];
        $loIdCombustivel        = $row["id_combustivel"];
        $loNomeCombustivel      = $row["nomeCombustivel"];
        $loIdCor                = $row["id_cor"];
        $loNome                 = $row["nomeCor"];
        $loPlaca                = $row["placa"];
        $loChassi               = $row["chassi"];
        $loRenavam              = $row["renavam"];
        $loAnoVeiculo           = $row["ano_veiculo"];
        $loAnoModelo            = $row["ano_modelo"];
        $loNumMotor             = $row["num_motor"];
        $loIdPessoaMatriz       = $row["id_pessoa_matriz"];
        $loIdPessoaCad          = $row["id_pessoa_cad"];
        $loDtCad                = $row["dt_cad"];
        $loDtAlt                = $row["dt_alt"];
        $loIdUsuarioCad         = $row["id_usuario_cad"];
        $loIdUsuarioAlt         = $row["id_usuario_alt"];
        $loAtivo                = $row["ativo"];
        $loIdNivelCombustivel   = $row["id_nivel_combustivel"];
        $loQtdPassageiro        = $row["qtd_passageiro"]; 
        $loPortas               = $row["portas"];
        $loKm                   = $row["km"];
        $loExclusivo            = $row["exclusivo"]; 
        $lodata_substituidoDev  = $row["data_substituidoDev"];
        $loIdGaragem            = $row["id_localidade_garagem"];
        $loSituacao             = $row["situacao"];
        $loMotivoDesativacao    = $row["motivo_desativacao"];
        $loDataHoraDesativacao  = $row["dt_alt_status"];
        $loUsuarioDesativacao   = $row["nome_usuario_alt_status"];


        if($loExclusivo == 1){ $loIndExclusivoCheck = "checked"; }


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

                    <div class="col-md-7">
                    
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-automobile"></i>
                                        <span class="caption-subject font-dark sbold uppercase">Veiculos</span>
                                    </div>
                   
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                        
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Placa *</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="placa" class="form-control mask_placa"  value="<?php echo $loPlaca; ?>" >
                                                  </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Modelo *</label>
                                                <div class="col-md-9">
                                                     <select class="form-control" id="modelo">

                                                        <?php

                                                            $loModelo = new modeloBO();
                                                            $loDadosC = array( 'nome' => '', 'id' => '' );
                                                            $loExibir = $loModelo->ListaModelo($loDadosC);

                                                            echo "<option value='' ></option>";
                                                            foreach ($loExibir as $row){
                                                                
                                                                $loSelectedM = "";
                                                                if($row["id_modelo"] == $loIdModelo){ $loSelectedM = "selected";  }
                                                                echo "<option value='".$row["id_modelo"]."' ".$loSelectedM." >".$row["nome"]."</option>";

                                                            }

                                                        ?>
                                                     
                                                     </select>
                                                  </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Combustivel</label>
                                                <div class="col-md-3">
                                                     <select class="form-control" id="combustivel">

                                                     <?php

                                                            $loCombustivel = new combustivelBO();
                                                            $loDadosC = array( 'nome' => '', 'id' => '' );
                                                            $loExibir = $loCombustivel->ListaCombustivel($loDadosC);

                                                            echo "<option value='' ></option>";
                                                            foreach ($loExibir as $row){

                                                                $loSelectedC = "";
                                                                if($row["id_combustivel"] == $loIdCombustivel){ $loSelectedC = "selected";  }
                                                                echo "<option value='".$row["id_combustivel"]."' ".$loSelectedC." >".$row["nome"]."</option>";

                                                            }

                                                        ?>

                                                     </select>
                                                  </div>
                                                  <label class="col-md-2 control-label">Cor.</label>
                                                  <div class="col-md-4">
                                                     <select class="form-control" id="cor">


                                                     <?php

                                                            $loCor = new corBO();
                                                            $loDadosC = array( 'nome' => '', 'id' => '' );
                                                            $loExibir = $loCor->ListaCor($loDadosC);

                                                            echo "<option value='' ></option>";
                                                            foreach ($loExibir as $row){

                                                                $loSelectedCo = "";
                                                                if($row["id_cor"] == $loIdCor){ $loSelectedCo = "selected";  }
                                                                echo "<option value='".$row["id_cor"]."' ".$loSelectedCo." >".$row["nome"]."</option>";

                                                            }

                                                        ?>

                                                     </select>
                                                  </div>
                                            </div> 


                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Ano Modelo</label>
                                                <div class="col-md-2">
                                                    <input type="text" id="ano-modelo" class="form-control "  value="<?php echo $loAnoModelo; ?>" >
                                                  </div>
                                                  <label class="col-md-3 control-label">Ano Veiculo</label>
                                                  <div class="col-md-2">
                                                    <input type="text" id="ano-veiculo" class="form-control"  value="<?php echo $loAnoVeiculo; ?>" >
                                                  </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Chassi </label>
                                                <div class="col-md-5">
                                                    <input type="text" id="chassi" class="form-control"  value="<?php echo $loChassi; ?>" >
                                                  </div>
                                            </div>   

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Renavam </label>
                                                <div class="col-md-5">
                                                    <input type="text" id="renavam" class="form-control"  value="<?php echo $loRenavam; ?>" >
                                                  </div>
                                            </div>    


                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Qtd Passageiro</label>
                                                <div class="col-md-2">
                                                    <input type="text" id="qtd-passageiro" class="form-control "  value="<?php echo $loQtdPassageiro; ?>" >
                                                  </div>
                                                  <label class="col-md-3 control-label">Portas</label>
                                                  <div class="col-md-2">
                                                    <input type="text" id="portas" class="form-control"  value="<?php echo $loPortas; ?>" >
                                                  </div>
                                            </div>    

                                             <div class="form-group">
                                                <label class="col-md-3 control-label">KM </label>
                                                <div class="col-md-5">
                                                    <input type="text" id="km" class="form-control"  value="<?php echo $loKm; ?>" >
                                                  </div>
                                            </div>                                                                                 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Nivel Combustivel</label>
                                                <div class="col-md-5">
                                                     <select class="form-control" id="nivel_combustivel">


                                                     <?php

                                                            $loDadosC = array( 'nome' => '', 'id' => '' );
                                                            $loExibir = $loVeiculo->ListaNivelCombustivel($loDadosC);

                                                            echo "<option value='' ></option>";
                                                            foreach ($loExibir as $row){

                                                                $loSelectedN = "";
                                                                if($row["id_nivel_combustivel"] == $loIdNivelCombustivel ){ $loSelectedN = "selected";  }
                                                                echo "<option value='".$row["id_nivel_combustivel"]."' ".$loSelectedN." >".$row["nome"]."</option>";

                                                            }

                                                        ?>


                                                     </select>
                                                  </div>
                                            </div>  
                                            
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Substituido/Devl.</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="data-substituido-dev" class="form-control mask_date"  value="<?php echo $lodata_substituidoDev; ?>" >
                                                  </div>
                                                   <label class="col-md-2 control-label">Situa&ccedil;&atilde;o</label>
                                                  <div class="col-md-3">
                                                   <select class="form-control" id="situacao">
                                                         <option value='' ></option>
                                                         <option value='D' <?php if($loSituacao == "D"){ echo "selected"; } ?> >Disponivel</option>
                                                         <option value='U' <?php if($loSituacao == "U"){ echo "selected";  } ?> >Em Uso</option>
                                                    </select>
                                                  </div>   
                                                  
                                            </div>  
                                                  
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Garagem</label>
                                                <div class="col-md-5">
                                                     <select class="form-control" id="garagem">

                                                     <?php

                                                            $loDadosGaragem = array('id' => $loIdGaragem);
                                                            $loExibirGaragem = $loVeiculo->ListaGaragem($loDadosGaragem);

                                                            echo "<option value='' ></option>";
                                                            foreach ($loExibirGaragem as $row){
                                                                
                                                                $loSelectedGaragem = "";
                                                                if($row["id"] == $loIdGaragem){ $loSelectedGaragem = "selected";  }
                                                                echo "<option value='".$row["id"]."' ".$loSelectedGaragem." >".$row["nome"]."</option>";

                                                            }

                                                        ?>  

                                                     </select>
                                                  </div>
                                            </div>   

                                                                                        
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Exclusivo</label>
                                                <div class="col-md-5">
                                                  <input type="checkbox" id="exclusivo" class="form-control" <?php echo $loIndExclusivoCheck; ?> value="" >
                                                  </div>
                                            </div>                                  
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"  >Status</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="status">
                                                        <option <?php if($loAtivo == 1 ){ echo "selected"; }?> value="1" >Ativo</option>
                                                        <option <?php if($loAtivo != 1  ){ echo "selected"; }?> value="0" >Desativado</option>
                                                    </select>
                                                </div>

                                            </div>

                                             <div class="form-group div-motivo-desativacao">
                                                <label class="col-md-3 control-label">Motivo Desativa&ccedil;&atilde;o *</label>
                                                <div class="col-md-5">
                                                    <textarea id="motivo_desativacao" rows="4" cols="50"></textarea>
                                                </div>
                                             </div>

                                              <?php if($loAtivo == 0 && $loMotivoDesativacao != ""){ ?>
                                              <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-5">
                                                    <div class="alert alert-info">
                                                        <strong>Motivo Desativa&ccedil;&atilde;o:</strong><br />
                                                        <?php echo $loMotivoDesativacao; ?><br />
                                                        <?php echo "<strong> Data Hora: </strong> ".$loDataHoraDesativacao; ?><br />
                                                        <?php echo "<strong> Usuario: </strong> ".$loUsuarioDesativacao; ?>
                                                        </div>
                                                    </div>
                                                
                                             </div>
                                              <?php } ?>



                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loIdVeiculo; ?>" />
                                                    <input type="hidden" id="id-menu" value="<?php echo $IdMenu; ?>" />
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

        <script src="js/veiculo.js" type="text/javascript"></script>
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