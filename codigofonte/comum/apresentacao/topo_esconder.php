<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
<?php 

$loDadosMotorista = new pessoaBO();

$loContagemHanilitacao = 0;
$loContDadosMotorista =  $loDadosMotorista->ListaMotoristaVencHabilitacao(0);
if(count($loContDadosMotorista) > 0 ){ foreach ($loContDadosMotorista as $row){ $loContagemHanilitacao++; } }


$loItensMotH = "";
$loDadosC = array( 'not_limit' => '5');
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

?>

<div class="page-header-top">
                <div class="container">
                    <!-- BEGIN LOGO -->
                    <!--div class="page-logo">
                        <a href="../../comum/apresentacao/inicio.php">
                            <img src="../../../assets/global/img/logo_227_115.png" width="125" height="61" alt="logo" class="logo-default"> 
                        </a>
                    </div-->
                    <!-- END LOGO -->



                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            
                            
                        <!-- AVISO SISTEMA INCIO -->

                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge "> <?php echo $loContagemHanilitacao; ?> </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3> Notificacao de Habilitacao  </h3>
                                        <a href="#" onClick="MotoristaHabilitacaoVenc_onClick();"  >Ver Todos</a>
                                    </li>
                                    <li>
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><ul class="dropdown-menu-list scroller" style="height: 250px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                                        
                                            <?php echo $loItensMotH; ?>               
    
                                        </ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 121.359px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                                    </li>
                                </ul>
                            </li>

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
                                            <i class="icon-user"></i> Alterar </a>
                                    </li>

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
                </div>
            </div>


            <div id="dialog-habilitacao" ></div>