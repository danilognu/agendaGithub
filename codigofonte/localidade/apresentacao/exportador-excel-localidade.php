<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-localidade.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");


$loLocalidade = new localidadeBO();

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

$loItensConsulta =  $loLocalidade->ListaItensConsulta($loDadosC);

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
$loId = null;
$loNome = null;
$loStatus = null;
$loNomenclatura = "Relatorio";
$loTitulo = "Relatorio";

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }
if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura = $_REQUEST["nomenclatura"]; }
if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }



$loDadosC = array( 
            'id' => $loId 
        , 'nome' => $loNome
        , 'status' => $loStatus
    );

$loLista =  $loLocalidade->ListaLocalidade($loDadosC);


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