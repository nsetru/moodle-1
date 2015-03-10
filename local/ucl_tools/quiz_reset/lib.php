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
 *
 * Library functions to process quiz data and update tables to set quiz attempt state to 'inprogress'
 *
 * @package     local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license     http://www.ucl.ac.uk
 */

function local_ucl_tools_getquizattempts($courseid) {
    global $DB;

    $content = '';

    $quizzes = $DB->get_records('quiz', array('course' => $courseid));

    foreach ($quizzes as $quiz) {

        // Display quiz names found within course.
        $content .= '<hr>';
        $content .= html_writer::start_tag('h3', array('class' => 'title'));
        $content .= $quiz->name;
        $content .= html_writer::end_tag('h3');

        // Get all abandoned quiz attempts for a quiz.
        $quizattempts = $DB->get_records('quiz_attempts', array('quiz' => $quiz->id, 'state' => 'abandoned'));

        if (!empty($quizattempts)) {
            // Table lists abandoned quiz attempts.
            $quizattemptstable = local_ucl_tools_printquizattemptstable($quizattempts, $quiz);
            $content .= html_writer::table($quizattemptstable);
        } else {
            $content .= html_writer::start_tag('h5', array('class' => 'title'));
            $content .= 'No quiz attempts in Never submitted state';
            $content .= html_writer::end_tag('h5');
        }
    }

    return $content;
}

function local_ucl_tools_printquizattemptstable($quizattempts, $quiz) {
    global $CFG, $DB, $OUTPUT;

    // Display table with list of quiz attempts stuck in 'abandoned' state.
    $table = new html_table();
    $table->width = "100%";
    $table->head = array('Quiz', 'First name/Surname', 'Email address', 'Quiz State', 'Update');
    $table->align = array('center', 'center', 'center', 'center', 'center');

    $namefields = get_all_user_name_fields(true);
    $stredit = get_string('updatequiz', 'local_ucl_tools');
    $strview = get_string('viewprofile', 'local_ucl_tools');

    foreach ($quizattempts as $quizattempt) {
        $user = $DB->get_record('user', array('id' => $quizattempt->userid), 'id, ' . $namefields . ', username, email');
        $user->fullname = fullname($user, true);

        // Build link to update quiz attempt state.
        $updatelinkparams = array('attempt' => $quizattempt->id, 'course' => $quiz->course);
        $updatelink = new moodle_url($CFG->wwwroot . '/local/ucl_tools/quiz_reset/index.php', $updatelinkparams);
        // Image to be displayed in the table cell.
        $imgsrc = html_writer::empty_tag('img', array('src' => $OUTPUT->pix_url('t/edit'), 'alt' => $stredit, 'class' => 'iconsmall'));
        $updatebutton = html_writer::link($updatelink, $imgsrc, array('title' => $stredit));

        // Build link to view user profile.
        $viewlinkparams = array('id' => $user->id, 'course' => 1);
        $viewlink = new moodle_url($CFG->wwwroot . '/user/view.php', $viewlinkparams);
        $viewlinkimg = html_writer::empty_tag('img', array('src' => $OUTPUT->pix_url('t/hide'), 'alt' => $strview, 'class' => 'iconsmall'));
        $viewprofilebutton = html_writer::link($viewlink, $viewlinkimg, array('title' => $strview));

        $table->data[] = array(
            $quiz->name,
            $user->fullname. $viewprofilebutton,
            $user->email,
            get_string('stateabandoned', 'local_ucl_tools'),
            $updatebutton
        );
    }
    return $table;
    //html_writer::link(new moodle_url($returnurl, array('unsuspend'=>$user->id, 'sesskey'=>sesskey())), html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/show'), 'alt'=>$strunsuspend, 'class'=>'iconsmall')), array('title'=>$strunsuspend));
}

function local_ucl_tools_updatequizattempt($attemptid) {
    global $DB;

    $recordexists = $DB->get_record('quiz_attempts', array('id' => $attemptid));

    // Set abandoned quiz attempt to 'inprogress'.
    if ($recordexists) {
        $updaterecord = new stdClass();
        $updaterecord->id = $attemptid;
        $updaterecord->state = 'inprogress';
        $DB->update_record('quiz_attempts', $updaterecord);
    }

}