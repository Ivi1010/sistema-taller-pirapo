<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pagos de <?= esc($alumna['nombre'] . ' ' . $alumna['apellido']) ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>


<div class="container mt-5">


    <!-- ========================================== -->
    <!-- ENCABEZADO -->
    <!-- ========================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1>
                Pagos de la alumna
            </h1>

            <p class="text-muted mb-0">
                Historial de mensualidades
            </p>

        </div>


        <a
            href="<?= base_url('mensualidades') ?>"
            class="btn btn-secondary"
        >
            ← Volver
        </a>

    </div>


    <!-- ========================================== -->
    <!-- MENSAJES -->
    <!-- ========================================== -->

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


    <!-- ========================================== -->
    <!-- DATOS DE LA ALUMNA -->
    <!-- ========================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">

                    <strong>
                        Alumna
                    </strong>

                    <p class="mb-0">

                        <?= esc(
                            $alumna['nombre'] . ' ' .
                            $alumna['apellido']
                        ) ?>

                    </p>

                </div>


                <div class="col-md-4">

                    <strong>
                        Cédula
                    </strong>

                    <p class="mb-0">

                        <?= esc(
                            $alumna['cedula']
                        ) ?>

                    </p>

                </div>


                <div class="col-md-4">

                    <strong>
                        Curso
                    </strong>

                    <p class="mb-0">

                        <?= esc(
                            $alumna['nombre_curso']
                        ) ?>

                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================== -->
    <!-- RESUMEN -->
    <!-- ========================================== -->

    <div class="row mb-4">


        <!-- MENSUALIDADES -->

        <div class="col-md-4 col-lg">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Mensualidades por pagar
                    </h6>

                    <h3>
                        <?= $totalMensualidades ?>
                    </h3>

                    <small class="text-muted">
                        Febrero a noviembre
                    </small>

                </div>

            </div>

        </div>


        <!-- PAGADAS -->

        <div class="col-md-4 col-lg">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pagadas
                    </h6>

                    <h3 class="text-success">
                        <?= $pagadas ?>
                    </h3>

                    <small class="text-muted">
                        Meses pagados
                    </small>

                </div>

            </div>

        </div>


        <!-- PENDIENTES -->

        <div class="col-md-4 col-lg">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pendientes
                    </h6>

                    <h3 class="text-warning">
                        <?= $pendientes ?>
                    </h3>

                    <small class="text-muted">
                        Meses restantes
                    </small>

                </div>

            </div>

        </div>


        <!-- CUENTA PENDIENTE -->

        <div class="col-md-6 col-lg">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Cuenta pendiente
                    </h6>

                    <h3 class="text-danger">

                        Gs.
                        <?= number_format(
                            $cuentaPendiente,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </h3>

                    <small class="text-muted">
                        Monto restante por pagar
                    </small>

                </div>

            </div>

        </div>


        <!-- TOTAL PAGADO -->

        <div class="col-md-6 col-lg">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total pagado
                    </h6>

                    <h3 class="text-success">

                        Gs.
                        <?= number_format(
                            $totalPagado,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </h3>

                    <small class="text-muted">
                        Dinero pagado por la alumna
                    </small>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================== -->
    <!-- HISTORIAL -->
    <!-- ========================================== -->

    <div class="card shadow-sm">

        <div class="card-body">


            <h4 class="mb-4">
                Historial de mensualidades
            </h4>


            <div class="table-responsive">


                <table class="table table-hover align-middle">


                    <thead>

                        <tr>

                            <th>
                                Año
                            </th>

                            <th>
                                Mes
                            </th>

                            <th>
                                Monto
                            </th>

                            <th>
                                Vencimiento
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php

                    $meses = [

                        1  => 'Enero',
                        2  => 'Febrero',
                        3  => 'Marzo',
                        4  => 'Abril',
                        5  => 'Mayo',
                        6  => 'Junio',
                        7  => 'Julio',
                        8  => 'Agosto',
                        9  => 'Septiembre',
                        10 => 'Octubre',
                        11 => 'Noviembre',
                        12 => 'Diciembre'

                    ];

                    ?>


                    <?php if (!empty($mensualidades)): ?>


                        <?php foreach ($mensualidades as $mensualidad): ?>


                            <?php

                            /*
                             * Obtener el pago asociado.
                             */
                            $pago = $mensualidad['pago'] ?? null;


                            /*
                             * Determinar si existe un pago anulado.
                             */
                            $pagoAnulado = (
                                $pago &&
                                $pago['estado'] === 'Anulado'
                            );


                            /*
                             * Determinar si el pago está válido.
                             */
                            $pagoValido = (
                                $pago &&
                                $pago['estado'] === 'Pagado'
                            );

                            ?>


                            <tr>


                                <!-- AÑO -->

                                <td>

                                    <?= esc(
                                        $mensualidad['anio']
                                    ) ?>

                                </td>


                                <!-- MES -->

                                <td>

                                    <?= esc(
                                        $meses[
                                            $mensualidad['mes']
                                        ] ?? 'Desconocido'
                                    ) ?>

                                </td>


                                <!-- MONTO -->

                                <td>

                                    Gs.
                                    <?= number_format(
                                        $mensualidad['monto'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>


                                <!-- VENCIMIENTO -->

                                <td>

                                    <?= date(
                                        'd/m/Y',
                                        strtotime(
                                            $mensualidad[
                                                'fecha_vencimiento'
                                            ]
                                        )
                                    ) ?>

                                </td>


                                <!-- ESTADO -->

                                <td>


                                    <?php if ($pagoAnulado): ?>


                                        <span
                                            class="badge bg-danger"
                                        >

                                            ✕ Anulada

                                        </span>


                                        <?php if (
                                            !empty(
                                                $pago[
                                                    'motivo_anulacion'
                                                ]
                                            )
                                        ): ?>

                                            <br>

                                            <small class="text-muted">

                                                Motivo:
                                                <?= esc(
                                                    $pago[
                                                        'motivo_anulacion'
                                                    ]
                                                ) ?>

                                            </small>

                                        <?php endif; ?>


                                    <?php elseif (
                                        $mensualidad['estado']
                                        === 'Pagada'
                                        && $pagoValido
                                    ): ?>


                                        <span
                                            class="badge bg-success"
                                        >

                                            ✓ Pagada

                                        </span>


                                    <?php elseif (
                                        $mensualidad['estado']
                                        === 'Vencida'
                                    ): ?>


                                        <span
                                            class="badge bg-danger"
                                        >

                                            ⚠ Vencida

                                        </span>


                                    <?php else: ?>


                                        <span
                                            class="badge bg-warning text-dark"
                                        >

                                            Pendiente

                                        </span>


                                    <?php endif; ?>


                                </td>


                                <!-- ACCIONES -->

                                <td>


                                    <?php if (
                                        $mensualidad['estado']
                                        === 'Pagada'
                                        && $pagoValido
                                    ): ?>


                                        <!-- EDITAR -->

                                        <a
                                            href="<?= base_url(
                                                'mensualidades/editar/' .
                                                $mensualidad[
                                                    'id_mensualidad'
                                                ]
                                            ) ?>"
                                            class="btn btn-sm btn-warning mb-1"
                                        >

                                            ✏️ Editar

                                        </a>


                                        <!-- ANULAR -->

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger mb-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalAnular"
                                            data-id="<?= esc(
                                                $mensualidad[
                                                    'id_mensualidad'
                                                ]
                                            ) ?>"
                                            data-mes="<?= esc(
                                                $meses[
                                                    $mensualidad['mes']
                                                ] ?? 'Desconocido'
                                            ) ?>"
                                            data-anio="<?= esc(
                                                $mensualidad['anio']
                                            ) ?>"
                                        >

                                            ✕ Anular

                                        </button>


                                    <?php elseif ($pagoAnulado): ?>


                                        <a
                                            href="<?= base_url(
                                                'mensualidades/registrar/' .
                                                $alumna[
                                                    'id_inscripcion'
                                                ]
                                            ) ?>"
                                            class="btn btn-sm btn-success"
                                        >

                                            💰 Registrar pago

                                        </a>


                                    <?php else: ?>


                                        <span class="text-muted">

                                            Sin pago registrado

                                        </span>


                                    <?php endif; ?>


                                </td>


                            </tr>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >

                                Esta alumna todavía no tiene
                                mensualidades registradas.

                            </td>

                        </tr>


                    <?php endif; ?>


                    </tbody>


                </table>

            </div>


        </div>

    </div>


