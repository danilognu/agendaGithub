<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
<?php 

$loTopAcessoIndOperado = NULL;
$loTopAcessoIndGestor = NULL;
$loTopAcessoInAdm = NULL;


$loDadosMotorista = new pessoaBO();
$loComum = new comumBO();
$loTopAcessoIndOperador = 0;
$loTopAcessoIndGestor = 0;
$loTopAcessoIndAdm = 0;
$loTopAcessoIndUsuario = 0;

//Verica Acesso
$loDadosAcessoUsuarioCc = $loComum->ListaDadosAcessoUsuarioCorrente();
if(count($loDadosAcessoUsuarioCc) > 0){
    foreach ($loDadosAcessoUsuarioCc as $row){ 

        $loTopAcessoIndOperador = $row["ind_operador"];
        $loTopAcessoIndGestor = $row["ind_gestor"];
        $loTopAcessoIndAdm = $row["ind_adm"];
        $loTopAcessoIndUsuario = $row["ind_usuario"];

    }
}


$loContagemHanilitacao = 0;
$loDadosCont = array( 'not_limit' => '1000', 'ind_gestor' => $loTopAcessoIndGestor, "ind_usuario" => $loTopAcessoIndUsuario );
$loContDadosMotorista =  $loDadosMotorista->ListaMotoristaVencHabilitacao($loDadosCont);
if(count($loContDadosMotorista) > 0 ){ foreach ($loContDadosMotorista as $row){ $loContagemHanilitacao++; } }

$loItensMotH = "";
$loDadosC = array( 'not_limit' => '5', 'ind_gestor' => $loTopAcessoIndGestor, "ind_usuario" => $loTopAcessoIndUsuario );
$loListaDadosMotorista =  $loDadosMotorista->ListaMotoristaVencHabilitacao($loDadosC);
if(count($loListaDadosMotorista) > 0 ){ 
    foreach ($loListaDadosMotorista as $row){ 
        $loItensMotH  .= "
                    <li>
                        <a href='../../pessoa/apresentacao/adicionar-motorista-passageiro.php?id_menu=8&acao=U&id=".$row["id_pessoa"]."'>
                            <span class='time'>".$row["DiasparaVenc"]." Dias</span>
                            <span class='details'>
                                <span class='label label-sm label-icon label-success'>
                                    </span> ".$row["nome"]."
                                </span>
                        </a>
                    </li>
        "; 
            } 
}

$loContaCarona = 0;
$loItensMotCarona = "";
$loPendenciaCaronaTopo = $loComum->PendenciasDeAutorizacaoCarona();
if(count($loPendenciaCaronaTopo) > 0){
    $loContaCarona = count($loPendenciaCaronaTopo);
     foreach ($loPendenciaCaronaTopo as $row){ 
           $loItensMotCarona  .= "
                    <li>
                        <a href='../../solicitacao/apresentacao/consulta-atencimentos.php?id_menu=30&id=".$row["id_solicitacao"]."&situacao=0&not_limit=0&ind_carona=0'>
                            <span class='time'> Solic: ".$row["id_solicitacao"]." </span>
                            <span class='details'>
                                <span class='label label-sm label-icon label-success'>
                                    </span> ".$row["pessoa_solicitante"]."
                                </span>
                        </a>
                    </li>
        ";      
     
     }
}

$loNomeArquivoLogo = NULL;
$loCaminhoArquivoLogo = NULL;

$loDadosLogo = $loComum->BuscaLogoEmpresa();
if(count($loDadosLogo) > 0){
    foreach ($loDadosLogo as $row){ 
        $loNomeArquivoLogo      = $row["arquivo_logo"];
        $loCaminhoArquivoLogo   = $row["arquivo_logo_caminho"];
    }
}
?>

<div class="page-header-top">
                <div class="container">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="../../comum/apresentacao/inicio.php">
                            <img src="../../../assets/global/img/logo_227_115.png" width="125" height="61" alt="logo" class="logo-default"> 
                        </a>
                    </div>

                   
                    <!-- END LOGO -->



                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">

                        <ul class="nav navbar-nav pull-right">
                            
                            
                        <!-- AVISO SISTEMA INCIO -->
                        <?php if( $loTopAcessoIndUsuario == 0 && ($loContagemHanilitacao > 0 || $loContaCarona > 0) ){ ?> 
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge "> <?php echo $loContagemHanilitacao+$loContaCarona; ?> </span>
                                </a>
                                <ul class="dropdown-menu">

                                   <?php if($loContaCarona > 0 ){ ?>
                                        <li class="external">
                                            <h3> Notifica&ccedil;&atilde;o de Carona  </h3>
                                        </li>

                                        <li>
                                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                                            <ul class="dropdown-menu-list scroller" style=" overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                                            
                                                <?php echo $loItensMotCarona; ?>               
        
                                            </ul>
                                            </div>
                                        </li>
                                   <?php } ?>


                                    <li class="external">
                                        <h3> Notifica&ccedil;&atilde;o de Habilita&ccedil;&atilde;o  </h3>
                                            <a href="#" onClick="MotoristaHabilitacaoVenc_onClick();"  >Ver Todos</a>
                                    </li>
                                    <li>
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;"><ul class="dropdown-menu-list scroller" style="height: auto; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                                        
                                            <?php echo $loItensMotH; ?>               
    
                                        </ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 121.359px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- AVISO SISTEMA FIM -->


                            
                            <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                            </li>
                          
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    
                                    <i class="fa fa-user"></i>

                                    <span class="username username-hide-mobile">Usuario: <?php echo $_SESSION["nome"]; ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="../../usuario/apresentacao/adicionar-usuario.php?id=<?php echo $_SESSION["id_usuario"]; ?>&acao=U ">
                                            <i class="icon-user"></i> Alterar Usu&aacute;rio </a>
                                    </li>

                                    <?php if($loTopAcessoIndOperador == 1 || $loTopAcessoIndAdm == 1){ ?>
                                    <li class="divider"> </li>
                                    <li>
                                        <a target="_blank" href="../../../documentacao/Manual.pdf">
                                            <i class="fa fa-book"></i> Manual </a>
                                    </li>
                                    <?php } ?>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="../../login/apresentacao/login.php">
                                            <i class="icon-key"></i> Sair </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                           
                        </ul>


                    </div>
                    <!-- END TOP NAVIGATION MENU -->

                    <?php if(strlen($loCaminhoArquivoLogo) > 0){ ?>
                    <div style="position: static; margin-left: 1150px; margin-top: 15px; ">
                        <img src="<?php echo $loCaminhoArquivoLogo.$loNomeArquivoLogo; ?>" width="90" height="50" alt="logo" class="logo-default">
                    </div>
                    <?php } ?>


                </div>
            </div>


            <div id="dialog-habilitacao" ></div>