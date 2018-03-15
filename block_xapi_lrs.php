<?php
defined('MOODLE_INTERNAL') || die();
class block_xapi_lrs extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_xapi_lrs');
    }

    public function get_content() {
        global $USER, $_SERVER, $DB;
        $TinCanExist = $DB->count_records_select('config_plugins','name = "endpoint" AND value = "http://lrs.annulab.com/xapi/"');
        $this->content = new stdClass();
        if ($TinCanExist == 0)
            $this->content->text = html_writer::div('<span style="color:#FF0000;font-weight: bold;"'.
                 ' title="Exige le plugins logstore_xapi">LrsAnnulab non actif</span>');
        else
        {
           $Tab = array();
           $Tab = explode(',',$CFG->siteadmins);
           $IsTeacher = $DB->count_records_select('role_assignments','userid = '.$USER->id.' AND (roleid = 1 OR roleid = 3)');
           $flag = ($IsTeacher > 0) ? 1 : 0;
           for ($i=0;$i< count($Tab);$i++){if ($USER->id == $Tab[$i]) $flag=2;}
           $urlBase = 'http://formagri.educagri.fr/xapilrs/MesDatas.php';
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
