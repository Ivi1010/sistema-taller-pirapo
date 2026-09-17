<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Inventario - Taller de Confección</title>

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
            <h2 class="mb-1">
                <i class="fa-solid fa-boxes-stacked"></i>
                Inventario
            </h2>

            <p class="text-muted mb-0">
                Control de productos y existencias
            </p>
        </div>

        <a
            href="<?= base_url('inventario/nuevo') ?>"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-plus"></i>
            Nuevo producto
        </a>

    </div>


    <!-- MENSAJES -->

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fa-solid fa-circle-check"></i>

            <?= session()->getFlashdata('success') ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= session()->getFlashdata('error') ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- BUSCADOR -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <label class="form-label">
                        Buscar producto
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>

                        <input
                            type="text"
                            id="buscarProducto"
                            class="form-control"
                            placeholder="Ingrese el nombre del producto..."
                        >

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- TABLA -->

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Producto</th>

                            <th>Categoría</th>

                            <th>Unidad</th>

                            <th>Precio compra</th>

                            <th>Precio venta</th>

                            <th>Stock actual</th>

                            <th class="text-center">Acciones</th>

                        </tr>

                    </thead>

                    <tbody id="tablaProductos">

                    <?php if (!empty($productos)): ?>

                        <?php foreach ($productos as $producto): ?>

                            <?php
                                $stock = (float) $producto['stock_actual'];
                            ?>

                            <tr>

                                <td class="nombre-producto">

                                    <strong>
                                        <?= esc($producto['nombre_producto']) ?>
                                    </strong>

                                </td>


                                <td>

                                    <?= esc(
                                        $producto['nombre_categoria']
                                        ?? 'Sin categoría'
                                    ) ?>

                                </td>


                                <td>

                                    <?= esc(
                                        $producto['unidad_medida']
                                        ?? '-'
                                    ) ?>

                                </td>


                                <td>

                                    Gs.
                                    <?= number_format(
                                        $producto['precio_compra'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>


                                <td>

                                    Gs.
                                    <?= number_format(
                                        $producto['precio_venta'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>


                                <td>

                                    <?php if ($stock <= 0): ?>

                                        <span class="badge bg-danger">
                                            Sin stock
                                        </span>

                                    <?php elseif ($stock <= 5): ?>

                                        <span class="badge bg-warning text-dark">
                                            Bajo:
                                            <?= number_format(
                                                $stock,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-success">
                                            <?= number_format(
                                                $stock,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td class="text-center">

                                    <div class="btn-group">

                                        <!-- EDITAR -->

                                        <a
                                            href="<?= base_url(
                                                'inventario/editar/' .
                                                $producto['id_producto']
                                            ) ?>"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Editar"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>


                                        <!-- ENTRADA -->

                                        <a
                                            href="<?= base_url(
                                                'inventario/entrada/' .
                                                $producto['id_producto']
                                            ) ?>"
                                            class="btn btn-sm btn-outline-success"
                                            title="Registrar entrada"
                                        >
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </a>


                                        <!-- SALIDA -->

                                        <a
                                            href="<?= base_url(
                                                'inventario/salida/' .
                                                $producto['id_producto']
                                            ) ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Registrar salida"
                                        >
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </a>


                                        <!-- MOVIMIENTOS -->

                                        <a
                                            href="<?= base_url(
                                                'inventario/movimientos/' .
                                                $producto['id_producto']
                                            ) ?>"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="Ver movimientos"
                                        >
                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted py-4"
                            >

                                <i class="fa-solid fa-box-open fa-2x mb-2"></i>

                                <br>

                                No hay productos registrados.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>

document
    .getElementById('buscarProducto')
    .addEventListener('keyup', function () {

        let texto = this.value.toLowerCase();

        let filas = document.querySelectorAll(
            '#tablaProductos tr'
        );

        filas.forEach(function (fila) {

            let nombre = fila
                .querySelector('.nombre-producto');

            if (!nombre) {
                return;
            }

            let contenido = nombre.textContent.toLowerCase();

            fila.style.display =
                contenido.includes(texto)
                    ? ''
                    : 'none';

        });

    });

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>