<?php
include('persistencia-pessoa.php');

class pessoaBO{

    public function ListaPessoa($loDados){


        $loDdConsulta = null;
        
        if(isset($loDados["tipo_pessoa"])){
            $loTipoPessoa = $loDados["tipo_pessoa"];
            $loDdConsulta =  " AND tipo_pessoa.id_tipo_pessoa IN(".$loTipoPessoa.")"; 
        }

        $loID = null;
        if(isset($loDados["id"]) && !empty($loDados["id"]) ){
            $loID = $loDados["id"];
            $loDdConsulta .=  " AND pessoa.id_pessoa = ".$loID; 

        }
        $loNome = null;
        if(isset($loDados["nome"]) && !empty($loDados["nome"]) ){
            $loNome = $loDados["nome"];
            $loDdConsulta .=  " AND pessoa.nome like '%".utf8_decode($loNome)."%'"; 

        }
        $loCnpj = null;
        if(isset($loDados["cnpj"]) && !empty($loDados["cnpj"]) ){
            $loCnpj = $loDados["cnpj"];
            $loDdConsulta .=  " AND pessoa.cnpj like '%".$loCnpj."%'"; 

        }        
        $loCpf = null;
        if(isset($loDados["cpf"]) && !empty($loDados["cpf"]) ){
            $loCpf = $loDados["cpf"];
            $loDdConsulta .=  " AND pessoa.cpf like '%".$loCpf."%'"; 

        }
        $loStatus = null;
        if(isset($loDados["status"]) && strlen($loDados["status"]) >= 1){
            $loStatus= $loDados["status"];
            $loDdConsulta .=  " AND pessoa.ativo in(".$loStatus.")";
        }else{
            $loDdConsulta .=  " AND pessoa.ativo = 1";
        }
        $loIndPassageiro = null;
        if(isset($loDados["ind_passageiro"]) && !empty($loDados["ind_passageiro"]) ){
            $loIndPassageiro = $loDados["ind_passageiro"];
            $loDdConsulta .=  " AND pessoa.ind_passageiro = ".$loIndPassageiro; 

        }
        $loIndMotorista = null;
        if(isset($loDados["ind_motorista"]) && !empty($loDados["ind_motorista"]) ){
            $loIndMotorista = $loDados["ind_motorista"];
            $loDdConsulta .=  " AND pessoa.ind_motorista = ".$loIndMotorista; 

        } 
        $loIndCondutor = null;
        if(isset($loDados["ind_condutor"]) && !empty($loDados["ind_condutor"]) ){
            $loIndCondutor = $loDados["ind_condutor"];
            $loDdConsulta .=  " AND pessoa.ind_condutor = ".$loIndCondutor; 

        }        


        if($_SESSION["supervisor"] != 1){    
            $loDdConsulta .= " AND pessoa.id_pessoa_matriz = ".$_SESSION["id_pessoa_matriz"];
        }

        $loPessoa = new pessoaBOA();
        $loListaPessoas = $loPessoa->ListaPessoas($loDdConsulta);

        return $loListaPessoas;

    }

    public function GravarCliente($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );



