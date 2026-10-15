# Memorial Plan Management and Online Payment System — Checking 1

Delivered on October 15, 2026 (Asia/Manila). This is a working system-design prototype on the existing **LavaLust 4.7.0**, not a completed production backend.

## Reference review and decisions

1. **Wireframe:** public plan discovery, a customer dashboard, and administrator management pages. The implementation retains these purposes with green St. Peter-inspired dashboard styling, reusable layouts, responsive navigation, cards, searchable tables, and explicit sample labels. Individual, Family, and Premium prices are ₱25,000, ₱50,000, and ₱100,000.
2. **ERD:** the baseline contains 13 tables. All named fields and foreign-key relationships are represented in `database/schema.sql`; no existing database was modified.
3. **Sitemap:** public, customer, and administrator sections define the route hierarchy. Primary pages render actual interfaces; remaining record/workflow subpages have consistent sample forms or labeled design placeholders.
4. **Assignment image:** supplied and reviewed after the initial implementation. It confirms seven requirements: identify major features, prepare a sitemap, create initial wireframes, design an ERD, configure LavaLust, implement routes/navigation, and run locally without major errors. Its grading weights match the pasted checklist (20/15/20/20/25). The required demonstration is a running LavaLust project, planned interfaces, database explanation, and basic navigation/routes. Screenshots must support the grading criteria. No additional backend or live payment requirement appears in this image.

Conflicts and small design decisions:

- Beneficiaries, Services Catalog, and Refunds appear in the wireframes but not in the approved ERD. They are available as separately labeled, read-only wireframe extension previews, linked from contracts/plans/payments. They are not added to the 13-table database or the primary sitemap menu.
- Starter migration `001_create_users_table.php` defines different fields (`id`, `username`, `password`, etc.). Starter migrations are preserved. **Do not run the starter migrations into the ERD database.** Use a separate empty database for the SQL schema.
- The application previously had only the default Welcome controller and view. Both are preserved, while the home route now uses the memorial public controller.
- At the user's request, the project now uses St. Peter's official logo and a green visual palette adapted from its website. The interface is an independent college project, not an official company service. Plan names/prices remain assignment samples; no official product terms, office contact endpoints, or payment facilities are implied.
- Sample installment dates and totals are fixtures, not payment-term rules. Juan Dela Cruz / CL-001 owns CON-001 for the Individual Plan: ₱25,000 total, ₱5,000 sample paid, ₱20,000 remaining. Five ₱5,000 installments sum to the contract amount. Sample dates are illustrative, including future dates relative to delivery.
- All portal routes are public demonstrations, with no role enforcement. Login, registration, password reset, administrative forms, and support forms validate locally without persistence or delivery.
- Native CSS illustrations replace unsupplied memorial photography. No frontend packages or external CDN assets are needed.

## Project organization

```text
app/
  config/       config.php, routes.php, memorial.php (page and subpage registry)
  controllers/  Public_site.php, Customer_portal.php, Admin_portal.php
                Memorial.php (shared rendering/validation)
  models/       Demo_model.php (read-only sample data)
  views/
    memorial/   layout.php, public.php, overview.php, portal.php, table.php
    errors/     memorial_404.php + preserved framework error templates
public/
  index.php     original LavaLust bootstrap + mount-path compatibility
  assets/css/   memorial.css, st-peter-dashboard.css
  assets/js/    memorial.js
  assets/images/ st-peter-logo.png
database/       schema.sql
docs/           this guide, ROUTES.md, HTTP/browser test evidence, screenshots/
tests/          check_routes.py, dev-router.php
scheme/         existing LavaLust framework (unchanged)
```

The actual framework routing API is `$router->get('/path', 'Controller::method')`, with `{page}` and `{detail?}` parameters. Views load with `$this->call->view(...)`; the model loads with `$this->call->model('Demo_model')`. Data is read in the controller and passed to reusable views. Invalid page names and unsupported record IDs return HTTP 404. Dynamic output is escaped using `htmlspecialchars`.

## Implemented scope

| Area | Working Checking 1 interfaces |
|---|---|
| Public | Wireframe-style homepage with top navigation and hero, About, plan catalog and three detail pages, FAQ accordion, contact preview, Login/Register/Forgot/Reset previews |
| Customer | Dashboard, profile, plans, contract and coverage, installments, payment-method selection and checkout preview, history, sample receipt/document print views, support preview, notifications |
| Administrator | Dashboard, customer/plan/contract/schedule/payment/method/receipt/document/inquiry/notification/user pages, management form previews, sample report preview |
| Shared | Active navigation, breadcrumbs, 404 page, responsive menus, browser form validation, table search with empty state, mobile table scrolling |

