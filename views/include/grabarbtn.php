<?php
    $mod= "Agregar Datos";
    if ($modo == "Editar")
    {
       $mod = "Grabar Datos";
    }
?>
<input type="submit" class="btn btn-success" value=" <?php echo $mod; ?>">&nbsp&nbsp