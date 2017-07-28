<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-pessoa.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loEndereco = null;
$loConsulta = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["endereco"])){ $loEndereco = $_REQUEST["endereco"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["consulta"])){ $loConsulta = $_REQUEST["consulta"]; }

if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }

$loComum = new comumBO();

$loPessoa = new pessoaBO();

?>

<br />

<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
        <tr>
            <th width="1%">
            </th>
            <th width="30%">Gargem Origem </th>
            <th width="30%">Garagem Destino </th> 
            <th width="10%">Data </th>
            <th width="10%">Motivo </th>

        </tr>
    </thead>
    <tbody  >


       <?php
            $loDadosC = array('id_motorista' => $loId );

            $loLista =  $loPessoa->ListaHistorioGargem($loDadosC);

            if(count($loLista) > 0){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td> </td>
                    <td> <?php echo $row["origem"]; ?> </td>
                    <td> <?php echo $row["destino"]; ?> </td>
                    <td> <?php echo $row["data_inc"]; ?> </td>
                    <td> <?php echo $row["motivo_alteracao"]; ?> </td>

                </tr>
            <?php

                }
                
            }

            ?>


    </tbody>
</table>





