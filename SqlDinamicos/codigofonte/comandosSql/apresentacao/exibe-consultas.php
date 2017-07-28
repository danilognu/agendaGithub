<?php include("../../../conexao-todos-bd.php"); ?>
<?php include("../../../conexao-base.php"); ?>
<?php  include("../negocio.php");  ?>
<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>SQL COMANDOS</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../../../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../../../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
       
       <link href="../../../assets/layouts/layout3/css/jquery-ui.css" rel="stylesheet" type="text/css" />
       
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-full-width">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.html">
                        <img src="../../../assets/layouts/layout/img/logoo.png" alt="logo" class="logo-default" /> </a>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN MEGA MENU -->
                <!-- DOC: Remove "hor-menu-light" class to have a horizontal menu with theme background instead of white background -->
                <!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) in the responsive menu below along with sidebar menu. So the horizontal menu has 2 seperate versions -->
                <div class="hor-menu   hidden-sm hidden-xs">
                    <ul class="nav navbar-nav">
                        <!-- DOC: Remove data-hover="megamenu-dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
                        <li class="classic-menu-dropdown active">
                            <a href="index.html"> Comados
                                <span class="selected"> </span>
                            </a>
                        </li>

                        <li class="classic-menu-dropdown">
                            <a href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true"> Configuracao
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-left">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-bookmark-o"></i> Comandos Sql</a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-user"></i> Cadastro de Usuario </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-puzzle-piece"></i> Grupo de Acesso </a>
                                </li>
                            </ul>
                        </li>

                         
                      
                    </ul>
                </div>
                <!-- END MEGA MENU -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->

            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- END SIDEBAR MENU -->
                    <div class="page-sidebar-wrapper">
                        <!-- BEGIN RESPONSIVE MENU FOR HORIZONTAL & SIDEBAR MENU -->
                        <ul class="page-sidebar-menu visible-sm visible-xs  page-header-fixed">
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
                            <li class="sidebar-search-wrapper">
                                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                                <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
                                    <a href="javascript:;" class="remove">
                                        <i class="icon-close"></i>
                                    </a>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <button class="btn submit">
                                                <i class="icon-magnifier"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                                <!-- END RESPONSIVE QUICK SEARCH FORM -->
                            </li>
                          
                        </ul>
                        <!-- END RESPONSIVE MENU FOR HORIZONTAL & SIDEBAR MENU -->
                    </div>
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                  
                 
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> CONTROLE DE ALTERACOES
                        <small></small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!--div class="note note-info">
                        <p> Escolha o banco ao lado </p>
                    </div-->

                    <?php  include("listabancos.php"); ?>
                    <br /><br /><br />
                    <?php  include("listacomandos.php"); ?>


                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
          
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> sql comandos
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->

        
        <script src="../../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

        <script src="../../../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../../../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script src="js/consultas.js" type="text/javascript"></script>



    

    </body>

</html>