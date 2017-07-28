<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-solicitacao.php");
include("../../comum/Mpdf/mpdf.php");

$loTipoOut = "D";
$loPastaDestino = "";
$ItemUnico = "";

if(isset($_REQUEST["id_solicitacao"])){
    $loId = $_REQUEST["id_solicitacao"];
}

if(isset($_REQUEST["tipo_out_envio"]) && !empty($_REQUEST["tipo_out_envio"])){
    $loTipoOut = $tipoOutEnvio;
    $loPastaDestino = "autorizacoes";
    $ItemUnico = date("YmdHis");  
}

$loNomeOutput              = "AutorizacaoDeSolicitacao_".$loId."_".$ItemUnico.".pdf";

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

$loSolicitacao = new solicitacaoBO();

$loDadosC = array('id_solicitacao' => $loId);
$loLista =  $loSolicitacao->AutorizacaoPDF($loDadosC);


foreach ($loLista as $row){

        $loNomeSetor               = $row["nome_setor"];
        $loNomeRequisitante        = $row["nome_requisitante"];
        $loDDRequisitante          = $row["dd_requisitante"];
        $loTelefoneRequisitante    = $row["telefone_requisitante"];
        $loFinalidade              = $row["finalidade"]; 
        $loDtAbertura              = $row["dt_abertura"];
        $loDtAprovado              = $row["dt_aprovado"];
        $loDtSaida                 = $row["dt_saida"];
        $loDtRetornoPrev           = $row["dt_retorno_prev"];
        $loNomeOrigem              = $row["nome_origem"];
        $loPlaca                   = $row["placa"];
        $loNomeModelo              = $row["nome_modelo"];
        $loNomeMotorista           = $row["nome_motorista"];
        $loDDMotorista             = $row["dd_motorista"];
        $loTelefoneMotorista       = $row["telefone_motorista"];
        $loDestinos                = $row["destinos"];
        $loPassageiros             = $row["passageiros"];

}

$loComum = new comumBO();

$loNomeArquivoLogo = NULL;
$loCaminhoArquivoLogo = NULL;

$loDadosLogo = $loComum->BuscaLogoEmpresa();
if(count($loDadosLogo) > 0){
    foreach ($loDadosLogo as $row){ 
        $loNomeArquivoLogo      = $row["arquivo_logo"];
        $loCaminhoArquivoLogo   = $row["arquivo_logo_caminho"];
    }
}


$loHtml = "";
$loHtml .= "<table width='100%' style='border:1px; border-style:solid; border-color:#000; font-family:'Arial'; font-size:14px;' >";
$loHtml .= "<tr >";
$loHtml .= "    <td ><img src=".$loCaminhoArquivoLogo.$loNomeArquivoLogo." width='180' height='80' /></td>";
$loHtml .= "    <td align='right' ><!--img src='../../comum/apresentacao/imagens/logo_secretaria.jpg' /--></td>";
$loHtml .= "</tr>";
$loHtml .= "<tr >";
$loHtml .= "    <td style='border-top: thin solid; border-bottom: thin solid;' colspan='2'>&nbsp;</td>";
$loHtml .= "</tr>";
$loHtml .= "<tr>";
$loHtml .= "    <td>";
$loHtml .= "    <table style='border:0px; font-family:'Arial'; font-size:14px;'>";
$loHtml .= "        <tr>";
$loHtml .= "            <td><strong>Solicita&ccedil;&atilde;o</strong></td>";
$loHtml .= "        </tr>";
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Solicita&ccedil;&atilde;o de Veiculo: ".$loId."</td>";
$loHtml .= "        </tr>";
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Setor Requisitante: ".$loNomeSetor ."</td>";
$loHtml .= "        </tr>";
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Usu&aacute;rio Requisitante: ".$loNomeRequisitante ."</td>";
$loHtml .= "            <td style='padding-left: 1cm;'>Telefone: (".$loDDRequisitante.") ".$loTelefoneRequisitante."</td>";
$loHtml .= "        </tr>";  
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Finalidade: ".$loFinalidade."</td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td>&nbsp;</td>";
$loHtml .= "        </tr>";             
$loHtml .= "        <tr>";
$loHtml .= "            <td><strong>Detalhes:</strong></td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Data Hora Solicita&ccedil;&atilde;o: ".$loDtAbertura."</td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Data Hora Aprova&ccedil;&atilde;o: ".$loDtAprovado."</td>";
$loHtml .= "        </tr>";
$loHtml .= "        <tr>";
$loHtml .= "            <td>&nbsp;</td>";
$loHtml .= "        </tr>";             
$loHtml .= "        <tr>";
$loHtml .= "            <td><strong>Previs&atilde;o:</strong></td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Saida: ".$loDtSaida."</td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Retorno: ".$loDtRetornoPrev." </td>";
$loHtml .= "        </tr>";   
$loHtml .= "        <tr>";
$loHtml .= "            <td>&nbsp;</td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td><strong>Saida:</strong></td>";
$loHtml .= "        </tr>";                
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Local: ".$loNomeOrigem." </td>";
$loHtml .= "        </tr>";               
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Veiculo: ".$loNomeModelo."</td>";
$loHtml .= "            <td>Placa: ".$loPlaca."</td>";
$loHtml .= "            <td></td>";
$loHtml .= "        </tr>";
$loHtml .= "        <tr>";
$loHtml .= "            <td style='padding-left: 1cm;'>Motorista: ".$loNomeMotorista."</td>";
$loHtml .= "            <td>Telefone: (".$loDDMotorista.") ".$loTelefoneMotorista."</td>";
$loHtml .= "        </tr>"; 
$loHtml .= "    </table>";
$loHtml .= "    </td>";
$loHtml .= "</tr>";

