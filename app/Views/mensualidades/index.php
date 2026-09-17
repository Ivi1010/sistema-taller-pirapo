<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Mensualidades - Taller de Confección</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <!-- ENCABEZADO -->

    <div class="mb-4">

        <h1>
            Mensualidades
        </h1>

        <p class="text-muted mb-0">
            Control de pagos de las alumnas
        </p>

    </div>


    <!-- BUSCADOR -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <label
                for="buscador"
                class="form-label fw-bold"
            >
                Buscar alumna
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    🔎
                </span>

                <input
                    type="text"
                    id="buscador"
                    class="form-control"
                    placeholder="Buscar por nombre, apellido o cédula..."
                >

            </div>

        </div>

    </div>


    <!-- MENSAJES -->

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>


    <!-- LISTADO DE ALUMNAS -->

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                Alumna
                            </th>

                            <th>
                                Cédula
                            </th>

                            <th>
                                Curso
                            </th>

                            <th class="text-center">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody id="tablaAlumnas">

                    <?php if (!empty($alumnas)): ?>

                        <?php foreach ($alumnas as $alumna): ?>

                            <tr>

                                <!-- ALUMNA -->

                                <td>

                                    <strong>

                                        <?= esc(
                                            $alumna['nombre'] . ' ' .
                                            $alumna['apellido']
                                        ) ?>

                                    </strong>

                                </td>


                                <!-- CÉDULA -->

                                <td>

                                    <?= esc(
                                        $alumna['cedula']
                                    ) ?>

                                </td>


                                <!-- CURSO -->

                                <td>

                                    <?= esc(
                                        $alumna['nombre_curso']
                                    ) ?>

                                </td>


                                <!-- ACCIONES -->

                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- VER PAGOS -->

                                        <a
                                            href="<?= base_url(
                                                'mensualidades/alumna/' .
                                                $alumna['id_inscripcion']
                                            ) ?>"
                                            class="btn btn-sm btn-primary"
                                        >

                                            Ver pagos

                                        </a>


                                        <!-- REGISTRAR MENSUALIDAD -->

                                        <a
                                            href="<?= base_url(
                                                'mensualidades/registrar/' .
                                                $alumna['id_inscripcion']
                                            ) ?>"
                                            class="btn btn-sm btn-success"
                                        >

                                            + Registrar mensualidad

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>


                    <?php else: ?>

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-muted py-4"
                            >

                                No hay alumnas con inscripción activa.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- BUSCADOR -->

<script>

const buscador = document.getElementById('buscador');

const filas = document.querySelectorAll(
    '#tablaAlumnas tr'
);

buscador.addEventListener('keyup', function () {

    const texto = this.value.toLowerCase();

    filas.forEach(function (fila) {

        const contenido =
            fila.textContent.toLowerCase();

        if (contenido.includes(texto)) {

            fila.style.display = '';

        } else {

            fila.style.display = 'none';

        }

    });

});

</script>


</body>

</html>