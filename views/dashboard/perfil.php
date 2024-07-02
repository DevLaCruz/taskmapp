<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">

    <?php include_once __DIR__ . '/../template/alerts.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar Password</a>

    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <label for="nombre">Nombre Completo</label>
            <input type="text" value="<?php echo $user->name; ?>" name="name" placeholder="Tu Nombre" />
        </div>
        <!-- <div class="campo">
            <label for="email">Email</label>
            <input type="email" value="<?php echo $user->email; ?>" name="email" placeholder="Tu Email" />
        </div> -->

        <input type="submit" value="Guardar Cambios">
    </form>
</div>


<?php include_once __DIR__  . '/footer-dashboard.php'; ?>