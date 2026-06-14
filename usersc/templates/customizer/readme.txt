DISTRIBUTING / RELEASING THIS TEMPLATE
======================================
This template generates per-install files at runtime: a user's customizations,
the generated stylesheets, the light/dark pairing, the capability marker. When
you distribute or update the template you must NOT ship those generated files.
Shipping them overwrites a user's existing setup, and a leftover
customizations.php suppresses first-load initialization so a fresh install
never receives its defaults.

Delete these from your release copy before packaging:

assets/css/customizations.php          generated parent theme — the TRIGGER
                                       file; MUST be absent for init to run
assets/css/revision.php                points at the timestamped parent CSS
assets/css/custom-bootstrap-*.css      generated parent stylesheets
assets/css/theme_pair.php              install-specific light/dark pairing
dark_mode.php                          generated light/dark capability marker
                                       (template root)

assets/child_themes/  -- delete the WHOLE directory's contents:
  dashboard.php, dashboard-*.css       the generated system dashboard theme
  *-<timestamp>.css                    generated child stylesheets (rebuilt
                                       on demand)
  preset copies (nord.php, carbon.php, ...)
                                       seeded from assets/presets/ by
                                       syncCustomizerPresets(); deleting them
                                       avoids shipping a user-edited copy

On first load, with customizations.php missing, initialize.php regenerates a
fresh set of defaults. Existing installs keep their own files untouched during
an update.

(Maintainers: the full release checklist lives in _plans/customizer_release.md.)


PRESETS
-------
Pre-made child themes ship in this template's own:

assets/presets/

Each preset is a single .php file that returns an array of `--bs-*` overrides
(keys drop the `--bs-` prefix and use hyphens) plus an optional `custom_css`
string, with a metadata docblock at the top (Preset / Category / Description /
Tags / Mode / Author).

On every customizer load, syncCustomizerPresets() (in initialize.php) copies any
preset from assets/presets/ that is not yet present in assets/child_themes/.
It NEVER overwrites — a preset a user has loaded, edited, or saved over is left
alone. So:

  - Ship new presets by adding .php files to assets/presets/. They appear for
    users automatically on their next customizer visit.
  - Updating the theme never disturbs a user's existing/edited child themes.
  - Removing a preset from assets/presets/ in an update does NOT remove it from
    installs that already have it.

When you distribute the theme, ship assets/presets/ (your preset pack) but you
do NOT need to ship assets/child_themes/ — that directory is per-install and is
seeded from assets/presets/ on first load.
