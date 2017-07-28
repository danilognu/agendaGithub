<?php
include("persistencia-comum.php");

class comumBO{

    public function ListaEstado($mbDados){


        $loListaEstado = new comumBOA();
        $loLista = $loListaEstado->ListaEstado($mbDados);

        return  $loLista;

    }


    public function ListaCidade($loIdEstado,$loIdCidade){

        $loListaCidade = new comumBOA();
        $loLista = $loListaCidade->ListaCidade($loIdEstado,$loIdCidade);

        return  $loLista;

    }

     public function Mask($val, $mask)
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

    public function AdicionaDate($data){

        if(!empty($data)) {

            $loDia = substr($data, 0, 2);
            $loMes = substr($data, 2, 2);
            $loAno = substr($data, 4, 4);
            $DtInverte = $loAno."/".$loMes."/".$loDia;

            return $DtInverte;
        }
        
    }


    public function AdicionaHora($data){

        if(!empty($data)) {

            $loHora = substr($data, 0, 2);
            $loMinuto = substr($data, 2, 2);
            $retorno = $loHora.":".$loMinuto;

            return $retorno;
        }
        
    }

    public function AdicionaDataHora($data){

        if(!empty($data)) {

            $loDia = substr($data, 0, 2);
            $loMes = substr($data, 2, 2);
            $loAno = substr($data, 4, 4);
            $loHora = substr($data, 8, 2);
            $loMinut = substr($data, 10, 2);
            $DtInverte = $loAno."/".$loMes."/".$loDia." ".$loHora.":".$loMinut;

            return $DtInverte;
        }
        
    }

    public function AdicionaDataHoraFormatoVisual($data){

        if(!empty($data)) {

            $loDia = substr($data, 0, 2);
            $loMes = substr($data, 2, 2);
            $loAno = substr($data, 4, 4);
            $loHora = substr($data, 8, 2);
            $loMinut = substr($data, 10, 2);
            $DtInverte = $loDia."/".$loMes."/".$loAno." ".$loHora.":".$loMinut;

            return $DtInverte;
        }
        
    }    

    public function AdicionaComBarraDataHora($data){

        if(!empty($data)) {

            $loDia = substr($data, 0, 2);
            $loMes = substr($data, 3, 2);
            $loAno = substr($data, 6, 4);
            $loHora = substr($data, 9, 2);
            $loMinut = substr($data, 12, 2);
            $DtInverte = $loAno."/".$loMes."/".$loDia;

            return $DtInverte;
        }
        
    }


    public function ExibirNomeMenu($loIdMenu){

        $loExibirNomeMenu = new comumBOA();
        $loExibir = $loExibirNomeMenu->ExibirNomeMenu($loIdMenu);

        return  $loExibir;

    }

    public function VerificaPermissao($mbDados){

        $verificaPermissao = new comumBOA();
        $loRetorno = $verificaPermissao->VerificaPermissao($mbDados);

        return  $loRetorno;

    }

    public function VerificaItemArray($mbDados,$mbItem){
        
        $item = false;
        if(count($mbDados) > 0){
            foreach ($mbDados as $row){
                if($row["tipo_acesso"] == $mbItem){ $item=true; }
            }
        }

        return $item;

    }

    public function variavelVazia($var){
        if(empty($var)){
            $var = "NULL"; 
        }
        return $var;
    }

    public function VerificaCarona(){
        
        $loComum = new comumBOA();
        $loExibir = $loComum->VerificaCarona();

        return  $loExibir;
    }


    public function VarGlobal(){
         
         $loRetorno = array(  
                              "CODIGO_GRUPO_ACESSO_OPERADOR" => 4
                            , "CODIGO_GRUPO_ACESSO_GESTOR"   => 3
                            , "CODIGO_GRUPO_ACESSO_GESTOR"   => 1 
                           );

        return $loRetorno;
    }

    public function ListaDadosAcessoUsuarioCorrente(){

        $loComum = new comumBOA();
        $loExibir = $loComum->ListaDadosAcessoUsuarioCorrente();

        return  $loExibir;

    }

    public function PendenciasDeAutorizacaoCarona(){

        $loComum = new comumBOA();
        $loExibir = $loComum->PendenciasDeAutorizacaoCarona();

        return  $loExibir;

    }    

    public function BuscaLogoEmpresa(){
        
        $loComum = new comumBOA();
        $loExibir = $loComum->BuscaLogoEmpresa();

        return  $loExibir;        
    }

    public function ConfiguracaoHostEmail(){
        
        $loRetorno = array(  
                              "HOST"   => "SRVAQAEUROIT2.grupomorada.local"
                            , "PORTA"  => 587
                            , "EMAIL"  => "tecnologia@grupomorada.com.br"
                           );

        return $loRetorno;  
    }

}

?>