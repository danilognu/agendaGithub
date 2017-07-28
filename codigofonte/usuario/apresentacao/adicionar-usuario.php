<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../../pessoa/negocio-pessoa.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-setor.php");  ?>
<?php  include("../negocio-grupo-acesso.php");  ?>
<?php  include("../negocio-usuario.php");  ?>

<?php

$loNome = null;
$loLogin = null;
$loEmail = null;
$loSenha = null;
$loNomeFilial = null;
$loIndAtivo = 1;
$loIdUsuario = 0;
$loIDGrupoAcesso = null;
$loIDSetor = null;
$loIdPesoaOrigem = null;
$loIndPermissaoUsuario = null;
$loIndPermissaoGestor = null;
$loIDGrupoAcessoUsuarioLogado = null;

$loAcao = $_REQUEST["acao"];

//Pessoa
$loPessoa = new pessoaBO();
$loUsuario = new usuarioBO();
$loComum = new comumBO();

if(isset($_REQUEST["id"]))
{
    $loIdUsuario = $_REQUEST["id"];

    
    $loDadosC = array( 'tipo' => 'exibir', 'id' => $loIdUsuario );
    $loExibirUser = $loUsuario->ListaUsuarios($loDadosC);

    foreach ($loExibirUser as $row){

        $loNome = $row["nome"];
        $loLogin = $row["login"];
        $loEmail = $row["email"];
        $loIndAtivo = $row["ativo"];
        $loSenha = $row["senha"];
        $loNomeFilial = $row["nome_filial"];
        $loIDFilial = $row["id_pessoa_filial"];
        $loIDGrupoAcesso = $row["id_grupo"];
        $loIDSetor = $row["id_setor"];
        $loIdPesoaOrigem = $row["id_pessoa_origem"];
        $loIndPermissaoUsuario  = $row["ind_usuario"];
        $loIndPermissaoGestor  = $row["ind_gestor"];


    }
}else{

    $loDadosC = array( 
        'id' => $_SESSION["id_pessoa_matriz"]
    );
    $loLista =  $loUsuario->BuscaNomeFilial($loDadosC);
    if(count($loLista)>0){
        foreach ($loLista as $row){
            $loNomeFilial = $row["nome"];
        }
    }

}

$ItensDisabled = NULL;
if($loIndPermissaoUsuario == 1 || $loIndPermissaoGestor == 1){
    $ItensDisabled = "disabled";
}


$loVlUsuarioLogado = $loUsuario->BuscaIDGrupoUsuarioLogado();

foreach ($loVlUsuarioLogado as $row){
    $loIDGrupoAcessoUsuarioLogado = $row["id_grupo"];
}


