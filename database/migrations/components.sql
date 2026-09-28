CREATE TABLE IF NOT EXISTS components (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    type VARCHAR(40) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'published',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_components_group (name, status, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS component_translations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    component_id INT UNSIGNED NOT NULL,
    language VARCHAR(2) NOT NULL,
    title VARCHAR(255) DEFAULT NULL,
    subtitle VARCHAR(255) DEFAULT NULL,
    text TEXT DEFAULT NULL,
    image_alt VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_component_language (component_id, language),
    CONSTRAINT fk_component_translations_component
        FOREIGN KEY (component_id) REFERENCES components (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