foreach ($loDestinos as $rowDestino){
        $loHtml .= "<tr >";
        $loHtml .= "    <td style='border-top: thin solid;' colspan='2' >Destino: ".utf8_decode($rowDestino["nome"])."</td>";
        $loHtml .= "</tr>";
        $loHtml .= "<tr>";
        $loHtml .= "    <td style='border-top: thin solid;' colspan='2' >";
        $loHtml .= "    <table style='border:0px; font-family:'Arial'; font-size:14px;'>";
        $loHtml .= "        <tr>";
        $loHtml .= "            <td >Saida Efetiva: _____/_____/______ _____:_____</td>";
        $loHtml .= "            <td >Chegada Efetiva: _____/_____/______ _____:_____</td>";
        $loHtml .= "        </tr>";               
        $loHtml .= "        <tr>";
        $loHtml .= "            <td>Hod Inicial: ______________________________ km </td>";
        $loHtml .= "            <td>Hod Final:  ______________________________ km  </td>";
        $loHtml .= "        </tr>";
        $loHtml .= "        <tr>";
        $loHtml .= "            <td >Realizado Sim ____ N&atilde;o ____</td>";
        $loHtml .= "            <td ></td>";
        $loHtml .= "        </tr>"; 
        $loHtml .= "    </table>";
        $loHtml .= "    </td>";
        $loHtml .= "</tr>";
}
$loHtml .= "<tr>";
$loHtml .= "    <td style='border-top: thin solid;' colspan='2' ><strong>Passageiros</strong></td>";
$loHtml .= "</tr>";

foreach ($loPassageiros as $rowPassageiro){
    $loHtml .= "<tr>";
    $loHtml .= "    <td style='border-top: thin solid;' colspan='2' >";
    $loHtml .= "    <table style='border:0px; font-family:'Arial'; font-size:14px;'>";
    $loHtml .= "        <tr>";
    $loHtml .= "            <td width='30%' >".$rowPassageiro["nome"]."</td>";
    $loHtml .= "            <td width='20%' >Telefone: (".$rowPassageiro["telefone_dd"].") ".$rowPassageiro["telefone"]." </td>";
    $loHtml .= "            <td width='20%' >Compareceu no local ____ </td>";
    $loHtml .= "        </tr>";               
    $loHtml .= "    </table>";
    $loHtml .= "    </td>";
    $loHtml .= "</tr>";
}

$loHtml .= "</table>";

/*echo utf8_decode($loHtml);
exit;*/

//$mpdf=new mPDF('','A4');
$mpdf=new mPDF('en-GB-x','A4','','',5,5,5,10,6,3); 
$mpdf->WriteHTML(utf8_encode($loHtml));
//$mpdf->Output();
$mpdf->Output($loPastaDestino."/".$loNomeOutput, $loTipoOut);

if(isset($_REQUEST["email_autorizacao"]) && !empty($_REQUEST["email_autorizacao"])){
    $loDados = array( 'id_solicitacao' => $loId,'arquivo' => $loNomeOutput, 'pasta' => $loPastaDestino);
    $loSolicitacao->EnviarEmailAtorizacaoMotorista($loDados);
}

exit();

?>

