<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-solicitacao.php");
include("../../comum/Mpdf/mpdf.php");


$loId = null;
$loIdMenu = null;
$loSituacao = null;
$loStatus = null;
$tela_solicitacao = 0;
$tela_atendimento = 0;

$loTitulo = "Relatorio";
$loNomenclatura = "exportador.pdf";

$loHtmlTabela = "";
$loHtmlConteudo = "";

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }

if(isset($_REQUEST["id-menu-exp"])){ $loIdMenu = $_REQUEST["id-menu-exp"]; }
if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura = $_REQUEST["nomenclatura"]; }
if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }

//Telas
if(isset($_REQUEST["tela_solicitacao"])){ $tela_solicitacao = $_REQUEST["tela_solicitacao"]; }
if(isset($_REQUEST["tela_atendimento"])){ $tela_atendimento = $_REQUEST["tela_atendimento"]; }

if(isset($_REQUEST["not_limit"])){$loLimit = 0;}

$loComum = new comumBO();

$loSolicitacao = new solicitacaoBO();

 $loHtmlTabela .= "<h3 style='font-size:14px; font-family:Arial, Helvetica, sans-serif;' > ".$loTitulo." </h3>";
 $loHtmlTabela .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-size:12px; font-family:Arial, Helvetica, sans-serif;'>";
 $loHtmlTabela .= "<thead>";
 $loHtmlTabela .= "<tr >";

            //Cabeçalho da consulta dinamica 
            $loDadosC = array( 
                        'id_menu' => $loIdMenu//$IdMenu 
                );

            $loItensConsulta =  $loSolicitacao->ListaItensConsulta($loDadosC);

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
                            
                            $loHtmlTabela .= " <th style='border-collapse: collapse;border:1px solid #000000; font-weight:900;padding: 5px;'> 
                                             ".$item." </th>"; 
                            $contador++; 
                    }
                }
                }


$loHtmlTabela .= "</tr>";
$loHtmlTabela .= "</thead>";
$loHtmlTabela .= "<tbody id='conteudo'>";



$loDadosC = array( 
            'id' => $loId 
          , 'situacao' => $loSituacao
          , 'not_limit'  =>$loLimit
          , 'tela_solicitacao' => $tela_solicitacao
          , 'tela_atendimento' => $tela_atendimento
    );


$loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    $loHtmlConteudo .= "<tr class='odd gradeX' >";

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => $loIdMenu 
                );

            $loItensConsulta =  $loSolicitacao->ListaItensConsulta($loDadosGrid);

                foreach ($loItensConsulta as $rowItem){
                    
                    $loItens = explode(",", $rowItem["campo_bd"]);   

                    foreach ($loItens as $item){

                        if($item == "ativo"){//verifica se é status

                            if($row["ativo"] == 1){
                                $loHtmlConteudo .= " <td style='border-collapse: collapse;border:1px solid #000000;padding: 3px' >  Ativo   </td>";
                            }else{
                                $loHtmlConteudo .= " <td style='border-collapse: collapse;border:1px solid #000000;padding: 3px' >  Desativado   </td>";
                            }

                        }else{// demais itens

                            $loHtmlConteudo .= " <td style='border-collapse: collapse;border:1px solid #000000;padding: 3px' > ".$row[$item]." </td>";
                            
                        }
                    }
                }
                //Monta grid dinamica End

    $loHtmlConteudo .= "</tr>";

    }
    
}

$loHtmlTabela .= $loHtmlConteudo;

///echo  $loHtmlConteudo;
//exit;

$loHtmlTabela .= "</tbody>";
$loHtmlTabela .= "</table>";


/*echo utf8_decode($loHtmlTabela);
exit;*/

$mpdf=new mPDF('','A4-L');
//$mpdf->charset_in='iso-8859-1'; 
//$mpdf=new mPDF();
$mpdf->WriteHTML(utf8_encode($loHtmlTabela));
//$mpdf->Output();
$mpdf->Output($loNomenclatura.".pdf", 'D');
exit();

?>

