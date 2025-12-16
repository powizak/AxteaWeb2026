<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOS | AXTEA s.r.o.</title>
    
    <!-- Favicony -->
    <link rel="shortcut icon" href="/img/favicon.ico">

    <!-- Tailwind CSS (Local Build) -->
    <link rel="stylesheet" href="dist/styles.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 h-screen flex flex-col overflow-hidden">

    <header class="bg-white shadow-md border-b border-gray-100 py-3 px-4 md:px-8 flex justify-between items-center z-20 shrink-0 h-16">
        <h1 class="text-xl md:text-2xl font-serif font-bold text-gray-800 tracking-tight">Vnitřní oznamovací systém</h1>
        <a href="index.php" class="inline-flex items-center justify-center px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-secondary transition duration-300 shadow hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i> Zpět
        </a>
    </header>

    <main class="flex-grow w-full relative z-10">
        <iframe 
            src="files/VOS-AX.pdf" 
            class="absolute inset-0 w-full h-full" 
            title="VOS - AXTEA s.r.o.">
            <p class="text-center p-8 bg-gray-100">
                Váš prohlížeč nepodporuje zobrazení PDF. 
                <a href="files/VOS-AX.pdf" class="text-primary font-bold hover:underline">Stáhněte si soubor zde</a>.
            </p>
        </iframe>
    </main>

</body>
</html>
