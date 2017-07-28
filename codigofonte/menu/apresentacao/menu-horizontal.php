<?php include("../../menu/negocio-menu.php"); ?>
<?php include_once("../../comum/negocio-comum.php"); ?>
<?php 

$loComum = new comumBO();

?>
            <div class="page-header-menu">
                <div class="container">



              
              
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu  ">
                        <ul class="nav navbar-nav">
                          

                        <?php
                        
                        $loMenu = new menuBO();
                        $loDadosMenu =  $loMenu->ListaMenu();

                        foreach ($loDadosMenu as $row){
                            
                            $loUrl= "javascript:;"; 
                            $loTarget = "";
                            
                            if($row["id_menu"] == 28){//Display 
                                $loUrl = $row["url"]."?id_menu=".$row["id_menu"];
                                $loTarget = "target='_blank'";
                            }
                            
                        ?>
                        
                          <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="<?php echo $loUrl; ?>" <?php echo $loTarget; ?>  > 
                                     <i class="<?php echo $row["css_icon"]; ?>"></i>
                                    <?php echo $row['nome']; ?>
                                </a>


                                <ul class="dropdown-menu pull-left">

                                     <?php
                                 //Exibir Sub Menus
                                 $loSubMenu = new menuBO();
                                 $loDadosSubMenu =  $loSubMenu->ListaSubMenu($row['id_menu']);

                                 if(count($loDadosSubMenu) > 0){
                                    foreach ($loDadosSubMenu as $rowSub){
                                    ?>
                                   
                                   <?php if($rowSub["nome"] == "Empresa" &&  $_SESSION["supervisor"] != 1 ){ $loExibir = false; }else{ $loExibir = true; }?>
                                   
                                   <?php 
                                    if($rowSub["id_menu"] == 33){//Carona
                                        $loExibir = $loComum->VerificaCarona();
                                    }                                    
                                   ?>

                                   <?php if($loExibir){ ?> 
                                    <li class=" ">
                                                                      
                                        <?php if($rowSub["id_menu"] == 13 || $rowSub["id_menu"] == 25){    ?>
                                            <a href="#" onClick="window.open('<?php echo $rowSub["url"]."?id_menu=".$rowSub["id_menu"]; ?>', '_blank', 'width=1300 height=600');" class="nav-link ">
                                                    <i class="<?php echo $rowSub["css_icon"]; ?>"></i>
                                                    <span class="title"><?php echo $rowSub["nome"]; ?></span>
                                            </a>
                                        <?php }else{ ?>
                                            <a href="<?php echo $rowSub["url"]."?id_menu=".$rowSub["id_menu"]; ?>" class="nav-link ">
                                                    <i class="<?php echo $rowSub["css_icon"]; ?>"></i>
                                                    <span class="title"><?php echo $rowSub["nome"]; ?></span>
                                            </a>
                                        <?php } ?>

                                    </li>
                                   <?php } ?>


                                <?php 
                                    }
                                 }
                                ?>
                                   
                                </ul>


                        <?php } ?>    
                            </li>
                          
                      










                            <!--li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> Dashboard
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="index.html" class="nav-link  ">
                                            <i class="icon-bar-chart"></i> Default Dashboard
                                            <span class="badge badge-success">1</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="dashboard_2.html" class="nav-link  ">
                                            <i class="icon-bulb"></i> Dashboard 2 </a>
                                    </li>
                                    <li class=" ">
                                        <a href="dashboard_3.html" class="nav-link  ">
                                            <i class="icon-graph"></i> Dashboard 3
                                            <span class="badge badge-danger">3</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown mega-menu-dropdown  ">
                                <a href="javascript:;"> UI Features
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu" style="min-width: 710px">
                                    <li>
                                        <div class="mega-menu-content">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <a href="ui_colors.html"> Color Library </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_general.html"> General Components </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_buttons.html"> Buttons </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_confirmations.html"> Popover Confirmations </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_icons.html"> Font Icons </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_socicons.html"> Social Icons </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_typography.html"> Typography </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_tabs_accordions_navs.html"> Tabs, Accordions & Navs </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_tree.html"> Tree View </a>
                                                        </li>
                                                        <li>
                                                            <a href="maps_google.html"> Google Maps </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <a href="maps_vector.html"> Vector Maps </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_timeline.html"> Timeline </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_page_progress_style_1.html"> Page Progress Bar - Flash </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_page_progress_style_2.html"> Page Progress Bar - Big Counter </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_blockui.html"> Block UI </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_bootstrap_growl.html"> Bootstrap Growl Notifications </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_notific8.html"> Notific8 Notifications </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_toastr.html"> Toastr Notifications </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_bootbox.html"> Bootbox Dialogs </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <a href="ui_alerts_api.html"> Metronic Alerts API </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_session_timeout.html"> Session Timeout </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_idle_timeout.html"> User Idle Timeout </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_modals.html"> Modals </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_extended_modals.html"> Extended Modals </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_tiles.html"> Tiles </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_datepaginator.html"> Date Paginator </a>
                                                        </li>
                                                        <li>
                                                            <a href="ui_nestable.html"> Nestable List </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> Layouts
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="layout_mega_menu_light.html" class="nav-link  "> Light Mega Menu </a>
                                    </li>
                                    <li class=" ">
                                        <a href="layout_top_bar_light.html" class="nav-link  "> Light Top Bar Dropdowns </a>
                                    </li>
                                    <li class=" ">
                                        <a href="layout_fluid_page.html" class="nav-link  "> Fluid Page </a>
                                    </li>
                                    <li class=" ">
                                        <a href="layout_top_bar_fixed.html" class="nav-link  "> Fixed Top Bar </a>
                                    </li>
                                    <li class=" ">
                                        <a href="layout_mega_menu_fixed.html" class="nav-link  "> Fixed Mega Menu </a>
                                    </li>
                                    <li class=" ">
                                        <a href="layout_disabled_menu.html" class="nav-link  "> Disabled Menu Links </a>
                                    </li>
                                    <li class=" ">
                                        <a href="layout_blank_page.html" class="nav-link  "> Blank Page </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown mega-menu-dropdown  mega-menu-full">
                                <a href="javascript:;"> Components
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu" style="min-width: ">
                                    <li>
                                        <div class="mega-menu-content">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <h3>Components 1</h3>
                                                        </li>
                                                        <li>
                                                            <a href="components_date_time_pickers.html"> Date & Time Pickers </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_color_pickers.html"> Color Pickers </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_select2.html"> Select2 Dropdowns </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_select.html"> Bootstrap Select </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_multi_select.html"> Multi Select </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <h3>Components 2</h3>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_select_splitter.html"> Select Splitter </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_typeahead.html"> Typeahead Autocomplete </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_tagsinput.html"> Bootstrap Tagsinput </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_switch.html"> Bootstrap Switch </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_maxlength.html"> Bootstrap Maxlength </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <h3>Components 3</h3>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_fileinput.html"> Bootstrap File Input </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_bootstrap_touchspin.html"> Bootstrap Touchspin </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_form_tools.html"> Form Widgets & Tools </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_context_menu.html"> Context Menu </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_editors.html"> Markdown & WYSIWYG Editors </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3">
                                                    <ul class="mega-menu-submenu">
                                                        <li>
                                                            <h3>Components 4</h3>
                                                        </li>
                                                        <li>
                                                            <a href="components_code_editors.html"> Code Editors </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_ion_sliders.html"> Ion Range Sliders </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_noui_sliders.html"> NoUI Range Sliders </a>
                                                        </li>
                                                        <li>
                                                            <a href="components_knob_dials.html"> Knob Circle Dials </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-dropdown classic-menu-dropdown ">
                                <a href="javascript:;"> More
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class="dropdown-submenu ">
                                        <a href="javascript:;" class="nav-link nav-toggle ">
                                            <i class="icon-settings"></i> Form Stuff
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class=" ">
                                                <a href="form_controls.html" class="nav-link "> Bootstrap Form
                                                    <br>Controls </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_controls_md.html" class="nav-link "> Material Design
                                                    <br>Form Controls </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_validation.html" class="nav-link "> Form Validation </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_validation_states_md.html" class="nav-link "> Material Design
                                                    <br>Form Validation States </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_validation_md.html" class="nav-link "> Material Design
                                                    <br>Form Validation </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_layouts.html" class="nav-link "> Form Layouts </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_input_mask.html" class="nav-link "> Form Input Mask </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_editable.html" class="nav-link "> Form X-editable </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_wizard.html" class="nav-link "> Form Wizard </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_icheck.html" class="nav-link "> iCheck Controls </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_image_crop.html" class="nav-link "> Image Cropping </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_fileupload.html" class="nav-link "> Multiple File Upload </a>
                                            </li>
                                            <li class=" ">
                                                <a href="form_dropzone.html" class="nav-link "> Dropzone File Upload </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu ">
                                        <a href="javascript:;" class="nav-link nav-toggle ">
                                            <i class="icon-briefcase"></i> Tables
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-submenu ">
                                                <a href="javascript:;" class="nav-link nav-toggle"> Static Tables
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="">
                                                        <a href="table_static_basic.html" class="nav-link "> Basic Tables </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_static_responsive.html" class="nav-link "> Responsive Tables </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="dropdown-submenu ">
                                                <a href="javascript:;" class="nav-link nav-toggle"> Datatables
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="">
                                                        <a href="table_datatables_managed.html" class="nav-link "> Managed Datatables </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_buttons.html" class="nav-link "> Buttons Extension </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_colreorder.html" class="nav-link "> Colreorder Extension </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder Extension </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_scroller.html" class="nav-link "> Scroller Extension </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_fixedheader.html" class="nav-link "> FixedHeader Extension </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_responsive.html" class="nav-link "> Responsive Extension </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_editable.html" class="nav-link "> Editable Datatables </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="table_datatables_ajax.html" class="nav-link "> Ajax Datatables </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu ">
                                        <a href="?p=" class="nav-link nav-toggle ">
                                            <i class="icon-wallet"></i> Portlets
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class=" ">
                                                <a href="portlet_boxed.html" class="nav-link "> Boxed Portlets </a>
                                            </li>
                                            <li class=" ">
                                                <a href="portlet_light.html" class="nav-link "> Light Portlets </a>
                                            </li>
                                            <li class=" ">
                                                <a href="portlet_solid.html" class="nav-link "> Solid Portlets </a>
                                            </li>
                                            <li class=" ">
                                                <a href="portlet_ajax.html" class="nav-link "> Ajax Portlets </a>
                                            </li>
                                            <li class=" ">
                                                <a href="portlet_draggable.html" class="nav-link "> Draggable Portlets </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu ">
                                        <a href="?p=" class="nav-link nav-toggle ">
                                            <i class="icon-settings"></i> Elements
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class=" ">
                                                <a href="elements_steps.html" class="nav-link "> Steps </a>
                                            </li>
                                            <li class=" ">
                                                <a href="elements_lists.html" class="nav-link "> Lists </a>
                                            </li>
                                            <li class=" ">
                                                <a href="elements_ribbons.html" class="nav-link "> Ribbons </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu ">
                                        <a href="javascript:;" class="nav-link nav-toggle ">
                                            <i class="icon-bar-chart"></i> Charts
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class=" ">
                                                <a href="charts_amcharts.html" class="nav-link "> amChart </a>
                                            </li>
                                            <li class=" ">
                                                <a href="charts_flotcharts.html" class="nav-link "> Flot Charts </a>
                                            </li>
                                            <li class=" ">
                                                <a href="charts_flowchart.html" class="nav-link "> Flow Charts </a>
                                            </li>
                                            <li class=" ">
                                                <a href="charts_google.html" class="nav-link "> Google Charts </a>
                                            </li>
                                            <li class=" ">
                                                <a href="charts_echarts.html" class="nav-link "> eCharts </a>
                                            </li>
                                            <li class=" ">
                                                <a href="charts_morris.html" class="nav-link "> Morris Charts </a>
                                            </li>
                                            <li class="dropdown-submenu ">
                                                <a href="javascript:;" class="nav-link nav-toggle"> HighCharts
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="">
                                                        <a href="charts_highcharts.html" class="nav-link " target="_blank"> HighCharts </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="charts_highstock.html" class="nav-link " target="_blank"> HighStock </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="charts_highmaps.html" class="nav-link " target="_blank"> HighMaps </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li-->


                            
                           
                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>