<?php
global $DB, $PAGE, $OUTPUT, $login_low,$login_high,$aprov_low,$aprov_high,$post_low,$post_high,$login_importance,$post_importance,$assid_high, $assid_low,$startCourseDate,$tempdate,$defaultdate;
//$startCourseDate=date('d/m/y');
//$newdate= new array;
global $date,$dateObject, $timestamp,$resultnew;
$errors=array();
require_once("../../config.php");
// Input params.
$courseid = required_param('courseid', PARAM_INT);
$instanceid = required_param('instanceid', PARAM_INT);

// Require course login.
$course = $DB->get_record("course", array("id" => $courseid), '*', MUST_EXIST);
require_course_login($course);

// Require capability to use this plugin in block context.
$context = context_block::instance($instanceid);
require_capability('block/backoffice:use', $context);

$action = optional_param('action', 'all', PARAM_ALPHANUM);
$id = optional_param('id', 0, PARAM_INT);

// Current url.
$pageurl = new moodle_url('/blocks/backoffice/backoffice.php');
$pageurl->params(array(
    'courseid' => $courseid,
    'instanceid' => $instanceid,
    'action' => $action,
    'id' => $id,
));
$courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
// Page format.
$PAGE->set_context($context);
$PAGE->set_pagelayout('report');
$PAGE->set_pagetype('course-view-' . $course->format);
$PAGE->navbar->add(get_string('pluginname', 'block_backoffice'), new moodle_url('/blocks/backoffice/backoffice.php', array('courseid' => $courseid, 'instanceid' => $instanceid)));
$PAGE->set_url($pageurl);
$PAGE->set_title(get_string('pagetitle', 'block_backoffice', $course->shortname));
$PAGE->set_heading($course->fullname);

//Checking whether the threshold value is already stored for the course
$result=$DB->get_record('threshold',array("courseid"=>$courseid));
//If the threshold is not stored, the form to read is displayed to the teacher
if($result==Null){
// Load libraries.
require_once('backoffice_form.php');
echo $OUTPUT->header();
// Display the form to read the threshold value
$mform = new backoffice_block_selection_form($pageurl, null, 'get');
//$startCourseDate = make_timestamp($year, $month, $day);
//$mform->setDefault('startCourseDate', $startCourseDate);
//$mform->setDefault('startCourseDate',$defaultdate);
$mform->display();
	if ($mform->is_submitted()) {
	   	$formdata = $mform->get_data();	
		//echo $formdata->startCourseDate;
		//$dateObject = DateTime::createFromFormat('d-m-Y H:i:s', $formdata->startCourseDate);
		//$timestamp = $dateObject->getTimestamp();
		/*$tempdate=date('d/m/y');
		//$temp=date_parse($tempdate);
		//$year=$temp[year]; $month= $temp[month]; $day=$temp[day];
		$year=2018; $month=06; $day= 28;
		$defaultdate= make_timestamp($year,$month,$day);*/
		//$timestamp=strtotime($date);
		//$startCourseDate=$defaultdate;
		//date_parse($startCourseDate);
		//$tempdate=strtotime($startCourseDate);
		//$defaultdate = make_timestamp($year, $month, $day);
		//$mform->setDefault('startCourseDate',  $defaultdate);
		//$startCourseDate=$tempdate;*/
		$formdata->courseid = $courseid;
		/*if ($errors['login_importance'])
		{
			print_error('Data not stored in the table');
		}*/
			//If the record is inserted successfully , Display data saved
		if($DB->insert_record('threshold',$formdata) )
			{
			require_once('backoffice_form.php');
			$rform = new backoffice_block_result_form($pageurl, null, 'get');
			// Form.
			$rform->display();
			}
			//If data not stored in the table display error
			elseif(!$DB->insert_record('threshold',$formdata)){
			print_error('Data not stored in the table');
			}
	}
$pageurl->params(array(
	'startCoursedate' => $startCourseDate,
	'post_high' => $post_high,
	'post_low' => $post_low,
	'login_high' => $login_high,
   'login_low' => $login_low,
	'login_importance'=> $login_importance,
	'post_importance'=> $post_importance,
    'assid_low' => $assid_low,
	'assid_high' => $assid_high,
	'aprov_low' => $aprov_low,
	'aprov_high' => $aprov_high,

));

}
else{
	//Threshold Value is already stored for this course. Would  you like to update the threshold value";
require_once('backoffice_edit_form.php');
$sform = new backoffice_block_edit_form($pageurl, null, 'get');
	echo $OUTPUT->header();

	// Form 
$sform->display();
	$ef = $sform->get_data();
//Checking whether the teacher wanted to update the data	
	if($sform->is_cancelled())
	{	
    redirect($courseurl);
	}
	elseif ($sform->is_submitted())
	{
	$updateurl = new moodle_url('/blocks/backoffice/backofficeupdate.php');
		$updateurl->params(array(
		'courseid' => $courseid,
		'instanceid' => $instanceid,
		'action' => $action,
		'id' => $id,
		));
   redirect($updateurl);
	echo $OUTPUT->box_start();

foreach ($view->header as $header) {
    echo $OUTPUT->heading($header, 4);
     }
	}

}
