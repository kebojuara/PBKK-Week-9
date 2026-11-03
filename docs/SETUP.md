# Local setup

[English README](../README.md) · [Panduan lengkap Bahasa Indonesia](../README.id.md#7-instalasi-dari-repository)

## Prerequisites

Use PHP 8.2+ with intl, mbstring, mysqli/mysqlnd, fileinfo and XML/DOM for the included tests. GD is available in the development environment. Use Composer and native MySQL 8.4. Node/npm are not required to serve the applications.

On a new Ubuntu machine, ask the administrator to install missing dependencies rather than replacing an existing database server. A typical PHP-only package list is:

```bash
sudo apt update
sudo apt install php-cli php-intl php-mbstring php-mysql php-xml php-gd php-curl php-zip unzip composer
```

Do not run installation commands merely to match a tutorial if these tools are already installed. Version details and the CI4 requirements are in the root README.

## Source and PHP dependencies

The repository URL below is a template until publication; replace YOUR_GITHUB_USERNAME.

```bash
git clone https://github.com/YOUR_GITHUB_USERNAME/pbkk-week-9-codeigniter4.git
cd 'pbkk-week-9-codeigniter4'
for app in StudentPortal SIAKAD KampusMart; do
  (cd "$app" && composer install)
done
```

## MySQL databases

Run the following through your own local MySQL administrator only for a **new installation**. Replace all three password placeholders with separate private values. If any database/user already exists, stop and inspect it; do not delete it or reset accounts to make the example succeed. These grants intentionally omit privileges outside the application's schema.

```sql
CREATE DATABASE student_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siakad CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE kampusmart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'studentportal'@'localhost' IDENTIFIED BY 'REPLACE_WITH_UNIQUE_PASSWORD_1';
CREATE USER 'siakad'@'localhost' IDENTIFIED BY 'REPLACE_WITH_UNIQUE_PASSWORD_2';
CREATE USER 'kampusmart'@'localhost' IDENTIFIED BY 'REPLACE_WITH_UNIQUE_PASSWORD_3';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, REFERENCES
  ON student_portal.* TO 'studentportal'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, REFERENCES
  ON siakad.* TO 'siakad'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, REFERENCES
  ON kampusmart.* TO 'kampusmart'@'localhost';
```

## Environment

For each application, copy `.env.example` only if `.env` does not already exist:

```bash
for app in StudentPortal SIAKAD KampusMart; do
  if [ ! -e "$app/.env" ]; then
    cp "$app/.env.example" "$app/.env"
    chmod 600 "$app/.env"
  fi
done
```

Replace CHANGE_ME_LOCALLY with your database password locally. Match the example user/database to the administrator's setup. Keep hostname localhost or 127.0.0.1, MySQLi, port 3306, and an empty prefix. The setup guard accepts exactly student_portal, siakad or kampusmart for its corresponding app.

Ports/base URLs: StudentPortal 8080, SIAKAD 8081, KampusMart 8082. No key:generate step is required for these implemented flows. Never publish a real .env, uploaded payment file, session, database dump or credentials.

## First migration and seed

From each application directory, as an ordinary user:

```bash
php spark project:setup --seed
php spark migrate:status
```

The four/five/five migrations create tables in their verified database. All application tables must be empty for seeding. Once data exists, use `php spark project:setup` without `--seed`. A repeated seed is rejected by design. A pre-existing unversioned schema requires manual review. Do not use destructive migration/reset commands.

## Run and verify

Use a separate terminal in each application directory:

```bash
# StudentPortal/
php spark serve --host 127.0.0.1 --port 8080
# SIAKAD/
php spark serve --host 127.0.0.1 --port 8081
# KampusMart/
php spark serve --host 127.0.0.1 --port 8082
```

The comments indicate different working directories, not three blocking commands to paste in one terminal. Open localhost on the relevant port; stop with Ctrl+C. For another web server point its document root to public/.

```bash
composer validate --no-check-publish
php spark routes
vendor/bin/phpunit
```

For screenshots, demos and current/historical test distinctions, see [README](../README.md), [README.id](../README.id.md) and [VERIFICATION](VERIFICATION.md). Public pages load Bootstrap/Icons/fonts from CDNs; administrator template scripts and webfonts are included locally.
