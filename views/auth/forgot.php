<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../template/site-name.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Olvidaste tu pass?</p>

        <?php include_once __DIR__ . '/../template/alerts.php'; ?>
        
        <form action="/forgot" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu email" name="email">
            </div>


            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>

        <div class="acciones">
            <a href="/">Ingresa a tu Cuenta</a>
            <a href="/Registrate">Crea una cuenta</a>
        </div>
    </div>

</div>