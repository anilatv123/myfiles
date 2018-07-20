<?php
defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

class backoffice_block_edit_form extends moodleform {

    public function definition() {
        $mform = & $this->_form;
		$mform->addElement('header', 'general', get_string('form1', 'block_backoffice'));
		$mform->addElement('html', html_writer::tag('p', get_string('form2', 'block_backoffice')));
		$buttonarray=array();
		$buttonarray[] =& $mform->createElement('submit', 'yes', get_string('yes'));
		$buttonarray[] =& $mform->createElement('cancel', 'no', get_string('no'));
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		}

}
class backoffice_result_form extends moodleform {

    public function definition() {
        $rform = & $this->_form;
		$rform->addElement('header', 'general', get_string('result', 'block_backoffice'));
		 }

}