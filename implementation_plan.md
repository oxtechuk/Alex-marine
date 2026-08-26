# redesign-product-page-to-match-reference

Redesign the Laravel product show page (`/products/{category_slug}/{product_slug}`) to match the structure, typography, inquiry action block, features & specifications layout, image presentation, and related products display shown in the reference design (`http://127.0.0.1:8000/products/marine-supplies/solas-marine-life-jacket`).

## User Review Required

> [!IMPORTANT]
> - **Language & Layout**: The website will support rich Arabic/English styling with RTL compatibility while reproducing the exact visual structure, clean spacing, two-column product display, bulleted Features & Specifications, "GOT INQUIRY?" call-to-action block, search icon overlay on image, and 3-card Related Products layout from the screenshot.
> - **Inquiry Buttons**: The "GOT INQUIRY ?" block includes direct buttons for **Chat with Us** (WhatsApp/Live Chat) and **Call Us Now / Request Quote** (Direct Call / RFQ Modal).

## Proposed Changes

### Database & Seeders

#### [MODIFY] [DatabaseSeeder.php](file:///c:/wamp64/www/al/database/seeders/DatabaseSeeder.php)
- Enhance product seed data (including `solas-marine-life-jacket` and marine safety equipment) with structured features, bullet points, specifications, and high-resolution product imagery.

---

### Product View & Design System

#### [MODIFY] [show.blade.php](file:///c:/wamp64/www/al/resources/views/products/show.blade.php)
- **Top Product Section**:
  - Re-align layout to match reference: 2-column split (Left: Text content & CTA, Right: High-res Product Image with zoom overlay button).
  - Bold product title typography in dark navy (`#0A1D37`).
  - Styled **Features** list section with bullet points (`المميزات:`) and **Specifications** list section (`المواصفات الفنية:`).
  - Summary reassurance paragraph below specs.
  - **"GOT INQUIRY ?"** box:
    - Bold uppercase heading `GOT INQUIRY ? / هل لديك استفسار؟`.
    - Teal/Emerald green **Chat with Us** button (`تحدث معنا 💬`).
    - Gold/Yellow **Call Us Now / Request Quote** button (`اتصل بنا 📞` / `طلب عرض سعر`).
- **Related Products Section**:
  - Centered bold header **Related Products / منتجات ذات صلة**.
  - Clean 3-column card grid with product thumbnail, category title, and product name.
- **RFQ Modal / Direct Action**:
  - Add seamless Request Quote Modal / Form accessible directly from the inquiry block.

#### [MODIFY] [app.scss](file:///c:/wamp64/www/al/resources/sass/app.scss) / [app.blade.php](file:///c:/wamp64/www/al/resources/views/layouts/app.blade.php)
- Refine styling tokens for navy tones, teal inquiry buttons, gold call buttons, image zoom overlay badge, bullet list styles, and card hover effects matching the reference design aesthetics.

## Verification Plan

### Automated & Built-in Verification
- Run `php artisan migrate:fresh --seed` (or seed database) to populate rich sample product data.
- Run `npm run build` or Vite build check to verify CSS/SCSS compilation without errors.

### Manual Verification
- Access `http://127.0.0.1:8000/products/marine-supplies/solas-marine-life-jacket` in browser.
- Verify two-column layout, image display with zoom icon, bold title, Features list, Specifications list, GOT INQUIRY block with Chat & Call buttons, and Related Products section matching the screenshot.
