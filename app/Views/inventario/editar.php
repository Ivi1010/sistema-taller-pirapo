<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar producto - Inventario</title>

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
            <i class="fa-solid fa-pen"></i>
            Editar producto
        </h2>

        <p class="text-muted">
            Modificar los datos del producto.
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="<?= base_url(
                    'inventario/actualizar/' .
                    $producto['id_producto']
                ) ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <div class="row g-3">


                    <!-- NOMBRE -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Nombre del producto
                        </label>

                        <input
                            type="text"
                            name="nombre_producto"
                            class="form-control"
                            required
                            maxlength="100"
                            value="<?= esc(
                                $producto['nombre_producto']
                            ) ?>"
                        >

                    </div>


                    <!-- CATEGORIA -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Categoría
                        </label>

                        <select
                            name="id_categoria"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccione una categoría
                            </option>

                            <?php foreach ($categorias as $categoria): ?>

                                <option
                                    value="<?= $categoria['id_categoria'] ?>"
                                    <?= $producto['id_categoria'] ==
                                        $categoria['id_categoria']
                                        ? 'selected'
                                        : '' ?>
                                >

                                    <?= esc(
                                        $categoria['nombre_categoria']
                                    ) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- UNIDAD -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Unidad de medida
                        </label>

                        <select
                            name="unidad_medida"
                            class="form-select"
                            required
                        >

                            <?php
                            $unidades = [
                                'Unidad',
                                'Metro',
                                'Centímetro',
                                'Rollo',
                                'Paquete'
                            ];
                            ?>

                            <?php foreach ($unidades as $unidad): ?>

                                <option
                                    value="<?= $unidad ?>"
                                    <?= $producto['unidad_medida'] ==
                                        $unidad
                                        ? 'selected'
                                        : '' ?>
                                >

                                    <?= $unidad ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- PRECIO COMPRA -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Precio de compra
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Gs.
                            </span>

                            <input
                                type="number"
                                name="precio_compra"
                                class="form-control"
                                min="0"
                                step="1"
                                required
                                value="<?= esc(
                                    $producto['precio_compra']
                                ) ?>"
                            >

                        </div>

                    </div>


                    <!-- PRECIO VENTA -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Precio de venta
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Gs.
                            </span>

                            <input
                                type="number"
                                name="precio_venta"
                                class="form-control"
                                min="0"
                                step="1"
                                required
                                value="<?= esc(
                                    $producto['precio_venta']
                                ) ?>"
                            >

                        </div>

                    </div>

                </div>


                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fa-solid fa-save"></i>
                        Actualizar producto

                    </button>


                    <a
                        href="<?= base_url('inventario') ?>"
                        class="btn btn-secondary"
                    >

                        <i class="fa-solid fa-arrow-left"></i>
                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>