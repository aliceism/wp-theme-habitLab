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
