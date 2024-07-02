<?php
foreach ($alerts as $key => $error) :
    foreach ($error as $message) : // Cambiado $alert a $error
?>
        <div class="alerta <?php echo $key; ?>"><?php echo $message; ?></div>
<?php
    endforeach;
endforeach;
?>