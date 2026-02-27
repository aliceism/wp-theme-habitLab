# HabitLab (WordPress Theme)

HabitLab is an inspirational personal growth movement built as a content-first platform with a bold dark UI and energetic glow accents.

This repository contains the **HabitLab WordPress theme**. The theme is designed to support:

- A manifesto-style landing page (movement tone)
- A modern blog experience (readability-first)
- Logged-in user navigation for a future HabitLab dashboard plugin

## Goals

- **Dark, high-contrast UI** that feels energetic and motivating
- **Big typography, short copy**, strong emotional statements
- **Performance-friendly** (minimal JS, no heavy frameworks)
- Clean and maintainable WordPress theme architecture

## Non-goals (for now)

- No page builders
- No Tailwind/Bootstrap
- No complex animations that hurt performance

## Primary Pages

- Home (front-page.php): manifesto hero + philosophy + system + CTA
- Blog archive (archive.php): post grid cards with glow hover
- Single post (single.php): narrow readable layout, strong typography

## Login-aware Navigation

If the user is logged in, the theme will expose a "Dashboard" entry in the primary navigation (future plugin integration).

## Dev Notes

- CSS lives in `assets/css/main.css`
- JS lives in `assets/js/main.js` (keep minimal)
- Reusable sections/components in `template-parts/`

## Quick Start

1. Create folder: `wp-content/themes/habitlab/`
2. Add theme files and activate from WP Admin → Appearance → Themes
3. Customize menus in WP Admin → Appearance → Menus

## Brand Voice

HabitLab is a movement:

- confident, inspiring
- short, punchy sentences
- focus on identity, consistency, momentum

Examples:

- "You become what you repeat."
- "Momentum compounds."
- "Build systems. Not excuses."
  > > > > > > > 6b5295b (Initial commit)
