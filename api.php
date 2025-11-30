<?php
header('Content-Type: application/json');

// Načtení centrálního připojení k databázi
require_once 'db.php';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // V produkci nevypisovat chybu napřímo
    echo json_encode(['error' => 'Connection failed']);
    exit;
}

// Získání dat
try {
    $stmt = $pdo->query("SELECT * FROM practical_info WHERE is_active = 1 ORDER BY sort_order ASC, id DESC");
    $data = $stmt->fetchAll();
    
    // Rozdělení do kategorií
    $output = [
        'aktualne' => [],
        'odkazy' => [],
        'uzitecne' => []
    ];

    foreach ($data as $row) {
        if (isset($output[$row['category']])) {
            $output[$row['category']][] = $row;
        }
    }

    echo json_encode($output);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>