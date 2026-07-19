=== Mini Games Play ===
A WordPress theme converted from a static HTML/CSS/JS "Mini Games Play"
template (page1.html, style.css, first.js).

== Installation ==

1. Zip the "mini-games-play" folder (if not already zipped) and upload it
   via Appearance → Themes → Add New → Upload Theme, then Activate.
   Or drop the folder into wp-content/themes/ via FTP/SFTP.
2. Go to Settings → General and set the Site Title (used in the sidebar
   logo and navbar).
3. Go to Appearance → Customize:
   - "Hero Section" — edit the headline, subtext, buttons, and hero image.
   - "Featured Banner" — edit the CTA banner near the footer.
   - "Footer" — edit the About text and social links.
   - "Site Identity" → upload a custom logo icon if you don't want the
     default game-controller icon.
4. Add games: go to the new "Games" menu in wp-admin.
   - Set a Featured Image (used as the game thumbnail).
   - Fill in the "Game Details" box: playable game URL (iframe embed),
     rating, play count, and an optional HOT/NEW/TOP/ONLINE badge.
   - Assign one or more "Game Categories" (Action, Puzzle, Racing, Sports,
     Arcade, Brain Games, Multiplayer, Shooting, Board — created
     automatically on activation).
   - Assign a "Game List" term (Trending / Popular / New) to control which
     homepage row(s) a game appears in.
5. (Optional) Appearance → Menus:
   - Create a menu, assign it to "Sidebar Menu" to fully customize the
     left sidebar (add a Font Awesome class like "fa-solid fa-house" to
     a menu item's CSS Classes field — enable that field via Screen
     Options if it's hidden — to control its icon).
   - Create menus for "Footer: Categories" and "Footer: Quick Links" if
     you want to override the automatic footer columns.

== What was converted ==

- style.css   → theme stylesheet (WordPress theme header added, all
                original selectors and media queries kept as-is).
- first.js    → js/theme.js (adapted: fake/random play-count injection
                removed now that real data comes from post meta; the
                "Play Now" click-alert was replaced with a normal link to
                each game's single page, which can embed the game via an
                iframe).
- page1.html  → split into header.php / footer.php / front-page.php /
                template-parts/game-card.php / single-game.php /
                archive-game.php / taxonomy-game_category.php /
                taxonomy-game_list.php / search.php / 404.php / page.php /
                index.php, with the "Games" custom post type + the
                game_category and game_list taxonomies replacing the
                hardcoded game cards and category list.

== Note ==

The original HTML referenced a "responsive.css" file that wasn't part of
your upload — all the responsive rules were already present as @media
blocks inside style.css, so nothing is missing.

Image paths like assets/hero/hero.png and assets/games/game1.jpg from the
original template are not included (no image files were uploaded). Add
your own via the Customizer (hero image) and each Game's Featured Image;
the theme falls back to /images/hero.png and
/images/placeholder-game.jpg if you'd rather drop static files into the
theme's /images/ folder.

== Next step ==

This theme is intentionally built around a "game" custom post type and
"game_category" / "game_list" taxonomies (rather than hardcoded markup)
so it maps cleanly onto Elementor widgets in the next phase — e.g. a
"Game Grid" widget (query control by category/list/count), a "Game Card"
widget, and a "Sidebar Menu" widget, all reading from the same data.
