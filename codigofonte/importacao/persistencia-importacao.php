<?php

class importacaoBOA{


    public function BuscaDadosveiculos($mbDados){


        $loConexao = new ConexaoSqlSrv();
        $pdo = $loConexao->IniciaConexaoSqlSrv();

        $loSql = "SELECT 
                    T009.A009_cd_veiculo as codVeiculoEuroit
                    ,T009.A009_placa_veiculo as Placa
                    ,T013.A013_nome_modelo as nomeModelo
                    ,T017.A017_nome_combustivel as nomeCombustivel
                    ,T035.A035_dsc_cor as nomeCor
                    ,T009.A009_chassi as Chassi
                    ,T009.A009_renavan as Renavan
                    ,T009.A009_num_motor as NumeroMotor
                    ,T009.A009_ano_modelo as AnoModelo
                    ,T009.A009_ano_veiculo as AnoVeiculo
                    ,T009.A009_quilomet_atual as km
                FROM T009_VEICULO T009
                INNER JOIN T013_MODELO T013 ON T013.A013_cd_modelo = T009.A013_cd_modelo
                INNER JOIN T017_COMBUSTIVEL T017 ON T017.A017_cd_combustivel = T009.A017_cd_combustivel
                INNER JOIN T035_COR T035 ON T035.A035_cd_cor = T009.A035_cd_cor
                WHERE T009.A009_placa_veiculo = '".trim($mbDados)."' ";

        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loVeiculo = null;
        foreach ($query as $row) {
               
               
               $loVeiculo[] = array(
                     'codVeiculoEuroit' => $row["codVeiculoEuroit"] 
                     ,'Placa'           => $row["Placa"] 
                     ,'nomeModelo'      => $row["nomeModelo"] 
                     ,'nomeCombustivel' => $row["nomeCombustivel"] 
                     ,'nomeCor'         => $row["nomeCor"] 
                     ,'Chassi'          => $row["Chassi"] 
                     ,'Renavan'         => $row["Renavan"] 
                     ,'NumeroMotor'     => $row["NumeroMotor"] 
                     ,'AnoModelo'       => $row["AnoModelo"] 
                     ,'AnoVeiculo'      => $row["AnoVeiculo"] 
                     ,'km'              => $row["km"] 
                );
               
        
        }

        return $loVeiculo;        

    }

