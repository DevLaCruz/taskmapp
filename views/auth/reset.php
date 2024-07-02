<div class="contenedor reset">
    <?php include_once __DIR__ . '/../template/site-name.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nueva contraseña</p>

    <?php include_once __DIR__ . '/../template/alerts.php'; ?>

    <?php if($show){ ?>
        <form class="formulario" method="POST">

            <div class="campo">
                <label for="password">Ingresa tu nueva contraseña</label>
                <input type="password" id="password" placeholder="Tu password" name="password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
    <?php } ?>    

        <div class="acciones">
            <a href="/create">Crea tu Cuenta</a>
            <a href="/forgot">Olvidaste tu Contraseña</a>
        </div>
    </div>

</div>