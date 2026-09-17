<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cursos - Taller de Confección</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1>Cursos</h1>

            <p class="text-muted">
                Gestión de cursos del taller
            </p>

        </div>

        <a
            href="<?= base_url('cursos/nuevo') ?>"
            class="btn btn-primary"
        >
            + Nuevo curso
        </a>

    </div>


    <div class="card shadow">

        <div class="card-body">

            <?php if (!empty($cursos)): ?>

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Nombre del curso</th>

                                <th>Descripción</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($cursos as $curso): ?>

                                <tr>

                                    <td>
                                        <?= esc($curso['id_curso']) ?>
                                    </td>

                                    <td>
                                        <?= esc($curso['nombre_curso']) ?>
                                    </td>

                                    <td>
                                        <?= esc($curso['descripcion']) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <p class="text-center text-muted mb-0">
                    No hay cursos registrados.
                </p>

            <?php endif; ?>

        </div>

    </div>

</div>

</body>

</html>