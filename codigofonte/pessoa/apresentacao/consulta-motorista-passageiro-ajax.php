<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-pessoa.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loCpf = null;
$loStatus = null;
$loIndPassageiro = null;
$loIndMotorista = null;
$loIndCondutor = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["cpf"])){ $loCpf = $_REQUEST["cpf"]; }
if(isset($_REQUEST["status"])){ $loStatus = $_REQUEST["status"]; }
if(isset($_REQUEST["ind_passageiro"])){ $loIndPassageiro = $_REQUEST["ind_passageiro"]; }
if(isset($_REQUEST["ind_motorista"])){ $loIndMotorista = $_REQUEST["ind_motorista"]; }
if(isset($_REQUEST["ind_condutor"])){ $loIndCondutor = $_REQUEST["ind_condutor"]; }

                                            
$loComum = new comumBO();

$loPessoa = new pessoaBO();

$loDadosC = array( 
        'tipo_pessoa' => '4,5,6'
        , 'id' => $loId 
        , 'nome' => $loNome
        , 'cpf' => $loCpf 
        , 'status' => $loStatus
        , 'ind_passageiro' => $loIndPassageiro
        , 'ind_motorista' => $loIndMotorista
        , 'ind_condutor' => $loIndCondutor
    );


$loLista =  $loPessoa->ListaPessoa($loDadosC);

if(count($loLista) > 0 ){

    foreach ($loLista as $row){
        
    ?>

    <tr class="odd gradeX" >
        <td>
            <input type="checkbox" class="checkboxes" name="checkboxes-motorista"  value="<?php echo $row["id_pessoa"]; ?>"> 
        </td>
   <?php

            //Monta grid dinamica Begin
            $loDadosGrid = array( 
                        'id_menu' => 8 
                );

            $loItensConsulta =  $loPessoa->ListaItensConsulta($loDadosGrid);

                foreach ($loItensConsulta as $rowItem){
                    
                    $loItens = explode(",", $rowItem["campo_bd"]);   

                    foreach ($loItens as $item){



                        switch ($item) {
                            case "ativo":
                            
                                if($row["ativo"] == 1){
                                    echo " <td> <span class='label label-sm label-success'> Ativo </span>  </td>";
                                }else{
                                    echo " <td> <span class='label label-sm label-danger'> Desativado </span>  </td>";
                                }

                            break;
                            case "telefone":
                                echo " <td onclick='MotoristaPassageiro.AbrirItem(".$row["id_pessoa"].");' style='cursor:pointer;' > (".$row["telefone_dd"].") ".substr($row["telefone"], 0, 4)."-".substr($row["telefone"], 4, 10)." </td>"; 
                            break;
                            default:
                                echo " <td onclick='MotoristaPassageiro.AbrirItem(".$row["id_pessoa"].");' style='cursor:pointer;' > ".$row[$item]." </td>";

                        }

                    }
                }
                //Monta grid dinamica End

        ?>


    </tr>
<?php

    }
    
}

?>
                                           


