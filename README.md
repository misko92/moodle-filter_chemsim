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
    [chemsim titration analyte=NH3]
    [chemsim galvanic left=Cu right=Ag predict=1]
    [chemsim vaporpressure mode=heating]
    [chemsim massspec mode=identify]
    [chemsim beerslaw mode=calibrate]
    [chemsim gibbs reaction=caco3]
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
| `beerslaw` | Spectrophotometer: absorbance spectrum (KMnO₄, Blue 1 dye, CuSO₄), concentration, path length and wavelength (A = εbc, %T); calibration-curve tab with standards, best-fit line and an unknown to determine | `mode` = explore / calibrate; `solution` = KMnO4, blue1 or CuSO4; `title=0`; `tour=0` |
| `boltzmann` | Maxwell–Boltzmann: speed distribution of a colliding gas (temperature, He/N₂/CO₂/Xe, He + Xe mixture, same-speed start) and the kinetic-energy distribution with a draggable E<sub>a</sub>, catalyst and temperature comparison | `mode` = speed / energy; `gas` = He, N2, CO2, Xe or mix; `title=0`; `tour=0` |
| `equilibrium` | 2 NO₂ ⇌ N₂O₄ particle box: Le Chatelier changes, Q vs K, forward/reverse rates | `predict=1` turns on "predict first"; `title=0` hides the heading; `tour=0` stops the first-visit tour starting by itself |
| `galvanic` | Galvanic cell with 8 metals: anode/cathode, electron flow in the wire, salt-bridge ions, half-reactions, E°cell, ΔG°, K; Nernst equation with adjustable concentrations; concentration cells; the cell runs down to E = 0 when a bulb is connected; removing the salt bridge | `left`, `right` = Mg, Al, Zn, Fe, Ni, Pb, Cu or Ag; `predict=1` asks which electrode is the anode first; `title=0`; `tour=0` |
| `gaslaws` | Ideal gas in a container with a piston (locked or free) and a pressure gauge; wall hits shown; record points and graph P vs V, P vs 1/V, P vs T, V vs T (with °C extrapolation to absolute zero), P vs n, V vs n; partial-pressures tab with He + Xe (Dalton's law) | `mode` = laws / mix; `graph` = PV, PinvV, PT, VT, Pn or Vn; `title=0`; `tour=0` |
| `gibbs` | ΔG° = ΔH° − TΔS°: bars for the enthalpy and entropy terms, ΔG° vs T graph with crossover temperature, the four sign cases, K; real reactions or custom values; practice tab | `mode` = explore / practice; `reaction` = caco3, nh3, h2o2, o3, melt or custom; `title=0`; `tour=0` |
| `kinetics` | A → products at zero, first or second order: particle view plus [A], ln[A] and 1/[A] vs time with best-fit lines, half-lives and a data table; identify tab with a mystery reaction (find the order and k with units) | `mode` = explore / identify; `order` = 0, 1 or 2; `title=0`; `tour=0` |
| `massspec` | Mass spectrometer animation building the spectrum of an element (B, Ne, Mg, Si, Cl, Cu, Ga, Br, Rb, Zr, Ag) or Cl₂ molecules; average atomic mass calculation; identify-the-element tab | `mode` = explore / identify; `el` = element symbol or Cl2; `title=0`; `tour=0` |
| `pes` | Photoelectron spectroscopy: explore, how PES works, build a spectrum, identify the element (H–Ca, plus Sc, Fe, Zn, Fe²⁺) | `mode` = explore / measure / build / identify; `el` = element symbol (`Fe2+` for the ion); `compare` = element, `prev`, `next` or `none`; `tabs=0` hides the tabs; `tour=0` stops the first-visit tour from starting by itself (the ? button still shows it) |
| `solubility` | Saturated solutions and K<sub>sp</sub> (AgCl, PbI₂, Mg(OH)₂): adding solid or water, evaporating, common ion, acid; plus a "will it precipitate?" mixing tab | `mode` = sat / mix; `salt` = AgCl, PbI2 or MgOH2; `predict=1`; `title=0`; `tour=0` |
| `titration` | Titration of HCl, CH₃COOH, HCN or NH₃ with particle view, indicator colors, pH curve with half-equivalence and equivalence points (exact pH); buffers tab comparing water and a buffer as strong acid/base is added (capacity, Henderson–Hasselbalch) | `mode` = titration / buffer; `analyte` = HCl, CH3COOH, HCN or NH3; `title=0`; `tour=0` |
| `vaporpressure` | Closed container with evaporation and condensation reaching vapor pressure (ether, ethanol, water; temperature, volume); vapor-pressure curves and normal boiling points; heating-curve tab for 1 mol of water with q calculations and kinetic vs potential energy | `mode` = vapor / heating; `liquid` = ether, ethanol or water; `title=0`; `tour=0` |

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
