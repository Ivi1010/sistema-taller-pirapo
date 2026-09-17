<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Personas - Taller de Confección</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        /* BOTONES DE FILTRO */

        .filtros-personas {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .filtro-btn {
            border: 1px solid #dee2e6;
            background-color: #fff;
            color: #495057;
            padding: 7px 18px;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.2s;
        }

        .filtro-btn:hover {
            background-color: #f1f3f5;
        }

        .filtro-btn.activo {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

    </style>

</head>

<body>

<div class="container mt-5">

    <!-- ENCABEZADO -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1>Personas</h1>

            <p class="text-muted">
                Gestión de personas registradas
            </p>

        </div>

        <a
            href="<?= base_url('personas/nueva') ?>"
            class="btn btn-primary"
        >
            + Nueva persona
        </a>

    </div>


    <div class="card">

        <div class="card-body">


            <!-- FILTROS -->

            <div class="filtros-personas">

                <button
                    type="button"
                    class="filtro-btn activo"
                    data-filtro="todas"
                >
                    Todas
                </button>

                <button
                    type="button"
                    class="filtro-btn"
                    data-filtro="alumna"
                >
                    Alumnas
                </button>

                <button
                    type="button"
                    class="filtro-btn"
                    data-filtro="cliente"
                >
                    Clientes
                </button>

            </div>


            <!-- BUSCADOR -->

            <div class="col-md-6 mb-4">

                <label
                    for="buscador"
                    class="form-label"
                >
                    Buscar persona
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        🔎
                    </span>

                    <input
                        type="text"
                        id="buscador"
                        class="form-control"
                        placeholder="Cédula, nombre o apellido..."
                    >

                </div>

            </div>


            <!-- TABLA -->

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Cédula</th>

                            <th>Nombre</th>

                            <th>Apellido</th>

                            <th>Teléfono</th>

                            <th>Dirección</th>

                            <th>Tipo</th>

                            <th>Curso</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($personas)): ?>

                            <?php foreach ($personas as $persona): ?>

                                <?php

                                /*
                                 * Convertimos los roles a minúsculas
                                 * para poder hacer el filtro.
                                 */

                                $rolesPersona = strtolower(
                                    $persona['roles'] ?? ''
                                );

                                ?>

                                <tr
                                    data-roles="<?= esc($rolesPersona) ?>"
                                >

                                    <td>
                                        <?= esc($persona['id_persona']) ?>
                                    </td>

                                    <td>
                                        <?= esc($persona['cedula']) ?>
                                    </td>

                                    <td>
                                        <?= esc($persona['nombre']) ?>
                                    </td>

                                    <td>
                                        <?= esc($persona['apellido']) ?>
                                    </td>

                                    <td>
                                        <?= esc($persona['telefono']) ?>
                                    </td>

                                    <td>
                                        <?= esc($persona['direccion']) ?>
                                    </td>


                                    <!-- TIPO -->

                                    <td>

                                        <?php if (!empty($persona['roles'])): ?>

                                            <?= esc($persona['roles']) ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Sin rol
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- CURSO -->

                                    <td>

                                        <?php if (!empty($persona['nombre_curso'])): ?>

                                            <?= esc($persona['nombre_curso']) ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                No corresponde
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if (!empty($persona['estado_inscripcion'])): ?>

                                            <?php if ($persona['estado_inscripcion'] === 'Activa'): ?>

                                                <span class="badge bg-success">
                                                    Activa
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-secondary">
                                                    Inactiva
                                                </span>

                                            <?php endif; ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                No corresponde
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- ACCIONES -->

                                    <td>

                                        <a
                                            href="<?= base_url('personas/editar/' . $persona['id_persona']) ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="<?= base_url('personas/eliminar/' . $persona['id_persona']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Está segura de que desea eliminar esta persona?')"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center text-muted"
                                >
                                    No hay personas registradas.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| FILTROS DE PERSONAS
|--------------------------------------------------------------------------
*/

const botonesFiltro =
    document.querySelectorAll('.filtro-btn');

const filas =
    document.querySelectorAll('tbody tr');

let filtroActual = 'todas';


botonesFiltro.forEach(function (boton) {

    boton.addEventListener('click', function () {

        /*
         * Quitamos el estado activo
         * de todos los botones.
         */

        botonesFiltro.forEach(function (b) {

            b.classList.remove('activo');

        });


        /*
         * Activamos el botón seleccionado.
         */

        this.classList.add('activo');


        /*
         * Guardamos el filtro seleccionado.
         */

        filtroActual =
            this.dataset.filtro;


        aplicarFiltros();

    });

});


/*
|--------------------------------------------------------------------------
| BUSCADOR
|--------------------------------------------------------------------------
*/

const buscador =
    document.getElementById('buscador');


buscador.addEventListener('keyup', function () {

    aplicarFiltros();

});


/*
|--------------------------------------------------------------------------
| FUNCIÓN PRINCIPAL DE FILTRADO
|--------------------------------------------------------------------------
*/

function aplicarFiltros() {

    const texto =
        buscador.value.toLowerCase().trim();


    filas.forEach(function (fila) {

        const contenido =
            fila.textContent.toLowerCase();

        const roles =
            fila.dataset.roles || '';


        /*
         * Comprobar categoría
         */

        let coincideCategoria = false;


        if (filtroActual === 'todas') {

            coincideCategoria = true;

        }
        else if (filtroActual === 'alumna') {

            coincideCategoria =
                roles.includes('alumna');

        }
        else if (filtroActual === 'cliente') {

            coincideCategoria =
                roles.includes('cliente');

        }


        /*
         * Comprobar buscador
         */

        const coincideBusqueda =
            contenido.includes(texto);


        /*
         * Mostrar u ocultar fila
         */

        if (
            coincideCategoria &&
            coincideBusqueda
        ) {

            fila.style.display = '';

        }
        else {

            fila.style.display = 'none';

        }

    });

}

</script>

</body>

</html>