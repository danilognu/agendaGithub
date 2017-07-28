<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-projetos.php");
include("../../comum/Mpdf/mpdf.php");


$loId = null;
$loIdMenu = null;
$loNome = null;
$loCpf = null;
$loTipoPessoa = null;
$loStatus = null;

$loTitulo = "Relatorio";
$loNomenclatura = "exportador.pdf";

$loHtmlTabela = "";
$loHtmlConteudo = "";


if(isset($_REQUEST["chassi"])){ $loChassi = $_REQUEST["chassi"]; }
if(isset($_REQUEST["placa"])){ $loPlaca = $_REQUEST["placa"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }

if(isset($_REQUEST["id-menu-exp"])){ $loIdMenu = $_REQUEST["id-menu-exp"]; }
if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura = $_REQUEST["nomenclatura"]; }
if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }

//$loIdMenu = 8;
//$loTipoPessoa = "4,5";

$loComum = new comumBO();

$loPercDados = new projetosBO();

$loHtmlTabela .= "<h3 style='font-size:14px; font-family:Arial, Helvetica, sans-serif;' > ".$loTitulo." </h3>";
$loHtmlTabela .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:12px; font-family:Arial, Helvetica, sans-serif;'>";
$loHtmlTabela .= "<thead>";
$loHtmlTabela .= "<tr >";
$loHtmlTabela .= " <th style='border-collapse: collapse;border:1px solid #000000; font-weight:900;padding: 5px;'> Codigo </th>";
$loHtmlTabela .= " <th style='border-collapse: collapse;border:1px solid #000000; font-weight:900;padding: 5px;'> Nome   </th>";
$loHtmlTabela .= " <th style='border-collapse: collapse;border:1px solid #000000; font-weight:900;padding: 5px;'> Status </th>";
$loHtmlTabela .= "</tr>";
$loHtmlTabela .= "</thead>";
$loHtmlTabela .= "<tbody id='conteudo'>";



$loDadosC = array( 
          'id' => $loId 
        , 'nome' => $loNome
        , 'status' => $loStatus
    );

$loLista =  $loPercDados->Consultar($loDadosC);

if(count($loLista) > 0 ){



    foreach ($loLista as $row){
        
         $loHtmlConteudo .= "<tr class='odd gradeX' >";
         $loHtmlConteudo .= " <td style='border-collapse: collapse;border:1px solid #000000;padding: 3px' > ".$row["id_projeto"]." </td>";
         $loHtmlConteudo .= " <td style='border-collapse: collapse;border:1px solid #000000;padding: 3px' > ".$row["nome"]." </td>";
         
         if($row["ativo"] == 0){
             $loStatus = "Desativado";
         }else{
             $loStatus = "Ativo";
         }
         $loHtmlConteudo .= " <td style='border-collapse: collapse;border:1px solid #000000;padding: 3px' > ".$loStatus." </td>";
         $loHtmlConteudo .= "</tr>";

    }
    
}

$loHtmlTabela .= $loHtmlConteudo;

$loHtmlTabela .= "</tbody>";
$loHtmlTabela .= "</table>";

/*echo utf8_decode($loHtmlTabela);
exit;*/

$mpdf=new mPDF('','A4-L');
$mpdf->WriteHTML(utf8_encode($loHtmlTabela));
$mpdf->Output($loNomenclatura.".pdf", 'D');
exit();

?>

