<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-relatorio.php");

//include("../../gerenciaCadastros/negocio-projetos.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");


$loRelatorio = new relatorioBO();
// Instanciamos a classe
$objPHPExcel = new PHPExcel();

$loComum = new comumBO();

//Aqui é adicionado a logo do cliente
/*$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objDrawing->setName('Logo Interesses Pessoais');
$objDrawing->setDescription('Logo Interesses Pessoais');
$objDrawing->setPath('../../comum/apresentacao/imagens/salute_logo_15.jpg');
$objDrawing->setHeight(60);
$objDrawing->setWidth(70);
$objDrawing->setCoordinates('B1');*/

//Negrido
$objPHPExcel->getActiveSheet()->getStyle("A"."1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A"."2")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A"."3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B"."1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C"."1")->getFont()->setBold(true);
//Mescla Linhas
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
//Lagura
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(40);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "RELATORIO SSL" );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A2", "Periodo:" );

$objPHPExcel->getActiveSheet()->getStyle("A"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4", "PLACA" );

$objPHPExcel->getActiveSheet()->getStyle("B"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B4", "SETOR" );

$objPHPExcel->getActiveSheet()->getStyle("C"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C4", "RG" );

$objPHPExcel->getActiveSheet()->getStyle("D"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D4", "NOME" );

$objPHPExcel->getActiveSheet()->getStyle("E"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E4", "C/C" );

$objPHPExcel->getActiveSheet()->getStyle("F"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("F4", "CNPJ" );

$objPHPExcel->getActiveSheet()->getStyle("G"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("G4", "DESTINO" );

$objPHPExcel->getActiveSheet()->getStyle("H"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("H4", "FINALIDADE" );

$objPHPExcel->getActiveSheet()->getStyle("I"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("I4", "DATA SAIDA");

$objPHPExcel->getActiveSheet()->getStyle("J"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("J4", "HORA SAIDA");

$objPHPExcel->getActiveSheet()->getStyle("K"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K4", "KM INICIO");

$objPHPExcel->getActiveSheet()->getStyle("L"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K4", "DATA RETORNO");

$objPHPExcel->getActiveSheet()->getStyle("M"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K4", "HORA RETORNO");

$objPHPExcel->getActiveSheet()->getStyle("N"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K4", "KM FINAL");

$objPHPExcel->getActiveSheet()->getStyle("O"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K4", "TOTAL");

$objPHPExcel->getActiveSheet()->getStyle("P"."4")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("K4", "RATEIO");



//Monta Corpo
$loId = null;
$loNome = null;
$loStatus = null;
$loNomenclatura = "AtendimentosPorSetor";
$loTitulo = "AtendimentosPorSetor";

if(isset($_REQUEST["nome"])){$loNome = $_REQUEST["nome"]; }

if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura = $_REQUEST["nomenclatura"]; }
if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }

$arTabela = array(
                    'placa'
                    ,'setor'
                    ,'registro'
                    ,'nome_requisitante'
                    ,'centro_custo'
                    ,'cnpj_faturamento'
                    ,'finalidade'
                    ,'data_saida'
                    ,'hora_saida'
                    ,'data_retorno_prev'
                    ,'hora_retorno_prev'
                    ,'km_partida'
                    );


$loLista =  $loRelatorio->ListaRelatorioRateio($_POST);


if(count($loLista) > 0 ){

    $linha = 5;
    foreach ($loLista as $row){

        
            $coluna = 0;
             foreach ($arTabela as $nomeColuna){

               if($nomeColuna == "ativo"){
                   if($row["ativo"] == 0){ $item = "Desativado"; }else{ $item = "Ativo"; }
               }else{
                   $item = $row[$nomeColuna];
               }

               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, utf8_encode($item) );

               $coluna++;

            }
        

        $linha++;
    }
}

//exit.
// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle($loTitulo);

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$loNomenclatura.'.xls');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

?>