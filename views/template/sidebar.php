<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2 id="pitulo" style="cursor: pointer;">TaskMapp</h2>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>


    <nav class="sidebar-nav">
        <a class="<?php echo ($title === 'Proyectos') ? 'activo' : ''; ?>" href="/dashboard">Mis Listas</a>
        <a class="<?php echo ($title === 'Crear Proyecto') ? 'activo' : ''; ?>" href="/crear-lista">Agregar nueva Lista</a>
        <a class="<?php echo ($title === 'Perfil') ? 'activo' : ''; ?>" href="/perfil">Mi Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>

<script>
    document.getElementById('pitulo').addEventListener('click', function() {
        window.location.href = '/dashboard';
    });
</script>