<?php
class usuarioBOA{


    public function ListaUsuarios($mbDados){


        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();


        $loSql = "SELECT 
                        usuario.id_usuario
                        ,usuario.nome
                        ,usuario.login
                        ,usuario.senha
                        ,usuario.ativo
                        ,pessoa_origem.email
                        ,pessoa.nome as nome_filial
			            ,pessoa.id_pessoa as id_pessoa_filial
                        ,usuario.ind_supervisor
                        ,usuario.id_grupo
                        ,usuario.id_setor
                        ,usuario.id_pessoa_origem
                        ,(
                            SELECT ind_usuario FROM usuario
                            INNER JOIN  grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                            WHERE usuario.id_usuario = ".$_SESSION["id_usuario"]."                     
                        ) as ind_usuario
                        ,(
                            SELECT ind_gestor FROM usuario
                            INNER JOIN  grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                            WHERE usuario.id_usuario = ".$_SESSION["id_usuario"]."                     
                        ) as ind_gestor   
                        ,(
                            SELECT grupo_acesso.ind_adm FROM usuario
                            INNER JOIN  grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                            WHERE usuario.id_usuario = ".$_SESSION["id_usuario"]."                   
                        ) as ind_adm                                                
                    FROM usuario 
                    LEFT JOIN pessoa pessoa_origem ON pessoa_origem.id_pessoa = usuario.id_pessoa_origem
                    LEFT JOIN pessoa ON pessoa.id_pessoa =  usuario.id_pessoa_matriz
                    LEFT JOIN grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                    WHERE 1=1 ".$mbDados;

       //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loUsuarios = null;
        foreach ($query as $row) {
               
               
               $loUsuarios[] = array(
                    'id_usuario'        =>$row['id_usuario'] , 
                    'nome'              =>$row['nome'], 
                    'login'             =>$row['login'], 
                    'senha'             =>$row['senha'],
                    'ativo'             =>$row['ativo'],
                    'ind_adm'           =>$row['ind_adm'],
                    'email'             =>$row["email"],
                    'nome_filial'       =>$row["nome_filial"],
                    'id_pessoa_filial'  =>$row["id_pessoa_filial"],
                    'ind_supervisor'    =>$row["ind_supervisor"],
                    'id_grupo'          =>$row["id_grupo"],
                    'id_setor'          =>$row["id_setor"],
                    'id_pessoa_origem'  =>$row["id_pessoa_origem"],
                    'ind_usuario'       =>$row["ind_usuario"], 
                    'ind_gestor'        =>$row["ind_gestor"]  
                );
               
        
        }

        return $loUsuarios;        



    }

    public function IncluirUsuario($loDados){

        $loNome = utf8_decode($loDados["nome"]);
        $loLogin = utf8_decode($loDados["login"]);
        $loSenha = base64_encode($loDados["confirSenha"]);
        $loData = "NOW()";
        $loEmail = $loDados["email"];
        $loEmpresa = $loDados["empresa"];
        $loGrupoAcesso = $loDados["id_grupo"];
        $loSetor = $loDados["id_setor"];

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        $loSql = "INSERT INTO 
                    usuario (
                        nome
                        ,login
                        ,senha
                        ,dt_cadastro
                        ,email
                        ,ativo
                        ,id_pessoa_matriz
                        ,id_grupo
                        ,id_setor
                    ) VALUES (?,?,?,?,?,?,?,?,?)";
         
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loNome);
        $query->bindValue(2, $loLogin);
        $query->bindValue(3, $loSenha);
        $query->bindValue(4, $loData);
        $query->bindValue(5, $loEmail);
        $query->bindValue(6, 1);
        $query->bindValue(7, $loEmpresa);
        $query->bindValue(8, $loGrupoAcesso);
        $query->bindValue(9, $loSetor);
        $query->execute(); 


        $losqlM = "SELECT MAX(id_usuario) id_usuario  FROM usuario";
        $queryM= $pdo->prepare($losqlM);
        $queryM->execute();    

        $loDadosUsuarios = null;
        foreach ($queryM as $rowM) {

            $loDadosUsuarios = array(
                'id_usuario'        =>$rowM["id_usuario"], 
                'nome'              =>$loNome,
                'email'             =>$loEmail,
                'id_pessoa_matriz'  =>$loEmpresa
                ,'id_setor'         =>$loSetor
            );

           $this->InserirCamposTabelasDinamica($rowM["id_usuario"]);
           $this->IncluirPessoaUsuario($loDadosUsuarios);
        }


