<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Movimientos de inventario</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

</head>

<body>

<div class="container py-4">


    <!-- ENCABEZADO -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>

                <i class="fa-solid fa-clock-rotate-left"></i>

                Historial de movimientos

            </h2>

            <p class="text-muted mb-0">

                <?= esc($producto['nombre_producto']) ?>

            </p>

        </div>


        <a
            href="<?= base_url('inventario') ?>"
            class="btn btn-secondary"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver

        </a>

    </div>


    <!-- INFORMACIÓN -->

    <div class="row mb-4">


        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Producto
                    </small>

                    <h5 class="mt-1">

                        <?= esc(
                            $producto['nombre_producto']
                        ) ?>

                    </h5>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Unidad de medida
                    </small>

                    <h5 class="mt-1">

                        <?= esc(
                            $producto['unidad_medida']
                        ) ?>

                    </h5>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Stock actual
                    </small>

                    <h5 class="mt-1">

                        <?= number_format(
                            $stock,
                            2,
                            ',',
                            '.'
                        ) ?>

                    </h5>

                </div>

            </div>

        </div>

    </div>


    <!-- TABLA -->

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">

                Movimientos registrados

            </h5>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Fecha</th>

                            <th>Tipo</th>

                            <th>Cantidad</th>

                            <th>Movimiento</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (!empty($movimientos)): ?>

                        <?php foreach ($movimientos as $movimiento): ?>

                            <tr>

                                <td>

                                    <?= date(
                                        'd/m/Y',
                                        strtotime(
                                            $movimiento['fecha']
                                        )
                                    ) ?>

                                </td>


                                <td>

                                    <?php if (
                                        $movimiento['tipo_movimiento']
                                        === 'Entrada'
                                    ): ?>

                                        <span
                                            class="badge bg-success"
                                        >

                                            <i
                                                class="fa-solid fa-arrow-down"
                                            ></i>

                                            Entrada

                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge bg-danger"
                                        >

                                            <i
                                                class="fa-solid fa-arrow-up"
                                            ></i>

                                            Salida

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?= number_format(
                                        $movimiento['cantidad'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>

                                    <?= esc(
                                        $producto['unidad_medida']
                                    ) ?>

                                </td>


                                <td>

                                    <?php if (
                                        $movimiento['tipo_movimiento']
                                        === 'Entrada'
                                    ): ?>

                                        <span class="text-success">

                                            +
                                            <?= number_format(
                                                $movimiento['cantidad'],
                                                2,
                                                ',',
                                                '.'
                                            ) ?>

                                        </span>

                                    <?php else: ?>

                                        <span class="text-danger">

                                            -
                                            <?= number_format(
                                                $movimiento['cantidad'],
                                                2,
                                                ',',
                                                '.'
                                            ) ?>

                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-muted py-4"
                            >

                                <i
                                    class="fa-solid fa-box-open fa-2x mb-2"
                                ></i>

                                <br>

                                No existen movimientos registrados
                                para este producto.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>