<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>

<?php  include("../../pessoa/negocio-pessoa.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-setor.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-projetos.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-centro-de-custo.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-cnpj-de-faturamento.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-motivo-cancelamento.php");  ?>
<?php  include("../../gerenciaCadastros/negocio-motivo-nao-planejamento.php");  ?>
<?php  include_once("../../localidade/negocio-localidade.php");  ?>
<?php  include_once("../../veiculo/negocio-veiculo.php");  ?>

<?php  include("../negocio-solicitacao.php");  ?>

<?php

$loComum = new comumBO();
$loSetor = new setorBO();
$loProjetos = new projetosBO();
$loSolicitacao = new solicitacaoBO();
$loMotivoCancelamento = new motivoCancelamentoBO();
$loMotivoNaoPlanejamento = new motivoNaoPlanejamentoBO();
$loPessoa = new pessoaBO();
$loLocalidade = new localidadeBO();
$loVeiculo = new veiculoBO(); 
$loCentroDeCusto = new centroDeCustoBO();
$loCnpjDeFaturamento = new cnpjDeFaturamentoBO();

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
$loIndViagem               = NULL;  
$loIndComMotorista         = NULL;  
$loIndPernoite             = NULL;  
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
$loIdMotivoNaoPlanejamento = NULL;  
$loId                      = NULL;
$lodtFechamento            = NULL;
$loIdUsuarioFechamento     = NULL;
$loNomeUsuarioFechamento   = NUll;
$loQtdPassageiro           = 0;
$loNomeGestor              = NULL;
$loIdCentroDeCusto         = NULL;


$loDtPartida               = NULL; 
$loDtChegada               = NULL;  
$loKmPartida               = NULL;
$loKmChegada               = NULL; 
$loIndPlanejado            = NULL; 
$loIndRealizado            = NULL; 
$loObsRealizada            = NULL; 

$loIdVeiculo               = NULL;
$loPlaca                   = NULL;
$loIdMotorista             = NULL;
$loNomeMotorista           = NULL;
$loKmSaida                 = 0;
$loKmRetorno               = 0;
$IdMenu                    = NULL;
$loAtendimento             = 0;
$loAtendimentoRota         = 0;
$loPassageiroRota          = 0;
$loDisabledButtonAprovar   = NULL;
$loDisabledStatusFechado   = NULL;
$loDisabledStatusCancelado = NULL; 
$loQtdPassageiroVeiculos   = NULL;
$loNomeUsuarioAlt          = NULL;
$loIndEncaminhadoGestor    = NULL;
$loIndCondutor             = NULL;
$loIndPassageiro           = NULL;
$loTLPassageiroRota        = "";
$loDisabledStatusAgendado = NULL;
$loDisabledStatusAguardandoVeic =  NUll;
$loDisabledUsuarioGestor = NULL;
$loindStatusRetornado = 0;
$loIdCnpjFaturamento = NULL;       



$loIndViagemCheck = ""; 
$loIndComMotoristaCheck = "";
$loIndPernoiteCheck = "";

if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

//Atendimento
if(isset($_REQUEST["atendimento"])){
    $loAtendimento = $_REQUEST["atendimento"];
}
if(isset($_REQUEST["atendimento_rota"])){
    $loAtendimentoRota = $_REQUEST["atendimento_rota"];
}
if(isset($_REQUEST["passageiro_rota"])){
    $loPassageiroRota = $_REQUEST["passageiro_rota"];
}
//Verifca tela 
if($loAtendimento == 1 ){
    $loTLSolcitacao = "";
    $loTLAtendimento = "active";
}else{
    $loTLSolcitacao = "active";
    $loTLAtendimento = "";
}
if($loPassageiroRota == 1){
    $loTLPassageiroRota = "active";
    $loTLSolcitacao = "";
    $loTLAtendimento = "";
}



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
            $loNomeUsuarioAlt          = $row["usuario_nome"]; 
            $loIdStatusSolicitacao     = $row["id_status_solicitacao"];  
            $lonomeStatus              = $row["nome_status"]; 
            $loidUsuarioAbertura       = $row["id_usuario_abertura"];  
            $loNomeUsuarioAbertura     = $row["nome_usuario_abertura"]; 
            $lodtAbertura              = $row["dt_abertura"]; 
            $loidGestor                = $row["id_gestor"];  
            $loNomeGestor              = $row["nome_gestor"]; 
            $lodtEncGestor             = $row["dt_enc_gestor"]; 
            $loidUsuarioAprovado       = $row["id_usuario_aprovado"];  
            $lonomeUsuarioAprovado     = $row["nome_usuario_aprovado"]; 
            $lodtAprovado              = $row["dt_aprovado"];  
            $loidUsuarioCancelamento   = $row["id_usuario_cancelamento"];  
            $lonomeUsuarioCancelamento = $row["nome_usuario_cancelamento"]; 
            $lodtCancelamento          = $row["dt_cancelamento"];  
            $loidMotivoCancelamento    = $row["id_motivo_cancelamento"]; 
            $lodtFechamento            = $row["dt_fechado"]; 
            $loIdUsuarioFechamento     = $row["id_usuario_fechado"];
            $loNomeUsuarioFechamento   = $row["nome_usuario_fechado"];  
            $loQtdPassageiro           = $row["qtd_passageiro"]; 
            $loIdCentroDeCusto         = $row["id_centro_custo"];   
            $loQtdPassageiroVeiculos   = $row["qtd_passageiro_veiculo"];   
            $loIndEncaminhadoGestor    = $row["ind_encaminhado_gestor"];
            $loindStatusRetornado      = $row["ind_status_retornado"];
            $loIdCnpjFaturamento       = $row["id_cnpj_faturamento"];

            $loIndViagem               = $row["ind_viagem"];  
            $loIndComMotorista         = $row["ind_com_motorista"];  
            $loIndPernoite             = $row["ind_pernoite"];  

            //Atendimento
            $loIdVeiculo               = $row["id_veiculo"];
            $loPlaca                   = $row["placa"];
            $loIdMotorista             = $row["id_motorista"];
            $loNomeMotorista           = $row["nome_motorista"];
            $loKmSaida                 = $row["km_saida"];
            $loKmRetorno               = $row["km_retorno"];

            //Rota
            //$loDtPartida               = $row["dt_partida"]; 
            //$loDtChegada               = $row["dt_chegada"];  
            //$loKmPartida               = $row["km_partida"];
            //$loKmChegada               = $row["km_chegada"]; 
            //$loIndPlanejado            = $row["ind_planejado"]; 
            //$loIndRealizado            = $row["ind_realizado"];
            //$loObsRealizada            = $row["obs_realizado"]; 
            //$loIdMotivoNaoPlanejamento = $row["id_mot_plan"];

            if($loIndViagem == 1){ $loIndViagemCheck = "checked"; }
            if($loIndComMotorista == 1){ $loIndComMotoristaCheck = "checked"; }
            if($loIndPernoite == 1){ $loIndPernoiteCheck = "checked"; }

        
    }
}



