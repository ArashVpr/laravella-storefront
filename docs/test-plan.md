# Laravella Storefront — Comprehensive Test Plan

Date: 2025-11-15
Scope: Web UI + Server-side behaviors (routes/controllers/views)
Seed/Baseline Data: `seed.spec.ts` (when used for environment prep) and Laravel factories

## Application Overview

A Laravel-based car marketplace with public browsing and authenticated seller features.

- Browsing: Home listings, advanced search with filters/sorting/pagination, car detail pages with gallery and specs.
- Auth: Email/password login, signup, logout, email verification, password reset, optional social login (Google/Facebook).
- User: Profile management (name, email, phone), password change with strong policies.
- Watchlist: Authenticated users can favorite/unfavorite cars and view their watchlist.
- Seller (verified users): CRUD for cars, image management (add/reorder/delete), publishing controls.
- Static: Legal pages (privacy, cookies, mentions), docs, ERD view, file download route.

## Assumptions & Test Data

- Fresh database migrated with seed data; demo credentials available from UI: `akoelpin@example.net` / `password`.
- Email delivery uses a test transport (e.g., log/file) or MailHog; links can be extracted from logs.
- Social login uses test OAuth apps or is mocked in lower environments.
- File storage uses local `public` disk; images accessible via `Storage::url`.
- Base URL (local): `http://localhost:8000` (adapt if different).
- Roles/Policies: Only owners can edit/delete their cars; creating a car requires a phone number on profile; watchlist endpoints require `auth` and `verified`.

## Test Environments

- Browsers: Chromium, Firefox, WebKit (latest stable). Mobile viewport smoke on Chromium.
- Headless/CI: All flows executable headless; downloads verified via response headers.
- Accessibility: Quick checks (tab order, labels, color contrast heuristic) on key pages.

---

## 1. Home Page — Listings and Entry Points

Seed: `seed.spec.ts`

### 1.1 Load Home and List Cars (Happy Path)
Steps:
1. Navigate to `/`.
2. Observe hero slider and search form presence.
3. Verify "New Cars" list renders up to 30 recent items.
Expected:
- HTTP 200, no console errors.
- Each card shows image (or placeholder), title, price, location.
- Pagination controls absent on home (limited feed only).
Success: All UI elements render and at least one card appears with correct data.
Failure: Empty list with seeded data, broken images, console errors.

### 1.2 Navigate to Car Detail From Home
Steps:
1. Click first car card title/image.
Expected:
- Navigates to `/car/{id}` with car details visible.
Success: Detail page loads with main image and specs.
Failure: 404 or missing associations.

### 1.3 Search Entry From Home Form
Steps:
1. In home search widget, select a maker and submit.
Expected:
- Redirects to `/car/search` with query params applied and results filtered.
Success: URL has `maker_id`; results correspond.
Failure: Filters ignored or errors in query string.

---

## 2. Authentication & Verification

### 2.1 Signup (Valid)
Steps:
1. Go to `/signup`.
2. Fill valid `name`, unique `email`, valid `phone` (8–15 chars), strong password + confirmation.
3. Submit.
Expected:
- Redirect to `/` with success flash: verification notice.
- User is authenticated; `verification.notice` accessible.
Success: User created, session established, verification mail queued.
Failure: Validation errors for fields; no user created.

### 2.2 Signup (Invalid Inputs)
Steps:
1. Submit empty form.
2. Submit with weak password; duplicate email/phone.
Expected:
- Field-level errors reflecting `Store` rules; password complexity errors.
Success: Errors display, old inputs preserved (where applicable), no user created.

### 2.3 Email Verification Flow
Steps:
1. As newly signed-up user, visit a verified-only route (e.g., `/watchlist`).
2. Expect redirect to `verification.notice`.
3. Trigger resend `POST /email/verification-notification` and follow emailed `GET /email/verify/{id}/{hash}` link.
Expected:
- After verify, redirect to `/` with success message; verified middleware allows access.
Success: Verified flag set; access to gated routes works.
Failure: Invalid/expired link shows error; user remains unverified.

### 2.4 Login/Logout
Steps:
1. Visit `/login` and login with demo credentials.
2. Logout via `POST /logout`.
Expected:
- Login redirects to intended/home with flash success; session regenerated.
- Logout redirects to home; session and CSRF token regenerated.
Success: Auth transitions succeed; no CSRF errors.
Failure: Bad creds show error on email field; stays on login.

### 2.5 Password Reset
Steps:
1. Start at `/forgot-password`; submit known email.
2. From email, open `/reset-password/{token}`; submit strong new password + confirmation.
Expected:
- Link sent message; on reset, redirect to `/login` with success flash.
Success: Password updated; old password invalid.
Failure: Invalid token/email shows error; password policy enforced.

