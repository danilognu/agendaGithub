<?php
$loNegociosComandos = new negocioBO();
$loDadosComandos = $loNegociosComandos->ListaComandosSQL();
?>

<div class="portlet-body">
<div class="table-scrollable">

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th> Codigo </th>
            <th> Nome Comando </th>
            <th> Descricao  </th>
            <th> Executar </th>
        </tr>
    </thead>
    <tbody>
            <?php
                foreach ($loDadosComandos as $row){
                    echo "<tr>";
                    echo "<td>".$row["id_comando"]."</td>";
                    echo "<td>".$row["nome"]."</td>";
                    echo "<td>".$row["descricao"]."</td>";
                    echo "<th> <button id='btn-executacomando' value='".$row["id_comando"]."' >Executar</button>  </th>";
                    echo "</tr>";
                }
            ?>
    </tbody>
</table>
</div>
</div>
