<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrar pago - Taller de Confección</title>

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
                        Registrar pago de mensualidades
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
                            $alumna['nombre'] . ' ' .
                            $alumna['apellido']
                        ) ?>


                        <br>


                        <strong>
                            Curso:
                        </strong>

                        <?= esc(
                            $alumna['nombre_curso']
                        ) ?>

                    </div>


                    <!-- FORMULARIO -->

                    <form
                        action="<?= base_url('mensualidades/guardar-varios') ?>"
                        method="post"
                        id="formPago"
                    >


                        <!-- ID DE INSCRIPCIÓN -->

                        <input
                            type="hidden"
                            name="id_inscripcion"
                            value="<?= esc(
                                $alumna['id_inscripcion']
                            ) ?>"
                        >


                        <!-- AÑO INICIAL -->

                        <div class="mb-3">

                            <label
                                for="anio"
                                class="form-label fw-bold"
                            >

                                Año inicial

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


                                <option value="">

                                    Seleccionar año

                                </option>


                                <?php for (
                                    $anio = $anioActual;
                                    $anio <= $anioActual + 3;
                                    $anio++
                                ): ?>

                                    <option
                                        value="<?= $anio ?>"
                                        <?= $anio == $anioActual
                                            ? 'selected'
                                            : '' ?>
                                    >

                                        <?= $anio ?>

                                    </option>

                                <?php endfor; ?>

                            </select>


                            <small class="text-muted">

                                Año desde el cual comenzará el pago.

                            </small>

                        </div>


                        <!-- MES INICIAL -->

                        <div class="mb-3">

                            <label
                                for="mes"
                                class="form-label fw-bold"
                            >

                                Mes inicial

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


                                <option value="2">
                                    Febrero
                                </option>

                                <option value="3">
                                    Marzo
                                </option>

                                <option value="4">
                                    Abril
                                </option>

                                <option value="5">
                                    Mayo
                                </option>

                                <option value="6">
                                    Junio
                                </option>

                                <option value="7">
                                    Julio
                                </option>

                                <option value="8">
                                    Agosto
                                </option>

                                <option value="9">
                                    Septiembre
                                </option>

                                <option value="10">
                                    Octubre
                                </option>

                                <option value="11">
                                    Noviembre
                                </option>

                            </select>


                            <small class="text-muted">

                                Las clases son de febrero a noviembre.

                            </small>

                        </div>


                        <!-- CANTIDAD DE MESES -->

                        <div class="mb-3">

                            <label
                                for="cantidad"
                                class="form-label fw-bold"
                            >

                                Cantidad de meses

                            </label>


                            <input
                                type="number"
                                name="cantidad"
                                id="cantidad"
                                class="form-control"
                                min="1"
                                max="30"
                                value="1"
                                required
                            >


                            <small class="text-muted">

                                Puede pagar 1 mes, varios meses,
                                1 año (10 meses), 2 años (20 meses)
                                o 3 años (30 meses).

                            </small>

                        </div>


                        <!-- RESUMEN DEL PAGO -->

                        <div class="card bg-light mb-4">

                            <div class="card-body">


                                <h6 class="fw-bold">

                                    Resumen del pago

                                </h6>


                                <p class="mb-2">

                                    <strong>
                                        Meses a pagar:
                                    </strong>

                                    <span id="cantidadResumen">
                                        1
                                    </span>

                                </p>


                                <p class="mb-2">

                                    <strong>
                                        Precio por mes:
                                    </strong>

                                    Gs. 10.000

                                </p>


                                <p class="mb-0">

                                    <strong>
                                        Total:
                                    </strong>

                                    <span
                                        id="total"
                                        class="text-success fw-bold"
                                    >

                                        Gs. 10.000

                                    </span>

                                </p>

                            </div>

                        </div>


                        <!-- MESES QUE SE PAGARÁN -->

                        <div
                            id="vistaPrevia"
                            class="alert alert-info"
                        >

                            <strong>
                                Meses que se registrarán:
                            </strong>


                            <ul
                                id="listaMeses"
                                class="mb-0 mt-2"
                            >

                                <li>
                                    Seleccione el año y mes inicial.
                                </li>

                            </ul>

                        </div>
                        <!-- FECHA DE PAGO-->

