<?php

$loNegocios = new negocioBO();
$loDados = $loNegocios->ListaBancos();
?>

<div class="form-group">
    <label class="col-md-1 control-label">Banco</label>
    <div class="col-md-3">
        <select class="form-control">
            <?php
            foreach ($loDados as $row){
                echo "<option>".$row["nome"]."</option>";
            }
            ?>
        </select>
    </div>
</div>
