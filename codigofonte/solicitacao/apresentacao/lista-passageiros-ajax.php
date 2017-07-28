<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
<?php

$loDados = null;
if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }

if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }

$loPessoa = new pessoaBO();

?>
<?php
$loHtml = "";
if(count($loDados) > 0 ){

    foreach ($loDados as $item){    

            $loDadosC = array( 
                'tipo_pessoa' => '4'
                , 'id' => $item 
            );

            $loLista =  $loPessoa->ListaPessoa($loDadosC);

            if(count($loLista) > 0 ){

                foreach ($loLista as $row){     

                    if($row["ind_motorista"] == 1){ $loMotorista = "SIM"; }else{$loMotorista = "N&Atilde;O";}           

                       $loHtml ="<td> ".$row["nome"]." </td>
                                    <td> 
                                        <a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>
                                        <input type='hidden' class='codigo-passageiros' value='".$row["id_pessoa"]."' />
                                        </td>";

                        $loItens[] = array('td' => $loHtml);                                


            }
        }
    }
    
}

echo json_encode($loItens);


?>




