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

/**
 * Tests for the chemsim shortcode filter.
 *
 * @package    filter_chemsim
 * @category   test
 * @copyright  2026 Moodle
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \filter_chemsim\text_filter
 */
final class text_filter_test extends \advanced_testcase {
    /**
     * Run the filter on some text.
     *
     * @param string $text
     * @return string
     */
    private function run_filter(string $text): string {
        $filter = new text_filter(\context_system::instance(), []);
        return $filter->filter($text);
    }

    public function test_basic_shortcode(): void {
        $out = $this->run_filter('<p>Try this: [chemsim pes mode=build el=Fe]</p>');
        $this->assertStringContainsString('<iframe', $out);
        $this->assertStringContainsString('/filter/chemsim/sims/pes.html?mode=build&amp;el=Fe', $out);
        $this->assertStringContainsString('height:1150px', $out);
        $this->assertStringContainsString('Photoelectron spectroscopy builder', $out);
        $this->assertStringNotContainsString('[chemsim', $out);
    }

    public function test_unknown_options_dropped_and_height(): void {
        $out = $this->run_filter('[chemsim equilibrium predict=1 src=http://evil.example height=700]');
        $this->assertStringContainsString('equilibrium.html?predict=1', $out);
        $this->assertStringNotContainsString('evil', $out);
        $this->assertStringContainsString('height:700px', $out);
    }

    public function test_plus_sign_is_encoded(): void {
        $out = $this->run_filter('[chemsim pes el=Fe2+]');
        $this->assertStringContainsString('el=Fe2%2B', $out);
    }

    public function test_unknown_sim_left_alone(): void {
        $text = '<p>[chemsim nosuchsim mode=x]</p>';
        $this->assertSame($text, $this->run_filter($text));
    }

    public function test_code_and_attributes_left_alone(): void {
        $text = '<p><code>[chemsim pes]</code> <a title="[chemsim pes]">x</a></p><pre>[chemsim equilibrium]</pre>';
        $this->assertSame($text, $this->run_filter($text));
    }

    public function test_nbsp_from_editor(): void {
        $out = $this->run_filter('<p>[chemsim&nbsp;pes&nbsp;mode=identify]</p>');
        $this->assertStringContainsString('pes.html?mode=identify', $out);
    }

    public function test_unicode_nbsp(): void {
        $out = $this->run_filter("<p>[chemsim\u{00A0}pes\u{00A0}mode=build]</p>");
        $this->assertStringContainsString('pes.html?mode=build', $out);
    }

    public function test_quotes_cannot_break_out(): void {
        $out = $this->run_filter('[chemsim pes el=Na"onload=alert(1)]');
        $this->assertStringNotContainsString('<iframe', $out);
    }

    public function test_full_screen_link_returns_to_page(): void {
        global $PAGE;
        $PAGE->set_url(new \moodle_url('/mod/page/view.php', ['id' => 42]));
        $out = $this->run_filter('[chemsim pes]');
        $this->assertMatchesRegularExpression('~<a [^>]*href="[^"]*pes\.html\?v=[^"]*back=[^"]*mod%2Fpage%2Fview\.php[^"]*"~', $out);
        $this->assertStringNotContainsString('target="_blank"', $out);
        // The frame itself never carries the back link.
        $this->assertMatchesRegularExpression('~<iframe[^>]*src="[^"]*pes\.html\?v=\d+"~', $out);
    }

    public function test_solubility_options(): void {
        $out = $this->run_filter('[chemsim solubility mode=mix salt=PbI2 colour=red]');
        $this->assertStringContainsString('solubility.html?mode=mix&amp;salt=PbI2', $out);
        $this->assertStringNotContainsString('colour', $out);
        $this->assertStringContainsString('Solubility box', $out);
    }

    public function test_gaslaws_and_kinetics_options(): void {
        $out = $this->run_filter('[chemsim gaslaws mode=mix graph=VT] [chemsim kinetics mode=identify order=2 k=5]');
        $this->assertStringContainsString('gaslaws.html?mode=mix&amp;graph=VT', $out);
        $this->assertStringContainsString('kinetics.html?mode=identify&amp;order=2&amp;v=', $out);
        $this->assertStringNotContainsString('k=5', $out);
    }

    public function test_text_without_shortcode_unchanged(): void {
        $text = '<p>No simulations here [chem] at all.</p>';
        $this->assertSame($text, $this->run_filter($text));
    }
}
