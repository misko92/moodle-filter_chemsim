# Chemistry simulations filter (filter_chemsim)

Embeds interactive chemistry simulations anywhere Moodle shows formatted text
(pages, labels, quiz questions, lessons, forum posts) with a shortcode:

    [chemsim pes]
    [chemsim pes mode=build el=Fe]
    [chemsim pes mode=identify tabs=0]
    [chemsim equilibrium predict=1]
    [chemsim solubility salt=PbI2]
    [chemsim solubility mode=mix]

Both simulations show a short guided tour the first time a student opens them (PES: each tab)
(remembered in that browser; the ? button replays it).

The simulations are self-contained HTML files in `sims/` (no external scripts,
no tracking, nothing stored on the server). Each one is shown in a frame that
resizes itself to fit; an "Open full screen" link opens it on its own.

## Simulations

| Name | What it is | Options |
|---|---|---|
| `pes` | Photoelectron spectroscopy: explore, how PES works, build a spectrum, identify the element (H–Ca, plus Sc, Fe, Zn, Fe²⁺) | `mode` = explore / measure / build / identify; `el` = element symbol (`Fe2+` for the ion); `compare` = element, `prev`, `next` or `none`; `tabs=0` hides the tabs; `tour=0` stops the first-visit tour from starting by itself (the ? button still shows it) |
| `equilibrium` | 2 NO₂ ⇌ N₂O₄ particle box: Le Chatelier changes, Q vs K, forward/reverse rates | `predict=1` turns on "predict first"; `title=0` hides the heading; `tour=0` stops the first-visit tour starting by itself |
| `solubility` | Saturated solutions and K<sub>sp</sub> (AgCl, PbI₂, Mg(OH)₂): adding solid or water, evaporating, common ion, acid; plus a "will it precipitate?" mixing tab | `mode` = sat / mix; `salt` = AgCl, PbI2 or MgOH2; `predict=1`; `title=0`; `tour=0` |

Every shortcode also accepts `height=` (pixels) for the starting frame height.
Options a simulation doesn't know are dropped, and unknown simulation names are
left as text so typos are easy to spot. Shortcodes inside `<code>` or `<pre>`
are not converted.

## Install

Copy to `filter/chemsim` (under `public/` on Moodle 5.1+), visit
Site administration → Notifications, then enable "Chemistry simulations" in
Site administration → Plugins → Filters → Manage filters.

## License

GNU GPL v3 or later.
