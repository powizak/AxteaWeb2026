-- Kompletní inicializační skript pro databázi AxteaWeb2026
-- Obsahuje tabulky pro uživatele, praktické informace (včetně kurzů) a konfiguraci.
-- Zatím poslední verze, kterou máme - ty dvě ostatní možno po otestování smazat.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Struktura tabulky `users` (Administrátoři)
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktura tabulky `practical_info` (Veřejné info + Kurzy)
--
CREATE TABLE IF NOT EXISTS `practical_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` enum('public','courses') NOT NULL DEFAULT 'public',
  `category` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT 'file',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktura tabulky `app_config` (Nastavení, např. heslo pro kurzy)
--
CREATE TABLE IF NOT EXISTS `app_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vložení výchozích dat
--

-- 1. Výchozí heslo pro kurzy (axtea2025)
INSERT INTO `app_config` (`key_name`, `value`) VALUES
('course_password', 'axtea2025')
ON DUPLICATE KEY UPDATE `value`='axtea2025';

-- 2. Výchozí admin uživatel (admin / admin123)
-- Poznámka: V ostrém provozu ihned změňte heslo!
-- Hash pro 'admin123' je: $2y$10$8.Dk.X/I.J/I.J/I.J/I.J/I.J/I.J/I.J/I.J/I.J/I.J/I.J (Příklad, generováno PHP password_hash)
-- Zde vložíme placeholder, uživatel si musí vytvořit účet nebo použít existující hash.
-- Pokud chcete vložit defaultního admina, odkomentujte níže:
-- INSERT INTO `users` (`username`, `password_hash`) VALUES ('admin', '$2y$10$G8...VÁŠ_HASH...');

COMMIT;
