
<?php  include("../../conexao-sqlsrv.php");  ?>
<?php 


$SqlCad = "SELECT A009_cd_veiculo,A009_chassi,A009_renavan,* FROM T009_VEICULO WHERE A009_placa_veiculo = ? AND A011_cd_empresa_atual = ?";


$pieces = explode("WHERE", $SqlCad);
//echo $pieces[1];
$piecesAND = explode("AND", $pieces[1]);
$loContaTB = 0;
$loTd = "";

foreach ($piecesAND as $row) { 

    //echo $row;
    $colunasTb = explode("=", $row);

     //echo $colunasTb[0];

     $loTd .= "<td> ".$colunasTb[0]." <br />
            <input type='text' name='elementosInput' id='".$colunasTb[0]."' value='' />
           </td> ";
           
     $loContaTB++;
 
}

?>

<table width="50%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <?php echo $loTd; ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<input type="submit" id='envia-dados-pesquisa' onClick="Teste();" />

<script>

function Teste(){

     var elemento = document.getElementsByName('elementosInput');
 
       for(i=0;i<elemento.length;i++){
          var e = elemento[i];
          console.log(e.value);
          console.log(e.id);
       }

}

</script>
