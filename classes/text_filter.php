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

namespace filter_chemsim;

use filter_chemsim\local\sims;

/**
 * Turns [chemsim name option=value ...] shortcodes into embedded simulations.
 *
 * Example: [chemsim pes mode=build el=Fe] or [chemsim equilibrium predict=1].
 * The simulations are self-contained HTML files in this plugin's sims/ folder.
 * Shortcodes inside tags, <pre> or <code> are left alone, as are unknown
 * simulation names (so a typo stays visible to the teacher).
 *
 * @package    filter_chemsim
 * @copyright  2026 Moodle
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class text_filter extends \core_filters\text_filter {
    /** @var string Shortcode pattern: name, then optional key=value pairs. */
    private const PATTERN = '/\[chemsim\s+([a-z][a-z0-9_]*)((?:(?:\s|&nbsp;)+[a-z][a-z0-9_]*=[^\s\]&<"\']+)*)(?:\s|&nbsp;)*\]/i';

    #[\Override]
    public function filter($text, array $options = []) {
        if (!is_string($text) || stripos($text, '[chemsim') === false) {
            return $text;
        }
        $parts = preg_split('/(<[^>]*>)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $skip = 0;
        foreach ($parts as $i => $part) {
            if ($part === '') {
                continue;
            }
            if ($part[0] === '<') {
                if (preg_match('~^<(/?)(pre|code)\b~i', $part, $m)) {
                    $skip = max(0, $skip + ($m[1] === '/' ? -1 : 1));
                }
                continue;
            }
            if (!$skip && stripos($part, '[chemsim') !== false) {
                $parts[$i] = preg_replace_callback(self::PATTERN, [$this, 'render'], $part);
            }
        }
        return implode('', $parts);
    }

    /**
     * Render one shortcode match.
     *
     * @param array $m regex match
     * @return string HTML
     */
    private function render(array $m): string {
        $sim = sims::get($m[1]);
        if (!$sim) {
            return $m[0];
        }
        $params = [];
        $height = $sim['height'];
        preg_match_all('/([a-z][a-z0-9_]*)=([^\s\]&<"\']+)/i', $m[2], $pairs, PREG_SET_ORDER);
        foreach ($pairs as [, $key, $value]) {
            $key = strtolower($key);
            if ($key === 'height' && ctype_digit($value)) {
                $height = max(200, min(4000, (int) $value));
            } else if (in_array($key, $sim['options'], true)) {
                $params[$key] = $value;
            }
        }
        $params['v'] = get_config('filter_chemsim', 'version');
        $url = new \moodle_url('/filter/chemsim/sims/' . $sim['file'], $params);
        $title = get_string('sim_' . strtolower($m[1]), 'filter_chemsim');

        $html = \html_writer::tag('iframe', '', [
            'class' => 'filter-chemsim-frame',
            'src' => $url->out(false),
            'title' => $title,
            'loading' => 'lazy',
            'allow' => 'fullscreen',
            'style' => "width:100%;height:{$height}px;border:0;display:block",
        ]);
        $link = \html_writer::link($url, get_string('openfull', 'filter_chemsim'),
            ['target' => '_blank', 'class' => 'filter-chemsim-open small']);
        return \html_writer::div($html . $link, 'filter-chemsim') . $this->resize_script();
    }

    /**
     * A small script that sizes each frame to the height its
     * simulation reports with postMessage (works wherever filtered text is shown,
     * including quiz questions and content loaded later). It is added after every
     * shortcode, because filtered text is cached piece by piece; the window flag makes
     * sure only one listener is installed.
     *
     * @return string
     */
    private function resize_script(): string {
        return '<script>(function(){if(window.filterChemsimResize)return;window.filterChemsimResize=1;' .
            'window.addEventListener("message",function(e){var d=e.data;if(!d||d.chemsim!=="height")return;' .
            'document.querySelectorAll("iframe.filter-chemsim-frame").forEach(function(f){' .
            'if(f.contentWindow===e.source){var h=Math.max(200,Math.min(4000,Math.ceil(+d.h||0)+4));' .
            'f.style.height=h+"px";}});});})();</script>';
    }
}
