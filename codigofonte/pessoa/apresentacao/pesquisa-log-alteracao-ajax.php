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

<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
    <thead>
        <tr>
            <th width="20%">Data  </th>
            <th width="20%">Campo Alterado </th> 
            <th width="18%">Valor Anterior </th>
            <th width="18%">Valor Atual </th>
            <th width="30%">Usuario que alterou </th>
        </tr>
    </thead>
    <tbody  >


       <?php
            $loDadosC = array('id' => $loId );

            $loLista =  $loPessoa->ListaLog($loDadosC);

            if(count($loLista) > 0){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td> <?php echo $row["dt_alt"]; ?> </td>                    
                    <td> <?php echo $row["item_alterado"]; ?> </td>
                    <td> <?php echo $row["valor_alterado"]; ?> </td>
                    <td> <?php echo $row["valor_atual"]; ?> </td>
                    <td> <?php echo $row["nome_usuario"]; ?> </td>

                </tr>
            <?php

                }
                
            }

            ?>


    </tbody>
</table>





