<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nueva persona</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header">

                    <h4 class="mb-0">
                        Registrar nueva persona
                    </h4>

                </div>

                <div class="card-body">

                    <form action="<?= base_url('personas/guardar') ?>" method="post">

                        <!-- ========================= -->
                        <!-- DATOS PERSONALES -->
                        <!-- ========================= -->

                        <h5 class="mb-3">
                            Datos personales
                        </h5>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Cédula
                                </label>

                                <input
                                    type="text"
                                    name="cedula"
                                    class="form-control"
                                    required
                                >

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    class="form-control"
                                    required
                                >

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Apellido
                                </label>

                                <input
                                    type="text"
                                    name="apellido"
                                    class="form-control"
                                    required
                                >

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    name="telefono"
                                    class="form-control"
                                >

                            </div>


                            <div class="col-12 mb-3">

                                <label class="form-label">
                                    Dirección
                                </label>

                                <input
                                    type="text"
                                    name="direccion"
                                    class="form-control"
                                >

                            </div>

                        </div>


                        <!-- ========================= -->
                        <!-- TIPO DE PERSONA -->
                        <!-- ========================= -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Tipo de persona
                            </label>

                            <div class="border rounded p-3">

                                <?php foreach ($roles as $rol): ?>

                                    <div class="form-check">

                                        <input
                                            class="form-check-input rol-persona"
                                            type="checkbox"
                                            name="roles[]"
                                            value="<?= $rol['id_rol'] ?>"
                                            id="rol<?= $rol['id_rol'] ?>"
                                            data-rol="<?= esc($rol['nombre_rol']) ?>"
                                        >

                                        <label
                                            class="form-check-label"
                                            for="rol<?= $rol['id_rol'] ?>"
                                        >
                                            <?= esc($rol['nombre_rol']) ?>
                                        </label>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>


                        <!-- ========================= -->
                        <!-- INSCRIPCIÓN -->
                        <!-- ========================= -->

                        <div
                            id="seccionInscripcion"
                            class="card border-primary mb-4"
                            style="display: none;"
                        >

                            <div class="card-header bg-primary text-white">

                                <h5 class="mb-0">
                                    Inscripción de alumna
                                </h5>

                            </div>

                            <div class="card-body">

                                <p class="text-muted">
                                    Como esta persona es alumna,
                                    debe ser vinculada a un curso.
                                </p>


                                <div class="mb-3">

                                    <label
                                        for="id_curso"
                                        class="form-label fw-bold"
                                    >
                                        Curso
                                    </label>

                                    <select
                                        name="id_curso"
                                        id="id_curso"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Seleccione un curso
                                        </option>

                                        <?php if (!empty($cursos)): ?>

                                            <?php foreach ($cursos as $curso): ?>

                                                <option
                                                    value="<?= $curso['id_curso'] ?>"
                                                >
                                                    <?= esc($curso['nombre_curso']) ?>
                                                </option>

                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <option value="">
                                                No hay cursos registrados
                                            </option>

                                        <?php endif; ?>

                                    </select>

                                </div>


                                <div class="mb-3">

                                    <label
                                        for="fecha_inscripcion"
                                        class="form-label fw-bold"
                                    >
                                        Fecha de inscripción
                                    </label>

                                    <input
                                        type="date"
                                        name="fecha_inscripcion"
                                        id="fecha_inscripcion"
                                        class="form-control"
                                        value="<?= date('Y-m-d') ?>"
                                    >
                                </div>

<!-- ESTADO DE LA INSCRIPCIÓN -->

<div class="col-md-6 mb-3">

    <label class="form-label">
        Estado de la inscripción
    </label>

    <select
        name="estado_inscripcion"
        class="form-select"
    >

        <option value="Activa" selected>
            Activa
        </option>

        <option value="Inactiva">
            Inactiva
        </option>

    </select>

</div>

                            </div>

                        </div>


                        <!-- ========================= -->
                        <!-- BOTONES -->
                        <!-- ========================= -->

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Guardar
                            </button>


                            <a
                                href="<?= base_url('personas') ?>"
                                class="btn btn-secondary"
                            >
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ========================= -->
<!-- JAVASCRIPT -->
<!-- ========================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const roles = document.querySelectorAll('.rol-persona');

    const seccionInscripcion =
        document.getElementById('seccionInscripcion');

    const curso =
        document.getElementById('id_curso');

    const fecha =
        document.getElementById('fecha_inscripcion');


    function verificarAlumna() {

        let esAlumna = false;

        roles.forEach(function (rol) {

            if (
                rol.checked &&
                rol.dataset.rol.toLowerCase() === 'alumna'
            ) {

                esAlumna = true;

            }

        });


        if (esAlumna) {

            seccionInscripcion.style.display = 'block';

            curso.required = true;
            fecha.required = true;

        } else {

            seccionInscripcion.style.display = 'none';

            curso.required = false;
            fecha.required = false;

            curso.value = '';
            fecha.value = '';

        }

    }


    roles.forEach(function (rol) {

        rol.addEventListener('change', verificarAlumna);

    });


    verificarAlumna();

});

</script>


</body>

</html>