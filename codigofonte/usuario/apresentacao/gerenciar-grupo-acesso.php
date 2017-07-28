<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-grupo-acesso.php");  ?>

<?php


$loIdGrupo = "";
if(isset($_REQUEST["id_grupo"])){
    $loIdGrupo = $_REQUEST["id_grupo"];
}


$loGrupo = new grupoAcessoBO();

$loNome         = null;
$loAcao         = $_REQUEST["acao"];
$loIndGestor    =  null;
$loIndOperador  =  null;
$loIndAdm       =  null;
$loIndUsuario   = null;
$loIndGestorCheck =  null;
$loIndOperadorCheck =  null;
$loIndAdmCheck      = null;
$loIndUsuarioCheck  = null;
    
$loDadosC = array( 'nome' => '', 'id' => $loIdGrupo );
$loExibir = $loGrupo->ListaGrupoAcesso($loDadosC);


foreach ($loExibir as $row){

    $loNome         = $row["nome"];
    $loIndGestor    = $row["ind_gestor"];
    $loIndOperador  = $row["ind_operador"];
    $loIndAdm       = $row["ind_adm"];
    $loIndUsuario   = $row["ind_usuario"];

    if($loIndGestor == 1){ $loIndGestorCheck = "checked"; }
    if($loIndOperador == 1){ $loIndOperadorCheck = "checked"; }
    if($loIndAdm == 1){ $loIndAdmCheck = "checked"; }
    if($loIndUsuario == 1){ $loIndUsuarioCheck = "checked"; }

}


