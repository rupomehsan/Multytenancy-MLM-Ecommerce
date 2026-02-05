# MLM E-commerce

This repository contains the MLM E-commerce Laravel application. This README contains a short reference for module migration commands used by this project.

**Module Migrations (php artisan migrate:modules)**

This project uses a custom Artisan command `migrate:modules` that runs database migrations for both core and module migrations. Below are the common flags and recommended usage patterns.

Usage examples

- Run core and module migrations (normal run):

```bash
php artisan migrate:modules --force
```

- Fresh (drop all tables, then run migrations):

```bash
php artisan migrate:modules --fresh --force
```

- Fresh and seed module + core seeders:

```bash
php artisan migrate:modules --fresh --force --seed-all
```

- Run only module migrations (skip core):

```bash
php artisan migrate:modules --no-core --force
```

- Run migrations for a specific module:

```bash
php artisan migrate:modules --module=ECOMMERCE --force
```

- Dry-run (show SQL without executing):

```bash
php artisan migrate:modules --pretend
```

Flags and notes

- `--force`: Bypass confirmation prompts (required for CI/non-interactive shells). Use with care in production.
- `--fresh`: Drops all tables and re-runs migrations. This is destructive — do not use in production unless intended.
- `--seed-all`: Runs module and core seeders after migrations (useful for local dev).
- `--no-core`: Skip core migrations, run only module migrations.
- `--module=NAME`: Target a specific module by name.
- `--pretend`: Show SQL statements that would run without applying them.

Recommended workflow

1. Review migrations with `--pretend` before running destructive operations.
2. For local environment setup:

```bash
composer install
composer dump-autoload -o
php artisan migrate:modules --force
php artisan db:seed    # optional, if you have a seeder
```

3. For a full clean dev rebuild:

```bash
php artisan migrate:modules --fresh --force --seed-all
```

4. After running migrations, clear caches to avoid stale configuration or view caches:

```bash
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

Safety & troubleshooting

- Backup production databases before running `--fresh` or other destructive commands.
- If you see SQL errors about missing tables (for example `country`), either create a migration that defines the missing table or add guards in the code that queries it.
- If views throw "Attempt to read property '...' on null", confirm the controller passes the expected variable or make the view defensive using `data_get()` or the null coalescing operator.

If you want, I can add a dedicated `docs/` page with more examples, or include module-specific migration instructions.
