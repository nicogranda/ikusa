-- ============================================================
-- MALETA CHIC — Esquema de tablas para el sistema de afiliados
-- Ejecutar en phpMyAdmin sobre la base de datos existente
-- ============================================================

-- 1) Rol de afiliado en users
-- Si tu tabla `users` ya tiene un campo `role` tipo ENUM/VARCHAR,
-- solo asegúrate de que acepte el valor 'affiliate'.
-- Si es ENUM, ejemplo de ajuste (adapta el nombre real de la columna):
--
-- ALTER TABLE users
--   MODIFY COLUMN role ENUM('customer','admin','affiliate') NOT NULL DEFAULT 'customer';

-- ============================================================
-- 2) Tabla principal de afiliados (1:1 con users)
-- ============================================================
CREATE TABLE IF NOT EXISTS affiliates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    referral_code VARCHAR(30) NOT NULL,
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    promotion_channels VARCHAR(255) NULL COMMENT 'Como planea promocionar (texto libre del registro)',
    commission_rate DECIMAL(5,2) NOT NULL DEFAULT 10.00 COMMENT 'Porcentaje de comision para el afiliado, ej 10.00 = 10%',
    customer_discount_rate DECIMAL(5,2) NOT NULL DEFAULT 10.00 COMMENT 'Porcentaje de descuento que recibe el cliente al usar el codigo, ej 10.00 = 10%',
    payout_method VARCHAR(50) NULL COMMENT 'paypal, transferencia, etc',
    payout_details VARCHAR(255) NULL COMMENT 'email de paypal, IBAN, etc',
    approved_at DATETIME NULL,
    rejected_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_affiliate_user (user_id),
    UNIQUE KEY uq_affiliate_code (referral_code),
    KEY idx_affiliate_status (status),
    CONSTRAINT fk_affiliate_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 3) Tabla de clics (tracking de cada visita con ?ref=CODIGO)
-- ============================================================
CREATE TABLE IF NOT EXISTS affiliate_clicks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    affiliate_id INT UNSIGNED NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    landing_url VARCHAR(255) NULL,
    clicked_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_click_affiliate (affiliate_id),
    KEY idx_click_date (clicked_at),
    CONSTRAINT fk_click_affiliate FOREIGN KEY (affiliate_id) REFERENCES affiliates(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 4) Tabla de comisiones (una fila por pedido atribuido)
-- ============================================================
CREATE TABLE IF NOT EXISTS commissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    affiliate_id INT UNSIGNED NOT NULL,
    order_id INT UNSIGNED NOT NULL,
    order_subtotal_original DECIMAL(10,2) NOT NULL COMMENT 'Subtotal sin envio, ANTES del descuento',
    discount_rate DECIMAL(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Rate de descuento aplicado al cliente',
    discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Monto de descuento dado al cliente',
    order_subtotal_after_discount DECIMAL(10,2) NOT NULL COMMENT 'Base real sobre la que se calcula la comision',
    commission_rate DECIMAL(5,2) NOT NULL COMMENT 'Rate de comision aplicado en el momento del pedido',
    commission_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','approved','paid','cancelled') NOT NULL DEFAULT 'pending',
    paid_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_commission_order (order_id),
    KEY idx_commission_affiliate (affiliate_id),
    KEY idx_commission_status (status),
    CONSTRAINT fk_commission_affiliate FOREIGN KEY (affiliate_id) REFERENCES affiliates(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 5) Vincular pedidos con el afiliado que los origino
-- Ajusta el nombre de tu tabla de pedidos si no se llama `orders`
-- ============================================================
ALTER TABLE orders
    ADD COLUMN affiliate_id INT UNSIGNED NULL AFTER user_id,
    ADD COLUMN affiliate_discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER affiliate_id,
    ADD CONSTRAINT fk_order_affiliate FOREIGN KEY (affiliate_id) REFERENCES affiliates(id) ON DELETE SET NULL;
