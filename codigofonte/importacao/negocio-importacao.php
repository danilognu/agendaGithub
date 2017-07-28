<?php
include('persistencia-importacao.php');

class importacaoBO{


    public function BuscaDadosveiculos($loDados){

            $loImportacao = new importacaoBOA();

            $strPlacas = explode(",", trim($loDados));

            foreach ($strPlacas as $placaItens) {


                $loVeiculo = $loImportacao->BuscaDadosveiculos($placaItens); //Verifica se veiculo Existe no EuroIt
                $loRtVeiculo = $loImportacao->VerificaVeiculoCad($placaItens); //Verifica se veiculo ja esta cadastrado na Agenda Lets

                $loContVeicCad = $loRtVeiculo["veiculoExiste"];
                $loVeiculoExisteDesativado = $loRtVeiculo["veiculoExisteDesativado"];

                $loErros = false;
                $loStrMsg = "";
                if(count($loVeiculo) == 0){
                    $loStrMsg = "Placa não Localizada ".$placaItens.", remova a placa da listagem para prosseguir!";
                    $loErros = true;
                }
                if($loContVeicCad > 0){
                    $loStrMsg = "Placa ".$placaItens." ja cadastrado, por favor, remova a placa da listagem para prosseguir!";
                    $loErros = true;
                }
                if($placaItens == ""){
                    $loStrMsg = "Placa ".$placaItens." não localizada!";
                    $loErros = true;
                }
                if($loVeiculoExisteDesativado == 0){
                    $loStrMsg = "Placa ".$placaItens." ja cadastrado, porem esta desativada!";
                    $loErros = true;                   
                }

            }

            if($loErros){
                 $loRetorno = array("erro" => true, "messagem" => $loStrMsg );
            }else{

                foreach ($strPlacas as $placaItens) {

                    $loVeiculo = $loImportacao->BuscaDadosveiculos($placaItens);

                    $loErros = false;
                    //echo $loVeiculo["nomeModelo"];
                    //print_r($loVeiculo);

                     foreach ($loVeiculo as $rowVeic){

                          $loIDModelo = $loImportacao->VerificaModelo($rowVeic["nomeModelo"]);

                          //echo "Modelo = ". $loIDModelo;
                          //exit;

                          $loIDCombustivel = $loImportacao->VerificaCombustivel($rowVeic["nomeCombustivel"]);
                          $loIDCor = $loImportacao->VerificaCor($rowVeic["nomeCor"]);

                          //echo "Modelo = ".$loIDModelo."<br />";
                          //echo "Combustivel = ".$loIDCombustivel."<br />"; 
                          //echo "Cor = ".$loIDCor."<br />"; 

                         $loImportacao->ImportarDados($rowVeic,$loIDModelo,$loIDCombustivel,$loIDCor);

                         $loRetorno = array("erro" => false, "messagem" => "Veiculos adicionados com exito!" );
                      
                     }


                }

            }
           

            return $loRetorno;


    }


} 

?>