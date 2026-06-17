# HabitLab WordPress Theme

HabitLab is the custom WordPress theme for the Bachelor Thesis project **HabitLab Habit Tracker**. It provides the product-facing website, article experience, authentication pages, and logged-in application shell that supports the Habit Tracker plugin.

The theme is designed to present HabitLab as a complete habit-building platform rather than a standalone visual template. It combines marketing pages, educational content, responsive navigation, and deeply integrated dashboard templates for habits, check-ins, progress, and profile management.

## Table of Contents

- [Features](#features)
- [Screenshots](#screenshots)
- [Architecture](#architecture)
- [Content and Data Model](#content-and-data-model)
- [User Workflow](#user-workflow)
- [Habit Tracker Plugin Integration](#habit-tracker-plugin-integration)
- [Technologies Used](#technologies-used)
- [Testing](#testing)
- [Key Learning Outcomes](#key-learning-outcomes)
- [Repository Structure](#repository-structure)
- [Future Improvements](#future-improvements)

## Features

- Custom WordPress theme for the HabitLab product and thesis presentation.
- Responsive global header with primary navigation, mobile menu, app navigation, and logged-in user menu.
- Public landing page with hero section, HabitLab system explanation, interactive system modals, and mindset messaging.
- Insights/articles area with featured content, category topics, latest posts, guide-style posts, post cards, read-time labels, and related articles.
- Dedicated app page templates for Habits, Dashboard, Progress, and Profile.
- Authentication page template for login and registration flows.
- Theme overrides for Habit Tracker plugin templates, allowing the plugin output to match the HabitLab interface.
- Conditional loading of Habit Tracker styles only on relevant app pages or shortcode-powered pages.
- Logged-in front page redirect to the dashboard when a dashboard page exists.
- Redirect from the default WordPress admin profile page to the frontend profile experience.
- WordPress theme support for dynamic title tags, featured images, custom article image sizes, and a primary menu location.
- Vanilla JavaScript interactions for navigation, account menu behavior, and landing-page modals.

## Screenshots

Screenshots can be added to `docs/screenshots/` when available.

| Area | Placeholder |
| --- | --- |
| Landing Page | `docs/screenshots/landing-page.png` |
| Insights Page | `docs/screenshots/insights.png` |
| Habit App Shell | `docs/screenshots/app-shell.png` |
| Dashboard | `docs/screenshots/dashboard.png` |
| Progress | `docs/screenshots/progress.png` |

## Architecture

The theme is organized around WordPress template responsibilities and a small set of reusable helpers.

- **Theme bootstrap**: `functions.php` loads the setup, assets, helpers, and routing modules from `inc/`.
- **Setup module**: `inc/setup.php` registers WordPress theme support, image sizes, and the primary navigation menu.
- **Asset module**: `inc/assets.php` enqueues the base theme CSS/JS and conditionally loads the Habit Tracker integration stylesheet.
- **Helper module**: `inc/helpers.php` centralizes page URL resolution, dashboard/profile links, read-time calculation, and article category helpers.
- **Routing module**: `inc/routing.php` handles product-specific redirects and forces the frontend profile template where appropriate.
- **Global layout**: `header.php` and `footer.php` define the site shell, logged-out navigation, logged-in app navigation, user menu, and main content region.
- **Page templates**: `front-page.php`, `page-auth.php`, `page-habits.php`, `page-dashboard.php`, `page-progress.php`, `page-profile.php`, `page-insights.php`, and `page-articles.php` define the major product screens.
- **Template parts**: `template-parts/` contains reusable sections for the landing page, app page shell, page headers, article cards, single posts, pages, and empty states.
- **Plugin template overrides**: `habit-tracker/` contains theme-level template overrides consumed by the Habit Tracker plugin's template resolver.
- **Assets**: `assets/css/main.css`, `assets/css/habit-tracker.css`, `assets/js/main.js`, and reference images provide the theme presentation and interactions.

## Content and Data Model

The theme does not create custom database tables. It relies on WordPress content and user data, plus the companion Habit Tracker plugin for habit-specific persistence.

WordPress-managed data includes:

- Pages such as `home`, `insights`, `articles`, `login`, `join`, `habits`, `dashboard`, `progress`, and `profile`.
- Posts used for the Insights and Articles sections.
- Categories and tags used for article topics, guides, featured content, and related posts.
- Featured images rendered through custom image sizes.
- WordPress users, authentication state, display names, and profile links.
- Menus assigned to the theme's `primary` menu location.

Habit-tracking data is owned by the plugin, not the theme. The theme integrates with that plugin through shortcodes and template overrides.

## User Workflow

### Visitor

1. Lands on the public HabitLab homepage.
2. Reads the core product message and opens system modals for Knowledge, Practice, and Proof.
3. Browses Insights content, topics, featured posts, and latest articles.
4. Opens the Login or Join page from the public navigation.

### Registered User

1. Logs in or creates an account through the authentication page.
2. Is guided into the app shell with navigation for Insights, Habits, Dashboard, and Progress.
3. Opens Habits to manage the habit stack through the Habit Tracker plugin.
4. Opens Dashboard to track daily check-ins and review live metrics.
5. Opens Progress to review trend and category analytics.
6. Uses the user menu to access the frontend profile page or log out.

### Administrator / Site Owner

1. Activates the HabitLab theme in WordPress.
2. Creates the expected pages and assigns templates where needed.
3. Assigns the primary navigation menu.
4. Publishes article content with categories, tags, excerpts, and featured images.
5. Activates the companion Habit Tracker plugin to power the app views.

## Habit Tracker Plugin Integration

The theme is built to work closely with the custom Habit Tracker plugin.

The app page templates call plugin shortcodes when they are available:

| Theme Page | Plugin Shortcode Usage |
| --- | --- |
| `page-habits.php` | `[habit_tracker_habits_notice]`, `[habit_tracker_habits_stack]`, `[habit_tracker_habits_shared]`, `[habit_tracker_habits]` |
| `page-dashboard.php` | `[habit_tracker_dashboard]` |
| `page-progress.php` | `[habit_tracker_progress]` |
| `page-profile.php` | `[habit_tracker_profile]` |
| `page-auth.php` | `[habit_tracker_login_form]`, `[habit_tracker_register_form]` |

If plugin shortcodes are unavailable, the theme renders fallback cards explaining which integration is missing.

The `habit-tracker/` directory contains template overrides for dashboard metrics, monthly check-in grids, habit stack modals, shared habit modals, progress charts, and category analytics. This keeps plugin functionality visually consistent with the HabitLab product interface.

## Technologies Used

- WordPress Theme API
- PHP 7.4+
- WordPress template hierarchy
- WordPress hooks, filters, page templates, menus, post thumbnails, users, and queries
- WordPress shortcodes through the companion Habit Tracker plugin
- Vanilla JavaScript for navigation, user menu state, and modal interactions
- CSS for responsive layout, landing pages, article pages, and app UI styling
- WordPress posts, pages, categories, tags, featured images, and theme template parts

## Testing

The theme does not currently include a dedicated automated test suite.

Current verification is manual and syntax-oriented:

- PHP syntax checks across all theme PHP files.
- Manual browser testing for responsive navigation, landing-page modals, article templates, authentication pages, and Habit Tracker plugin integration.
- WordPress runtime verification for templates, shortcodes, redirects, menus, and asset loading.

Syntax check command:

```bash
find . -name '*.php' -print0 | xargs -0 -n 1 php -l
```

Latest local result: all PHP files passed syntax validation.

## Key Learning Outcomes

- Designing a custom WordPress theme as a complete product interface, not only a static website skin.
- Integrating a theme and plugin through shortcodes, template overrides, shared helper functions, and conditional asset loading.
- Applying WordPress template hierarchy concepts to landing pages, app pages, auth pages, article archives, and single posts.
- Building a user-aware navigation system that changes between public and logged-in states.
- Structuring reusable template parts for maintainability and consistent visual language.
- Balancing marketing content, educational articles, and application screens inside one coherent thesis project.
- Using progressive enhancement with simple JavaScript while keeping the core WordPress/PHP rendering functional.

## Repository Structure

```text
habitlab/
|-- assets/
|   |-- css/
|   |   |-- main.css
|   |   `-- habit-tracker.css
|   |-- images/
|   |   `-- reference-images/
|   `-- js/
|       `-- main.js
|-- habit-tracker/
|-- inc/
|   |-- assets.php
|   |-- helpers.php
|   |-- routing.php
|   `-- setup.php
|-- template-parts/
|   |-- app/
|   |-- content/
|   `-- front-page/
|-- 404.php
|-- archive.php
|-- footer.php
|-- front-page.php
|-- functions.php
|-- header.php
|-- index.php
|-- page-auth.php
|-- page-dashboard.php
|-- page-habits.php
|-- page-insights.php
|-- page-profile.php
|-- page-progress.php
|-- page.php
|-- single.php
|-- style.css
`-- README.md
```

## Future Improvements

- Add automated tests for helper functions with a WordPress test environment.
- Add pagination or filtering to the custom Articles page if content volume grows.
