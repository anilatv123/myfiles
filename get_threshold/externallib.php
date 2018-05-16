<?php
require_once($CFG->libdir . "/externallib.php");

class threshold extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function read_threshold_parameters() {
        return new external_function_parameters(
                array('courseid' => new external_value(PARAM_INT, 'The field stores the courseid whose threshold value is required '))
        );
    }

    /**
     * Returns the record from the table threshold for the given course id
     */
    public static function read_threshold($courseid) {
        global $USER, $DB,$result,$end;
		$end=array();
		$result=array();
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::read_threshold_parameters(),
                array('courseid' => $courseid));

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_module::instance($USER->id);
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('moodle/user:viewdetails', $context)) {
            throw new moodle_exception('cannotviewprofile');
        }
	$sql= "SELECT * FROM mdl_threshold WHERE courseid = '$courseid'";
	$result=$DB->get_record_sql($sql, array($param=null), $strictness=IGNORE_MISSING);
		if($result)
			return $result;
		else
			{
			$end= "Threshold value is not maintained for this course";
			return $end;
			}
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function read_threshold_returns() {
		return new external_single_structure(
		array(
				//'id'=> new external_value(PARAM_INT,'the id of the row',VALUE_OPTIONAL),
				'courseid' => new external_value(PARAM_INT,'the courseid of the course'),
				'post_high'=>new external_value(PARAM_INT,'Maximum number of posts'),
				'post_low' =>new external_value(PARAM_INT, 'Minimum number of posts'),
				'login_high'=> new external_value(PARAM_INT, 'Maximum Login'),
				'login_low'=>new external_value(PARAM_INT, 'Minimum Login'),
				'aprov_high'=> new external_value(PARAM_INT, 'Maximum Grade'),
				'aprov_low'=> new external_value(PARAM_INT, 'Minimum Grade')));
          }
}
