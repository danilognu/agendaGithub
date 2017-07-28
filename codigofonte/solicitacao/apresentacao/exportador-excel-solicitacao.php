<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-solicitacao.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");


$loSolicitacao = new solicitacaoBO();

// Instanciamos a classe
$objPHPExcel = new PHPExcel();


$loIdMenu = null;
if(isset($_REQUEST["id-menu-exp"])){ $loIdMenu = $_REQUEST["id-menu-exp"]; }

$loComum = new comumBO();
$loExibirNomeMenu =  $loComum->ExibirNomeMenu($loIdMenu);



//Monta Cabeçalho
$loDadosC = array( 
        'id_menu' => $loIdMenu 
);

$loItensConsulta =  $loSolicitacao->ListaItensConsulta($loDadosC);

$contLetra = 65;
$contNum = 1;
foreach ($loItensConsulta as $row){

    $Alfab = chr($contLetra);

    $objPHPExcel->getActiveSheet()->getStyle($Alfab."1")->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($Alfab)->setWidth(20);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($Alfab."1", utf8_encode($row["campo_visual"]) );

    $contLetra++;
    $contNum++;

}



//Monta Corpo
$loId = NULL;
$loSituacao = NULL;
$loIdMenu = NULL;
$loNomenclatura = NULL;
$loTitulo = NULL;
$loLimit = NULL;
$loNomenclatura = "Relatorio";
$loTitulo = null;
$loStatus = null;
$tela_solicitacao = 0;
$tela_atendimento = 0;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["situacao"])){ $loSituacao = $_REQUEST["situacao"]; }
if(isset($_REQUEST["id-menu-exp"])){ $loIdMenu = $_REQUEST["id-menu-exp"]; }
if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura = $_REQUEST["nomenclatura"]; }
if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }
if(isset($_REQUEST["not_limit"])){$loLimit = 0;}

//Telas
if(isset($_REQUEST["tela_solicitacao"])){ $tela_solicitacao = $_REQUEST["tela_solicitacao"]; }
if(isset($_REQUEST["tela_atendimento"])){ $tela_atendimento = $_REQUEST["tela_atendimento"]; }


$loSolicitacao = new solicitacaoBO();

$loDadosC = array( 
            'id' => $loId 
          , 'situacao' => $loSituacao
          , 'not_limit'  =>$loLimit
          , 'tela_solicitacao' => $tela_solicitacao
          , 'tela_atendimento' => $tela_atendimento
    );

$loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

if(count($loLista) > 0 ){

    $linha = 2;
    foreach ($loLista as $row){
        

/**/

            $coluna = 0;
            foreach ($loItensConsulta as $rowConsulta){

               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, utf8_encode($row[$rowConsulta["campo_bd"]]));

               $coluna++;

            }
        
/**/

        $linha++;
    }
}

//exit;


$objPHPExcel->getActiveSheet()->setTitle($loNomenclatura);

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