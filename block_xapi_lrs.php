<?php
defined('MOODLE_INTERNAL') || die();
class block_xapi_lrs extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_xapi_lrs');
    }

    public function get_content() {
        global $USER, $_SERVER, $DB;
        $TinCanExist = $DB->count_records_select('config_plugins','name = "tincanlaunchlrsendpoint" AND value = "http://lrs.annulab.com/xapi/"');
        $this->content = new stdClass();
        if ($TinCanExist == 0)
            $this->content->text = html_writer::div('<span style="color:#FF0000;font-weight: bold;"'.
                 ' title="Exige les plugins xAPI, logstore_xapi et TincanLauch">LrsAnnulab non actif</span>');
        else
        {
           $flag = ((strstr($USER->institution, '-20') || $USER->phone1 == '') && $USER->address == '') ? 0 : 1;
           $urlBase = 'http://lrs.annulab.com/MesDatas.php';
           $LeNom = $USER->firstname." ".$USER->lastname;
           $this->content = new stdClass();
           $url = new moodle_url($urlBase, ['flag'=>$flag,'nom'=>$LeNom,'LMSorigin'=>$_SERVER['HTTP_HOST']]);
           $this->content->text = html_writer::link($url,"Mon historique personnel",array('target' => '_blank'));
        }
        $this->content->footer = '';
        return $this->content;
    }
}
?>