?>  
<html>

    <head>
        
        <title>Agenda Lets | </title>
        
         <!-- CABECALHO BEGIN -->
         <?php include("../../comum/apresentacao/cabecalho.php"); ?>


        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../../../assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->


 
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




             <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-social-dribbble "></i>
                                        <span class="caption-subject bold uppercase">Grupos - <?php echo $loNome; ?> </span>
                                    </div>
                                   
                                </div>
                                <div class="portlet-body">
                                    <div id="tree_1" class="tree-demo">
                                        <ul>


                                        <?php


                                                $loListaMenu =  $loGrupo->ListaMenuMae();

                                                if(count($loListaMenu) > 0 ){

                                                    foreach ($loListaMenu as $row){
                                                        //Menu Mae
                                                    ?>

                                                       <li data-jstree='{ "selected" : false }'>
                                                            <a href="javascript:;"> <?php echo $row["nome"] ?> </a>

                                                            <ul>
                                                            <?php 
                                                            
                                                                $loListaMenuFilho =  $loGrupo->ListaMenuFilho($row["id_menu"]);
                                                                if(count($loListaMenuFilho) > 0 ){
                                                                    foreach ($loListaMenuFilho as $rowSub){
                                                                        //Menu Filho
                                                                    ?>
                                                                        
                                                                        <li data-jstree='{ "selected" : false }'> 
                                                                        
                                                                            <a href="javascript:;"><?php echo $rowSub["nome"]; ?> </a>
                                                                            <ul>

                                                                                <?php

                                                                                $loDadosPerm = array( 
                                                                                    'id_grupo' => $loIdGrupo
                                                                                    , 'id_usuario' => $_SESSION["id_usuario"] 
                                                                                    , 'id_menu' => $rowSub["id_menu"] 
                                                                                );

                                                                                $loListaPerm =  $loGrupo->VerificaPermissao($loDadosPerm);

                                                                                $class_Consult = "fa fa-close";
                                                                                $class_Alt = "fa fa-close";
                                                                                $class_Ex = "fa fa-close";
                                                                                $loAcesso_c = 0;
                                                                                $loAcesso_a = 0;
                                                                                $loAcesso_e = 0;
                                                                                if(count($loListaPerm) > 0 ){
                                                                                    foreach ($loListaPerm as $rowPerm){
                                                                                        if($rowPerm["tipo"] == "C"){
                                                                                            $class_Consult = "fa fa-check";
                                                                                            $loAcesso_c = 1;
                                                                                        }
                                                                                        if($rowPerm["tipo"] == "A"){
                                                                                            $class_Alt = "fa fa-check";
                                                                                            $loAcesso_a = 1;
                                                                                        }
                                                                                         if($rowPerm["tipo"] == "E"){
                                                                                            $class_Ex = "fa fa-check";
                                                                                            $loAcesso_e = 1;
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>

                                                                                <li data-jstree='{ "type" : "file" }' onClick="GrupoAcesso.ValidaPermissao(<?php echo $loIdGrupo; ?>,<?php echo $rowSub["id_menu"]; ?>,'C',<?php echo $loAcesso_c; ?>,'<?php echo $class_Consult; ?>',this);"> 
                                                                                    <span class="<?php echo $class_Consult; ?>" id="<?php echo $loIdGrupo ?><?php echo $rowSub["id_menu"]; ?>C"></span> Consultar 
                                                                                </li>
                                                                                <li data-jstree='{ "type" : "file" }'  onClick="GrupoAcesso.ValidaPermissao(<?php echo $loIdGrupo; ?>,<?php echo $rowSub["id_menu"]; ?>,'A',<?php echo $loAcesso_a; ?>,'<?php echo $class_Alt; ?>',this);" > 
                                                                                    <span class="<?php echo $class_Alt; ?>" id="<?php echo $loIdGrupo ?><?php echo $rowSub["id_menu"]; ?>A"></span>
                                                                                     Altera&#231;&otilde;es 
                                                                                </li>
                                                                                    <li data-jstree='{ "type" : "file" }'  onClick="GrupoAcesso.ValidaPermissao(<?php echo $loIdGrupo; ?>,<?php echo $rowSub["id_menu"]; ?>,'E',<?php echo $loAcesso_a; ?>,'<?php echo $class_Ex ; ?>',this);" > 
                                                                                    <span class="<?php echo $class_Ex ; ?>" id="<?php echo $loIdGrupo ?><?php echo $rowSub["id_menu"]; ?>E"></span>
                                                                                     Excluir
                                                                                </li>
                                                                            </ul>

                                                                        </li>
                                                                    
                                                                    <?php    
                                                                    }
                                                                }
                                                            ?>
                                                            </ul>    

                                                       </li>

                                                    <?php
                                                
                                                    }
                                                }

                                        ?>
                                          
                                          
                                        </ul>
                                    </div>
                                </div>


                            <br />    

                            <div class="form-group">
                                <label>Tipo Acesso</label>
                                <div class="input-group">
                                    <div class="icheck-list">
                                        <label>
                                            <input type="checkbox" id="ind-usuario" <?php echo $loIndUsuarioCheck; ?> class="icheck" data-checkbox="icheckbox_square-grey"> Usuario </label>                                      
                                        <label>
                                            <input type="checkbox" id="ind-operador" <?php echo $loIndOperadorCheck; ?> class="icheck" data-checkbox="icheckbox_square-grey"> Operador </label>

                                        <label>
                                            <input type="checkbox" id="ind-gestor" <?php echo $loIndGestorCheck; ?> class="icheck" data-checkbox="icheckbox_square-grey"> Gestor  </label>
                                        <label>
                                            <input type="checkbox" id="ind-adm" <?php echo $loIndAdmCheck; ?> class="icheck" data-checkbox="icheckbox_square-grey"> Administra&ccedil;&atilde;o </label>
                                          
                                    </div>
                                </div>
                            </div>

                            <br />


                            </div>





                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-permissao-dados" >Adicionar</button>
                                                    <button type="button" id="btn-cancelar-form" class="btn default">Cancelar</button>
                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loIdGrupo ?>" />
                                                </div>
                                            </div>
                                        </div>

                        </div>

                    </div>
                   
                    <!-- END PAGE CONTENT-->






            </div>
            <!-- END CONTENT -->
           




        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
      
        <!-- BEGIN INNER FOOTER -->
        <?php //include("../../comum/apresentacao/rodape.php"); ?>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->



        <!-- scripts BEGIN -->
        <?php include("../../comum/apresentacao/scripts.php"); ?>

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../../../assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->


        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../../../assets/pages/scripts/ui-tree.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->


         <script src="js/grupo-acesso.js" type="text/javascript"></script>
         <script src="../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
         <script src="../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>


  

    </body>

</html>