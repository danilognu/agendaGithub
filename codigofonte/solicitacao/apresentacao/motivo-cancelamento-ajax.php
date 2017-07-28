<?php
include("../../comum/comum.php");  
include("../negocio-solicitacao.php");
include("../../gerenciaCadastros/negocio-motivo-cancelamento.php");  


$loIdSolicitacao = $_REQUEST["id_solicitacao"];
$loObs = NULL;

$loConsulta = new solicitacaoBO();
$loMotivoCancelamento = new motivoCancelamentoBO();
 
?>

<select class="form-control input-sm" nome="motivo-cancelamento-modal" id="motivo-cancelamento-modal"  >    
<?php   

    $loDadosMot = array( 'id' => '');
    $loListaMot =  $loMotivoCancelamento->Consultar($loDadosMot);
    
    echo "<option value='' ></option>" ;      
        
        if(count($loListaMot)>0){
            foreach ($loListaMot as $row){
                
                $loSelected = "";
                if($loidMotivoCancelamento == $row["id"]){
                    $loSelected = "selected";
                }

                echo "<option value=".$row["id"]." ".$loSelected." >".$row["nome"]."</option>" ;      

            } 
        }

?>  
</select>
