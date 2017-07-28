<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-relatorio.php");
include("../../comum/Mpdf/mpdf.php");

if(isset($_REQUEST["id_solicitacao"])){
    $loId = $_REQUEST["id_solicitacao"];
}


$loNomeSetor               = NULL;
$loNomeRequisitante        = NULL;
$loDDRequisitante          = NULL;
$loTelefoneRequisitante    = NULL;
$loFinalidade              = NULL; 
$loDtAbertura              = NULL;
$loDtAprovado              = NULL;
$loDtSaida                 = NULL;
$loDtRetornoPrev           = NULL;
$loNomeOrigem              = NULL;
$loPlaca                   = NULL;
$loNomeModelo              = NULL;
$loNomeMotorista           = NULL;
$loDDMotorista             = NULL;
$loTelefoneMotorista       = NULL;
$loDestinos                = NULL; 
$loPassageiros             = NULL;

$loRelatorio = new relatorioBO();

$loDadosC = array('id_solicitacao' => $loId);
$loLista =  $loRelatorio->TempoAtendimento($loDadosC);



$loHtml = "";
$loHtml .= "<table width='100%' style='border:1px; border-style:solid; border-color:#000; font-family:'Arial'; font-size:14px;' >";
$loHtml .= "<tr >";
$loHtml .= "    <td colspan='7'><img src='../../comum/apresentacao/imagens/logo_salute.jpg' /></td>";
$loHtml .= "    <td colspan='7' align='right' ><img src='../../comum/apresentacao/imagens/logo_secretaria.jpg' /></td>";
$loHtml .= "</tr>";
$loHtml .= "<tr >";
$loHtml .= "    <td colspan='9' align='center' style='border-top: thin solid; border-bottom: thin solid;'><strong>Tempo Atendimento - Analitico</strong></td>";
$loHtml .= "</tr>";
$loHtml .= "<tr >";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='5%' >Solicitação</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='11%' >Data/Hora Inicio</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='11%' >Data/Hora Termino</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='9%' >Tempo Atendimento</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='9%' >Tempo Deslocamento</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='17%' >Passageiro</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='11%' >Setor</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='11%' >Garagem Atual do Veiculo</td>";
$loHtml .= "    <td style='font-size:11px; font-weight: bold;' width='16%' >Motorista</td>";
$loHtml .= "</tr>";
$loHtml .= "<tr >";
$loHtml .= "    <td colspan='9' align='center' style='border-top: thin solid;'></td>";
$loHtml .= "</tr>";
foreach ($loLista as $row){

      
        if(count($row["passageiros"])>0){
            foreach($row["passageiros"] as $rowPassageiro){
                foreach($rowPassageiro as $passageiro){
                     $loPassageiros .= $passageiro.",";
                }
            }
            $loPassageiros = substr( $loPassageiros,0,  $loPassageiros-1);
        }         

        $loHtml .= "<tr style='font-size:12px;'>";
        $loHtml .= "    <td style='font-size:11px;'>".$row["id_solicitacao"]."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".$row["dt_saida"]."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".$row["dt_retorno_prev"]."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".substr(str_replace("-", "", $row["tempoAtendimento"]),0,5)."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".substr($row["tempoDeslocamento"],0,5)."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".$loPassageiros ."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".$row["setor"]."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".$row["garagem"]."</td>";
        $loHtml .= "    <td style='font-size:11px;'>".$row["motorista"]."</td>";
        $loHtml .= "</tr>";

}

$loHtml .= "<tr >";
$loHtml .= "    <td style='border-top: thin solid; border-bottom: thin solid;' colspan='9'>&nbsp;</td>";
$loHtml .= "</tr>";
$loHtml .= "</table>";

/*echo utf8_decode($loHtml);
exit;*/

$mpdf=new mPDF('','A4-L');
$mpdf->WriteHTML($loHtml);
//$mpdf->Output();
$mpdf->Output("AutorizacaoDeSolicitacao_".$loId.".pdf", 'D');
exit();

?>

