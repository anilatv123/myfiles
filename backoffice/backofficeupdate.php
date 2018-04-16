<?php
global $CFG;
global $DB, $PAGE, $OUTPUT, $login_low,$login_high,$aprov_low,$aprov_high,$post_low,$post_high;
require_once("../../config.php");
require_once($CFG->libdir . '/formslib.php');
$courseid = required_param('courseid', PARAM_INT);
$instanceid = required_param('instanceid', PARAM_INT);
	$course = $DB->get_record("course", array("id" => $courseid), '*', MUST_EXIST);
//	require_course_login($course);
// Require capability to use this plugin in block context.
$context = context_block::instance($instanceid);
require_capability('block/backoffice:use', $context);

//require_once('backoffice_lib.php');
$action = optional_param('action', 'all', PARAM_ALPHANUM);
$id = optional_param('id', 0, PARAM_INT);
$pageurl = new moodle_url('/blocks/backoffice/backofficeupdate.php');
$pageurl->params(array(
    'courseid' => $courseid,
    'instanceid' => $instanceid,
    'action' => $action,
    'id' => $id,
));
$PAGE->set_context($context);
$PAGE->set_pagelayout('report');
$PAGE->set_pagetype('course-view-' . $course->format);
$PAGE->navbar->add(get_string('coursename', 'block_backoffice',$course->fullname), new moodle_url('/course/view.php', array('id' => $courseid)	));
$PAGE->navbar->add(get_string('pluginname', 'block_backoffice'), new moodle_url('/blocks/backoffice/backoffice.php', array('courseid' => $courseid, 'instanceid' => $instanceid)));
$PAGE->navbar->add(get_string('update', 'block_backoffice'), new moodle_url('/blocks/backoffice/backofficeupdate.php', array('courseid' => $courseid, 'instanceid' => $instanceid)));
$PAGE->set_url($pageurl);
$PAGE->set_title(get_string('pagetitle', 'block_backoffice', $course->shortname));
$PAGE->set_heading($course->fullname);
$courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
        require_once('backoffice_form.php');
		$xform = new backoffice_block_selection_form($pageurl, null, 'get');
	    echo $OUTPUT->header();
		$xform->display();		
	if ($xform->is_submitted())
		{
    	$viewdata = $xform->get_data();
		$viewdata->courseid = $courseid;
   	$uniquerecord = $DB->get_record('threshold',array("courseid"=>$courseid),'*', MUST_EXIST);
	$viewdata->id = $uniquerecord-> id;
	//$DB->delete_record('threshold', array("courseid" =>$viewdata->courseid));
	if($DB->update_record('threshold',$viewdata))
	//if($DB->execute_sql("UPDATE {threshold} SET max_attendance=$viewdata->max_attendance AND min_attendance=$viewdata->min_attendance AND
	//max_grade=$viewdata->max_grade AND min_grade= $viewdata->min_grade where courseid = $courseid "))
		{
		require_once('backoffice_edit_form.php');
		$cform = new backoffice_result_form($pageurl, null, 'get');
		//$a=$cform->get_data();
		//echo $OUTPUT->header();
		// Form.
		$cform->display();
		redirect($courseurl);
		}
	    elseif(!$DB->update_record('threshold',$viewdata)){
		print_error('Update not successful');
		}

		}
	
	
