# On Stage Theatrical Productions — WordPress block theme

Native **Full Site Editing** theme (no Elementor, no page builders) for **On Stage Theatrical Productions, Inc.**

The installable theme **is the repository root**. Drop this folder into `wp-content/themes/` (folder name can stay `onstage-wp-theme` or be renamed `onstage`).

Ported from the read-only static mockup [hvnlysrph/onstage-client-preview](https://github.com/hvnlysrph/onstage-client-preview) (`index.html`, `about.html`, `programs.html`, `shows.html`, `scholarship.html`, `costumes.html`, `christmas-carol-costumes.html`, `gallery.html`, `style.css`). That repo is **not** Janet’s and must not be pushed to.

Requires **WordPress 6.4+** (block themes + core image lightbox). Tested against the 6.7 `theme.json` schema.

---

## Install on LocalWP (site already created)

Janet already has a blank Local site. Admin user: **devgirl**.

1. In Local, open the site → **Go to site folder** (or *Reveal in Finder*).
2. Copy **this entire repository folder** into:
   `app/public/wp-content/themes/onstage-wp-theme`
   You can clone it, download the ZIP from GitHub, or drag the folder in.
3. In Local, click **WP Admin** and log in as `devgirl`.
4. Go to **Settings → Permalinks**, choose **Post name**, and Save (needed for `/about/`, `/shows/`, etc.).
5. Go to **Appearance → Themes**, activate **On Stage Theatrical Productions**.
6. On first activation the theme will:
   - Upload the logo and set it as the Site Logo
   - Create pages (Home, About, Programs & Classes, Shows & Tickets, Scholarships, Costume Rentals, Photo Gallery, program/gallery/costume collection pages, plus Privacy/Terms stubs)
   - Set Home as the static front page
   - Create a **Primary** menu
   - Publish three demo **Shows** (Christmas Spectacular, Spring Musical, Student Showcase)
7. Visit the site (Local’s **Open site**). If menus 404, repeat the Permalinks save and refresh.

No production host, database password, or extra credentials are required for this Local workflow.

### Updating an already-activated copy

If the theme is **already active** in Local, you do **not** need to switch themes.

1. Copy this repository folder over `app/public/wp-content/themes/onstage-wp-theme` (replace the old files).
2. Open **WP Admin** once as `devgirl` (Dashboard is enough).
3. Version **1.0.17** will:
   - Overwrite seeded pages, including **Home** (hero wrap, Explore card slots, Upcoming Shows cards) and program child pages
   - Keep **PRODUCTIONS,** on one line in the home hero (slightly wider left column; no mid-word breaks)
   - Align Explore Our Programs rows: titles, copy, photos, and Find Out More on shared baselines
   - Rebuild Home **UPCOMING SHOWS AND EVENTS** cards: image left (~1/3), content right (~2/3), calendar date lines from Show meta, venue, light blue LEARN MORE
   - Center the Behind the Scenes pink badge
   - Crop program-child intro photos from **center top** so faces stay in frame (Cover focal point still wins if set)
   - Still publish Scheduled Shows whose WordPress date is in the future
   - Pause KSES with `kses_remove_filters()` / `kses_init()` only
   - Reset Site Logo and saved FSE templates/parts
4. Hard-refresh so `style.css?ver=1.0.17` and `layout-fixes.css` load.
5. Open Home (hero, Explore, Upcoming Shows, Behind the Scenes badge), then `/musical-theater/` and `/recreational-dance/` intro photos.

You do **not** need to deactivate/re-activate. Demo Shows **content** and existing Classes are not overwritten — only a scheduled Show’s WordPress **status/date** is set to Published / today.

If you already edited Home (or Header/Footer in the Site Editor), copy those edits first — this refresh replaces them with the theme files.

To force a full first-time seed again (developers only): delete the `onstage_setup_complete` and `onstage_content_version` options, then switch away from the theme and back.

---

## What the client edits where

| What | Where in WP Admin |
| --- | --- |
| Header, nav, footer, global colors/fonts | **Appearance → Editor** (Site Editor). Header/footer are template parts. Colors live in `theme.json` and **Styles**. |
| Home, About, Programs, Shows page intro, Scholarships, Costumes, Gallery | **Pages**. Each page is core blocks. Patterns under **On Stage** can be re-inserted. |
| Productions (title, dates, ticket URL, artwork) | **Shows** (custom post type). Not mixed with blog Posts. |
| Class schedule | **Classes** (custom post type). Weekday, time, ages, instructor, category color, optional NEW badge. The Programs page grid updates automatically. |
| Logo | **Appearance → Editor → Header**, or **Appearance → Customize** is limited; prefer Site Editor → Site Logo. |
| Privacy / Terms | Placeholder pages linked from the footer. Replace copy before any public launch. |

Ticket office and studio registration stay **external** (do not iframe or rebuild them):

- Tickets: `https://30865.smallvenueticketing.com/nocookie/start-session.cfm?goto=%2F`
- Join the Studio: `https://portal.akadadance.com/auth?schoolId=225`
- Give Kids A Chance application: `https://forms.gle/xSwt6845z1gy8TQE8`

---

## How to add a show

Published Shows always list on **Home** and **Shows & Tickets** (upcoming and TBA). The calendar date does **not** have to have arrived.

1. **Shows → Add Show**.
2. Title of the production.
3. Featured image (poster / artwork).
4. In **Show details** (sidebar):
   - **Dates / times** — the performance text shown on the site (for example `December 5, 2026 - 6:00 PM`). Leave this blank to display **TBA**.
   - **Venue**
   - **Ticket URL** — leave blank to use the studio-wide Small Venue Ticketing link
5. Write a short excerpt (used on cards) and optional body copy (used on the single show page).
6. Click **Publish** now. Do **not** schedule the WordPress post for the performance date — WordPress treats that as “not yet live” and can hide the show until that day.
7. Use an earlier (or today’s) **publish date** only if you want to control sort order on the listings. Performance dates live in the Dates/times field, not the WordPress publish date.

The show appears immediately on **Home** and **Shows & Tickets**.

### If existing Shows say Scheduled (Quick Edit workaround)

Older seed/import set the WordPress **Date** to the performance day (for example June 26, 2027). WordPress then hides the show until that clock time.

**After installing 1.0.14:** open WP Admin once. The theme publishes those Shows automatically (performance text in **Dates / times** is unchanged).

**Manual workaround if you need them live before replacing the theme:**

1. **Shows → All Shows**.
2. **Quick Edit** on each Scheduled show.
3. Change **Date** to today (and the time to now or earlier).
4. Set **Status** to **Published** if it is still Scheduled.
5. **Update**. Repeat for each show.

Do not put the performance datetime in the WordPress Date field again. Put it only in **Show details → Dates / times**.

---

## How to update the class schedule

**Modeled as a lightweight Class CPT** (`studio_class` in admin as **Classes**), not a calendar plugin and not a giant HTML table.

Each class is one post: title, weekday, time, ages/note, instructor, category color (Company / Musical Theater / Little Ones / Teen & Adult / Rehearsals / Hip Hop), optional **NEW** badge, and menu order within the day.

The Programs page heading, legend, Good to Know cards, performance-dates bar, and Call/Email buttons are normal blocks. The weekday columns are rendered by `[onstage_class_schedule]`.

1. **Classes → Add Class** (or edit an existing one).
2. Fill **Class details** in the sidebar.
3. Set **Order** (lower number = earlier in that day’s column).
4. Publish. The Fall 2026–2027 grid on **Programs & Classes** updates immediately.

To restore the page chrome: **+ → Patterns → On Stage → Fall 2026–2027 Class Schedule**. Seeded demo classes are created once on theme setup / 1.0.4 refresh and are not overwritten later.

---

## Images and documents (do not dump the 178MB tree)

This theme ships compressed **logo, hero, program stills, sponsor logos, staff portraits, and a handful of gallery thumbs** (~7MB) under `assets/images/`.

**Do not** copy the entire preview `/images` tree into git. Instead, on the Local site:

1. From the preview project, copy needed folders into a staging directory:
   - `/images/galleries/` (Dare to Dream, Peter Pan, Christmas Carol, Oliver)
   - `/images/A_Chistmas_Carol_Pictures/` (30 costume photos — note the folder spelling)
   - `/images/OLIVER_PICTURES_2024/`, `/images/PETER_PAN_25/`
   - `/documents/` (rental / sizing PDFs when they are ready)
2. In WP Admin → **Media → Add New**, upload what you need.
3. On Gallery, Costume, and Christmas Carol pages, replace the placeholder Gallery blocks with those uploads. Core **lightbox** is enabled in `theme.json` (click an image to enlarge). No gallery plugin required.

---

## Theme map

```
style.css          Theme header + ported mockup CSS + block-theme compatibility
theme.json         Palette, typography, layout, image lightbox
functions.php      Assets, pattern category, Query Loop CPT support, [onstage_show_details], [onstage_youtube]
inc/cpt-show.php   Show CPT + meta box (dates, venue, ticket URL)
inc/cpt-class.php  Class CPT + [onstage_class_schedule] weekday grid
inc/setup.php      First-activation pages, menu, demo shows/classes, logo; content-version page refresh
inc/inner-pages.php Shared markup for program / gallery / costume collection pages
templates/         FSE templates (header + post-content + footer)
parts/header.html  Logo + Navigation
parts/footer.html  Address, email, socials, legal links
patterns/          Page and section patterns (On Stage category)
assets/images/     Critical artwork only
```

Shows use a **Show CPT** (not blog posts) because productions need a ticket URL, venue, and featured image without mixing with news.

---

## Open questions for mentor review

1. **Program subpages** — Seeded as `/children-program/`, `/recreational-dance/`, `/musical-theater/`, `/voice-piano/`, and `/performance-competition/`.
2. **Schedule** — Class CPT is in place. Revisit a plugin only if the office wants parent-facing filters or online placement requests.
3. **Galleries** — Show pages are seeded (`/dare-to-dream-gallery/`, `/peter-pan-gallery/`, `/christmas-carol-gallery/`, `/oliver-gallery/`). Replace placeholder images with the full Media uploads.
4. **Costume PDFs** — Mockup marks rental/sizing forms as coming soon. Link Media uploads when legal/design signs off.
5. **Privacy / Terms** — Footer stubs only. Who supplies real copy?
6. **Per-show ticket URLs** — Demo shows reuse the generic Small Venue Ticketing session URL. Confirm unique links per performance.
7. **CDN fonts/icons** — Montserrat (Google Fonts) and Font Awesome 6 (cdnjs) match the mockup. Self-host for production privacy/performance?
8. **Summer camps** — The camps section is commented out in `programs.html`. Omit until dates are confirmed, or restore as a pattern?
9. **Give Kids A Chance** — Eligibility is a static list plus the existing Google Form. Keep it external, or replace with a WP form later (still no page builder)?

---

## Development notes

- Block theme / FSE only. Prefer core blocks. Query Loop lists the `show` CPT on Home and Shows.
- `[onstage_show_details]` prints dates, venue, and optional ticket button. PHP patterns are snapshotted on `init`, so post meta cannot live only in a pattern file.
- External ticket and studio links always `target="_blank"` / `rel="noreferrer noopener"` (Gutenberg’s button save output).
- Seeded page HTML must match core `save()` markup. Cover `dimRatio` has to match the overlay class (50 → `has-background-dim` only). Lists need `core/list-item` wrappers. Nested `core/pattern` placeholders are expanded into real blocks before they are stored on pages.
- No invented hosting, passwords, or production DNS.
