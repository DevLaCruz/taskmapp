document.addEventListener('DOMContentLoaded', function () {
    console.log('JavaScript cargado correctamente.');

    const botonesEditar = document.querySelectorAll('.boton-editar');
    const botonesEliminar = document.querySelectorAll('.boton-eliminar');

    if (botonesEditar.length > 0) {
        console.log('Botones de editar encontrados:', botonesEditar.length);
    } else {
        console.log('No se encontraron botones de editar.');
    }

    if (botonesEliminar.length > 0) {
        console.log('Botones de eliminar encontrados:', botonesEliminar.length);
    } else {
        console.log('No se encontraron botones de eliminar.');
    }

    // Evento para Editar Proyecto
    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault(); // Evita que el enlace recargue la página
            const proyectoId = this.dataset.id;
            Swal.fire({
                title: 'Editar Lista',
                input: 'text',
                inputPlaceholder: 'Nuevo nombre de la lista',
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: (nuevoNombre) => {
                    if (!nuevoNombre) {
                        Swal.showValidationMessage('El nombre de la lista es obligatorio');
                        return false;
                    }
                    // Aquí haces la petición para editar el proyecto en tu backend
                    return fetch(`/api/proyecto/editar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: proyectoId, nombre: nuevoNombre })
                    }).then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                return result;
                            } else {
                                Swal.showValidationMessage(result.message);
                            }
                        }).catch(() => {
                            Swal.showValidationMessage('Error al editar la lista');
                        });
                }
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire('Guardado!', 'La lista ha sido editado.', 'success').then(() => {
                        location.reload();
                    });
                }
            });
        });
    });

    // Evento para Eliminar Proyecto
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault(); // Evita que el enlace recargue la página
            const proyectoId = this.dataset.id;
            Swal.fire({
                title: '¿Eliminar Lista?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    // Aquí haces la petición para eliminar el proyecto en tu backend
                    fetch(`/api/proyecto/eliminar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: proyectoId })
                    }).then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                Swal.fire('Eliminado!', 'La Lista ha sido eliminada.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', result.message, 'error');
                            }
                        }).catch(() => {
                            Swal.fire('Error!', 'Error al eliminar la lista', 'error');
                        });
                }
            });
        });
    });
});
