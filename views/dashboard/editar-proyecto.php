<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<h1 class="nombre-pagina">Editar Lista</h1>
<p class="descripcion-pagina">Modifica el nombre de la Lista</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="proyecto">Nombre de la Lista</label>
        <input type="text" id="proyecto" name="proyecto" placeholder="Nombre de la Lista" value="<?php echo $proyecto->proyecto; ?>">
    </div>
    <input type="submit" class="boton" value="Guardar Cambios">
</form>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
