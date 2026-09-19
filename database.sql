-- =========================================================
-- BASE DE DATOS
-- =========================================================
CREATE DATABASE IF NOT EXISTS taller_confeccion_pirapo
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE taller_confeccion_pirapo;
-- =========================================================
-- 1. TABLA USUARIO
-- =========================================================
CREATE TABLE usuario (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB;
-- =========================================================
-- 2. TABLA PERSONA
-- =========================================================
CREATE TABLE persona (
    id_persona INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(100)
) ENGINE=InnoDB;
-- =========================================================
-- 3. TABLA ROL
-- =========================================================
CREATE TABLE rol (
    id_rol INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;
-- =========================================================
-- 4. TABLA PERSONA_ROL
-- =========================================================
CREATE TABLE persona_rol (
    id_persona_rol INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    id_rol INT UNSIGNED NOT NULL,

    CONSTRAINT fk_persona_rol_persona
        FOREIGN KEY (id_persona)
        REFERENCES persona(id_persona)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_persona_rol_rol
        FOREIGN KEY (id_rol)
        REFERENCES rol(id_rol)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT uk_persona_rol
        UNIQUE (id_persona, id_rol)
) ENGINE=InnoDB;
-- =========================================================
-- 5. TABLA CURSO
-- =========================================================
CREATE TABLE curso (
    id_curso INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_curso VARCHAR(50) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB;
-- =========================================================
-- 6. TABLA INSCRIPCION
-- =========================================================
CREATE TABLE inscripcion (
    id_inscripcion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    id_curso INT UNSIGNED NOT NULL,
    fecha_inscripcion DATE NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'Activa',

    CONSTRAINT fk_inscripcion_persona
        FOREIGN KEY (id_persona)
        REFERENCES persona(id_persona)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_inscripcion_curso
        FOREIGN KEY (id_curso)
        REFERENCES curso(id_curso)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;
-- =========================================================
-- 7. TABLA MENSUALIDAD
-- =========================================================
CREATE TABLE mensualidad (
    id_mensualidad INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_inscripcion INT UNSIGNED NOT NULL,
    mes INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'Pendiente',

    CONSTRAINT fk_mensualidad_inscripcion
        FOREIGN KEY (id_inscripcion)
        REFERENCES inscripcion(id_inscripcion)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_mensualidad_mes
        CHECK (mes BETWEEN 1 AND 12),

    CONSTRAINT chk_mensualidad_monto
        CHECK (monto >= 0)
) ENGINE=InnoDB;
-- =========================================================
-- 8. TABLA PAGO_MENSUALIDAD
-- =========================================================
CREATE TABLE pago_mensualidad (
    id_pago INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_mensualidad INT UNSIGNED NOT NULL,
    fecha_pago DATE NOT NULL,
    monto_pagado DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_pago_mensualidad
        FOREIGN KEY (id_mensualidad)
        REFERENCES mensualidad(id_mensualidad)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_pago_mensualidad_monto
        CHECK (monto_pagado > 0)
) ENGINE=InnoDB;
-- =========================================================
-- 9. TABLA CATEGORIA_PRODUCTO
-- =========================================================
CREATE TABLE categoria_producto (
    id_categoria INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;
-- =========================================================
-- 10. TABLA PRODUCTO
-- =========================================================
CREATE TABLE producto (
    id_producto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT UNSIGNED NOT NULL,
    nombre_producto VARCHAR(100) NOT NULL,
    unidad_medida VARCHAR(20) NOT NULL,
    precio_compra DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_producto_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categoria_producto(id_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_producto_precio_compra
        CHECK (precio_compra >= 0),

    CONSTRAINT chk_producto_precio_venta
        CHECK (precio_venta >= 0)
) ENGINE=InnoDB;
-- =========================================================
-- 11. TABLA MOVIMIENTO_INVENTARIO
-- =========================================================
CREATE TABLE movimiento_inventario (
    id_movimiento INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_producto INT UNSIGNED NOT NULL,
    tipo_movimiento VARCHAR(20) NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    fecha DATE NOT NULL,

    CONSTRAINT fk_movimiento_producto
        FOREIGN KEY (id_producto)
        REFERENCES producto(id_producto)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_movimiento_cantidad
        CHECK (cantidad > 0)
) ENGINE=InnoDB;
-- =========================================================
-- 12. TABLA COMPRA
-- =========================================================
CREATE TABLE compra (
    id_compra INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha_compra DATE NOT NULL,
    total DECIMAL(10,2) NOT NULL DEFAULT 0,

    CONSTRAINT chk_compra_total
        CHECK (total >= 0)
) ENGINE=InnoDB;
-- =========================================================
-- 13. TABLA DETALLE_COMPRA
-- =========================================================
CREATE TABLE detalle_compra (
    id_detalle_compra INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_compra INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_detalle_compra_compra
        FOREIGN KEY (id_compra)
        REFERENCES compra(id_compra)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_detalle_compra_producto
        FOREIGN KEY (id_producto)
        REFERENCES producto(id_producto)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_detalle_compra_cantidad
        CHECK (cantidad > 0),

    CONSTRAINT chk_detalle_compra_precio
        CHECK (precio >= 0)
) ENGINE=InnoDB;
-- =========================================================
-- 14. TABLA VENTA
-- =========================================================
CREATE TABLE venta (
    id_venta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_persona INT UNSIGNED NOT NULL,
    fecha_venta DATE NOT NULL,
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    estado_pago VARCHAR(20) NOT NULL DEFAULT 'Pagado',

    CONSTRAINT fk_venta_persona
        FOREIGN KEY (id_persona)
        REFERENCES persona(id_persona)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_venta_total
        CHECK (total >= 0)
) ENGINE=InnoDB;
-- =========================================================
-- 15. TABLA DETALLE_VENTA
-- =========================================================
CREATE TABLE detalle_venta (
    id_detalle_venta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_venta INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_detalle_venta_venta
        FOREIGN KEY (id_venta)
        REFERENCES venta(id_venta)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_detalle_venta_producto
        FOREIGN KEY (id_producto)
        REFERENCES producto(id_producto)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_detalle_venta_cantidad
        CHECK (cantidad > 0),

    CONSTRAINT chk_detalle_venta_precio
        CHECK (precio >= 0)
) ENGINE=InnoDB;
-- =========================================================
-- 16. TABLA CUENTA_COBRAR
-- =========================================================
CREATE TABLE cuenta_cobrar (
    id_cuenta_cobrar INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_venta INT UNSIGNED NOT NULL,
    fecha_generacion DATE NOT NULL,
    monto_total DECIMAL(10,2) NOT NULL,
    saldo_pendiente DECIMAL(10,2) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'Pendiente',

    CONSTRAINT fk_cuenta_cobrar_venta
        FOREIGN KEY (id_venta)
        REFERENCES venta(id_venta)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_cuenta_monto_total
        CHECK (monto_total >= 0),

    CONSTRAINT chk_cuenta_saldo
        CHECK (saldo_pendiente >= 0),

    CONSTRAINT uk_cuenta_venta
        UNIQUE (id_venta)
) ENGINE=InnoDB;
-- =========================================================
-- 17. TABLA PAGO_CUENTA
-- =========================================================
CREATE TABLE pago_cuenta (
    id_pago_cuenta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cuenta_cobrar INT UNSIGNED NOT NULL,
    fecha_pago DATE NOT NULL,
    monto_pagado DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_pago_cuenta
        FOREIGN KEY (id_cuenta_cobrar)
        REFERENCES cuenta_cobrar(id_cuenta_cobrar)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT chk_pago_cuenta_monto
        CHECK (monto_pagado > 0)
) ENGINE=InnoDB;
-- =========================================================
-- 18. TABLA APORTE_MUNICIPAL
-- =========================================================
CREATE TABLE aporte_municipal (
    id_aporte INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha_aporte DATE NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    descripcion TEXT,

    CONSTRAINT chk_aporte_monto
        CHECK (monto > 0)
) ENGINE=InnoDB;
-- =========================================================
-- 19. TABLA GASTO
-- =========================================================
CREATE TABLE gasto (
    id_gasto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha_gasto DATE NOT NULL,
    descripcion TEXT,
    monto DECIMAL(10,2) NOT NULL,

    CONSTRAINT chk_gasto_monto
        CHECK (monto > 0)
) ENGINE=InnoDB;