### 2.6 Social Login (Google/Facebook)
Steps:
1. Click `Login with Google/Facebook`.
2. Complete OAuth flow (or mocked path) returning to app.
Expected:
- On callback, user is created/updated, authenticated, redirected to intended/home.
Success: Session established; email verified flag set per controller.
Failure: Exceptions redirect back to `/login` with error flash.

---

## 3. Profile Management

### 3.1 View Profile
Steps:
1. Authenticated user visits `/profile`.
Expected:
- Form shows current `name`, `email` (unless OAuth-only), `phone`.
Success: Page renders; data matches DB.

### 3.2 Update Profile (Valid)
Steps:
1. Change `name`, `phone` to unique; optionally `email` to a new unique.
2. Submit `PUT /profile`.
Expected:
- Flash success; if email changed, verification mail sent and `email_verified_at` cleared.
Success: DB updated; subsequent views reflect changes.
Failure: Duplicate `email`/`phone` shows errors; OAuth-only user may skip email rule.

### 3.3 Update Password (Valid/Invalid)
Steps:
1. Submit current password and a strong new password with confirmation to `PUT /profile/password`.
2. Try weak password or wrong current password.
Expected:
- Success: flash message; password actually changes.
- Failures: field errors for policy or current password.

---

## 4. Car Browsing & Search

### 4.1 Search With Filters (Happy Path)
Steps:
1. Visit `/car/search`.
2. Set combinations: maker/model, car type, fuel, year range, price range, mileage, state/city.
3. Submit; paginate through results.
Expected:
- Results reflect filters; query string persists across pages; `Found N cars` shows total.
Success: Server applies all filters and sort order; pagination stable.
Failure: Filters ignored, incorrect totals, invalid joins on state/city.

### 4.2 Sorting
Steps:
1. Use sort dropdown values: `price`, `-price`, `year`, `-year`, `mileage`, `-mileage`, `created_at`, `-created_at`.
Expected:
- Order changes accordingly; stable when combined with filters.

### 4.3 Reset Filters
Steps:
1. Click Reset in the sidebar form.
Expected:
- All inputs cleared; results reflect default (most recent).

### 4.4 No Results State
Steps:
1. Choose filter combo that yields zero matches.
Expected:
- "No results found" message; suggestions to change criteria.

---

## 5. Car Details Page

### 5.1 Render Details and Specs
Steps:
1. Open `/car/{id}` for a seeded record with images/features.
Expected:
- Main image displayed; thumbnails populated; specs list reflects feature flags; price formatted.
- JSON-LD structured data script present with correct fields (name, brand, price, images).

### 5.2 Carousel Navigation
Steps:
1. Click next/prev arrows; click thumbnails.
Expected:
- Active image updates accordingly.

### 5.3 Watchlist Toggle — Unauthenticated
Steps:
1. Click heart button.
Expected:
- Request to `/watchlist/{car}` rejected (auth/verified); UI shows login requirement or no-op; no server-side change.

### 5.4 Watchlist Toggle — Authenticated + Verified
Steps:
1. Login + verify; open car detail; click heart to add, click again to remove.
Expected:
- JSON response `added: true/false`; icon toggles; watchlist reflects change.

### 5.5 Reveal Phone Number
Steps:
1. On details, click "view full number" (calls `POST /car/phone/{car}`).
Expected:
- Phone displayed in full from JSON; tel link updated.
Failure: Non-200 or incorrect masking logic.

---

## 6. Watchlist

### 6.1 View Watchlist Page
Steps:
1. Auth+verified user visits `/watchlist`.
Expected:
- Cards list favorited cars; pagination summary present if > page size.

### 6.2 Add/Remove From List
Steps:
1. From details or search cards, toggle heart for multiple cars; reload `/watchlist`.
Expected:
- Items appear/disappear accordingly; order is newest-first by pivot id.

---

## 7. Seller Dashboard — My Cars

### 7.1 List My Cars
Steps:
1. Visit `/car` while authenticated and verified.
Expected:
- Table with image, title, date, published flag, actions (edit/images/delete); pagination as needed.

### 7.2 Create Car — Valid
Steps:
1. Navigate to `/car/create`.
2. Fill required fields per `StoreCarRequest` including maker/model/year/type/price/vin/mileage/fuel/city/address/phone.
3. Add multiple images (<=2MB each); set features; submit `POST /car`.
Expected:
- Redirect to `/car` with success flash; new row visible; primary image derived from lowest position.

### 7.3 Create Car — Missing Phone On Profile (Gate)
Steps:
1. Ensure user profile lacks phone; visit `/car/create`.
Expected:
- Redirect to `profile.index` with warning to provide phone.

