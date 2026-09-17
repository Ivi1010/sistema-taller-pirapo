<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar mensualidad</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-header">

                    <h4 class="mb-0">
                        Registrar mensualidad
                    </h4>

                </div>

                <div class="card-body">

                    <?php if (session()->getFlashdata('error')): ?>

                        <div class="alert alert-danger">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>

                    <?php endif; ?>


                    <form
                        action="<?= base_url('mensualidades/guardar') ?>"
                        method="post"
                    >

                        <!-- ALUMNA -->

                        <div class="mb-3">

                            <label
                                for="id_inscripcion"
                                class="form-label"
                            >
                                Alumna
                            </label>

                            <select
                                name="id_inscripcion"
                                id="id_inscripcion"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Seleccionar alumna
                                </option>

                                <?php foreach ($alumnas as $alumna): ?>

                                    <option
                                        value="<?= $alumna['id_inscripcion'] ?>"
                                    >

                                        <?= esc(
                                            $alumna['apellido'] . ', ' .
                                            $alumna['nombre'] .
                                            ' - ' .
                                            $alumna['nombre_curso']
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- MES -->

                        <div class="mb-3">

                            <label
                                for="mes"
                                class="form-label"
                            >
                                Mes
                            </label>

                            <select
                                name="mes"
                                id="mes"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Seleccionar mes
                                </option>

                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>

                            </select>

                        </div>


                        <!-- MONTO -->

                        <div class="mb-4">

                            <label class="form-label">
                                Monto mensual
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="Gs. 10.000"
                                readonly
                            >

                            <small class="text-muted">
                                El monto mensual es de Gs. 10.000 para todas las alumnas.
                            </small>

                        </div>


                        <!-- BOTONES -->

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Registrar mensualidad
                            </button>

                            <a
                                href="<?= base_url('mensualidades') ?>"
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