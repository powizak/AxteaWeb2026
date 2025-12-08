# Bezpečnostní a Rychlostní Audit - AxteaWeb2026

Tento dokument shrnuje výsledky bezpečnostního auditu a provedené změny v projektu.

## 1. Bezpečnostní Audit

### Nalezené a opravené problémy

1.  **Nahrávání souborů (Kritické)**
    *   **Problém:** Skript `admin.php` nekontroloval typ nahrávaného souboru. Útočník by mohl nahrát `.php` soubor a spustit ho na serveru.
    *   **Oprava:** Byla přidána kontrola přípon (whitelist: pdf, doc, jpg, png, atd.) a dvojitá kontrola po sanitizaci jména.
    *   **Oprava:** Do složky `uploads/` byl přidán `.htaccess`, který zakazuje spouštění PHP skriptů v této složce (Defense in Depth).

2.  **CSRF (Cross-Site Request Forgery)**
    *   **Problém:** Formuláře v `admin.php` nebyly chráněny proti CSRF útokům. Útočník by mohl podvrhnout formulář a donutit přihlášeného admina k akci.
    *   **Oprava:** Implementována ochrana pomocí `csrf_token` v session a ověření u všech POST požadavků.

3.  **Git Ignorování souborů**
    *   **Problém:** `node_modules/` a citlivé soubory nebyly kompletně v `.gitignore`.
    *   **Oprava:** Aktualizován `.gitignore`.

4.  **SQL Injection**
    *   **Stav:** Kód již používal `PDO` a připravené dotazy (`prepare/execute`). Toto bylo v pořádku, ale u `db.php` bylo ověřeno nastavení `PDO::ATTR_EMULATE_PREPARES => false`.

5.  **Bezpečnost hesel**
    *   **Stav:** Admin heslo je hashováno (`password_hash`).
    *   **Riziko:** Heslo pro kurzy je v databázi uloženo jako čistý text (`app_config`). Toto je "by design" pro jednoduché sdílení, ale v případě úniku DB bude heslo čitelné. Doporučeno v budoucnu hashovat i toto heslo, pokud to logika aplikace umožní (nyní se porovnává v `api.php`).

## 2. Rychlost a Optimalizace

### Nalezené a opravené problémy

1.  **Databázové Indexy**
    *   **Problém:** Tabulka `practical_info` neměla indexy na sloupce, podle kterých se často filtruje a řadí (`section`, `is_active`, `sort_order`).
    *   **Oprava:** Vytvořen soubor `db_indexes.sql` s příkazy pro přidání indexů. **Doporučujeme spustit tento SQL skript na vaší databázi.**

2.  **Build proces**
    *   **Problém:** Chyběly skripty pro minifikaci CSS.
    *   **Oprava:** Do `package.json` přidán skript `npm run build:css` pro minifikaci Tailwind CSS.

## 3. Doporučení pro další rozvoj

*   **HTTPS:** Zajistěte, aby web běžel na HTTPS (nastavení serveru).
*   **Zálohování:** Pravidelně zálohujte databázi a složku `uploads/`.
*   **Monitoring:** Sledujte `error_log` serveru pro případné problémy s aplikací.

---
*Audit provedl AI Asistent, 2025.*
