<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-pessoa.php");  ?>

<?php

$nome = null;
$ind_passageiro= null;
$ind_motorista= null;
$ind_condutor= null;
$status = null;
$cpf = null;

if(isset($_REQUEST["id_menu"])){
    $IdMenu = $_REQUEST["id_menu"];
}

if(isset($_REQUEST["nome"])){
    $nome = $_REQUEST["nome"];
}
if(isset($_REQUEST["cpf"])){
    $cpf = $_REQUEST["cpf"];
}
if(isset($_REQUEST["status"])){
    $status = $_REQUEST["status"];
}
if(isset($_REQUEST["ind_passageiro"])){
    $ind_passageiro = $_REQUEST["ind_passageiro"];
}
if(isset($_REQUEST["ind_motorista"])){
    $ind_motorista = $_REQUEST["ind_motorista"];
}
if(isset($_REQUEST["ind_condutor"])){
    $ind_condutor = $_REQUEST["ind_condutor"];
}


$loPessoa = new pessoaBO();


?>
<html>

    <head>
        
        <title>Agenda Lets | </title>
        
         <!-- CABECALHO BEGIN -->
         <?php include("../../comum/apresentacao/cabecalho.php"); ?>
         <!-- CABECALHO HEAD -->
        <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
 
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
                                        <i class="fa fa-users"></i>
                                        <span class="caption-subject bold uppercase"> Pessoa </span>
                                    </div>
                                   
                                </div>

                                <h6><i class="fa fa-filter"></i> Filtro</h4>
                   

                                <form class="form-inline" id="form-filtro" role="form" method="POST" >


                                        <div class="form-group">
                                               
                                                
                                                <div class="col-md-2">Nome<br />
                                                    <input type="text" id="filtro-nome" name="filtro-nome" class="form-control"  size="30" value="<?php echo $nome != "" ? $nome : ""; ?>" >
                                                </div>
              
                                            </div>
                                           <div class="form-group">
                                                 <div class="col-md-3">CPF <br />
                                                    <input type="text" id="filtro-cpf" name="filtro-cpf" class="form-control mask_cpf" size="20" value="<?php echo $cpf != "" ? $cpf : ""; ?>" >
                                                </div>                                           
                                           </div>
                                        
                                        <div class="form-group">Status <br />
                                         <select class="form-control input-small" id="filtro-status" name="status" >
                                                    <option value="1" <?php echo $status == "1" ? "selected" : ""; ?> >Ativo</option>
                                                    <option value="0" <?php echo $status == "0" ? "selected" : ""; ?> >Desativo</option>
                                                    <option value="0,1" <?php echo $status == "0,1" ? "selected": ""; ?>>Todos</option>
                                                </select>   
                                        </div>
                                       <div class="form-group">
                                       <br />

                                        Motorista  <input type="checkbox" id="ind-motorista" <?php echo $ind_motorista == 1 ? "checked" : ""; ?>>
                                        Passageiro <input type="checkbox" id="ind-passageiro" <?php echo $ind_passageiro == 1 ? "checked": ""; ?> >
                                        Condutor   <input type="checkbox" id="ind-condutor"  <?php echo $ind_condutor == 1 ? "checked": ""; ?> >


                                        </div>
                                        <div class="btn-group btn-group-sm btn-group-solid"><br/>
                                            <a href="#" id="pesquisa" class="btn sbold dark"> Pesquisar
                                                    <i class="fa fa-search"></i>
                                            </a>
                                        </div>
                                           <input type="hidden" name="id-menu-exp" id="id-menu-exp" value="<?php echo $IdMenu; ?>" />
                                           <input type="hidden" name="tipo-pessoa" id="tipo-pessoa" value="4,5" /> 
                                           <input type="hidden" name="nomenclatura" id="nomenclatura" value="MotoristaPassageiro.pdf" /> 
                                           <input type="hidden" name="titulo" id="titulo" value="Relatorio Motorista Passageiro" />   
                                    </form>

                                    <br />
                                    <br />


                    


                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group btn-group-sm btn-group-solid">
                                                    <button id="btn-adicionar" class="btn sbold dark"> Adicionar
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    </div>
                                                    <div class="btn-group btn-group-sm btn-group-solid">
                                                    <button id="btn-desativar" class="btn sbold dark input-sm"> Desativar
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                </div>
                                            </div>
                                  

                                        <div class="col-md-5">

                                                <div class="btn-group pull-right">
                                                    <button class="btn dark  btn-outline dropdown-toggle" data-toggle="dropdown">Colunas
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        
                                                            
                                                            <?php
                                                                $loGridItens =  $loPessoa->GridConsultaItens($IdMenu);

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
                                                            <a href="#" id="exportar-excel">
                                                                <i class="fa fa-file-excel-o"></i> Exportar Excel </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" id="exportar-pdf" >
                                                                <i class="fa fa-file-pdf-o"></i> Exportar PDF </a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    
                                   
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes">
                                                </th>
                                                <?php

                                                //Cabeçalho da consulta dinamica 
                                                $loDadosC = array( 
                                                         'id_menu' => $IdMenu 
                                                    );

                                                $loItensConsulta =  $loPessoa->ListaItensConsulta($loDadosC);

                                                 if(count($loItensConsulta) > 0){
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
                                                 }

                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody id="conteudo">
   
                                           
                                           <?php include("consulta-motorista-passageiro-ajax.php"); ?>


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
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
      
        <!-- BEGIN INNER FOOTER -->
        <?php include("../../comum/apresentacao/rodape.php"); ?>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->



        <!-- scripts BEGIN -->
        <?php include("../../comum/apresentacao/scripts.php"); ?>

        <script src="js/motorista-passageiro.js" type="text/javascript"></script>

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