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
 * Reset never-submitted/abandoned quiz attempts to 'inprogress'
 *
 * @package local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license http://www.ucl.ac.uk
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/local/ucl_tools/quiz_reset/quiz_attempt_reset_form.php');
require_once($CFG->dirroot . '/local/ucl_tools/quiz_reset/lib.php');

$id = optional_param('attemptid', '', PARAM_INT);

$syscontext = context_system::instance();

$PAGE->set_context($syscontext);
$PAGE->set_url('/local/ucl_tools/quiz_reset/index.php');

require_login();
require_capability('moodle/site:config', $syscontext);

$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname','local_ucl_tools'));
$PAGE->set_heading('UCL Tools - Quiz attempt reset');

if()
// initiate form
$quiz_reset_form = new quiz_attempt_reset_form();

$content = '';

echo $OUTPUT->header();

// display form for user to enter course shortname
$content .= $quiz_reset_form->display();
if ($formdata = $quiz_reset_form->get_data()) {
    $content .= 'formadata';
    $shortname = $formdata->courseshortname;
    $quizzes = local_ucl_tools_quizresetgetquizzes($shortname);
    foreach($quizzes as $quiz) {

        // display quiz names found within course
        $content .= html_writer::start_tag('h3', array('class'=>'title'));
        $content .= $quiz->name;
        $content .= html_writer::end_tag('h3');

        // get all abandoned quiz attempts for a quiz
        $quiz_attempts = $DB->get_records('quiz_attempts', array('quiz' => $quiz->id, 'state' => 'abandoned'));

        // display html table, listing abandoned quiz attempts
        $quizattempts_table = local_ucl_tools_printquizattemptstable($quiz_attempts, $quiz);
        $content .= html_writer::table($quizattempts_table);

    }
}
echo $content;
echo $OUTPUT->footer();


