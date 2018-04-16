<?php
class block_backoffice extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_backoffice');
    }

    public function specialization() {
        // Previous block versions didn't have config settings.
        if ($this->config === null) {
            $this->config = new stdClass();
        }
        // Set always show_dedication config settings to avoid errors.
        if (!isset($this->config->show_dedication)) {
            $this->config->show_dedication = 0;
        }
    }

    public function get_content() {
        global $OUTPUT, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if ($this->config->show_dedication == 1) {
           // require_once('dedication_lib.php');
            $mintime = $this->page->course->startdate;
            $maxtime = time();
         //   $dm = new block_dedication_manager($this->page->course, $mintime, $maxtime, $this->config->limit);
           // $dedicationtime = $dm->get_user_dedication($USER, true);
            $this->content->text .= html_writer::tag('p', get_string('dedication_estimation', 'block_backoffice'));
          //  $this->content->text .= html_writer::tag('p', block_dedication_utils::format_dedication($dedicationtime));
        }

        if (has_capability('block/backoffice:use', context_block::instance($this->instance->id))) {
            $this->content->footer .= html_writer::tag('hr', null);
            $this->content->footer .= html_writer::tag('p', get_string('access_info', 'block_backoffice'));
            $url = new moodle_url('/blocks/backoffice/backoffice.php', array(
                'courseid' => $this->page->course->id,
                'instanceid' => $this->instance->id,
            ));
            $this->content->footer .= $OUTPUT->single_button($url, get_string('access_button', 'block_backoffice'), 'get');
        }

        return $this->content;
    }

    public function applicable_formats() {
        return array('course' => true);
    }

}
