<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar persona</title>

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
                        Editar persona
                    </h4>

                </div>

                <div class="card-body">

                    <form
                        action="<?= base_url('personas/actualizar/' . $persona['id_persona']) ?>"
                        method="post"
                    >

                        <div class="row">

                            <!-- CÉDULA -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Cédula
                                </label>

                                <input
                                    type="text"
                                    name="cedula"
                                    class="form-control"
                                    value="<?= esc($persona['cedula']) ?>"
                                    required
                                >

                            </div>


                            <!-- NOMBRE -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    class="form-control"
                                    value="<?= esc($persona['nombre']) ?>"
                                    required
                                >

                            </div>


                            <!-- APELLIDO -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Apellido
                                </label>

                                <input
                                    type="text"
                                    name="apellido"
                                    class="form-control"
                                    value="<?= esc($persona['apellido']) ?>"
                                    required
                                >

                            </div>


                            <!-- TELÉFONO -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    name="telefono"
                                    class="form-control"
                                    value="<?= esc($persona['telefono']) ?>"
                                >

                            </div>


                            <!-- DIRECCIÓN -->

                            <div class="col-12 mb-3">

                                <label class="form-label">
                                    Dirección
                                </label>

                                <input
                                    type="text"
                                    name="direccion"
                                    class="form-control"
                                    value="<?= esc($persona['direccion']) ?>"
                                >

                            </div>


                            <!-- TIPO DE PERSONA -->

                            <div class="col-12 mb-4">

                                <label class="form-label fw-bold">
                                    Tipo de persona
                                </label>

                                <div class="border rounded p-3">

                                    <?php foreach ($roles as $rol): ?>

                                        <?php

                                        $rolMarcado = false;

                                        foreach ($rolesPersona as $rolPersona) {

                                            if (
                                                $rolPersona['id_rol']
                                                == $rol['id_rol']
                                            ) {

                                                $rolMarcado = true;
                                                break;

                                            }

                                        }

                                        ?>

                                        <div class="form-check">

                                            <input
                                                class="form-check-input rol-checkbox"
                                                type="checkbox"
                                                name="roles[]"
                                                value="<?= $rol['id_rol'] ?>"
                                                data-rol="<?= strtolower(esc($rol['nombre_rol'])) ?>"
                                                id="rol<?= $rol['id_rol'] ?>"
                                                <?= $rolMarcado ? 'checked' : '' ?>
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


                            <!-- INSCRIPCIÓN -->

                            <div
                                class="col-12 mb-4"
                                id="seccionInscripcion"
                            >

                                <div class="card border-primary">

                                    <div class="card-header bg-primary text-white">

                                        <strong>
                                            Datos de inscripción
                                        </strong>

                                    </div>

                                    <div class="card-body">

                                        <div class="row">


                                            <!-- CURSO -->

                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Curso
                                                </label>

                                                <select
                                                    name="id_curso"
                                                    class="form-select"
                                                >

                                                    <option value="">
                                                        Seleccionar curso
                                                    </option>

                                                    <?php foreach ($cursos as $curso): ?>

                                                        <option
                                                            value="<?= $curso['id_curso'] ?>"
                                                            <?= (
                                                                !empty($inscripcion)
                                                                &&
                                                                $inscripcion['id_curso']
                                                                == $curso['id_curso']
                                                            )
                                                                ? 'selected'
                                                                : ''
                                                            ?>
                                                        >

                                                            <?= esc($curso['nombre_curso']) ?>

                                                        </option>

                                                    <?php endforeach; ?>

                                                </select>

                                            </div>


                                            <!-- FECHA -->

                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Fecha de inscripción
                                                </label>

                                                <input
                                                    type="date"
                                                    name="fecha_inscripcion"
                                                    class="form-control"
                                                    value="<?= !empty($inscripcion)
                                                        ? esc($inscripcion['fecha_inscripcion'])
                                                        : date('Y-m-d') ?>"
                                                >

                                            </div>


                                            <!-- ESTADO -->

                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Estado
                                                </label>

                                                <select
                                                    name="estado_inscripcion"
                                                    class="form-select"
                                                >

                                                    <option
                                                        value="Activa"
                                                        <?= (
                                                            !empty($inscripcion)
                                                            &&
                                                            $inscripcion['estado'] == 'Activa'
                                                        )
                                                            ? 'selected'
                                                            : ''
                                                        ?>
                                                    >
                                                        Activa
                                                    </option>

                                                    <option
                                                        value="Inactiva"
                                                        <?= (
                                                            !empty($inscripcion)
                                                            &&
                                                            $inscripcion['estado'] == 'Inactiva'
                                                        )
                                                            ? 'selected'
                                                            : ''
                                                        ?>
                                                    >
                                                        Inactiva
                                                    </option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- BOTONES -->

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Guardar cambios
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


<script>

/*
|--------------------------------------------------------------------------
| CONTROL DE INSCRIPCIÓN
|--------------------------------------------------------------------------
*/

const checkboxesRol =
    document.querySelectorAll('.rol-checkbox');

const seccionInscripcion =
    document.getElementById('seccionInscripcion');


function actualizarInscripcion() {

    let esAlumna = false;

    checkboxesRol.forEach(function (checkbox) {

        const rol =
            checkbox.dataset.rol;

        if (
            rol === 'alumna'
            &&
            checkbox.checked
        ) {

            esAlumna = true;

        }

    });


    if (esAlumna) {

        seccionInscripcion.style.display = 'block';

    } else {

        seccionInscripcion.style.display = 'none';

    }

}


/*
|--------------------------------------------------------------------------
| Detectar cambios
|--------------------------------------------------------------------------
*/

checkboxesRol.forEach(function (checkbox) {

    checkbox.addEventListener(
        'change',
        actualizarInscripcion
    );

});


/*
|--------------------------------------------------------------------------
| Ejecutar al cargar la página
|--------------------------------------------------------------------------
*/

actualizarInscripcion();

</script>

</body>

</html>