$loDadosC = array('id' => $_SESSION["id_pessoa_matriz"]);
$loLista =  $loPessoa->ListaDadosEmpresa($loDadosC);
if(count($loLista)){
    foreach ($loLista as $row){
        $loNomeFilial = $row["nome"];
    }
}

if($loAcao == "I"){
    $loDadosC = array('id_usuario' => $_SESSION["id_usuario"] );
    $loListaRequi =  $loSolicitacao->ListaRequisitante($loDadosC);
    if(count($loListaRequi)){
        foreach ($loListaRequi as $row){
            $loNomeRequisitante = $row["nome_requisitante"];
            $loidRequisitante = $row["id_pessoa_requisitante"];
            $loIdSetor = $row["id_setor"];
            $loIndPassageiroRequisitante = $row["ind_passageiro"];
            $loIndPassageiroCondutor = $row["ind_condutor"];
        }
    }
}

if($loIdStatusSolicitacao == 3 || $loIdStatusSolicitacao == 4 || $loIdStatusSolicitacao == 5){
    $loDisabledButtonAprovar = "disabled";
}

if($loIdStatusSolicitacao == 5){
    $loDisabledStatusFechado = "disabled";
}

if($loIdStatusSolicitacao == 4){
    $loDisabledStatusCancelado = "disabled";
}
if($loIdMotorista != "" &&  $loQtdPassageiro > 0){ 
     if($loidSolicitacao != ""){
        $loVerificaSeMotoristaePassageiro =  $loSolicitacao->VerificaSePassageiroeMotorista($loidSolicitacao);
        if($loVerificaSeMotoristaePassageiro == 0){
            $loQtdPassageiro++; 
        }
     }
}

$loRemoveTompo = true;
if(isset($_REQUEST["removeTop"]) && $_REQUEST["removeTop"] == "S"){
    $loRemoveTompo = false;
}

//Verifica Grupo Acesso Usuario
$loGrupoAcessoUser = $loSolicitacao->VerificaGrupoAcessoUsuario();
$loGrupoAcessoUsuario = $loGrupoAcessoUser["ind_usuario"];
$loGrupoAcessoGestor = $loGrupoAcessoUser["ind_gestor"];
$loGrupoAcessoOperador = $loGrupoAcessoUser["ind_operador"];
$loGrupoAcessoAdm = $loGrupoAcessoUser["ind_adm"];


if($loGrupoAcessoUser["ind_usuario"] == 1 || $loGrupoAcessoUser["ind_gestor"] == 1){

    //Verifica se usuario tem alguem que aprova ele se for maior que 0 existe se nao é 0    
    $UsuarioAutorizaRequisitante = $loSolicitacao->UsuarioCorrenteAutoriza($loidSolicitacao);
    if($UsuarioAutorizaRequisitante == 0){
        $loDisabledButtonAprovar = "disabled";  
    }
    $loDisabledUsuarioGestor = "disabled";
    $loDisabledStatusAgendado = "disabled";
    $loDisabledStatusAguardandoVeic =  "disabled";

}

if($loIndEncaminhadoGestor == 1){
    $loTextBtnEncaminadoGestor = "Enviado ao Gestor ";
}else{
   $loTextBtnEncaminadoGestor = "Enc. Gestor ";
}

