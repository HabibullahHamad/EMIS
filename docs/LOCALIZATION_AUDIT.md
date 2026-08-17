# EMIS Localization Audit

Initial source audit covered 124 Blade files. It found 573 distinct literal UI
strings (1,083 occurrences), in addition to already localized content.

The first normalization pass connected 264 repeated literals across 37 main
layout pages to existing translation keys. A static key check now confirms that
every literal `emis.*` key used by the application is defined in English,
Pashto, and Dari. The dynamic `emis.status_*` prefix is intentionally resolved
at runtime from the status value.

The Settings Center translation registry is complete in English, Pashto, and
Dari. Remaining legacy literals are concentrated in correspondence, tasks,
tracking, users, departments, notifications, and unused prototype views.

## Rule

New or changed pages must not introduce literal user-facing text. Use
`__('emis.key')` for interface text and `__('messages.key')` for operation
results. Missing keys must be added to all three locales in the same change.

## Legacy view handling

Some older Blade files contain complete nested HTML documents or duplicate
prototype pages. They must not be bulk-deleted because their deployment usage
is not proven. Routed pages should be converted module by module; confirmed
unused prototypes can then be archived or removed in a separate, reviewed
change.

## Functional gaps discovered and resolved

The following active views were absent in the uploaded source and are included
in the corrected package:

- `focal-point-introductions.show` and `.edit`
- `focal-point-cards.verification` (public QR verification)
- `budget-entities.show` and `.edit`
- `layouts.app` and `layouts.guest`

The QR verification route was moved outside the authenticated route group so a
card can be verified without logging into EMIS.

The following references remain only in legacy controllers that have no route
registration in the uploaded project. They were not activated because their
models, relationships, or database workflow are incomplete:

- `DocumentManagement.dindex`
- `export_documents.show`
- `letters.index` and `.show`
- `comming`

The archive also references three Persian date-picker assets that are absent
from `public/`: `css/persian-datepicker.min.css`, `js/persian-date.min.js`, and
`js/persian-datepicker.min.js`. Either add the locally licensed assets or
remove those layout references if the date-picker is no longer used.
