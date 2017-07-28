<?php
class veiculoBOA{


    public function ListaVeiculo($mbDados){
        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loDdConsulta = "";
        /*if(isset($_SESSION["id_pessoa_matriz"]) && !empty($_SESSION["id_pessoa_matriz"]) ){
            $loDdConsulta .= " AND id_pessoa = ".$_SESSION["id_pessoa_matriz"];
        }*/

        $loNome = null;
        if(isset($mbDados["id"]) && !empty($mbDados["id"]) ){
            $loNome = $mbDados["id"];
            $loDdConsulta .=  " AND id_veiculo = ".$loNome; 

        }

        $loPlaca = null;
        if(isset($mbDados["placa"]) && !empty($mbDados["placa"]) ){
            $loPlaca = $mbDados["placa"];
            $loDdConsulta .=  " AND veiculo.placa like '%".$loPlaca."%'";

        }


        $loChassi = null;
        if(isset($mbDados["chassi"]) && !empty($mbDados["chassi"]) ){
            $loChassi = $mbDados["chassi"];
            $loDdConsulta .=  " AND veiculo.chassi like '%".$loChassi."%'";

        }


        $loNome = null;
        if(isset($mbDados["nome"]) && !empty($mbDados["nome"]) ){
            $loNome = $mbDados["nome"];
            $loDdConsulta .=  " AND nome like '%".$loNome."%'"; 

        }

        $loStatus = null;
        if(isset($mbDados["status"]) && strlen($mbDados["status"]) >= 1){
            $loStatus= $mbDados["status"];
            $loDdConsulta .=  " AND veiculo.ativo in(".$loStatus.")";
        }else{
            $loDdConsulta .=  " AND veiculo.ativo = 1";
        }

        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND veiculo.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }

        $loSql = "SELECT 
                    veiculo.id_veiculo
                    ,modelo.id_modelo
                    ,modelo.nome as nomeModelo
                    ,combustivel.id_combustivel
                    ,combustivel.nome as nomeCombustivel
                    ,cor.id_cor
                    ,cor.nome as nomeCor
                    ,veiculo.placa
                    ,veiculo.chassi
                    ,veiculo.renavam
                    ,veiculo.ano_veiculo
                    ,veiculo.ano_modelo
                    ,veiculo.num_motor
                    ,veiculo.id_pessoa_matriz
                    ,veiculo.id_pessoa_cad
                    ,veiculo.dt_cad
                    ,veiculo.dt_alt
                    ,veiculo.id_usuario_cad
                    ,veiculo.id_usuario_alt 
                    ,veiculo.ativo
                    ,nivel_combustivel.id_nivel_combustivel
                    ,nivel_combustivel.nome as nomeNivelCombustivel
                    ,veiculo.qtd_passageiro 
                    ,veiculo.portas 
                    ,veiculo.km 
                    ,veiculo.exclusivo 
                    ,DATE_FORMAT(veiculo.data_substituidoDev, '%d/%m/%Y') data_substituidoDev
                    ,veiculo.id_localidade_garagem
                    ,veiculo.situacao
                    ,veiculo.motivo_desativacao
                    ,DATE_FORMAT(veiculo.dt_alt_status, '%d/%m/%Y %H:%i') dt_alt_status
                    ,usuario.nome as nome_usuario_alt_status
                FROM veiculo 
                LEFT JOIN modelo ON modelo.id_modelo = veiculo.id_modelo
                LEFT JOIN combustivel ON combustivel.id_combustivel = veiculo.id_combustivel
                LEFT JOIN cor ON cor.id_cor = veiculo.id_cor
                LEFT JOIN nivel_combustivel ON nivel_combustivel.id_nivel_combustivel = veiculo.id_nivel_combustivel
                LEFT JOIN usuario ON usuario.id_usuario = veiculo.id_usuario_alt_status
                WHERE 1=1  ".$loDdConsulta." ORDER BY modelo.nome "  ;
        //echo $loSql;

        

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loVeiculos = null;
        foreach ($query as $row) {   


             $loVeiculos[] = array(
                    'id_veiculo'              => $row["id_veiculo"] 
                    ,'id_modelo'              => $row["id_modelo"]
                    ,'nomeModelo'             => $row["nomeModelo"]
                    ,'id_combustivel'         => $row["id_combustivel"]
                    ,'nomeCombustivel'        => $row["nomeCombustivel"]
                    ,'id_cor'                 => $row["id_cor"]
                    ,'nomeCor'                => $row["nomeCor"]
                    ,'placa'                  => $row["placa"]
                    ,'chassi'                 => $row["chassi"]
                    ,'renavam'                => $row["renavam"]
                    ,'ano_veiculo'            => $row["ano_veiculo"]
                    ,'ano_modelo'             => $row["ano_modelo"] 
                    ,'num_motor'              => $row["num_motor"]
                    ,'id_pessoa_matriz'       => $row["id_pessoa_matriz"]
                    ,'id_pessoa_cad'          => $row["id_pessoa_cad"]
                    ,'dt_cad'                 => $row["dt_cad"] 
                    ,'dt_alt'                 => $row["dt_alt"]
                    ,'id_usuario_cad'         => $row["id_usuario_cad"] 
                    ,'id_usuario_alt'         => $row["id_usuario_alt"]
                    ,'ativo'                  => $row["ativo"] 
                    ,'id_nivel_combustivel'   => $row["id_nivel_combustivel"]
                    ,'nomeNivelCombustivel'   => $row["nomeNivelCombustivel"]
                    ,'qtd_passageiro'         => $row["qtd_passageiro"] 
                    ,'portas'                 => $row["portas"] 
                    ,'km'                     => $row["km"]
                    ,'exclusivo'              => $row["exclusivo"]  
                    ,'data_substituidoDev'    => $row["data_substituidoDev"]
                    ,'id_localidade_garagem'  => $row["id_localidade_garagem"]
                    ,'situacao'               => $row["situacao"] 
                    ,'motivo_desativacao'     => $row["motivo_desativacao"] 
                    ,'dt_alt_status'          => $row["dt_alt_status"]
                    ,'nome_usuario_alt_status'=> $row["nome_usuario_alt_status"]
             );

             

        }

