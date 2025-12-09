<?php
session_start();

// Načtení centrálního připojení k databázi (včetně .env)
require_once 'db.php';

$uploadDir = 'uploads/';       // Složka pro nahrávání souborů

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Chyba připojení k DB. Zkontrolujte údaje v souboru admin.php");
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// CSRF Protection Helper
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verify_csrf() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed.");
    }
}

$error = '';
$success = '';

// --- ZMĚNA HESLA PRO KURZY ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password']) && isset($_SESSION['user_id'])) {
    verify_csrf();
    $newPass = trim($_POST['course_password']);
    if (!empty($newPass)) {
        // Uložíme/Aktualizujeme heslo v DB
        $stmt = $pdo->prepare("INSERT INTO app_config (key_name, value) VALUES ('course_password', ?) ON DUPLICATE KEY UPDATE value = ?");
        $stmt->execute([$newPass, $newPass]);
        $success = "Heslo pro kurzy bylo změněno.";
    }
}

// --- ZMĚNA HESLA ADMINISTRÁTORA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin_password']) && isset($_SESSION['user_id'])) {
    verify_csrf();
    $newAdminPass = trim($_POST['admin_password']);
    $newAdminPassConfirm = trim($_POST['admin_password_confirm']);

    if (!empty($newAdminPass)) {
        if ($newAdminPass === $newAdminPassConfirm) {
            $newHash = password_hash($newAdminPass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
            $stmt->execute([$newHash, $_SESSION['user_id']]);
            $success = "Heslo administrátora bylo úspěšně změněno.";
        } else {
            $error = "Zadaná hesla se neshodují. Zkuste to prosím znovu.";
        }
    } else {
        $error = "Heslo nesmí být prázdné.";
    }
}

// --- LOGIN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Note: Usually CSRF is less critical on login forms, but good practice.
    // For simplicity, we are skipping it here or we need to inject it into the login form below before login logic.
    // Let's protect it.
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            // Regenerate session ID after login
            session_regenerate_id(true);
            header("Location: admin.php");
            exit;
        } else {
            $error = "Špatné jméno nebo heslo.";
        }
    } else {
         $error = "Chyba zabezpečení (CSRF). Zkuste to znovu.";
    }
}
 
// --- PŘIDÁNÍ POLOŽKY + NAHRÁVÁNÍ SOUBORU ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item']) && isset($_SESSION['user_id'])) {
    verify_csrf();
    
    $link = $_POST['link']; // Výchozí hodnota z textového pole
    $uploadSuccess = true;

    // Zpracování nahrávání souboru
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        // Povolené přípony
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($_FILES['file_upload']['name']);
        $extension = strtolower($fileInfo['extension']);

        if (!in_array($extension, $allowedExtensions)) {
            $error = "Typ souboru není povolen. Povolené formáty: " . implode(', ', $allowedExtensions);
            $uploadSuccess = false;
        }

        // Kontrola existence složky
        if ($uploadSuccess && !is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $error = "Nepodařilo se vytvořit složku pro nahrávání ($uploadDir).";
                $uploadSuccess = false;
            }
        }

        if ($uploadSuccess) {
            $fileName = basename($_FILES['file_upload']['name']);
            // Jednoduchá sanitizace jména souboru (odstranění diakritiky a mezer)
            $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);

            // Dvojitá kontrola přípony po sanitizaci (pro jistotu)
            $finalExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($finalExt, $allowedExtensions)) {
                 $error = "Neplatný název souboru nebo přípona.";
                 $uploadSuccess = false;
            } else {
                // Přidání časového razítka proti přepsání
                $targetPath = $uploadDir . time() . '_' . $fileName;

                // Pokus o přesun souboru
                if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetPath)) {
                    $link = $targetPath; // Odkaz nyní směřuje na nahraný soubor
                } else {
                    $error = "Chyba při ukládání souboru. Zkontrolujte práva složky $uploadDir.";
                    $uploadSuccess = false;
                }
            }
        }
    }

    // Pokud nenastala chyba (nebo nebyl nahráván soubor), uložíme do DB
    if ($uploadSuccess) {
        // Pokud není vyplněn ani soubor, ani odkaz
        if (empty($link)) {
            $error = "Musíte zadat odkaz nebo nahrát soubor.";
        } else {
            // Získání a očištění kategorie
            $category = isset($_POST['category']) ? trim($_POST['category']) : '';
            
            // Debugging: Pokud je kategorie prázdná, zalogujeme to (pro jistotu)
            if ($category === '') {
                file_put_contents('debug_category_error.txt', date('Y-m-d H:i:s') . " - Empty category. POST: " . print_r($_POST, true) . "\n", FILE_APPEND);
            }

            // Fallback pro prázdnou kategorii
            if ($category === '') {
                $category = ($_POST['section'] === 'courses') ? 'dalsi' : 'aktualne';
            }

            $sql = "INSERT INTO practical_info (section, category, title, description, link, icon, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_POST['section'],
                $category,
                $_POST['title'],
                $_POST['description'],
                $link,
                $_POST['icon'],
                (int)$_POST['sort_order'],
                isset($_POST['is_active']) ? 1 : 0
            ]);
            header("Location: admin.php?success=1");
            exit;
        }
    }
}

