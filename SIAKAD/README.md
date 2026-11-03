# SIAKAD

[English repository overview](../README.md) · [Laporan tugas Bahasa Indonesia](../README.id.md)

A standalone CodeIgniter 4.7.6 application within the PBKK Week 9 monorepo.

## Local setup

See [the shared setup guide](../docs/SETUP.md) for PHP requirements and the independent MySQL database/user for this application. For a new setup only, copy `.env.example` to `.env`, enter your own local database password, and keep that file private. Never overwrite an existing environment file.

From this directory:

```bash
composer install
php spark project:setup --seed
php spark serve --host 127.0.0.1 --port 8081
```

The `--seed` option is only for the first installation on empty application tables. For subsequent additive migrations use `php spark project:setup` without seeding. Setup validates the exact local database name; it does not create database users or reset existing data.

Local URL: http://localhost:8081/ . Use a separate terminal for each application.

## Verification

```bash
composer validate --no-check-publish
php spark routes
php spark migrate:status
vendor/bin/phpunit
```

Relevant application tests are included. Runtime data, uploaded files, Composer dependencies, internal capture scripts and legacy starter examples are excluded from the public repository. See [verification evidence and limitations](../docs/VERIFICATION.md), [schema](../docs/DATABASE.md), and the root READMEs for actual screenshots, features, roles and intentionally fictional demo accounts.
