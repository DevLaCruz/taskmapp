<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<?php if (count($proyectos) === 0) { ?>
    <p class="no-proyectos">No Hay Listas Aún <a href="/crear-lista">Comienza creando uno</a></p>
<?php } else { ?>
    <ul class="listado-proyectos" id="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) { ?>
            <?php if (!$proyecto->deleted_at) { ?>
                <li class="proyecto" data-proyecto-id="<?php echo $proyecto->id; ?>">
                    <a href="/lista?id=<?php echo $proyecto->url; ?>">
                        <span style="margin-right: 4rem;"><?php echo $proyecto->proyecto; ?></span>
                        <span>Creado el <?php echo date('d/m/Y', strtotime($proyecto->created_at)); ?></span>

                    </a>
                    <div class="botones-proyecto">
                        <a href="#" class="boton-editar" data-id="<?php echo $proyecto->id; ?>">Editar</a>
                        <a href="#" class="boton-eliminar" data-id="<?php echo $proyecto->id; ?>">Eliminar</a>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>

<?php include_once __DIR__  . '/footer-dashboard.php'; ?>

<?php
$script .= '
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="build/js/proyectos.js"></script>
';
?>

<style>
    .botones-proyecto {
        display: table-row;
        gap: 10px;
        margin-top: 5px;
    }

    .boton-editar,
    .boton-eliminar {
        background-color: #333;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        text-align: center;
    }

    .boton-editar:hover {
        background-color: skyblue;
    }

    .boton-eliminar:hover {
        background-color: #d00;
    }
</style>