<div class="mb-3">

    <label for="fecha_pago" class="form-label">
        Fecha de pago
    </label>

    <input
        type="date"
        name="fecha_pago"
        id="fecha_pago"
        class="form-control"
        value="<?= date('Y-m-d') ?>"
        required
    >

    <small class="text-muted">
        Ingrese la fecha en que la alumna realizó el pago.
        La fecha de vencimiento se calcula automáticamente.
    </small>

</div>

                        <!-- BOTONES -->

                        <div class="d-flex gap-2">


                            <button
                                type="submit"
                                class="btn btn-success"
                            >

                                ✓ Registrar pago

                            </button>


                            <a
                                href="<?= base_url(
                                    'mensualidades/alumna/' .
                                    $alumna['id_inscripcion']
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


<!-- ========================================== -->
<!-- JAVASCRIPT -->
<!-- ========================================== -->

<script>

const precioMensualidad = 10000;

const anio = document.getElementById('anio');

const mes = document.getElementById('mes');

const cantidad = document.getElementById('cantidad');

const cantidadResumen =
    document.getElementById('cantidadResumen');

const total =
    document.getElementById('total');

const listaMeses =
    document.getElementById('listaMeses');


const nombresMeses = {

    2: 'Febrero',
    3: 'Marzo',
    4: 'Abril',
    5: 'Mayo',
    6: 'Junio',
    7: 'Julio',
    8: 'Agosto',
    9: 'Septiembre',
    10: 'Octubre',
    11: 'Noviembre'

};


const mesesAcademicos = [

    2,
    3,
    4,
    5,
    6,
    7,
    8,
    9,
    10,
    11

];


function actualizarResumen()
{

    let cantidadMeses =
        parseInt(cantidad.value) || 0;


    // ==========================================
    // CALCULAR TOTAL
    // ==========================================

    let totalPagar =
        cantidadMeses * precioMensualidad;


    cantidadResumen.textContent =
        cantidadMeses;


    total.textContent =
        'Gs. ' +
        totalPagar.toLocaleString('es-PY');


    // ==========================================
    // OBTENER AÑO Y MES
    // ==========================================

    let anioSeleccionado =
        parseInt(anio.value);

    let mesSeleccionado =
        parseInt(mes.value);


    listaMeses.innerHTML = '';


    if (
        !anioSeleccionado ||
        !mesSeleccionado ||
        cantidadMeses < 1
    ) {

        const li =
            document.createElement('li');

        li.textContent =
            'Seleccione el año y mes inicial.';

        listaMeses.appendChild(li);

        return;
    }


    // ==========================================
    // BUSCAR POSICIÓN DEL MES
    // ==========================================

    let posicion =
        mesesAcademicos.indexOf(
            mesSeleccionado
        );


    let anioActual =
        anioSeleccionado;


    // ==========================================
    // GENERAR LISTA DE MESES
    // ==========================================

    for (
        let i = 0;
        i < cantidadMeses;
        i++
    ) {

        let mesActual =
            mesesAcademicos[posicion];


        const li =
            document.createElement('li');


        li.textContent =
            nombresMeses[mesActual] +
            ' ' +
            anioActual;


        listaMeses.appendChild(li);


        posicion++;


        // Después de noviembre
        // pasa a febrero del siguiente año

        if (
            posicion >=
            mesesAcademicos.length
        ) {

            posicion = 0;

            anioActual++;

        }

    }

}


// ==========================================
// ACTUALIZAR AL CAMBIAR DATOS
// ==========================================

anio.addEventListener(
    'change',
    actualizarResumen
);


mes.addEventListener(
    'change',
    actualizarResumen
);


cantidad.addEventListener(
    'input',
    actualizarResumen
);


// ==========================================
// MOSTRAR RESUMEN AL CARGAR
// ==========================================

actualizarResumen();

</script>


</body>

</html>