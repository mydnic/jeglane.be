# Working in this repository

Laravel 13 on PHP 8.4, Inertia + Vue 3, Nuxt UI, Vite with an SSR bundle,
Jetstream for auth. `README.md` covers the local install.

## What CI runs on every pull request

`.github/workflows/ci.yml`. Run the same things before you push:

```bash
vendor/bin/pint --test        # PHP formatting
php artisan view:cache        # compiles every Blade view
php artisan test              # Pest, sqlite in memory on CI
yarn lint                     # eslint, `yarn lint:fix` to autofix
yarn build                    # vite client + SSR
yarn test:tracking            # pageview counting, needs Chromium
```

`php artisan view:cache` is the floor for any diff touching a Blade file: a
component tag that does not compile throws for every visitor, and it costs
seconds to catch.

## Things that are easy to break

- **The Rybbit tag** in `resources/views/app.blade.php` and the pageview
  tracking in `resources/js/app.js` are the only measurement this site has.
  `tests/Browser/pageview-tracking.mjs` asserts how many pageviews a real
  session sends; keep it passing.
- **`resources/js/ziggy.js` is generated** by `php artisan ziggy:generate`.
  Do not hand-edit it, and it is excluded from eslint.
- **The Vite build reads Ziggy out of `vendor/`**, so `composer install` has
  to run before `yarn build`, including in CI.
- **The Google Maps bootstrap loader** in `resources/js/Components/Map/Map.vue`
  is vendor code pasted verbatim. It is wrapped in `eslint-disable` on purpose.

## Conventions

- Controllers hold the Laravel CRUD actions only, or a single `__invoke`. No
  `private` or `protected` methods: move the logic to an action, a service or
  a helper, and authorization to a policy or a form request.
- Front-end style is the eslint config: 4 spaces, single quotes, no semicolons,
  no trailing commas, a space before a function paren.
