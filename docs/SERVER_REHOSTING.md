# EMIS server rehosting checklist

This package includes the standardized interface and the revised sidebar:

- Dashboard is a standalone first item.
- Admin, Management, Audit, and Settings remain grouped menus.
- All enabled Settings Center pages are listed under the Settings parent menu.

## 1. Back up the current server

Before replacing files, create backups of:

- the complete current EMIS project;
- the production database;
- `.env`;
- uploaded files under `storage/app` and `public/storage`.

Do not copy a development `.env` over the production `.env`.

## 2. Upload the application

Extract this package into a new release directory. Keep the existing production
`.env` and uploaded storage. Point the web server document root to the release's
`public` directory, never to the Laravel project root.

## 3. Install and prepare

Run these commands from the project directory:

```bash
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
php artisan storage:link
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If Vite assets are not already built, also run:

```bash
npm ci
npm run build
```

## 4. Permissions on Linux

The web-server account must be able to write to:

```text
storage/
bootstrap/cache/
```

Do not make the whole application world-writable.

## 5. Production environment

Confirm these production values in `.env`:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-emis-domain.example
LOG_LEVEL=error
```

Also verify the production database, mail, queue, session, cache, and filesystem
settings. Run queue workers and the Laravel scheduler if EMIS uses them.

## 6. Verification

After deployment, verify:

1. Login and logout.
2. Dashboard appears separately at the top of the sidebar.
3. Settings expands and its Overview, sections, History, About, and Profile links work.
4. Pashto, Dari, and English switching.
5. Incoming/outgoing document access and attachment download.
6. Focal-point registration, approval, card generation, verification, and printing.
7. `storage/logs/laravel.log` contains no new application errors.

If deployment fails, restore the database and project backups before investigating.
