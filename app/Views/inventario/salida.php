<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Salida de inventario</title>

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

    <div class="mb-4">

        <h2>

            <i class="fa-solid fa-arrow-up text-danger"></i>

            Salida de inventario

        </h2>

        <p class="text-muted">

            Registrar la salida de unidades del inventario.

        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">


            <!-- INFORMACIÓN PRODUCTO -->

            <div class="alert alert-light border">

                <strong>Producto:</strong>

                <?= esc($producto['nombre_producto']) ?>

                <br>

                <strong>Unidad de medida:</strong>

                <?= esc($producto['unidad_medida']) ?>

                <br>

                <strong>Stock disponible:</strong>

                <span class="badge bg-primary">

                    <?= number_format(
                        $stock,
                        2,
                        ',',
                        '.'
                    ) ?>

                </span>

            </div>


            <?php if ($stock <= 0): ?>

                <div class="alert alert-warning">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                    Este producto no tiene stock disponible.

                </div>

            <?php endif; ?>


            <form
                action="<?= base_url('inventario/guardarSalida') ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <input
                    type="hidden"
                    name="id_producto"
                    value="<?= $producto['id_producto'] ?>"
                >


                <div class="row g-3">


                    <!-- CANTIDAD -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Cantidad
                        </label>

                        <input
                            type="number"
                            name="cantidad"
                            class="form-control"
                            min="0.01"
                            max="<?= $stock ?>"
                            step="0.01"
                            required
                            value="<?= old('cantidad') ?>"
                            <?= $stock <= 0 ? 'disabled' : '' ?>
                        >

                    </div>


                    <!-- FECHA -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="fecha"
                            class="form-control"
                            required
                            value="<?= old(
                                'fecha',
                                date('Y-m-d')
                            ) ?>"
                            <?= $stock <= 0 ? 'disabled' : '' ?>
                        >

                    </div>

                </div>


                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-danger"
                        <?= $stock <= 0 ? 'disabled' : '' ?>
                    >

                        <i class="fa-solid fa-arrow-up"></i>

                        Registrar salida

                    </button>


                    <a
                        href="<?= base_url('inventario') ?>"
                        class="btn btn-secondary"
                    >

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>