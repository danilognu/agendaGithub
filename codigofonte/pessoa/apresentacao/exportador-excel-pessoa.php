<?php
session_start();
include("../../conexao.php"); 
include("../../comum/negocio-comum.php"); 
include("../negocio-pessoa.php");
include("../../comum/PHPExcel/Classes/PHPExcel.php");



/*for($i=65;$i<91;$i++) {
	echo chr($i);
}*/


$loPessoa = new pessoaBO();

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
/*$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);*/

$loIdMenu = null;
if(isset($_REQUEST["id-menu-exp"])){ $loIdMenu = $_REQUEST["id-menu-exp"]; }

$loComum = new comumBO();
$loExibirNomeMenu =  $loComum->ExibirNomeMenu($loIdMenu);



//Monta Cabeçalho
$loDadosC = array( 
        'id_menu' => $loIdMenu 
);

$loItensConsulta =  $loPessoa->ListaItensConsulta($loDadosC);

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
$loCnpj = null;
$loCpf = null;
$loTipoPessoa = null;
$loNomenclatura = "Relatorio";
$loTitulo = null;
$loStatus = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["cnpj"])){ $loCnpj = $_REQUEST["cnpj"]; }
if(isset($_REQUEST["cpf"])){ $loCpf = $_REQUEST["cpf"]; }
if(isset($_REQUEST["tipo-pessoa"])){ $loTipoPessoa = $_REQUEST["tipo-pessoa"]; }
if(isset($_REQUEST["nomenclatura"])){ $loNomenclatura  = $_REQUEST["nomenclatura"]; }
if(isset($_REQUEST["titulo"])){ $loTitulo = $_REQUEST["titulo"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }


$loPessoa = new pessoaBO();

$loDadosC = array( 
        'tipo_pessoa' => $loTipoPessoa
        , 'id' => $loId 
        , 'nome' => $loNome
        , 'cnpj' => $loCnpj 
        , 'cpf' => $loCpf 
        , 'status' => $loStatus
    );

$loLista =  $loPessoa->ListaPessoa($loDadosC);



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


// Podemos configurar diferentes larguras paras as colunas como padrão
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
/*$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);*/

/*$loUsuario = new usuarioBO();
$loDadosC = array( 'tipo' => 'consulta', 'id' => '' );
$loListaMenu =  $loUsuario->ListaUsuarios($loDadosC);

$linha = 2;
foreach ($loListaMenu as $row){*/


  /*  if($row["ativo"] == 1){
        $loAtivo = "Ativo";
    }else{ $loAtivo = "Desativado"; }*/

 //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "nome");   
 //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "login");  
 /*$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "email");  
 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "ativo");*/  
 //$linha++;

//}

// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Fulano");
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, " da Silva");
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "fulano@exemplo.com.br");

// Exemplo inserindo uma segunda linha, note a diferença no segundo parâmetro
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Beltrano");
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, " da Silva Sauro");
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "beltrando@exemplo.com.br");

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
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