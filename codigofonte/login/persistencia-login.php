<?php
include("../../conexao.php");

class usuarioBOA{ 
 
    public function VerificaUsuario($Dados){
            

        $loConexao = new Conexao();
        $pdo = $loConexao->IniciaConexao();



        $login = $this->sanitizeString($Dados['login']);
        $senha = $this->sanitizeString($Dados['senha']);

        $loSql = "SELECT 
                        usuario.id_usuario
                        ,usuario.nome
                        ,usuario.login
                        ,usuario.senha
                        ,usuario.id_pessoa_matriz
                        ,usuario.ind_supervisor 
                        ,grupo_acesso.id_grupo
                    FROM usuario 
                        INNER JOIN grupo_acesso ON grupo_acesso.id_grupo = usuario.id_grupo
                    WHERE login = '".$login."' 
                    AND senha = '".base64_encode($senha)."' 
                    AND ativo = 1";
        $query = $pdo->prepare($loSql);
        $query->execute();

        $loValidaAc = 0;
        $menu_items = null;

        foreach ($query as $row) {


                $menu_items =array(
						'id_usuario'        =>$row['id_usuario'] , 
						'nome'              =>$row['nome'], 
						'login'             =>$row['login'], 
						'senha'             =>$row['senha'],
                        'id_pessoa_matriz'  =>$row["id_pessoa_matriz"],
                        'ind_supervisor'    =>$row["ind_supervisor"],
                        'id_grupo'          =>$row["id_grupo"]
					);
                    
        }

        unset($pdo); 
        unset($query);

        return $menu_items;

        }

        public function  sanitizeString($string) {

            // matriz de entrada
            $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

            // matriz de saída
            $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );

            // devolver a string
            return str_replace($what, $by, $string);
        }

        public function VerificaEmail($mbDados) {

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();            

            $loEmail = $mbDados["email"];
            $loSql = "SELECT id_usuario,nome,email FROM usuario WHERE email = '".$loEmail."'";
            $query = $pdo->prepare($loSql);
            $query->execute();

            $Grid = null;
            foreach ($query as $row) {
                $Grid[] = array(
                        'id_usuario'  => $row['id_usuario'] 
                        ,'nome'       => $row['nome'] 
                        ,'email'      => $row['email'] 
                    );
            }

            return $Grid;   

        }

        public function AtualizaRecuperacaoSenha($mbId,$mbNovaSenha) {

            $loConexao = new Conexao();
            $pdo = $loConexao->IniciaConexao();   

            $loSql = "UPDATE usuario SET ind_recuperar_senha = 1, senha = '".$mbNovaSenha."' WHERE id_usuario = ".$mbId;           
            $query = $pdo->prepare($loSql);
            $query->execute();

        }

}



?>