All forms explicitly state their demonstration behavior. A valid form reports only that its preview was validated; no false account creation, payment completion, password reset email, upload, or database update is displayed. Checkout carries the chosen sample installment and method into the review and stays **Not submitted**. Receipt/document print views are prominently marked samples; the browser's Print / Save as PDF function is used rather than pretending a cloud document exists.

For exact route-to-page mapping, including all allowed subpages, see [ROUTES.md](ROUTES.md).

## Database preparation

`database/schema.sql` contains the original ERD entities:

`users`, `clients`, `memorial_plans`, `inquiries`, `stored_files`, `plan_contracts`, `payment_schedules`, `payment_methods`, `payments`, `notifications`, `digital_receipts`, `payment_transactions`, `qr_codes`.

- Integer primary keys and matching unsigned foreign keys; InnoDB and utf8mb4.
- `DECIMAL(12,2)` for amounts, nonnegative amount checks, `DATE` and `DATETIME` as shown in the ERD.
- Unique business references and indexes for lookup/status/date fields and foreign keys.
- Foreign keys restrict deletion/update to preserve related financial/customer records; there are no destructive cascades.
- `responded_by`, inquiry response, optional contact details, and `sent_at` may be null for pending/unprovided information.
- One client profile per user is enforced. Receipt, transaction, and QR references are unique; payment foreign keys are not unique, allowing the baseline's child collections without inventing a one-to-one restriction.
- `password_hash` reserves 255 characters. No real account or seeded password exists; use `password_hash()` / `password_verify()` when authentication is built.
- No `DROP`, `ALTER`, seed financial transactions, credentials, or automatic schema import is included. Import into a **new empty database** selected by the operator. SQL DDL can partially commit on error; do not import into an existing application database.

The existing database configuration uses environment variables and is unconfigured in this checkout. It was preserved. The demo intentionally works without a database connection. SQL import and actual MySQL foreign-key enforcement have **not** been executed in this delivery.

To demonstrate schema preparation, open the SQL in the editor. To demonstrate actual database tables later: start MySQL in XAMPP, create an empty database such as `memorial_checking1`, select it in phpMyAdmin, and import `database/schema.sql`. Do not select a database containing existing tables. Confirm 13 tables in phpMyAdmin Designer. If you later connect the app, supply approved `DB_*` settings privately; database-backed models are still future work.

### Optional ERD additions (proposal only)

| Proposed entity | Why needed | Suggested relationships |
|---|---|---|
| `beneficiaries` | Names, relationship, contact details in the beneficiary wireframe | FK to `plan_contracts`; decide whether beneficiary can belong to several contracts |
| `services` and `plan_services` | Service catalog and plan inclusion/pricing mapping | Junction FKs to services and memorial plans; separately approve price snapshot behavior |
| `refunds` | Refund request, reason, review status, approved amount | FK to payments and requesting/reviewing users; define eligibility and authorization first |

These require approval of business rules and an ERD revision before backend implementation. Read-only beneficiary, service, and refund screens illustrate the wireframe. No persistent management operation or corresponding database table is implemented.

## Local run instructions

