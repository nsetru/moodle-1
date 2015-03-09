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
 * library functions to process quiz data and update tables to set quiz attempt state to 'inprogress'
 *
 * @package local_ucl_tools
 * @subpackage  ucl_tools
 * @copyright   2014, Nivedita Setru <n.setru@ucl.ac.uk>
 * @license http://www.ucl.ac.uk
 */

function local_ucl_tools_getquizattempts($courseid) {
    global $DB;

    $content = '';

    $quizzes = $DB->get_records('quiz', array('course' => $courseid));

    foreach($quizzes as $quiz) {

        // display quiz names found within course
        $content .= html_writer::start_tag('h3', array('class'=>'title'));
        $content .= $quiz->name;
        $content .= html_writer::end_tag('h3');

        // get all abandoned quiz attempts for a quiz
        $quiz_attempts = $DB->get_records('quiz_attempts', array('quiz' => $quiz->id, 'state' => 'abandoned'));

        if(!empty($quiz_attempts)) {
            // table lists abandoned quiz attempts
            $quizattempts_table = local_ucl_tools_printquizattemptstable($quiz_attempts, $quiz);
            $content .= html_writer::table($quizattempts_table);
        } else {
            $content .= html_writer::start_tag('h5', array('class'=>'title'));
            $content .= 'No quiz attempts in Never submitted state';
            $content .= html_writer::end_tag('h5');
        }


    }

    return $content;
}

function local_ucl_tools_printquizattemptstable($quizattempts, $quiz){
    global $CFG, $DB, $OUTPUT;

    // display table with list of quiz attempts stuck in 'abandoned' state
    $table = new html_table();
    $table->width = "100%";
    $table->head = array('Quiz', 'First name/Surname', 'Email address', 'Quiz State', 'Update');
    $table->align = array('center', 'center', 'center', 'center', 'center');

    $namefields = get_all_user_name_fields(true);
    $stredit   = get_string('updatequiz', 'local_ucl_tools');
    foreach($quizattempts as $quizattempt) {
        $user = $DB->get_record('user', array('id' => $quizattempt->userid), 'id, ' . $namefields . ', username, email');
        $user->fullname = fullname($user, true);
        $updatelink = html_writer::link(new moodle_url($CFG->wwwroot.'/local/ucl_tools/quiz_reset/index.php', array('attempt'=>$quizattempt->id, 'course'=>$quiz->course)), html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/edit'), 'alt'=>$stredit, 'class'=>'iconsmall')), array('title'=>$stredit));
        $table->data[] = array (
            $quiz->name,
            $user->fullname,
            $user->email,
            get_string('stateabandoned', 'local_ucl_tools'),
            $updatelink
        );
    }
    return $table;
}

function local_ucl_tools_updatequizattempt($attemptid) {
    global $DB;

    $record_exists = $DB->get_record('quiz_attempts', array('id' => $attemptid));

    // set abandoned quiz attempt to 'inprogress'
    if($record_exists) {
        $update_record = new stdClass();
        $update_record->id = $attemptid;
        $update_record->state = 'inprogress';
        $DB->update_record('quiz_attempts', $update_record);
    }

}