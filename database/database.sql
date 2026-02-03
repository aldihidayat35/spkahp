-- =============================================
-- WhatsApp API - Database Structure (Fresh Install)
-- Version: 3.0
-- Date: 2025-11-28
-- Author: System
-- =============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS wa_api_new CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wa_api_new;

-- Drop all tables if exists (fresh install)
DROP TABLE IF EXISTS message_queue;
DROP TABLE IF EXISTS message_history;
DROP TABLE IF EXISTS session_logs;
DROP TABLE IF EXISTS whatsapp_sessions;
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS app_settings;
DROP TABLE IF EXISTS users;

-- =============================================
-- Table: users
-- Description: User management untuk akses aplikasi
-- =============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    avatar VARCHAR(255),
    role ENUM('admin', 'operator', 'viewer') DEFAULT 'operator',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: app_settings
-- Description: Konfigurasi aplikasi
-- =============================================
CREATE TABLE app_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json') DEFAULT 'text',
    category VARCHAR(50) DEFAULT 'general',
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_key (setting_key),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: whatsapp_sessions
-- Description: WhatsApp session management
-- =============================================
CREATE TABLE whatsapp_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL UNIQUE,
    session_name VARCHAR(100),
    phone_number VARCHAR(20),
    qr_code TEXT,
    pairing_code VARCHAR(10),
    status ENUM('disconnected', 'connecting', 'connected', 'failed', 'logged_out') DEFAULT 'disconnected',
    connection_method ENUM('qr', 'pairing') DEFAULT 'qr',
    user_id INT,
    user_name VARCHAR(100),
    user_jid VARCHAR(100),
    device_info JSON,
    last_connected TIMESTAMP NULL,
    last_disconnected TIMESTAMP NULL,
    total_messages_sent INT DEFAULT 0,
    total_messages_received INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_session_id (session_id),
    INDEX idx_status (status),
    INDEX idx_phone (phone_number),
    INDEX idx_active (is_active),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: message_history
