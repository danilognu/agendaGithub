<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-solicitacao.php");  ?>
<?php

$loDados = null;
$loConsulta = null;
if(isset($_REQUEST["dados"])){ $loDados = $_REQUEST["dados"]; }
if(isset($_REQUEST["consulta"])){ $loConsulta = $_REQUEST["consulta"]; }
if(isset($_REQUEST["id_solicitacao"])){ $loIdsolicitacao = $_REQUEST["id_solicitacao"]; }

$loSolicitacao= new solicitacaoBO();

$loHtml = "";
if(count($loDados) > 0 ){

    foreach ($loDados as $item){    

            $loDadosC = array( 
                    'id_localidade' => $item
                    //,'id_solicitacao' => $loIdsolicitacao  
            );


            $loLista =  $loSolicitacao->ListaLocalidade($loDadosC);

            if(count($loLista) > 0 ){
                $loContagem = 1;
                foreach ($loLista as $row){     

                    if( $loConsulta == "paradas"){ 
                        $value = $row["id_localidade"].":".$row["id_destino"];
                        $onclick = "Solicitacao.RemoverLinhaParadas(this,".$row["id_destino"].");"; 
                    }else{ 
                        $value = $row["id_localidade"]; 
                        $onclick = "Solicitacao.RemoverLinha(this);";
                    }


                        $loHtml = "<td>".utf8_encode($row["nome"])." - ".utf8_encode($row["endereco"])."</td>
                                    <td> 
                                        <a href='#' class='btn-rota' onclick='".$onclick."' ><i class='fa fa-close'></i> Remover </a>
                                        <input type='hidden' class='codigo-localidade-".$loConsulta."' value='".$value."' />
                                    </td>";
                       $loItens[] = array('td' => $loHtml); 
                       $loContagem++;    

            }
        }
    }
    
}
echo json_encode($loItens);
?>



