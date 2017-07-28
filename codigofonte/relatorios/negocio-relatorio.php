<?php
include('persistencia-relatorio.php');

class relatorioBO{

    public function ListaRelatorioRateio($loDados){

         $loComumParametros = new comumBO();
         $loDdConsulta = null;

        if( (isset($loDados["data-saida"]) && !empty($loDados["data-saida"])) && (isset($loDados["data-retorno"]) && !empty($loDados["data-retorno"]))  ){
             
             $loDtSaida = $loComumParametros->AdicionaComBarraDataHora($loDados["data-saida"]);
             $loDtRetorno = $loComumParametros->AdicionaComBarraDataHora($loDados["data-retorno"]);

             $loDdConsulta .=  " AND solicitacao.dt_saida >= '".$loDtSaida." 00:00' AND solicitacao.dt_saida <= '".$loDtRetorno." 23:59'";
             $loDdConsulta .=  " AND solicitacao.dt_retorno_prev >= '".$loDtSaida." 00:00' AND solicitacao.dt_retorno_prev <= '".$loDtRetorno." 23:59'";
        }
        if(isset($loDados["select-veiculo"]) && !empty($loDados["select-veiculo"]) ){
             $loDdConsulta .=  " AND veiculo.id_veiculo = ".$loDados["select-veiculo"];
        }         

        $loRelatorio = new relatorioBOA();
        $loLista = $loRelatorio->ListaRelatorioRateio($loDdConsulta);

        return $loLista;

    }

    public function ListaAtencimentosPorSetor($loDados){

         $loComumParametros = new comumBO();
         $loDdConsulta = null;

        if( (isset($loDados["data-saida"]) && !empty($loDados["data-saida"])) && (isset($loDados["data-retorno"]) && !empty($loDados["data-retorno"]))  ){
             
             $loDtSaida = $loComumParametros->AdicionaComBarraDataHora($loDados["data-saida"]);
             $loDtRetorno = $loComumParametros->AdicionaComBarraDataHora($loDados["data-retorno"]);

             $loDdConsulta .=  " AND solicitacao.dt_saida >= '".$loDtSaida." 00:00' AND solicitacao.dt_saida <= '".$loDtRetorno." 23:59'";
             $loDdConsulta .=  " AND solicitacao.dt_retorno_prev >= '".$loDtSaida." 00:00' AND solicitacao.dt_retorno_prev <= '".$loDtRetorno." 23:59'";
        }
        if(isset($loDados["select-veiculo"]) && !empty($loDados["select-veiculo"]) ){
             $loDdConsulta .=  " AND veiculo.id_veiculo = ".$loDados["select-veiculo"];
        }
        if( (isset($loDados["data-inic-prev"]) && !empty($loDados["data-inic-prev"])) && (isset($loDados["data-termino-prev"]) && !empty($loDados["data-termino-prev"]))  ){
        
             $loDtInicPrev = $loComumParametros->AdicionaComBarraDataHora($loDados["data-inic-prev"]);
             $loDtTerminoPrev = $loComumParametros->AdicionaComBarraDataHora($loDados["data-termino-prev"]);

             $loDdConsulta .=  " AND solicitacao.dt_partida >= '".$loDtInicPrev." 00:00' AND solicitacao.dt_partida <= '".$loDtTerminoPrev." 23:59'";
             $loDdConsulta .=  " AND solicitacao.dt_chegada >= '".$loDtInicPrev." 00:00' AND solicitacao.dt_chegada <= '".$loDtTerminoPrev." 23:59'";
        }
        if(isset($loDados["select-motorista"]) && !empty($loDados["select-motorista"]) ){
             $loDdConsulta .=  " AND solicitacao.id_pessoa_motorista = ".$loDados["select-motorista"];
        }
        if(isset($loDados["select-requisitante"]) && !empty($loDados["select-requisitante"]) ){
            $loDdConsulta .=  " AND solicitacao.id_pessoa_requisitante = ".$loDados["select-requisitante"];
        }
        if(isset($loDados["setor"]) && !empty($loDados["setor"]) ){
            $loDdConsulta .=  " AND solicitacao.id_setor = ".$loDados["setor"];
        }     
        if(isset($loDados["select-origem"]) && !empty($loDados["select-origem"]) ){
            $loDdConsulta .=  " AND solicitacao.id_localidade_origem = ".$loDados["select-origem"];
        }        
        if(isset($loDados["select-destino"]) && !empty($loDados["select-destino"]) ){
        }   
        if(isset($loDados["planejado"]) && !empty($loDados["planejado"]) && ($loDados["planejado"] == "0" || $loDados["planejado"] == "1")  ){
            $loDdConsulta .=  " AND solicitacao.ind_planejado = ".$loDados["planejado"];
        }  

        $loRelatorio = new relatorioBOA();
        $loLista = $loRelatorio->ListaAtencimentosPorSetor($loDdConsulta);

        return $loLista;
    }

    public function ExportadorExcelAtendimentosPorSetor($mbDados){

            // Instanciamos a classe
            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getActiveSheet()->getStyle("A"."1")->getFont()->setBold(true);
            //$objPHPExcel->getActiveSheet()->getStyle("B"."1")->getFont()->setBold(true);
            //$objPHPExcel->getActiveSheet()->getStyle("C"."1")->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(20);
            //$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
            //$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);


            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "Codigo" );
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", "Nome" );
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", "Status" );


            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,1, "teste" );

            /*$loDadosC = array( 
                    'nome' => $loNome
                );
            

            $loLista =  $loProjetos->ListaSetor($loDadosC);

            $arTabela = array("id_setor", "nome", "ativo");

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
            }*/

            //exit.
            // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
            $objPHPExcel->getActiveSheet()->setTitle("teste");

            // Cabeçalho do arquivo para ele baixar
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=Teste.xls');
            header('Cache-Control: max-age=0');
            // Se for o IE9, isso talvez seja necessário
            header('Cache-Control: max-age=1');

            // Acessamos o 'Writer' para poder salvar o arquivo
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
            $objWriter->save('php://output'); 

            exit;

    }  


    public function TempoAtendimento($mbDados){

        $loDdConsulta = null;
        $loRelatorio = new relatorioBOA();
        $loLista = $loRelatorio->TempoAtendimento($loDdConsulta);

        return $loLista;

    }

    /*public function BuscaValorLocacaoSistemaLets($mbDados){

        $loPlacas = "";
        foreach ($mbDados as $row){

            $loPlacas .= "'".$row["placa"]."',";
        }
        $size = strlen($loPlacas);
        $loPlacas = substr($loPlacas,0, $size-1);

        $loRelatorio = new relatorioBOA();
        $loLista = $loRelatorio->BuscaValorLocacaoSistemaLets($loPlacas);

    }*/

    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                $maskared .= $mask[$i];
            }
        }
        return $maskared;
     }


} 

?>