$loCondutor = $loSolicitacao->VerificaUsuarioConsutor();
if(count($loCondutor) > 0){
    $loIndCondutor = $loCondutor["ind_condutor"];
    $loIndPassageiro = $loCondutor["ind_passageiro"];
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

        <link href="../../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
 
    </head>

    <body class="page-container-bg-solid page-boxed">
        <!-- BEGIN HEADER -->
        <?php if($loRemoveTompo){ ?>
        <div class="page-header">
            <!-- BEGIN  TOP -->
            <?php include("../../comum/apresentacao/topo.php"); ?>
            <!-- END  TOP -->

            <!-- BEGIN  MENU -->            
            <?php include("../../menu/apresentacao/menu-horizontal.php"); ?>
            <!-- END  MENU -->
        </div>
        <?php } ?>
        <!-- END HEADER -->



                  


                  <div class="row">

                    <div class="col-md-7" id="div-base-conteudo" >
                    


                                <div class="portlet light bordered">
                                <div class="portlet" >

                                    <div class="caption">
                                        <i class="fa fa-automobile"></i>
                                        <span class="caption-subject bold uppercase"> Solicita&ccedil;&atilde;o / Atendimento - N&deg; <?php echo $loidSolicitacao; ?> </span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body"  >
                                    <div class="tabbable tabbable-tabdrop" >
                                        <ul class="nav nav-tabs"> 
                                            <li class="<?php echo $loTLSolcitacao; ?>" >
                                                <a href="#tab1" data-toggle="tab" onClick="Solicitacao.AbaRetornaCss();" >IDENTIFICA&Ccedil;&Atilde;O</a>
                                            </li>
                                            <li class="<?php echo $loTLPassageiroRota; ?>" >
                                                <a href="#tab2" data-toggle="tab" onClick="Solicitacao.AbaRetornaCss();" >PASSAGEIROS / ROTA</a>
                                            </li>
                                            <?php if(isset($_REQUEST["id"]) && ($loIdStatusSolicitacao == 2 || $loIdStatusSolicitacao == 3 || $loIdStatusSolicitacao == 5 || $loIdStatusSolicitacao == 6 || $loIdStatusSolicitacao == 7 || $loIdStatusSolicitacao == 8) ) { ?>
                                             <li class="<?php echo $loTLAtendimento; ?>" >
                                                <a href="#tab3" data-toggle="tab" id="tab3-pai" onclick="Solicitacao.AbaRetornaCss();Solicitacao.AbaVerificaRotaCss();"  >ATENDIMENTO</a>
                                            </li>
                                            <?php } ?>
                                           
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane <?php echo $loTLSolcitacao; ?>" id="tab1">
                                                
                                                <!-- INICIO CONTEUDO ABA 1 - IDENTIFICACAO -->    




                                                    <div class="portlet-body form">
                                                    <form class="form-horizontal" role="form">
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Unidade</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $loNomeFilial; ?>" >
                                                                </div>
                                                            </div>
                                                            

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Requisitado por</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control input-sm" id="nome-requisitante" value="<?php echo $loNomeRequisitante; ?>" >
                                                                    <input type="hidden"  id="codigo-requisitante" value="<?php echo $loidRequisitante; ?>" >                                                    
                                                                </div>
                                                                <div class="col-md-2">
                                                                <a href="#" id="pesquisa-requisitante" class="btn btn-default requisitante"><i class="fa fa-search"></i></a>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Setor</label>
                                                                <div class="col-md-3">
                                                                    <select class="form-control input-sm" name="setor" id="setor">

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


                                                                <label class="col-md-3 control-label">Cnpj Fat.</label>
                                                                <div class="col-md-3">
                                                                    <select class="form-control input-sm " name="cnpj-faturamento" id="cnpj-faturamento">

                                                                    <?php   

                                                                    $loDadosCnpj = array('cnpj' => '' );                                                                   
                                                                    $loListaCnpj =  $loCnpjDeFaturamento->Consultar($loDadosCnpj);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        foreach ($loListaCnpj as $row){
                                                                            
                                                                            $loSelected = "";
                                                                            if($loIdCnpjFaturamento == $row["id"]){
                                                                                $loSelected = "selected";
                                                                            }

                                                                            echo "<option value=".$row["id"]." ".$loSelected." >".$row["cnpj"]." / ".$row["descricao"]."</option>" ;      

                                                                        } 

                                                                        ?>
                                                                    
                                                                    </select>
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Projeto</label>
                                                                <div class="col-md-3">
                                                                    <select class="form-control input-sm " name="projeto" id="projeto">

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


                                                                <label class="col-md-3 control-label">Centro de Custo</label>
                                                                <div class="col-md-3">
                                                                    <select class="form-control input-sm " name="centro-de-custo" id="centro-de-custo">

                                                                    <?php   

                                                                    $loDadosP = array('nome' => '' );                                                                   
                                                                    $loListaP =  $loCentroDeCusto->Consultar($loDadosP);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        foreach ($loListaP as $row){
                                                                            
                                                                            $loSelected = "";
                                                                            if($loIdCentroDeCusto == $row["id"]){
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
                                                                    <textarea class="form-control input-sm" rows="3" id="finalidade"><?php echo $loFinalidade; ?></textarea>
                                                                </div>
                                                            </div>

                                                        <div class="form-group">

                                                                <label class="col-md-3 control-label ">Data Evento*</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control form-control input-sm mask_date_hora" id="data-evento" value="<?php echo $lodtEvento; ?>" >
                                                                </div>

                                                                <label class="col-md-4 control-label"></label>
                                                                <div class="col-md-6">
                                                                    <input type="checkbox" id="ind-viagem" <?php echo $loIndViagemCheck; ?> >
                                                                    Viagem
                                                                    <input type="checkbox" id="ind-com-motorista" <?php echo $loIndComMotoristaCheck; ?> >
                                                                    Com Motorista
                                                                    <input type="checkbox" id="ind-pernoite" <?php echo $loIndPernoiteCheck; ?> >
                                                                    Pernoite
                                                                </div>
                                                        
                                                        </div>

                                                          <div class="form-group">
                                                                <label class="col-md-3 control-label">Data Saida*</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control input-sm mask_date_hora" id="data-saida" value="<?php echo $loDtSaida; ?>" >
                                                                </div>
                                                                <label class="col-md-2 control-label">Retorno Prev.*</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" class="form-control input-sm mask_date_hora" id="retorno-previsto" value="<?php echo $loDtRetornoPrev; ?>" >
                                                                </div>
                                                            </div>

                                                            
                                                        </div>


                                                        <div class="form-group">
                                                                <label class="col-md-3 control-label">Situa&ccedil;&atilde;o *</label>
                                                                <div class="col-md-5">
                                                                    <select class="form-control input-sm" disabled nome="situacao" id="situacao" onClick="Solicitacao.Situacao_onClick(this);" onChange="Solicitacao.EncaminharGestro(this);" >
                                                                    
                                                                <?php   

                                                                    $loListaSoli =  $loSolicitacao->ListaSituacao(0);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        foreach ($loListaSoli as $row){
                                                                            
                                                                            $loSelected = "";
                                                                            if($loIdStatusSolicitacao == $row["id_status_solicitacao"]){
                                                                                $loSelected = "selected";
                                                                            }else{
                                                                                if($row["id_status_solicitacao"] == 1 && $loAcao == "I"){ $loSelected = "selected"; }
                                                                            }

                                                                           
                                                                            if($row["id_status_solicitacao"] != 5){
                                                                                echo "<option value=".$row["id_status_solicitacao"]." ".$loSelected." >".$row["nome"]."</option>";        
                                                                            }else{

                                                                                 if($row["id_status_solicitacao"] == 5 && ($loIdStatusSolicitacao == 2 || $loIdStatusSolicitacao == 3 || $loIdStatusSolicitacao == 5)){
                                                                                    echo "<option value=".$row["id_status_solicitacao"]." ".$loSelected." >".$row["nome"]."</option>" ;                      
                                                                                 }

                                                                            }
                                                                           

                                                                        } 

                                                                        ?>                                      
                                                                    
                                                                    </select>
                                                                    <!-- hidden -->
                                                                    <input type="hidden" id="id-gestor" >
                                                                    <input type="hidden" id="ind-solicitacao-envida-gestor" value="0" >
                                                                </div>


                                                                <label class="col-md-2 control-label">Qtd Passageiro</label>
                                                                <div class="col-md-1">
                                                                    <input type="text" class="form-control input-sm qtd-passageiro-visual" value="<?php echo $loQtdPassageiro; ?>" disabled>
                                                                </div>


                                                            </div>
                                                             <?php if($loidMotivoCancelamento > 0){$exibirMotivo = "display:block;";}else{$exibirMotivo = "display:none;";} ?>
                                                             <div class="form-group"  style="<?php echo  $exibirMotivo; ?>" id="grupo-motivo-cancelamento" >
                                                                <label class="col-md-3 control-label">Motivo cancelamento*</label>
                                                                <div class="col-md-9">
                                                                    <select class="form-control input-sm" disabled nome="motivo-cancelamento" id="motivo-cancelamento"  >
                                                                    
                                                                <?php   

                                                                    $loDadosMot = array( 'id' => '');
                                                                    $loListaMot =  $loMotivoCancelamento->Consultar($loDadosMot);
                                                                    
                                                                    echo "<option value='' ></option>" ;      
                                                                        
                                                                        if(count($loListaMot)>0){
                                                                            foreach ($loListaMot as $row){
                                                                                
                                                                                $loSelected = "";
                                                                                if($loidMotivoCancelamento == $row["id"]){
                                                                                    $loSelected = "selected";
                                                                                }

                                                                                echo "<option value=".$row["id"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                            } 
                                                                        }

                                                                        ?>                                      
                                                                    
                                                                    </select>
                                                                </div>
                                                            </div>




                                                        



                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-offset-1 col-md-9">
                                                                    <button type="button" <?php echo $loDisabledStatusFechado; ?> class="btn dark btn-gravar-dados"  >
                                                                        <?php 
                                                                           echo "Salvar Solicita&ccedil;&atilde;o"; 
                                                                        ?>                                                                        
                                                                    </button>
                                                                    <!--button type="button" class="btn default btn-gestor"  ><?php //echo $loTextBtnEncaminadoGestor; ?><i class="fa fa-mail-forward"></i></button-->
                                                                    <button type="button" class="btn default btn-aprovar" <?php echo $loDisabledButtonAprovar; ?>  >Aprovar <i class="fa fa-check"></i></button>
                                                                    <button type="button" class="btn default btn-cancelar" <?php echo $loDisabledStatusCancelado;?>  >Cancelar <i class="fa fa-close"></i></button>
                                                                    <button type="button" class="btn default btn-voltar" >Voltar <i class="fa fa-mail-reply"></i> </button>
                                                                    <input type="hidden" id="acao" value="<?php echo $loAcao; ?>" /> 
                                                                    <input type="hidden" id="id" value="<?php echo $loId; ?>" />
                                                                    <input type="hidden" id="id-menu" value="<?php echo $IdMenu; ?>" />
                                                                    <input type="hidden" id="ativa-aprovar" value="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    </div>


                                             

                                                <!-- FIM CONTEUDO ABA 1 - IDENTIFICACAO -->    


                                            </div>
                                            <div class="tab-pane <?php echo $loTLPassageiroRota; ?>"  id="tab2">
                                                

                                                <!-- INCIO CONTEUDO ABA 2 - ROTA -->      



                                                        <div class="portlet-body form">
                                                        <form class="form-horizontal" role="form">
                                                            <div class="form-body">


                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label"><strong>Passageiros</strong></label>
                                                                    <!--div class="col-md-5">
                                                                        <input type="text" class="form-control input-sm" id="nome-passageiro-pesq" >
                                                                    </div-->

                                                                    <div class="col-md-5">
                                                                    <select class="form-control select2me" name="options2" id="select-passageiros" >
                                                                        <option value=""></option>
                                                                        <?php
                                                                            $loDadosC = array( 
                                                                                    'tipo_pessoa' => '4,5'
                                                                                       , 'ind_passageiro' => '1'
                                                                                );

                                                                                $loLista =  $loPessoa->ListaPessoa($loDadosC);

                                                                                if(count($loLista) > 0){

                                                                                    foreach ($loLista as $row){
                                                                                        ?>
                                                                                        <option value="<?php echo $row["id_pessoa"].":".$row["nome"]; ?>"><?php echo $row["nome"]; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                        
                                                                            ?>
                                                                    </select>
                                                                     </div>

                                                                    <div class="col-md-4">
                                                                        <a href="#" id="btn-adicionar-item-passageiro" class="btn btn-default"><i class="fa fa-check"></i></i></a>
                                                                        <a href="#" id="pesquisa-passageiro" class="btn btn-default"><i class="fa fa-search"></i></a>
                                                                        <button type="button" class="btn btn-default" id="modal-cadastro-rapido--passageiro" >Cadastrar</button>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group" id="grupo-passageiro">

                                                                <!--Grupo Passageiros Inicio -->
                                                                <?php //if(isset($_REQUEST["id"])){ ?>
                                                                <!--h5><strong>Passageiros</strong></h5-->
                                                                <table width="100%" class="table-rota bordasimples" id="table-passageiros" >
                                                                    <thead>
                                                                        <tr>

                                                                            <th width="80%" >Passageiro</th>
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

                                                                                                    <td> <?php echo $rowPassageiro["nome"]; ?> </td>
                                                                                                    <td>
                                                                                                        <a href="#" class="btn-rota" onclick="Solicitacao.RemoverLinhaPassageiros(this);" ><i class="fa fa-close"></i> Remover </a>
                                                                                                        <input type="hidden" class="codigo-passageiros" value="<?php echo $rowPassageiro["id_pessoa"]; ?> " />
                                                                                                    </td>
                                                                                                </tr>

                                                                            <?php
                                                                                    }
                                                                                }

                                                                            if( $loAcao == "I" && ($loIndCondutor == 1 || $loIndPassageiro == 1) ){
                                                                            ?>   
                                                                                    <tr class="odd gradeX"  >

                                                                                        <td> <?php echo $loNomeRequisitante; ?> </td>
                                                                                        <td>
                                                                                            <a href="#" class="btn-rota" onclick="Solicitacao.RemoverLinhaPassageiros(this);" ><i class="fa fa-close"></i> Remover </a>
                                                                                            <input type="hidden" class="codigo-passageiros" value="<?php echo $loidRequisitante; ?> " />
                                                                                        </td>
                                                                                    </tr>                 
                                                                            <?php
                                                                            }                                                                                
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php //} ?>
                                                                <!-- Grupo Passageiro Fim -->

                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label"><strong>Origem</strong></label>
                                                                    <!--div class="col-md-5">
                                                                        <input type="text" class="form-control input-sm" >
                                                                    </div-->
                                                                    <div class="col-md-5">
                                                                    <select class="form-control select2me" name="options2" id="select-origem" >
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
                                                                                        <option value="<?php echo $row["id_localidade"].":".$row["nome"]. " - ".$row["endereco"]; ?>"><?php echo $row["nome"]; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                        
                                                                            ?>
                                                                    </select>
                                                                     </div>
                                                                    
                                                                    <div class="col-md-4">
                                                                        <a href="#" id="btn-adicionar-item-origem" class="btn btn-default"><i class="fa fa-check"></i></i></a>
                                                                        <a href="#" id="pesquisa-rota-origem" class="btn btn-default origem"><i class="fa fa-search"></i></a>
                                                                        <button type="button" class="btn btn-default" id="modal-cadastro-rapido-origem" >Cadastrar</button>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group" id="grupo-origem">

                                                                <!--Grupo Origem Inicio -->
                                                                <?php //if(isset($_REQUEST["id"])){ ?>
                                                                <!--h5><strong>Origem</strong></h5-->
                                                                <table width="100%" class="table-rota bordasimples" id="table-origem" >
                                                                    <thead>
                                                                        <tr>

                                                                            <th width="80%" align="left" >Origem  </th>
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

                                                                                            $loCidadeLocalidade = "";
                                                                                            if($rowOrigem["nome_cidade"] != ""){
                                                                                                $loCidadeLocalidade = " - ".$rowOrigem["nome_cidade"]."/".$rowOrigem["uf"];
                                                                                            }          
                                                                            ?>

                                                                                                <tr class="odd gradeX"  >

                                                                                                    <td align="left"> <?php echo $rowOrigem["nome"]." ".$rowOrigem["endereco"]." ".$loCidadeLocalidade; ?> </td>
                                                                                                    <td> 
                                                                                                        <!--button type="button" class="btn sbold red" onClick="Solicitacao.RemoverLinha(this);" >
                                                                                                            <i class="fa fa-close"></i>
                                                                                                        </button-->
                                                                                                        <a href="#" onClick="Solicitacao.RemoverLinha(this);" ><i class="fa fa-close"></i> Remover </a>
                                                                                                        <input type="hidden" class="codigo-localidade-origem" value="<?php echo $rowOrigem["id"]; ?> " />
                                                                                                    </td>
                                                                                                </tr>

                                                                            <?php
                                                                                    }
                                                                                }
                                                                                
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php //} ?>
                                                                <!-- Grupo Origem Fim -->

                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label"><strong>Paradas</strong></label>
                                                                    <div class="col-md-5">
                                                                    <select class="form-control select2me" name="options2" id="select-paradas" >
                                                                        <option value=""></option>
                                                                        <?php
                                                                            $loDadosCOrigem = array( 
                                                                                     'status' => '1'
                                                                                );

                                                                                $loLista =  $loLocalidade->ListaLocalidade($loDadosC);

                                                                                if(count($loLista) > 0){

                                                                                    foreach ($loLista as $row){
                                                                                        ?>
                                                                                        <option value="<?php echo $row["id_localidade"].":".$row["nome"]." - ".$row["endereco"]; ?>"><?php echo $row["nome"]; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                        
                                                                            ?>
                                                                    </select>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <a href="#" id="btn-adicionar-item-paradas" class="btn btn-default"><i class="fa fa-check"></i></i></a>
                                                                        <a href="#" id="pesquisa-rota-paradas" class="btn btn-default paradas"><i class="fa fa-search"></i></a>
                                                                        <button type="button" class="btn btn-default" id="modal-cadastro-rapido-paradas" >Cadastrar</button>
                                                                    </div>
                
                                                                </div>


                                                                <div class="form-group" id="grupo-paradas">


                                                                <!--Grupo Paradas Inicio -->
                                                                <?php //if(isset($_REQUEST["id"])){ ?>
                                                                <!--h5><strong>Paradas</strong></h5-->
                                                                <table width="100%" class="table-rota bordasimples" id="table-paradas" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="5%" align="left">Ordem</th>
                                                                            <th width="70%" align="left">Paradas</th>
                                                                            <th width="10%" >A&ccedil;&atilde;o  </th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody  >
                                                                    <?php
                                                                                        $loDadosDestino = array( 
                                                                                        'id_solicitacao' => $loId
                                                                                        );

                                                                                    $loListaDestinos =  $loSolicitacao->ListaDestinos($loDadosDestino);

                                                                                    if(count($loListaDestinos) > 0 && !empty($loId)){

                                                                                        foreach ($loListaDestinos as $rowDestino){    

                                                                                            
                                                                                            $loCidadeLocalidadeParada = "";
                                                                                            if($rowOrigem["nome_cidade"] != ""){
                                                                                                $loCidadeLocalidadeParada = " - ".$rowDestino["nome_cidade"]."/".$rowDestino["uf"];
                                                                                            }  

                                                                            ?>

                                                                                                <tr class="odd gradeX table-tr-paradas">
      
                                                                                                    <td align="left" class="table-paradas-contagem" > <?php echo $rowDestino["contagem"]; ?> </td>
                                                                                                    <td align="left"> <?php echo $rowDestino["nome"]." - ".$rowDestino["endereco"]. " " .$loCidadeLocalidadeParada ; ?> </td>
                                                                                                    <td> 
                                                                                                        <a href="#" onClick="Solicitacao.RemoverLinhaParadas(this,<?php echo $rowDestino["id_destino"]; ?>);" > <i class="fa fa-close"></i> Remover </a>
                                                                                                        <input type="hidden" class="codigo-localidade-paradas" value="<?php echo $rowDestino["id_localidade"].":".$rowDestino["id_destino"]; ?> " />
                                                                                                    </td>

                                                                                                </tr>

                                                                            <?php
                                                                                    }
                                                                                }
                                                                                
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <?php //} ?>
                                                                <!-- Grupo Paradas Fim -->

                                                                        <div class="col-md-4"> 
                                                                        <br/>                                                                    
                                                                        <p class="font-blue-madison"> Obs: &Uacute;ltima parada ser&aacute; o destino. </p>
                                                                        </div>
                                                                </div>

                                                            
                                                                
                                                            </div>
                                                            <div class="form-actions">
                                                                <div class="row">
                                                                    <div class="col-md-offset-1 col-md-9">
                                                                        <button type="button" <?php echo $loDisabledStatusFechado; ?> class="btn dark btn-gravar-dados" >
                                                                         <?php 
                                                                            echo "Salvar Solicita&ccedil;&atilde;o"; 
                                                                        ?>
                                                                        </button>
                                                                        <!--button type="button" class="btn default btn-gestor"  ><?php //echo $loTextBtnEncaminadoGestor; ?><i class="fa fa-mail-forward"></i></button-->
                                                                        <button type="button" class="btn default btn-aprovar" <?php echo $loDisabledButtonAprovar; ?> >Aprovar <i class="fa fa-check"></i></button>
                                                                        <button type="button" class="btn default btn-cancelar" <?php echo $loDisabledStatusCancelado;?>  >Cancelar <i class="fa fa-close"></i></button>
                                                                        <button type="button" class="btn default btn-voltar" >Voltar <i class="fa fa-mail-reply"></i> </button>
                                                                    </div>
                                                                </div>
                                                            </div>                                                            
                                                        </form>
                                                        </div>



                                                <!-- FIM CONTEUDO ABA 2 - ROTA -->  

                                            </div>
                                            <div class="tab-pane <?php echo $loTLAtendimento; ?>" id="tab3">
                                                

                                                <!-- INCIO CONTEUDO ABA 3 - ATENDIMENTO -->    




                                                    <div class="portlet-body">
                                                    <div class="tabbable tabbable-tabdrop">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active">
                                                                <a href="#tab5" id="tab5-pai" data-toggle="tab" onClick="Solicitacao.AbaRetornaCss();" >Atendimento</a>
                                                            </li>
                                                            <li>
                                                                <a href="#tab6" id="tab6-rota" data-toggle="tab" onClick="Solicitacao.AbaRota();" >Rota</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="tab5">


                                                                <!-- INICIO SUB ABA 3.2 ATENDIMENTO -->
                                                                <div class="portlet-body form">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">

                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">Unidade</label>
                                                                            <div class="col-md-5">
                                                                                <input type="text" class="form-control input-sm" disabled value="<?php echo $loNomeFilial; ?>" >
                                                                            </div>

                                                                            <label class="col-md-1 control-label">Codigo Atend.</label>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control input-sm"  disabled value="<?php echo $loId; ?>" >
                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">Placa</label>
                                                                            <div class="col-md-3 col-veiculo">

                                                                            <select class="form-control select2me" name="options2" id="select-veiculo" >
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

                                                                                <!--input type="text" class="form-control input-sm mask_placa" id="placa" value="<?php //echo $loPlaca; ?>" >
                                                                                <span class="help-block messagem-valida-placa"></span>
                                                                                <input type="hidden" class="form-control" id="codigo-veiculo" value="<?php //echo $loIdVeiculo; ?>" -->
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a href="#" id="pesquisa-placa" class="btn btn-default placa"><i class="fa fa-search"></i></a>
                                                                            </div>

                                                                            <label class="col-md-1 control-label">Motorista</label>
                                                                            <div class="col-md-4">

                                                                            <select class="form-control select2me" name="options2" id="select-motorista" >
                                                                            <option value=""></option>
                                                                            <?php

                                                                                    $loDadosMotorista= array( 'tipo_pessoa' => '4,5,6','motorista_condutor' => 1, 'id' => NULL );

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
                                                                                    }
                                                                                            
                                                                                ?>
                                                                            </select>

                                                                                <!--input type="text" class="form-control input-sm" id="nome-motorista" value="<?php //echo $loNomeMotorista; ?>" >
                                                                                <input type="hidden" class="form-control" id="codigo-motorista" value="<?php //echo $loIdMotorista; ?>" -->
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <a href="#" id="pesquisa-motorista" class="btn btn-default motorista"><i class="fa fa-search"></i></a>
                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">Data Saida</label>
                                                                            <div class="col-md-3">
                                                                                <input type="text" class="form-control input-sm mask_date_hora" id="dt-saida-atencimento" value="<?php echo $loDtSaida; ?>" onKeyUp="Solicitacao.ReplicaIdentificacao();" >
                                                                            </div>
                                                                            <label class="col-md-2 control-label">Retorno Previsto</label>
                                                                            <div class="col-md-3">
                                                                                <input type="text" class="form-control input-sm mask_date_hora" id="dt-retorno-atencimento" value="<?php echo $loDtRetornoPrev; ?>" onKeyUp="Solicitacao.ReplicaIdentificacao();" >
                                                                            </div>
                                                                        </div>    



                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">KM Saida</label>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control input-sm mask_number" id="km-saida" value="<?php echo $loKmSaida; ?>" >
                                                                            </div>
                                                                            <label class="col-md-3 control-label">KM Retorno</label>
                                                                            <div class="col-md-2">
                                                                                <input type="text" class="form-control input-sm mask_number" id="km-retorno" value="<?php echo $loKmRetorno; ?>" >
                                                                            </div>
                                                                        </div>    


                                                                        <div class="form-group">
                                                                        <label class="col-md-2 control-label"></label>
                                                                            <div class="col-md-5">
                                                                            <?php if($loIndViagem == 1){ echo "<i class='fa fa-check-square'></i>"; }else{ echo "<i class='fa fa-square'></i>"; } ?>
                                                                                Viagem &nbsp;&nbsp;
                                                                                <?php if($loIndComMotorista == 1){ echo "<i class='fa fa-check-square'></i>"; }else{ echo "<i class='fa fa-square'></i>"; } ?>
                                                                                Com Motorista &nbsp;&nbsp;
                                                                                <?php if($loIndPernoite == 1){ echo "<i class='fa fa-check-square'></i>"; }else{ echo "<i class='fa fa-square'></i>"; } ?>
                                                                                Pernoite &nbsp;&nbsp;
                                                                            </div> 
                                                                             <label class="col-md-2 control-label">Qtd Passageiro</label>
                                                                            <div class="col-md-1">
                                                                                <input type="text" class="form-control input-sm qtd-passageiro-visual" value="<?php echo $loQtdPassageiro; ?>" disabled>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">Origem</label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control input-sm" disabled  value="<?php echo $lonomeLocalidade; ?>" >
                                                                            </div>
                                                                        </div>  
                                                                        <?php 
                                                                            $loDadosUltimoDestino = array(  'ultimo' => '1', 'id_solicitacao' => $loId);
                                                                            $ListaUltimoDestino = $loSolicitacao->ListaDestinos($loDadosUltimoDestino);
                                                                            $loNomeUltimoDestino = NULL;
                                                                            if(count($ListaUltimoDestino) > 0 ){
                                                                                foreach ($ListaUltimoDestino as $rowDestinoUltimoDestino){   
                                                                                    $loNomeUltimoDestino =  $rowDestinoUltimoDestino["nome"];
                                                                                }    
                                                                            }
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">Destino Final</label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" class="form-control input-sm" disabled  value="<?php echo $loNomeUltimoDestino; ?>" >
                                                                            </div>
                                                                        </div> 
                                                                        

                                                                        <div class="form-group">
                                                                        <label class="col-md-2 control-label">Situa&ccedil;&atilde;o</label>
                                                                        <div class="col-md-5">
                                                                            <select class="form-control input-sm" disabled nome="situacao-atendimento" id="situacao-atendimento"  onClick="Solicitacao.SituacaoAtendimento_onClick(this);" >
                                                                            
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
                                                                    </div>

                                                                    <?php if($loidMotivoCancelamento > 0){$exibirMotivo = "display:block;";}else{$exibirMotivo = "display:none;";} ?>
                                                                    <div class="form-group"  style="<?php echo  $exibirMotivo; ?>" id="grupo-motivo-cancelamento-atendimento" >
                                                                        <label class="col-md-2 control-label">Motivo cancelamento*</label>
                                                                        <div class="col-md-9">
                                                                            <select class="form-control input-sm" nome="motivo-cancelamento-atendimento" id="motivo-cancelamento-atendimento" onClick="Solicitacao.MotivoCancSituacaoAtendimento_onClick(this);" >
                                                                            
                                                                        <?php   

                                                                            $loDadosMot = array( 'id' => '');
                                                                            $loListaMot =  $loMotivoCancelamento->Consultar($loDadosMot);
                                                                            
                                                                            echo "<option value='' ></option>" ;      
                                                                                
                                                                                if(count($loListaMot)>0){
                                                                                    foreach ($loListaMot as $row){
                                                                                        
                                                                                        $loSelected = "";
                                                                                        if($loidMotivoCancelamento == $row["id"]){
                                                                                            $loSelected = "selected";
                                                                                        }

                                                                                        echo "<option value=".$row["id"]." ".$loSelected." >".$row["nome"]."</option>" ;      

                                                                                    } 
                                                                                }

                                                                                ?>                                      
                                                                            
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    


                                                                        <div class="form-group">
                                                                                <!--Grupo Passageiros Inicio -->
                                                                                <?php if(isset($_REQUEST["id"])){ ?>
                                                                                <!--h5>Passageiros</h5-->
                                                                                <table width="100%" class="table-rota bordasimples"  id="" >
                                                                                    <thead>
                                                                                                <tr>
                                                                                                    <th width="60%" >Passageiros  </th>
                                                                                                    <th width="10%" >Motorista  </th>
                                                                                                    <th width="30%" >Telefone  </th>
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

                                                                                                                    if($rowPassageiro["telefone"] != ""){
                                                                                                                        $loTelefonePassageiroAtendimento = "(".$rowPassageiro["telefone_dd"].") ".$rowPassageiro["telefone"];
                                                                                                                    }else{ $loTelefonePassageiroAtendimento =""; }

                                                                                                                    if($rowPassageiro["ind_motorista"] == "1"){
                                                                                                                        $loIndMotoristaAtendimento =  "Sim";    
                                                                                                                    }else{ $loIndMotoristaAtendimento =  "N&atilde;o"; }         
                                                                                                    ?>

                                                                                                                        <tr class="odd gradeX"  >
                                                                                                                            <td> <?php echo $rowPassageiro["nome"]; ?> </td>
                                                                                                                            <td> <?php echo $loIndMotoristaAtendimento; ?> </td>
                                                                                                                            <td> <?php echo $loTelefonePassageiroAtendimento; ?> </td>
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


                                                                            <div class="form-actions">
                                                                                <div class="row">
                                                                                    <div class="col-md-offset-0 col-md-11">
                                                                                        <button type="button" <?php echo $loDisabledStatusFechado; ?> <?php echo $loDisabledUsuarioGestor; ?> class="btn dark btn-gravar-dados" >
                                                                                        Salvar Atendimento                                                                                     
                                                                                        </button>
                                                                                        <button type="button" <?php echo $loDisabledStatusFechado.$loDisabledUsuarioGestor; ?> class="btn default btn-fechar"  >Fechar <i class="fa fa-lock"></i></button>
                                                                                        <button type="button" class="btn default btn-aprovar" <?php echo $loDisabledButtonAprovar; ?> >Aprovar <i class="fa fa-check"></i></button>
                                                                                        <button type="button" class="btn default btn-agendado" <?php echo $loDisabledStatusAgendado.$loDisabledStatusFechado; ?> >Agendado <i class="fa fa-edit"></i> </button>
                                                                                        <button type="button" class="btn default btn-aguardando-veiculo" <?php echo $loDisabledStatusAguardandoVeic.$loDisabledStatusFechado; ?> >Aguardando Ve&iacute;culo <i class="fa fa-automobile"></i> </button>
                                                                                         <br />  <br />
                                                                                        <button type="button" class="btn default btn-imprimir-autorizacao"  >Imprimir <i class="fa fa-print"></i></button>
                                                                                        <!--button type="button" class="btn default btn-email-autorizacao"  >Email <i class="fa fa-envelope"></i></button-->
                                                                                        <button type="button" class="btn default btn-cancelar" <?php echo $loDisabledStatusCancelado;?>  >Cancelar <i class="fa fa-close"></i></button>
                                                                                        <!--button type="button" class="btn default btn-voltar" >Voltar <i class="fa fa-mail-reply"></i> </button-->
                                                                                    </div>
                                                                                </div>


                                                                            </div>   

                                                                                                                           

                                                                        </div>                                                            
                                                                    </form>
                                                                    </div>


                                                                    <!-- FIM SUB ABA 3.2 ATENDIMENTO -->

                                                            </div>
                                                            <div class="tab-pane" id="tab6">



                                                 <!-- INICIO SUB ABA 3.3 ROTA -->
                                         

                                                                            

                                                                        <!--Grupo Informações ROTA -->
                                                                        <div id="conteudo-grid-rota">
                                                                        <?php if(isset($_REQUEST["id"])){ 
                                                                     
                                                                            include("grid-rota-destinos-ajax.php");
                                                                            
                                                                         } ?>
                                                                         </div>
                                                                        <!--Grupo Informações ROTA -->


                                                                        <div class="form-actions">
                                                                        <div class="row">
                                                                            <div class="col-md-offset-3 col-md-9">
                                                                                <!--button type="button" class="btn dark btn-gravar-dados" >Adicionar</button-->
                                                                                <button type="button" class="btn default btn-fechar" <?php echo $loDisabledStatusFechado.$loDisabledUsuarioGestor; ?>  >Fechar <i class="fa fa-lock"></i></button>
                                                                                <button type="button" class="btn default btn-agendado" <?php echo $loDisabledStatusAgendado.$loDisabledStatusFechado; ?> >Agendado <i class="fa fa-edit"></i> </button>
                                                                                <button type="button" class="btn default btn-aguardando-veiculo" <?php echo $loDisabledStatusAguardandoVeic.$loDisabledStatusFechado; ?> >Aguardando Ve&iacute;culo <i class="fa fa-automobile"></i> </button>

                                                                                <button type="button" class="btn default btn-imprimir-autorizacao"  >Imprimir <i class="fa fa-print"></i></button>
                                                                                <!--button type="button" class="btn default btn-email-autorizacao"  >Email <i class="fa fa-envelope"></i></button-->
                                                                                <button type="button" class="btn default btn-voltar" >Voltar <i class="fa fa-mail-reply"></i> </button>
                                                                            </div>
                                                                        </div>

                                                                        <br />
                                                                        <br />
                                                                        <br />

                                                               
                                                         
                                                               
                                                                <!-- FIM SUB ABA 3.3 ROTA -->


                                                            </div>                                                            
                                                        </div>
                                                    </div> 
                                                    </div>

                    

                                                <!-- FIM CONTEUDO ABA 3 - ATENDIMENTO -->  

                                             </div>

      
 
                                        </div>
                                    </div>

                                </div>
                            </div>


                            </div><!--<div class="col-md-6 ">-->
                    
                    </div><!--<div class="row">-->


                        <br />
                        <br />
                        <br />


                    <div class="row">
                            <div class="col-md-7 ">
                            <!-- BEGIN SAMPLE FORM PORTLET item 2 -->
                            <div class="portlet light bordered">
                                <div class="portlet-body form">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-body">


                                            <div class="form-group">

                                                
                                                <div class="col-md-3">
                                                Aberto Por
                                                    <input type="text" class="form-control input-sm" value="<?php echo $loNomeUsuarioAbertura; ?>" disabled >
                                                Aprovada
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $lonomeUsuarioAprovado; ?>" >
                                                </div>                                                
                                                <div class="col-md-3">
                                                Data Hora 
                                                <input type="text" class="form-control input-sm" disabled value="<?php echo $lodtAbertura; ?>" >
                                                Data Hora
                                                <input type="text" class="form-control input-sm" disabled value="<?php echo $lodtAprovado; ?>" >
                                                </div>

                                                <div class="col-md-3">
                                                    Enc. ao Gestor
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $loNomeGestor; ?>"  >
                                                    Cancelada
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $lonomeUsuarioCancelamento; ?>" >                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    Data Hora
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $lodtEncGestor; ?>" >

                                                    Data Hora
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $lodtCancelamento; ?>" >                                                    
                                                </div> 


                                                <div class="col-md-3">
                                                    Fechado
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $loNomeUsuarioFechamento; ?>" >
                                                </div> 
                                                    <div class="col-md-3">
                                                    Hora
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $lodtFechamento; ?>" >
                                                </div> 

                                                <div class="col-md-3">
                                                    &Uacute;ltima Altera&ccedil;&atilde;o
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $loNomeUsuarioAlt; ?>" >
                                                </div> 
                                                    <div class="col-md-3">
                                                    Hora
                                                    <input type="text" class="form-control input-sm" disabled value="<?php echo $lodtAlt; ?>" >
                                                </div> 

                                            </div>



                                   
                                        </div>
                                    </form>
                                </div>
                                </div>
                                </div>
                                </div>













<!-- ================================================================================================================= -->
                  
             
             
                
        <div id="dialog-message" ></div>
        

        <input type="hidden" id="grupoAcessoUsuario" value="<?php echo $loGrupoAcessoUsuario; ?>" />
        <input type="hidden" id="grupoAcessoGestor" value="<?php echo $loGrupoAcessoGestor; ?>" />

        <input type="hidden" id="grupoAcessoOperador" value="<?php echo $loGrupoAcessoOperador; ?>" />
        <input type="hidden" id="grupoAcessoAdm" value="<?php echo $loGrupoAcessoAdm; ?>" />

        <input type="hidden" id="ind_status_retornado" value="<?php echo $loindStatusRetornado; ?>" />
        


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
        <script src="../../../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
        <!-- scripts END -->

        <?php 
            if($loAtendimentoRota == 1){
        ?>
            <script>
                $("#tab5-pai").parent().removeClass("active");
                $("#tab5").removeClass("active");
                $("#tab6-rota").parent().addClass("active");
                $("#tab6").addClass("active");                
                Solicitacao.AbaRota();
            </script>
        <?php
            }

             $loExibir = $loComum->VerificaCarona();
             if($loExibir && $loAcao == "I"){
             ?>
                <script>Solicitacao.MessagemUsuarioRequeCarona();</script>
             <?php
             }
        ?>

    </body>

</html>