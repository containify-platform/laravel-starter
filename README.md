# Laravel starter

[![Deploy on Containify](https://containify.cloud/deploy-button.svg)](https://containify.cloud/templates/laravel)

A minimal [Laravel](https://laravel.com) 13 app on PHP 8.5 with a PostgreSQL database, ready to
deploy on [Containify](https://containify.cloud). The home page records each visit in Postgres and
shows the count; `/up` is the health check.

The production image runs [FrankenPHP](https://frankenphp.dev), a PHP app server built on Caddy,
in a single container as a non-root user: no separate nginx and PHP-FPM. It serves plain HTTP on
port 8080 and caches config, routes and views when it starts.

## Deploy on Containify

[![Deploy on Containify](https://containify.cloud/deploy-button.svg)](https://containify.cloud/templates/laravel)

One click deploys it on [Containify](https://containify.cloud). The [template page](https://containify.cloud/templates/laravel) shows what it creates, and passwords, connection strings and the HTTPS address are filled in for you.

Deploy the **Laravel starter** template from the Containify catalogue. It creates:

- **Laravel**, built from this repository, with an HTTPS endpoint on port 8080 and a health check on `/up`.
- **Postgres**, a private PostgreSQL 17 database with a volume.

`APP_KEY` is generated for you, `DB_URL` references the Postgres app, and
`php artisan migrate --force` runs as the pre-deploy command, so migrations run once per deploy
before the new version takes traffic. Sessions, the cache and queued jobs use the database.

To build your own app from it, fork this repository and point the app's source at your fork.
See the [Laravel guide](https://containify.cloud/docs/guides/laravel).

## Run locally

You need PHP 8.3 or newer with the `pdo_pgsql` extension, Composer and PostgreSQL.

```bash
composer install
cp .env.example .env          # then point DB_URL at your Postgres
php artisan key:generate
php artisan migrate
php artisan serve
```

Or run the production image with Docker:

```bash
docker build -t laravel-starter .
docker run -p 8080:8080 \
  -e APP_KEY=base64:$(openssl rand -base64 32) \
  -e DB_URL=postgresql://postgres:postgres@host.docker.internal:5432/laravel \
  laravel-starter
docker exec <container> php artisan migrate --force
```

## Front-end assets

The starter has no front-end build, so its image needs no Node.js. To add Vite, add a
`package.json` and a Node stage that runs `npm run build` and copies `public/build` into the
image, as in the [Laravel guide](https://containify.cloud/docs/guides/laravel#2-add-a-dockerfile).

## License

MIT

---

Made by [Containify](https://containify.cloud): deploy apps, databases and workers from a Git repo or an image, with per-second billing. [Docs](https://containify.cloud/docs) · [Templates](https://containify.cloud/templates)
