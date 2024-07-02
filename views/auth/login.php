<div class="contenedor login">
    <?php include_once __DIR__ . '/../template/site-name.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ . '/../template/alerts.php'; ?>


        <form action="/" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu email" name="email">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Tu password" name="password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/create">Crea tu Cuenta</a>
            <a href="/forgot">Olvidaste tu Contraseña</a>
        </div>
    </div>

</div>