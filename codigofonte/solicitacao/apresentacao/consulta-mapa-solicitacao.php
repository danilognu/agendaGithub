<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../../pessoa/negocio-pessoa.php");  ?>
<?php  include("../negocio-solicitacao.php");  ?>

<?php


if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

$loSolicitacao = new solicitacaoBO();
$loPessoa = new pessoaBO();

?>
<html>

    <head>
        
        <title>MAPA DE SOLICITACOES | Agenda Lets  </title>
        
         <!-- CABECALHO BEGIN -->
         <?php //include("../../comum/apresentacao/cabecalho.php"); ?>

        <?php header("Content-Type: text/html; charset=ISO-8859-1"); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->       
        <link href="../../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/bootstrap/css/bootstrap.lets.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!--link href="../../../assets/layouts/layout3/css/layout.css" rel="stylesheet" type="text/css" /-->
        <!-- Alterar -->
        <!--link href="../../../assets/layouts/layout3/css/themes/lets.css" rel="stylesheet" type="text/css" id="style_color" /-->

        <link href="../../../assets/layouts/layout3/css/custom.css" rel="stylesheet" type="text/css" />

        <link href="../../../assets/layouts/layout3/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>

         <!-- CABECALHO HEAD -->
        <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
 
        <link href="../../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />


    </head>

    <body class="page-container-bg-solid page-boxed">
        <!-- BEGIN HEADER -->
        <div class="">
            <!-- BEGIN  TOP -->
            <?php //include("../../comum/apresentacao/topo.php"); ?>
            <!-- END  TOP -->

            <!-- BEGIN  MENU -->            
            <?php //include("../../menu/apresentacao/menu-horizontal.php"); ?>
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
                    <div class="" >
                     
                     <!-- Inicio -->


                       <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered "> 
                                <div class="portlet box dark">
                                    <div class="caption">
                                        <i class="fa fa-map" style="color:#FFF;"></i>
                                        <span class="caption-subject bold uppercase" style="color:#FFF;" > Mapa de Solicita&ccedil;&otilde;es</span>
                                    </div>
                                   
                                </div>

                                <!--h6><i class="fa fa-filter"></i> Filtro</h6-->
                   

                                <form class="form-inline" role="form" id="form-filtro" style="padding-left:15px;">



                                            <div class="">
                                                
                                                 <div class="form-group">
                                                 Ordenar Por<br />
                                                <select class="form-control input-sm" id="filtro-ordenar" name="status" >
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
                                                   <input type="text" id="filtro-data-inicio" class="form-control input-sm mask_date" size="10" name="" >
                                                   </div>
                                                    <div class="form-group">
                                                    ate <br />
                                                    <input type="text" id="filtro-data-fim" class="form-control input-sm mask_date" size="10" name="" >
                                                    </div>
                                                    <div class="form-group">
                                                    Situa&ccedil;&atilde;o <br />
                                                    <select class="form-control input-sm" nome="filtro-situacao" id="filtro-situacao" onClick="Solicitacao.Situacao_onClick(this);" >
                                                                        
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

                                           <div class="form-group">
                                                Localidade Origem<br />
                                                <input type="hidden" id="todas-origem"  >
                                                <!--todas as localidade de origem
                                                <br /-->
                                                <input type="text" id="nome-origem" class="form-control input-sm" size="20" name="" >  
                                                <input type="hidden" id="codigo-origem" class="" name="" >  
                                                  <a href="#" id="pesquisa-mapa-origem" class="btn origem">
                                                            <i class="fa fa-search"></i>
                                                    </a>                                                  
                                            </div> 


                                            <div class="form-group">
                                                Localidade Destino<br />
                                                <input type="hidden" id="todas-destino"  >
                                                <!--todas as localidade de destino
                                                <br /-->
                                                <input type="text" id="nome-destino" class="form-control input-sm" size="20" name="" >
                                                <input type="hidden" id="codigo-destino" class="" name="" >   
                                                  <a href="#" id="pesquisa-mapa-destino" class="btn destino">
                                                            <i class="fa fa-search"></i>
                                                    </a>  


                                            </div> 
                                            <div class="form-group">   
                                                     Placa <br />
                                                    <input type="text" id="filtro-placa" class="form-control input-sm mask_placa" size="7" name="placa" >
                                            </div> 
 
                                            </div>




                                                          
                                        
                                            <input type="hidden" name="id-menu-exp" id="id-menu-exp" value="<?php echo $IdMenu; ?>" />
                                            <input type="hidden" name="nomenclatura" id="nomenclatura" value="Solicitacao" />
                                            <input type="hidden" name="titulo" id="titulo" value="Relatorio Solicitacao" />         
                                    </form>

                                          <br/>

                                           <div class="form-group" > 
                                                <div class="col-md-3">
                                                    Motorista <br />  
                                                     <select class="form-control select2me" name="options2" id="filtro-select-motorista" >
                                                            <option value=""></option>
                                                            <?php
                                                                $loDadosC = array( 
                                                                        'tipo_pessoa' => '4,5'
                                                                            , 'ind_motorista' => '1'
                                                                    );

                                                                    $loLista =  $loPessoa->ListaPessoa($loDadosC);

                                                                    if(count($loLista) > 0){

                                                                        foreach ($loLista as $row){
                                                                            ?>
                                                                            <option value="<?php echo $row["id_pessoa"]; ?>"><?php echo $row["nome"]; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                            
                                                                ?>
                                                        </select>                                                          
                                                </div>   
                                                <br />    
                                                  <a href="#" id="pesquisa-mapa" class="btn sbold dark">Pesquisar
                                                            <i class="fa fa-search"></i>
                                                    </a>    
                                            </div>

                                    



                    

                                    <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">

                                            </div>
                                  

                                        <div class="col-md-5">

                                               
                                            </div>

                                            <div class="col-md-1">

            
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

                                        </div>
                                    </div>
                                    

                                <table class="table table-striped table-bordered table-hover" id="">
                                        <thead>
                                            <tr>
                                                <!--th width="2px;"></th-->
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

                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody id="conteudo" >
   
                                           <?php include("consulta-mapa-solicitacao-ajax.php"); ?>

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
        <?php //include("../../comum/apresentacao/rodape.php"); ?>
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
        <script src="../../../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>

        <!-- scripts END -->

        <script language="Javascript">
            window.onload = function () {
                setTimeout('location.reload();', 30000);
            }
        </script>

    </body>

</html>