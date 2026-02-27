# HabitLab Theme Architecture

## Core Templates

- header.php / footer.php: global layout shell
- front-page.php: landing page (movement sections)
- index.php: fallback template
- page.php: standard pages
- single.php: blog post
- archive.php: blog/category archives
- 404.php: error page

## Template Parts

Reusable sections in `template-parts/`:

- hero.php
- section-philosophy.php
- section-system.php
- section-dashboard-preview.php
- section-cta.php
- card-post.php

## Assets

- assets/css/main.css: design system + components + layout
- assets/js/main.js: minimal enhancements (menu toggle, counters)

## Login-aware UI

Header navigation should show:

- If logged out: "Login" / "Join"
- If logged in: "Dashboard" + "Logout"

Dashboard route:

- Use a placeholder page with slug `/dashboard` until the plugin provides content.
