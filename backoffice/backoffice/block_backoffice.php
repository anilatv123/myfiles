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
        // Set always show_threshold config settings to avoid errors.
        if (!isset($this->config->show_threshold)) {
            $this->config->show_threshold = 0;
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
