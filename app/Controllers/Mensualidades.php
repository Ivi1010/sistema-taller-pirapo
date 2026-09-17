<?php

namespace App\Controllers;

use App\Models\MensualidadModel;
use App\Models\PagoMensualidadModel;
use App\Models\InscripcionModel;

class Mensualidades extends BaseController
{
    protected $mensualidadModel;
    protected $pagoMensualidadModel;
    protected $inscripcionModel;

    public function __construct()
    {
        $this->mensualidadModel = new MensualidadModel();
        $this->pagoMensualidadModel = new PagoMensualidadModel();
        $this->inscripcionModel = new InscripcionModel();
    }


    // =====================================================
    // LISTADO DE ALUMNAS
    // =====================================================

    public function index()
    {
        // Actualizar estados de mensualidades vencidas
        $this->actualizarVencimientos();

        $alumnas = $this->inscripcionModel
            ->select('
                inscripcion.id_inscripcion,
                persona.id_persona,
                persona.cedula,
                persona.nombre,
                persona.apellido,
                curso.nombre_curso
            ')
            ->join(
                'persona',
                'persona.id_persona = inscripcion.id_persona'
            )
            ->join(
                'curso',
                'curso.id_curso = inscripcion.id_curso'
            )
            ->where(
                'inscripcion.estado',
                'Activa'
            )
            ->orderBy(
                'persona.apellido',
                'ASC'
            )
            ->orderBy(
                'persona.nombre',
                'ASC'
            )
            ->findAll();

        return view(
            'mensualidades/index',
            [
                'alumnas' => $alumnas
            ]
        );
    }


    // =====================================================
    // ACTUALIZAR MENSUALIDADES VENCIDAS
    // =====================================================

    private function actualizarVencimientos()
    {
        $hoy = date('Y-m-d');

        $this->mensualidadModel
            ->where('estado', 'Pendiente')
            ->where('fecha_vencimiento <', $hoy)
            ->set([
                'estado' => 'Vencida'
            ])
            ->update();
    }


    // =====================================================
    // MOSTRAR FORMULARIO PARA REGISTRAR MENSUALIDADES
    // =====================================================

    public function registrar($idInscripcion)
    {
        $alumna = $this->inscripcionModel
            ->select('
                inscripcion.id_inscripcion,
                persona.nombre,
                persona.apellido,
                curso.nombre_curso
            ')
            ->join(
                'persona',
                'persona.id_persona = inscripcion.id_persona'
            )
            ->join(
                'curso',
                'curso.id_curso = inscripcion.id_curso'
            )
            ->where(
                'inscripcion.id_inscripcion',
                $idInscripcion
            )
            ->where(
                'inscripcion.estado',
                'Activa'
            )
            ->first();

        if (!$alumna) {
            return redirect()
                ->to('/mensualidades')
                ->with(
                    'error',
                    'No se encontró la alumna.'
                );
        }

        return view(
            'mensualidades/registrar',
            [
                'alumna' => $alumna
            ]
        );
    }

// =====================================================
// REGISTRAR UNA O VARIAS MENSUALIDADES
// =====================================================

public function guardarVarios()
{
    $idInscripcion = $this->request->getPost(
        'id_inscripcion'
    );

    $anioInicial = (int) $this->request->getPost(
        'anio'
    );

    $mesInicial = (int) $this->request->getPost(
        'mes'
    );

    $cantidad = (int) $this->request->getPost(
        'cantidad'
    );

    $fechaPago = $this->request->getPost(
        'fecha_pago'
    );


    // =================================================
    // VALIDAR DATOS
    // =================================================

    if (
        empty($idInscripcion) ||
        empty($anioInicial) ||
        empty($mesInicial) ||
        empty($cantidad) ||
        empty($fechaPago)
    ) {
        return redirect()
            ->back()
            ->with(
                'error',
                'Debe completar todos los campos.'
            );
    }


    // =================================================
    // VALIDAR AÑO
    // =================================================

    if (
        $anioInicial < 2020 ||
        $anioInicial > 2100
    ) {
        return redirect()
            ->back()
            ->with(
                'error',
                'El año seleccionado no es válido.'
            );
    }


    // =================================================
    // VALIDAR MES
    // =================================================

    if (
        $mesInicial < 2 ||
        $mesInicial > 11
    ) {
        return redirect()
            ->back()
            ->with(
                'error',
                'El mes debe estar entre febrero y noviembre.'
            );
    }


    // =================================================
    // VALIDAR CANTIDAD
    // =================================================

    if (
        $cantidad < 1 ||
        $cantidad > 30
    ) {
        return redirect()
            ->back()
            ->with(
                'error',
                'La cantidad de meses no es válida.'
            );
    }


    // =================================================
    // VERIFICAR INSCRIPCIÓN
    // =================================================

    $inscripcion = $this->inscripcionModel
        ->where(
            'id_inscripcion',
            $idInscripcion
        )
        ->where(
            'estado',
            'Activa'
        )
        ->first();

    if (!$inscripcion) {
        return redirect()
            ->to('/mensualidades')
            ->with(
                'error',
                'La alumna no tiene una inscripción activa.'
            );
    }


    // =================================================
    // CONFIGURACIÓN
    // =================================================

    $montoMensualidad = 10000;

    $mesesAcademicos = [
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


    // =================================================
    // GENERAR PERIODOS
    // =================================================

    $periodos = [];

    $anio = $anioInicial;

    $posicionMes = array_search(
        $mesInicial,
        $mesesAcademicos
    );

    for (
        $i = 0;
        $i < $cantidad;
        $i++
    ) {

        $mes = $mesesAcademicos[$posicionMes];

        $periodos[] = [
            'anio' => $anio,
            'mes' => $mes
        ];

        $posicionMes++;

        if (
            $posicionMes >=
            count($mesesAcademicos)
        ) {
            $posicionMes = 0;
            $anio++;
        }
    }


    // =================================================
    // VERIFICAR MENSUALIDADES
    // =================================================

    $nombreMeses = [
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre'
    ];


    foreach ($periodos as $periodo) {

        $existe = $this->mensualidadModel
            ->where(
                'id_inscripcion',
                $idInscripcion
            )
            ->where(
                'mes',
                $periodo['mes']
            )
            ->where(
                'anio',
                $periodo['anio']
            )
            ->first();


        /*
         * Si existe una mensualidad:
         *
         * - Pagada  → no se puede volver a pagar.
         * - Pendiente/Vencida → se puede pagar.
         *
         * Esto permite volver a pagar después
         * de una anulación.
         */

        if (
            $existe &&
            $existe['estado'] === 'Pagada'
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'La mensualidad de ' .
                    $nombreMeses[$periodo['mes']] .
                    ' de ' .
                    $periodo['anio'] .
                    ' ya está pagada.'
                );
        }
    }


    // =================================================
    // GUARDAR
    // =================================================

    $db = \Config\Database::connect();

    $db->transStart();


    foreach ($periodos as $periodo) {

        $fechaVencimiento = sprintf(
            '%04d-%02d-10',
            $periodo['anio'],
            $periodo['mes']
        );


        /*
         * Buscar si ya existe la mensualidad.
         */
        $mensualidad = $this->mensualidadModel
            ->where(
                'id_inscripcion',
                $idInscripcion
            )
            ->where(
                'mes',
                $periodo['mes']
            )
            ->where(
                'anio',
                $periodo['anio']
            )
            ->first();


        // =================================================
        // SI YA EXISTE
        // =================================================

        if ($mensualidad) {

            /*
             * La mensualidad puede existir porque
             * anteriormente fue anulada.
             *
             * No creamos otra mensualidad.
             * Reutilizamos la existente.
             */

            $idMensualidad =
                $mensualidad['id_mensualidad'];


            $this->mensualidadModel->update(
                $idMensualidad,
                [
                    'monto' =>
                        $montoMensualidad,

                    'fecha_vencimiento' =>
                        $fechaVencimiento,

                    'estado' =>
                        'Pagada'
                ]
            );


        } else {


            // =================================================
            // SI NO EXISTE, CREAR MENSUALIDAD
            // =================================================

            $idMensualidad =
                $this->mensualidadModel->insert(
                    [
                        'id_inscripcion' =>
                            $idInscripcion,

                        'mes' =>
                            $periodo['mes'],

                        'anio' =>
                            $periodo['anio'],

                        'monto' =>
                            $montoMensualidad,

                        'fecha_vencimiento' =>
                            $fechaVencimiento,

                        'estado' =>
                            'Pagada'
                    ],
                    true
                );
        }


        // =================================================
        // CREAR NUEVO PAGO
        // =================================================

        /*
         * IMPORTANTE:
         *
         * No modificamos el pago anterior.
         *
         * Si existía un pago Anulado,
         * queda guardado como historial.
         *
         * Aquí creamos un nuevo pago válido.
         */

        $this->pagoMensualidadModel->insert(
            [
                'id_mensualidad' =>
                    $idMensualidad,

                'fecha_pago' =>
                    $fechaPago,

                'monto_pagado' =>
                    $montoMensualidad,

                'estado' =>
                    'Pagado'
            ]
        );
    }


    $db->transComplete();


    // =================================================
    // VERIFICAR TRANSACCIÓN
    // =================================================

    if ($db->transStatus() === false) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Ocurrió un error al registrar los pagos.'
            );
    }


    // =================================================
    // TOTAL
    // =================================================

    $total =
        $cantidad *
        $montoMensualidad;


    return redirect()
        ->to(
            '/mensualidades/alumna/' .
            $idInscripcion
        )
        ->with(
            'success',
            'Se registraron ' .
            $cantidad .
            ' mensualidades correctamente. Total pagado: Gs. ' .
            number_format(
                $total,
                0,
                ',',
                '.'
            )
        );
}

// =====================================================
// VER HISTORIAL DE UNA ALUMNA
// =====================================================
public function alumna($idInscripcion)
{
    $alumna = $this->inscripcionModel
        ->select('
            inscripcion.id_inscripcion,
            persona.cedula,
            persona.nombre,
            persona.apellido,
            curso.nombre_curso
        ')
        ->join(
            'persona',
            'persona.id_persona = inscripcion.id_persona'
        )
        ->join(
            'curso',
            'curso.id_curso = inscripcion.id_curso'
        )
        ->where(
            'inscripcion.id_inscripcion',
            $idInscripcion
        )
        ->first();

    if (!$alumna) {
        return redirect()
            ->to('/mensualidades')
            ->with(
                'error',
                'No se encontró la alumna.'
            );
    }

    $mensualidades = $this->mensualidadModel
        ->where(
            'id_inscripcion',
            $idInscripcion
        )
        ->orderBy('anio', 'ASC')
        ->orderBy('mes', 'ASC')
        ->findAll();

    $mesesAcademicos = [
        2, 3, 4, 5,
        6, 7, 8,
        9, 10, 11
    ];

    $pagadas = 0;
    $totalPagado = 0;

    /*
     * Agregamos información del pago
     * a cada mensualidad.
     */
    foreach ($mensualidades as &$mensualidad) {

$pago = $this->pagoMensualidadModel
    ->where(
        'id_mensualidad',
        $mensualidad['id_mensualidad']
    )
    ->orderBy(
        'id_pago',
        'DESC'
    )
    ->first();

        $mensualidad['pago'] = $pago;

        /*
         * Si la mensualidad está pagada
         * y el pago también está válido,
         * contamos el pago.
         */
        if (
            $mensualidad['estado'] === 'Pagada'
            && $pago
            && $pago['estado'] === 'Pagado'
        ) {
            $pagadas++;

            $totalPagado += (float)
                $pago['monto_pagado'];
        }
    }

    unset($mensualidad);

    /*
     * En el año académico existen
     * 10 mensualidades:
     * febrero a noviembre.
     */
    $totalMensualidades = 10;

    /*
     * Una mensualidad anulada vuelve
     * a estar pendiente.
     */
    $pendientes =
        $totalMensualidades - $pagadas;

    if ($pendientes < 0) {
        $pendientes = 0;
    }

    /*
     * Monto de cada mensualidad.
     */
    $montoMensualidad = 10000;

    /*
     * Cuenta pendiente.
     */
    $cuentaPendiente =
        $pendientes * $montoMensualidad;

    return view(
        'mensualidades/alumna',
        [
            'alumna' => $alumna,
            'mensualidades' => $mensualidades,
            'totalMensualidades' => $totalMensualidades,
            'pagadas' => $pagadas,
            'pendientes' => $pendientes,
            'cuentaPendiente' => $cuentaPendiente,
            'totalPagado' => $totalPagado
        ]
    );
}
// =====================================================
// MOSTRAR FORMULARIO DE EDICIÓN
// =====================================================

public function editar($idMensualidad)
{
    $mensualidad = $this->mensualidadModel
        ->select('
            mensualidad.*,
            persona.nombre,
            persona.apellido,
            curso.nombre_curso
        ')
        ->join(
            'inscripcion',
            'inscripcion.id_inscripcion = mensualidad.id_inscripcion'
        )
        ->join(
            'persona',
            'persona.id_persona = inscripcion.id_persona'
        )
        ->join(
            'curso',
            'curso.id_curso = inscripcion.id_curso'
        )
        ->where(
            'mensualidad.id_mensualidad',
            $idMensualidad
        )
        ->first();

    if (!$mensualidad) {

        return redirect()
            ->to('/mensualidades')
            ->with(
                'error',
                'La mensualidad no existe.'
            );
    }


    /*
     * Buscar solamente el último pago válido.
     *
     * Si anteriormente hubo un pago anulado,
     * no queremos cargar ese pago en el formulario.
     */
    $pago = $this->pagoMensualidadModel
        ->where(
            'id_mensualidad',
            $idMensualidad
        )
        ->where(
            'estado',
            'Pagado'
        )
        ->orderBy(
            'id_pago',
            'DESC'
        )
        ->first();


    /*
     * Si no existe un pago válido,
     * no permitimos editar como si estuviera pagado.
     */
    if (!$pago) {

        return redirect()
            ->to(
                '/mensualidades/alumna/' .
                $mensualidad['id_inscripcion']
            )
            ->with(
                'error',
                'No existe un pago válido para editar.'
            );
    }


    return view(
        'mensualidades/editar',
        [
            'mensualidad' =>
                $mensualidad,

            'pago' =>
                $pago
        ]
    );
}
// =====================================================
// ACTUALIZAR MENSUALIDAD Y PAGO
// =====================================================

public function actualizar($idMensualidad)
{
    $mes = (int) $this->request->getPost(
        'mes'
    );

    $anio = (int) $this->request->getPost(
        'anio'
    );

    $monto = (float) $this->request->getPost(
        'monto'
    );

    $fechaPago = $this->request->getPost(
        'fecha_pago'
    );


    // =================================================
    // BUSCAR MENSUALIDAD
    // =================================================

    $mensualidad = $this->mensualidadModel
        ->find($idMensualidad);

    if (!$mensualidad) {

        return redirect()
            ->to('/mensualidades')
            ->with(
                'error',
                'La mensualidad no existe.'
            );
    }


    // =================================================
    // VALIDAR DATOS
    // =================================================

    if (
        empty($mes) ||
        empty($anio) ||
        empty($monto) ||
        empty($fechaPago)
    ) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Debe completar todos los campos.'
            );
    }


    // =================================================
    // VALIDAR MES
    // =================================================

    if (
        $mes < 2 ||
        $mes > 11
    ) {

        return redirect()
            ->back()
            ->with(
                'error',
                'El mes debe estar entre febrero y noviembre.'
            );
    }


    // =================================================
    // VALIDAR AÑO
    // =================================================

    if (
        $anio < 2020 ||
        $anio > 2100
    ) {

        return redirect()
            ->back()
            ->with(
                'error',
                'El año seleccionado no es válido.'
            );
    }


    // =================================================
    // VALIDAR MONTO
    // =================================================

    if ($monto <= 0) {

        return redirect()
            ->back()
            ->with(
                'error',
                'El monto debe ser mayor a cero.'
            );
    }


    // =================================================
    // VERIFICAR DUPLICADO
    // =================================================

    $duplicado = $this->mensualidadModel
        ->where(
            'id_inscripcion',
            $mensualidad['id_inscripcion']
        )
        ->where(
            'anio',
            $anio
        )
        ->where(
            'mes',
            $mes
        )
        ->where(
            'id_mensualidad !=',
            $idMensualidad
        )
        ->first();

    if ($duplicado) {

        return redirect()
            ->back()
            ->with(
                'error',
                'La alumna ya tiene registrada una mensualidad para ese mes y año.'
            );
    }


    // =================================================
    // FECHA DE VENCIMIENTO
    // =================================================

    /*
     * La fecha de vencimiento siempre es
     * el día 10 del mes correspondiente.
     *
     * El usuario no la modifica manualmente.
     */

    $fechaVencimiento = sprintf(
        '%04d-%02d-10',
        $anio,
        $mes
    );


    // =================================================
    // BUSCAR ÚLTIMO PAGO VÁLIDO
    // =================================================

    $pago = $this->pagoMensualidadModel
        ->where(
            'id_mensualidad',
            $idMensualidad
        )
        ->where(
            'estado',
            'Pagado'
        )
        ->orderBy(
            'id_pago',
            'DESC'
        )
        ->first();


    if (!$pago) {

        return redirect()
            ->back()
            ->with(
                'error',
                'No se encontró un pago válido para actualizar.'
            );
    }


    // =================================================
    // INICIAR TRANSACCIÓN
    // =================================================

    $db = \Config\Database::connect();

    $db->transStart();


    // =================================================
    // ACTUALIZAR MENSUALIDAD
    // =================================================

    $this->mensualidadModel->update(
        $idMensualidad,
        [
            'mes' =>
                $mes,

            'anio' =>
                $anio,

            'monto' =>
                $monto,

            'fecha_vencimiento' =>
                $fechaVencimiento,

            'estado' =>
                'Pagada'
        ]
    );


    // =================================================
    // ACTUALIZAR PAGO VÁLIDO
    // =================================================

    $this->pagoMensualidadModel->update(
        $pago['id_pago'],
        [
            'fecha_pago' =>
                $fechaPago,

            'monto_pagado' =>
                $monto,

            'estado' =>
                'Pagado'
        ]
    );


    $db->transComplete();


    // =================================================
    // VERIFICAR TRANSACCIÓN
    // =================================================

    if ($db->transStatus() === false) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Ocurrió un error al actualizar la mensualidad.'
            );
    }


    // =================================================
    // VOLVER AL HISTORIAL
    // =================================================

    return redirect()
        ->to(
            '/mensualidades/alumna/' .
            $mensualidad['id_inscripcion']
        )
        ->with(
            'success',
            'La mensualidad fue actualizada correctamente.'
        );
}