        if($loDados["cnpj"] == ""){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o CNPJ.";
        }
        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome.";

        }

     
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loDadosCliente = new pessoaBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loDadosCliente->IncluirCliente($loDados);
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loDadosCliente->AlterarCliente($loDados);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }

    public function GravarMotoristaPassageiro($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 
        $loValidacaoTela = "pessoa";

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );

        if(isset($loDados["tela"]) && !empty($loDados["tela"])){
           if($loDados["tela"] == "solicitacao"){
               $loValidacaoTela = "solicitacao";
           } 
        }

        /*if($loDados["cpf"] == "" && $loValidacaoTela == "pessoa"){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o CPF.";
        }*/
        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome.";
        }
         if($loDados["endereco"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Endere&ccedil;o.";
        }
        if($loDados["email"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o E-mail.";
        }
        if($loDados["telefone"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Telefone.";
        }
        if($loDados["data_validade_habilitacao"] == "" && $loDados["ind_motorista"] == "1" && $loValidacaoTela == "pessoa"){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Data validade habilita&ccedil;&atilde;o.";
        }
        if($loDados["acao"] == "U" && $loValidacaoTela == "pessoa"){

            $loPessoa = new pessoaBOA();
            $loRetornoGaragem = $loPessoa->VerificaGaragemAtual($loDados["id"],$loDados["id_localidade_garagem"]);

            if($loDados["id_localidade_garagem"] != "" && $loDados["motivo_garagem"] == "" && $loRetornoGaragem["conta_garem_vazio"] == 0 && $loRetornoGaragem["conta_garem_igual"] == 0){
                $loResultadoOperacao = true;
                $loResultadoMessagem = "Para alterar a garagem, por favor, preencha o motivo da troca";
            }
        }
      
        if($loDados["ind_passageiro"] == 0 && $loDados["ind_motorista"] == 0 && $loDados["ind_condutor"] == 0 && $loValidacaoTela == "pessoa"){
                $loResultadoOperacao = true;
                $loResultadoMessagem = "Por favor, selecione pelo menos um dos itens, Passageiros, Motorista ou Condutor.";
        }


        //Validação usuario
        if(isset($loDados["confirma_cadastro_usuario"])){

            if( $loDados["confirma_cadastro_usuario"] == 1 ){

                if(isset($loDados["login"]) && $loDados["login"] == ""){
                    $loResultadoOperacao = true;
                    $loResultadoMessagem = "Favor preencher o login!";
                }
                if(isset($loDados["senha"]) && $loDados["senha"] == "" && $loDados["acao"] == "I" ){
                    $loResultadoOperacao = true;
                    $loResultadoMessagem = "Favor preencher a senha!";
                }
                if(isset($loDados["confi_senha"]) && $loDados["confi_senha"] == ""  && $loDados["acao"] == "I" ){
                    $loResultadoOperacao = true;
                    $loResultadoMessagem = "Favor preencher a Confirma&ccedil;&atilde;o da senha!";
                }

            if( (isset($loDados["senha"]) && isset($loDados["confi_senha"]))  && $loDados["senha"] != $loDados["confi_senha"]  && $loDados["acao"] == "I" ){
                    $loResultadoOperacao = true;
                    $loResultadoMessagem = "Senha n&atilde;o e igual a Confirma&ccedil;&atilde;o da Senha!";
                }

            }

        }

     
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{


            $loPessoa = new pessoaBOA();

            if($loDados["acao"] == "I"){
                $loRetorno = $loPessoa->IncluirMotoristaPassageiro($loDados);
                $loIdPessoa = $loPessoa->BuscaIDPessoa();
            }
            if($loDados["acao"] == "U"){
                $loRetorno = $loPessoa->AlterarMotoristaPassageiro($loDados);
                $loIdPessoa = $loDados["id"];
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido", "id" => $loIdPessoa);
            }

        }

         return $loRetorno;

    }


    public function GravarEmpresa($loDados){


        //Tratar campos obrigatorios
        $loResultadoOperacao = false;
        $loResultadoMessagem = null;
        $loRetorno[] = null; 
        $loNomeArquivo = null;
        $loDiretorio = "../../comum/apresentacao/imagens/";

        $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );



        if($loDados["cnpj"] == ""){
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o CNPJ.";
        }
        if($loDados["nome"] == ""){ 
            $loResultadoOperacao = true;
            $loResultadoMessagem = "Favor preencher o Nome.";

        }


        //Upload de Imagem Inicio
        if(isset($loDados["logoArquivo"]["arquivo"]) && $loDados["logoArquivo"]["arquivo"]["name"] != "" ){
            
            //Tipo Imagem
            $loTypeArquivo = $loDados["logoArquivo"]["arquivo"]["type"]; 


            //Verifica se imagem é jpg ou png //Verifica se é submit, validacao == 1 é submit / validacao == 0 não é submit 
            if(isset($loDados["validacao"]) && $loDados["validacao"] == 0)
            {

               
               if($loTypeArquivo == "image/jpeg" || $loTypeArquivo == "image/png")
               {

                    $nome_empresa = $this->RemoveAcentos($loDados["nome"] );
                    $arquivo = $loDados["logoArquivo"]["arquivo"];

                    $rand = rand(2, 30);
                    $loNomeArquivo = $nome_empresa."_logo_".$rand.".jpg";

                    if (!move_uploaded_file($arquivo["tmp_name"],$loDiretorio.$loNomeArquivo)){
                        $loResultadoOperacao = true;
                        $loResultadoMessagem = "uplaod_erro";
                    }

                 }else{

                    $loResultadoOperacao = true;
                    $loResultadoMessagem = "upload_formato";

                }
            }

        }
        //Upload de Imagem Fim

        //Array logo
        $loArquivoLogo = array("diretorio" => $loDiretorio, "nome_arquivo" => $loNomeArquivo );
      
         
        if($loResultadoOperacao){
              $loRetorno = array("erro" => $loResultadoOperacao, "messagem" => $loResultadoMessagem );
        }else{

            $loDadosEmpresa = new pessoaBOA();

            if($loDados["acao"] == "I" && (isset($loDados["validacao"]) && $loDados["validacao"] == 0) ){
                $loRetorno = $loDadosEmpresa->IncluirEmpresa($loDados,$loArquivoLogo);
            }
            if($loDados["acao"] == "U" && (isset($loDados["validacao"]) && $loDados["validacao"] == 0) ){
                $loRetorno = $loDadosEmpresa->AlterarEmpresa($loDados,$loArquivoLogo);
            }

            if($loRetorno){
                 $loRetorno = array("erro" => false, "messagem" => "Incluido" );
            }

        }

         return $loRetorno;

    }

    public function RemoveAcentos($string) {

        $map = array(
            'á' => 'a',
            'à' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'é' => 'e',
            'ê' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ç' => 'c',
            'Á' => 'A',
            'À' => 'A',
            'Ã' => 'A',
            'Â' => 'A',
            'É' => 'E',
            'Ê' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ú' => 'U',
            'Ü' => 'U',
            'Ç' => 'C'
        );

        $loStrtr =  strtr($string, $map); 
        $loStrReplace = str_replace(" ", "_", $loStrtr);
        $loRetorno = strtolower($loStrReplace);

        return $loRetorno;

    }


    public function ListaItensConsulta($loDados){

        $loPessoa = new pessoaBOA();
        $loItensConsulta = $loPessoa->ListaItensConsulta($loDados);

        return $loItensConsulta;

    }

    public function GridConsultaItens($loDados){

        $loPessoa = new pessoaBOA();
        $loGridItens = $loPessoa->GridConsultaItens($loDados);

        return $loGridItens;

    }

    public function AlteraConsultaCliente($loDados){

        $loPessoa = new pessoaBOA();
        $loConsulta = $loPessoa->AlteraConsultaCliente($loDados);

        return $loConsulta;

    }

    public function DesativarMotoristaPassageiro($loDados){

       $loRetorno[] = null; 

        $loPessoa = new pessoaBOA();
        $loDesativa = $loPessoa->DesativarMotoristaPassageiro($loDados);
        return $loRetorno;
    }

    public function DesativarPessoa($loDados){

       $loRetorno[] = null; 

        $loPessoa = new pessoaBOA();
        $loDesativa = $loPessoa->DesativarPessoa($loDados);
        return $loRetorno;
    }

    public function ListaDadosEmpresa($loDados){

        $loPessoa = new pessoaBOA();
        $loRetorno = $loPessoa->ListaDadosEmpresa($loDados);
        return $loRetorno;
    }

   public function ListaMotoristaVencHabilitacao($loDados){

        $loDdConsulta = null;
        $loLimit = null;
        if(isset($loDados["not_limit"]) && !empty($loDados["not_limit"]) ){
            $loLimit = $loDados["not_limit"];
            if($loLimit > 0 ){
                $loDdConsulta .=  " LIMIT ".$loLimit; 
            }

        }

        $loPessoa = new pessoaBOA();
        $loRetorno = $loPessoa->ListaMotoristaVencHabilitacao($loDdConsulta);
        return $loRetorno;
    }

    public function ListaHistorioGargem($loDados){

        $loPessoa = new pessoaBOA();
        $loRetorno = $loPessoa->ListaHistorioGargem($loDados);
        return $loRetorno;        

    }

    public function ListaLog($loDados){
        $loPessoa = new pessoaBOA();
        $loRetorno = $loPessoa->ListaLog($loDados);
        return $loRetorno;        

    }

    public function ListaDadosUsuario($loDados){

        $loPessoa = new pessoaBOA();
        $loRetorno = $loPessoa->ListaDadosUsuario($loDados);
        return $loRetorno;        

    }

} 

?>