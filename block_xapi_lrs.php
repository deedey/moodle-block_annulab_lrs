<?php
// This file is part of Moodle - http://moodle.org/
//
// This file needs a free subscription to http://lrs.annulab.com
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
 * xapi_lrs block must be used vith Annulab LRS
 *
 * @package    block_xapi_lrs
 * @copyright  2018 Dey Bendifallah
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
class block_xapi_lrs extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_xapi_lrs');
    }

    public function get_content() {
        global $USER, $_SERVER, $DB;
        $TinCanExist = $DB->count_records_select('config_plugins','(name = "endpoint" OR name = "tincanlaunchlrsendpoint") AND value = "http://lrs.annulab.com/xapi/"');
        $this->content = new stdClass();
        if ($TinCanExist == 0)
            $this->content->text = html_writer::div('<span style="color:#FF0000;font-weight: bold;"'.
                 ' title="Exige le plugin logstore_xapi">LrsAnnulab is disabled</span>');
        else
        {
           $Tab = array();
           $Tab = explode(',',$CFG->siteadmins);
           $IsTeacher = $DB->count_records_select('role_assignments','userid = '.$USER->id.' AND (roleid = 1 OR roleid = 3)');
           $flag = ($IsTeacher > 0) ? 1 : 0;
           for ($i=0;$i< count($Tab);$i++){if ($USER->id == $Tab[$i]) $flag=2;}
           $urlBase = 'http://lrs.annulab.com/MesDatas.php';
           $LeNom = $USER->firstname." ".$USER->lastname;
           $this->content = new stdClass();
           $url = new moodle_url($urlBase, ['flag'=>$flag,'nom'=>$LeNom,'LMSorigin'=>$_SERVER['HTTP_HOST']]);
           $this->content->text = html_writer::link($url,"My own datas",array('target' => '_blank'));
       }
        $this->content->footer = '';
        return $this->content;
    }
}
?>
