```php
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Nuevo producto - Inventario</title>

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

    <div class="mb-4">

        <h2>

            <i class="fa-solid fa-box"></i>

            Nuevo producto

        </h2>

        <p class="text-muted">

            Registrar un nuevo producto en el inventario.

        </p>

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



    <!-- ============================================== -->
    <!-- FORMULARIO NUEVO PRODUCTO -->
    <!-- ============================================== -->

    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="<?= base_url('inventario/guardar') ?>"
                method="post"
            >

                <?= csrf_field() ?>



                <div class="row g-3">



                    <!-- NOMBRE DEL PRODUCTO -->

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
                            value="<?= old('nombre_producto') ?>"
                            placeholder="Ej.: Tela de algodón"
                        >

                    </div>



                    <!-- ================================= -->
                    <!-- CATEGORIA -->
                    <!-- ================================= -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Categoría

                        </label>

                        <div class="input-group">

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
                                        <?= old('id_categoria') == $categoria['id_categoria']
                                            ? 'selected'
                                            : '' ?>
                                    >

                                        <?= esc($categoria['nombre_categoria']) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>



                            <!-- BOTÓN NUEVA CATEGORÍA -->

                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modalNuevaCategoria"
                            >

                                <i class="fa-solid fa-plus"></i>

                                Nueva categoría

                            </button>

                        </div>

                    </div>



                    <!-- ================================= -->
                    <!-- UNIDAD -->
                    <!-- ================================= -->

                    <div class="col-md-4">

                        <label class="form-label">

                            Unidad de medida

                        </label>

                        <select
                            name="unidad_medida"
                            class="form-select"
                            required
                        >

                            <option value="">

                                Seleccione

                            </option>



                            <option
                                value="Unidad"
                                <?= old('unidad_medida') == 'Unidad'
                                    ? 'selected'
                                    : '' ?>
                            >

                                Unidad

                            </option>



                            <option
                                value="Metro"
                                <?= old('unidad_medida') == 'Metro'
                                    ? 'selected'
                                    : '' ?>
                            >

                                Metro

                            </option>



                            <option
                                value="Centímetro"
                                <?= old('unidad_medida') == 'Centímetro'
                                    ? 'selected'
                                    : '' ?>
                            >

                                Centímetro

                            </option>



                            <option
                                value="Rollo"
                                <?= old('unidad_medida') == 'Rollo'
                                    ? 'selected'
                                    : '' ?>
                            >

                                Rollo

                            </option>



                            <option
                                value="Paquete"
                                <?= old('unidad_medida') == 'Paquete'
                                    ? 'selected'
                                    : '' ?>
                            >

                                Paquete

                            </option>

                        </select>

                    </div>



                    <!-- ================================= -->
                    <!-- CANTIDAD INICIAL -->
                    <!-- ================================= -->

                    <div class="col-md-4">

                        <label class="form-label">

                            Cantidad inicial

                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                name="cantidad"
                                class="form-control"
                                min="0"
                                step="0.01"
                                required
                                value="<?= old('cantidad') ?>"
                                placeholder="Ej.: 30"
                            >

                            <span class="input-group-text">

                                Stock inicial

                            </span>

                        </div>

                        <small class="text-muted">

                            Cantidad disponible al registrar el producto.

                        </small>

                    </div>



                    <!-- ================================= -->
                    <!-- PRECIO COMPRA -->
                    <!-- ================================= -->

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
                                value="<?= old('precio_compra') ?>"
                            >

                        </div>

                    </div>



                    <!-- ================================= -->
                    <!-- PRECIO VENTA -->
                    <!-- ================================= -->

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
                                value="<?= old('precio_venta') ?>"
                            >

                        </div>

                    </div>

                </div>



                <!-- ================================= -->
                <!-- BOTONES -->
                <!-- ================================= -->

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fa-solid fa-save"></i>

                        Guardar producto

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



<!-- ================================================= -->
<!-- MODAL NUEVA CATEGORÍA -->
<!-- ================================================= -->

<div
    class="modal fade"
    id="modalNuevaCategoria"
    tabindex="-1"
    aria-labelledby="modalNuevaCategoriaLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">



            <!-- CABECERA -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="modalNuevaCategoriaLabel"
                >

                    <i class="fa-solid fa-folder-plus"></i>

                    Nueva categoría

                </h5>



                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"
                ></button>

            </div>



            <!-- CUERPO -->

            <div class="modal-body">

                <form
                    action="<?= base_url('inventario/guardarCategoria') ?>"
                    method="post"
                >

                    <?= csrf_field() ?>



                    <div class="mb-3">

                        <label class="form-label">

                            Nombre de la categoría

                        </label>

                        <input
                            type="text"
                            name="nombre_categoria"
                            class="form-control"
                            maxlength="50"
                            required
                            placeholder="Ej.: Telas"
                        >

                    </div>



                    <!-- BOTONES -->

                    <div class="d-flex justify-content-end gap-2">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >

                            Cancelar

                        </button>



                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fa-solid fa-save"></i>

                            Guardar categoría

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<!-- BOOTSTRAP -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>
```
