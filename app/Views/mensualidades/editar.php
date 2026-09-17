<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar pago - Taller de Confección</title>

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


                <!-- ENCABEZADO -->

                <div class="card-header">

                    <h4 class="mb-0">

                        ✏️ Editar pago de mensualidad

                    </h4>

                </div>


                <div class="card-body">


                    <!-- MENSAJE DE ERROR -->

                    <?php if (session()->getFlashdata('error')): ?>

                        <div class="alert alert-danger">

                            <?= esc(
                                session()->getFlashdata('error')
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <!-- DATOS DE LA ALUMNA -->

                    <div class="alert alert-light border">

                        <strong>
                            Alumna:
                        </strong>

                        <?= esc(
                            $mensualidad['nombre'] . ' ' .
                            $mensualidad['apellido']
                        ) ?>


                        <br>


                        <strong>
                            Curso:
                        </strong>

                        <?= esc(
                            $mensualidad['nombre_curso']
                        ) ?>

                    </div>


                    <!-- FORMULARIO -->

                    <form
                        action="<?= base_url(
                            'mensualidades/actualizar/' .
                            $mensualidad['id_mensualidad']
                        ) ?>"
                        method="post"
                    >


                        <!-- AÑO -->

                        <div class="mb-3">

                            <label
                                for="anio"
                                class="form-label"
                            >

                                Año del pago

                            </label>


                            <select
                                name="anio"
                                id="anio"
                                class="form-select"
                                required
                            >

                                <?php

                                $anioActual = date('Y');

                                ?>


                                <?php for (
                                    $anio = $anioActual - 2;
                                    $anio <= $anioActual + 3;
                                    $anio++
                                ): ?>

                                    <option
                                        value="<?= $anio ?>"
                                        <?= $anio == $mensualidad['anio']
                                            ? 'selected'
                                            : '' ?>
                                    >

                                        <?= $anio ?>

                                    </option>

                                <?php endfor; ?>

                            </select>

                        </div>


                        <!-- MES -->

                        <div class="mb-3">

                            <label
                                for="mes"
                                class="form-label"
                            >

                                Mes que está pagando

                            </label>


                            <select
                                name="mes"
                                id="mes"
                                class="form-select"
                                required
                            >

                                <?php

                                $meses = [

                                    2  => 'Febrero',
                                    3  => 'Marzo',
                                    4  => 'Abril',
                                    5  => 'Mayo',
                                    6  => 'Junio',
                                    7  => 'Julio',
                                    8  => 'Agosto',
                                    9  => 'Septiembre',
                                    10 => 'Octubre',
                                    11 => 'Noviembre'

                                ];

                                ?>


                                <?php foreach (
                                    $meses as $numero => $nombre
                                ): ?>

                                    <option
                                        value="<?= $numero ?>"
                                        <?= $numero == $mensualidad['mes']
                                            ? 'selected'
                                            : '' ?>
                                    >

                                        <?= $nombre ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- MONTO -->

                        <div class="mb-3">

                            <label
                                for="monto"
                                class="form-label"
                            >

                                Monto de la mensualidad

                            </label>


                            <input
                                type="number"
                                name="monto"
                                id="monto"
                                class="form-control"
                                value="<?= esc(
                                    $mensualidad['monto']
                                ) ?>"
                                min="1"
                                required
                            >


                            <small class="text-muted">

                                Monto registrado para esta mensualidad.

                            </small>

                        </div>


                        <!-- FECHA DE VENCIMIENTO -->
<div class="mb-3">

    <label class="form-label">
        Fecha de vencimiento
    </label>

    <input
        type="text"
        class="form-control"
        value="<?= date(
            'd/m/Y',
            strtotime($mensualidad['fecha_vencimiento'])
        ) ?>"
        readonly
    >

    <small class="text-muted">
        La fecha de vencimiento se determina automáticamente
        según el mes de la mensualidad.
    </small>

</div>

                        <!-- ESTADO -->
<div class="mb-3">
    <label class="form-label">
        Estado
    </label>

    <input
        type="text"
        class="form-control"
        value="<?= esc($mensualidad['estado']) ?>"
        readonly
    >
</div>
                        <!-- FECHA DEL PAGO -->

                        <div class="mb-4">

                            <label
                                for="fecha_pago"
                                class="form-label"
                            >

                                Fecha en que realizó el pago

                            </label>


                            <input
                                type="date"
                                name="fecha_pago"
                                id="fecha_pago"
                                class="form-control"
                                value="<?= esc(
                                    $pago['fecha_pago']
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- BOTONES -->

                        <div class="d-flex gap-2">


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                💾 Guardar cambios

                            </button>


                            <a
                                href="<?= base_url(
                                    'mensualidades/alumna/' .
                                    $mensualidad['id_inscripcion']
                                ) ?>"
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