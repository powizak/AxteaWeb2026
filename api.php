<?php
header('Content-Type: application/json');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Načtení centrálního připojení k databázi
require_once 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed']);
    exit;
}

// --- 1. ZPRACOVÁNÍ HESLA PRO KURZY ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = null;
    
    // Zkusíme načíst JSON vstup
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['password'])) {
        $password = $input['password'];
    } elseif (isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    if ($password) {
        // Ověření hesla
        $stmt = $pdo->prepare("SELECT value FROM app_config WHERE key_name = 'course_password'");
        $stmt->execute();
        $storedPass = $stmt->fetchColumn();

        if ($password === $storedPass) {
            // Heslo je správné -> vrátíme data pro kurzy
            $stmt = $pdo->prepare("SELECT * FROM practical_info WHERE section = 'courses' AND is_active = 1 ORDER BY category, sort_order ASC, id DESC");
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $grouped = [
                'materialy' => [],
                'prezentace' => [],
                'dalsi' => []
            ];

            foreach ($items as $item) {
                if (isset($grouped[$item['category']])) {
                    $grouped[$item['category']][] = $item;
                } else {
                    $grouped['dalsi'][] = $item;
                }
            }
            
            // Sloučíme 'success' flag s daty, aby JS měl přímý přístup (data.materialy)
            echo json_encode(array_merge(['success' => true], $grouped));
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Neplatné heslo']);
            exit;
        }
    }
}

// --- 2. VEŘEJNÉ INFO (DEFAULT) ---
try {
    // Načteme pouze veřejné a aktivní položky
    $stmt = $pdo->prepare("SELECT * FROM practical_info WHERE section = 'public' AND is_active = 1 ORDER BY category, sort_order ASC, id DESC");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $output = [
        'aktualne' => [],
        'odkazy' => [],
        'uzitecne' => []
    ];

    foreach ($items as $row) {
        if (isset($output[$row['category']])) {
            $output[$row['category']][] = $row;
        }
    }

    echo json_encode($output);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>