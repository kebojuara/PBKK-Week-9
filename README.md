[Bahasa Indonesia (Laporan Tugas) → README.id.md](README.id.md)

# PBKK Week 9 — Three CodeIgniter 4 Applications

A student information portal, an academic information system, and a campus shop in one repository. Each application has its own routes, session cookies, database schema, migrations, and seeded demo users.

**William Hans Chandra · 5025241138 · Pemrograman Berbasis Kerangka Kerja D**

This repository contains the source and documentation for PBKK Week 9. It is intended for local study and portfolio review. The UI is in Indonesian; this README is the main English documentation. The [Indonesian report](README.id.md) explains the coursework, selected implementation details, and all captured features in greater depth.

## Contents

- [Applications](#applications)
- [Technology stack](#technology-stack)
- [Architecture and repository layout](#architecture-and-repository-layout)
- [Getting started](#getting-started)
- [Demo accounts](#demo-accounts)
- [Testing and verification](#testing-and-verification)
- [Security and technical decisions](#security-and-technical-decisions)
- [Limitations](#limitations)
- [Credits and author](#credits-and-author)

## Applications

| Coursework | Application | Purpose | Roles |
|---|---|---|---|
| Exercise 1 | [StudentPortal](StudentPortal/) | Public student directory and staff administration | Visitor, staff, admin |
| Exercise 2a | [SIAKAD](SIAKAD/) | Academic records, study plans and grading | Student, lecturer, admin |
| Exercise 2b | [KampusMart](KampusMart/) | Product catalog, checkout and manual payment workflow | Visitor, buyer, admin |

### StudentPortal

The public portal provides program pages, a searchable and paginated student directory, individual profiles, and a validated contact form. Staff manage student records and photos. Administrators also manage programs, staff accounts, and message deletion.

Student uploads allow JPEG, PNG and WebP images up to 2 MB. Program deletion is blocked while students still reference it. Public student profiles omit the student's email and individual GPA; the public home still exposes aggregate statistics. Session login, role filters, CSRF and output escaping are applied in the actual routes and templates.

| Action | Visitor | Staff | Admin |
|---|---|---|---|
| Browse directory/programs; send contact form | Yes | Yes | Yes |
| List/create/update student records | No | Yes | Yes |
| Delete student records | No | No | Yes |
| Read messages | No | Yes | Yes |
| Manage programs, staff accounts; delete messages | No | No | Yes |

The following captures are actual application renders. Form previews are labelled and were not saved.

![Public home, program highlights and aggregate statistics.](docs/screenshots/studentportal/01-home.png)

*Figure 1. Public home, program highlights and aggregate statistics.*


<details>
<summary>StudentPortal: directory, forms, administration, validation, role protection and mobile views</summary>

![Student directory with a real name search; pagination is part of the directory.](docs/screenshots/studentportal/02-student-directory.png)

*Figure 2. Student directory with a real name search; pagination is part of the directory.*

![Public student profile; individual email and GPA are kept out of the profile.](docs/screenshots/studentportal/03-student-detail.png)

*Figure 3. Public student profile; individual email and GPA are kept out of the profile.*

![Program detail and its student directory.](docs/screenshots/studentportal/04-program-detail.png)

*Figure 4. Program detail and its student directory.*

![Contact form with CSRF protection; no message is submitted in this capture.](docs/screenshots/studentportal/05-contact.png)

*Figure 5. Contact form with CSRF protection; no message is submitted in this capture.*

![Staff login before any credential is entered.](docs/screenshots/studentportal/06-login.png)

*Figure 6. Staff login before any credential is entered.*

![Administrator dashboard and Chart.js distribution by program.](docs/screenshots/studentportal/07-admin-dashboard.png)

*Figure 7. Administrator dashboard and Chart.js distribution by program.*

![Student CRUD list, program filter and pagination.](docs/screenshots/studentportal/08-student-crud.png)

*Figure 8. Student CRUD list, program filter and pagination.*

![Student form with the actual client-side preview of a fictional file; not saved.](docs/screenshots/studentportal/09-student-form-upload.png)

*Figure 9. Student form with the actual client-side preview of a fictional file; not saved.*

![Program management and student counts; linked programs cannot be deleted.](docs/screenshots/studentportal/10-program-crud.png)

*Figure 10. Program management and student counts; linked programs cannot be deleted.*

![Administrator-only staff management and role matrix.](docs/screenshots/studentportal/11-user-management.png)

*Figure 11. Administrator-only staff management and role matrix.*

![Real staff access denial when opening administrator-only user management.](docs/screenshots/studentportal/12-role-denied.png)

*Figure 12. Real staff access denial when opening administrator-only user management.*

![Server-side required-field validation after an empty form; no row is inserted.](docs/screenshots/studentportal/13-form-validation.png)

*Figure 13. Server-side required-field validation after an empty form; no row is inserted.*

![Public StudentPortal at a 390-pixel mobile viewport.](docs/screenshots/studentportal/14-mobile-home.png)

*Figure 14. Public StudentPortal at a 390-pixel mobile viewport.*

![Message inbox, currently empty; no fictional message is inserted just for documentation.](docs/screenshots/studentportal/15-message-inbox.png)

*Figure 15. Message inbox, currently empty; no fictional message is inserted just for documentation.*

</details>


### SIAKAD

Administrators provision students and lecturers together with their login accounts, maintain courses, and reset initial passwords. Lecturers grade their own classes and review their advisees. Students manage KRS (study plans), view KHS (semester results), and print study plans and transcripts.

The credit limit is **not always 24**: it is 24, 21, 18 or 15 according to the previous semester GPA, while new students receive 20. The active configuration is the odd semester of 2026/2027, with KRS open from **1 August through 30 November 2026**. The service also checks semester parity, duplicates, previously passed courses, class quota and ownership. Grades use A/AB/B/BC/C/D/E; transcript GPA uses the best result when a course is repeated.

| Action | Student | Lecturer | Admin |
|---|---|---|---|
| Own dashboard, study plan, results, transcript | Yes | No | No |
| Own classes and advisees; enter grades | No | Yes | No |
| Master data, account provisioning/reset | No | No | Yes |
| Change own password | Yes | Yes | Yes |

[`KrsService`](SIAKAD/app/Libraries/KrsService.php) serializes requests for the same student and locks class capacity inside a transaction. [`Penilaian`](SIAKAD/app/Libraries/Penilaian.php) contains the grade/GPA calculations independently from controllers.

![Student dashboard with GPA, earned credits and the period credit limit.](docs/screenshots/siakad/10-student-dashboard.png)

*Figure 16. Student dashboard with GPA, earned credits and the period credit limit.*


<details>
<summary>SIAKAD: all three roles, master data, grading, advising, KRS, results, print layouts and access control</summary>

![Academic login and documented fictional demo accounts.](docs/screenshots/siakad/01-login.png)

*Figure 17. Academic login and documented fictional demo accounts.*

![Academic administrator dashboard: master data, grades and class capacity.](docs/screenshots/siakad/02-admin-dashboard.png)

*Figure 18. Academic administrator dashboard: master data, grades and class capacity.*

![Lecturer profiles linked to login users.](docs/screenshots/siakad/03-lecturer-list.png)

*Figure 19. Lecturer profiles linked to login users.*

![Student profiles and academic advisers.](docs/screenshots/siakad/04-student-list.png)

*Figure 20. Student profiles and academic advisers.*

![Course master data: credits, curriculum semester, lecturer and quota.](docs/screenshots/siakad/05-course-list.png)

*Figure 21. Course master data: credits, curriculum semester, lecturer and quota.*

![Student provisioning form; saving would create both user and profile, but this form is not submitted.](docs/screenshots/siakad/06-student-form.png)

*Figure 22. Student provisioning form; saving would create both user and profile, but this form is not submitted.*

![Lecturer view of assigned classes and participant counts.](docs/screenshots/siakad/07-lecturer-dashboard.png)

*Figure 23. Lecturer view of assigned classes and participant counts.*

![Actual grade-entry form previews 88 as A; this edit is not saved.](docs/screenshots/siakad/08-class-and-grades.png)

*Figure 24. Actual grade-entry form previews 88 as A; this edit is not saved.*

![Lecturer advising list with students and GPA summaries.](docs/screenshots/siakad/09-academic-advising.png)

*Figure 25. Lecturer advising list with students and GPA summaries.*

![Existing study plan and available odd-semester courses.](docs/screenshots/siakad/11-krs.png)

*Figure 26. Existing study plan and available odd-semester courses.*

![The seeded Operating Systems class is full; existing capacity is shown without changing KRS.](docs/screenshots/siakad/12-krs-capacity.png)

*Figure 27. The seeded Operating Systems class is full; existing capacity is shown without changing KRS.*

![Semester results calculated from seeded grades.](docs/screenshots/siakad/13-khs.png)

*Figure 28. Semester results calculated from seeded grades.*

![Transcript using the best grade for a repeated course.](docs/screenshots/siakad/14-transcript.png)

*Figure 29. Transcript using the best grade for a repeated course.*

![Print-ready KRS with adviser signature space.](docs/screenshots/siakad/15-print-krs.png)

*Figure 30. Print-ready KRS with adviser signature space.*

![Change-password form with empty password fields.](docs/screenshots/siakad/16-password-form.png)

*Figure 31. Change-password form with empty password fields.*

![Print-ready transcript; this is an HTML render of the actual print view.](docs/screenshots/siakad/17-print-transcript.png)

*Figure 32. Print-ready transcript; this is an HTML render of the actual print view.*

![Student access to the administrator route is rejected and redirected to the student dashboard.](docs/screenshots/siakad/18-role-protection.png)

*Figure 33. Student access to the administrator route is rejected and redirected to the student dashboard.*

</details>


### KampusMart

Visitors browse categories, search/sort the catalog and build a session cart before signing in. Buyers register, check out, upload a private payment image, review their own orders, cancel eligible orders and confirm delivery. Administrators maintain products/categories, inspect payments, dispatch orders with a tracking number, and monitor revenue and low stock.

Checkout rechecks availability and deducts stock with a conditional update inside a transaction. Each order item stores the name and price at purchase time. Shipping costs Rp15,000 below Rp200,000 and is free at or above that threshold; the per-product cart limit is 10 units. Cancelled orders return stock once. Products that already appear in orders are deactivated rather than deleted.

```text
Awaiting payment → Awaiting verification → Processing → Shipped → Completed
                          ↓ rejection
                    Awaiting payment

Eligible payment/processing stages → Cancelled
```

The permitted transitions and actors are defined by [`OrderStatus`](KampusMart/app/Libraries/OrderStatus.php), not by the visibility of buttons. Payment proof files live outside the public web root and are served only to the owner or an administrator.

| Action | Visitor | Buyer | Admin |
|---|---|---|---|
| Catalog and session cart | Yes | Yes | Yes |
| Checkout, own order history, proof upload | No | Yes | No |
| Manage catalog, review payments, ship orders | No | No | Yes |

No database records were created for these screenshots. Existing seeded orders demonstrate the available lifecycle states. The receipt preview is explicitly fictional and unsubmitted; the verification queue was empty at capture time.

![Storefront with product categories, best sellers and new arrivals.](docs/screenshots/kampusmart/01-storefront.png)

*Figure 34. Storefront with product categories, best sellers and new arrivals.*


<details>
<summary>KampusMart: catalog, account forms, cart, checkout, order stages, proof preview and administration</summary>

![Product catalog ordered by lowest price, with search and category filters.](docs/screenshots/kampusmart/02-catalog.png)

*Figure 35. Product catalog ordered by lowest price, with search and category filters.*

![Product detail with current price, stock and quantity control.](docs/screenshots/kampusmart/03-product-detail.png)

*Figure 36. Product detail with current price, stock and quantity control.*

![Buyer and administrator email login before credentials are entered.](docs/screenshots/kampusmart/04-login.png)

*Figure 37. Buyer and administrator email login before credentials are entered.*

![Buyer registration with address and password confirmation.](docs/screenshots/kampusmart/05-registration.png)

*Figure 38. Buyer registration with address and password confirmation.*

![Session cart with quantity forms and shipping summary; database stock is unchanged.](docs/screenshots/kampusmart/06-cart.png)

*Figure 39. Session cart with quantity forms and shipping summary; database stock is unchanged.*

![Checkout form populated with fictional seeded contact data; no order is placed.](docs/screenshots/kampusmart/07-checkout.png)

*Figure 40. Checkout form populated with fictional seeded contact data; no order is placed.*

![The signed-in buyer can view only their existing order history.](docs/screenshots/kampusmart/08-order-history.png)

*Figure 41. The signed-in buyer can view only their existing order history.*

![Existing seeded order awaiting payment, with sample transfer accounts and cancellation action.](docs/screenshots/kampusmart/09-order-awaiting-payment.png)

*Figure 42. Existing seeded order awaiting payment, with sample transfer accounts and cancellation action.*

![Actual proof-upload preview using a clearly labelled simulated receipt; not submitted, so status remains awaiting payment.](docs/screenshots/kampusmart/10-payment-proof-preview.png)

*Figure 43. Actual proof-upload preview using a clearly labelled simulated receipt; not submitted, so status remains awaiting payment.*

![Existing seeded order in the processing stage.](docs/screenshots/kampusmart/11-order-processing.png)

*Figure 44. Existing seeded order in the processing stage.*

![Existing shipped order with fictional tracking number and receipt confirmation.](docs/screenshots/kampusmart/12-order-shipped.png)

*Figure 45. Existing shipped order with fictional tracking number and receipt confirmation.*

![Existing completed order with its final status.](docs/screenshots/kampusmart/13-order-completed.png)

*Figure 46. Existing completed order with its final status.*

![Existing cancelled order; no cancellation is performed during documentation.](docs/screenshots/kampusmart/14-order-cancelled.png)

*Figure 47. Existing cancelled order; no cancellation is performed during documentation.*

![Store administrator dashboard; local QA audit orders may affect totals compared with a fresh seed.](docs/screenshots/kampusmart/15-admin-dashboard.png)

*Figure 48. Store administrator dashboard; local QA audit orders may affect totals compared with a fresh seed.*

![Category management with product counts.](docs/screenshots/kampusmart/16-category-management.png)

*Figure 49. Category management with product counts.*

![Product management; historical QA products are inactive and do not appear in the storefront.](docs/screenshots/kampusmart/17-product-management.png)

*Figure 50. Product management; historical QA products are inactive and do not appear in the storefront.*

![Product form and actual fictional-image preview, without saving a product.](docs/screenshots/kampusmart/18-product-form-upload.png)

*Figure 51. Product form and actual fictional-image preview, without saving a product.*

![Administrator order detail with valid processing-to-shipping actions and required tracking number.](docs/screenshots/kampusmart/19-admin-order-actions.png)

*Figure 52. Administrator order detail with valid processing-to-shipping actions and required tracking number.*

![Real verification queue is currently empty. No database state is manufactured to populate it.](docs/screenshots/kampusmart/20-verification-queue.png)

*Figure 53. Real verification queue is currently empty. No database state is manufactured to populate it.*

![KampusMart at 390 × 844, with responsive product cards and navigation.](docs/screenshots/kampusmart/21-mobile-storefront.png)

*Figure 54. KampusMart at 390 × 844, with responsive product cards and navigation.*

</details>


## Technology stack
| Component | Project requirement / use | Verified development version |
|---|---|---|
| Ubuntu | Native Linux PHP/MySQL development | 26.04.1 LTS |
| PHP | `^8.2` in each composer.json | 8.5.4 |
| CodeIgniter | `^4.7`, resolved by composer.lock | 4.7.6 |
| CI translations | Indonesian validation messages | 4.7.4 |
| MySQL | MySQLi driver, independent schemas | 8.4.11 |
| Composer | Install locked PHP dependencies | 2.10.2 |
| Node / npm | Optional documentation/browser tooling, not PHP runtime | 22.22.1 / 11.20.0 |
| SB Admin 2 | Local administrator assets | 4.1.4 |
| Bootstrap | Local Bootstrap 4 admin bundle; public storefront/portal CDN | 4 / 5.3.3 |
| Chart.js | Administrator and academic charts | 2.x bundled with SB Admin 2 |
| PHPUnit | Application regression tests | 10.5.66 |

PHP must enable `intl`, `mbstring`, `mysqli`/`mysqlnd` and `fileinfo`; GD is available in the development environment for image-related work. The included PHPUnit setup also needs XML/DOM extensions. Node is unnecessary for serving these PHP applications. Public Bootstrap/Icons and fonts use their documented CDNs; SB Admin 2 administrator assets are committed locally.

## Architecture and repository layout

Each application follows MVC: explicit routes call controllers; models handle query/validation rules; PHP views extend shared layouts. Domain services keep academic and order invariants outside page controllers. Migrations define the schema, and guarded seeders provide fictional data.

```text
pbkk-week-9-codeigniter4/
├── README.md
├── README.id.md
├── .gitignore
├── .gitattributes
├── docs/
│   ├── ARCHITECTURE.md
│   ├── DATABASE.md
│   ├── SETUP.md
│   ├── VERIFICATION.md
│   └── screenshots/{studentportal,siakad,kampusmart}/
├── StudentPortal/
├── SIAKAD/
└── KampusMart/
    # Each app: app/, public/, tests/, writable/ markers,
    # composer.json, composer.lock, .env.example, spark, phpunit.dist.xml
```

See [architecture and source map](docs/ARCHITECTURE.md) and [database tables and relationships](docs/DATABASE.md). Composer dependencies, real environment files, dynamic uploads, runtime files, internal orchestration kits and other students' reference material are excluded. This is one repository, with no nested application repositories.

## Getting started

### 1. Install prerequisites and dependencies

Use native PHP 8.2+ and MySQL 8.4. See the [Ubuntu setup guide](docs/SETUP.md) for the required extensions and database SQL. No XAMPP installation or database server replacement is necessary.

The following clone URL is a template: replace `YOUR_GITHUB_USERNAME` after the repository has actually been published.

```bash
git clone https://github.com/YOUR_GITHUB_USERNAME/pbkk-week-9-codeigniter4.git
cd 'pbkk-week-9-codeigniter4'
for app in StudentPortal SIAKAD KampusMart; do
  (cd "$app" && composer install)
done
```

### 2. Configure three independent local databases

Create the three empty schemas and least-privilege local users as described in [SETUP.md](docs/SETUP.md#mysql-databases). Use unique passwords of your own. Do not alter or delete an existing schema to follow the example.

| Directory | Database | Example local database user | Base URL |
|---|---|---|---|
| `StudentPortal` | `student_portal` | `studentportal` | `http://localhost:8080/` |
| `SIAKAD` | `siakad` | `siakad` | `http://localhost:8081/` |
| `KampusMart` | `kampusmart` | `kampusmart` | `http://localhost:8082/` |

Copy [StudentPortal/.env.example](StudentPortal/.env.example), [SIAKAD/.env.example](SIAKAD/.env.example) and [KampusMart/.env.example](KampusMart/.env.example) to `.env` inside their respective applications **only for a new setup**:

```bash
for app in StudentPortal SIAKAD KampusMart; do
  if [ ! -e "$app/.env" ]; then
    cp "$app/.env.example" "$app/.env"
    chmod 600 "$app/.env"
  fi
done
```

Fill `database.default.password` locally; `CHANGE_ME_LOCALLY` is a placeholder, not a working password. Keep the example's database name, local host, MySQLi driver and empty prefix because the setup guard verifies them. No encryption key generation is required by the implemented flows.

### 3. Migrate and seed a new, empty database

Inside each app, run:

```bash
php spark project:setup --seed
php spark migrate:status
```

`project:setup` validates the target before additive migrations. `--seed` is for the first installation only: the seeder refuses any populated application table. Later, run `php spark project:setup` without `--seed`. No reset or rollback is part of setup. A pre-existing schema without migration history requires manual review.

### 4. Run three local servers

Use a separate terminal per application:

| Working directory | Command | Local URL |
|---|---|---|
| `StudentPortal` | `php spark serve --host 127.0.0.1 --port 8080` | http://localhost:8080/ |
| `SIAKAD` | `php spark serve --host 127.0.0.1 --port 8081` | http://localhost:8081/login |
| `KampusMart` | `php spark serve --host 127.0.0.1 --port 8082` | http://localhost:8082/ |

Serve `public/` as the document root if you later configure a web server. Do not expose the project root or use these demo accounts in a public production deployment.

## Demo accounts

These are intentionally fictional application accounts from the public seeders, **not database credentials**.

| Application | Role | Username / email | Seeded demo password |
|---|---|---|---|
| StudentPortal | Admin | `admin` | `admin123` |
| StudentPortal | Staff | `staff` | `staff123` |
| SIAKAD | Admin | `admin` | `admin123` |
| SIAKAD | Lecturer | `0011018501` | `0011018501` |
| SIAKAD | Student | `5025251001` / `5025251002` | same as the selected NIM |
| KampusMart | Admin | `admin@kampusmart.test` | `admin123` |
| KampusMart | Buyer | `budi@mail.test` / `sari@mail.test` | `pembeli123` |

Fresh seeds contain 2 staff accounts, 5 programs and 12 students in StudentPortal; 1 admin, 4 lecturers, 9 students, 16 courses and 83 KRS rows in SIAKAD; and 3 users, 4 categories, 14 products and 6 orders in KampusMart. Existing local screenshots may include retained, inactive QA transaction fixtures. Those records and uploaded files are not shipped as a database dump.

## Testing and verification

From each application directory:

```bash
composer validate --no-check-publish
php spark routes
vendor/bin/phpunit
```

KampusMart additionally has a read-only opt-in MySQL aggregate check:

```bash
PBKK_MYSQL_ACCEPTANCE=1 vendor/bin/phpunit tests/database/ProdukAggregateTest.php
```

The earlier implementation run recorded **14 applied migrations, 79 E2E assertions, 59 HTTP smoke checks and 18 Chrome checks**. These were distinct forms of evidence, not 79 separate test cases. The write-based E2E run included concurrent KRS/stock requests, upload/ownership checks, full payment-to-delivery and cancellation, and CRUD cleanup.

For repository preparation, these historical results were checked against their local evidence. The write-based suite was **not rerun** because database contents must remain unchanged. The preparation pass instead checks the public export, locked dependency installation, relevant PHPUnit suites, routes, read-only migration status, live screenshots, asset availability, links and secrets. See the [verification record](docs/VERIFICATION.md) for exact current results and the distinction between historical and current checks. Internal logs and orchestration scripts are not publication files.

The clean public export passed **45 PHPUnit tests (1 explicit opt-in skip), 112 assertions and 24 Chrome checks** during preparation; the separately enabled MySQL test also passed (1 test, 2 assertions). All 17 project tables retained identical row counts and content fingerprints. No fresh database migration/seed was repeated in this pass.

## Security and technical decisions

- Explicit HTTP routes, CSRF fields and method spoofing protect state-changing forms; logout uses POST.
- Role filters protect controllers on the server. Lecturer/student/order ownership is checked in queries and controllers.
- Each app has a different session and CSRF cookie name, avoiding collisions across localhost ports.
- Passwords use `password_hash`/`password_verify`; real DB passwords belong only in ignored `.env` files.
- Uploads validate file type, extension and size and use random names. Payment proofs remain under `writable/`, outside `public/`.
- Foreign keys, quota locks, conditional stock updates, guarded status transitions and transaction checks enforce the important data rules.
- Source, migrations, safe examples and required frontend vendor assets are retained; runtime/private data is not.

## Limitations

- The KRS dates deliberately match the coursework configuration. Outside that window, study-plan changes are rejected until the configuration is intentionally updated.
- The shop models manual bank-transfer verification. The 24-hour payment window is displayed; there is no automatic payment gateway or expiry scheduler in the source requirements.
- There was no live order awaiting verification during this capture. The docs show the actual empty queue, unsubmitted proof preview, other stored order stages, and the transition code rather than manufacturing a screenshot by editing data.
- The message inbox was empty during capture. Screenshots document this honestly; contact submission and message deletion were covered by the historical E2E run.
- CDN assets require internet access. Physical printing and code-coverage percentages are not claimed. Legacy SQLite starter examples are excluded from the public candidate; the relevant app tests are kept, including the separately enabled MySQL check.

## Credits and author

- [CodeIgniter 4](https://codeigniter.com/) and its [server requirements](https://www.codeigniter.com/user_guide/intro/requirements.html).
- [SB Admin 2](https://github.com/StartBootstrap/startbootstrap-sb-admin-2), Bootstrap, Font Awesome, Bootstrap Icons, jQuery, Chart.js and the font providers used in the templates. Existing upstream license notices remain with the assets; no new project license is assigned here.
- Coursework specification: the PBKK Week 9 guide used during implementation. Other students' PDF/README examples were not available locally and no text or images from them were copied.

**William Hans Chandra — 5025241138**  
**Pemrograman Berbasis Kerangka Kerja D**