    public function ImportarDados($mbDados,$loIDModelo,$loIDCombustivel,$loIDCor){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
        
        $Placa  = $mbDados["Placa"];
        $Chassi = $mbDados["Chassi"];
        $Renavan = $mbDados["Renavan"];
        $AnoModelo = $mbDados["AnoModelo"];
        $AnoVeiculo = $mbDados["AnoVeiculo"];
        $NumeroMotor = $mbDados["NumeroMotor"];
        $km = $mbDados["km"];
        $CodVeiculoEuroit = $mbDados["codVeiculoEuroit"];


        $loSql =  " INSERT INTO veiculo (
                        id_modelo
                        ,id_combustivel
                        ,id_cor
                        ,placa
                        ,chassi
                        ,renavam                        
                        ,ano_veiculo
                        ,ano_modelo
                        ,num_motor
                        ,km
                        ,cd_euroit
                        ,id_pessoa_origem
                        ,id_pessoa_cad
                        ,id_usuario_cad
                        ,id_pessoa_matriz
                        ,ativo
                        ,dt_cad
                        ,qtd_passageiro
                )
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,4)";
        $query= $pdo->prepare($loSql);

        //echo $loSql;

        $query->bindValue(1, $loIDModelo); 
        $query->bindValue(2, $loIDCombustivel); 
        $query->bindValue(3, $loIDCor); 
        $query->bindValue(4, $Placa);
        $query->bindValue(5, $Chassi); 
        $query->bindValue(6, $Renavan); 
        $query->bindValue(7, $AnoVeiculo); 
        $query->bindValue(8, $AnoModelo); 
        $query->bindValue(9, $NumeroMotor); 
        $query->bindValue(10, $km); 
        $query->bindValue(11, $CodVeiculoEuroit); 
        $query->bindValue(12, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(13, $_SESSION["id_pessoa_matriz"]); 
        $query->bindValue(14, $_SESSION["id_usuario"]); 
        $query->bindValue(15, $_SESSION["id_pessoa_matriz"]); 
        $query->bindValue(16, "1"); 
        $query->bindValue(17, "NOW()"); 
        $query->execute(); 

        return true;

    }

    public function VerificaModelo($mbModelo){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_modelo FROM modelo WHERE nome like '%".$mbModelo."%'";
        //echo $loSql;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $Not_Item = 1;
        foreach ($query as $row) {

            if(strlen($row["id_modelo"]) > 0){ 
                $Not_Item = 0;  
                $loIDModelo = $row["id_modelo"];
            }

        }

        if($Not_Item==1){
           $loIDModelo = $this->IncluirModelo($mbModelo);
        }

        return  $loIDModelo;
    }


    public function IncluirModelo($mbModelo){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
        
        $loSql = "INSERT INTO modelo 
                    (
                        nome
                        ,ativo
                        ,id_usuario_cad
                        ,id_pessoa
                        ,dt_cad
                    ) VALUES (?,?,?,?,NOW())";
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $mbModelo); 
        $query->bindValue(2, 1);
        $query->bindValue(3, $_SESSION["id_usuario"]); 
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]); 
        $query->execute(); 


        $loSqlm = "SELECT MAX(id_modelo) id_modelo FROM modelo "; 
        $querym= $pdo->prepare($loSqlm);
        $querym->execute();   

        foreach ($querym as $row) {
            $id_modelo = $row["id_modelo"];
        }

        return $id_modelo;
    
    }


    public function VerificaCombustivel($mbCombustivel){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_combustivel FROM combustivel WHERE nome like '%".$mbCombustivel."%'";

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $Not_Item = 1;
        foreach ($query as $row) {

            if(strlen($row["id_combustivel"]) > 0){ 
                $Not_Item = 0; 
                $loIDCombustivel = $row["id_combustivel"];  
            }

        }

       /* if($Not_Item==1){
           $loIDCombustivel = $this->IncluirCombustivel($mbCombustivel);
        }*/

        return  $loIDCombustivel;
    }


    public function IncluirCombustivel($mbCombustivel){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
        
        $loSql = "INSERT INTO combustivel 
                    (
                        nome
                        ,ativo
                        ,id_usuario_cad
                        ,id_pessoa
                        ,dt_cad
                    ) VALUES (?,?,?,?,NOW())";
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $mbCombustivel); 
        $query->bindValue(2, 1);
        $query->bindValue(3, $_SESSION["id_usuario"]); 
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]); 
        $query->execute(); 


        $loSqlm = "SELECT MAX(id_combustivel) id_combustivel FROM combustivel "; 
        $querym= $pdo->prepare($loSqlm);
        $querym->execute();   

        foreach ($querym as $row) {
            $id_combustivel = $row["id_combustivel"];
        }

        return $id_combustivel;
    
    }



    public function VerificaCor($mbCor){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "SELECT id_cor FROM cor WHERE nome like '%".$mbCor."%'";

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $Not_Item = 1;
        foreach ($query as $row) {

            if(strlen($row["id_cor"]) > 0){ 
                $Not_Item = 0; 
                $loIDCor= $row["id_cor"];  
            }

        }

       /* if($Not_Item==1){
           $loIDCor = $this->IncluirCor($mbCor);
        }*/

        return  $loIDCor;
    }


    public function IncluirCor($mbCor){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
        
        $loSql = "INSERT INTO cor 
                    (
                        nome
                        ,ativo
                        ,id_usuario_cad
                        ,id_pessoa
                        ,dt_cad
                    ) VALUES (?,?,?,?,NOW())";
        $query= $pdo->prepare($loSql);

        $query->bindValue(1, $mbCor); 
        $query->bindValue(2, 1);
        $query->bindValue(3, $_SESSION["id_usuario"]); 
        $query->bindValue(4, $_SESSION["id_pessoa_matriz"]); 
        $query->execute(); 


        $loSqlm = "SELECT MAX(id_cor) id_cor FROM cor "; 
        $querym= $pdo->prepare($loSqlm);
        $querym->execute();   

        foreach ($querym as $row) {
            $id_cor = $row["id_cor"];
        }

        return $id_cor;
    
    }

    public function VerificaVeiculoCad($mbPlaca){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();
    
        $loSql = "SELECT COUNT(*) contaVeiculo FROM veiculo WHERE placa = '".$mbPlaca."'";
        $query= $pdo->prepare($loSql);
        $query->execute();   

        $contagem = 0;
        $loVeiculoDesativado = 10;
        foreach ($query as $row) {
            
            $contagem = $row["contaVeiculo"];
            
            if($contagem > 0){
                
                $loSqlAtivo = "SELECT ativo FROM veiculo WHERE placa = '".$mbPlaca."'";
                $queryAtivo= $pdo->prepare($loSqlAtivo);
                $queryAtivo->execute(); 
                foreach ($queryAtivo as $rowAtivo) {
                    $loVeiculoDesativado = $rowAtivo["ativo"];
                }

            }
        }

        $loRetorno = array("veiculoExiste" => $contagem, "veiculoExisteDesativado" => $loVeiculoDesativado );

        return $loRetorno;

    }



}
?>