### 7.4 Create Car — Validation Errors
Steps:
1. Leave required fields blank; upload oversized image.
Expected:
- Field errors aligned with rules (e.g., year bounds, image size <= 2MB, price/mileage >= 0, VIN max 17).

### 7.5 Edit Car — Owner
Steps:
1. Open `/car/{id}/edit`; update fields and submit `PUT /car/{id}`.
Expected:
- Flash success; values persisted; features merged with zero-defaults.

### 7.6 Edit/Delete — Not Owner
Steps:
1. As another user, request `/car/{id}/edit` and `DELETE /car/{id}`.
Expected:
- 403 Forbidden (policy/gate) for update/delete.

### 7.7 Manage Images
Steps:
1. Open `/car/{id}/images`.
2. Reorder via positions; delete selected; submit `PUT /car/{id}/images`.
3. Add new images via `POST /car/{id}/images`; submit with no files.
Expected:
- Deletions remove files from storage and records; positions persisted; success flash.
- Posting with no files shows warning flash; adding files appends positions after max.

---

## 8. Static & Utility Pages

### 8.1 Legal Pages
Steps:
1. Visit `/privacy`, `/cookies`, `/mentions-legales`.
Expected:
- HTTP 200; content renders from blade components.

### 8.2 Documentation & ERD
Steps:
1. Visit `/docs`, `/docs-fr`, `/erd`.
Expected:
- HTTP 200; respective content displays.

### 8.3 File Download
Steps:
1. Visit `/download-cv`.
Expected:
- Prompts a download of `CA-f.pdf`; `Content-Disposition: attachment` set.

---

## 9. Security & Access Control

- Auth-only routes reject guests (302 to login or 401/403 for XHR); verified-only routes reject unverified users to notice page.
- CSRF tokens required on form posts; method spoofing used for `PUT`/`DELETE`.
- Only owners can modify their cars; non-owners receive 403.
- Phone revelation endpoint returns only the car owner’s provided phone; no sensitive leakage.

Scenarios:
1. Guest access to `/car/create` → redirect to login.
2. Auth but unverified access to `/watchlist` → verification notice.
3. Owner vs non-owner edit/delete → 200 vs 403.
4. XHR to `/watchlist/{car}` as guest → non-200 and no DB change.

---

## 10. Error Handling & Edge Cases

- Invalid car id `/car/999999` → 404 page.
- Search with nonsensical ranges (year_to < year_from) → verify server-side resilience (should still return empty or correct subset; no exception).
- Very high pagination page number → shows last page gracefully.
- Missing images on detail → fallback placeholder displayed.
- Long descriptions sanitized and trimmed; JSON-LD description <= 300 chars (no newlines).

---

## 11. Non-Functional Checks

- Performance: Pagination query counts acceptable (eager loaded relations in controllers). Basic TTI < 3s locally.
- Caching: Home page list cached for 60 minutes as `home-cars`; verify cache warms and expires; new creations not shown until cache expiry (documented behavior).
- SEO: Presence of structured data script on car detail; page titles set via `<x-app title>`.
- Accessibility: Forms have labels; interactive elements focusable; color contrast check on primary buttons.

---

## 12. Test Data and Reset

- Use Laravel factories to generate cars with images/features for deterministic tests.
- Clean-up: Delete created cars; reset favorites; clear storage for uploaded images in test env.

---

## 13. Traceability Matrix (Routes → Scenarios)

- `/` → 1.1, 1.2, 1.3
- `/car/search` → 4.x
- `/car/{car}` → 5.x
- `/watchlist` → 6.x, 9.x
- `/car` CRUD + `/car/{car}/images` → 7.x
- Auth flows `/login`, `/signup`, `/logout` → 2.x
- Verification `/email/*` → 2.3
- Password reset `/forgot-password`, `/reset-password/*` → 2.5
- Legal & docs `/privacy`, `/cookies`, `/mentions-legales`, `/docs`, `/docs-fr`, `/erd` → 8.x
- Download `/download-cv` → 8.3

---

## 14. Automation Notes (Playwright)

- Use data-testid or semantic selectors when available; otherwise rely on stable labels and button text.
- Handle CSRF by real form submissions; for XHR endpoints, include cookies from logged-in context.
- Mock OAuth providers in CI; assert redirect flows and callback handling.
- For email flows, parse links from test mailbox/logs.

Example commands:

```bash
# Run Playwright E2E (headless)
npx playwright install --with-deps
npx playwright test --project=chromium --reporter=list
```

---

## 15. Acceptance Criteria Summary

- Core user journeys (browse → view → favorite) work for guests and authenticated users with expected gating.
- Sellers can create and manage listings with full validation and image handling.
- Auth flows (signup/login/logout/reset/verify) are reliable and secure.
- Static routes and download endpoint respond correctly.
- Security and authorization rules enforced for all protected actions.
