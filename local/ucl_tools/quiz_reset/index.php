<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Reset Never submitted/abandoned quiz attempts to 'inprogress'
 *
 * @package     local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license     http://www.ucl.ac.uk
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/local/ucl_tools/quiz_reset/quiz_attempt_reset_form.php');
require_once($CFG->dirroot . '/local/ucl_tools/quiz_reset/lib.php');

// We need quiz attempt id and course id to set and display quiz attempt state.
$attemptid = optional_param('attempt', '', PARAM_INT);
$courseid = optional_param('course', '', PARAM_INT);

$syscontext = context_system::instance();

$PAGE->set_context($syscontext);
$PAGE->set_url('/local/ucl_tools/quiz_reset/index.php');

require_login();
require_capability('moodle/site:config', $syscontext);

$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_ucl_tools'));
$PAGE->set_heading('UCL Tools - Quiz attempt reset');


// Initiate form.
$quizresetform = new quiz_attempt_reset_form();

$content = '';

echo $OUTPUT->header();

// Update quiz from 'abandoned' state to 'progress' state.
if (isset($attemptid)) {
    local_ucl_tools_updatequizattempt($attemptid);
}

// Display form to enter course shortname.
echo $OUTPUT->box_start('generalbox boxaligncenter boxwidthwide');
$content .= $quizresetform->display();
echo $OUTPUT->box_end();

// Process form data.
if ($formdata = $quizresetform->get_data()) {
    $shortname = $formdata->courseshortname;
    $course = $DB->get_record('course', array('shortname' => $shortname));

    // Get quiz attempt data to display.
    $content .= local_ucl_tools_getquizattempts($course->id);

} else {
    if (isset($courseid)) {
        // Get quiz attempt data to display.
        $content .= local_ucl_tools_getquizattempts($courseid);
    }
}

// Display content.
echo $content;
echo $OUTPUT->footer();


