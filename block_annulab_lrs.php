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

/**
 * annulab_lrs block must be used vith Annulab LRS
 *
 * @package    block_annulab_lrs
 * @copyright  2018 Dey Bendifallah
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/


defined('MOODLE_INTERNAL') || die();
class block_annulab_lrs extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'Annulab LRS Block');
    }

    public function get_content() {
        global $USER, $CFG;
  
        if ($this->content !== null) {
            return $this->content;
        }

        $endpoint = get_config('block_annulab_lrs', 'endpoint');
        if ($endpoint == "http://lrsdata.com/xapi/") {
            $tincanexist = true;
        }  
        $this->content = new stdClass();
        if (!isset($tincanexist))
        {
            $this->content->text = html_writer::div('<span style="color:#FF0000;font-weight: bold;"'.
            ' title="'.get_string('annulab_lrs_nolrsplug', 'block_annulab_lrs').'">'.
            get_string('annulablrs_isdisabled', 'block_annulab_lrs').'</span>');
        }
        else
        {
            $isteacher = get_user_capability_course('block/annulab_lrs:addinstance', null, true, '', '', 1);
            $flag = (empty($isteacher)) ? 0 : 1 ;
            $urlbase = 'http://lrsdata.com/MesDatas.php';
            $lenom = fullname($USER);
            $this->content = new stdClass();
            $url = new moodle_url($urlbase, ['flag' => $flag, 'nom' => $lenom, 'LMSorigin' => $CFG->wwwroot]);
            $this->content->text = html_writer::link($url, get_string('annulablrs', 'block_annulab_lrs'), array('target' => '_blank'));
        }
        $this->content->footer = '';
        return $this->content;
    }
}