        return $loVeiculos; 
    }

    public function IncluirVeiculo($loDados){

         $loComumParametros = new comumBO();

        $loIdModelo             = $loDados["id_modelo"];
        $loIdCombustivel        = $loDados["id_combustivel"];
        $loCor                  = $loDados["id_cor"];
        $loPlaca                = $loDados["placa"];
        $loChassi               = $loDados["chassi"];
        $loRenavam              = $loDados["renavam"];
        $loAnoVeiculo           = $loDados["ano_veiculo"];
        $loAnoModelo            = $loDados["ano_modelo"];
        $loIdNivelCombustivel   = $loDados["id_nivel_combustivel"];
        $loQtdPassageiro        = $loDados["qtd_passageiro"];
        $loPortas               = $loDados["portas"]; 
        $loKm                   = $loDados["km"]; 
        $loExclusivo            = $loDados["exclusivo"]; 
        $loDtSubstituidoDev = $loComumParametros->AdicionaDate($loDados["data_substituidoDev"]);
        $loIdGaragem            = $loDados["id_localidade_garagem"];
        $loSituacao             = $loDados["situacao"];
        $loAtivo                = $loDados["status"];
        $loMotivoDesativacao    = $loDados["motivo_desativacao"];


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();




        $loSql = "INSERT INTO 
                    veiculo (
                    id_modelo
                    ,id_combustivel
                    ,id_cor
                    ,placa
                    ,chassi
                    ,renavam
                    ,ano_veiculo
                    ,ano_modelo
                    ,ativo
                    ,id_nivel_combustivel                    
                    ,id_usuario_cad
                    ,id_pessoa_matriz
                    ,qtd_passageiro 
                    ,portas 
                    ,km 
                    ,exclusivo 
                    ,data_substituidoDev
                    ,id_localidade_garagem
                    ,situacao
                    ,motivo_desativacao
                    ,dt_cad
                     ) VALUES (                        
                         ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
         
        $query= $pdo->prepare($loSql);
        
        $query->bindValue(1, $loIdModelo);
        $query->bindValue(2, $loIdCombustivel);
        $query->bindValue(3, $loCor);
        $query->bindValue(4, $loPlaca);
        $query->bindValue(5, $loChassi);
        $query->bindValue(6, $loRenavam);
        $query->bindValue(7, $loAnoVeiculo);
        $query->bindValue(8, $loAnoModelo);
        $query->bindValue(9, $loAtivo);
        $query->bindValue(10, $loIdNivelCombustivel);
        $query->bindValue(11, $_SESSION["id_usuario"]);
        $query->bindValue(12, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(13, $loQtdPassageiro);
        $query->bindValue(14, $loPortas); 
        $query->bindValue(15, $loKm); 
        $query->bindValue(16, $loExclusivo); 
        $query->bindValue(17, $loDtSubstituidoDev);
        $query->bindValue(18, $loIdGaragem);
        $query->bindValue(19, $loSituacao);
        $query->bindValue(20, $loMotivoDesativacao);
        

        $query->execute(); 

        return true;


    }

    public function AlterarVeiculo($loDados){

        $loComumParametros = new comumBO();

        $loIdModelo             = $loDados["id_modelo"];
        $loIdCombustivel        = $loDados["id_combustivel"];
        $loCor                  = $loDados["id_cor"];
        $loPlaca                = $loDados["placa"];
        $loChassi               = $loDados["chassi"];
        $loRenavam              = $loDados["renavam"];
        $loAnoVeiculo           = $loDados["ano_veiculo"];
        $loAnoModelo            = $loDados["ano_modelo"];
        $loIdNivelCombustivel   = $loDados["id_nivel_combustivel"];
        $loQtdPassageiro        = $loDados["qtd_passageiro"];
        $loPortas               = $loDados["portas"]; 
        $loKm                   = $loDados["km"]; 
        $loExclusivo            = $loDados["exclusivo"]; 
        $loDtSubstituidoDev     = $loComumParametros->AdicionaDate($loDados["data_substituidoDev"]);
        $loIdGaragem            = $loDados["id_localidade_garagem"];
        $loAtivo                = $loDados["status"];   
        $loId                   = $loDados["id"];
        $loSituacao             = $loDados["situacao"];
        $loMotivoDesativacao    = $loDados["motivo_desativacao"];

        if($loSituacao == 0){
            $loLOGDesativacao = ",id_usuario_alt_status = ".$_SESSION["id_usuario"].", dt_alt_status = NOW()";
        }else{
            $loLOGDesativacao = ",id_usuario_alt_status = NULL, dt_alt_status = NULL ";
        }


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "UPDATE veiculo SET
                    id_modelo = ?
                    ,id_combustivel = ?
                    ,id_cor = ?
                    ,placa = ?
                    ,chassi = ?
                    ,renavam = ?
                    ,ano_veiculo = ?
                    ,ano_modelo = ?
                    ,ativo = ?
                    ,id_nivel_combustivel = ?                    
                    ,id_usuario_alt = ?
                    ,id_pessoa_matriz = ?
                    ,dt_alt = NOW() 
                    ,qtd_passageiro = ? 
                    ,portas  = ?
                    ,km  = ?
                    ,exclusivo = ? 
                    ,data_substituidoDev  = ? 
                    ,id_localidade_garagem = ?
                    ,situacao = ?
                    ,motivo_desativacao = ?
                    ".$loLOGDesativacao."
                WHERE id_veiculo = ? ";

        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loIdModelo);
        $query->bindValue(2, $loIdCombustivel);
        $query->bindValue(3, $loCor);
        $query->bindValue(4, $loPlaca);
        $query->bindValue(5, $loChassi);
        $query->bindValue(6, $loRenavam);
        $query->bindValue(7, $loAnoVeiculo);
        $query->bindValue(8, $loAnoModelo);
        $query->bindValue(9, $loAtivo);
        $query->bindValue(10, $loIdNivelCombustivel);
        $query->bindValue(11, $_SESSION["id_usuario"]);
        $query->bindValue(12, $_SESSION["id_pessoa_matriz"]);
        $query->bindValue(13, $loQtdPassageiro);
        $query->bindValue(14, $loPortas); 
        $query->bindValue(15, $loKm); 
        $query->bindValue(16, $loExclusivo); 
        $query->bindValue(17, $loDtSubstituidoDev);
        $query->bindValue(18, $loIdGaragem); 
        $query->bindValue(19, $loSituacao); 
        $query->bindValue(20, $loMotivoDesativacao); 
        $query->bindValue(21, $loId);
        $query->execute(); 
     
        return true;         

    }

    public function ListaNivelCombustivel($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loDdConsulta = "";
        $loIDNivel = null;
        if(isset($mbDados["id"]) && !empty($mbDados["id"]) ){
            $loIDNivel = $mbDados["nome"];
            $loDdConsulta .=  " AND id_nivel_combustivel = ".$loIDNivel; 

        }

        $loSql = "SELECT 
                    id_nivel_combustivel
                    ,nome 
                FROM 
                    nivel_combustivel 
                WHERE 1=1  ".$loDdConsulta." ORDER BY nome "  ;

        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loNivel = null;
        foreach ($query as $row) {   

             $loNiveis[] = array(
                    'id_nivel_combustivel'       => $row["id_nivel_combustivel"]
                    ,'nome'                      => $row["nome"]

             );

             

        }

        return $loNiveis; 
    }


 
   public function ListaItensConsulta($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdMenu = $loDados["id_menu"];

        //Busca Itens para consulta
        $loSqlC = "SELECT id_grid_consulta FROM usuario_consulta WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$loIdMenu;    
        $query = $pdo->prepare($loSqlC);
        $query->execute();    

        foreach ($query as $row) { $id_grid_consulta = $row["id_grid_consulta"]; }  


        $loSql = "SELECT id_grid_consulta,campo_bd,campo_visual FROM grid_consulta WHERE id_grid_consulta IN(".$id_grid_consulta.") AND id_menu = ".$loIdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loConsulta = null;
        foreach ($query as $row) {
               
               $loConsulta[] = array(
                    'id_grid_consulta'      => $row["id_grid_consulta"]
                    ,'campo_bd'             => $row["campo_bd"]
                    ,'campo_visual'         => $row["campo_visual"]
                );
               
        
        }

        return $loConsulta;  


    }

    public function GridConsultaItens($IdMenu){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        //Verifica itens selecionados
        $loSqlBsCheck = "SELECT id_grid_consulta FROM usuario_consulta WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$IdMenu;
        $queryBsCheck = $pdo->prepare($loSqlBsCheck);
        $queryBsCheck->execute(); 
        foreach ($queryBsCheck as $row) {
               $ItensSelecionados = $row["id_grid_consulta"];         
        } 
        
        //Lista todos os itens da tabela cliente depara
        $loSql = "SELECT id_grid_consulta,campo_bd,campo_visual FROM grid_consulta WHERE id_menu = ".$IdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();
        $loGrid = null;
        foreach ($query as $row) {


            $checked = "";
            $loItens = explode(",", $ItensSelecionados);   
            $contaItem = count($loItens);
            foreach ($loItens as $item){

                if($item == $row["id_grid_consulta"]){ $checked = "checked"; }

            }


             $loGrid[] = array(
                    'campo_visual'       => $row["campo_visual"]
                    ,'campo_bd'          => $row["campo_bd"]
                    ,'id_grid_consulta'  => $row["id_grid_consulta"]
                    ,'checked'           => $checked
                );

        }

        return $loGrid;

    }

    public function AlteraConsultaCliente($loDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loIdMenu = $loDados["id_menu"];
        $loStrConsulta = substr($loDados["strConsulta"],0,-1);

        $loSql = "UPDATE usuario_consulta set id_grid_consulta = '".$loStrConsulta."' WHERE id_usuario = ".$_SESSION["id_usuario"]." AND id_menu = ".$loIdMenu;
        $query= $pdo->prepare($loSql);
        $query->execute();



    }   

    public function DesativarVeiculo($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if(count($loDados) > 0 ){
            foreach ($loDados as $item){
            
                $loSql = "UPDATE veiculo SET ativo = 0 WHERE id_veiculo = ".$item;
                $query= $pdo->prepare($loSql);
                $query->execute();
            }
        }

         return true;

     } 

    public function ListaGaragem($loDados){
        
        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        $loDdConsulta = "";
        $loId = null;
        if(isset($mbDados["id"]) && !empty($mbDados["id"]) ){
            $loId = $mbDados["id_localidade"];
            $loDdConsulta .=  " AND id_localidade = ".$loIDNivel; 

        }        

        $loSql = "SELECT id_localidade,nome FROM localidade WHERE garagem = 'S' AND ativo  = 1 ".$loDdConsulta." ORDER BY nome";
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loConsulta = null;
        foreach ($query as $row) {
               $loConsulta[] = array(
                    'id'     => $row["id_localidade"]
                    ,'nome'  => $row["nome"]
                );
        }
        return $loConsulta;          
    }

}

?>