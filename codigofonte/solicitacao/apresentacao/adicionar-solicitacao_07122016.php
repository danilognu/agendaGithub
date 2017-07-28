<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>

<?php  include("../../pessoa/negocio-pessoa.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-setor.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-projetos.php");  ?>

<?php  include("../negocio-solicitacao.php");  ?>

<?php

$loSetor = new setorBO();
$loProjetos = new projetosBO();
$loSolicitacao = new solicitacaoBO();
$loPessoa = new pessoaBO();

if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}



$loidLocalidade            = NULL; 
$loidSolicitacao           = NULL;  
$loidPessoaMatriz          = NULL; 
$loidRequisitante          = NULL; 
$loNomeRequisitante        = NULL; 
$loidPessoaMotPass         = NULL;  
$loNomeMotPass             = NULL;
$loIdSetor                 = NULL;  
$loMomeSetor               = NULL; 
$loIdProjeto               = NULL;  
$loNomeProjeto             = NULL; 
$lodtEvento                = NULL;  
$loDtSaida                 = NULL;  
$loDtRetornoPrev           = NULL;  
$loFinalidade              = NULL;  
$loindViagem               = NULL;  
$loindComMotorista         = NULL;  
$loindPernoite             = NULL;  
$loindRetornoPrevisto      = NULL;    
$loidLocalidade            = NULL;    
$lonomeLocalidade          = NULL;   
$loindAberto               = NULL;    
$lodtCad                   = NULL;    
$lodtAlt                   = NULL;    
$loidUsuarioCad            = NULL;    
$loidUsuarioAlt            = NULL;    
$loIdStatusSolicitacao     = NULL;    
$lonomeStatus              = NULL;   
$loidUsuarioAbertura       = NULL;    
$loNomeUsuarioAbertura     = NULL;   
$lodtAbertura              = NULL;   
$loidUsuarioEncGestor      = NULL;    
$lonomeUsuarioEncGestor    = NULL;   
$lodtEncGestor             = NULL;   
$loidUsuarioAprovado       = NULL;    
$lonomeUsuarioAprovado     = NULL;   
$lodtAprovado              = NULL;  
$loidUsuarioCancelamento   = NULL;    
$lonomeUsuarioCancelamento = NULL;  
$lodtCancelamento          = NULL;    
$loidMotivoCancelamento    = NULL; 
$loNomeFilial              = NULL;  
$loId                      = NULL;


$loIndViagemCheck = ""; 
$loIndComMotoristaCheck = "";
$loIndPernoiteCheck = "";

$loAcao = $_REQUEST["acao"];

if(isset($_REQUEST["id"]))
{
    $loId = $_REQUEST["id"];

    $loDadosC = array( 
                'id' => $loId 
        );

    $loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

    foreach ($loLista as $row){

            $loidLocalidade            = $row["id_localidade"]; 
            $loidSolicitacao           = $row["id_solicitacao"];  
            $loidPessoaMatriz          = $row["id_pessoa_matriz"];  
            $loNomePessoaMatriz        = $row["nome_pessoa_matriz"]; 
            $loidRequisitante          = $row["id_pessoa_requisitante"];  
            $loNomeRequisitante        = $row["nome_requisitante"];
            $loIdSetor                 = $row["id_setor"];  
            $loMomeSetor               = $row["nome_setor"]; 
            $loIdProjeto               = $row["id_projeto"];  
            $loNomeProjeto             = $row["nome_projeto"]; 
            $lodtEvento                = $row["dt_evento"];  
            $loDtSaida                 = $row["dt_saida"];  
            $loDtRetornoPrev           = $row["dt_retorno_prev"];  
            $loFinalidade              = $row["finalidade"];  
            $loindRetornoPrevisto      = $row["ind_retorno_previsto"];  
            $loidLocalidade            = $row["id_localidade"];  
            $lonomeLocalidade          = $row["nome_localidade"]; 
            $loindAberto               = $row["ind_aberto"];  
            $lodtCad                   = $row["dt_cad"];  
            $lodtAlt                   = $row["dt_alt"];  
            $loidUsuarioCad            = $row["id_usuario_cad"];  
            $loidUsuarioAlt            = $row["id_usuario_alt"];  
            $loIdStatusSolicitacao     = $row["id_status_solicitacao"];  
            $lonomeStatus              = $row["nome_status"]; 
            $loidUsuarioAbertura       = $row["id_usuario_abertura"];  
            $loNomeUsuarioAbertura     = $row["nome_usuario_abertura"]; 
            $lodtAbertura              = $row["dt_abertura"]; 
            $loidUsuarioEncGestor      = $row["id_usuario_enc_gestor"];  
            $lonomeUsuarioEncGestor    = $row["nome_usuario_enc_gestor"]; 
            $lodtEncGestor             = $row["dt_enc_gestor"]; 
            $loidUsuarioAprovado       = $row["id_usuario_aprovado"];  
            $lonomeUsuarioAprovado     = $row["nome_usuario_aprovado"]; 
            $lodtAprovado              = $row["dt_aprovado"];  
            $loidUsuarioCancelamento   = $row["id_usuario_cancelamento"];  
            $lonomeUsuarioCancelamento = $row["nome_usuario_cancelamento"]; 
            $lodtCancelamento          = $row["dt_cancelamento"];  
            $loidMotivoCancelamento    = $row["id_motivo_cancelamento"]; 

            $loIndViagem               = $row["ind_viagem"];  
            $loIndComMotorista         = $row["ind_com_motorista"];  
            $loIndPernoite             = $row["ind_pernoite"];  

            if($loIndViagem == 1){ $loIndViagemCheck = "checked"; }
            if($loIndComMotorista == 1){ $loIndComMotoristaCheck = "checked"; }
            if($loIndPernoite == 1){ $loIndPernoiteCheck = "checked"; }

        
    }
}


