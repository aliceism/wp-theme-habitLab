# HabitLab Theme Notes

## Auth Page Setup

Create these WordPress pages in WP Admin:

1. `Login`
   - Slug: `login`
   - Template: `Auth Page`
   - Content: `[habitlab_login]`

2. `Join`
   - Slug: `join`
   - Template: `Auth Page`
   - Content: `[habitlab_register]`

The theme only provides layout, styling, and navigation. Authentication logic stays in the plugin that exposes these shortcodes.

## App Pages Setup

Create these WordPress pages in WP Admin:

1. `Dashboard`
   - Slug: `dashboard`
   - Template: default page template
   - Content: optional for now

2. `Habits`
   - Slug: `habits`
   - Template: default page template
   - Content: optional for now

3. `Progress`
   - Slug: `progress`
   - Template: default page template
   - Content: optional for now

The theme uses slug-based templates:

- `page-dashboard.php`
- `page-habits.php`
- `page-progress.php`

If plugin shortcodes or dynamic blocks are added later, place them in the page content. The theme already renders `the_content()` inside the branded app shell.
