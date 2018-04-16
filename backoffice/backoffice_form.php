<?php
defined('MOODLE_INTERNAL') || die();

global $CFG, $login_low,$login_high,$aprov_low, $aprov_high,$attendance;
/*settype($min_attendance,"integer");
settype($max_attendance,"integer");
settype($min_grade,"integer");
settype($max_grade,"integer");*/
require_once($CFG->libdir . '/formslib.php');

// Form to select start and end date ranges and session time.
class backoffice_block_selection_form extends moodleform {

    public function definition() {
        $mform = & $this->_form;

         $mform->addElement('header', 'general', get_string('form', 'block_backoffice'));
        $mform->addElement('html', html_writer::tag('p', get_string('form_text', 'block_backoffice')));
		
        $mform->addElement('text', 'post_high', get_string('post_high', 'block_backoffice'));
		$mform->addElement('text', 'post_low', get_string('post_low', 'block_backoffice'));
		
        $mform->addElement('text', 'login_high', get_string('login_high', 'block_backoffice')); 
		$mform->addElement('text', 'login_low', get_string('login_low', 'block_backoffice'));
	    
        $mform->addElement('text', 'aprov_high', get_string('aprov_high', 'block_backoffice'));
		$mform->addElement('text', 'aprov_low', get_string('aprov_low', 'block_backoffice'));
        $this->add_action_buttons(false, get_string('submit', 'block_backoffice'));
    }

}
class backoffice_block_result_form extends moodleform {

    public function definition() {
        $aform = & $this->_form;

         $aform->addElement('header', 'general', get_string('heading', 'block_backoffice'));
       
    }

}
