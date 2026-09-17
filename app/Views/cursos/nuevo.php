<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nuevo curso</title>

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
                        Registrar nuevo curso
                    </h4>

                </div>

                <div class="card-body">

                    <form
                        action="<?= base_url('cursos/guardar') ?>"
                        method="post"
                    >

                        <div class="mb-3">

                            <label class="form-label">
                                Nombre del curso
                            </label>

                            <input
                                type="text"
                                name="nombre_curso"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Descripción
                            </label>

                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="4"
                            ></textarea>

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Guardar
                            </button>

                            <a
                                href="<?= base_url('cursos') ?>"
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

</body>

</html>