        return true;


    }

    public function AlterarUsuario($loDados,$loCodigosPessoaQuemAutorizo,$loCodigosPessoaQuemMeAutoriza){

        $loLogin = utf8_decode($loDados["login"]);
        $loSenha = base64_encode($loDados["confirSenha"]);
        $loEmail = $loDados["email"];
        $loIdUsuario = $loDados["id_usuario"];
        $loStatus = $loDados["status"];
        $loGrupoAcesso = $loDados["id_grupo"];
        $loEmpresa = $loDados["empresa"];
        $loIdPessoaOrigem = $loDados["id_pessoa_origem"];
        $loEnviaSenha = null;

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();

        if($loSenha != ""){
            $loEnviaSenha = " ,senha = '".$loSenha."'";
        }

       $loSql = "UPDATE usuario SET
                        login= ?
                        ,email = ?
                        ,ativo = ?
                        ,id_grupo = ?
                        ,id_pessoa_matriz = ?
                        ,dt_alt = NOW()
                        ".$loEnviaSenha."
                WHERE id_usuario = ? ";
        
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $loLogin);
        $query->bindValue(2, $loEmail);
        $query->bindValue(3, $loStatus);
        $query->bindValue(4, $loGrupoAcesso);
        $query->bindValue(5, $loEmpresa);
        $query->bindValue(6, $loIdUsuario);        
        $query->execute(); 


        //Grava pessoa que o usuario autoriza
        if(!is_null($loCodigosPessoaQuemAutorizo)){
            foreach ($loCodigosPessoaQuemAutorizo as $rowPessoa) {
              $this->IncluirUsuarioAutorizador($loIdPessoaOrigem,$rowPessoa);
            }
        }  

        //Grava pessoa que autoriza o usuario
        if(!is_null($loCodigosPessoaQuemMeAutoriza)){
            foreach ($loCodigosPessoaQuemMeAutoriza as $rowPessoa) {
              $this->IncluirUsuarioAutorizador($rowPessoa,$loIdPessoaOrigem);
            }
        }  

        $this->AtualizaPessoaOrigem($loDados);             

        return true;         

    }

    public function AtualizaPessoaOrigem($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();        

         $loEmail = $loDados["email"];
         $loIdUsuario = $loDados["id_usuario"];
         $loNome = $loDados["nome"];
         $loEmpresa = $loDados["empresa"];

         $loSql = "UPDATE pessoa 
                        SET email = '".$loEmail."'
                            ,nome = '".$loNome."' 
                            ,id_pessoa_matriz = ".$loEmpresa."
                   WHERE id_pessoa = (SELECT id_pessoa_origem FROM usuario WHERE id_usuario = ".$loIdUsuario." )";
         $query= $pdo->prepare($loSql);
         $query->execute();   

    }

    public function InserirCamposTabelasDinamica($mbIdUsuario){


       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();


        //Verifica aqui telas ira permitir tabelas dinamicas
        $loSql = "SELECT id_menu,nome FROM MENU WHERE grid_dinamico = 1";
        $query= $pdo->prepare($loSql);
        $query->execute();    

        $loUsuarios = null;
        foreach ($query as $row) {
        
            //Pega os itens definidos como padrao para as consultas
            $loSqlGridC = "SELECT id_grid_consulta FROM grid_consulta WHERE id_menu =  ".$row["id_menu"]." AND ind_padrao = 1";

            $queryGridC= $pdo->prepare($loSqlGridC);
            $queryGridC->execute();    

            $loStrIDGridConsulta = "";
            $loStrINConsulta = "";
            foreach ($queryGridC as $rowGridC) {
                $loStrIDGridConsulta .= $rowGridC["id_grid_consulta"].",";
            }
            $loStrINConsulta = substr($loStrIDGridConsulta,0,-1);


            $loSqlInsert = "INSERT INTO usuario_consulta 
                                (id_usuario,id_menu,id_grid_consulta) 
                            VALUES 
                                (".$mbIdUsuario.",".$row["id_menu"].",'".$loStrINConsulta."')";

            $queryInsert= $pdo->prepare($loSqlInsert);
            $queryInsert->execute();                                 


        }
        

    }


    public function PesquisaAutorizadoresUsuario($mbIdPessoa){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();


        $loSql = "SELECT 
                        pessoa.id_pessoa
                        ,pessoa.nome
                    FROM autorizadores
                    INNER JOIN pessoa ON pessoa.id_pessoa = autorizadores.id_pessoa_filho
                    WHERE autorizadores.id_pessoa_pai = ".$mbIdPessoa;

         $query= $pdo->prepare($loSql);
         $query->execute();    

         $loUsuariosAut = null;
         foreach ($query as $row) {
                
                 $loUsuariosAut[] = array(
                    'id_pessoa'        =>$row['id_pessoa'] , 
                    'nome'             =>$row['nome'] 
                );

         }

         return  $loUsuariosAut;                  

    }

    public function PesquisaQueAutorizaUsuarioCorrente($mbIdPessoa){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();


        $loSql = "SELECT 
                        pessoa.id_pessoa
                        ,pessoa.nome
                    FROM autorizadores
                    INNER JOIN pessoa ON pessoa.id_pessoa = autorizadores.id_pessoa_pai
                    WHERE autorizadores.id_pessoa_filho = ".$mbIdPessoa;

         $query= $pdo->prepare($loSql);
         $query->execute();    

         $loUsuariosAut = null;
         foreach ($query as $row) {
                
                 $loUsuariosAut[] = array(
                    'id_pessoa'        =>$row['id_pessoa'] , 
                    'nome'             =>$row['nome'] 
                );

         }

         return  $loUsuariosAut;                  

    }


    public function IncluirUsuarioAutorizador($mbIdPessoaPai,$mdIdPessoaFilho){

       $loConexao = new Conexao();
       $pdo = $loConexao->IniciaConexao();        

        $loSql = "INSERT INTO autorizadores 
                    (
                        id_pessoa_pai
                        ,id_pessoa_filho
                        ,id_usuario_cad
                        ,dt_cad
                    )
                    VALUES (?,?,?,NOW()) ";
        $query= $pdo->prepare($loSql);
        $query->bindValue(1, $mbIdPessoaPai);
        $query->bindValue(2, $mdIdPessoaFilho);
        $query->bindValue(3, $_SESSION["id_usuario"]);
        $query->execute(); 

        return true;
    }

    public function VerificaSeUsuarioAutoriza($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();  

        $loIdUsuarioAlt = $loDados["id_usuario_alt"];
        $loIdUsuarioAutoriza = $loDados["id_usuario_autorizador"];

        $loSql = "SELECT COUNT(*) conta FROM autorizadores WHERE id_usuario = ".$loIdUsuarioAlt." AND id_usuario_autorizador = ".$loIdUsuarioAutoriza;
        $query= $pdo->prepare($loSql);
        $query->execute();    

         $loUsuariosAut = null;
         foreach ($query as $row) {
                
                 $loUsuariosAut[] = array(
                    'conta'        =>$row['conta'] 
                );

         }

         return  $loUsuariosAut;   

    }

    public function ExcluirUsuarioAutorizador($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao(); 

        $loIdPessoaPai = $loDados["id_pessoa_pai"];
        $loIdPessoaFilho = $loDados["id_pessoa_filho"];
        
        $loSql = "DELETE FROM autorizadores WHERE id_pessoa_pai = ".$loIdPessoaPai." AND id_pessoa_filho = ".$loIdPessoaFilho;
        $query= $pdo->prepare($loSql);
        $query->execute(); 

        return true;

    }


    public function IncluirPessoaUsuario($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao(); 

        $loNome = $loDados["nome"];
        $loEmail = $loDados["email"];
        $loIdUsuario = $loDados["id_usuario"];
        $loEmpresa = $loDados["id_pessoa_matriz"];
        $loSetor = $loDados["id_setor"];

        $loSql = "INSERT INTO 
                  pessoa (nome,email,ativo,id_tipo_pessoa,id_usuario_origem,id_pessoa_matriz,id_setor) 
                  VALUES ('".$loNome."','".$loEmail."',1,6,".$loIdUsuario.",".$loEmpresa.",".$loSetor.")";
        //echo $loSql;
        $query= $pdo->prepare($loSql);
        $query->execute(); 

        $loSqlMaxP = "SELECT MAX(id_pessoa) id_pessoa_max FROM pessoa";
        $queryMaxP = $pdo->prepare($loSqlMaxP);
        $queryMaxP->execute(); 

        foreach ($queryMaxP as $row) {

            $loSqlUp = "UPDATE usuario set id_pessoa_origem = ".$row["id_pessoa_max"]." WHERE id_usuario = ".$loIdUsuario;
            $queryUp = $pdo->prepare($loSqlUp);
            $queryUp->execute(); 

        }
        
        
    }

    public function BuscaNomeFilial($loDados){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao(); 

        $loIdPessoaFilial = $loDados["id"];

        $loSql = "SELECT id_pessoa,nome FROM pessoa WHERE id_pessoa = ".$loIdPessoaFilial;
        $query = $pdo->prepare($loSql);
        $query->execute(); 

        $loItens = null;
        foreach ($query as $row) {
            $loItens[] = array(
                'id_pessoa'    =>$row['id_pessoa']
                ,'nome'        =>$row['nome'] 
            );
        }

        return $loItens;

    }

    public function BuscaIDGrupoUsuarioLogado(){

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();         

        $loSql = "SELECT grupo_acesso.id_grupo FROM usuario
                    INNER JOIN  grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                    WHERE usuario.id_usuario = ".$_SESSION["id_usuario"];
        $query = $pdo->prepare($loSql);
        $query->execute(); 

        $loItens = null;
        foreach ($query as $row) {
            $loItens[] = array(
                'id_grupo'    =>$row['id_grupo']
            );
        }

        return $loItens;                    

    }



}
?>