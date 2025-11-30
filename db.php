<?php
// Funkce pro načtení .env souboru a vrácení pole s konfigurací
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception("Soubor .env nebyl nalezen.");
    }

    $config = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Přeskočit komentáře
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Rozdělit na klíč a hodnotu
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $config[trim($name)] = trim($value);
        }
    }
    return $config;
}

// Načtení konfigurace do proměnné
try {
    $env = loadEnv(__DIR__ . '/.env');
} catch (Exception $e) {
    die("Chyba konfigurace: " . $e->getMessage());
}

// Kontrola, zda máme všechny údaje (pro jistotu)
if (!isset($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASS'])) {
    die("Chyba: V souboru .env chybí některé konfigurační údaje.");
}

// Připojení k databázi pomocí načtených hodnot
$host = $env['DB_HOST'];
$db   = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // V produkci logovat chybu, nevypisovat hesla
    error_log($e->getMessage());
    die("Chyba připojení k databázi.");
}
?>