if($loIDGrupoAcessoUsuarioLogado == 4){
    $ItensDisabled = "disabled";
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
                    <div class="" style="padding-left:50px">
                     
                     <!-- Inicio -->


                  <div class="row">

                    <div class="col-md-8">
                    


                                <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                       <i class="fa fa-user font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase">Usuario - <?php echo $loNome; ?></span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="tabbable tabbable-tabdrop">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab1" data-toggle="tab">Dados Basicos</a>
                                            </li>
                                            <?php if($loIDGrupoAcessoUsuarioLogado == 1 || $loIDGrupoAcessoUsuarioLogado == 4 || $_SESSION["supervisor"] == 1){ ?>
                                                <li>
                                                    <a href="#tab2" data-toggle="tab">Pessoas que Autorizo</a>
                                                </li>
                                                <li>
                                                    <a href="#tab3" data-toggle="tab">Pessoas que me Autorizam</a>
                                                </li>   
                                            <?php } ?>                                         
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                
                                                <!-- INICIO CONTEUDO ABA 1 - USUARIO -->    

                                                    <!-- BEGIN SAMPLE FORM PORTLET-->
                                                    <div class="portlet light bordered">
                         
                                                        <div class="portlet-body form">
                                                            <form class="form-horizontal" role="form">
                                                                <div class="form-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Nome</label>
                                                                        <div class="col-md-5">
                                                                            <input type="text" disabled id="nome" class="form-control" value="<?php echo $loNome; ?>" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Login*</label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-inline input-medium">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-user"></i>
                                                                                    </span>
                                                                                    <input type="text" id="login" class="form-control" value="<?php echo $loLogin; ?>" > </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Senha*</label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="input-icon">
                                                                                    <i class="fa fa-lock fa-fw"></i>
                                                                                    <input id="senha" class="form-control" type="password" name="senha" value="" /> </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Confirmar Senha</label>
                                                                        <div class="col-md-9">
                                                                            <div class="input-group">
                                                                                <div class="input-icon">
                                                                                    <i class="fa fa-lock fa-fw"></i>
                                                                                    <input id="confi-senha" class="form-control" type="password" name="confi-senha"  value="" /> </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                            <label class="col-md-2 control-label">E-mail*</label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-envelope"></i>
                                                                                    </span>
                                                                                    <input type="email" id="email" class="form-control"  value="<?php echo $loEmail; ?>" > </div>
                                                                            </div>
                                                                        </div>
                                                               
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Status</label>
                                                                        <div class="col-md-3">
                                                                            <select class="form-control" id="status" <?php echo $ItensDisabled; ?> >
                                                                                <option <?php if($loIndAtivo == 1 ){ echo "selected"; }?> value="1" >Ativo</option>
                                                                                <option <?php if($loIndAtivo != 1  ){ echo "selected"; }?> value="0" >Desativado</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                              
                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Grupo de Acesso</label>
                                                                        <div class="col-md-5">

                                                                            <select class="form-control" nome="grupo-acesso" id="grupo-acesso" <?php echo $ItensDisabled; ?> >
                                                                            
                                                                            <?php 

                                                                            $loGrupo = new grupoAcessoBO();
                                                                                
                                                                            $loDadosC = array( 
                                                                                        'id' => '' 
                                                                                    );

                                                                                $loListaGrupo =  $loGrupo->ListaGrupoAcesso($loDadosC);
                                                                            
                                                                            echo "<option value='' ></option>" ;      
                                                                                
                                                                                foreach ($loListaGrupo as $row){
                                                                                    
                                                                                    $loSelected = "";
                                                                                    if($loIDGrupoAcesso  == $row["id_grupo"]){
                                                                                        $loSelected = "selected";
                                                                                    }

                                                                                    echo "<option value=".$row["id_grupo"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                                }     
                                                                            ?>
                                                                            
                                                                            </select>
                                                                            
                                                        
                                                                        </div>
                                                                    </div>


                                                                <div class="form-group">
                                                                        <label class="col-md-2 control-label">Empresa</label>
                                                                        <div class="col-md-5">
                                                                            <?php if($_SESSION["supervisor"] == 1) {  ?>


                                                                            <select class="form-control" nome="empresa" id="empresa" >
                                                                            
                                                                            <?php 

                                                                                
                                                                            $loDadosC = array( 
                                                                                        'tipo_pessoa' => 1
                                                                                    );

                                                                            $loLista =  $loPessoa->ListaPessoa($loDadosC);
                                                                            
                                                                            echo "<option value='' ></option>" ;      
                                                                                
                                                                                foreach ($loLista as $row){
                                                                                    
                                                                                    $loSelected = "";
                                                                                    if($loIDFilial == $row["id_pessoa"]){
                                                                                        $loSelected = "selected";
                                                                                    }

                                                                                    echo "<option value=".$row["id_pessoa"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                                }     
                                                                            ?>
                                                                            
                                                                            </select>
                                                                            
                                                                                
                                                                            <?php }else{ ?> 
                                                                            <input type="filial" id="filial" class="form-control" disabled  value="<?php echo $loNomeFilial; ?>" >
                                                                            <input type="hidden" nome="empresa" id="empresa"  value="<?php echo $_SESSION["id_pessoa_matriz"]; ?>" >
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>

                                                                <div class="form-actions">
                                                                    <div class="row">
                                                                        <div class="col-md-offset-3 col-md-9">
                                                                            <button type="button" class="btn dark btn-gravar-dados" >Alterar</button>
                                                                            <?php if($loIDGrupoAcesso == 4 || $loIDGrupoAcesso == 1 || $_SESSION["supervisor"] == 1){ ?>
                                                                            <button type="button" class="btn default btn-cancelar-form">Cancelar</button>
                                                                            <?php } ?>
                                                                            <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                                            <input type="hidden" id="id_usuario" value="<?php echo $loIdUsuario; ?>" />
                                                                            <input type="hidden" id="id_pessoa_origem" value="<?php echo $loIdPesoaOrigem; ?>" />                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- END SAMPLE FORM PORTLET-->

                                                <!-- FIM CONTEUDO ABA 1 - USUARIO -->    


                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                

                                                <!-- INCIO CONTEUDO ABA 2 - AUTORIZAÇÕES -->      
                                                <p> &nbsp; </p>

                                                <div class="btn-group">
                                                    <button id="btn-adicionar-quem-autorizo-pesq" class="btn sbold dark"> Adicionar pessoa para autoriza&ccedil;&atilde;o 
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
        
                                                    <div class="table-scrollable">
                                                        <table class="table table-striped table-bordered table-hover order-column" id="table-pessoa-quem-autorizo" >
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"> Codigo </th>
                                                                    <th> Nome usuario </th>
                                                                    <th> A&ccedil;&atilde;o </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php

                                                                    $loListaAut =  $loUsuario->PesquisaAutorizadoresUsuario($loIdPesoaOrigem);

                                                                    if(count($loListaAut) > 0 ){

                                                                        foreach ($loListaAut as $row){
                                                                ?>

                                                                <tr>
                                                                    <td> <?php echo $row["id_pessoa"]; ?> </td>
                                                                    <td> <?php echo $row["nome"]; ?> </td>
                                                                    <td>                                                                     
                                                                         <button onClick="Usuario.RemoverLinhaExcluirAutorizador(this,<?php echo $loIdPesoaOrigem;?>,<?php echo $row["id_pessoa"];?>);" class="btn red "> 
                                                                           <i class="fa fa-close"></i> 
                                                                        </button>
                                                                        <input type='hidden'  class='codigo-pessoa-cad-quem_autorizo' value='<?php echo $row["id_pessoa"]; ?>' />
                                                                    </td>
                                                                </tr>

                                                                        <?php }
                                                                    } ?>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                               <br />
                                               <br />
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-offset-1 col-md-9">
                                                            <button type="button" class="btn dark btn-gravar-dados">Alterar</button>
                                                            <button type="button" class="btn default btn-cancelar-form">Cancelar</button>
                                                            <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                            <input type="hidden" id="id_usuario" value="<?php echo $loIdUsuario; ?>" />
                                                        </div>
                                                    </div>
                                                </div>   

                                                <!-- FIM CONTEUDO ABA 2 - AUTORIZAÇÕES -->  

                                            </div>



                                            <div class="tab-pane" id="tab3">
                                                

                                                <!-- INCIO CONTEUDO ABA 3 - AUTORIZAÇÕES -->      
                                                <p> &nbsp; </p>

                                                <div class="btn-group">
                                                    <button id="btn-adicionar-quem-me-autoriza-pesq" class="btn sbold dark"> Adicionar pessoa que me autoriza 
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
        
                                                    <div class="table-scrollable">
                                                        <table class="table table-hover" id="table-pessoa-que-me-autoriza" >
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"> Codigo </th>
                                                                    <th> Nome usuario </th>
                                                                    <th> A&ccedil;&atilde;o </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php

                                                                    $loListaAut =  $loUsuario->PesquisaQueAutorizaUsuarioCorrente($loIdPesoaOrigem);

                                                                    if(count($loListaAut) > 0 ){

                                                                        foreach ($loListaAut as $row){
                                                                ?>

                                                                <tr>
                                                                    <td> <?php echo $row["id_pessoa"]; ?> </td>
                                                                    <td> <?php echo $row["nome"]; ?> </td>
                                                                    <td>                                                                     
                                                                         <button onClick="Usuario.RemoverLinhaExcluirAutorizador(this,<?php echo $row["id_pessoa"];?>,<?php echo $loIdPesoaOrigem;?>);" class="btn red "> 
                                                                           <i class="fa fa-close"></i> 
                                                                        </button>
                                                                        <input type='hidden' class='codigo-pessoa-cad-quem_me_autoriza' value='<?php echo $row["id_pessoa"]; ?>' />
                                                                    </td>
                                                                </tr>

                                                                        <?php }
                                                                    } ?>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                               <br />
                                               <br />
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-offset-1 col-md-9">
                                                            <button type="button" class="btn dark btn-gravar-dados">Alterar</button>
                                                            <button type="button" class="btn default btn-cancelar-form">Cancelar</button>
                                                            <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                            <input type="hidden" id="id_usuario" value="<?php echo $loIdUsuario; ?>" />
                                                        </div>
                                                    </div>
                                                </div>   

                                                <!-- FIM CONTEUDO ABA 3 - AUTORIZAÇÕES -->  

                                            </div>                                            
 
                                        </div>
                                    </div>

                                </div>
                            </div>








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
        <?php //include("../../comum/apresentacao/rodape.php"); ?>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->


        <div id="dialog-message"></div>

        <!-- scripts BEGIN -->
        <?php include("../../comum/apresentacao/scripts.php"); ?>

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>

         <script src="js/usuario.js" type="text/javascript"></script>
         <script src="../../comum/js/comum.js" type="text/javascript"></script>

        <script src="../../../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <!-- scripts END -->

    </body>

</html>