1. Keep this directory at `C:\xampp\htdocs\st peter`.
2. Start Apache in XAMPP. Apache was started during verification and the app is currently available at [http://localhost/st%20peter/](http://localhost/st%20peter/).
3. Open the homepage; use the public footer demo links or account previews to enter the customer and administrator demos. No credentials are required.
4. MySQL is not required for the demonstration UI.

`app/config/config.php` defaults to `http://localhost/st%20peter/` and supports an `APP_URL` environment override with a trailing slash. All internal links use LavaLust `site_url()`. Do not hardcode a production URL. After relocating the project, update `APP_URL` or the local fallback.

Root `.htaccess` forwards requests to `public/`, prevents repeated forwarding, and blocks private directories under this subdirectory installation. `public/index.php` normalizes the external encoded mount path before LavaLust parses routes; this fixes Apache routing when the directory name contains a space. Framework core files are unchanged.

Optional PHP development server, from the project directory in PowerShell:

```powershell
$env:APP_URL='http://127.0.0.1:8088/'
& C:/xampp/php/php.exe -S 127.0.0.1:8088 tests/dev-router.php
```

Stop that foreground server with Ctrl+C. The router is development-only and blocks private directories. Apache remains the primary XAMPP demonstration path.

## Verification and evidence

Executed checks are recorded in `http-test-results.json` and `browser-test-results.json`.

- PHP syntax checks on application PHP files; JavaScript syntax check using `node --check`.
- Recursive HTTP verification of all reachable internal navigation and assets, plus explicit account previews, real 404 responses, private-file HTTP 403 checks, and checkout parameter preservation. The final count is in the HTTP evidence JSON. Both PHP's local server and XAMPP Apache were exercised; final evidence uses Apache.
- Browser checks: public plan navigation, customer dashboard, administrator dashboard, search empty state, inquiry preview, selected checkout method/date, report preview, FAQ accordion, and mobile menu navigation.
- All 36 primary/detail public and primary portal screens checked at 390px and 320px widths: 72 checks with no document-level horizontal overflow. Wide tables scroll inside their containers.
- Browser console inspection across tested pages found no warning/error entries.
- Actual screenshots saved in `docs/screenshots/`.

Environment note: XAMPP PHP emits a startup warning that the GD module is loaded twice. This pre-existing PHP configuration warning does not come from the application; PHP/Apache settings were not changed. Full production security, persistence, real payment gateways, real email/SMS, database import, accessibility audit, cross-browser coverage, and a report engine are not claimed.

## Changed and added files

Modified: `.htaccess`, `public/index.php`, `app/config/config.php`, `app/config/routes.php`.

Added: three area controllers plus shared `Memorial.php`; `Demo_model.php`; `app/config/memorial.php`; shared `app/views/memorial/` templates; `app/views/errors/memorial_404.php`; three public CSS/JS assets and the official logo image; `database/schema.sql`; two local verification scripts; this guide; route map; test-evidence JSON; browser screenshots. No framework core files, database credentials, starter migrations, or existing data were changed or deleted.

## Screenshot and submission checklist

Already captured (actual running pages):

- `screenshots/home-desktop.jpg`: wireframe-style public homepage.
- `screenshots/st-peter-overview.jpg`: previous dashboard-home design, superseded by the wireframe homepage.
- `screenshots/plans-desktop.jpg`: plan cards and prices.
- `screenshots/customer-desktop.jpg`: customer dashboard and navigation.
- `screenshots/admin-desktop.jpg`: administrator dashboard and navigation.
- `screenshots/home-mobile.jpg` and `screenshots/customer-mobile.jpg`: responsive layouts.
- `screenshots/contact-preview.jpg`: truthful demonstration form result.

Capture these manually from your editor/XAMPP tools before submission:

1. Editor Explorer showing `app`, `scheme`, `public`, `database`, `docs`, and `tests`.
2. Browser with the localhost address bar visible and the running homepage.
3. `app/config/routes.php` in the editor, showing actual LavaLust routing syntax.
4. Original supplied wireframe, sitemap, ERD, and assignment images are copied into `docs/references/` for submission evidence.
5. `database/schema.sql`, including representative PK/FK declarations; or phpMyAdmin's 13-table overview after a separate intentional import.
6. The system requirements and grading mapping below.
7. Navigation demonstration: customer billing with active sidebar, then administrator customers with a filtered table.

Avoid capturing environment files or credentials.

## Professor demonstration (about 5–7 minutes)

1. State the scope: Checking 1 design/setup prototype with explicitly read-only samples.
2. Show the original sitemap and open the homepage, plan catalog, and one plan detail; explain the three prices.
3. Open FAQ and expand a question; preview a contact inquiry and show that no message is sent.
4. Open the customer demo. Show Juan's dashboard, contract, installment schedule, and checkout selection. Explain that no payment is processed.
5. Open a sample receipt and demonstrate the print interface if needed; cancel printing when done.
6. Open the administrator demo. Show summary cards, searchable customer table, a management form preview, and report selector.
7. Resize to a mobile width and use the Menu control. Open an invalid URL to show HTTP 404 behavior.
8. Show routes, area controllers, shared views, and the model. Explain how LavaLust's existing bootstrap is retained.
9. Show SQL entities and foreign keys; explain missing optional entities and the preserved migration conflict. Present SQL preparation as preparation unless actual tables have been separately imported.

## Assignment image: seven-instruction acceptance mapping

| Instruction | Project evidence | Status |
|---|---|---|
| 1. Identify major features and functions | Implemented scope table and demonstration limitations above | Documented |
| 2. Prepare pages and navigation sitemap | `references/sitemap.jpg`, `ROUTES.md`, and working public/customer/admin menus | Prepared and implemented |
| 3. Create wireframes/interface designs | `references/wireframe.jpg` and actual desktop/mobile page screenshots | Prepared and implemented |
| 4. Design tables, fields, primary keys, and relationships | `references/erd.jpg` and `database/schema.sql` with 13 baseline tables | Design prepared; database import not performed |
| 5. Create/configure using LavaLust PHP | Existing LavaLust 4.7.0 project, area controllers, shared views, model, and local base URL | Implemented |
| 6. Initial routes and basic navigation | `app/config/routes.php`, `ROUTES.md`, and HTTP/browser checks | Implemented and verified |
| 7. Run locally without major errors | XAMPP Apache verification, HTTP evidence, browser evidence, and actual screenshots | Verified during implementation |

The assignment requests database **design**, so the ERD and SQL meet that design deliverable without claiming a database was imported. Full authentication, persistent CRUD, live payments, and real notifications are outside this Checking 1 checklist. The screenshot requirement still needs the editor/address-bar captures listed above; webpage screenshots alone do not show every grading category. This mapping describes the delivered evidence, not a guaranteed grade.

| Grading criterion | Weight | Evidence |
|---|---:|---|
| System Requirements | 20 | Scope/features and demo limitations in this guide |
| Sitemap and Navigation | 15 | `ROUTES.md`, working menus, route checks |
| Interface Design | 20 | Desktop/mobile screenshots and responsive browser checks |
| Database Design | 20 | 13-table baseline schema, relationships, optional additions |
| LavaLust Project Setup | 25 | Existing 4.7.0 bootstrap, actual routing/MVC APIs, XAMPP checks |

Remaining work for later checking stages: approved company policies and installment rules; secure authentication/authorization; server validation and CSRF for persistent actions; database models and transactions; guarded file storage; actual document generation; gateway/webhook reconciliation and idempotency; validated report queries; notifications; approved ERD additions. Do not publish this demonstration as a secure production system.


## St. Peter branding and dashboard revision

The user requested St. Peter's visual design and a dashboard presentation. The initial branding revision used a dashboard homepage. The latest user instruction supersedes that layout: the public site follows the wireframe with top navigation and a hero, while customer/admin portals retain their dashboard shells. Original sitemap routes, demo fixtures, and database design remain intact.

Visual reference sources, inspected October 15, 2026:

- Official website: https://stpeter.com.ph/
- Official stylesheet: https://stpeter.com.ph/css/public.css (green `#106939` / `#109448` references).
- Logo source: https://stpeter.com.ph/images/logo-lifeplan-new.png, saved locally as `public/assets/images/st-peter-logo.png`.

The dashboard layout is a custom academic adaptation, not a copy of an official St. Peter customer portal. Branding is accompanied by a visible college-project/nonofficial-service label. Assignment sample plans/prices must not be presented as official St. Peter offerings. No new frontend dependencies were added.

Changed for this revision: shared layout, public content, new overview template, 404 branding, new dashboard stylesheet, logo asset, image-asset smoke checks, this guide, and refreshed screenshots/test evidence. The shared `memorial.css` remains the base; `st-peter-dashboard.css` contains the dashboard theme.


## Latest revision: wireframe + sitemap + baseline ERD

The latest instruction restores the supplied wireframe's page purposes and structure with St. Peter styling:

| Wireframe area | Current implementation |
|---|---|
| Public homepage | Top navigation, hero, View Plans / Learn More, three benefits, plan cards, footer |
| Public plan catalog | All / Individual / Family / Premium filters, prices, coverage, detail links |
| Plan details | Illustration, price, coverage, Inquire Now / Add to Inquiry navigation |
| FAQ, contact, account access | Accordion, labeled form/contact layout, standalone account preview panels |
| Customer dashboard | Summary cards and Upcoming Payment card with schedule/payment links |
| My Plans / Contract Details | Plan card, contract number/start date/amount/paid/balance, coverage/schedule/document links |
| Billing and payment | Installment table, method selection, checkout/status demonstration |
| Receipts, inquiries, notifications | Sample file rows, inquiry card/New Inquiry action, reminder feed |
| Administrator | Summary cards/recent payments, management tables, search/status badges, add/create/upload buttons, report preview |

The compact portal sidebar remains without required scrolling at the previously tested normal desktop heights. Contract Details is indented below My Plans to reflect the sitemap hierarchy. Exact artwork and record values are illustrative, not a pixel-for-pixel reproduction.

Wireframe-only extension routes: `/customer/beneficiaries`, `/admin/services`, `/admin/refunds`. They are linked from the related contract, plan, and payment pages, and each explains its unapproved ERD addition. Primary sidebar navigation still follows the supplied sitemap. The baseline SQL remains exactly 13 tables and was not imported or modified by this design revision.

`home.php` and `wireframe.css` implement the public wireframe structure and page-specific refinements. `overview.php` is preserved from the earlier design but is no longer rendered. Current screenshots and HTTP/browser evidence were refreshed after this revision.
