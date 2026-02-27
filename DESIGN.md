# HabitLab Design System (Bold Energy Dark)

This theme uses a high-contrast dark UI with controlled neon glow accents.
The goal is **inspiring & energetic**, but still readable and clean.

## 1) Color Tokens

### Backgrounds

- --bg-primary: #070B14
- --bg-secondary: #0F172A
- --surface-card: #111827

### Text

- --text-primary: #E5E7EB
- --text-secondary: #94A3B8
- --text-muted: #64748B

### Accents (use sparingly)

- --accent-blue: #3B82F6 (primary CTA, links, focus)
- --accent-purple: #8B5CF6 (energy gradient, secondary accent)
- --accent-green: #22FF88 (success/progress)
- --accent-amber: #FFB020 (streak/highlight)
- --accent-pink: #EC4899 (very limited, special highlights only)

## 2) Typography

- Headings: Poppins or Space Grotesk (fallback: system-ui)
- Body: Inter (fallback: system-ui)

Rules:

- Headings: bold, big, short lines
- Body: max width 700–800px on reading pages
- Avoid pure white text on pure black

Suggested sizes (desktop):

- H1: 64–80px in hero
- H2: 36–44px
- Body: 16–18px, line-height 1.6+

## 3) Layout & Spacing

- Use generous whitespace
- Standard container width: 1120px
- Reading container width: 720–800px

Radius:

- Cards/buttons: 12px
- Tags/chips: 999px (pill)

## 4) Glow Rules (important)

Glows must be:

- controlled (not everywhere)
- used for primary CTAs, hover states, active nav items

Recommended glow approach:

- Primary CTA uses blue glow
- Secondary CTA uses subtle purple glow
- Progress/success uses green glow
- Streak highlight uses amber glow

Do not:

- add glow to every card by default
- animate glow constantly (use hover or subtle pulse only on hero CTA)

## 5) Components

### Buttons

- .btn
- .btn-primary (blue glow)
- .btn-secondary (outline/gradient)
- .btn-ghost

### Cards

- .card (surface background)
- .card--hover (lift + border glow on hover)

### Post Card

- image/thumbnail (optional)
- category tag (pill)
- title
- excerpt

### Tags/Chips

- .tag (pill)
- color: blue/purple depending on category

### Stats

- big number + label
- optional icon
- number can animate (count-up) via minimal JS

## 6) Motion Guidelines

Transitions:

- 0.25–0.35s ease
  Hover:
- translateY(-4px) on cards
- scale(1.03–1.05) on primary CTA
  Avoid:
- heavy parallax
- continuous animations that impact performance

## 7) Copy Tone (Movement)

Use short, punchy text.
Examples:

- "You become what you repeat."
- "Systems beat motivation."
- "Momentum compounds."