$loDadosC = array( 
    'id' => $_SESSION["id_pessoa_matriz"]
);
$loLista =  $loPessoa->ListaDadosEmpresa($loDadosC);
if(count($loLista)){
    foreach ($loLista as $row){
        $loNomeFilial = $row["nome"];
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



                  


                  <div class="row">

                    <div class="col-md-6">
                    


                                <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-automobile"></i>
                                        <span class="caption-subject bold uppercase"> Solicita&ccedil;&atilde;o </span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="tabbable tabbable-tabdrop">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab1" data-toggle="tab">Identificao</a>
                                            </li>
                                            <li>
                                                <a href="#tab2" data-toggle="tab">Rota Solicitacao</a>
                                            </li>
                                             <li>
                                                <a href="#tab3" data-toggle="tab">Atendimento</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                
                                                <!-- INICIO CONTEUDO ABA 1 - USUARIO -->    




                                                    <div class="portlet-body form">
                                                    <form class="form-horizontal" role="form">
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Unidade</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" disabled value="<?php echo $loNomeFilial; ?>" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Data Evento</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control form-control mask_date_hora" id="data-evento" value="<?php echo $lodtEvento; ?>" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Requisitado por</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" id="nome-requisitante" value="<?php echo $loNomeRequisitante; ?>" >
                                                                    <input type="hidden"  id="codigo-requisitante" value="<?php echo $loidRequisitante; ?>" >                                                    
                                                                </div>
                                                                <div class="col-md-2">
                                                                <a href="#" id="pesquisa-requisitante" class="btn btn-default requisitante"><i class="fa fa-search"></i></a>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Setor</label>
                                                                <div class="col-md-5">
                                                                    <select class="form-control" name="setor" id="setor">

                                                            <?php 

                                                                    $loDadosS = array('nome' => '' );                                                                   
                                                                    $loListaSetor =  $loSetor->ListaSetor($loDadosS);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        foreach ($loListaSetor as $row){
                                                                            
                                                                            $loSelected = "";
                                                                            if($loIdSetor == $row["id_setor"]){
                                                                                $loSelected = "selected";
                                                                            }

                                                                            echo "<option value=".$row["id_setor"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                        }     
                                                                    ?>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                        <div class="form-group">
                                                                <label class="col-md-3 control-label">Projeto</label>
                                                                <div class="col-md-5">
                                                                    <select class="form-control" name="projeto" id="projeto">

                                                                    <?php   

                                                                    $loDadosP = array('nome' => '' );                                                                   
                                                                    $loListaP =  $loProjetos->Consultar($loDadosP);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        foreach ($loListaP as $row){
                                                                            
                                                                            $loSelected = "";
                                                                            if($loIdProjeto == $row["id"]){
                                                                                $loSelected = "selected";
                                                                            }

                                                                            echo "<option value=".$row["id"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                        } 

                                                                        ?>
                                                                    
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Finalidade</label>
                                                                <div class="col-md-9">
                                                                    <textarea class="form-control" rows="3" id="finalidade"><?php echo $loFinalidade; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"></label>
                                                                <div class="col-md-9">
                                                                    <input type="checkbox" id="ind-viagem" <?php echo $loIndViagemCheck; ?> >
                                                                    Viagem
                                                                    <input type="checkbox" id="ind-com-motorista" <?php echo $loIndComMotoristaCheck; ?> >
                                                                    Com Motorista
                                                                    <input type="checkbox" id="ind-pernoite" <?php echo $loIndPernoiteCheck; ?> >
                                                                    Pernoite
                                                                </div>
                                                            </div>


                                                        <div class="form-group">
                                                                <label class="col-md-3 control-label">Data Saida</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control mask_date_hora" id="data-saida" value="<?php echo $loDtSaida; ?>" >
                                                                </div>
                                                                <label class="col-md-3 control-label">Retorno Previsto</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control mask_date_hora" id="retorno-previsto" value="<?php echo $loDtRetornoPrev; ?>" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Qtd Passageiro</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" value="0" disabled>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                                <label class="col-md-3 control-label">Situa&ccedil;&atilde;o</label>
                                                                <div class="col-md-5">
                                                                    <select class="form-control" nome="situacao" id="situacao">
                                                                    
                                                                <?php   

                                                                    $loListaSoli =  $loSolicitacao->ListaSituacao();
                                                                    
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
                                                            </div>



                                                        <div class="form-group">
                                                                <label class="col-md-3 control-label">Aberto Por</label>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" value="<?php echo $loNomeUsuarioAbertura; ?>" disabled >
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Encaminhado ao Gestor</label>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" disabled >
                                                                </div>
                                                            </div>



                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Aprovado Por</label>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" disabled >
                                                                </div>
                                                            </div>

                                                            
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Cancelado Por</label>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" disabled >
                                                                </div>
                                                            </div>
                                                        




                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-offset-3 col-md-9">
                                                                    <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                                    <button type="button" class="btn default" id="btn-cancelar" >Cancelar</button>
                                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                                    <input type="hidden" id="id" value="<?php echo $loId; ?>" />
                                                                    <input type="hidden" id="id-menu" value="<?php echo $IdMenu; ?>" />

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    </div>


                                              

                                                <!-- FIM CONTEUDO ABA 1 - USUARIO -->    


                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                

                                                <!-- INCIO CONTEUDO ABA 2 - AUTORIZAÇÕES -->      



                                                        <div class="portlet-body form">
                                                        <form class="form-horizontal" role="form">
                                                            <div class="form-body">


                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Passageiros</label>
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" id="nome-passageiro-pesq" >
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <a href="#" id="pesquisa-passageiro" class="btn btn-default"><i class="fa fa-search"></i></a>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group" id="grupo-passageiro">

                                                                <!--Grupo Passageiros Inicio -->
                                                                <?php if(isset($_REQUEST["id"])){ ?>
                                                                <h5>Passageiros</h5>
                                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th  ></th>
                                                                            <th width="90%" >Nome  </th>
                                                                            <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody  >
                                                                    <?php
                                                                                        $loDadosPassageiro = array( 
                                                                                        'id_solicitacao' => $loId
                                                                                        );

                                                                                    $loListaPassageiros =  $loSolicitacao->ListaPassageiros($loDadosPassageiro);

                                                                                    if(count($loListaPassageiros) > 0 ){

                                                                                        foreach ($loListaPassageiros as $rowPassageiro){               
                                                                            ?>

                                                                                                <tr class="odd gradeX"  >
                                                                                                    <td>  </td>
                                                                                                    <td> <?php echo $rowPassageiro["nome"]; ?> </td>
                                                                                                    <td> 
                                                                                                        <button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" >
                                                                                                            <i class="fa fa-close"></i>
                                                                                                        </button>
                                                                                                        <input type="hidden" class="codigo-passageiros" value="<?php echo $rowPassageiro["id_pessoa"]; ?> " />
                                                                                                    </td>
                                                                                                </tr>

                                                                            <?php
                                                                                    }
                                                                                }
                                                                                
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php } ?>
                                                                <!-- Grupo Passageiro Fim -->

                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Rota Origem</label>
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" >
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <a href="#" id="pesquisa-rota-origem" class="btn btn-default origem"><i class="fa fa-search"></i></a>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group" id="grupo-origem">

                                                                <!--Grupo Origem Inicio -->
                                                                <?php if(isset($_REQUEST["id"])){ ?>
                                                                <h5>Origem</h5>
                                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th >  </th>
                                                                            <th width="90%" align="left" >Nome  </th>
                                                                            <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody  >
                                                                    <?php
                                                                                        $loDadosOrigem = array( 
                                                                                        'id_solicitacao' => $loId
                                                                                        );

                                                                                    $loListaOrigem =  $loSolicitacao->ListaOrigem($loDadosOrigem);

                                                                                    if(count($loListaOrigem) > 0 ){

                                                                                        foreach ($loListaOrigem as $rowOrigem){               
                                                                            ?>

                                                                                                <tr class="odd gradeX"  >
                                                                                                    <td> </td>
                                                                                                    <td align="left"> <?php echo $rowOrigem["nome"]; ?> </td>
                                                                                                    <td> 
                                                                                                        <button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" >
                                                                                                            <i class="fa fa-close"></i>
                                                                                                        </button>
                                                                                                        <input type="hidden" class="codigo-localidade-origem" value="<?php echo $rowOrigem["id"]; ?> " />
                                                                                                    </td>
                                                                                                </tr>

                                                                            <?php
                                                                                    }
                                                                                }
                                                                                
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php } ?>
                                                                <!-- Grupo Origem Fim -->

                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Paradas</label>
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" >
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <a href="#" id="pesquisa-rota-paradas" class="btn btn-default paradas"><i class="fa fa-search"></i></a>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group" id="grupo-paradas">


                                                                <!--Grupo Paradas Inicio -->
                                                                <?php if(isset($_REQUEST["id"])){ ?>
                                                                <h5>Paradas</h5>
                                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th> </th>
                                                                            <th width="90%" align="left">Nome  </th>
                                                                            <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody  >
                                                                    <?php
                                                                                        $loDadosDestino = array( 
                                                                                        'id_solicitacao' => $loId
                                                                                        );

                                                                                    $loListaDestinos =  $loSolicitacao->ListaDestinos($loDadosDestino);

                                                                                    if(count($loListaDestinos) > 0 ){

                                                                                        foreach ($loListaDestinos as $rowDestino){               
                                                                            ?>

                                                                                                <tr class="odd gradeX"  >
                                                                                                    <td> </td>
                                                                                                    <td align="left"> <?php echo $rowDestino["nome"]; ?> </td>
                                                                                                    <td> 
                                                                                                        <button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" > 
                                                                                                            <i class="fa fa-close"></i>
                                                                                                        </button>
                                                                                                        <input type="hidden" class="codigo-localidade-paradas" value="<?php echo $rowDestino["id"]; ?> " />
                                                                                                    </td>
                                                                                                </tr>

                                                                            <?php
                                                                                    }
                                                                                }
                                                                                
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php } ?>
                                                                <!-- Grupo Paradas Fim -->


                                                                </div>

                                                            
                                                                
                                                            </div>
                                                            <div class="form-actions">
                                                                <div class="row">
                                                                    <div class="col-md-offset-3 col-md-9">
                                                                        <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                                        <button type="button" class="btn default" id="btn-cancelar" >Cancelar</button>
                                                                        <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                                        <input type="hidden" id="id" value="<?php echo $loId; ?>" />
                                                                        <input type="hidden" id="id-menu" value="<?php echo $IdMenu; ?>" />

                                                                    </div>
                                                                </div>
                                                            </div>                                                            
                                                        </form>
                                                        </div>



                                                <!-- FIM CONTEUDO ABA 2 - AUTORIZAÇÕES -->  

                                            </div>
                                            <div class="tab-pane" id="tab3">
                                                

                                                <!-- INCIO CONTEUDO ABA 3 - AUTORIZAÇÕES -->      
                               

                                                <!-- FIM CONTEUDO ABA 3 - AUTORIZAÇÕES -->  

                                            </div>
 
                                        </div>
                                    </div>

                                </div>
                            </div>


                            </div><!--<div class="col-md-6 ">-->
                    
                    </div><!--<div class="row">-->













<!-- ================================================================================================================= -->
                  
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-6 ">
                          
                          <!-- BEGIN SAMPLE FORM PORTLET item 2 -->
                            <div class="portlet light bordered">
                                <div class="portlet-title">


                                    <div class="caption font-dark">
                                        <i class="fa fa-automobile"></i>
                                        <span class="caption-subject bold uppercase"> Solicita&ccedil;&atilde;o </span>
                                    </div>
                                   

                                    
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Unidade</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" disabled value="<?php echo $loNomeFilial; ?>" >
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Data Evento</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control mask_date_hora" id="data-evento" value="<?php echo $lodtEvento; ?>" >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Requisitado por</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="nome-requisitante" value="<?php echo $loNomeRequisitante; ?>" >
                                                    <input type="hidden"  id="codigo-requisitante" value="<?php echo $loidRequisitante; ?>" >                                                    
                                                </div>
                                                <div class="col-md-2">
                                                <a href="#" id="pesquisa-requisitante" class="btn btn-default requisitante"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Setor</label>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="setor" id="setor">

                                            <?php 

                                                       $loDadosS = array('nome' => '' );                                                                   
                                                       $loListaSetor =  $loSetor->ListaSetor($loDadosS);
                                                       
                                                       echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaSetor as $row){
                                                            
                                                            $loSelected = "";
                                                            if($loIdSetor == $row["id_setor"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id_setor"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        }     
                                                    ?>

                                                    </select>
                                                </div>
                                            </div>

                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Projeto</label>
                                                <div class="col-md-5">
                                                     <select class="form-control" name="projeto" id="projeto">

                                                    <?php   

                                                       $loDadosP = array('nome' => '' );                                                                   
                                                       $loListaP =  $loProjetos->Consultar($loDadosP);
                                                       
                                                       echo "<option value='' ></option>" ;      
                                                        
                                                        foreach ($loListaP as $row){
                                                            
                                                            $loSelected = "";
                                                            if($loIdProjeto == $row["id"]){
                                                                $loSelected = "selected";
                                                            }

                                                            echo "<option value=".$row["id"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                        } 

                                                        ?>
                                                     
                                                    </select>
                                                </div>
                                            </div>

                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Finalidade</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3" id="finalidade"><?php echo $loFinalidade; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" id="ind-viagem" <?php echo $loIndViagemCheck; ?> >
                                                    Viagem
                                                     <input type="checkbox" id="ind-com-motorista" <?php echo $loIndComMotoristaCheck; ?> >
                                                     Com Motorista
                                                      <input type="checkbox" id="ind-pernoite" <?php echo $loIndPernoiteCheck; ?> >
                                                    Pernoite
                                                </div>
                                            </div>


                                          <div class="form-group">
                                                <label class="col-md-3 control-label">Data Saida</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control mask_date_hora" id="data-saida" value="<?php echo $loDtSaida; ?>" >
                                                </div>
                                                <label class="col-md-3 control-label">Retorno Previsto</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control mask_date_hora" id="retorno-previsto" value="<?php echo $loDtRetornoPrev; ?>" >
                                                </div>
                                            </div>

                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Qtd Passageiro</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" value="0" disabled>
                                                </div>
                                            </div>
                                        </div>


                                          <div class="form-group">
                                                <label class="col-md-3 control-label">Situa&ccedil;&atilde;o</label>
                                                <div class="col-md-5">
                                                     <select class="form-control" nome="situacao" id="situacao">
                                                    
                                                 <?php   

                                                       $loListaSoli =  $loSolicitacao->ListaSituacao();
                                                       
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
                                            </div>


                                
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Aberto Por</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" value="<?php echo $loNomeUsuarioAbertura; ?>" disabled >
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Encaminhado ao Gestor</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" disabled >
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Aprovado Por</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" disabled >
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cancelado Por</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" disabled >
                                                </div>
                                            </div>
                                          




                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn dark" id="btn-gravar-dados" >Adicionar</button>
                                                    <button type="button" class="btn default" id="btn-cancelar" >Cancelar</button>
                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                    <input type="hidden" id="id" value="<?php echo $loId; ?>" />
                                                    <input type="hidden" id="id-menu" value="<?php echo $IdMenu; ?>" />

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                          
                        </div>
                        <div class="col-md-6 ">
                            <!-- BEGIN SAMPLE FORM PORTLET item 2 -->
                            <div class="portlet light bordered">
                                <div class="portlet-title">

                                </div>
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Passageiros</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" id="nome-passageiro-pesq" >
                                                </div>
                                                <div class="col-md-2">
                                                <a href="#" id="pesquisa-passageiro" class="btn btn-default"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>

                                            <div class="form-group" id="grupo-passageiro">

                                            <!--Grupo Passageiros Inicio -->
                                            <?php if(isset($_REQUEST["id"])){ ?>
                                            <h5>Passageiros</h5>
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="" >
                                                <thead>
                                                    <tr>
                                                        <th  ></th>
                                                        <th width="90%" >Nome  </th>
                                                        <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                    </tr>
                                                </thead>
                                                <tbody  >
                                                <?php
                                                                 $loDadosPassageiro = array( 
                                                                    'id_solicitacao' => $loId
                                                                 );

                                                                $loListaPassageiros =  $loSolicitacao->ListaPassageiros($loDadosPassageiro);

                                                                if(count($loListaPassageiros) > 0 ){

                                                                    foreach ($loListaPassageiros as $rowPassageiro){               
                                                        ?>

                                                                            <tr class="odd gradeX"  >
                                                                                <td>  </td>
                                                                                <td> <?php echo $rowPassageiro["nome"]; ?> </td>
                                                                                <td> 
                                                                                    <button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" >
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                    <input type="hidden" class="codigo-passageiros" value="<?php echo $rowPassageiro["id_pessoa"]; ?> " />
                                                                                </td>
                                                                            </tr>

                                                        <?php
                                                                }
                                                            }
                                                            
                                                        ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <!-- Grupo Passageiro Fim -->

                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Rota Origem</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="col-md-2">
                                                <a href="#" id="pesquisa-rota-origem" class="btn btn-default origem"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>

                                            <div class="form-group" id="grupo-origem">

                                            <!--Grupo Origem Inicio -->
                                            <?php if(isset($_REQUEST["id"])){ ?>
                                            <h5>Origem</h5>
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="" >
                                                <thead>
                                                    <tr>
                                                        <th >  </th>
                                                        <th width="90%" align="left" >Nome  </th>
                                                        <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                    </tr>
                                                </thead>
                                                <tbody  >
                                                <?php
                                                                 $loDadosOrigem = array( 
                                                                    'id_solicitacao' => $loId
                                                                 );

                                                                $loListaOrigem =  $loSolicitacao->ListaOrigem($loDadosOrigem);

                                                                if(count($loListaOrigem) > 0 ){

                                                                    foreach ($loListaOrigem as $rowOrigem){               
                                                        ?>

                                                                            <tr class="odd gradeX"  >
                                                                                <td> </td>
                                                                                <td align="left"> <?php echo $rowOrigem["nome"]; ?> </td>
                                                                                <td> 
                                                                                    <button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" >
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                    <input type="hidden" class="codigo-localidade-origem" value="<?php echo $rowOrigem["id"]; ?> " />
                                                                                </td>
                                                                            </tr>

                                                        <?php
                                                                }
                                                            }
                                                            
                                                        ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <!-- Grupo Origem Fim -->

                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Paradas</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" >
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" id="pesquisa-rota-paradas" class="btn btn-default paradas"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>


                                            <div class="form-group" id="grupo-paradas">


                                            <!--Grupo Paradas Inicio -->
                                            <?php if(isset($_REQUEST["id"])){ ?>
                                            <h5>Paradas</h5>
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="" >
                                                <thead>
                                                    <tr>
                                                        <th> </th>
                                                        <th width="90%" align="left">Nome  </th>
                                                        <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                    </tr>
                                                </thead>
                                                <tbody  >
                                                <?php
                                                                 $loDadosDestino = array( 
                                                                    'id_solicitacao' => $loId
                                                                 );

                                                                $loListaDestinos =  $loSolicitacao->ListaDestinos($loDadosDestino);

                                                                if(count($loListaDestinos) > 0 ){

                                                                    foreach ($loListaDestinos as $rowDestino){               
                                                        ?>

                                                                            <tr class="odd gradeX"  >
                                                                                <td> </td>
                                                                                <td align="left"> <?php echo $rowDestino["nome"]; ?> </td>
                                                                                <td> 
                                                                                    <button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" > 
                                                                                        <i class="fa fa-close"></i>
                                                                                    </button>
                                                                                    <input type="hidden" class="codigo-localidade-paradas" value="<?php echo $rowDestino["id"]; ?> " />
                                                                                </td>
                                                                            </tr>

                                                        <?php
                                                                }
                                                            }
                                                            
                                                        ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <!-- Grupo Paradas Fim -->


                                            </div>
   
                                     
                                          
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END SAMPLE FORM PORTLET-->
                          
                           
                           


             
                            

                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                          
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->

                
                <div id="dialog-message" ></div>
      
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