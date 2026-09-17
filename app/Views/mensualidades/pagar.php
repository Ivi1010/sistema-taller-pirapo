<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrar pago</title>

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
                        Registrar pago de mensualidad
                    </h4>

                </div>

                <div class="card-body">

                    <div class="alert alert-light border">

                        <strong>Alumna:</strong>

                        <?= esc(
                            $mensualidad['nombre'] . ' ' .
                            $mensualidad['apellido']
                        ) ?>

                        <br>

                        <strong>Curso:</strong>

                        <?= esc($mensualidad['nombre_curso']) ?>

                        <br>

                        <strong>Monto de la mensualidad:</strong>

                        Gs.
                        <?= number_format(
                            $mensualidad['monto'],
                            0,
                            ',',
                            '.'
                        ) ?>

                    </div>


                    <form
                        action="<?= base_url('mensualidades/registrar-pago') ?>"
                        method="post"
                    >

                        <input
                            type="hidden"
                            name="id_mensualidad"
                            value="<?= esc(
                                $mensualidad['id_mensualidad']
                            ) ?>"
                        >


                        <div class="mb-3">

                            <label class="form-label">
                                Fecha de pago
                            </label>

                            <input
                                type="date"
                                name="fecha_pago"
                                class="form-control"
                                value="<?= date('Y-m-d') ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Monto pagado
                            </label>

                            <input
                                type="number"
                                name="monto_pagado"
                                class="form-control"
                                value="<?= esc(
                                    $mensualidad['monto']
                                ) ?>"
                                min="1"
                                required
                            >

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Registrar pago
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