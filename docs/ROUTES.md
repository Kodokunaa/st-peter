# Route-to-page mapping

Paths are relative to `http://localhost/st%20peter/`. Pages use GET; persistent form endpoints are not implemented. Unknown page or record keys return HTTP 404.

| Area | Path | Page | Controller |
|---|---|---|---|
| Public | `/` | Home | Public_site |
| Public | `/about` | About Us | Public_site |
| Public | `/plans` | Memorial Plans | Public_site |
| Public | `/faq` | Frequently Asked Questions | Public_site |
| Public | `/contact` | Contact & Support | Public_site |
| Public | `/login` | Login | Public_site |
| Public | `/register` | Register | Public_site |
| Public | `/forgot-password` | Forgot Password | Public_site |
| Public | `/reset-password` | Reset Password | Public_site |
| Customer | `/customer/dashboard` | Dashboard | Customer_portal |
| Customer | `/customer/profile` | My Profile | Customer_portal |
| Customer | `/customer/plans` | My Plans | Customer_portal |
| Customer | `/customer/contracts` | Contract Details | Customer_portal |
| Customer | `/customer/billing` | Billing & Installments | Customer_portal |
| Customer | `/customer/payment` | Make a Payment | Customer_portal |
| Customer | `/customer/history` | Payment History | Customer_portal |
| Customer | `/customer/receipts` | Digital Receipts | Customer_portal |
| Customer | `/customer/documents` | My Documents | Customer_portal |
| Customer | `/customer/support` | Support Requests | Customer_portal |
| Customer | `/customer/notifications` | Notifications | Customer_portal |
| Admin | `/admin/dashboard` | Dashboard | Admin_portal |
| Admin | `/admin/customers` | Customers | Admin_portal |
| Admin | `/admin/plans` | Memorial Plans | Admin_portal |
| Admin | `/admin/contracts` | Plan Contracts | Admin_portal |
| Admin | `/admin/billing` | Billing & Installments | Admin_portal |
| Admin | `/admin/payments` | Payments & Transactions | Admin_portal |
| Admin | `/admin/methods` | Payment Methods | Admin_portal |
| Admin | `/admin/receipts` | Digital Receipts | Admin_portal |
| Admin | `/admin/documents` | Document Management | Admin_portal |
| Admin | `/admin/inquiries` | Inquiries Management | Admin_portal |
| Admin | `/admin/notifications` | Notifications | Admin_portal |
| Admin | `/admin/users` | Users & Roles | Admin_portal |
| Admin | `/admin/reports` | Reports | Admin_portal |

`/customer` and `/admin` also open dashboards. Public plan details: `/plans/individual`, `/plans/family`, `/plans/premium`. Contract Details is nested visually under My Plans in the customer sidebar.

## Sitemap subpages

| Parent path | Allowed suffixes |
|---|---|
| `/customer/profile/` | `edit`, `password` |
| `/customer/contracts/` | `CON-001`, `coverage`, `schedule`, `documents` |
| `/customer/billing/` | `upcoming`, `details` |
| `/customer/payment/` | `checkout`, `status` |
| `/customer/history/` | `PAY-001` |
| `/customer/receipts/` | `RCP-001` |
| `/customer/documents/` | `DOC-001` |
| `/customer/support/` | `new`, `INQ-001` |
| `/customer/notifications/` | `NTF-001` |
| `/admin/customers/` | `add`, `CL-001`, `CL-002`, `CL-003`, `edit`, `contracts`, `payments`, `documents` |
| `/admin/plans/` | `add`, `individual`, `family`, `premium`, `edit` |
| `/admin/contracts/` | `create`, `CON-001`, `edit` |
| `/admin/billing/` | `create`, `edit`, `status` |
| `/admin/payments/` | `record`, `PAY-001`, `transaction`, `qr` |
| `/admin/methods/` | `add`, `edit` |
| `/admin/receipts/` | `RCP-001` |
| `/admin/documents/` | `upload`, `DOC-001` |
| `/admin/inquiries/` | `INQ-001`, `respond` |
| `/admin/notifications/` | `NTF-001`, `delivery` |
| `/admin/users/` | `add`, `edit`, `roles`, `status` |
| `/admin/reports/` | `collections`, `contracts`, `enrollments`, `overdue`, `methods` |

## Wireframe-only extensions

These read-only previews are linked from related pages, separate from primary sitemap navigation. They require future ERD approval; no baseline tables are added.

- `/customer/beneficiaries` — from Contract Details.
- `/admin/services` — from Memorial Plans.
- `/admin/refunds` — from Payments & Transactions.
