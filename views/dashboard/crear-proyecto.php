<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../template/alerts.php'; ?>

    <form class="formulario" method="POST" action="/crear-lista">
        <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
        <input type="submit" value="Crear">
    </form>
</div>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>