-- Description: Riwayat semua pesan yang dikirim/diterima
-- =============================================
CREATE TABLE message_history (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    message_id VARCHAR(100),
    direction ENUM('outgoing', 'incoming') NOT NULL,
    recipient_number VARCHAR(20),
    sender_number VARCHAR(20),
    message_type ENUM('text', 'image', 'video', 'audio', 'document', 'sticker', 'location', 'contact') DEFAULT 'text',
    message_content TEXT,
    media_url VARCHAR(500),
    media_caption TEXT,
    media_size INT,
    media_mimetype VARCHAR(100),
    status ENUM('pending', 'sent', 'delivered', 'read', 'failed') DEFAULT 'pending',
    error_message TEXT,
    timestamp BIGINT,
    is_group BOOLEAN DEFAULT FALSE,
    group_id VARCHAR(100),
    quoted_message_id VARCHAR(100),
    extra_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_session (session_id),
    INDEX idx_direction (direction),
    INDEX idx_recipient (recipient_number),
    INDEX idx_sender (sender_number),
    INDEX idx_type (message_type),
    INDEX idx_status (status),
    INDEX idx_created (created_at),
    FOREIGN KEY (session_id) REFERENCES whatsapp_sessions(session_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: message_queue
-- Description: Antrian pesan yang akan dikirim
-- =============================================
CREATE TABLE message_queue (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    recipient_number VARCHAR(20) NOT NULL,
    message_type ENUM('text', 'image', 'video', 'audio', 'document') DEFAULT 'text',
    message_content TEXT,
    media_url VARCHAR(500),
    media_caption TEXT,
    scheduled_at TIMESTAMP NULL,
    priority ENUM('low', 'normal', 'high') DEFAULT 'normal',
    status ENUM('pending', 'processing', 'sent', 'failed', 'cancelled') DEFAULT 'pending',
    retry_count INT DEFAULT 0,
    max_retry INT DEFAULT 3,
    error_message TEXT,
    sent_at TIMESTAMP NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_session (session_id),
    INDEX idx_status (status),
    INDEX idx_scheduled (scheduled_at),
    INDEX idx_priority (priority),
    INDEX idx_created (created_at),
    FOREIGN KEY (session_id) REFERENCES whatsapp_sessions(session_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: session_logs
-- Description: Log aktivitas session (connect, disconnect, dll)
-- =============================================
CREATE TABLE session_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    log_type ENUM('connect', 'disconnect', 'qr_generated', 'pairing_code', 'error', 'info', 'warning') NOT NULL,
    message TEXT NOT NULL,
    details JSON,
    ip_address VARCHAR(50),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_session (session_id),
    INDEX idx_type (log_type),
    INDEX idx_created (created_at),
    FOREIGN KEY (session_id) REFERENCES whatsapp_sessions(session_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: activity_logs
-- Description: Log aktivitas umum aplikasi
-- =============================================
CREATE TABLE activity_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    module VARCHAR(50),
    ip_address VARCHAR(50),
    user_agent TEXT,
    extra_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_module (module),
    INDEX idx_created (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- INSERT SAMPLE DATA
-- =============================================

-- Users (password: admin123 - hashed with bcrypt)
INSERT INTO users (username, email, password, full_name, phone, role, status) VALUES
('admin', 'admin@waapi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', '628123456789', 'admin', 'active'),
('operator1', 'operator1@waapi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operator Satu', '628123456788', 'operator', 'active'),
('viewer1', 'viewer@waapi.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Viewer User', '628123456787', 'viewer', 'active');

-- App Settings
INSERT INTO app_settings (setting_key, setting_value, setting_type, category, description, is_public) VALUES
('app_name', 'WhatsApp API Multi Session', 'text', 'general', 'Nama aplikasi', TRUE),
('app_version', '3.0.0', 'text', 'general', 'Versi aplikasi', TRUE),
('app_description', 'WhatsApp API dengan dukungan multi session dan message queue', 'text', 'general', 'Deskripsi aplikasi', TRUE),
('app_logo', '/Media/logo.png', 'text', 'general', 'Logo aplikasi', TRUE),
('company_name', 'PT. Digital Solutions Indonesia', 'text', 'company', 'Nama perusahaan', TRUE),
('company_email', 'info@digitalsolutions.id', 'text', 'company', 'Email perusahaan', TRUE),
('company_phone', '+62 21 1234 5678', 'text', 'company', 'Telepon perusahaan', TRUE),
('company_address', 'Jakarta, Indonesia', 'text', 'company', 'Alamat perusahaan', TRUE),
('max_sessions', '10', 'number', 'whatsapp', 'Maksimal session yang diizinkan', FALSE),
('session_timeout', '3600', 'number', 'whatsapp', 'Timeout session dalam detik', FALSE),
('qr_timeout', '60', 'number', 'whatsapp', 'Timeout QR code dalam detik', FALSE),
('max_retry', '3', 'number', 'whatsapp', 'Maksimal retry koneksi', FALSE),
('default_country_code', '62', 'text', 'whatsapp', 'Kode negara default', FALSE),
('api_rate_limit', '100', 'number', 'api', 'Rate limit API per menit', FALSE),
('api_timeout', '30', 'number', 'api', 'Timeout API dalam detik', FALSE),
('maintenance_mode', 'false', 'boolean', 'system', 'Mode maintenance', FALSE),
('allow_registration', 'true', 'boolean', 'system', 'Izinkan registrasi user baru', FALSE),
('message_retention_days', '90', 'number', 'message', 'Lama penyimpanan riwayat pesan (hari)', FALSE),
('queue_max_retry', '3', 'number', 'message', 'Maksimal retry untuk message queue', FALSE),
('queue_retry_delay', '60', 'number', 'message', 'Delay antar retry (detik)', FALSE);

-- WhatsApp Sessions
INSERT INTO whatsapp_sessions (session_id, session_name, phone_number, status, connection_method, user_id, is_active) VALUES
('session1', 'Session Demo 1', '628123456789', 'disconnected', 'qr', 1, TRUE),
('session2', 'Session Demo 2', '628987654321', 'disconnected', 'pairing', 1, TRUE),
('session3', 'Session Customer Service', NULL, 'disconnected', 'qr', 2, TRUE);

-- Message History
INSERT INTO message_history (session_id, message_id, direction, recipient_number, sender_number, message_type, message_content, status, timestamp) VALUES
('session1', 'msg_001', 'outgoing', '628111222333', '628123456789', 'text', 'Halo, ini pesan test dari WhatsApp API', 'delivered', UNIX_TIMESTAMP()),
('session1', 'msg_002', 'incoming', '628123456789', '628111222333', 'text', 'Terima kasih atas pesannya', 'read', UNIX_TIMESTAMP()),
('session1', 'msg_003', 'outgoing', '628111222334', '628123456789', 'image', 'Lihat gambar ini', 'sent', UNIX_TIMESTAMP()),
('session2', 'msg_004', 'outgoing', '628555666777', '628987654321', 'text', 'Pengumuman penting', 'delivered', UNIX_TIMESTAMP()),
('session2', 'msg_005', 'incoming', '628987654321', '628555666777', 'text', 'Baik, sudah diterima', 'read', UNIX_TIMESTAMP());

-- Message Queue
INSERT INTO message_queue (session_id, recipient_number, message_type, message_content, scheduled_at, priority, status, created_by) VALUES
('session1', '628111222333', 'text', 'Pesan terjadwal untuk dikirim nanti', DATE_ADD(NOW(), INTERVAL 1 HOUR), 'normal', 'pending', 1),
('session1', '628111222334', 'text', 'Pesan prioritas tinggi', NOW(), 'high', 'pending', 1),
('session2', '628555666777', 'text', 'Broadcast message ke semua pelanggan', NOW(), 'normal', 'pending', 2);

-- Session Logs
INSERT INTO session_logs (session_id, log_type, message, ip_address) VALUES
('session1', 'connect', 'Session berhasil terkoneksi ke WhatsApp', '127.0.0.1'),
('session1', 'qr_generated', 'QR Code berhasil di-generate', '127.0.0.1'),
('session1', 'disconnect', 'Session terputus dari WhatsApp', '127.0.0.1'),
('session2', 'pairing_code', 'Pairing code berhasil di-generate: ABC123', '127.0.0.1'),
('session2', 'connect', 'Session berhasil terkoneksi menggunakan pairing code', '127.0.0.1'),
('session3', 'qr_generated', 'QR Code berhasil di-generate', '192.168.1.100'),
('session3', 'error', 'Gagal terkoneksi: Timeout', '192.168.1.100');

-- Activity Logs
INSERT INTO activity_logs (user_id, action, description, module, ip_address) VALUES
(1, 'login', 'Admin berhasil login ke sistem', 'auth', '127.0.0.1'),
(1, 'create_session', 'Membuat session baru: session1', 'whatsapp', '127.0.0.1'),
(1, 'send_message', 'Mengirim pesan ke 628111222333', 'message', '127.0.0.1'),
(2, 'login', 'Operator berhasil login ke sistem', 'auth', '192.168.1.100'),
(2, 'create_session', 'Membuat session baru: session3', 'whatsapp', '192.168.1.100'),
(1, 'update_settings', 'Mengubah pengaturan aplikasi', 'settings', '127.0.0.1'),
(2, 'send_broadcast', 'Mengirim broadcast ke 50 kontak', 'message', '192.168.1.100');

-- =============================================
-- VIEWS
-- =============================================

-- View: Active Sessions
CREATE OR REPLACE VIEW v_active_sessions AS
SELECT 
    ws.id,
    ws.session_id,
    ws.session_name,
    ws.phone_number,
    ws.status,
    ws.last_connected,
    ws.total_messages_sent,
    ws.total_messages_received,
    u.username,
    u.full_name AS user_full_name
FROM whatsapp_sessions ws
LEFT JOIN users u ON ws.user_id = u.id
WHERE ws.is_active = TRUE
ORDER BY ws.last_connected DESC;

-- View: Recent Messages
CREATE OR REPLACE VIEW v_recent_messages AS
SELECT 
    mh.id,
    mh.session_id,
    ws.session_name,
    mh.direction,
    mh.recipient_number,
    mh.sender_number,
    mh.message_type,
    LEFT(mh.message_content, 100) AS message_preview,
    mh.status,
    FROM_UNIXTIME(mh.timestamp) AS sent_time,
    mh.created_at
FROM message_history mh
JOIN whatsapp_sessions ws ON mh.session_id = ws.session_id
ORDER BY mh.created_at DESC
LIMIT 100;

-- View: Pending Queue
CREATE OR REPLACE VIEW v_pending_queue AS
SELECT 
    mq.id,
    mq.session_id,
    ws.session_name,
    mq.recipient_number,
    mq.message_type,
    LEFT(mq.message_content, 100) AS message_preview,
    mq.scheduled_at,
    mq.priority,
    mq.retry_count,
    mq.created_at
FROM message_queue mq
JOIN whatsapp_sessions ws ON mq.session_id = ws.session_id
WHERE mq.status = 'pending'
ORDER BY mq.priority DESC, mq.scheduled_at ASC;

-- View: Message Statistics
CREATE OR REPLACE VIEW v_message_stats AS
SELECT 
    session_id,
    COUNT(*) AS total_messages,
    SUM(CASE WHEN direction = 'outgoing' THEN 1 ELSE 0 END) AS total_sent,
    SUM(CASE WHEN direction = 'incoming' THEN 1 ELSE 0 END) AS total_received,
    SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) AS total_delivered,
    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS total_failed,
    DATE(created_at) AS message_date
FROM message_history
GROUP BY session_id, DATE(created_at);

-- =============================================
-- STORED PROCEDURES
-- =============================================

DELIMITER $$

-- Procedure: Clean Old Messages
CREATE PROCEDURE sp_clean_old_messages(IN days_to_keep INT)
BEGIN
    DELETE FROM message_history 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL days_to_keep DAY);
    
    SELECT ROW_COUNT() AS deleted_rows;
END$$

-- Procedure: Clean Old Logs
CREATE PROCEDURE sp_clean_old_logs(IN days_to_keep INT)
BEGIN
    DELETE FROM session_logs 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL days_to_keep DAY);
    
    DELETE FROM activity_logs 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL days_to_keep DAY);
    
    SELECT ROW_COUNT() AS deleted_rows;
END$$

-- Procedure: Process Message Queue
CREATE PROCEDURE sp_process_queue(IN limit_rows INT)
BEGIN
    SELECT * FROM message_queue
    WHERE status = 'pending'
    AND (scheduled_at IS NULL OR scheduled_at <= NOW())
    ORDER BY priority DESC, created_at ASC
    LIMIT limit_rows;
END$$

-- Procedure: Get Session Summary
CREATE PROCEDURE sp_get_session_summary(IN p_session_id VARCHAR(100))
BEGIN
    SELECT 
        ws.*,
        (SELECT COUNT(*) FROM message_history WHERE session_id = p_session_id) AS total_messages,
        (SELECT COUNT(*) FROM message_queue WHERE session_id = p_session_id AND status = 'pending') AS pending_queue,
        (SELECT COUNT(*) FROM session_logs WHERE session_id = p_session_id) AS total_logs
    FROM whatsapp_sessions ws
    WHERE ws.session_id = p_session_id;
END$$

DELIMITER ;

-- =============================================
-- TRIGGERS
-- =============================================

DELIMITER $$

-- Trigger: Update session stats after message insert
CREATE TRIGGER tr_message_stats_insert
AFTER INSERT ON message_history
FOR EACH ROW
BEGIN
    IF NEW.direction = 'outgoing' THEN
        UPDATE whatsapp_sessions 
        SET total_messages_sent = total_messages_sent + 1
        WHERE session_id = NEW.session_id;
    ELSE
        UPDATE whatsapp_sessions 
        SET total_messages_received = total_messages_received + 1
        WHERE session_id = NEW.session_id;
    END IF;
END$$

-- Trigger: Log session status change
CREATE TRIGGER tr_session_status_update
AFTER UPDATE ON whatsapp_sessions
FOR EACH ROW
BEGIN
    IF OLD.status != NEW.status THEN
        INSERT INTO session_logs (session_id, log_type, message)
        VALUES (NEW.session_id, 'info', CONCAT('Status berubah dari ', OLD.status, ' menjadi ', NEW.status));
    END IF;
END$$

-- Trigger: Auto-update last_login on users
CREATE TRIGGER tr_user_last_login
BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.last_login > OLD.last_login OR OLD.last_login IS NULL THEN
        INSERT INTO activity_logs (user_id, action, description, module, created_at)
        VALUES (NEW.id, 'login', CONCAT('User ', NEW.username, ' berhasil login'), 'auth', NOW());
    END IF;
END$$

DELIMITER ;

-- =============================================
-- INDEXES OPTIMIZATION (Additional)
-- =============================================

-- Composite indexes for better query performance
CREATE INDEX idx_message_session_created ON message_history(session_id, created_at);
CREATE INDEX idx_queue_session_status ON message_queue(session_id, status);
CREATE INDEX idx_logs_session_type ON session_logs(session_id, log_type);

-- =============================================
-- DATABASE READY
-- =============================================
SELECT 'Database wa_api_new berhasil dibuat!' AS status,
       '7 tables created: users, app_settings, whatsapp_sessions, message_history, message_queue, session_logs, activity_logs' AS tables,
       '4 views, 4 stored procedures, 3 triggers' AS features;
