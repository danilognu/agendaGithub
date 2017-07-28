<?php
session_start();
include("../../conexao.php");  
include("../negocio-usuario.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");


// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nome' )
            ->setCellValue('B1', "Login " )
            ->setCellValue("C1", "E-mail" )
            ->setCellValue("D1", "Status" );

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

$loUsuario = new usuarioBO();

$filtroStatus = "";
if(isset($_REQUEST["filtroStatus"])){
    $filtroStatus = $_REQUEST["filtroStatus"];
}

$loDadosC = array( 
        'tipo' => 'consulta'
        , 'id' => '' 
        , 'filtroStatus' => $filtroStatus 
    );
$loLista =  $loUsuario->ListaUsuarios($loDadosC);

$linha = 2;
foreach ($loLista as $row){


    if($row["ativo"] == 1){
        $loAtivo = "Ativo";
    }else{ $loAtivo = "Desativado"; }

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_encode($row["nome"]));   
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $row["login"]);  
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $row["email"]);  
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $loAtivo);  
    $linha++;

}


// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Usuarios');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="usuarios.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

?>