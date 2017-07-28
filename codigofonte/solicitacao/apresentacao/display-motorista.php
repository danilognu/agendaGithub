<?php  include("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include("../negocio-solicitacao.php");  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Display Motoristas</title>
</head>

<body>
<style>
.table{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
.titulo td{
	font-family:Arial, Helvetica, sans-serif;
	font-size:20px;
	background-color:#EAEAEA;
	height:50px;
	border: 1px solid;
	border-color:#CCC;
	padding-left:10px;
	font-weight:900;
}
.couteudo td{
		border: 1px solid;
		border-color:#CCC;
		font-size:18px;
		padding-top:10px;
		padding-left:5px;
    padding-bottom: 5px;
}
</style>

<?php 

  $loSolicitacao = new solicitacaoBO();

  $classCss = "style='background-color:'"; //Verde #26C281 //Amarelo #F7CA18 //Vermelho //#e35b5a
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
  <tr class="titulo">
    <td>Solic.</td>
    <td>Setor</td>
    <td>Data Inicio</td>
    <td>Data Termino</td>
    <td>Veiculo</td>
    <td>Motorista</td>
    <td>Destino</td>
    <td>Situacao</td>
  </tr>

<?php 
    $loDadosC = array( 'id' => '');
    $loLista =  $loSolicitacao->DisplayMotoristas($loDadosC);

    if(count($loLista)){
    foreach ($loLista as $row){

?>

  <tr class="couteudo">
    <td <?php echo $classCss; ?> ><?php echo $row["id_solicitacao"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["setor"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["dt_saida"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["dt_retorno_prev"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["placa"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["motorista"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["destino"]; ?></td>
    <td <?php echo $classCss; ?> ><?php echo $row["situacao"]; ?></td>
  </tr>

<?php 
    }
}
?>  
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
</table>



</body>
</html>
