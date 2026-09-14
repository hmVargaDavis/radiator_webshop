# Radiátor Outlet Budapest - Laravel webshop

PHP / Laravel webshop 22K panelradiátorokhoz. Bootstrap 5, mobil first, adminfelület, kosár, rendelés, e-mail visszaigazolás, SEO.

## Indítás (helyi)

1. XAMPP PHP 8.2+ legyen elérhető (`php`, `composer`).
2. A projekt mappájában:

```bash
composer install
copy .env.example .env   # ha kell
php artisan key:generate
```

3. Adatbázis:
   - **Gyors helyi indítás (SQLite):** a `.env`-ben `DB_CONNECTION=sqlite` (alapértelmezett).
   - **MySQL (éles / XAMPP):** hozd létre a `radiator_webshop` adatbázist, majd:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=radiator_webshop
DB_USERNAME=root
DB_PASSWORD=
```

4. Migráció és mintaadatok:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

5. Böngésző: http://127.0.0.1:8000

## Admin

- URL: `/admin/login`
- E-mail: `admin@radiatoroutlet.hu` (`.env` → `ADMIN_EMAIL`)
- Jelszó: `Admin123!` (`.env` → `ADMIN_PASSWORD`) - élesben azonnal cseréld!

Az adminban módosíthatók: termékek (méret, ár, fotó, leírás, készlet), vélemények, rendelések, szövegek / szállítási díj / SEO.

## E-mail

Alapból `MAIL_MAILER=log` (a `storage/logs/laravel.log`-ba ír). Éles SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=rendeles@radiatoroutlet.hu
SHOP_OWNER_EMAIL=te@email.hu
```

## HTTPS / SSL

Éles tárhelyen állítsd be az SSL-t (Let's Encrypt / tárhely panel), és:

```env
APP_URL=https://domain.hu
```

## Admin (Shopify-szerű)

- URL: `/admin/login`
- Kezdőlap KPI-k, forgalmi források, eszközök, grafikonok
- Analitika: referrerek, UTM, böngészők, órák, top oldalak
- SEO: termék SEO score, checklist, organikus útvonalak
- Globális keresés, SPA navigáció, mobil tab bar
- Látogatás követés automatikus (admin/API kivételével)

## Mobil / PWA / Admin SPA

- Mobil alsó navigáció (app-szerű tabok)
- PWA: `manifest.webmanifest` + `sw.js` (Add to Home Screen)
- Admin: SPA navigáció AJAX-szal (`/js/admin-spa.js`), mobil alsó tabok, sticky sidebar asztalin

## SEO / GEO / AI

- Sitemap: `/sitemap.xml` (kép geo_location: Budapest)
- AI katalógus: `/api/katalogus.json`
- Termék AI JSON: `/radiatorok/{slug}.json` (schema.org Product + üzleti/GEO mezők)
- `llms.txt`: `/llms.txt`
- Minden oldalon LocalBusiness + geo meta; termékeken Offer + shippingDetails (Budapest)
- Adminban szerkeszthető: SEO cím, leírás, kulcsszavak, AI leírás

## Főbb funkciók

- Főoldal szekciók: radiátorok, csomag tartalma, szállítás, vélemények, kapcsolat
- Termékoldalak külön URL-lel (SEO + schema.org)
- Darabszám 1-50, kosár, megrendelés
- Admin és vásárlói e-mail a rendelésről
- Mobil sticky kosár + Hívás gomb