// ANULAR PAGO DE MENSUALIDAD
public function anular($idMensualidad)
{
    // Buscar la mensualidad
    $mensualidad = $this->mensualidadModel
        ->find($idMensualidad);

    if (!$mensualidad) {
        return redirect()
            ->to('/mensualidades')
            ->with('error', 'La mensualidad no existe.');
    }

    // Verificar que la mensualidad esté pagada
    if ($mensualidad['estado'] !== 'Pagada') {
        return redirect()
            ->back()
            ->with('error', 'Esta mensualidad no está pagada y no puede ser anulada.');
    }

    // Buscar el pago relacionado
 $pago = $this->pagoMensualidadModel
    ->where(
        'id_mensualidad',
        $idMensualidad
    )
    ->where(
        'estado',
        'Pagado'
    )
    ->orderBy(
        'id_pago',
        'DESC'
    )
    ->first();

    if (!$pago) {
        return redirect()
            ->back()
            ->with('error', 'No se encontró un pago válido para anular.');
    }

    // Obtener motivo
    $motivo = trim(
        $this->request->getPost('motivo_anulacion')
    );

    if (empty($motivo)) {
        return redirect()
            ->back()
            ->with('error', 'Debe indicar el motivo de la anulación.');
    }

    // Conectar a la base de datos
    $db = \Config\Database::connect();

    // Iniciar transacción
    $db->transStart();

    // Cambiar la mensualidad nuevamente a pendiente
    $this->mensualidadModel->update(
        $idMensualidad,
        [
            'estado' => 'Pendiente'
        ]
    );

    // Marcar el pago como anulado
    $this->pagoMensualidadModel->update(
        $pago['id_pago'],
        [
            'estado' => 'Anulado',
            'motivo_anulacion' => $motivo,
            'fecha_anulacion' => date('Y-m-d')
        ]
    );

    $db->transComplete();

    // Verificar si la operación terminó correctamente
    if ($db->transStatus() === false) {
        return redirect()
            ->back()
            ->with('error', 'Ocurrió un error al anular el pago.');
    }

    return redirect()
        ->to(
            '/mensualidades/alumna/' .
            $mensualidad['id_inscripcion']
        )
        ->with(
            'success',
            'El pago fue anulado correctamente. La mensualidad volvió a quedar pendiente.'
        );
}

}
