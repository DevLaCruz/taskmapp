<div class="contenedor crear">
    <?php include_once __DIR__ . '/../template/site-name.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta Yaa!</p>

        <?php include_once __DIR__ . '/../template/alerts.php'; ?>
        <form action="/create" class="formulario" method="POST">
            <div class="campo">
                <label for="name">Nombre Completo</label>
                <input type="name" id="name" placeholder="Tu nombre" name="name" value="<?php echo $user->name; ?>">
            </div>


            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo $user->email; ?>">
            </div>

            <div class=" campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Tu password" name="password">
            </div>

            <div class="campo">
                <label for="password2">Respite tu Contraseña</label>
                <input type="password" id="password2" placeholder="Respite tu Contraseña" name="password2">
            </div>

            <input type="submit" class="boton" value="Crea tu Cuenta">
        </form>

        <div class="acciones">
            <a href="/">Iniciar Sesión</a>
            <a href="/forgot">Olvidaste tu Contraseña</a>
        </div>
    </div>

</div>