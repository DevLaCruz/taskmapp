<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../template/alerts.php'; ?>

    <a href="/perfil" class="enlace">Volver a Perfil</a>

    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="campo">
            <label for="nombre">Password Actual</label>
            <input type="password" name="current_password" placeholder="Tu Password Actual" />
        </div>
        <div class="campo">
            <label for="nombre">Password Nuevo</label>
            <input type="password" name="new_password" placeholder="Tu Password Nuevo" />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>