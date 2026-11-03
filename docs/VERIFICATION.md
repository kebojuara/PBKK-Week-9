# Verification record

[English README](../README.md) · [Laporan akademik](../README.id.md#9-pengujian-dan-hasil-verifikasi)

Repository preparation was checked on **3 November 2026 (Asia/Jakarta)**. The results below distinguish earlier implementation tests from the current publication candidate. No commit, remote configuration, GitHub repository creation or push was performed.

## Current public-candidate checks

A clean export was made from the staged Git index into a temporary directory. It initially contained no Composer vendor directory, real .env or dynamic runtime files. This was an **index export**, not a git clone: no commit exists yet, as requested. Each application then ran composer install against its unchanged lockfile.

| Check on clean exported source | StudentPortal | SIAKAD | KampusMart |
|---|---:|---:|---:|
| Composer install / validate | Pass | Pass | Pass |
| PHP files linted | 106 | 117 | 116 |
| Explicit routes listed | 31 | 40 | 36 |
| Relevant PHPUnit suite | 8 tests, 18 assertions | 19 tests, 54 assertions | 19 tests, 40 assertions, 1 skipped |
| Read-only migration status | 4 applied | 5 applied | 5 applied |
| Separate MySQL aggregate test | — | — | 1 test, 2 assertions: pass |

The default public suites therefore ran **46 tests: 45 passed and 1 skipped, with 112 assertions**. The skip is the intentionally opt-in KampusMart MySQL aggregate check; it also passed separately with the existing local project database. Generic SQLite/session starter examples and their unused dummy data files are not publication files. This explains why these totals differ from the earlier workspace suite.

Chrome then checked the clean exported applications: **24 checks passed**, including login, actual administrator chart initialization, required CSS/JS/font HTTP responses, and representative public/mobile rendering. There were no uncaught JavaScript errors or failed network requests in that run. The temporary environments used existing database credentials privately and only for reads; they are absent from the staged candidate.

A transient connection reset interrupted two initial Composer downloads. Retrying from a new clean export with the successfully downloaded Composer archive cache completed for all three apps. No dependency versions or lockfiles were changed to bypass installation.

## Documentation and screenshot checks

- **54 original PNGs**: StudentPortal 15, SIAKAD 18, KampusMart 21; captured from the existing applications in Chrome.
- Both root READMEs reference all 54 screenshots, each with informative alt text and a caption. Indonesian captions run consecutively from Gambar 1 through Gambar 54; English captions use Figure 1 through Figure 54.
- PNG signatures, chunk CRCs and compressed pixel streams were validated. Desktop viewports were 1440 × 900; mobile representatives were 390 × 844. Full-page screenshots preserve the application text without downscaling or masking.
- Local Markdown links, heading anchors, code fences, image paths and bilingual navigation passed the final staged-file audit. This covers the root READMEs, shared docs, app READMEs and relevant test documentation.
- The scanner checked staged blobs rather than relying only on ignore rules. It found no real .env, local password value, private key/token signature, database dump, Composer dependency tree, runtime content, internal toolkit or private absolute workstation path.
- SB Admin frontend vendor assets remain staged; only Composer vendor directories and unused frontend distribution variants are excluded. Required jQuery, Bootstrap, Chart.js and Font Awesome files were checked in both the index and the clean-export browser.
- All **164 reference implementation files** matched the previously verified final hashes. No controller, model, migration, seeder, domain service, business config or view was changed during repository preparation.

The provided kit's filename-only checker was also run. Its broad patterns flag safe .env.example files, required frontend vendor assets and empty-directory markers. These are deliberate exceptions verified by the more precise staged-content audit, not leaked dependencies or secrets. Raw audit logs remain local and are not published.

## Database preservation

Read-only fingerprints covered all **17 tables** across the three project schemas, including migration tracking tables. Row counts and SHA-256 fingerprints were identical before and after capture and verification. No business data was created, updated, cancelled, graded, deleted, migrated or reseeded in this preparation pass. Other databases, MySQL accounts and server settings were not touched.

Browser interactions were limited to login, navigation, session cart operations, local file/grade previews and an invalid empty student form. The empty form was rejected before any insert. The fictitious payment preview was not submitted. Private temporary export environments were removed after verification; the original environment files were not overwritten.

## Historical implementation evidence

The earlier implementation report and local machine-readable results were checked for the following counts. The internal report, source guide, raw logs, old screenshots and fixture scripts are deliberately not publication files.

| Earlier implementation run | Recorded result |
|---|---|
| Applied migrations | 14 total: 4 + 5 + 5 |
| Write-based HTTP/MySQL E2E | 79 assertions: StudentPortal 17, SIAKAD 28, KampusMart 34 |
| HTTP smoke | 59 checks: 18 + 21 + 20 |
| Chrome | 18 checks, zero JS errors and zero failed asset requests |
| Full workspace PHPUnit | 46 passing tests, 7 skipped, 116 assertions |
| Separate read-only MySQL aggregate | 1 test, 2 assertions, pass |

The earlier E2E verified CRUD, role/ownership rejection, image uploads, duplicate/validation errors, bulk grading atomicity, GPA results, credit/quota checks, simultaneous KRS requests, simultaneous checkout, payment rejection/re-upload, verification, tracking, delivery confirmation, cancellation and exactly-once stock restoration. The historical number 79 counts assertions, not separate test cases.

Six earlier skips were unused starter SQLite examples on a runtime without sqlite3; the remaining skip was the MySQL opt-in test that passed separately. The current public candidate excludes those unrelated starter examples and retains application tests. Write-based E2E was not rerun for documentation because the user explicitly required unchanged databases.

## Limits and reproducibility

1. A new empty database was not created, migrated or seeded during this preparation pass. Fresh installation commands are based on the actual setup guard/migrations/seeders and their earlier successful run; the current pass verifies clean dependency installation, live reads and existing migration status without changing data.
2. No existing order was in Menunggu Verifikasi during capture. The actual empty queue, unsubmitted DEMO proof preview, and other existing seeded order stages are shown. The docs do not pretend an administrator verification action was performed for these screenshots.
3. The contact inbox was empty. Its empty-state screenshot is retained; inserting messages just for a picture would violate the database constraint.
4. Current and historical local shop totals can include retained inactive QA products/orders. A fresh seed contains only the documented fictional seed data, not a dump of this machine's state.
5. No production deployment, real bank transfer, payment gateway, physical print, code-coverage percentage or exhaustive penetration/load test is claimed. The KRS window and informational payment timeout follow the actual coursework config. Public CDN assets need internet access.
6. Other students' PDF/README examples were absent from the local reference directory. No text, identity or image from such material is published.

## Reproduce the public checks

From each application directory after installing dependencies:

```bash
composer validate --no-check-publish
php spark routes
vendor/bin/phpunit
```

After configuring its existing local project database, the shop's read-only aggregate test is optional:

```bash
PBKK_MYSQL_ACCEPTANCE=1 vendor/bin/phpunit tests/database/ProdukAggregateTest.php
```

Use the [setup guide](SETUP.md) only for a new installation or reviewed additive migration. The repository intentionally does not ship private environments, database exports or internal fixture/capture tooling.
