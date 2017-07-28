<?php
session_start();
include("../../conexao.php"); 
include("../../conexao-sqlsrv.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-relatorio.php");

//include("../../gerenciaCadastros/negocio-projetos.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");


$loRelatorio = new relatorioBO();
// Instanciamos a classe
$objPHPExcel = new PHPExcel();

$loComum = new comumBO();


error_reporting(E_ALL);

$objPHPExcel = PHPExcel_IOFactory::load('Rateio.xlsx');


$loLista =  $loRelatorio->ListaRelatorioRateio($_POST);
$arTabela = array(
                    'placa'
                    ,'div'
                    ,'rg'
                    ,'nome_requisitante'
                    ,'centro_custo'
                    ,'cnpj_faturamento'
                    ,'ultimo_destino'
                    ,'finalidade'
                    ,'data_saida'
                    ,'hora_saida'
                    ,'km_saida'
                    ,'data_retorno_prev'
                    ,'hora_retorno_prev'
                    ,'km_final'
                 );


if(count($loLista) > 0 ){

    $linha = 2;
    $loSomaDetodosKM = 0;
    
    foreach ($loLista as $row){

            
            $ValorTotalKmItem = 0;
            if($row["km_saida"] != "" && $row["km_final"] != ""){
                $ValorTotalKmItem = $row["km_final"] - $row["km_saida"];
            }

            $coluna = 0;
            
            foreach ($arTabela as $nomeColuna){

               $item = $row[$nomeColuna]; 
               if($nomeColuna == "cnpj_faturamento"){
                   if($row[$nomeColuna] != ""){
                        $item = $loRelatorio->mask($item,'##.###.###/####-##');
                   }
               }

               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, utf8_encode($item) );

               $coluna++;

           }
        

        $linha++;
    }

}



// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=RelatorioDeRateio.xls');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output'); 


//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', "RelatorioDeRateio.xlsx"));


?>