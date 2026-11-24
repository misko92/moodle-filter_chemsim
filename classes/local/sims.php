<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace filter_chemsim\local;

/**
 * Registry of the simulations shipped in the sims/ folder.
 *
 * Only simulations and URL options listed here can be embedded, so a
 * shortcode can never point the frame anywhere else.
 *
 * @package    filter_chemsim
 * @copyright  2026 Moodle
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class sims {
    /** @var array name => [file, starting height in px, allowed options] */
    private const SIMS = [
        'lewis' => ['file' => 'lewis.html', 'height' => 950, 'options' => ['mode', 'species', 'title', 'tour']],
        'massspec' => ['file' => 'massspec.html', 'height' => 900, 'options' => ['mode', 'el', 'title', 'tour']],
        'pes' => ['file' => 'pes.html', 'height' => 1150, 'options' => ['mode', 'el', 'compare', 'tabs', 'tour']],
        'boltzmann' => ['file' => 'boltzmann.html', 'height' => 900, 'options' => ['mode', 'gas', 'title', 'tour']],
        'beerslaw' => ['file' => 'beerslaw.html', 'height' => 950, 'options' => ['mode', 'solution', 'title', 'tour']],
        'equilibrium' => ['file' => 'equilibrium.html', 'height' => 1000, 'options' => ['predict', 'title', 'tour']],
        'galvanic' => ['file' => 'galvanic.html', 'height' => 900, 'options' => ['left', 'right', 'predict', 'title', 'tour']],
        'gaslaws' => ['file' => 'gaslaws.html', 'height' => 1000, 'options' => ['mode', 'graph', 'title', 'tour']],
        'gibbs' => ['file' => 'gibbs.html', 'height' => 900, 'options' => ['mode', 'reaction', 'title', 'tour']],
        'kinetics' => ['file' => 'kinetics.html', 'height' => 1000, 'options' => ['mode', 'order', 'title', 'tour']],
        'solubility' => ['file' => 'solubility.html', 'height' => 1050, 'options' => ['mode', 'salt', 'predict', 'title', 'tour']],
        'spectra' => ['file' => 'spectra.html', 'height' => 900, 'options' => ['mode', 'el', 'title', 'tour']],
        'titration' => ['file' => 'titration.html', 'height' => 1000, 'options' => ['mode', 'analyte', 'title', 'tour']],
        'vaporpressure' => ['file' => 'vaporpressure.html', 'height' => 1000, 'options' => ['mode', 'liquid', 'title', 'tour']],
    ];

    /**
     * Look up a simulation.
     *
     * @param string $name shortcode name, e.g. "pes"
     * @return array|null [file, height, options] or null if unknown
     */
    public static function get(string $name): ?array {
        return self::SIMS[strtolower($name)] ?? null;
    }

    /**
     * All simulation names.
     *
     * @return string[]
     */
    public static function names(): array {
        return array_keys(self::SIMS);
    }
}
