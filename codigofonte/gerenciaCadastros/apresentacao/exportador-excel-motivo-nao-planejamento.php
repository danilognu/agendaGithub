<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-motivo-nao-planejamento.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");


$loProjetos = new motivoNaoPlanejamentoBO();

// Instanciamos a classe
$objPHPExcel = new PHPExcel();


$loIdMenu = null;
if(isset($_REQUEST["id-menu-exp"])){ $loIdMenu = $_REQUEST["id-menu-exp"]; }


$loComum = new comumBO();


$objPHPExcel->getActiveSheet()->getStyle("A"."1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B"."1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C"."1")->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "Codigo" );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", "Nome" );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", "Status" );



//Monta Corpo
$loId = null;
$loNome = null;
$loStatus = null;
$loNomenclatura = "Relatorio";
$loTitulo = "Relatorio";

if(isset($_REQUEST["nome"])){$loNome = $_REQUEST["nome"]; }

if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura = $_REQUEST["nomenclatura"]; }
//if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }

$arTabela = array("id", "nome", "ativo");

$loDadosC = array( 
         'nome' => $loNome
    );
   

$loLista =  $loProjetos->Consultar($loDadosC);


if(count($loLista) > 0 ){

    $linha = 2;
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