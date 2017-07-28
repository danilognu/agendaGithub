<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-solicitacao.php");  ?>

<?php

$idSolicitacao = NULL;
$situacao = NULL;
$indCarona = NULL;

if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}
if(isset($_REQUEST["id"])){ $idSolicitacao = $_REQUEST["id"]; }
if(isset($_REQUEST["situacao"])){ $situacao = $_REQUEST["situacao"]; }else{ $loSituacao = "2,3,6,7"; }
if(isset($_REQUEST["ind_carona"])){ $indCarona = $_REQUEST["ind_carona"]; }

$loSolicitacao = new solicitacaoBO();
$loComum = new comumBO();

//$loIndCarona = $loComum->VerificaCarona();

//Verifica Grupo Acesso Usuario
$loGrupoAcessoUser = $loSolicitacao->VerificaGrupoAcessoUsuario();
$loGrupoAcessoUsuario = $loGrupoAcessoUser["ind_usuario"];
$loGrupoAcessoGestor = $loGrupoAcessoUser["ind_gestor"];
$loGrupoAcessoOperador = $loGrupoAcessoUser["ind_operador"];
$loGrupoAcessoAdm = $loGrupoAcessoUser["ind_adm"];

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
                                <div class="portlet">
                                    <div class="caption font-dark">
                                        <i class="fa fa-pencil-square-o"></i>
                                        <span class="caption-subject bold uppercase"> Atendimentos </span>
                                    </div>
                                   
                                </div>

                                <h5><i class="fa fa-filter"></i> Filtro</h5>
                   

                                <form class="form-inline" role="form" id="form-filtro">


                                        <div class="form-group" >
                                               
                                                <label class="col-md-4 control-label">Codigo</label>
                                                <div class="col-md-3">
                                                    <input type="text" id="filtro-codigo-localidade" name="id" value="<?php echo $idSolicitacao != "" ? $idSolicitacao : "";  ?>" class="form-control input-sm mask_number"  size="5" >

                                                </div>
                                            </div>

                                            <div class="form-group">
                                            <select class="form-control input-sm input-small" id="filtro-situacao" name="situacao" >
                                             <option value='0'>Todos</option>
                                             <?php
                                                
                                                $loSituacao =  $loSolicitacao->ListaSituacao('');
                                                foreach ($loSituacao as $row){
                                                    $row["id_status_solicitacao"] == $situacao ? $selectedSituacao = "selected" : $selectedSituacao = "";               
                                                    echo "<option value='".$row["id_status_solicitacao"]."' ".$selectedSituacao." >".$row["nome"]."</option>";
                                                }

                                             ?>       
                                            </select>   
                                            </div>
                                            <div class="form-group">
                                            <input type="checkbox" id="requer-carona" size="5" <?php echo $indCarona == 1 ? "checked" : ""; ?> > Requer carona
                                            </div>

                                        
                                        <div class="form-group">
                                        </div>
                                        <div class="btn-group btn-group-sm btn-group-solid">
                                                <a href="#" id="pesquisa-atendimento" class="btn dark"> Pesquisar
                                                        <i class="fa fa-search"></i>
                                                </a>
                                        </div>
   

                                         <input type="hidden" name="id-menu-exp" id="id-menu-exp" value="<?php echo $IdMenu; ?>" />
                                         <input type="hidden" name="nomenclatura" id="nomenclatura" value="Solicitacao" />
                                         <input type="hidden" name="titulo" id="titulo" value="Relatorio Solicitacao" />    
                                         <input type="hidden" name="tela_atendimento" id="tela_atendimento"  />         
                                    </form>

                                    <br />


                                    <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group btn-group-sm btn-group-solid">
                                                    <?php if ($loComumBO->VerificaItemArray($verificaPermissao,"A")) {   ?>
                                                    <!--button id="btn-adicionar" class="btn dark"> Adicionar
                                                        
                                                        <i class="fa fa-plus"></i>
                                                    </button-->
                                                    <?php } ?>
                                                </div>
                                                <!--div class="btn-group">
                                                    <button id="btn-desativar" class="btn sbold dark"> Desativar
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                    btn-group btn-group-sm btn-group-solid
                                                </div-->
                                            </div>
                                  

                                        <div class="col-md-5">

                                                <div class="btn-group pull-right">
                                                    <button class="btn dark  btn-outline dropdown-toggle" data-toggle="dropdown">Colunas
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        
                                                            
                                                            <?php
                                                                $loGridItens =  $loSolicitacao->GridConsultaItens($IdMenu);

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
                                                            <a href="#" id="exportar-excel-atencimento">
                                                                <i class="fa fa-file-excel-o"></i> Exportar Excel </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" id="exportar-pdf-atencimento">
                                                                <i class="fa fa-file-pdf-o"></i> Exportar PDF </a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    

                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th style="width:1px;"></th>
                                                <?php

                                                //Cabeçalho da consulta dinamica 
                                                $loDadosC = array( 
                                                         'id_menu' => $IdMenu 
                                                    );

                                                $loItensConsulta =  $loSolicitacao->ListaItensConsulta($loDadosC);

                                                 foreach ($loItensConsulta as $row){
                                                     
                                                     $loItens = explode(",", $row["campo_visual"]);   

                                                      $contaItem = count($loItens);
                                                      $contador = 1;
                                                      foreach ($loItens as $item){

                                                            $ultimoItem = "";
                                                            if($contador == $contaItem){
                                                                $ultimoItem = "ultimo";
                                                            }  
                                                            
                                                            echo " <th> ".$item." </th>"; 
                                                            $contador++; 
                                                      }
                                                 }
                                                
                                                 if($loGrupoAcessoOperador == 1){
                                                    $loCaronaPendente = $loSolicitacao->VerificaSeExisteCaronaPendentedeAprovacao();
                                                    if($loCaronaPendente > 0){
                                                        echo " <th> Aut.Carona </th>"; 
                                                    }
                                                 }

                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody id="conteudo" >
   
                                           <?php include("consulta-atencimentos-ajax.php"); ?>

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
        <div id="dialog-message" ></div>
        <div id="dialog-itens" ></div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
      
        <!-- BEGIN INNER FOOTER -->
        <?php include("../../comum/apresentacao/rodape.php"); ?>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->



        <!-- scripts BEGIN -->
        <?php include("../../comum/apresentacao/scripts.php"); ?>

         <script src="js/solicitacao.js" type="text/javascript"></script>

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