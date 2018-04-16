<?php
global $DB, $PAGE, $OUTPUT, $login_low,$login_high,$aprov_low,$aprov_high,$post_low,$post_high;
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

//require_once('backoffice_lib.php');
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
if($result==Null){

// Load libraries.
require_once('backoffice_form.php');
echo $OUTPUT->header();
// Load calculate params from form, request or set default values.
$mform = new backoffice_block_selection_form($pageurl, null, 'get');
$mform->display();
if ($mform->is_submitted()) {
	
	
    // Params from form post.
    //if($formdata = $mform->get_data()){
		$formdata = $mform->get_data();	
		$formdata->courseid = $courseid;
   /* $login_low = $formdata->login_low;
	$login_high= $formdata->login_high;
    $aprov_low = $formdata->aprov_low;
	$aprov_high = $formdata->aprov_high;*/
	
	//$lastinsert =  $DB->insert_record('threshold',$formdata);
	IF($DB->insert_record('threshold',$formdata) )
	{
		require_once('backoffice_form.php');
		$rform = new backoffice_block_result_form($pageurl, null, 'get');
		//$a=$rform->get_data();
		//echo $OUTPUT->header();
		// Form.
		$rform->display();
		}
    else{
		print_error('Data not stored in the table');
	}
}
$pageurl->params(array(
   'login_low' => $login_low,
	'login_high' => $login_high,
    'aprov_low' => $aprov_low,
	'aprov_high' => $aprov_high,
	'post_low' => $post_low,
	'post_high' => $post_high,

));



// Form.
//$mform->display();

//$rform->display();
//echo $OUTPUT->box_start();

//foreach ($view->header as $header) {
  //  echo $OUTPUT->heading($header, 4);
//}
//echo $OUTPUT->header();
}
else{
	//echo"Threshold Value is already stored for this course. Would  you like to update the threshold value";
require_once('backoffice_edit_form.php');
$sform = new backoffice_block_edit_form($pageurl, null, 'get');
	echo $OUTPUT->header();

	// Form.
$sform->display();
	$ef = $sform->get_data();	
	//if($ef == "yes")
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
  	
//echo $OUTPUT->box_start();


//$view2 = new stdClass();
//$view2->header = array();

//$view2->table = new html_table();
//echo $OUTPUT->header();

// Form.
//$sform->display();

echo $OUTPUT->box_start();

foreach ($view->header as $header) {
    echo $OUTPUT->heading($header, 4);
}
	}

	}