</div>


<!-- ========================================== -->
<!-- MODAL PARA ANULAR -->
<!-- ========================================== -->

<div
    class="modal fade"
    id="modalAnular"
    tabindex="-1"
    aria-labelledby="modalAnularLabel"
    aria-hidden="true"
>


    <div class="modal-dialog">


        <div class="modal-content">


            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="modalAnularLabel"
                >

                    Anular pago

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"
                ></button>

            </div>


            <form
                id="formAnular"
                method="post"
            >


                <div class="modal-body">


                    <p>

                        Está por anular el pago de:

                    </p>


                    <div class="alert alert-warning">

                        <strong id="mensualidadSeleccionada"></strong>

                    </div>


                    <div class="mb-3">


                        <label
                            for="motivo_anulacion"
                            class="form-label"
                        >

                            Motivo de la anulación

                        </label>


                        <textarea
                            name="motivo_anulacion"
                            id="motivo_anulacion"
                            class="form-control"
                            rows="3"
                            maxlength="255"
                            required
                            placeholder="Ej.: Se registró una mensualidad de más."
                        ></textarea>


                        <small class="text-muted">

                            Indique brevemente por qué se anula
                            el pago.

                        </small>


                    </div>


                </div>


                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >

                        Cancelar

                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        Sí, anular pago

                    </button>


                </div>


            </form>


        </div>

    </div>

</div>


<!-- ========================================== -->
<!-- BOOTSTRAP JAVASCRIPT -->
<!-- ========================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<script>

    const modalAnular =
        document.getElementById('modalAnular');


    modalAnular.addEventListener(
        'show.bs.modal',
        function (event) {

            const boton =
                event.relatedTarget;


            const id =
                boton.getAttribute('data-id');


            const mes =
                boton.getAttribute('data-mes');


            const anio =
                boton.getAttribute('data-anio');


            /*
             * Mostrar la mensualidad
             * que se quiere anular.
             */
            document.getElementById(
                'mensualidadSeleccionada'
            ).textContent =
                mes + ' de ' + anio;


            /*
             * Colocar la URL correcta
             * en el formulario.
             */
            document.getElementById(
                'formAnular'
            ).action =
                '<?= base_url(
                    'mensualidades/anular/'
                ) ?>' + id;


            /*
             * Limpiar el motivo
             * cada vez que se abre.
             */
            document.getElementById(
                'motivo_anulacion'
            ).value = '';

        }
    );

</script>


</body>

</html>