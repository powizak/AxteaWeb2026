<!DOCTYPE html>
<html lang="cs" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AXTEA | Daně a účetnictví s tradicí</title>
    <meta name="description" content="Komplexní daňové a účetní služby v Plzni. Tradice, odbornost a rodinný přístup od roku 1992.">
    
    <!-- Favicony -->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="shortcut icon" href="/img/favicon.ico">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- 1. GOOGLE CONSENT MODE V2 -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied',
            'wait_for_update': 500
        });
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#004b9c',
                        secondary: '#1a5da5',
                        dark: '#1d1d1c',
                        light: '#f3f4f6'
                    },
                    fontFamily: {
                        sans: ['Helvetica', 'sans-serif'],
                        serif: ['Helvetica', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-bg {
            background: radial-gradient(circle at center, #004b9c 0%, #002855 100%);
            position: relative;
            overflow: hidden;
        }
         #hero-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Nejnižší vrstva v rámci sekce */
        }
        .hero-content {
            position: relative;
            z-index: 10;
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        
        .toggle-checkbox:checked {
            right: 0;
            border-color: #004b9c;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #004b9c;
        }
    </style>
</head>
<body class="font-sans text-gray-700 bg-gray-50">

    <!-- Navigace -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <!-- LOGO s jemným pozadím pro čitelnost -->
                    <a href="#" class="px-2 py-1 rounded transition hover:opacity-80">
                        <img src="/img/logo.svg" alt="AXTEA" id="nav-logo" class="h-10 md:h-12 w-auto transition filter duration-300 brightness-0 invert">
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <!-- Odkazy mají defaultně 'text-white' pro zobrazení na tmavém pozadí -->
                        <a href="#sluzby" class="nav-link text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:shadow-[0_0_10px_rgba(255,255,255,0.3)]">Služby</a>
                        <a href="#o-nas" class="nav-link text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:shadow-[0_0_10px_rgba(255,255,255,0.3)]">O nás</a>
                        <a href="#prakticke" class="nav-link text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:shadow-[0_0_10px_rgba(255,255,255,0.3)]">Praktické info</a>
                        <a href="#kurzy" class="nav-link text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 hover:shadow-[0_0_10px_rgba(255,255,255,0.3)]">Semináře</a>
                        <a href="#kontakt" class="bg-primary text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-blue-800 transition shadow-lg transform hover:scale-105 border border-transparent hover:shadow-[0_0_15px_rgba(26,93,165,0.6)]">Kontaktovat</a>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <!-- Ikona má defaultně 'text-white' -->
                    <button id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white/90 backdrop-blur-md shadow-lg absolute w-full" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#sluzby" class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Služby</a>
                <a href="#o-nas" class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">O nás</a>
                <a href="#prakticke" class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Praktické info</a>
                <a href="#kurzy" class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Semináře</a>
                <a href="#kontakt" class="text-primary font-bold block px-3 py-2 rounded-md text-base">Kontakt</a>
            </div>
        </div>
    </nav>

    <!-- Hero Sekce -->
    <section class="hero-bg h-screen flex items-center justify-center relative">
         <!-- Canvas pro animaci -->
        <canvas id="hero-canvas"></canvas>

        <!-- Obsah (Text) -->
        <div class="text-center px-4 max-w-4xl mx-auto hero-content">
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-8 fade-in-up drop-shadow-md">
                Počítáme s vámi
            </h1>
            <div class="flex flex-col sm:flex-row justify-center gap-4 fade-in-up delay-200">
                <a href="#sluzby" class="bg-white text-primary px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg hover:shadow-[0_0_20px_rgba(255,255,255,0.5)]">
                    Naše služby
                </a>
                <a href="#kontakt" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-primary transition backdrop-blur-sm hover:shadow-[0_0_20px_rgba(255,255,255,0.5)]">
                    Sjednat schůzku
                </a>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 animate-bounce text-white text-2xl z-10">
            <a href="#sluzby" class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-white/20 text-white hover:bg-white hover:text-primary transition-all duration-300 backdrop-blur-sm hover:shadow-[0_0_20px_rgba(255,255,255,0.4)]">
                <i class="fas fa-chevron-down text-xl"></i>
            </a>
        </div>
    </section>

    <!-- Služby -->
    <section id="sluzby" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif font-bold text-primary mb-4">Co pro vás zajistíme</h2>
                <div class="w-20 h-1 bg-primary mx-auto rounded mb-8"></div>
                <p class="text-gray-600 max-w-3xl mx-auto text-lg leading-relaxed">
                    Poskytujeme servis pro právnické a fyzické osoby, které chtějí svoji ekonomicko-administrativní agendu nebo její část zabezpečit spoluprací s externí specializovanou firmou.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Karta 1 -->
                <div class="p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition border border-gray-100 group hover:-translate-y-1 duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary group-hover:bg-primary group-hover:text-white transition">
                        <i class="fas fa-calculator text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Daňové poradenství</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-2 flex-shrink-0"></i>
                            <span class="text-sm text-gray-600 leading-relaxed">Vypracování daňových přiznání k jednotlivým daním (z příjmů, z nemovitých věcí a jejich nabytí, DPH včetně souvisejících hlášení, silniční, spotřební).</span>
                        </li>
                    </ul>
                </div>

                <!-- Karta 2 -->
                <div class="p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition border border-gray-100 group hover:-translate-y-1 duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary group-hover:bg-primary group-hover:text-white transition">
                        <i class="fas fa-file-invoice text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Ekonomicko-organizační poradenství</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                             <i class="fas fa-check-circle text-primary mt-1 mr-2 flex-shrink-0"></i>
                            <span class="text-sm text-gray-600 leading-relaxed">Poradenství při developerských projektech</span>
                        </li>
                        <li class="flex items-start">
                             <i class="fas fa-check-circle text-primary mt-1 mr-2 flex-shrink-0"></i>
                            <span class="text-sm text-gray-600 leading-relaxed">Přeměny společností</span>
                        </li>
                    </ul>
                </div>

                <!-- Karta 3 -->
                <div class="p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition border border-gray-100 group hover:-translate-y-1 duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary group-hover:bg-primary group-hover:text-white transition">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Vedení agend</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                             <i class="fas fa-check-circle text-primary mt-1 mr-2 flex-shrink-0"></i>
                            <span class="text-sm text-gray-600 leading-relaxed">účetnictví, mzdové agendy, daňové evidence</span>
                        </li>
                        <li class="flex items-start">
                             <i class="fas fa-check-circle text-primary mt-1 mr-2 flex-shrink-0"></i>
                            <span class="text-sm text-gray-600 leading-relaxed">Zpracování přidružených výkazů (bankovní, statistické)</span>
                        </li>
                        <li class="flex items-start">
                             <i class="fas fa-check-circle text-primary mt-1 mr-2 flex-shrink-0"></i>
                            <span class="text-sm text-gray-600 leading-relaxed">Kalkulace</span>
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
    </section>

    <!-- Jak probíhá spolupráce -->
    <section class="py-20 bg-primary text-white relative overflow-hidden">
        <!-- Decorative background element -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 rounded-full bg-blue-400 blur-3xl"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl font-serif font-bold text-white mb-8">Jak probíhá spolupráce</h2>
            <div class="w-20 h-1 bg-blue-300 mx-auto rounded mb-10"></div>
            
            <p class="text-blue-50 text-lg leading-relaxed mb-8">
                Konkrétní podobu výkonů vždy upravujeme na míru podle vašich požadavků. Obvykle spolupracujeme s klienty pravidelně, ať jde o týdenní, měsíční nebo roční režim, podle povahy věci. Jednorázové poskytnutí našich služeb oceníte v situaci, kdy vaše aktivity a projekty stojí na křižovatce a pro rozhodnutí o dalším vývoji potřebujete kvalitní, fundované a vysoce individualizované rady ve věcech, kterým rozumíme.
            </p>
            
            <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 inline-block hover:bg-white/15 transition duration-300">
                <p class="text-white text-xl font-semibold leading-relaxed">
                    <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                    Situace, které to svojí povahou vyžadují, zastřešíme udělením plné moci.
                </p>
            </div>

            <div class="mt-12 max-w-2xl mx-auto bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 shadow-2xl text-left relative overflow-hidden group hover:bg-white/15 transition duration-300">
                <div class="absolute top-0 left-0 w-1 h-full bg-blue-300 shadow-[0_0_15px_rgba(147,197,253,0.5)]"></div>
                <p class="font-serif font-bold text-xl mb-4 text-white flex items-center">
                    <i class="fas fa-coins text-blue-300 mr-3 text-2xl"></i>
                    Kolik to bude stát
                </p>

                <p class="text-blue-50 leading-relaxed text-lg">
                    Běžná sazba služeb daňového poradenství činí <span class="font-bold text-white bg-white/10 px-2 py-1 rounded">2 200 Kč / hod + DPH</span>. 
                    Lze dohodnout také sazbu úkolovou. V rámci dlouhodobé spolupráce lze dohodnout paušální odměnu.
                </p>
            </div>
        </div>
    </section>

    <!-- O nás / Tým -->
    <section id="o-nas" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div>
                    <h2 class="text-3xl font-serif font-bold text-primary mb-6">Tradice, odbornost a etické zásady</h2>
                    <div class="flex flex-col sm:flex-row gap-6 items-start mb-4">
                        <p class="text-gray-600 leading-relaxed flex-1">

                        AXTEA s.r.o. je rodinná firma, která navazuje na činnost kanceláře založené v roce 1992 ekonomem Radimem Pavelkem (člen Komory daňových poradců od roku 1994). Jeho erudice a mnohaleté zkušenosti v daňovém poradenství přinášejí naší společnosti odborné zakotvení. Náš pracovní tým je dlouhodobě stabilní, s oporou v rodinné tradici. Vedle poradenství se věnujeme lektorské a vzdělávací činnosti.
                        </p>
                        <div class="flex-shrink-0 mx-auto sm:mx-0">
                            <a href="https://www.kdpcr.cz/" target="_blank" rel="noopener noreferrer" class="block transform hover:scale-105 transition duration-300">
                                <img src="/img/logo-kdp-cr-orig.webp" alt="Logo Komory daňových poradců ČR" class="w-32 h-auto drop-shadow-md hover:drop-shadow-xl">
                            </a>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Jako společnost jsme zapsáni v seznamu <a href="/files/osvedceni-axtea.pdf" target="_blank" rel="noopener noreferrer" class="text-primary font-medium hover:underline">Komory daňových poradců ČR</a> a garantujeme dodržování <a href="/files/eticky-kodex.pdf" target="_blank" rel="noopener noreferrer" class="text-primary font-medium hover:underline">etického kodexu Komory</a>. Zásada mlčenlivosti a sjednané pojištění výkonu daňového poradenství jsou pro nás samozřejmostí.
                   </p>
                </div>
                <div class="hidden">
                    <!-- Team Grid -->
                    
                    <!-- Ing. Radim Pavelek -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_RaPa.svg" alt="QR Kód kontakt Ing. Radim Pavelek" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Radim Pavelek</h4>
                        <p class="text-xs text-primary font-semibold mb-2">daňový poradce ev. č. 846</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420775215110" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 775 215 110</a>
                            <a href="mailto:pavelek@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> pavelek@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Ing. Renata Pavelek -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_RePa.svg" alt="QR Kód kontakt Ing. Renata Pavelek" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Renata Pavelek</h4>
                        <p class="text-xs text-primary font-semibold mb-2">správa kanceláře</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420775227891" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 775 227 891</a>
                            <a href="mailto:renatapavelek@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> renatapavelek@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Ing. Alžběta Rejtmajerová -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_AlRe.svg" alt="QR Kód kontakt Ing. Alžběta Rejtmajerová" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Alžběta Rejtmajerová</h4>
                        <p class="text-xs text-primary font-semibold mb-2">mzdová a personální agenda, účetnictví</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420732223938" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 732 223 938</a>
                            <a href="mailto:rejtmajerova@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> rejtmajerova@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Petra Pachová -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_PePa.svg" alt="QR Kód kontakt Petra Pachová" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Petra Pachová</h4>
                        <p class="text-xs text-primary font-semibold mb-2">účetnictví, daňová evidence</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420777652521" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 777 652 521</a>
                            <a href="mailto:pachova@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> pachova@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Ing. Štěpánka Schreiberová -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_StSch.svg" alt="QR Kód kontakt Ing. Štěpánka Schreiberová" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Štěpánka Schreiberová</h4>
                        <p class="text-xs text-primary font-semibold mb-2">účetnictví, daňová evidence</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420773508226" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 773 508 226</a>
                            <a href="mailto:schreiberova@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> schreiberova@axtea.cz</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontakt -->
    <section id="kontakt" class="py-20 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif font-bold text-primary mb-4">Kontaktujte nás</h2>
                <p class="text-gray-600">Vždy je nutné si sjednat schůzku předem – díky tomu jsme lépe připraveni řešit váš požadavek a jednání je rychlejší a efektivnější. Po dohodě se vám rádi budeme věnovat i v méně obvyklém čase.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Kontaktní info -->
                <div class="lg:w-1/3 bg-primary text-white p-10 rounded-2xl shadow-xl">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="text-2xl font-serif font-bold mb-2">AXTEA s.r.o.</h3>
                            <p class="text-sm opacity-90">IČ: 26394456</p>
                            <p class="text-sm opacity-90">DIČ: CZ26394456</p>
                            <p class="text-sm opacity-90">Obchodní rejstřík: KS v Plzni, C 17557</p>
                            <p class="text-sm opacity-90">Datová schránka: 9gxqehu</p>
                        </div>
                        <!-- QR CODE -->
                        <div class="bg-white p-2 rounded-lg shadow-sm flex-shrink-0">
                            <img src="/img/contact-qr-code.svg" alt="QR Kód Kontakt AXTEA s.r.o." class="w-20 h-20">
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 w-6 text-blue-300"></i>
                            <div>
                                <p class="font-semibold">Adresa</p>
                                <p class="text-blue-100 text-sm">Nohova 1398/19<br>326 00 Plzeň</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-phone mt-1 w-6 text-blue-300"></i>
                            <div>
                                <p class="font-semibold">Telefon</p>
                                <a href="tel:+420377455434" class="text-blue-100 text-sm hover:text-white">+420 377 455 434</a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-envelope mt-1 w-6 text-blue-300"></i>
                            <div>
                                <p class="font-semibold">E-mail</p>
                                <a href="mailto:renatapavelek@axtea.cz" class="text-blue-100 text-sm hover:text-white">renatapavelek@axtea.cz</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-clock mt-1 w-6 text-blue-300"></i>
                            <div>
                                <p class="font-semibold">Základní pracovní doba</p>
                                <p class="text-blue-100 text-sm">Po-Pá 8:00 – 12:00; 13:00 – 16:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mapa -->
                <div class="lg:w-2/3 h-80 lg:h-auto rounded-2xl overflow-hidden shadow-lg border border-gray-200">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2578.6886259958574!2d13.4020502!3d49.7354855!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470af1d7d38d06ab%3A0xec6ae4b2f6353251!2sNohova%201398%2F19%2C%20326%2000%20Plze%C5%88%202-Slovany!5e0!3m2!1scs!2scz!4v1700000000000!5m2!1scs!2scz" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Team Grid -->
            <div class="mt-16">
                <h3 class="text-2xl font-serif font-bold text-primary mb-8 text-center">Náš tým</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                    <!-- Ing. Radim Pavelek -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300 border border-gray-100">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_RaPa.svg" alt="QR Kód kontakt Ing. Radim Pavelek" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Radim Pavelek</h4>
                        <p class="text-xs text-primary font-semibold mb-2">daňový poradce ev. č. 846</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420775215110" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 775 215 110</a>
                            <a href="mailto:pavelek@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> pavelek@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Ing. Renata Pavelek -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300 border border-gray-100">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_RePa.svg" alt="QR Kód kontakt Ing. Renata Pavelek" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Renata Pavelek</h4>
                        <p class="text-xs text-primary font-semibold mb-2">správa kanceláře</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420775227891" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 775 227 891</a>
                            <a href="mailto:renatapavelek@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> renatapavelek@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Ing. Alžběta Rejtmajerová -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300 border border-gray-100">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_AlRe.svg" alt="QR Kód kontakt Ing. Alžběta Rejtmajerová" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Alžběta Rejtmajerová</h4>
                        <p class="text-xs text-primary font-semibold mb-2">mzdová a personální agenda, účetnictví</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420732223938" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 732 223 938</a>
                            <a href="mailto:rejtmajerova@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> rejtmajerova@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Petra Pachová -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300 border border-gray-100">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_PePa.svg" alt="QR Kód kontakt Petra Pachová" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Petra Pachová</h4>
                        <p class="text-xs text-primary font-semibold mb-2">účetnictví, daňová evidence</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420777652521" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 777 652 521</a>
                            <a href="mailto:pachova@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> pachova@axtea.cz</a>
                        </div>
                    </div>

                    <!-- Ing. Štěpánka Schreiberová -->
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-lg transition duration-300 border border-gray-100">
                        <div class="w-32 h-32 mx-auto mb-3">
                            <img src="img/QR_StSch.svg" alt="QR Kód kontakt Ing. Štěpánka Schreiberová" class="w-full h-full object-contain">
                        </div>
                        <h4 class="font-bold text-sm text-gray-800">Ing. Štěpánka Schreiberová</h4>
                        <p class="text-xs text-primary font-semibold mb-2">účetnictví, daňová evidence</p>
                        <div class="text-xs space-y-1">
                            <a href="tel:+420773508226" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-phone mr-1"></i> +420 773 508 226</a>
                            <a href="mailto:schreiberova@axtea.cz" class="block text-gray-500 hover:text-primary transition"><i class="fas fa-envelope mr-1"></i> schreiberova@axtea.cz</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Praktické informace (Dynamická sekce) -->
    <section id="prakticke" class="py-16 bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-serif font-bold text-white mb-10 border-b border-gray-700 pb-4">Praktické informace</h2>
            
            <!-- Loader -->
            <div id="practical-loader" class="text-center py-10">
                <i class="fas fa-spinner fa-spin text-3xl text-blue-500"></i>
            </div>

            <div id="practical-content" class="flex flex-col md:flex-row gap-10 hidden">
                
                <!-- Sloupec 1: Aktuálně -->
                <div id="col-aktualne" class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3"><i class="fas fa-bullhorn"></i></span>
                        Aktuálně
                    </h3>
                    <ul class="space-y-4" id="list-aktualne">
                        <!-- Data načtena přes JS -->
                    </ul>
                </div>

                <!-- Sloupec 2: Odkazy -->
                <div id="col-odkazy" class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <span class="bg-green-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3"><i class="fas fa-link"></i></span>
                        Odkazy
                    </h3>
                    <ul class="space-y-4" id="list-odkazy">
                         <!-- Data načtena přes JS -->
                    </ul>
                </div>

                <!-- Sloupec 3: Užitečné -->
                <div id="col-uzitecne" class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <span class="bg-purple-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3"><i class="fas fa-info"></i></span>
                        Užitečné
                    </h3>
                    <ul class="space-y-4" id="list-uzitecne">
                         <!-- Data načtena přes JS -->
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Sekce pro účastníky kurzů -->
    <section class="py-16 bg-gray-50" id="kurzy">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-primary mb-4">Sekce pro účastníky seminářů</h2>
                <p class="text-gray-600 mb-8">Tato sekce je přístupná pouze s heslem, které jste obdrželi na semináři.</p>
                
                <!-- Login Form -->
                <div id="course-login" class="max-w-md mx-auto">
                    <div class="flex gap-2">
                        <input type="password" id="course-password" placeholder="Zadejte heslo..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                        <button onclick="loadCourseMaterials()" class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-dark transition duration-300">
                            Zobrazit
                        </button>
                    </div>
                    <p id="course-error" class="text-red-500 text-sm mt-2 hidden">Nesprávné heslo.</p>
                </div>
            </div>

            <!-- Hidden Content -->
            <div id="course-content" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Materiály -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full flex flex-col">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                                <i class="fas fa-book-open text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Studijní materiály</h3>
                        </div>
                        <ul class="space-y-4 flex-grow" id="list-materialy"></ul>
                    </div>

                    <!-- Prezentace -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full flex flex-col">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                                <i class="fas fa-desktop text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Prezentace</h3>
                        </div>
                        <ul class="space-y-4 flex-grow" id="list-prezentace"></ul>
                    </div>

                    <!-- Další -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full flex flex-col">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                                <i class="fas fa-folder-open text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Další soubory</h3>
                        </div>
                        <ul class="space-y-4 flex-grow" id="list-dalsi"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-gray-500 py-8 text-center text-sm">
        <p>&copy; 2025 AXTEA s.r.o. | Vytvořeno s důrazem na rychlost a design.</p>
        <p class="mt-2"><a href="vos.php" class="text-gray-700 hover:text-gray-400">vstup VOS (zákon č. 253 / 2008 Sb.)</a></p>
    </footer>

    <!-- 2. COOKIE BANNER HTML -->
    <div id="cookie-banner" class="fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-2xl z-50 hidden p-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-sm text-gray-600 md:w-2/3">
                <p class="font-bold text-gray-800 text-lg mb-2">Vážíme si vašeho soukromí</p>
                <p>
                    Používáme soubory cookies k zajištění funkčnosti webu a s vaším souhlasem i k personalizaci obsahu a analýze návštěvnosti. 
                    Kliknutím na „Přijmout vše“ souhlasíte s využíváním všech cookies. Nastavení můžete kdykoli změnit.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <button onclick="CookieConsent.showSettings()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-100 transition text-sm">Nastavení</button>
                <button onclick="CookieConsent.rejectAll()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-100 transition text-sm">Odmítnout vše</button>
                <button onclick="CookieConsent.acceptAll()" class="px-6 py-2 bg-primary text-white rounded font-bold hover:bg-blue-800 transition shadow-md text-sm">Přijmout vše</button>
            </div>
        </div>
    </div>

    <!-- 3. COOKIE SETTINGS MODAL -->
    <div id="cookie-settings" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Nastavení cookies</h3>
                <button onclick="CookieConsent.hideSettings()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="p-6 space-y-6">
                <!-- Nezbytné -->
                <div class="flex justify-between items-start">
                    <div class="pr-4">
                        <h4 class="font-bold text-gray-800">Nezbytné (Technické)</h4>
                        <p class="text-sm text-gray-500 mt-1">Nutné pro správné fungování webu. Nelze je vypnout.</p>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" checked disabled class="opacity-50 absolute block w-6 h-6 bg-gray-400 rounded-full border-4 appearance-none cursor-not-allowed"/>
                        <label class="block overflow-hidden h-6 rounded-full bg-gray-300 cursor-not-allowed"></label>
                    </div>
                </div>
                
                <!-- Analytické -->
                <div class="flex justify-between items-start">
                    <div class="pr-4">
                        <h4 class="font-bold text-gray-800">Analytické a statistické</h4>
                        <p class="text-sm text-gray-500 mt-1">Pomáhají nám měřit návštěvnost a zlepšovat web (např. Google Analytics).</p>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="toggle" id="toggle-analytics" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                        <label for="toggle-analytics" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                <!-- Marketingové -->
                <div class="flex justify-between items-start">
                    <div class="pr-4">
                        <h4 class="font-bold text-gray-800">Marketingové</h4>
                        <p class="text-sm text-gray-500 mt-1">Pro personalizaci reklam a propojení se sociálními sítěmi.</p>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="toggle" id="toggle-marketing" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                        <label for="toggle-marketing" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3 bg-gray-50 rounded-b-lg">
                <button onclick="CookieConsent.saveSettings()" class="px-6 py-2 bg-primary text-white rounded font-bold hover:bg-blue-800 transition">Uložit nastavení</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Navbar scroll effect & Color Switch (Updated)
        function updateNavbar() {
            const nav = document.getElementById('navbar');
            const links = document.querySelectorAll('.nav-link');
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const logo = document.getElementById('nav-logo');

            if (window.scrollY > 50) {
                // Scrolled state (White bg, Dark text)
                nav.classList.add('bg-white/95', 'shadow-md', 'backdrop-blur-sm');
                links.forEach(link => {
                    link.classList.remove('text-white', 'hover:text-blue-200');
                    link.classList.add('text-gray-700', 'hover:text-primary');
                });
                mobileBtn.classList.remove('text-white', 'hover:text-blue-200');
                mobileBtn.classList.add('text-gray-700', 'hover:text-primary');
                if(logo) logo.classList.remove('brightness-0', 'invert');

            } else {
                // Top state (Transparent bg, White text)
                nav.classList.remove('bg-white/95', 'shadow-md', 'backdrop-blur-sm');
                links.forEach(link => {
                    link.classList.remove('text-gray-700', 'hover:text-primary');
                    link.classList.add('text-white', 'hover:text-blue-200');
                });
                mobileBtn.classList.remove('text-gray-700', 'hover:text-primary');
                mobileBtn.classList.add('text-white', 'hover:text-blue-200');
                if(logo) logo.classList.add('brightness-0', 'invert');
            }
        }
        window.addEventListener('scroll', updateNavbar);
        document.addEventListener('DOMContentLoaded', updateNavbar);

        // Mobile menu auto-close
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileLinks = mobileMenu.querySelectorAll('a');
            
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        });

        // Načítání praktických informací z API
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('practical-loader');
            const content = document.getElementById('practical-content');
            
            fetch('api.php?t=' + new Date().getTime())
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        console.error("DB Error:", data.error);
                        return; 
                    }

                    const renderItem = (item) => `
                        <li class="group">
                            <a href="${item.link}" target="_blank" class="block p-4 rounded bg-gray-800 hover:bg-gray-700 transition border-l-4 border-transparent hover:border-blue-500">
                                <div class="flex items-start">
                                    <i class="fas fa-${item.icon || 'file'} mt-1 mr-3 text-gray-500 group-hover:text-white transition"></i>
                                    <div>
                                        <strong class="block text-white group-hover:text-blue-300 transition">${item.title}</strong>
                                        <span class="text-xs text-gray-400">${item.description}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    `;

                    // Funkce pro obsluhu zobrazení/skrytí sloupce
                    const handleColumn = (dataArray, listId, colId) => {
                        const col = document.getElementById(colId);
                        const list = document.getElementById(listId);
                        
                        if (dataArray && dataArray.length > 0) {
                            list.innerHTML = dataArray.map(renderItem).join('');
                            col.classList.remove('hidden');
                        } else {
                            col.classList.add('hidden');
                        }
                    };

                    handleColumn(data.aktualne, 'list-aktualne', 'col-aktualne');
                    handleColumn(data.odkazy, 'list-odkazy', 'col-odkazy');
                    handleColumn(data.uzitecne, 'list-uzitecne', 'col-uzitecne');

                    loader.classList.add('hidden');
                    content.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Chyba načítání:', error);
                    loader.innerHTML = "<p class='text-red-500'>Nepodařilo se načíst data z databáze (API).</p>";
                });
        });

        // 4. COOKIE CONSENT LOGIC
        const CookieConsent = {
            banner: document.getElementById('cookie-banner'),
            settings: document.getElementById('cookie-settings'),
            
            init: function() {
                // Kontrola, zda již bylo rozhodnuto
                const savedConsent = localStorage.getItem('cookie_consent');
                if (!savedConsent) {
                    this.banner.classList.remove('hidden');
                } else {
                    // Pokud bylo uloženo, aplikujeme nastavení
                    const consent = JSON.parse(savedConsent);
                    this.updateGCM(consent);
                    this.loadScripts(consent);
                }
            },

            showSettings: function() {
                this.settings.classList.remove('hidden');
            },

            hideSettings: function() {
                this.settings.classList.add('hidden');
            },

            acceptAll: function() {
                const consent = { analytics: true, marketing: true };
                this.save(consent);
            },

            rejectAll: function() {
                const consent = { analytics: false, marketing: false };
                this.save(consent);
            },

            saveSettings: function() {
                const analytics = document.getElementById('toggle-analytics').checked;
                const marketing = document.getElementById('toggle-marketing').checked;
                const consent = { analytics, marketing };
                this.save(consent);
            },

            save: function(consent) {
                localStorage.setItem('cookie_consent', JSON.stringify(consent));
                this.updateGCM(consent);
                this.loadScripts(consent);
                this.banner.classList.add('hidden');
                this.settings.classList.add('hidden');
            },

            // Aktualizace Google Consent Mode
            updateGCM: function(consent) {
                if (typeof gtag === 'function') {
                    gtag('consent', 'update', {
                        'ad_storage': consent.marketing ? 'granted' : 'denied',
                        'ad_user_data': consent.marketing ? 'granted' : 'denied',
                        'ad_personalization': consent.marketing ? 'granted' : 'denied',
                        'analytics_storage': consent.analytics ? 'granted' : 'denied'
                    });
                }
            },

            // Reálné načtení skriptů (Pokud nepoužíváte GTM/GCM automatiku)
            loadScripts: function(consent) {
                // Příklad: Pokud uživatel souhlasil s analytikou, můžeme manuálně vložit skript
                /*
                if (consent.analytics && !window.analyticsLoaded) {
                    // Vložení GA scriptu
                    // window.analyticsLoaded = true;
                }
                */
                console.log("Cookie Consent Updated:", consent);
            }
        };

        // Spuštění logiky po načtení
        document.addEventListener('DOMContentLoaded', function() {
            CookieConsent.init();
        });

        // 6. LOGIKA PRO KURZY (Heslo)
        function loadCourseMaterials() {
            const password = document.getElementById('course-password').value;
            const errorMsg = document.getElementById('course-error');
            const loginDiv = document.getElementById('course-login');
            const contentDiv = document.getElementById('course-content');

            // Odeslání hesla na API
            fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'password=' + encodeURIComponent(password)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Heslo je správné -> Skrýt login, zobrazit obsah
                    loginDiv.classList.add('hidden');
                    contentDiv.classList.remove('hidden');
                    errorMsg.classList.add('hidden');

                    // Funkce pro vykreslení položek
                    const renderList = (items, elementId) => {
                        const list = document.getElementById(elementId);
                        if (!items || items.length === 0) {
                            list.innerHTML = '<li class="text-gray-400 italic text-sm">Žádné soubory.</li>';
                            return;
                        }
                        list.innerHTML = items.map(item => `
                            <li>
                                <a href="${item.link}" target="_blank" class="flex items-center p-3 rounded hover:bg-gray-50 transition group border border-transparent hover:border-gray-200">
                                    <i class="fas fa-${item.icon || 'file'} text-gray-400 group-hover:text-primary mr-3 transition"></i>
                                    <div>
                                        <span class="block text-gray-700 font-medium group-hover:text-primary transition">${item.title}</span>
                                        ${item.description ? `<span class="text-xs text-gray-500">${item.description}</span>` : ''}
                                    </div>
                                </a>
                            </li>
                        `).join('');
                    };

                    renderList(data.materialy, 'list-materialy');
                    renderList(data.prezentace, 'list-prezentace');
                    renderList(data.dalsi, 'list-dalsi');

                } else {
                    // Chyba
                    errorMsg.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                errorMsg.textContent = "Chyba spojení.";
                errorMsg.classList.remove('hidden');
            });
        }

        // 5. PARTICLE NETWORK ANIMATION (Hvězdkupa)
        (function() {
            const canvas = document.getElementById('hero-canvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];

            // Konfigurace
            const particleCount = window.innerWidth < 768 ? 40 : 90; // Méně bodů na mobilu
            const connectionDistance = 150;
            const mouseDistance = 200;

            // Inicializace velikosti
            function resize() {
                width = canvas.width = canvas.parentElement.offsetWidth;
                height = canvas.height = canvas.parentElement.offsetHeight;
            }
            window.addEventListener('resize', () => {
                resize();
                initParticles(); // Reset při změně velikosti
            });
            resize();

            // Třída pro částici
            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.vx = (Math.random() - 0.5) * 0.5; // Rychlost X
                    this.vy = (Math.random() - 0.5) * 0.5; // Rychlost Y
                    this.size = Math.random() * 2 + 1;
                    // Náhodná číslice 0-9
                    this.char = String(Math.floor(Math.random() * 10));
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    // Odraz od stěn
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }

                draw() {
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
                    ctx.font = '12px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(this.char, this.x, this.y);
                }
            }

            function initParticles() {
                particles = [];
                for (let i = 0; i < particleCount; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                
                // Aktualizace a vykreslení bodů
                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();

                    // Vykreslení čar (spojení)
                    for (let j = i; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < connectionDistance) {
                            ctx.beginPath();
                            // Opacity podle vzdálenosti (čím blíže, tím viditelnější)
                            const opacity = 1 - (distance / connectionDistance);
                            ctx.strokeStyle = `rgba(255, 255, 255, ${opacity * 0.2})`; 
                            ctx.lineWidth = 1;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(animate);
            }

            initParticles();
            animate();
        })();
    </script>
</body>
</html>