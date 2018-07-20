<?php
defined('MOODLE_INTERNAL') || die();

global $CFG, $login_low,$login_high,$aprov_low, $aprov_high,$attendance,$j,$i,$k,$login_importance,$post_importance,$arg,$value,$element;
require_once($CFG->libdir . '/formslib.php');

class backoffice_block_selection_form extends moodleform {

    public function definition() {
        $mform = & $this->_form;

         $mform->addElement('header', 'general', get_string('form', 'block_backoffice'));
        $mform->addElement('html', html_writer::tag('p', get_string('form_text', 'block_backoffice')));
		$mform->addElement('date_selector', 'startCourseDate', get_string('startCourseDate', 'block_backoffice'));
		/*$year=2018; $month=06; $day= 28;
		$defaultdate= make_timestamp($year,$month,$day);
		//$startCourseDate= gmmktime($defaultdate);
		//$startCourseDate=$defaultdate;
		//date_parse($startCourseDate);
		//$tempdate=strtotime($startCourseDate);
		//$defaultdate = make_timestamp($year, $month, $day);
		$mform->setDefault('startCourseDate',  $defaultdate);*/
		$postoptions=array();
		for($k=0; $k<=2;$k++){
			$postoptions[$k]=$k;
		}
        $mform->addElement('select', 'post_high', get_string('post_high', 'block_backoffice'),$postoptions);
		$mform->addHelpButton('post_high', 'post_high', 'block_backoffice');
		$mform->addElement('select', 'post_low', get_string('post_low', 'block_backoffice'),$postoptions);
		$mform->addHelpButton('post_low', 'post_low', 'block_backoffice');
		
		$limitoptions = array();
        for ($i = 1; $i <= 10; $i++) {
            $limitoptions[$i] = $i;
        }
        $mform->addElement('select', 'login_high', get_string('login_high', 'block_backoffice'),$limitoptions);
		$mform->addHelpButton('login_high', 'login_high', 'block_backoffice');
		$mform->addElement('select', 'login_low', get_string('login_low', 'block_backoffice'),$limitoptions);
		$mform->addHelpButton('login_low', 'login_low', 'block_backoffice');
	    
		$mform->addElement('text', 'login_importance', get_string('login_importance', 'block_backoffice'));
		$mform->addHelpButton('login_importance', 'login_importance', 'block_backoffice');
		$mform->addElement('text', 'post_importance', get_string('post_importance', 'block_backoffice'));
		/*$mform->registerRule('compare','function','callback','compare_field');
		
		function compare_field($element,$value,$arg){
			global $form;
			$value=$form->getElementValue($login_importance)+$form->getElementValue($post_importance);
			if($value==100)
				return true;
			else
				return false;
		}
		$mform->addRule('post_importance',null,'required',null,'client');*/
		
		$attnoptions=array();
		for($j=1;$j<=100;$j++){
			$attnoptions[$j]=$j;
		}
		$mform->addElement('select', 'assid_high', get_string('assid_high', 'block_backoffice'),$attnoptions);
		$mform->addElement('select', 'assid_low', get_string('assid_low', 'block_backoffice'),$attnoptions);

        $mform->addElement('select', 'aprov_high', get_string('aprov_high', 'block_backoffice'),$attnoptions);
		$mform->addElement('select', 'aprov_low', get_string('aprov_low', 'block_backoffice'),$attnoptions);
        $this->add_action_buttons(false, get_string('submit', 'block_backoffice'));
    }
	
	public function validation($data){
	$errors= array();
	global $login_importance, $post_importance,$arg1;
	$arg1=$data['login_importance']+$data['post_importance'];
	if($arg1!=100){
	$errors['login_importance'] = get_string('err_login_importance', 'block_backoffice');
	//print_error('The sum of Importance of Login and Importance of Post must be 100');
	//$errors['login_importance']="The Sum of Login_importance and Post_importance must be 100.";
	print_error($errors['login_importance']);
	}
	//return ($errors['login_importance'] = get_string('err_login_importance', 'block_backoffice'));
	return $errors;
	}
	
/*	public function setDefault($startCourseDate,$defaultdate)
	{
		global $month,$day,$year,$temp;
		$temp=array();
		$tempdate=date('d/m/y');
		$temp=date_parse($tempdate);
		$year=$temp[year]; $month= $temp[month]; $day=$temp[day];
		$defaultdate= make_timestamp($year,$month,$day);
		//$startCourseDate= gmmktime($defaultdate);
		//$startCourseDate=$defaultdate;
		return $defaultdate;
	}*/
}
class backoffice_block_result_form extends moodleform {

    public function definition() {
        $aform = & $this->_form;
        $aform->addElement('header', 'general', get_string('heading', 'block_backoffice'));
     }

}
