# EMIS Interface Standard

The application interface is standardized through
`public/css/emis-design-system.css`, loaded once by `resources/views/new.blade.php`.
Print, PDF, and ID-card templates intentionally do not load it.

## Page structure

Every application page should extend `new` and use this order:

1. `x-emis.page-header`
2. optional filter/search card
3. one or more `x-emis.card` components
4. `x-emis.table` for record lists
5. a single action bar for form actions

Do not include a second `html`, `head`, or `body` element inside a Blade page
that extends the main layout.

## Buttons

Use `x-emis.button` or Bootstrap button classes. Supported semantic variants:

- `primary`: create, save, confirm
- `secondary`: back, cancel, reset
- `success`: approve, activate, issue
- `warning`: suspend, renew, review
- `danger`: delete, revoke
- `info`: preview, details

Use small icon buttons only inside table action columns. Every icon-only button
must have a localized `title` and `aria-label`.

## Tables

All record tables must be inside `.table-responsive` or use `x-emis.table`.
The final column is reserved for actions. Empty tables should use
`x-emis.empty-state`; do not leave a blank table body.

## Forms

- Use `.form-label`, `.form-control`, and `.form-select`.
- Keep a maximum of three short fields per desktop row and one on mobile.
- Display validation errors immediately below the corresponding field.
- Use one save action bar at the bottom of each form.

## Localization

Visible labels, headings, placeholders, tooltips, alerts, status labels, and
JavaScript messages must use translation keys. Translation keys belong in:

- `resources/lang/en/emis.php`
- `resources/lang/ps/emis.php`
- `resources/lang/fa/emis.php`

Database dates and numbers remain language-neutral. Direction is selected by
the main layout: English is LTR; Pashto and Dari are RTL.
