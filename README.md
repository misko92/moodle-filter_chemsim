# Chemistry simulations filter (filter_chemsim)

Embeds interactive chemistry simulations anywhere Moodle shows formatted text
(pages, labels, quiz questions, lessons, forum posts) with a shortcode:

    [chemsim pes]
    [chemsim pes mode=build el=Fe]
    [chemsim pes mode=identify tabs=0]
    [chemsim equilibrium predict=1]
    [chemsim boltzmann]
    [chemsim boltzmann mode=energy]
    [chemsim gaslaws]
    [chemsim gaslaws mode=mix]
    [chemsim kinetics]
    [chemsim kinetics mode=identify]
    [chemsim solubility salt=PbI2]
    [chemsim solubility mode=mix]

Every simulation shows a short guided tour the first time a student opens it (each tab separately)
(remembered in that browser; the ? button replays it).

The simulations are self-contained HTML files in `sims/` (no external scripts,
no tracking, nothing stored on the server). Each one is shown in a frame that
resizes itself to fit; an "Open full screen" link opens it on its own.

## Simulations

| Name | What it is | Options |
|---|---|---|
| `pes` | Photoelectron spectroscopy: explore, how PES works, build a spectrum, identify the element (H–Ca, plus Sc, Fe, Zn, Fe²⁺) | `mode` = explore / measure / build / identify; `el` = element symbol (`Fe2+` for the ion); `compare` = element, `prev`, `next` or `none`; `tabs=0` hides the tabs; `tour=0` stops the first-visit tour from starting by itself (the ? button still shows it) |
| `boltzmann` | Maxwell–Boltzmann: speed distribution of a colliding gas (temperature, He/N₂/CO₂/Xe, He + Xe mixture, same-speed start) and the kinetic-energy distribution with a draggable E<sub>a</sub>, catalyst and temperature comparison | `mode` = speed / energy; `gas` = He, N2, CO2, Xe or mix; `title=0`; `tour=0` |
| `equilibrium` | 2 NO₂ ⇌ N₂O₄ particle box: Le Chatelier changes, Q vs K, forward/reverse rates | `predict=1` turns on "predict first"; `title=0` hides the heading; `tour=0` stops the first-visit tour starting by itself |
| `gaslaws` | Ideal gas in a container with a piston (locked or free) and a pressure gauge; wall hits shown; record points and graph P vs V, P vs 1/V, P vs T, V vs T (with °C extrapolation to absolute zero), P vs n, V vs n; partial-pressures tab with He + Xe (Dalton's law) | `mode` = laws / mix; `graph` = PV, PinvV, PT, VT, Pn or Vn; `title=0`; `tour=0` |
| `kinetics` | A → products at zero, first or second order: particle view plus [A], ln[A] and 1/[A] vs time with best-fit lines, half-lives and a data table; identify tab with a mystery reaction (find the order and k with units) | `mode` = explore / identify; `order` = 0, 1 or 2; `title=0`; `tour=0` |
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