// --- HROMADNÁ ÚPRAVA (POŘADÍ A AKTIVITA) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_items']) && isset($_SESSION['user_id'])) {
    verify_csrf();
    if (isset($_POST['items']) && is_array($_POST['items'])) {
        $sql = "UPDATE practical_info SET sort_order = ?, is_active = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        foreach ($_POST['items'] as $id => $data) {
            $sortOrder = intval($data['sort_order']);
            $isActive = isset($data['is_active']) ? 1 : 0;
            $stmt->execute([$sortOrder, $isActive, $id]);
        }
        $success = "Změny byly uloženy.";
        // Refresh pro zobrazení změn
        header("Location: admin.php?success_update=1");
        exit;
    }
}

if (isset($_GET['success_update'])) {
    $success = "Změny byly úspěšně uloženy.";
}

// --- SMAZÁNÍ POLOŽKY ---
if (isset($_GET['delete']) && isset($_SESSION['user_id'])) {
    // Nejdříve zjistíme, zda je to lokální soubor, abychom ho smazali z disku
    $stmt = $pdo->prepare("SELECT link FROM practical_info WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $item = $stmt->fetch();

    if ($item) {
        // Pokud odkaz začíná na naši upload složku, smažeme soubor
        if (strpos($item['link'], $uploadDir) === 0 && file_exists($item['link'])) {
            unlink($item['link']);
        }

        // Smazání z DB
        $stmt = $pdo->prepare("DELETE FROM practical_info WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
    }
    header("Location: admin.php");
    exit;
}

// Zpráva o úspěchu po redirectu
if (isset($_GET['success'])) {
    $success = "Položka byla úspěšně přidána.";
}

// --- LOGIN SCREEN ---
if (!isset($_SESSION['user_id'])) {
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="dist/styles.css">

       <!-- Favicony -->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="shortcut icon" href="/img/favicon.ico">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center">AXTEA Admin</h1>
        <?php if($error): ?><p class="text-red-500 mb-4 text-sm text-center"><?= $error ?></p><?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="text" name="username" placeholder="Jméno" class="w-full border p-2 mb-4 rounded" required>
            <input type="password" name="password" placeholder="Heslo" class="w-full border p-2 mb-6 rounded" required>
            <button type="submit" name="login" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Přihlásit</button>
        </form>
    </div>
</body>
</html>
<?php
exit;
}
?>

<!-- --- ADMIN PANEL --- -->
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Správa obsahu | AXTEA</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="dist/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <span class="font-bold text-xl text-blue-800">AXTEA Admin</span>
            <a href="?logout=1" class="text-red-500 hover:text-red-700">Odhlásit se</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Formulář -->
        <div class="bg-white p-6 rounded shadow h-fit">
            <h2 class="text-lg font-bold mb-4">Přidat novou informaci</h2>
            
            <?php if($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm"><?= $error ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm"><?= $success ?></div>
            <?php endif; ?>

            <!-- Důležité: enctype pro nahrávání souborů -->
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <!-- Výběr Sekce -->
                <div class="mb-4 bg-gray-50 p-3 rounded border">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Sekce webu</label>
                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="section" value="public" checked onchange="updateCategories('public')" class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm">Veřejné info</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="section" value="courses" onchange="updateCategories('courses')" class="text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Kurzy (Heslo)</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategorie</label>
                    <select name="category" id="categorySelect" class="w-full border p-2 rounded mt-1">
                        <!-- Naplněno JS -->
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nadpis</label>
                    <input type="text" name="title" class="w-full border p-2 rounded mt-1" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Popis (volitelné)</label>
                    <input type="text" name="description" class="w-full border p-2 rounded mt-1">
                </div>
                
                <div class="flex gap-4 mb-4">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700">Pořadí</label>
                        <input type="number" name="sort_order" class="w-full border p-2 rounded mt-1" value="0">
                    </div>
                    <div class="w-1/2 flex items-center mt-6">
                        <label class="flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="is_active" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500" checked>
                            <span class="ml-2 text-sm text-gray-700">Aktivní</span>
                        </label>
                    </div>
                </div>

                <!-- Sekce pro soubor nebo odkaz -->
                <div class="mb-4 p-4 bg-gray-50 rounded border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Soubor nebo Odkaz</label>
                    
                    <div class="mb-3">
                        <label class="block text-xs text-gray-500 mb-1">Varianta A: Nahrát soubor (PDF, DOC...)</label>
                        <input type="file" name="file_upload" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    
                    <div class="text-center text-gray-400 text-xs my-2">- NEBO -</div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Varianta B: Externí odkaz (URL)</label>
                        <input type="text" name="link" class="w-full border p-2 rounded mt-1" placeholder="https://...">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Ikona</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" name="icon" id="iconInput" class="w-full border p-2 rounded" placeholder="file-pdf" value="file-alt">
                        <div class="flex items-center justify-center w-10 bg-gray-100 rounded border text-gray-600">
                            <i id="iconPreview" class="fas fa-file-alt"></i>
                        </div>
                    </div>
                   <div class="flex flex-wrap gap-2 mt-3 text-xs text-blue-600">
                        <!-- Kancelářské / Soubory -->
                        <span onclick="setIcon('file-pdf')" class="cursor-pointer hover:underline bg-blue-50 px-2 py-1 rounded border border-blue-100">PDF</span>
                        <span onclick="setIcon('file-word')" class="cursor-pointer hover:underline bg-blue-50 px-2 py-1 rounded border border-blue-100">Word</span>
                        <span onclick="setIcon('file-excel')" class="cursor-pointer hover:underline bg-blue-50 px-2 py-1 rounded border border-blue-100">Excel</span>
                        <span onclick="setIcon('file-powerpoint')" class="cursor-pointer hover:underline bg-blue-50 px-2 py-1 rounded border border-blue-100">PowerPoint</span>
                        <span onclick="setIcon('file-alt')" class="cursor-pointer hover:underline bg-blue-50 px-2 py-1 rounded border border-blue-100">Dokument</span>
                        
                        <!-- Finance / Daně -->
                        <span onclick="setIcon('file-invoice-dollar')" class="cursor-pointer hover:underline bg-green-50 px-2 py-1 rounded border border-green-100 text-green-700">Faktura/Mzdy</span>
                        <span onclick="setIcon('calculator')" class="cursor-pointer hover:underline bg-green-50 px-2 py-1 rounded border border-green-100 text-green-700">Kalkulačka</span>
                        <span onclick="setIcon('coins')" class="cursor-pointer hover:underline bg-green-50 px-2 py-1 rounded border border-green-100 text-green-700">Peníze</span>
                        <span onclick="setIcon('percent')" class="cursor-pointer hover:underline bg-green-50 px-2 py-1 rounded border border-green-100 text-green-700">Procenta</span>

                        <!-- Obecné / Odkazy -->
                        <span onclick="setIcon('link')" class="cursor-pointer hover:underline bg-gray-100 px-2 py-1 rounded border border-gray-200 text-gray-700">Odkaz</span>
                        <span onclick="setIcon('globe')" class="cursor-pointer hover:underline bg-gray-100 px-2 py-1 rounded border border-gray-200 text-gray-700">Web</span>
                        <span onclick="setIcon('info-circle')" class="cursor-pointer hover:underline bg-gray-100 px-2 py-1 rounded border border-gray-200 text-gray-700">Info</span>
                        <span onclick="setIcon('bullhorn')" class="cursor-pointer hover:underline bg-gray-100 px-2 py-1 rounded border border-gray-200 text-gray-700">Aktuálně</span>
                        
                        <!-- Úřady -->
                        <span onclick="setIcon('landmark')" class="cursor-pointer hover:underline bg-purple-50 px-2 py-1 rounded border border-purple-100 text-purple-700">Banka/Úřad</span>
                        <span onclick="setIcon('envelope')" class="cursor-pointer hover:underline bg-purple-50 px-2 py-1 rounded border border-purple-100 text-purple-700">Dopis/Datovka</span>
                        <span onclick="setIcon('calendar-alt')" class="cursor-pointer hover:underline bg-purple-50 px-2 py-1 rounded border border-purple-100 text-purple-700">Kalendář</span>

                        <!-- Emoji / Ostatní -->
                        <span onclick="setIcon('smile')" class="cursor-pointer hover:underline bg-yellow-50 px-2 py-1 rounded border border-yellow-100 text-yellow-700">Úsměv</span>
                        <span onclick="setIcon('thumbs-up')" class="cursor-pointer hover:underline bg-yellow-50 px-2 py-1 rounded border border-yellow-100 text-yellow-700">Palec nahoru</span>
                        <span onclick="setIcon('star')" class="cursor-pointer hover:underline bg-yellow-50 px-2 py-1 rounded border border-yellow-100 text-yellow-700">Hvězda</span>
                        <span onclick="setIcon('heart')" class="cursor-pointer hover:underline bg-red-50 px-2 py-1 rounded border border-red-100 text-red-700">Srdce</span>
                        <span onclick="setIcon('exclamation-triangle')" class="cursor-pointer hover:underline bg-red-50 px-2 py-1 rounded border border-red-100 text-red-700">Pozor</span>
                        <span onclick="setIcon('question-circle')" class="cursor-pointer hover:underline bg-blue-50 px-2 py-1 rounded border border-blue-100 text-blue-700">Otazník</span>
                    </div>
                </div>
                
                <button type="submit" name="add_item" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700 font-bold shadow">
                    <i class="fas fa-plus mr-2"></i> Uložit na web
                </button>
            </form>

            <!-- Nastavení hesla pro kurzy -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-md font-bold mb-3 text-gray-700">Nastavení kurzů</h3>
                <form method="post" class="bg-gray-50 p-4 rounded border">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <label class="block text-sm text-gray-600 mb-1">Heslo pro účastníky</label>
                    <div class="flex gap-2">
                        <?php
                            // Načtení aktuálního hesla
                            $stmt = $pdo->query("SELECT value FROM app_config WHERE key_name = 'course_password'");
                            $currentPass = $stmt->fetchColumn() ?: '';
                        ?>
                        <input type="text" name="course_password" value="<?= htmlspecialchars($currentPass) ?>" class="w-full border p-2 rounded text-sm">
                        <button type="submit" name="update_password" class="bg-blue-600 text-white px-3 rounded hover:bg-blue-700 text-sm">Uložit</button>
                    </div>
                </form>
            </div>

            <!-- Nastavení hesla administrátora -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-md font-bold mb-3 text-gray-700">Změna hesla administrace</h3>
                <form method="post" class="bg-gray-50 p-4 rounded border">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <label class="block text-sm text-gray-600 mb-1">Nové heslo</label>
                    <div class="flex flex-col gap-2">
                        <input type="password" name="admin_password" class="w-full border p-2 rounded text-sm" placeholder="Nové heslo" required>
                        <input type="password" name="admin_password_confirm" class="w-full border p-2 rounded text-sm" placeholder="Potvrzení hesla" required>
                        <button type="submit" name="update_admin_password" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 text-sm font-bold">Změnit heslo</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Seznam -->
        <div class="lg:col-span-2 bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Obsah webu</h2>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="p-3">Pořadí</th>
                                <th class="p-3">Aktivní</th>
                                <th class="p-3">Sekce</th>
                                <th class="p-3">Kategorie</th>
                                <th class="p-3">Obsah</th>
                                <th class="p-3">Cíl odkazu</th>
                                <th class="p-3 text-right sticky right-0 bg-gray-100 border-l border-gray-200 shadow-sm z-10">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            $items = $pdo->query("SELECT * FROM practical_info ORDER BY section DESC, category, sort_order ASC, id DESC")->fetchAll();
                            foreach($items as $item):
                                $isUpload = strpos($item['link'], $uploadDir) === 0;
                            ?>
                            <tr class="group hover:bg-gray-50 transition">
                                <td class="p-3 w-20">
                                    <input type="number" name="items[<?= $item['id'] ?>][sort_order]" value="<?= $item['sort_order'] ?>" class="w-16 border p-1 rounded text-center">
                                </td>
                                <td class="p-3 w-16 text-center">
                                    <input type="checkbox" name="items[<?= $item['id'] ?>][is_active]" value="1" <?= $item['is_active'] ? 'checked' : '' ?> class="w-5 h-5 text-blue-600 rounded cursor-pointer">
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wide
                                        <?= $item['section'] == 'public' ? 'bg-gray-200 text-gray-700' : 'bg-purple-200 text-purple-800' ?>">
                                        <?= $item['section'] == 'public' ? 'Veřejné' : 'Kurzy' ?>
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        <?= $item['category'] == 'aktualne' ? 'bg-blue-100 text-blue-800' : 
                                           ($item['category'] == 'odkazy' ? 'bg-green-100 text-green-800' : 
                                           ($item['category'] == 'uzitecne' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($item['category'] == 'materialy' ? 'bg-purple-100 text-purple-800' :
                                           ($item['category'] == 'prezentace' ? 'bg-pink-100 text-pink-800' :
                                           ($item['category'] == 'dalsi' ? 'bg-gray-100 text-gray-800' : 'bg-indigo-100 text-indigo-800'))))) ?>">
                                        <?= $item['category'] ?>
                                    </span>
                                </td>
                                <td class="p-3">
                                    <div class="flex items-center">
                                        <div class="w-8 text-center text-gray-400 mr-3">
                                            <i class="fas fa-<?= htmlspecialchars($item['icon']) ?> text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900"><?= htmlspecialchars($item['title']) ?></div>
                                            <div class="text-xs text-gray-500"><?= htmlspecialchars($item['description']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3 text-xs font-mono text-gray-500 max-w-xs truncate">
                                    <?php if($isUpload): ?>
                                        <span class="text-orange-600 font-bold"><i class="fas fa-file-upload mr-1"></i> SOUBOR</span><br>
                                    <?php endif; ?>
                                    <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" class="hover:underline"><?= htmlspecialchars($item['link']) ?></a>
                                </td>
                                <td class="p-3 text-right sticky right-0 bg-white group-hover:bg-gray-50 border-l border-gray-200 shadow-sm z-10">
                                    <a href="?delete=<?= $item['id'] ?>" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded transition" onclick="return confirm('Opravdu smazat tuto položku? Pokud jde o nahraný soubor, bude smazán i z disku.')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <button type="submit" name="update_items" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold shadow transition">
                        <i class="fas fa-save mr-2"></i> Uložit změny
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        // Dynamické kategorie podle sekce
        const categories = {
            'public': [
                {val: 'aktualne', text: 'Aktuálně'},
                {val: 'odkazy', text: 'Odkazy'},
                {val: 'uzitecne', text: 'Užitečné'}
            ],
            'courses': [
                {val: 'materialy', text: 'Materiály'},
                {val: 'prezentace', text: 'Prezentace'},
                {val: 'dalsi', text: 'Další'}
            ]
        };

        function updateCategories(section) {
            const select = document.getElementById('categorySelect');
            select.innerHTML = '';
            categories[section].forEach(cat => {
                const opt = document.createElement('option');
                opt.setAttribute('value', cat.val); // Explicitně nastavit value
                opt.innerText = cat.text;
                select.appendChild(opt);
            });
            // Vybrat první možnost
            if (select.options.length > 0) {
                select.selectedIndex = 0;
            }
        }

        // Init based on current state (handles browser cache/reload)
        const currentSection = document.querySelector('input[name="section"]:checked').value;
        updateCategories(currentSection);

        // Jednoduchý script pro změnu ikony a náhledu
        function setIcon(iconName) {
            document.getElementById('iconInput').value = iconName;
            updatePreview();
        }
        
        document.getElementById('iconInput').addEventListener('input', updatePreview);

        function updatePreview() {
            const val = document.getElementById('iconInput').value;
            document.getElementById('iconPreview').className = 'fas fa-' + val;
        }
    </script>
</body>
</html>
